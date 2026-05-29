<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Payment;
use App\Models\AccessLog;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $totalRevenue = Payment::where('status', 'approved')->sum('amount');
        $activeMembersCount = Subscription::where('status', 'active')
            ->where('expires_at', '>=', Carbon::now()->toDateString())
            ->count();
        $totalMembersCount = User::where('role', 'member')->count();
        $recentPayments = Payment::with(['user', 'subscription.plan'])->orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.index', compact('totalRevenue', 'activeMembersCount', 'totalMembersCount', 'recentPayments'));
    }

    /**
     * Lista los miembros aplicando filtros e inyectando llaves de relación para Alpine.js.
     */
    public function members(Request $request)
    {
        $search = $request->input('search');
        $statusFilter = $request->input('status', 'Todos');

        $membersQuery = User::where('role', 'member')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            });

        $allMembers = $membersQuery->orderBy('created_at', 'desc')->get();

        foreach ($allMembers as $member) {
            $activeSub = $member->subscriptions()
                ->where('status', 'active')
                ->where('expires_at', '>=', now()->toDateString())
                ->with('plan')
                ->first();

            $latestPayment = $member->payments()->latest()->first();

            // Inyecciones dinámicas de integridad para que lea el Modal
            $member->is_active = !is_null($activeSub);
            $member->plan_name = $activeSub ? $activeSub->plan->name : 'Ninguno';
            $member->active_plan_id = $activeSub ? $activeSub->plan_id : ($member->subscriptions()->latest()->first()?->plan_id ?? null);
            $member->payment_method_current = $latestPayment ? ($latestPayment->payment_method === 'pos' ? 'tarjeta' : 'efectivo') : 'efectivo';
            $member->expiration_date = $activeSub ? Carbon::parse($activeSub->expires_at)->format('d/m/Y') : 'N/A';
            $member->join_date = $member->created_at->format('M Y');
        }

        if ($statusFilter === 'Activo') {
            $members = $allMembers->where('is_active', true);
        } elseif ($statusFilter === 'Vencido') {
            $members = $allMembers->where('is_active', false);
        } else {
            $members = $allMembers;
        }

        $plans = Plan::all();

        return view('admin.members', compact('members', 'search', 'statusFilter', 'plans'));
    }

    /**
     * Actualiza la información personal, el plan de entrenamiento y el método de pago del miembro.
     */
    public function updateMember(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'plan_id' => 'required|exists:plans,id',
            'payment_method' => 'required|string',
        ]);

        // 1. Sincronizar información de perfil básica
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        $plan = Plan::find($request->plan_id);

        // 2. Sincronizar o re-calcular la Suscripción asignada
        $subscription = $user->subscriptions()->latest()->first();

        if ($subscription) {
            $subscription->update([
                'plan_id' => $plan->id,
                'starts_at' => now()->toDateString(),
                'expires_at' => now()->addDays($plan->duration_days)->toDateString(),
                'status' => 'active',
            ]);
        } else {
            $subscription = Subscription::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'starts_at' => now()->toDateString(),
                'expires_at' => now()->addDays($plan->duration_days)->toDateString(),
                'status' => 'active',
            ]);
        }

        // Traducir el método al ENUM exacto de MariaDB
        $dbPaymentMethod = $request->payment_method === 'tarjeta' ? 'pos' : 'cash';
        
        // 3. Ajustar o asentar la caja contable de este ciclo
        $payment = Payment::where('subscription_id', $subscription->id)->latest()->first();
        
        if ($payment) {
            $payment->update([
                'amount' => $plan->price,
                'payment_method' => $dbPaymentMethod,
                'wompi_transaction_id' => $request->payment_method === 'tarjeta' ? ($request->pos_reference ?? 'POS-MANUAL') : 'CAJA_EFECTIVO',
            ]);
        } else {
            Payment::create([
                'user_id' => $user->id,
                'subscription_id' => $subscription->id,
                'amount' => $plan->price,
                'payment_method' => $dbPaymentMethod,
                'wompi_transaction_id' => $request->payment_method === 'tarjeta' ? ($request->pos_reference ?? 'POS-MANUAL') : 'CAJA_EFECTIVO',
                'status' => 'approved',
            ]);
        }

        return redirect()->route('admin.members')->with('success', 'Expediente del atleta, plan y método de cobro actualizados con éxito.');
    }

   public function storeMember(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255', // Removemos 'unique:users' para permitir renovaciones en mostrador
            'phone' => 'required|string|max:20',
            'plan_id' => 'required|exists:plans,id',
            'payment_method' => 'required|string',
        ]);

        // 1. BUSCADOR INTELIGENTE DE ATLETAS (Upsert)
        // Buscamos si el correo ya está registrado en el sistema
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Si el atleta ya existe, actualizamos sus datos de contacto por si cambiaron
            $user->update([
                'name' => $request->name,
                'phone' => $request->phone,
            ]);
        } else {
            // Si es un cliente completamente nuevo, le creamos su cuenta de acceso base
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role' => 'member',
                'password' => Hash::make('IronPass123!'),
            ]);
        }

        $plan = Plan::find($request->plan_id);

        // 2. CONTROL DE VIGENCIA IMPERMEABLE: ¿RENOVACIÓN O MATRÍCULA NUEVA?
        // Buscamos si el usuario ya cuenta con un registro previo de suscripción
        $subscription = Subscription::where('user_id', $user->id)->latest()->first();

        if ($subscription) {
            // RENOVACIÓN REAL: Modificamos su registro existente evitando filas duplicadas en MariaDB
            $subscription->update([
                'plan_id' => $plan->id,
                'starts_at' => now()->toDateString(),
                'expires_at' => now()->addDays($plan->duration_days)->toDateString(),
                'status' => 'active', // Revierte el estado de 'expired' a 'active' inmediatamente
            ]);
        } else {
            // MATRÍCULA NUEVA: Si el usuario jamás ha tenido un plan, se inicializa su primera fila
            $subscription = Subscription::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'starts_at' => now()->toDateString(),
                'expires_at' => now()->addDays($plan->duration_days)->toDateString(),
                'status' => 'active',
            ]);
        }

        // Mapeo del método de pago para respetar el ENUM de tu DB
        $dbPaymentMethod = $request->payment_method === 'tarjeta' ? 'pos' : 'cash';

        // 3. REGISTRO EN EL LIBRO CONTABLE (Siempre se genera una nueva fila de pago por la nueva plata recibida)
        Payment::create([
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
            'amount' => $plan->price,
            'payment_method' => $dbPaymentMethod, 
            'wompi_transaction_id' => $request->payment_method === 'tarjeta' ? ($request->pos_reference ?? 'POS-MANUAL') : 'CAJA_EFECTIVO',
            'status' => 'approved',
        ]);

        return redirect()->route('admin.members')->with('success', 'Membresía actualizada y cobro asentado con éxito en MariaDB.');
    }

    
    /**
     * Remueve de forma definitiva al miembro del gimnasio.
     */
    public function destroyMember($id)
    {
        $user = User::findOrFail($id);
        $user->delete(); // Elimina en cascada si están configuradas las llaves foráneas

        return redirect()->route('admin.members')->with('success', 'Atleta removido del sistema permanentemente.');
    }

    /**
     * Muestra la pantalla del molinete y carga los últimos 10 accesos del día.
     */
    public function accessIndex()
    {
        // Traemos el historial con su respectivo usuario para no sobrecargar la BD
        $logs = AccessLog::with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.access', compact('logs'));
    }

    /**
     * Procesa el código QR/ID del atleta y decide si otorgar el acceso físico.
     */
    public function scanQr(Request $request)
    {
        $request->validate([
            'member_id' => 'required|numeric',
        ]);

        // 1. Verificar si el código corresponde a un atleta real
        $user = User::where('id', $request->member_id)->where('role', 'member')->first();

        if (!$user) {
            return redirect()->route('admin.access')->with('deny', 'CÓDIGO INVÁLIDO: El identificador no pertenece a ningún atleta matriculado.');
        }

        // 2. Validar si cuenta con un pase activo que no haya expirado hoy
        $hasAccess = $user->subscriptions()
            ->where('status', 'active')
            ->where('expires_at', '>=', now()->toDateString())
            ->exists();

        // 3. Registrar de forma obligatoria la auditoría en MariaDB
        AccessLog::create([
            'user_id' => $user->id,
            'access_granted' => $hasAccess,
        ]);

        // 4. Disparar respuesta visual de impacto
        if ($hasAccess) {
            return redirect()->route('admin.access')->with('grant', 'ACCESO CONCEDIDO: Bienvenido/a de vuelta, ' . $user->name . '. Pase autorizado.');
        }

        return redirect()->route('admin.access')->with('deny', 'ACCESO RECHAZADO: El atleta ' . $user->name . ' tiene su membresía vencida.');
    }

    /**
     * Concilia los flujos de la pasarela digital Wompi vs cobros en mostrador.
     */
    public function wompiIndex()
    {
        // 1. Segmentación de Ingresos de Base de Datos
        $wompiRevenue = Payment::where('status', 'approved')->where('payment_method', 'wompi_card')->sum('amount');
        $posRevenue = Payment::where('status', 'approved')->where('payment_method', 'pos')->sum('amount');
        $cashRevenue = Payment::where('status', 'approved')->where('payment_method', 'cash')->sum('amount');

        // 2. Historial de transacciones procesadas estrictamente por pasarela digital
        $wompiPayments = Payment::with(['user', 'subscription.plan'])
            ->where('payment_method', 'wompi_card')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.wompi', compact('wompiRevenue', 'posRevenue', 'cashRevenue', 'wompiPayments'));
    }


    /**
     * Genera y transmite una descarga de reporte CSV con todas las ventas aprobadas.
     */
    public function exportSales()
    {
        // Traemos todos los cobros aprobados en el sistema
        $payments = Payment::with(['user', 'subscription.plan'])
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->get();

        $fileName = 'reporte_ventas_iron_' . now()->format('Ymd_His') . '.csv';

        // Cabeceras HTTP obligatorias para forzar la descarga de archivos planos
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        // Columnas del libro contable
        $columns = ['Fecha y Hora', 'Atleta', 'Correo', 'Plan Adquirido', 'Metodo de Pago', 'Monto Neto (USD)', 'ID Referencia / Wompi'];

        // Usamos una respuesta en streaming para cuidar la memoria RAM del servidor Fedora
        $callback = function() use($payments, $columns) {
            $file = fopen('php://output', 'w');
            
            // Inyectamos el BOM UTF-8 indispensable para que Excel en Windows/Linux reconozca tildes y caracteres latinos
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Escribimos la fila de encabezados
            fputcsv($file, $columns);

            // Recorremos los pagos inyectando la información formateada
            foreach ($payments as $p) {
                // Traducimos el enum interno a lenguaje legible para administración
                $methodLabel = match($p->payment_method) {
                    'wompi_card' => 'Wompi Web',
                    'pos'        => 'Tarjeta POS (Mostrador)',
                    'cash'       => 'Efectivo',
                    default      => $p->payment_method
                };

                fputcsv($file, [
                    $p->created_at->format('d/m/Y H:i:s'),
                    $p->user->name ?? 'N/A',
                    $p->user->email ?? 'N/A',
                    $p->subscription->plan->name ?? 'Plan Base',
                    $methodLabel,
                    number_format($p->amount, 2),
                    $p->wompi_transaction_id
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


}
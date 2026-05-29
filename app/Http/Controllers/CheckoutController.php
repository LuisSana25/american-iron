<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    /**
     * Muestra la pantalla para elegir el plan y pagar con el Widget de Wompi.
     */
    public function index()
    {
        $plans = Plan::all();
        $user = Auth::user();

        return view('checkout', compact('plans', 'user'));
    }

    /**
     * Captura la respuesta de Wompi tras un pago exitoso, 
     * evalúa el historial del atleta y actualiza o crea en MariaDB.
     */
    public function success(Request $request)
    {
        $user = Auth::user();
        
        // 1. Obtener los datos que Wompi inyecta por URL al retornar con éxito
        $planId = $request->query('plan_id');
        $wompiTxId = $request->query('idTransaccion'); // ID único de transacción de Wompi SV
        
        if (!$planId || !$wompiTxId) {
            return redirect()->route('dashboard')->with('error', 'La pasarela no devolvió los parámetros de validación.');
        }

        // 2. Buscar el plan para conocer su precio y días de duración
        $plan = Plan::findOrFail($planId);

        // 3. CONTROL DE VIGENCIA IMPERMEABLE: ¿RENOVACIÓN ONLINE O NUEVO ATLETA?
        // Buscamos si este usuario ya cuenta con alguna suscripción previa en la base de datos
        $subscription = Subscription::where('user_id', $user->id)->latest()->first();

        if ($subscription) {
            // RENOVACIÓN ONLINE: Modificamos su registro existente evitando filas duplicadas en MariaDB
            $subscription->update([
                'plan_id'    => $plan->id,
                'starts_at'  => Carbon::now()->toDateString(),
                'expires_at' => Carbon::now()->addDays($plan->duration_days)->toDateString(),
                'status'     => 'active', // Revierte de 'expired' a 'active' de inmediato
            ]);
        } else {
            // MATRÍCULA ONLINE NUEVA: Si es un cliente totalmente nuevo, se inicializa su primer registro
            $subscription = Subscription::create([
                'user_id'    => $user->id,
                'plan_id'    => $plan->id,
                'starts_at'  => Carbon::now()->toDateString(),
                'expires_at' => Carbon::now()->addDays($plan->duration_days)->toDateString(),
                'status'     => 'active',
            ]);
        }

        // 4. GUARDAR EL PAGO DE FORMA AUDITABLE PARA TUS REPORTES PDF
        // Siempre creamos una fila en pagos porque es una nueva inyección de dinero real
        Payment::create([
            'user_id'              => $user->id,
            'subscription_id'      => $subscription->id,
            'amount'               => $plan->price,
            'payment_method'       => 'wompi_card',
            'wompi_transaction_id' => $wompiTxId,
            'status'               => 'approved',
        ]);

        // 5. Redirigir al panel con un mensaje de éxito rotundo
        return redirect()->route('dashboard')->with('success', '¡Excelente! Tu pago para el plan ' . $plan->name . ' fue procesado correctamente. Tu acceso ya está activo.');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http; // 🚀 Crucial para conectar de forma segura con Wompi
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
     * Captura la respuesta de Wompi tras un intento de pago,
     * valida de forma segura con la API de Wompi y actualiza MariaDB.
     */
    public function success(Request $request)
    {
        $user = Auth::user();
        
        // 1. Obtener identificadores nativos de la URL
        $planId = $request->query('plan_id');
        // Wompi adjunta de forma automática el ID de su pasarela con el nombre 'wompi_transaccion_id'
        $wompiTxId = $request->query('wompi_transaccion_id'); 
        
        if (!$planId || !$wompiTxId) {
            return redirect()->route('dashboard')->with('error', 'La pasarela no devolvió los parámetros de validación obligatorios.');
        }

        // 2. EXTRA PROTECCIÓN: Consultar el estado real directo a la API de Wompi
        
        $apiUrl = config('services.wompi.api_url');
        $accessToken = config('services.wompi.access_token');
        $response = Http::withToken($accessToken)->get("{$apiUrl}/v1/transacciones/{$wompiTxId}");

        // Si la API falla o el estado no es estrictamente 'APROBADA', rechazamos la operación
        if ($response->failed() || $response->json('resultado') !== 'APROBADA') {
            return redirect()->route('dashboard')->with('error', 'La transacción no pudo ser verificada o fue rechazada por el banco emisor.');
        }

        // 3. Buscar el plan para conocer su precio y días de duración
        $plan = Plan::findOrFail($planId);

        // 4. CONTROL DE VIGENCIA IMPERMEABLE: ¿RENOVACIÓN ONLINE O NUEVO ATLETA?
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

        // 5. GUARDAR EL PAGO DE FORMA AUDITABLE PARA TUS REPORTES PDF
        Payment::create([
            'user_id'              => $user->id,
            'subscription_id'      => $subscription->id,
            'amount'               => $plan->price,
            'payment_method'       => 'wompi_card',
            'wompi_transaction_id' => $wompiTxId, // Guardamos el ID real validado por Wompi
            'status'               => 'approved',
        ]);

        // 6. Redirigir al panel con un mensaje de éxito rotundo
        return redirect()->route('dashboard')->with('success', '¡Excelente! Tu pago para el plan ' . $plan->name . ' fue procesado correctamente. Tu acceso en American Iron ya está activo.');
    }
}
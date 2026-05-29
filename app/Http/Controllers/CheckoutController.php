<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http; 
use Illuminate\Support\Facades\Log;
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
     * valida de forma segura y actualiza MariaDB.
     */
    public function success(Request $request)
    {
        // 1. Verificar que el usuario mantenga la sesión activa tras el retorno
        $user = Auth::user();
        if (!$user) {
            Log::error('Pago de Wompi procesado, pero el usuario perdió la sesión al retornar.');
            return redirect()->route('login')->with('error', 'Por favor, inicia sesión para activar tu membresía.');
        }
        
        // 2. Obtener identificadores nativos enviados por el nuevo flujo de Wompi
        $planName = $request->input('identificadorEnlaceComercio'); // Ej: "Iron Trimestral" o "Inscripción"
        $wompiTxId = $request->input('idTransaccion'); // ID único de la transacción en el banco
        
        if (!$planName || !$wompiTxId) {
            Log::error('Wompi retornó al éxito pero faltan parámetros cruciales en el Request.', $request->all());
            return redirect()->route('checkout')->with('error', 'La pasarela no devolvió los parámetros de validación obligatorios.');
        }

        // 3. Buscar el plan en MariaDB mapeando directamente por su nombre exacto
        $plan = Plan::where('name', $planName)->first();

        if (!$plan) {
            Log::error("Se procesó un pago para un plan no registrado en el sistema: " . $planName);
            return redirect()->route('checkout')->with('error', 'El plan procesado no coincide con nuestros registros actuales.');
        }

        // 4. EXTRA PROTECCIÓN OPCIONAL: Si deseas validar en vivo el estado contra la API de Wompi
        // Puedes descomentar este bloque si tu cuenta de Wompi requiere validación por API Key adicional
        /*
        $apiUrl = config('services.wompi.api_url');
        $accessToken = config('services.wompi.access_token');
        $response = Http::withToken($accessToken)->get("{$apiUrl}/v1/transacciones/{$wompiTxId}");

        if ($response->failed() || $response->json('resultado') !== 'APROBADA') {
            Log::warning("Validación de API fallida para la transacción: {$wompiTxId}");
            return redirect()->route('checkout')->with('error', 'La transacción no pudo ser verificada o fue rechazada.');
        }
        */

        try {
            // 5. CONTROL DE VIGENCIA IMPERMEABLE: ¿RENOVACIÓN ONLINE O NUEVO ATLETA?
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

            // 6. GUARDAR EL PAGO DE FORMA AUDITABLE PARA TUS REPORTES PDF
            Payment::create([
                'user_id'              => $user->id,
                'subscription_id'      => $subscription->id,
                'amount'               => $plan->price,
                'payment_method'       => 'wompi_card',
                'wompi_transaction_id' => $wompiTxId, 
                'status'               => 'approved',
            ]);

            // 7. Redirigir al panel de control con un mensaje de éxito rotundo
            return redirect()->route('dashboard')->with('success', '¡Excelente! Tu pago para el plan ' . $plan->name . ' fue procesado correctamente. Tu acceso en American Iron ya está activo.');

        } catch (\Exception $e) {
            Log::error('Error crítico al impactar la base de datos tras pago de Wompi: ' . $e->getMessage());
            return redirect()->route('checkout')->with('error', 'El pago fue cobrado con éxito, pero ocurrió un problema al activar tu membresía en el sistema. Contacta al administrador.');
        }
    }

    /**
     * Muestra la pantalla individual de resumen de compra y renderiza el Widget moderno de Wompi.
     */
    public function pay($id)
    {
        $plan = Plan::findOrFail($id);
        return view('checkout-pay', compact('plan'));
    }
}
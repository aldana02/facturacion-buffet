<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use MercadoPago\SDK;
use MercadoPago\Payment;
use MercadoPago\Payer;
use App\Models\Venta;

class MercadoPagoController extends Controller
{
    public function __construct()
    {
        // Establece el token de acceso desde config/services.php
       // SDK::setAccessToken(config('services.mercadopago.access_token'));
         
    }

    /**
     * Método de prueba (puede eliminarse en producción)
     */
    public function test()
    {
        $payment = new Payment();
        $payment->transaction_amount = 100;
        $payment->description = "Venta de prueba";
        $payment->payment_method_id = "visa";
        $payer = new Payer();
        $payer->email = "francovichecarina3@gmail.com";
        $payment->payer = $payer;
        $payment->save();

        return response()->json($payment);
    }

    /**
     * Webhook para recibir notificaciones de Mercado Pago
     */
    public function webhook(Request $request)
    {
        if ($request->query('token') !== env('MP_WEBHOOK_SECRET')) {
        return response()->json(['error' => 'Unauthorized'], 401);
        }
        Log::info('✅ Webhook recibido de Mercado Pago:', $request->all());
        \MercadoPago\SDK::setAccessToken(env('MP_ACCESS_TOKEN'));
        // Validar tipo de notificación
        $type = $request->input('type');
        $id = $request->input('data.id');

        if ($type === 'payment' && $id) {
            // Consultar el pago
            $payment = Payment::find_by_id($id);

            if ($payment && $payment->status === 'approved') {
                Log::info("✅ Pago aprobado. ID: {$payment->id} | Monto: {$payment->transaction_amount}");

                $venta = Venta::create([
                    'total' => $request->total,
                    'productos' => json_encode($productosArray),
                    'fecha_venta' => now(),
                ]);

            } else {
                Log::warning("⚠️ Pago no aprobado o no encontrado. ID recibido: {$id}");
            }
        }

        return response()->json(['message' => 'ok'], 200);
    }
}

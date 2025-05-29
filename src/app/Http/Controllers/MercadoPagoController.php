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
     /**
     * Webhook para recibir notificaciones de Mercado Pago
     */
    public function webhook(Request $request)
    {
        Log::info('✅ Webhook recibido de Mercado Pago:', $request->all());
        \MercadoPago\SDK::setAccessToken(env('MP_ACCESS_TOKEN'));
        // Validar tipo de notificación
        $type = $request->input('type');
      
        if ($type === 'payment') {
            // Consultar el pago
            $payment = $request->data['id'];
            if ($payment && $payment->status === 'approved') {
                Log::info("✅ Pago aprobado. ID: {$payment->id} | Monto: {$payment->transaction_amount}");

                $venta = Venta::create([
                    'total' => $payment->transaction_amount,
                    'productos' => json_encode($productosArray),
                    'fecha_venta' => now(),
                ]); 

            } else {
                Log::warning("⚠️ Pago no aprobado o no encontrado. ID recibido");
            }
        }

        return response()->json(['message' => 'ok'], 200);
    }
}

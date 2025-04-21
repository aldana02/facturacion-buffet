<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MercadoPagoController extends Controller
{
    public function test()
    {
        \MercadoPago\SDK::setAccessToken(config('services.mercadopago.access_token'));
        $payment = new \MercadoPago\Payment();
        $payment->transaction_amount = 100;
        $payment->description = "Venta de prueba";
        $payment->payment_method_id = "visa";
        $payment->payer = array(
            "email" => "francovichecarina3@gmail.com"
        );

        $payment->save();

        return response()->json($payment);
    }
    // public function webhook(Request $request)
    // {
    //     \Log::info('Webhook recibido', [
    //         'data' => $request->all(),
    //     ]);

    //     return response()->json(['status' => 'success'], 200);
    // }
    public function webhook(Request $request)
    {
        \Log::info('✅ Webhook Mercado Pago:', $request->all());

        return response()->json(['message' => 'ok']);
    }

}

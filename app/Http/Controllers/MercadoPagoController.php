<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MercadoPagoController extends Controller
{
    public function test()
    {
        \MercadoPago\SDK::setAccessToken(env('MP_ACCESS_TOKEN'));

        $payment = new \MercadoPago\Payment();
        $payment->transaction_amount = 100;
        $payment->description = "Venta de prueba";
        $payment->payment_method_id = "visa";
        $payment->payer = array(
            "email" => "test_user_123456@testuser.com"
        );

        $payment->save();

        return response()->json($payment);
    }
}

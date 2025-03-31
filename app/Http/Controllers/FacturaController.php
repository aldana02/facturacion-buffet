<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\Venta;


class FacturaController extends Controller
{
    public function facturarDia()
    {
        if (Factura::whereDate('fecha', today())->exists()) {
            return redirect()->route('home')->with('error', 'La factura del día ya fue generada.');
        }

        $ventasDelDia = Venta::whereDate('fecha_venta', today())->get();
        $totalDelDia = $ventasDelDia->sum('total');

        if ($totalDelDia == 0) {
            return redirect()->route('home')->with('error', 'No hay ventas para facturar.');
        }

        $afip = new \Afip([
            'CUIT' => config('afip.cuit'),
            'cert' => config('afip.cert'),
            'key' => config('afip.key'),
            'production' => config('afip.modo') === 'produccion'
        ]);

        // Datos de la factura para AFIP
        $data = [
            'CantReg'  => 1, 
            'PtoVta'   => 1, 
            'CbteTipo' => 6, 
            'Concepto' => 1, 
            'DocTipo'  => 80, 
            'DocNro'   => 20123456789, 
            'CbteFch'  => intval(date('Ymd')),
            'ImpTotal' => $totalDelDia,
            'ImpIVA'   => round($totalDelDia * 0.21, 2), 
            'ImpNeto'  => round($totalDelDia / 1.21, 2),
            'ImpOpEx'  => 0.00,
            'ImpTrib'  => 0.00,
            'MonId'    => 'PES',
            'MonCotiz' => 1,
            'Iva' => [
                [
                    'Id' => 5, 
                    'BaseImp' => round($totalDelDia / 1.21, 2),
                    'Importe' => round($totalDelDia * 0.21, 2)
                ]
            ]
        ];

        // Enviar la factura a AFIP
        $res = $afip->ElectronicBilling->CreateVoucher($data);

        // Guardar la factura en la base de datos
        Factura::create([
            'total' => $totalDelDia,
            'fecha' => today(),
            'cae' => $res['CAE'],
            'vencimiento_cae' => $res['CAEFchVto'],
        ]);

        return redirect()->route('home')->with('success', 'Factura del día generada correctamente.');
    }
}

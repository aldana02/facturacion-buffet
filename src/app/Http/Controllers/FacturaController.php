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
    try {
        $res = $afip->ElectronicBilling->CreateVoucher($data);

        if (!isset($res['CAE'])) {
            Log::error('⚠️ AFIP no devolvió CAE', ['respuesta' => $res]);
            return redirect()->route('home')->with('error', 'AFIP no devolvió CAE. Verificar configuración o datos enviados.');
        }

        // Guardar la factura en la base de datos
        Factura::create([
            'total' => $totalDelDia,
            'fecha' => today(),
            'cae' => $res['CAE'],
            'vencimiento_cae' => $res['CAEFchVto'],
        ]);

        return redirect()->route('home')->with('success', 'Factura generada correctamente.');

    } catch (\Exception $e) {
        Log::error('❌ Error al crear factura con AFIP: ' . $e->getMessage());
        return redirect()->route('home')->with('error', 'Error al generar factura: ' . $e->getMessage());
    }

    }
    public function facturarSeleccionadas(Request $request)
    {
        $ventaIds = $request->input('ventas'); 

        if (!$ventaIds || !is_array($ventaIds)) {
            return redirect()->back()->with('error', 'No seleccionaste ninguna venta para facturar.');
        }

        // Obtener las ventas seleccionadas
        $ventas = Venta::whereIn('id', $ventaIds)->get();

        if ($ventas->isEmpty()) {
            return redirect()->back()->with('error', 'No se encontraron ventas válidas.');
        }

        // Calcular el total sumando los importes
        $total = $ventas->sum('total');

        // Combinar los productos en una sola lista
        $productos = [];
        foreach ($ventas as $venta) {
            $productos = array_merge($productos, json_decode($venta->productos, true));
        }

        // Crear la factura del día (puede adaptarse si tenés un modelo llamado Factura)
        $factura = new Factura();
        $factura->total = $total;
        $factura->fecha = now();
        $factura->productos = json_encode($productos);
        $factura->save();

        return redirect()->back()->with('success', 'Factura generada exitosamente con las ventas seleccionadas.');
    }


}

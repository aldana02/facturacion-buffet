<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Factura;
use App\Models\Cliente;
use App\Models\Venta;

class HomeController extends Controller
{
    public function index()
    {
        $totalProductos = Producto::count();
        $totalVentas = Venta::whereDate('created_at', today())->sum('total');
        $totalClientes = Cliente::count();

        return view('home', compact('totalProductos', 'totalVentas', 'totalClientes'));
    }
}

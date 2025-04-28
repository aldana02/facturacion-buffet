<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ventas = Venta::orderBy('fecha_venta', 'desc')->get();
        return view('ventas.index', compact('ventas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ventas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'total' => 'required|numeric|min:0',
            'productos' => 'required|string',
        ]);
    

        $productosArray = explode(',', $request->productos);
    
        $venta = Venta::create([
            'total' => $request->total,
            'productos' => json_encode($productosArray),
            'fecha_venta' => now(),
        ]);
    
        return redirect()->route('ventas.index')->with('success', 'Venta registrada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $venta = Venta::findOrFail($id);
        return view('ventas.edit', compact('venta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'total' => 'required|numeric|min:0',
            'productos' => 'required|array',
        ]);

        $venta->update([
            'total' => $request->total,
            'productos' => json_encode($request->productos),
        ]);

        return redirect()->route('ventas.index')->with('success', 'Venta actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $venta = Venta::findOrFail($id);
        $venta->delete();
        return redirect()->route('ventas.index')->with('success', 'Venta eliminada correctamente.');
    }
}

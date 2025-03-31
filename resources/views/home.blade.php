@extends('layouts.app')

@section('content')
@auth
        <div class="text-center mt-6">
            <h1 class="text-2xl font-semibold mb-4">Panel de control</h1>

            <form action="{{ route('facturas.facturarDia') }}" method="POST" class="mb-6">
                @csrf
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    🧾 Generar Factura del Día
                </button>
            </form>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 px-4">
            <!-- Productos -->
            <div class="rounded-lg shadow p-6 border border-gray-300" style="background-color: #c7f5e3;">
                <h5 class="text-xl font-bold mb-2">📦 Productos</h5>
                <p class="text-2xl">{{ $totalProductos }}</p>
                <a href="{{ route('productos.index') }}" class="btn btn-primary mt-3">Ver productos</a>
            </div>

            <!-- Ventas -->
            <div class="rounded-lg shadow p-6 border border-gray-300" style="background-color: #c7f5e3;">
                <h5 class="text-xl font-bold mb-2">💰 Ventas del día</h5>
                <p class="text-2xl">${{ number_format($totalVentas, 2) }}</p>
                <a href="{{ route('ventas.index') }}" class="btn btn-success mt-3">Ver Ventas</a>
            </div>

            <!-- Clientes -->
            <div class="rounded-lg shadow p-6 border border-gray-300" style="background-color: #c7f5e3;">
                <h5 class="text-xl font-bold mb-2">👥 Clientes</h5>
                <p class="text-2xl">{{ $totalClientes }}</p>
                <a href="{{ route('clientes.index') }}" class="btn btn-warning mt-3">Ver clientes</a>
            </div>
        </div>

        </div>

        <div class="flex flex-wrap justify-center gap-4 mt-6">
            <a href="{{ route('productos.create') }}" class="bg-white border border-gray-300 text-gray-800 font-semibold py-2 px-4 rounded shadow hover:bg-gray-100">
                ➕ Agregar producto
            </a>
            <a href="{{ route('ventas.create') }}" class="bg-white border border-gray-300 text-gray-800 font-semibold py-2 px-4 rounded shadow hover:bg-gray-100">
                ➕ Registrar Nueva Venta
            </a>
            <a href="{{ route('clientes.create') }}" class="bg-white border border-gray-300 text-gray-800 font-semibold py-2 px-4 rounded shadow hover:bg-gray-100">
                ➕ Añadir cliente
            </a>
        </div>

        </div>
@endauth
@endsection
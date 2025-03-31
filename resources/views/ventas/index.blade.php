@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Ventas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="text-start mb-3">
    <a href="{{ route('home') }}" class="btn btn-dark">🏠 Volver a Home</a>
</div>
    <div class="container mt-4">
        <h2 class="text-center mb-3">Lista de Ventas</h2>

        <div class="text-end mb-3">
            <a href="{{ route('ventas.create') }}" class="btn btn-success">Registrar Nueva Venta</a>
        </div>

        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Total</th>
                    <th>Productos</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ventas as $venta)
                    <tr>
                        <td>{{ $venta->id }}</td>
                        <td>${{ number_format($venta->total, 2) }}</td>
                        <td>{{ implode(', ', json_decode($venta->productos)) }}</td>
                        <td>{{ $venta->fecha_venta }}</td>
                        <td>
                            <a href="{{ route('ventas.edit', $venta->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('ventas.destroy', $venta->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar venta?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
@endsection
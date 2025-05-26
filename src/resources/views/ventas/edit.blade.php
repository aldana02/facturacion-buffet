@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Venta</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container">
    <h2 class="text-center mb-3">Editar Venta</h2>

    <div class="card p-4 shadow-lg">
        <form action="{{ route('ventas.update', $venta->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Total</label>
                <input type="number" name="total" class="form-control" step="0.01" value="{{ $venta->total }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Productos (separados por coma)</label>
                <input type="text" name="productos" class="form-control" value="{{ $venta->productos }}" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Actualizar Venta</button>
        </form>

        <a href="{{ route('ventas.index') }}" class="btn btn-secondary mt-3 w-100">← Ir a Ventas</a>
    </div>
</div>
</body>
</html>
@endsection

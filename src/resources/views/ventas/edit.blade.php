@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-3">Editar Venta</h2>

    <div class="card p-4 shadow-lg">
        <form action="{{ route('ventas.update', $venta->id) }}" method="PUT">
            @csrf
            <!-- @method('PUT') -->

            <div class="mb-3">
                <label class="form-label">Total</label>
                <input type="number" name="total" class="form-control" step="0.01" value="{{ $venta->total }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Productos (separados por coma)</label>
                <input type="text" name="productos" class="form-control" value="{{ implode(', ', json_decode($venta->productos)) }}" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Actualizar Venta</button>
        </form>

        <a href="{{ route('ventas.index') }}" class="btn btn-secondary mt-3 w-100">← Ir a Ventas</a>
    </div>
</div>
@endsection

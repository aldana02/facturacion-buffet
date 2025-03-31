@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-3">Editar Cliente</h2>

    <div class="card p-4 shadow-lg">
        <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="name" class="form-control" value="{{ $cliente->name }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Notas</label>
                <textarea name="notas" class="form-control">{{ $cliente->notas }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Saldo Adeudado</label>
                <input type="number" name="saldo_adeudado" class="form-control" step="0.01" value="{{ $cliente->saldo_adeudado }}" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Actualizar Cliente</button>
        </form>

        <a href="{{ route('clientes.index') }}" class="btn btn-secondary mt-3 w-100">← Volver</a>
    </div>
</div>
@endsection

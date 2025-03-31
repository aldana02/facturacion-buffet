@extends('layouts.app')

@section('content')<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .container-fluid {
            max-width: 1200px; 
        }
    </style>
</head>
<body class="bg-light">

    <div class="container-fluid mt-4">
        <h2 class="text-center mb-3">Crear Producto</h2>

        <div class="row">
            <div class="col-12">
                <div class="card p-4 shadow-lg">
                    
                    <form action="{{ route('productos.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Precio</label>
                            <input type="number" name="price" class="form-control" step="0.01" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Stock</label>
                            <input type="number" name="stock" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Guardar Producto</button>
                    </form>

                    <a href="{{ route('productos.index') }}" class="btn btn-secondary mt-3 w-100">← Ver Productos </a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
@endsection
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cliente</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-4">
        <h2 class="text-center mb-3">Crear Cliente</h2>

        <div class="card p-4 shadow-lg">
            <form action="{{ route('clientes.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Notas</label>
                    <textarea name="notas" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Saldo Adeudado</label>
                    <input type="number" name="saldo_adeudado" class="form-control" step="0.01" required>
                </div>

                <button type="submit" class="btn btn-success w-100">Guardar Cliente</button>
            </form>

            <a href="{{ route('clientes.index') }}" class="btn btn-secondary mt-3 w-100">← Volver</a>
        </div>
    </div>
</body>
</html>

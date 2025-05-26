@extends('layouts.app')

@section('content')
<!-- <div class="text-start mb-3">
    <a href="{{ route('home') }}" class="btn btn-dark">🏠 Volver a Home</a>
</div> -->
<div class="py-6 px-4">
<script src="https://sdk.mercadopago.com/js/v2"></script>
    <h2 class="text-center mb-6 text-xl font-bold">Lista de Ventas</h2>
        @csrf

        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('ventas.create') }}" class="bg-white border border-gray-300 text-gray-800 font-semibold py-2 px-4 rounded shadow hover:bg-gray-100">
                ➕ Registrar Nueva Venta
            </a>
            <!-- <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                🧾 Facturar Seleccionadas
            </button> -->
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto bg-green-100 rounded shadow-md overflow-hidden">
                <thead class="bg-green-200">
                    <tr class="text-left text-sm font-semibold">
                        <!-- <th class="px-4 py-2"><input type="checkbox" id="select-all"></th> -->
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Total</th>
                        <th class="px-4 py-2">Productos</th>
                        <th class="px-4 py-2">Fecha</th>
                        <th class="px-4 py-2">Automática</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @foreach ($ventas as $venta)
                        <tr class="border-t border-gray-300">
                            <!-- <td class="px-4 py-2"><input type="checkbox" name="ventas_seleccionadas[]" value="{{ $venta->id }}"></td> -->
                            <td class="px-4 py-2">{{ $venta->id }}</td>
                            <td class="px-4 py-2">${{ number_format($venta->total, 2) }}</td>
                            <td class="px-4 py-2"> {{ str_replace('"', '', $venta->productos) }}</td>
                            <td class="px-4 py-2">{{ $venta->fecha_venta }}</td>
                            <td class="px-4 py-2">{{ $venta->es_automatica ? 'Automática' : 'Manual' }}</td>
                            <td class="px-4 py-2">
                                <div class="flex space-x-2">
                                    <a href="{{ route('ventas.edit', $venta->id) }}" class="text-yellow-600 hover:underline">Editar</a>
                                    <form action="{{ route('ventas.destroy', $venta->id) }}" method="POST" style="display:inline; color:red">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar esta venta?')">Eliminar</button>
                                    </form>
                                    <form action="{{ route('facturar', $venta->id) }}" method="POST" style="display:inline; color:green">
                                        @csrf
                                        <button type="submit">Facturar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
</div>

<script>
    document.getElementById('select-all').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('input[name="ventas_seleccionadas[]"]');
        checkboxes.forEach(c => c.checked = this.checked);
    });
</script>
@endsection

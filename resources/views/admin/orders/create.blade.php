@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Nuevo Pedido</h1>

    <form action="{{ route('admin.orders.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="user_id" class="form-label">Usuario</label>
            <select name="user_id" id="user_id" class="form-select" required>
                <option value="">Seleccionar usuario</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div id="products-container" class="mb-3">
            <label class="form-label">Productos</label>
            <div class="product-row d-flex mb-2">
                <select name="products[]" class="form-select me-2" required>
                    <option value="">Seleccionar producto</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->model }}</option>
                    @endforeach
                </select>
                <input type="number" name="quantities[]" class="form-control me-2" placeholder="Cantidad" required>
                <input type="number" name="prices[]" class="form-control me-2" placeholder="Precio" step="0.01" required>
                <button type="button" class="btn btn-danger remove-product">x</button>
            </div>
        </div>

        <button type="button" class="btn btn-secondary mb-3" id="add-product">Añadir producto</button>

        <div class="mb-3">
            <label for="total" class="form-label">Total (€)</label>
            <input type="number" step="0.01" name="total" id="total" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Estado</label>
            <select name="status" id="status" class="form-select" required>
                <option value="pending">Pendiente</option>
                <option value="paid">Pagado</option>
                <option value="shipped">Enviado</option>
                <option value="delivered">Entregado</option>
                <option value="cancelled">Cancelado</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Guardar Pedido</button>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>

<script>
document.getElementById('add-product').addEventListener('click', function() {
    const container = document.getElementById('products-container');
    const row = container.querySelector('.product-row').cloneNode(true);
    row.querySelectorAll('input, select').forEach(el => el.value = '');
    container.appendChild(row);
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-product')) {
        e.target.closest('.product-row').remove();
    }
});
</script>
@endsection

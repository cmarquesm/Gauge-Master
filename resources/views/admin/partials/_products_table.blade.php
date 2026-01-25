<div class="table-responsive">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Gestión de Productos</h4>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">Nuevo Producto</a>
    </div>

    <table class="table table-hover align-middle shadow-sm rounded overflow-hidden">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Calibre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th class="text-end">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->brand }}</td>
                    <td class="fw-bold text-dark">{{ $product->model }}</td>
                    <td>{{ $product->gauge }}</td>
                    <td>{{ number_format($product->price, 2) }} €</td>
                    <td>
                        @if($product->stock > 10)
                            <span class="badge bg-success">{{ $product->stock }}</span>
                        @elseif($product->stock > 0)
                            <span class="badge bg-warning text-dark">{{ $product->stock }}</span>
                        @else
                            <span class="badge bg-danger">Agotado</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary me-1">
                            Editar
                        </a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar producto?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">No hay productos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
         {{ $products->appends(['users_page' => request('users_page'), 'orders_page' => request('orders_page')])->links() }}
    </div>
</div>

<div class="table-responsive">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Pedidos Recientes</h4>
    </div>

    <table class="table table-hover align-middle shadow-sm">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Productos</th>
                <th class="text-end">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>
                        <div class="fw-bold">{{ $order->user->name ?? 'Usuario Eliminado' }}</div>
                        <small class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</small>
                    </td>
                    <td>{{ number_format($order->total, 2) }} €</td>
                    <td>
                        @switch($order->status)
                            @case('paid')
                                <span class="badge bg-primary">Pagado</span>
                                @break
                            @case('shipped')
                                <span class="badge bg-primary">Enviado</span>
                                @break
                            @case('completed')
                                <span class="badge bg-success">Completado</span>
                                @break
                            @case('cancelled')
                                <span class="badge bg-danger">Cancelado</span>
                                @break
                            @default
                                <span class="badge bg-warning text-dark">Pendiente</span>
                        @endswitch
                    </td>
                    <td>
                        <small>
                            <ul class="list-unstyled mb-0">
                                @foreach($order->products->take(2) as $prod)
                                    <li class="d-flex align-items-center gap-2 mb-1">
                                        @if($prod->image)
                                            <img src="{{ asset($prod->image) }}" 
                                                 alt="{{ $prod->brand }}" 
                                                 class="rounded"
                                                 style="height: 30px; width: auto; object-fit: contain;">
                                        @endif
                                        <span>{{ $prod->model }} (x{{ $prod->pivot->quantity }})</span>
                                    </li>
                                @endforeach
                                @if($order->products->count() > 2)
                                    <li class="text-muted fst-italic">+ {{ $order->products->count() - 2 }} más...</li>
                                @endif
                            </ul>
                        </small>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-sm btn-outline-info">
                            Ver / Editar
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">No hay pedidos recientes.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $orders->appends(['users_page' => request('users_page'), 'products_page' => request('products_page')])->links() }}
    </div>
</div>

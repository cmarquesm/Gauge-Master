@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Pedidos</h1>

    <a href="{{ route('admin.orders.create') }}" class="btn btn-primary mb-3">Nuevo Pedido</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Total (€)</th>
                <th>Estado</th>
                <th>Productos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ number_format($order->total, 2) }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>
                    <ul class="mb-0">
                        @foreach ($order->products as $product)
                            <li>{{ $product->model }} (x{{ $product->pivot->quantity }})</li>
                        @endforeach
                    </ul>
                </td>
                <td>
                    <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar pedido?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $orders->links() }}
</div>
@endsection

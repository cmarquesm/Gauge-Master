@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 fw-bold">Panel de Administración</h2>
    <p class="text-muted mb-5">Accesos rápidos y resumen general del sistema.</p>

    {{-- Accesos rápidos --}}
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                <div class="card text-center shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-0">Usuarios / Clientes</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.products.index') }}" class="text-decoration-none">
                <div class="card text-center shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-0">Productos</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.orders.index') }}" class="text-decoration-none">
                <div class="card text-center shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-0">Pedidos</h5>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- Resumen informativo --}}
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Usuarios registrados</h6>
                    <h2 class="fw-bold">{{ $userCount }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Número de pedidos</h6>
                    <h2 class="fw-bold">{{ $orderCount }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

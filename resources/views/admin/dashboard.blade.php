@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1 text-dark">Panel de Administración</h2>
            <p class="text-muted mb-0">Gestión integral del sistema</p>
        </div>
        <div class="text-muted small">
            <i class="bi bi-calendar3 me-1"></i> {{ now()->format('d M, Y') }}
        </div>
    </div>

    {{-- Tabs Navigation --}}
    <ul class="nav nav-tabs nav-fill mb-0 border-bottom-0" id="adminTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-semibold py-3" id="summary-tab" data-bs-toggle="tab" data-bs-target="#summary" type="button" role="tab" aria-controls="summary" aria-selected="true">
                <i class="bi bi-speedometer2 me-2"></i>Resumen
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-semibold py-3" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab" aria-controls="users" aria-selected="false">
                <i class="bi bi-people me-2"></i>Usuarios
                <span class="badge bg-primary rounded-pill ms-2">{{ $users->total() }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-semibold py-3" id="products-tab" data-bs-toggle="tab" data-bs-target="#products" type="button" role="tab" aria-controls="products" aria-selected="false">
                <i class="bi bi-box-seam me-2"></i>Productos
                <span class="badge bg-success rounded-pill ms-2">{{ $products->total() }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-semibold py-3" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button" role="tab" aria-controls="orders" aria-selected="false">
                <i class="bi bi-cart me-2"></i>Pedidos
                <span class="badge bg-warning text-dark rounded-pill ms-2">{{ $orders->total() }}</span>
            </button>
        </li>
    </ul>

    {{-- Tabs Content --}}
    <div class="tab-content border rounded-bottom shadow-sm bg-white p-4" id="adminTabContent">
        
        {{-- Resumen --}}
        <div class="tab-pane fade show active" id="summary" role="tabpanel" aria-labelledby="summary-tab">
            <div class="row g-4">
                <div class="col-md-4 col-lg-3">
                    <div class="card border-0 shadow-sm h-100 bg-light">
                        <div class="card-body p-4 text-center">
                            <h6 class="text-uppercase text-muted fw-bold mb-2">Total Usuarios</h6>
                            <h1 class="display-6 fw-bold text-primary mb-0">{{ $userCount }}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <div class="card border-0 shadow-sm h-100 bg-light">
                        <div class="card-body p-4 text-center">
                            <h6 class="text-uppercase text-muted fw-bold mb-2">Total Pedidos</h6>
                            <h1 class="display-6 fw-bold text-success mb-0">{{ $orderCount }}</h1>
                        </div>
                    </div>
                </div>
                {{-- Quick Actions / More Stats --}}
                <div class="col-md-4 col-lg-6">
                     <div class="card border-0 shadow-sm h-100 bg-light">
                        <div class="card-body p-4 d-flex align-items-center justify-content-center text-muted">
                            <span class="fst-italic">Más estadísticas próximamente...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Usuarios --}}
        <div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="users-tab">
            @include('admin.partials._users_table')
        </div>

        {{-- Productos --}}
        <div class="tab-pane fade" id="products" role="tabpanel" aria-labelledby="products-tab">
            @include('admin.partials._products_table')
        </div>

        {{-- Pedidos --}}
        <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
            @include('admin.partials._orders_table')
        </div>
    </div>
</div>
@endsection

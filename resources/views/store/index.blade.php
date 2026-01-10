@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto p-6">
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-semibold">Tienda · Cuerdas individuales</h1>
    <div id="shopAlert" class="hidden mb-4 rounded border p-4"></div>
    
    <a href="{{ route('profile.edit') }}" class="underline">Perfil</a>
  </div>

  {{-- Filtros --}}
  <form method="GET" action="{{ route('store') }}" class="border rounded-lg p-4 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <div>
        <label class="block text-sm mb-1">Fabricante</label>
        <select name="brand" class="border rounded w-full p-2">
          <option value="">Todos</option>
          @foreach($brands as $b)
            <option value="{{ $b }}" @selected(request('brand') === $b)>{{ $b }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="block text-sm mb-1">Material</label>
        <select name="material" class="border rounded w-full p-2">
          <option value="">Todos</option>
          @foreach($materials as $m)
            <option value="{{ $m }}" @selected(request('material') === $m)>{{ $m }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="block text-sm mb-1">Calibre</label>
        <select name="gauge" class="border rounded w-full p-2">
          <option value="">Todos</option>
          @foreach($gauges as $g)
            <option value="{{ $g }}" @selected(request('gauge') === $g)>{{ $g }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="block text-sm mb-1">Orden</label>
        <select name="sort" class="border rounded w-full p-2">
          <option value="gauge" @selected($sort === 'gauge')>Calibre</option>
          <option value="price_asc" @selected($sort === 'price_asc')>Precio ↑</option>
          <option value="price_desc" @selected($sort === 'price_desc')>Precio ↓</option>
        </select>
      </div>
    </div>

    <div class="mt-4 flex gap-3">
      <button class="px-4 py-2 border rounded">Filtrar</button>
      <a class="px-4 py-2 border rounded" href="{{ route('store') }}">Limpiar</a>
    </div>
  </form>

  {{-- Grid productos --}}
  @if($products->count() === 0)
    <p>No hay productos con esos filtros.</p>
  @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($products as $product)
        <div class="border rounded-lg p-4">
          <div class="text-sm text-gray-600">{{ $product->brand }}</div>
          <div class="font-semibold">{{ $product->model }} · {{ $product->gauge }}</div>
          <div class="text-sm mb-3">{{ $product->description }}</div>

          <div class="flex items-center justify-between mb-3">
            <div class="font-semibold">{{ number_format($product->price, 2) }} €</div>
            <div class="text-sm text-gray-600">Stock: {{ $product->stock }}</div>
          </div>

          @auth
            <form method="POST" action="{{ route('cart.add') }}" class="flex items-center gap-2">
              @csrf
              <input type="hidden" name="product_id" value="{{ $product->id }}">
              <input type="number" name="qty" value="1" min="1" class="border rounded w-20 p-2">
              <button class="px-3 py-2 border rounded">Añadir</button>
            </form>
          @else
            <a class="underline" href="{{ route('login') }}">Inicia sesión para comprar</a>
          @endauth
        </div>
      @endforeach
    </div>

    <div class="mt-6">
      {{ $products->links() }}
    </div>
  @endif
</div>
@endsection

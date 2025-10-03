@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">Productos</h1>

@if(session('success'))
  <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-800 rounded">
    {{ session('success') }}
  </div>
@endif

<div class="mb-4">
  <a href="{{ route('admin.products.create') }}"
     class="inline-block px-4 py-2 bg-primary text-white rounded hover:bg-blue-600">
    + Crear producto
  </a>
</div>

<div class="overflow-x-auto bg-white rounded-lg border">
  <table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
      <tr>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Marca</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Modelo</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Calibre</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
      @forelse ($products as $product)
      <tr>
        <td class="px-6 py-4 text-sm text-gray-600">{{ $product->id }}</td>
        <td class="px-6 py-4 text-sm text-gray-800">{{ $product->brand }}</td>
        <td class="px-6 py-4 text-sm text-gray-800">{{ $product->model }}</td>
        <td class="px-6 py-4 text-sm text-gray-800">{{ $product->gauge }}</td>
        <td class="px-6 py-4 text-sm text-gray-800">{{ $product->price }} €</td>
        <td class="px-6 py-4 text-sm text-gray-800">{{ $product->stock }}</td>
        <td class="px-6 py-4 text-sm flex gap-2">
            <a href="{{ route('admin.products.edit', $product) }}"
                lass="text-blue-600 hover:underline text-sm">Editar</a>

            <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-600 hover:underline text-sm">Eliminar</button>
            </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="7" class="px-6 py-4 text-sm text-gray-500 text-center">No hay productos.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-4">
  {{ $products->links() }}
</div>
@endsection

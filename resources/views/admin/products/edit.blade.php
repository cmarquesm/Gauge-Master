@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">Editar producto</h1>

<div class="bg-white p-6 rounded-lg border max-w-xl">
  <form action="{{ route('admin.products.update', $product) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-4">
      <label for="brand" class="block text-sm font-medium text-gray-700">Marca</label>
      <input type="text" id="brand" name="brand" required
             value="{{ old('brand', $product->brand) }}"
             class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500">
    </div>

    <div class="mb-4">
      <label for="model" class="block text-sm font-medium text-gray-700">Modelo</label>
      <input type="text" id="model" name="model" required
             value="{{ old('model', $product->model) }}"
             class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500">
    </div>

    <div class="mb-4">
      <label for="gauge" class="block text-sm font-medium text-gray-700">Calibre</label>
      <input type="text" id="gauge" name="gauge"
             value="{{ old('gauge', $product->gauge) }}"
             class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500">
    </div>

    <div class="mb-4">
      <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
      <textarea id="description" name="description" rows="3"
                class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $product->description) }}</textarea>
    </div>

    <div class="mb-4">
      <label for="price" class="block text-sm font-medium text-gray-700">Precio (€)</label>
      <input type="number" step="0.01" id="price" name="price" required
             value="{{ old('price', $product->price) }}"
             class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500">
    </div>

    <div class="mb-4">
      <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
      <input type="number" id="stock" name="stock" required
             value="{{ old('stock', $product->stock) }}"
             class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500">
    </div>

    <div class="mb-6">
      <label for="image" class="block text-sm font-medium text-gray-700">Ruta de imagen</label>
      <input type="text" id="image" name="image"
             value="{{ old('image', $product->image) }}"
             class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500">
    </div>

    <div class="flex justify-end">
      <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-gray-300 text-sm rounded mr-2">Cancelar</a>
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
        Actualizar producto
      </button>
    </div>
  </form>
</div>
@endsection

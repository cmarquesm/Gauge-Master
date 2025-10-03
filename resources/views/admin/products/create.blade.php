@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">Crear producto</h1>

<div class="bg-white p-6 rounded-lg border max-w-xl">
  <form action="{{ route('admin.products.store') }}" method="POST">
    @csrf

    <div class="mb-4">
      <label for="brand" class="block text-sm font-medium text-gray-700">Marca</label>
      <input type="text" id="brand" name="brand" required
             value="{{ old('brand') }}"
             class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500">
      @error('brand') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="mb-4">
      <label for="model" class="block text-sm font-medium text-gray-700">Modelo</label>
      <input type="text" id="model" name="model" required
             value="{{ old('model') }}"
             class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500">
      @error('model') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="mb-4">
      <label for="gauge" class="block text-sm font-medium text-gray-700">Calibre</label>
      <input type="text" id="gauge" name="gauge"
             value="{{ old('gauge') }}"
             class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500">
      @error('gauge') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="mb-4">
      <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
      <textarea id="description" name="description" rows="3"
                class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description') }}</textarea>
      @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="mb-4">
      <label for="price" class="block text-sm font-medium text-gray-700">Precio (€)</label>
      <input type="number" step="0.01" id="price" name="price" required
             value="{{ old('price') }}"
             class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500">
      @error('price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="mb-4">
      <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
      <input type="number" id="stock" name="stock" required
             value="{{ old('stock') }}"
             class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500">
      @error('stock') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="mb-6">
      <label for="image" class="block text-sm font-medium text-gray-700">Ruta de imagen</label>
      <input type="text" id="image" name="image"
             value="{{ old('image') }}"
             class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500">
      @error('image') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="flex justify-end">
      <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-gray-300 text-sm rounded mr-2">Cancelar</a>
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
        Guardar producto
      </button>
    </div>
  </form>
</div>
@endsection

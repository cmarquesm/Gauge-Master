@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto p-6">
  <h1 class="text-2xl font-semibold mb-4">Carrito</h1>

  @if(empty($cart))
    <p>Carrito vacío.</p>
  @else
    <table class="w-full border mb-4">
      <thead>
        <tr class="border-b">
          <th class="text-left p-2">Producto</th>
          <th class="text-right p-2">Precio</th>
          <th class="text-right p-2">Qty</th>
          <th class="text-right p-2">Subtotal</th>
          <th class="p-2"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($cart as $productId => $item)
          <tr class="border-b">
            <td class="p-2">{{ $item['title'] }}</td>
            <td class="p-2 text-right">{{ number_format($item['price'], 2) }}</td>
            <td class="p-2 text-right">{{ $item['qty'] }}</td>
            <td class="p-2 text-right">{{ number_format($item['price'] * $item['qty'], 2) }}</td>
            <td class="p-2 text-right">
              <form method="POST" action="{{ route('cart.remove') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $productId }}">
                <button class="underline">Eliminar</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="flex items-center justify-between">
      <div class="font-semibold">Total: {{ number_format($total, 2) }}</div>

      <form method="POST" action="{{ route('checkout.place') }}">
        @csrf
        <button class="px-4 py-2 border rounded">Confirmar compra</button>
      </form>
    </div>
  @endif
</div>
@endsection

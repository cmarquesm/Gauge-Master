@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-6">Carrito</h1>

    @if (session('success'))
    <div class="mb-4 rounded border border-green-200 bg-green-50 text-green-800 p-4">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="mb-4 rounded border border-red-200 bg-red-50 text-red-800 p-4">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if ($items->isEmpty())
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-gray-600">Tu carrito está vacío.</p>
        <a href="{{ route('store') }}" class="inline-block mt-4 underline">
            Ir a la tienda
        </a>
    </div>
    @else
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr class="text-left">
                    <th class="p-4">Producto</th>
                    <th class="p-4">Precio</th>
                    <th class="p-4">Cantidad</th>
                    <th class="p-4 text-right">Subtotal</th>
                    <th class="p-4"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $ci)
                @php
                $product = $ci->product;
                if (!$product) continue;
                $price = (float) $product->price;
                $qty = (int) $ci->quantity;
                $subtotal = $price * $qty;
                @endphp
                <tr class="border-t">
                    <td class="p-4">
                        <div class="font-medium">
                            {{ $product->brand }} {{ $product->model }} · {{ $product->gauge }}
                        </div>
                    </td>
                    <td class="p-4">
                        {{ number_format($price, 2) }} €
                    </td>
                    <td class="p-4">
                        {{ $qty }}
                    </td>
                    <td class="p-4 text-right">
                        {{ number_format($subtotal, 2) }} €
                    </td>
                    <td class="p-4 text-right">
                        <form method="POST" action="{{ route('cart.remove') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button class="underline text-sm">
                                Quitar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex items-center justify-between">
        <div class="text-lg font-semibold">
            Total: {{ number_format($total, 2) }} €
        </div>

        <div class="flex items-center gap-4">
            <form method="POST" action="{{ route('cart.clear') }}" onsubmit="return confirm('¿Estás seguro de que deseas vaciar todo el carrito?');">
                @csrf
                <button class="text-red-600 hover:underline">
                    Vaciar Carrito
                </button>
            </form>

            <form method="POST" action="{{ route('checkout.place') }}">
                @csrf
                <button class="px-5 py-2 rounded bg-black text-white">
                    Confirmar compra
                </button>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection
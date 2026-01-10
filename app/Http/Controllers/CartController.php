<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function show(Request $request)
    {
        $userId = $request->user()->id;

        $items = CartItem::with('product')
            ->where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->get();

        $total = 0.0;
        foreach ($items as $ci) {
            if (!$ci->product) continue;
            $total += (float) $ci->product->price * (int) $ci->quantity;
        }

        return view('cart.index', [
            'items' => $items,
            'total' => $total,
        ]);
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'nullable|integer|min:1',
        ]);

        $userId = $request->user()->id;
        $qty = (int) ($data['qty'] ?? 1);

        $item = CartItem::firstOrNew([
            'user_id' => $userId,
            'product_id' => $data['product_id'],
        ]);

        $item->quantity = ((int) ($item->exists ? $item->quantity : 0)) + $qty;
        $item->save();

        return back()->with('success', 'Añadido al carrito.');
    }


    public function remove(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        CartItem::where('user_id', $request->user()->id)
            ->where('product_id', $data['product_id'])
            ->delete();

        return back()->with('success', 'Producto eliminado del carrito.');
    }


    public function place(Request $request)
    {
        $userId = $request->user()->id;

        $cartItems = CartItem::with('product')
            ->where('user_id', $userId)
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->withErrors(['cart' => 'El carrito está vacío.']);
        }

        try {
            $order = DB::transaction(function () use ($userId, $cartItems) {

                $total = 0.0;
                foreach ($cartItems as $ci) {
                    $total += (float) $ci->product->price * (int) $ci->quantity;
                }

                $order = Order::create([
                    'user_id' => $userId,
                    'total' => $total,
                    'status' => 'pending',
                ]);

                foreach ($cartItems as $ci) {
                    $product = Product::query()
                        ->whereKey($ci->product_id)
                        ->lockForUpdate()
                        ->firstOrFail();

                    $qty = (int) $ci->quantity;

                    if ($product->stock < $qty) {
                        throw new \RuntimeException(
                            "Stock insuficiente: {$product->model} · {$product->gauge}"
                        );
                    }

                    $product->decrement('stock', $qty);

                    $order->products()->attach($product->id, [
                        'quantity' => $qty,
                        'price' => (float) $product->price,
                    ]);
                }

                CartItem::where('user_id', $userId)->delete();

                return $order;
            });
        } catch (\RuntimeException $e) {
            return back()->withErrors(['stock' => $e->getMessage()]);
        }

        return redirect()
            ->route('cart.show')
            ->with('success', "Compra realizada. Pedido #{$order->id}");
    }
}

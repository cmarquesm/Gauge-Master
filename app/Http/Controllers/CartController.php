<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'nullable|integer|min:1',
        ]);

        $userId = $request->user()->id;
        $qty = $data['qty'] ?? 1;

        $item = CartItem::firstOrNew([
            'user_id' => $userId,
            'product_id' => $data['product_id'],
        ]);

        $item->quantity = ($item->exists ? $item->quantity : 0) + $qty;
        $item->save();

        return response()->json(['ok' => true]);
    }

    public function remove(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        CartItem::where('user_id', $request->user()->id)
            ->where('product_id', $data['product_id'])
            ->delete();

        return response()->json(['ok' => true]);
    }

    public function place(Request $request)
    {
        $userId = $request->user()->id;

        $cartItems = CartItem::with('product')
            ->where('user_id', $userId)
            ->get();

        abort_if($cartItems->isEmpty(), 400, 'Cart empty');

        $order = DB::transaction(function () use ($userId, $cartItems) {
            $total = 0.0;

            foreach ($cartItems as $ci) {
                $price = (float) $ci->product->price; // snapshot del precio actual
                $total += $price * (int) $ci->quantity;
            }

            $order = Order::create([
                'user_id' => $userId,
                'total' => $total,
                'status' => 'pending',
            ]);

            foreach ($cartItems as $ci) {
                $order->products()->attach($ci->product_id, [
                    'quantity' => (int) $ci->quantity,
                    'price' => (float) $ci->product->price,
                ]);
            }

            CartItem::where('user_id', $userId)->delete();

            return $order;
        });

        return response()->json(['ok' => true, 'order_id' => $order->id]);
    }
}

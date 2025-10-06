<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'products'])->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        $users = User::all();
        $products = Product::all();
        return view('admin.orders.create', compact('users', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'total' => 'required|numeric|min:0',
            'status' => 'required|string',
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
            'quantities.*' => 'required|integer|min:1',
            'prices.*' => 'required|numeric|min:0',
        ]);

        $order = Order::create([
            'user_id' => $request->user_id,
            'total' => $request->total,
            'status' => $request->status,
        ]);

        foreach ($request->products as $i => $productId) {
            $order->products()->attach($productId, [
                'quantity' => $request->quantities[$i],
                'price' => $request->prices[$i],
            ]);
        }

        return redirect()->route('admin.orders.index')->with('success', 'Pedido creado correctamente.');
    }

    public function edit(Order $order)
    {
        $users = User::all();
        $products = Product::all();
        $order->load('products');
        return view('admin.orders.edit', compact('order', 'users', 'products'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'total' => 'required|numeric|min:0',
            'status' => 'required|string',
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
            'quantities.*' => 'required|integer|min:1',
            'prices.*' => 'required|numeric|min:0',
        ]);

        $order->update([
            'user_id' => $request->user_id,
            'total' => $request->total,
            'status' => $request->status,
        ]);

        $syncData = [];
        foreach ($request->products as $i => $productId) {
            $syncData[$productId] = [
                'quantity' => $request->quantities[$i],
                'price' => $request->prices[$i],
            ];
        }
        $order->products()->sync($syncData);

        return redirect()->route('admin.orders.index')->with('success', 'Pedido actualizado correctamente.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Pedido eliminado.');
    }
}

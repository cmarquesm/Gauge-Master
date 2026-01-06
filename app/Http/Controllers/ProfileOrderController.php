<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class ProfileOrderController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $orders = Order::with('products')
            ->where('user_id', $userId)
            ->latest()
            ->paginate(10);

        return view('profile.orders.index', compact('orders'));
    }

    public function show(Request $request, Order $order)
    {
        abort_unless($order->user_id === $request->user()->id, 403);

        $order->load('products');

        return view('profile.orders.show', compact('order'));
    }
}

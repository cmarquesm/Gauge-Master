<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $orderCount = Order::count();

        // Data for Tabs
        $users = User::latest()->paginate(10, ['*'], 'users_page');
        $products = \App\Models\Product::latest()->paginate(10, ['*'], 'products_page');
        $orders = Order::with('user')->latest()->paginate(10, ['*'], 'orders_page');

        return view('admin.dashboard', compact(
            'userCount', 
            'orderCount',
            'users',
            'products',
            'orders'
        ));
    }
}

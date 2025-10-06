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

        return view('admin.dashboard', compact('userCount', 'orderCount'));
    }
}

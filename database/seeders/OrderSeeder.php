<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        $products = Product::take(3)->get();

        if ($user && $products->count() > 0) {
            $order = Order::create([
                'user_id' => $user->id,
                'total' => $products->sum('price'),
                'status' => 'pending',
            ]);

            foreach ($products as $product) {
                $order->products()->attach($product->id, [
                    'quantity' => 1,
                    'price' => $product->price,
                ]);
            }
        }
    }
}

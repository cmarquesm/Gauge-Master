<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // D'Addario
        Product::create([
            'brand' => "D'Addario",
            'model' => 'EXL110',
            'gauge' => '10-46',
            'description' => 'Juego de cuerdas para guitarra eléctrica niqueladas.',
            'price' => 7.99,
            'stock' => 200,
            'image' => 'images/products/daddario-exl110.jpg',
        ]);

        Product::create([
            'brand' => "D'Addario",
            'model' => 'XL Nickel .009',
            'gauge' => '0.09',
            'description' => 'Cuerda suelta primera cuerda.',
            'price' => 1.20,
            'stock' => 200,
            'image' => 'images/products/daddario-009.jpg',
        ]);

        Product::create([
            'brand' => "D'Addario",
            'model' => 'XL Nickel .046',
            'gauge' => '0.46',
            'description' => 'Cuerda suelta sexta cuerda.',
            'price' => 1.50,
            'stock' => 200,
            'image' => 'images/products/daddario-046.jpg',
        ]);

        // Ernie Ball
        Product::create([
            'brand' => 'Ernie Ball',
            'model' => 'Regular Slinky',
            'gauge' => '10-46',
            'description' => 'Juego de cuerdas clásico para guitarra eléctrica.',
            'price' => 6.99,
            'stock' => 200,
            'image' => 'images/products/ernieball-regular-slinky.jpg',
        ]);

        Product::create([
            'brand' => 'Ernie Ball',
            'model' => 'Single .010',
            'gauge' => '0.10',
            'description' => 'Cuerda suelta segunda cuerda.',
            'price' => 1.30,
            'stock' => 200,
            'image' => 'images/products/ernieball-010.jpg',
        ]);

        Product::create([
            'brand' => 'Ernie Ball',
            'model' => 'Single .052',
            'gauge' => '0.52',
            'description' => 'Cuerda suelta sexta cuerda gruesa.',
            'price' => 1.70,
            'stock' => 200,
            'image' => 'images/products/ernieball-052.jpg',
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10); // listado con paginación
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand'       => 'required|string|max:255',
            'model'       => 'required|string|max:255',
            'gauge'       => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|string|max:255', // si es path a imagen
        ]);

        Product::create($request->all());

        return redirect()->route('admin.products.index')->with('success', 'Producto creado correctamente.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'brand'       => 'required|string|max:255',
            'model'       => 'required|string|max:255',
            'gauge'       => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|string|max:255',
        ]);

        $product->update($request->all());

        return redirect()->route('admin.products.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Producto eliminado correctamente.');
    }
}

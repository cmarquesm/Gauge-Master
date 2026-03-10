<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()
            ->where('brand', '!=', 'CUSTOM')
            ->where('description', '!=', 'set personalizado creado en la calculadora')
            ->where('gauge', '!=', 'custom');

        // Filters
        if ($request->filled('brand')) {
            $query->where('brand', $request->string('brand'));
        }

        if ($request->filled('material')) {
            // Material is stored in description
            $query->where('description', $request->string('material'));
        }

        if ($request->filled('gauge')) {
            $query->where('gauge', $request->string('gauge'));
        }

        // Sorting
        $sort = $request->string('sort', 'gauge')->toString();
        if ($sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->orderBy('gauge', 'asc')->orderBy('brand', 'asc');
        }

        $products = $query->paginate(24)->withQueryString();

        // Filter options from database (excluding CUSTOM values)
        $brands = Product::query()
            ->select('brand')
            ->distinct()
            ->where('brand', '!=', 'CUSTOM')
            ->orderBy('brand')
            ->pluck('brand');
        
        $materials = Product::query()
            ->select('description')
            ->distinct()
            ->where('description', '!=', 'set personalizado creado en la calculadora')
            ->orderBy('description')
            ->pluck('description');
        
        $gauges = Product::query()
            ->select('gauge')
            ->distinct()
            ->where('gauge', '!=', 'custom')
            ->orderBy('gauge')
            ->pluck('gauge');

        return view('store.index', compact('products', 'brands', 'materials', 'gauges', 'sort'));
    }
}

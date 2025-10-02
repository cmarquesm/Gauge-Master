<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Placeholder para listado de productos
        return view('admin.products.index');
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        // Aquí irá la lógica de guardar producto
        return redirect()->route('admin.products.index')->with('success', 'Producto creado.');
    }

    public function edit($id)
    {
        return view('admin.products.edit');
    }

    public function update(Request $request, $id)
    {
        // Aquí irá la lógica de actualizar producto
        return redirect()->route('admin.products.index')->with('success', 'Producto actualizado.');
    }

    public function destroy($id)
    {
        // Aquí irá la lógica de eliminar producto
        return redirect()->route('admin.products.index')->with('success', 'Producto eliminado.');
    }
}

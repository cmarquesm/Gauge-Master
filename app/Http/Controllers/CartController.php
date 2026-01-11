<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function show(Request $request)
    {
        $userId = $request->user()->id;

        $items = CartItem::with('product')
            ->where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->get();

        $total = 0.0;
        foreach ($items as $ci) {
            if (!$ci->product) continue;
            $total += (float) $ci->product->price * (int) $ci->quantity;
        }

        return view('cart.index', [
            'items' => $items,
            'total' => $total,
        ]);
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'nullable|integer|min:1',
        ]);

        $userId = $request->user()->id;
        $qty = (int) ($data['qty'] ?? 1);

        $item = CartItem::firstOrNew([
            'user_id' => $userId,
            'product_id' => $data['product_id'],
        ]);

        $item->quantity = ((int) ($item->exists ? $item->quantity : 0)) + $qty;
        $item->save();

        return back()->with('success', 'Añadido al carrito.');
    }

    public function addCustomSet(Request $request)
    {
        $validated = $request->validate([
            'manufacturer'   => 'required|string|max:255',
            'material'       => 'required|in:nickel,steel',
            'notes'          => 'required|string',
            'gauges'         => 'required|string',
            'tensions'       => 'required|string',
            'total_tension'  => 'required|numeric',
            'scale'          => 'nullable|numeric',
        ]);

        // Parseo arrays
        $notes = array_map('trim', explode(',', $validated['notes']));
        $gauges = array_map('trim', explode(',', $validated['gauges']));
        $tensions = array_map('trim', explode(',', $validated['tensions']));

        if (count($notes) !== count($gauges) || count($notes) !== count($tensions)) {
            return back()->with('error', 'Datos del set incompletos (notas/calibres/tensiones no cuadran).');
        }

        // Validar que la marca existe con stock
        $brandHasStock = Product::query()
            ->where('brand', $validated['manufacturer'])
            ->where('stock', '>', 0)
            ->exists();

        if (!$brandHasStock) {
            return back()->with('error', 'El fabricante seleccionado no tiene stock.');
        }

        $userId = $request->user()->id;
        $missing = [];

        DB::transaction(function () use ($userId, $validated, $notes, $gauges, $tensions, &$missing) {
            // Limpia posibles restos de un intento previo reciente (opcional)
            // CartItem::where('user_id', $userId)->whereNotNull('meta')->delete();

            foreach ($gauges as $idx => $g) {
                // gauges llega como "0.010" etc
                $gFloat = (float) $g;
                $g3 = number_format($gFloat, 3, '.', '');          // "0.010"
                $gThou = (string) (int) round($gFloat * 1000);     // "10"
                $gDb = preg_replace('/^0\./', '.', $g3); // "0.010" -> ".010"

                $product = Product::query()
                    ->where('brand', $validated['manufacturer'])
                    ->where('stock', '>', 0)
                    ->where(function ($q) use ($g3, $gDb) {
                        $q->where('gauge', $gDb)   // ".010"
                            ->orWhere('gauge', $g3); // "0.010" (por si acaso)
                    })

                    ->orderByDesc('stock')
                    ->first();

                if (!$product) {
                    $missing[] = $g3;
                    continue;
                }

                CartItem::create([
                    'user_id'    => $userId,
                    'product_id' => $product->id,
                    'quantity'   => 1,
                    'meta'       => [
                        'type'             => 'custom_set_string',
                        'note'             => $notes[$idx] ?? null,
                        'tension'          => $tensions[$idx] ?? null,
                        'scale'            => $validated['scale'] ?? null,
                        'set_total_tension' => (float) $validated['total_tension'],
                        'material'         => $validated['material'],
                    ],
                ]);
            }

            // Si falta alguno, abortamos la transacción para que no se añada un set incompleto
            if (!empty($missing)) {
                throw new \RuntimeException('Missing gauges: ' . implode(', ', $missing));
            }
        });

        return redirect()->route('cart.show')->with('success', 'Set añadido al carrito con productos reales.');
    }


    public function remove(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        CartItem::where('user_id', $request->user()->id)
            ->where('product_id', $data['product_id'])
            ->delete();

        return back()->with('success', 'Producto eliminado del carrito.');
    }


    public function place(Request $request)
    {
        $userId = $request->user()->id;

        $cartItems = CartItem::with('product')
            ->where('user_id', $userId)
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->withErrors(['cart' => 'El carrito está vacío.']);
        }

        try {
            $order = DB::transaction(function () use ($userId, $cartItems) {

                $total = 0.0;
                foreach ($cartItems as $ci) {
                    $total += (float) $ci->product->price * (int) $ci->quantity;
                }

                $order = Order::create([
                    'user_id' => $userId,
                    'total' => $total,
                    'status' => 'pending',
                ]);

                foreach ($cartItems as $ci) {
                    $product = Product::query()
                        ->whereKey($ci->product_id)
                        ->lockForUpdate()
                        ->firstOrFail();

                    $qty = (int) $ci->quantity;

                    if ($product->stock < $qty) {
                        throw new \RuntimeException(
                            "Stock insuficiente: {$product->model} · {$product->gauge}"
                        );
                    }

                    $product->decrement('stock', $qty);

                    $order->products()->attach($product->id, [
                        'quantity' => $qty,
                        'price' => (float) $product->price,
                    ]);
                }

                CartItem::where('user_id', $userId)->delete();

                return $order;
            });
        } catch (\RuntimeException $e) {
            return back()->withErrors(['stock' => $e->getMessage()]);
        }

        return redirect()
            ->route('cart.show')
            ->with('success', "Compra realizada. Pedido #{$order->id}");
    }
}

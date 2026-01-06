<div>
  <h2 class="text-lg font-semibold mb-4">Mis pedidos</h2>

  @if($orders->count() === 0)
    <p>No tienes pedidos todavía.</p>
  @else
    <div class="overflow-x-auto">
      <table class="min-w-full border">
        <thead>
          <tr class="border-b">
            <th class="p-2 text-left">ID</th>
            <th class="p-2 text-left">Estado</th>
            <th class="p-2 text-right">Total</th>
            <th class="p-2 text-left">Fecha</th>
          </tr>
        </thead>
        <tbody>
          @foreach($orders as $order)
            <tr class="border-b">
              <td class="p-2">#{{ $order->id }}</td>
              <td class="p-2">{{ $order->status }}</td>
              <td class="p-2 text-right">{{ number_format($order->total, 2) }}</td>
              <td class="p-2">{{ $order->created_at->format('d/m/Y') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="mt-4">
      {{ $orders->links() }}
    </div>
  @endif
</div>

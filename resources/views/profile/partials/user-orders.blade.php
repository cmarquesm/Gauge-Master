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
              <td class="p-2">
                @switch($order->status)
                    @case('paid')
                        <span class="badge bg-primary">Preparando</span>
                        @break
                    @case('shipped')
                        <span class="badge bg-success">Enviado</span>
                        @break
                    @case('cancelled')
                        <span class="badge bg-danger">Cancelado</span>
                        @break
                    @case('completed')
                        <span class="badge bg-success">Completado</span>
                        @break
                    @default
                        <span class="badge bg-secondary">Pendiente</span>
                @endswitch
              </td>
              <td class="p-2 text-right">{{ number_format($order->total, 2) }}</td>
              <td class="p-2">{{ $order->created_at->format('d/m/Y') }}</td>
            </tr>
            {{-- Fila expandible con detalles de productos --}}
            <tr class="border-b bg-gray-50">
              <td colspan="4" class="p-3">
                <div class="text-sm font-semibold mb-2">Productos:</div>
                <div class="flex flex-wrap gap-3">
                  @foreach($order->products as $product)
                    <div class="flex items-center gap-2 bg-white border rounded p-2">
                      @if($product->image)
                        <img src="{{ asset($product->image) }}" 
                             alt="{{ $product->brand }}" 
                             class="h-12 w-auto object-contain">
                      @endif
                      <div class="text-sm">
                        <div class="font-medium">{{ $product->brand }} {{ $product->model }}</div>
                        <div class="text-gray-600">{{ $product->gauge }} · x{{ $product->pivot->quantity }}</div>
                      </div>
                    </div>
                  @endforeach
                </div>
              </td>
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

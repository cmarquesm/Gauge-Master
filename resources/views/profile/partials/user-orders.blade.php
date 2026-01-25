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
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="mt-4">
      {{ $orders->links() }}
    </div>
  @endif
</div>

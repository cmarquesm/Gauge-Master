<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">Mis afinaciones guardadas</h2>
        <p class="mt-1 text-sm text-gray-600">Gestiona tus afinaciones.</p>
    </header>

    @php
        $brands = \App\Models\Product::query()
            ->where('stock', '>', 0)
            ->select('brand')
            ->distinct()
            ->orderBy('brand')
            ->pluck('brand');
    @endphp

    <div class="mt-6 overflow-x-auto">
        @if ($tunings->isEmpty())
            <p class="text-sm text-gray-600">Aún no has guardado afinaciones.</p>
        @else
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left border-b">
                        <th class="py-2 pr-4">Nombre</th>
                        <th class="py-2 pr-4">Notas</th>
                        <th class="py-2 pr-4">Calibres</th>
                        <th class="py-2 pr-4">Tensión total</th>
                        <th class="py-2 pr-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tunings as $tuning)
                        <tr class="border-b">
                            <td class="py-2 pr-4">{{ $tuning->name }}</td>
                            <td class="py-2 pr-4">{{ $tuning->notes }}</td>
                            <td class="py-2 pr-4">{{ $tuning->gauges }}</td>
                            <td class="py-2 pr-4">{{ $tuning->total_tension }}</td>
                            <td class="py-2 pr-4 flex gap-3 items-center">
                                <a href="{{ route('tunings.edit', $tuning) }}" class="text-blue-600 hover:underline">
                                    Editar
                                </a>

                                <form action="{{ route('tunings.destroy', $tuning) }}" method="POST"
                                      onsubmit="return confirm('¿Eliminar esta afinación?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                </form>

                                <button type="button" 
                                    class="text-green-600 hover:underline font-semibold open-buy-modal-btn"
                                    data-tuning='@json($tuning)'>
                                    Comprar Set
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- Modal Añadir set al carrito --}}
    <div id="add-to-cart-modal" class="fixed inset-0 hidden items-center justify-center z-50 bg-black/50 p-4">
        <div class="bg-white w-full max-w-lg rounded-lg shadow-xl p-6 relative">
            <h3 class="text-xl font-semibold mb-4">Añadir set al carrito</h3>
            <p id="modal-tuning-name" class="text-sm text-gray-500 mb-4"></p>

            <form id="add-to-cart-form" method="POST" action="{{ route('cart.custom-set.add') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fabricante</label>
                    <select name="manufacturer" id="cart-manufacturer" class="border rounded p-2 w-full" required>
                        <option value="">Selecciona...</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand }}">{{ $brand }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Material</label>
                    <select name="material" id="cart-material" class="border rounded p-2 w-full" required>
                        <option value="nickel">Níquel</option>
                        <option value="steel">Acero inoxidable</option>
                    </select>
                </div>

                <div class="flex gap-2 justify-end pt-2">
                    <button type="button" id="add-to-cart-cancel" class="px-4 py-2 rounded border hover:bg-gray-100">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700">
                        Añadir
                    </button>
                </div>

                {{-- Payload oculto --}}
                <input type="hidden" name="notes" id="cart-notes">
                <input type="hidden" name="gauges" id="cart-gauges">
                <input type="hidden" name="tensions" id="cart-tensions">
                <input type="hidden" name="total_tension" id="cart-total">
                {{-- scale no está en Tuning, así que lo enviamos null o vacío --}}
                <input type="hidden" name="scale" id="cart-scale" value=""> 
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('add-to-cart-modal');
            const cancelBtn = document.getElementById('add-to-cart-cancel');
            const btns = document.querySelectorAll('.open-buy-modal-btn');

            // Inputs del modal
            const inputNotes = document.getElementById('cart-notes');
            const inputGauges = document.getElementById('cart-gauges');
            const inputTensions = document.getElementById('cart-tensions');
            const inputTotal = document.getElementById('cart-total');
            const tuningNameDisplay = document.getElementById('modal-tuning-name');
            const selectMaterial = document.getElementById('cart-material');

            btns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const data = JSON.parse(btn.getAttribute('data-tuning'));
                    
                    // Rellenar ocultos
                    inputNotes.value = data.notes;
                    inputGauges.value = data.gauges;
                    inputTensions.value = data.tensions;
                    inputTotal.value = data.total_tension;

                    // Mostrar info visual
                    tuningNameDisplay.textContent = `Afinación: ${data.name}`;

                    // Preseleccionar material si existe en el objeto tuning
                    if (data.material) {
                         // Intentar matchear value
                         selectMaterial.value = data.material;
                    }

                    // Mostrar modal
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                });
            });

            cancelBtn.addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });

            // Cerrar al hacer click fuera
            modal.addEventListener('click', (e) => {
                if(e.target === modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }
            });
        });
    </script>
</section>

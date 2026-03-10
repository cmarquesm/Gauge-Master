@extends('layouts.main')

@section('content')
<style>
    /* Amplifier Textures */
    .amp-cabinet {
        background-color: #1a1a1a;
        background-image: radial-gradient(#2a2a2a 1px, transparent 1px);
        background-size: 3px 3px;
        border: 12px solid #111;
        box-shadow: inset 0 0 50px rgba(0,0,0,0.8), 0 20px 40px rgba(0,0,0,0.4);
        position: relative;
    }

    .amp-panel {
        background: linear-gradient(180deg, #e5e7eb 0%, #d1d5db 50%, #9ca3af 100%);
        box-shadow: inset 0 2px 4px rgba(255,255,255,0.8), inset 0 -2px 4px rgba(0,0,0,0.2);
        border-bottom: 2px solid #4b5563;
        position: relative;
        overflow: hidden;
    }

    .amp-panel::after {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: repeating-linear-gradient(0deg, transparent, transparent 1px, rgba(0,0,0,0.05) 1px, rgba(0,0,0,0.05) 2px);
        pointer-events: none;
    }

    .amp-grill {
        background-color: #1a1a1a;
        background-image: 
            linear-gradient(45deg, #333 25%, transparent 25%), 
            linear-gradient(-45deg, #333 25%, transparent 25%), 
            linear-gradient(45deg, transparent 75%, #333 75%), 
            linear-gradient(-45deg, transparent 75%, #333 75%);
        background-size: 4px 4px;
        background-position: 0 0, 0 2px, 2px 2px, 2px 0;
        border-top: 4px solid #000;
    }

    /* Knob Controls */
    .knob-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }

    .knob-label {
        font-family: 'Courier New', Courier, monospace;
        font-weight: bold;
        font-size: 0.75rem;
        color: #1e3a8a; /* Azul oscuro/turquesa */
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }

    .knob-input {
        appearance: none;
        background: #111;
        border: 4px solid #333;
        border-radius: 50%;
        width: 64px;
        height: 64px;
        color: white;
        text-align: center;
        font-weight: bold;
        box-shadow: 0 4px 6px rgba(0,0,0,0.3), inset 0 2px 4px rgba(255,255,255,0.1);
        cursor: pointer;
        transition: transform 0.2s;
    }

    .knob-input:focus {
        outline: none;
        border-color: #1e40af;
        transform: scale(1.05);
    }

    select.knob-input {
        padding: 0;
        text-align-last: center;
        font-size: 0.7rem;
    }

    /* Footswitch Button */
    .footswitch-btn {
        width: 80px;
        height: 80px;
        background: radial-gradient(circle at 30% 30%, #f3f4f6, #9ca3af 60%, #4b5563);
        border-radius: 50%;
        border: 4px solid #374151;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.4), inset 0 -4px 6px rgba(0,0,0,0.2);
        position: relative;
        cursor: pointer;
        transition: all 0.1s;
    }

    .footswitch-btn:active {
        transform: translateY(4px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.4);
    }

    .footswitch-btn::after {
        content: "";
        position: absolute;
        top: 15%; left: 15%; right: 15%; bottom: 15%;
        border-radius: 50%;
        background: radial-gradient(circle, #e5e7eb, #9ca3af);
        border: 2px solid #6b7280;
    }

    /* Digital Display */
    .digital-display {
        background-color: #061006;
        border: 3px solid #1a1a1a;
        padding: 1rem;
        border-radius: 4px;
        color: #4ade80;
        font-family: 'Courier New', Courier, monospace;
        text-shadow: 0 0 10px rgba(74, 222, 128, 0.5);
    }

    .corner-metal {
        position: absolute;
        width: 40px;
        height: 40px;
        background: #4b5563;
        border-radius: 50%;
        z-index: 10;
    }
    .corner-tl { top: -15px; left: -15px; }
    .corner-tr { top: -15px; right: -15px; }
    .corner-bl { bottom: -15px; left: -15px; }
    .corner-br { bottom: -15px; right: -15px; }

</style>

<div class="max-w-4xl mx-auto my-12">
    <script>
        window.isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
        window.loginUrl = "{{ route('login') }}";
    </script>

    <div class="amp-cabinet rounded-xl p-4 sm:p-8">
        <!-- Corner Protectors -->
        <div class="corner-metal corner-tl"></div>
        <div class="corner-metal corner-tr"></div>
        <div class="corner-metal corner-bl"></div>
        <div class="corner-metal corner-br"></div>

        <!-- Upper Panel (Logo and Light) -->
        <div class="amp-panel rounded-t-lg p-6 flex flex-col items-center border-b-4 border-gray-400">
            <div class="flex justify-between w-full items-start">
                <div class="flex-1"></div>
                <div class="flex-1 flex flex-col items-center">
                    <img src="{{ asset('images/LOGO editar.png') }}" alt="Logo" class="h-20 w-auto mb-2 opacity-90">
                </div>
                <div class="flex-1 flex justify-end">
                    <div class="w-8 h-8 rounded-full bg-red-600 border-4 border-gray-400 shadow-[0_0_15px_rgba(220,38,38,0.8)] animate-pulse"></div>
                </div>
            </div>
        </div>

        <!-- Controls Panel -->
        <div class="amp-panel p-8 grid grid-cols-2 md:grid-cols-4 gap-8 items-end">
            <div class="knob-container">
                <span class="knob-label">Afinación</span>
                <select id="preset-tuning" class="knob-input text-xs">
                    <option value="E_standard" selected>E Estándar</option>
                    <option value="Drop_D">Drop D</option>
                    <option value="Drop_B">Drop B</option>
                    <option value="Open_D">Open D</option>
                </select>
            </div>

            <div class="knob-container">
                <span class="knob-label text-indigo-900 mb-2">Control Escala</span>
                <!-- Fluid Oval Display -->
                <div class="bg-black rounded-[100%_/_100%] border-2 border-gray-600 shadow-md flex flex-col items-center justify-center w-44 h-16 p-2 relative">
                    <div class="flex items-center justify-around w-full px-2">
                        <button type="button" onclick="const s = document.getElementById('scale'); s.stepDown(); s.dispatchEvent(new Event('change'))" 
                                class="text-gray-500 hover:text-white text-xl font-bold transition-colors w-6">-</button>
                        
                        <input type="number" id="scale" value="25.5" step="0.1" min="20" max="30" 
                               class="bg-transparent text-white text-xl font-normal text-center w-20 border-none focus:ring-0 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                        
                        <button type="button" onclick="const s = document.getElementById('scale'); s.stepUp(); s.dispatchEvent(new Event('change'))" 
                                class="text-gray-500 hover:text-white text-xl font-bold transition-colors w-6">+</button>
                    </div>
                    <span class="text-[0.6rem] uppercase font-mono font-bold tracking-widest text-gray-500 leading-none mt-1">Pulgadas</span>
                </div>
            </div>

            <div class="knob-container">
                <span class="knob-label">Material</span>
                <select id="calc-material" class="knob-input text-xs">
                    <option value="nickel" selected>Níquel</option>
                    <option value="steel">Acero</option>
                </select>
            </div>

            <div class="knob-container">
                <span class="knob-label">Tensión</span>
                <select id="tension" class="knob-input text-xs">
                    <option value="ligera">Ligera</option>
                    <option value="media" selected>Media</option>
                    <option value="alta">Alta</option>
                </select>
            </div>
        </div>

        <!-- Action Area (Footswitch) -->
        <div class="amp-panel p-8 flex justify-center items-center gap-12 bg-opacity-90">
            <div class="flex flex-col items-center gap-2">
                <span class="knob-label text-indigo-900">Calcular</span>
                <button id="calc-btn" class="footswitch-btn"></button>
            </div>
            
            <div class="digital-display flex flex-col items-center min-w-[200px]">
                <span class="text-[0.6rem] uppercase tracking-tighter opacity-70 mb-1">Tensión Total</span>
                <div class="text-3xl font-bold flex items-baseline gap-1">
                    <span id="total-tension">0</span>
                    <span class="text-sm opacity-50">lb</span>
                </div>
            </div>
        </div>

        <!-- Results Grid -->
        <div class="amp-grill rounded-b-lg p-6 min-h-[300px]">
            
            <div class="overflow-x-auto">
                <table class="w-full bg-black bg-opacity-60 text-green-400 font-mono text-sm border-separate border-spacing-1">
                    <thead>
                        <tr class="text-[0.6rem] uppercase opacity-70 text-gray-400">
                            <th class="p-2 border border-gray-800">#</th>
                            <th class="p-2 border border-gray-800">Nota</th>
                            <th class="p-2 border border-gray-800">Calibre (in)</th>
                            <th class="p-2 border border-gray-800">Tensión (lb)</th>
                        </tr>
                    </thead>
                    <tbody id="string-rows">
                        <!-- JS generated rows -->
                    </tbody>
                </table>
            </div>

            <!-- Secondary Action Buttons -->
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <button type="button" id="save-tuning-btn" class="px-4 py-2 bg-gray-800 text-gray-400 border border-gray-700 rounded text-xs uppercase hover:bg-gray-700 transition">
                    Guardar Config
                </button>
                <button type="button" id="add-to-cart-btn" class="px-4 py-2 bg-indigo-900 text-indigo-200 border border-indigo-700 rounded text-xs uppercase hover:bg-indigo-800 transition">
                    Comprar Set
                </button>
            </div>
        </div>
    </div>

    <!-- Hidden Panels -->
    <div id="save-tuning-panel" class="hidden mt-6 amp-cabinet p-6 rounded-lg">
        <h3 class="text-xl font-bold text-gray-300 mb-4 font-mono uppercase">Guardar Ajuste</h3>
        <form id="save-tuning-form" method="POST" action="{{ route('tunings.store') }}" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="grid grid-cols-1 gap-4">
                <input type="text" name="name" id="tuning-name" required class="bg-black text-green-400 border border-gray-800 p-2 rounded font-mono w-full" placeholder="Nombre del Ajuste">
            </div>

            <textarea name="description" id="tuning-description" rows="2" class="w-full bg-black text-green-400 border border-gray-800 p-2 rounded font-mono" placeholder="Descripción"></textarea>

            <input type="hidden" name="notes" id="tuning-notes">
            <input type="hidden" name="gauges" id="tuning-gauges">
            <input type="hidden" name="tensions" id="tuning-tensions">
            <input type="hidden" name="total_tension" id="tuning-total">
            <input type="hidden" name="material" id="tuning-material">

            <div class="flex justify-end gap-3">
                <button type="submit" class="px-6 py-2 bg-green-900 text-green-200 rounded uppercase text-xs font-bold hover:bg-green-800 transition">Confirmar Guardado</button>
            </div>
        </form>
    </div>

    {{-- Add set to cart modal --}}
    <div id="add-to-cart-modal" class="fixed inset-0 hidden items-center justify-center bg-black/80 z-[100] p-4">
        <div class="amp-cabinet w-full max-w-lg rounded-lg p-6">
            <h3 class="text-xl font-bold text-gray-300 mb-6 font-mono uppercase border-b border-gray-800 pb-2">Finalizar Set Personalizado</h3>

            <form id="add-to-cart-form" method="POST" action="{{ route('cart.custom-set.add') }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 gap-4">
                    <div class="flex flex-col">
                        <label class="text-xs uppercase text-gray-500 font-mono mb-1">Fabricante</label>
                        <select name="manufacturer" id="cart-manufacturer-modal" class="bg-black text-green-400 border border-gray-800 p-2 rounded font-mono" required>
                            <option value="">Seleccionar...</option>
                            <option value="Daddario">Daddario</option>
                            <option value="Ernie Ball">Ernie Ball</option>
                        </select>
                    </div>

                    <div class="flex flex-col">
                        <label class="text-xs uppercase text-gray-500 font-mono mb-1">Material</label>
                        <select name="material" id="cart-material-modal" class="bg-black text-green-400 border border-gray-800 p-2 rounded font-mono" required>
                            <option value="nickel">Níquel</option>
                            <option value="steel">Acero Inoxidable</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-4 justify-end mt-8">
                    <button type="button" id="add-to-cart-cancel" class="px-4 py-2 border border-gray-700 text-gray-500 rounded uppercase text-xs font-bold hover:bg-gray-800 transition">
                        Cancelar
                    </button>
                    <button type="submit" class="px-6 py-2 bg-indigo-900 text-indigo-200 rounded uppercase text-xs font-bold hover:bg-indigo-800 transition">
                        Añadir al Carrito
                    </button>
                </div>

                <input type="hidden" name="notes" id="cart-notes">
                <input type="hidden" name="gauges" id="cart-gauges">
                <input type="hidden" name="tensions" id="cart-tensions">
                <input type="hidden" name="total_tension" id="cart-total">
                <input type="hidden" name="scale" id="cart-scale">
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@vite(['resources/js/calculator.js'])
@endsection
@extends('layouts.main')

@section('content')
    <section class="text-center">
        <h2 class="text-3xl font-semibold mb-4">Calculadora de Calibres</h2>
        <p class="text-gray-600 mb-8">Calcula el calibre ideal según escala y afinación.</p>

        <div id="calculator" class="bg-white rounded-lg shadow p-6 max-w-3xl mx-auto text-left">

            {{-- Bloque 1: Parámetros globales --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <label>
                    Escala (pulgadas):
                    <input type="number" id="scale" value="25.5" step="0.1" min="20" max="30"
                        class="border rounded p-2 w-full">
                </label>

                <label>
                    Tensión objetivo:
                    <select id="tension" class="border rounded p-2 w-full">
                        <option value="ligera">Ligera</option>
                        <option value="media" selected>Media</option>
                        <option value="alta">Alta</option>
                    </select>
                </label>

                <label>
                    Afinación predefinida:
                    <select id="preset-tuning" class="border rounded p-2 w-full">
                        <option value="E_standard" selected>E estándar (E2–E4)</option>
                        <option value="Drop_D">Drop D (D2–D4)</option>
                        <option value="Drop_B">Drop B (B1–B3)</option>
                        <option value="Open_D">Open D (D2–A2–D3–F#3–A3–D4)</option>
                    </select>
                </label>

                <label>
                    Material:
                    <select id="material" class="border rounded p-2 w-full">
                        <option value="nickel" selected>Níquel</option>
                        <option value="steel">Acero inoxidable</option>
                    </select>
                </label>
            </div>
            {{-- Bloque Resultado --}}
            <h3 class="text-xl font-semibold mb-2">Resultado</h3>
            <div id="strings" class="overflow-x-auto mb-4">
                <table class="w-full border text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2 border">#</th>
                            <th class="p-2 border">Nota</th>
                            <th class="p-2 border">Calibre (in)</th>
                            <th class="p-2 border">Tensión (lb)</th>
                        </tr>
                    </thead>
                    <tbody id="string-rows">
                        {{-- Filas generadas por JS --}}
                    </tbody>
                </table>
            </div>

            {{-- Bloque Guardar afinación --}}
            <div id="save-tuning" class="mt-8 border-t pt-6">
                <h3 class="text-xl font-semibold mb-3">Guardar afinación</h3>

                <form id="save-tuning-form" method="POST" action="{{ route('tunings.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                        <input type="text" name="name" id="tuning-name" required class="border rounded p-2 w-full"
                            placeholder="Ej. Drop D ligera 25.5&quot;">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Material</label>
                        <select name="material" id="material" class="border rounded p-2 w-full">
                            <option value="nickel" selected>Níquel</option>
                            <option value="steel">Acero inoxidable</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                        <textarea name="description" id="tuning-description" rows="3" class="border rounded p-2 w-full"></textarea>
                    </div>

                    <input type="hidden" name="notes" id="tuning-notes">
                    <input type="hidden" name="gauges" id="tuning-gauges">
                    <input type="hidden" name="tensions" id="tuning-tensions">
                    <input type="hidden" name="total_tension" id="tuning-total">

                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Guardar afinación</button>
                </form>
            </div>


            <div class="flex justify-between items-center">
                <button id="calc-btn" class="bg-blue-600 text-white px-4 py-2 rounded">Calcular</button>
                <p class="text-gray-700"><strong>Tensión total:</strong> <span id="total-tension">0</span> lb</p>
            </div>


        </div>
    </section>
@endsection
@section('scripts')
    @vite(['resources/js/calculator.js'])
@endsection

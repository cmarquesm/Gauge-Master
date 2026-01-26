@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto space-y-12">
    <!-- Sección Principal -->
    <section class="text-center">
        <div class="flex justify-center mb-6">
            <img src="{{ asset('images/LOGO editar.png') }}" alt="Gauge Master Logo" class="h-24 w-auto drop-shadow-sm">
        </div>
        <h2 class="text-3xl font-semibold mb-4 text-gray-800">Sobre Gauge Master</h2>
        <p class="text-gray-700 leading-relaxed text-lg max-w-2xl mx-auto">
            Gauge Master es una aplicación para músicos y luthiers. Permite calcular tensiones y calibres
            según escala y afinación, guardar tus configuraciones y comprar cuerdas adaptadas.
        </p>
    </section>

    <!-- Sección sobre la Importancia del Calibre -->
    <section class="bg-gray-50 rounded-lg p-8 shadow-sm">
        <h3 class="text-2xl font-semibold mb-6 text-gray-800">La Importancia de Elegir el Calibre Correcto</h3>
        
        <div class="space-y-6 text-gray-700 leading-relaxed">
            <p>
                El calibre de las cuerdas es uno de los factores más importantes para lograr el sonido y la sensación 
                ideal en tu guitarra. Elegir el calibre adecuado no es solo una cuestión de preferencia personal, sino 
                una decisión técnica que afecta directamente a la <strong>tensión</strong>, el <strong>tono</strong> y 
                la <strong>tocabilidad</strong> del instrumento.
            </p>

            <div class="bg-white rounded-lg p-6 border-l-4 border-blue-500">
                <h4 class="font-semibold text-lg mb-3 text-gray-800">¿Por qué es tan importante la tensión?</h4>
                <p class="mb-3">
                    La tensión de las cuerdas determina cómo responde tu guitarra. Una tensión inadecuada puede causar:
                </p>
                <ul class="list-disc list-inside space-y-2 ml-4">
                    <li><strong>Problemas de afinación:</strong> Cuerdas demasiado flojas pueden desafinar fácilmente</li>
                    <li><strong>Trasteo:</strong> Tensión insuficiente hace que las cuerdas vibren contra los trastes</li>
                    <li><strong>Fatiga al tocar:</strong> Cuerdas muy tensas requieren más fuerza y cansan los dedos</li>
                    <li><strong>Daños al instrumento:</strong> Tensión excesiva puede deformar el mástil o dañar el puente</li>
                </ul>
            </div>

            <div class="bg-white rounded-lg p-6 border-l-4 border-green-500">
                <h4 class="font-semibold text-lg mb-3 text-gray-800">Calibre y Afinación: Una Relación Fundamental</h4>
                <p class="mb-3">
                    Cada afinación requiere un calibre específico para mantener la tensión óptima. Por ejemplo:
                </p>
                <ul class="list-disc list-inside space-y-2 ml-4">
                    <li><strong>Afinaciones estándar (E, A, D, G, B, E):</strong> Calibres .009-.042 o .010-.046 son ideales</li>
                    <li><strong>Afinaciones graves (Drop D, Drop C):</strong> Requieren calibres más gruesos (.011-.052 o superiores)</li>
                    <li><strong>Afinaciones agudas:</strong> Pueden usar calibres más finos para evitar tensión excesiva</li>
                </ul>
                <p class="mt-3">
                    Usar el calibre incorrecto para tu afinación puede resultar en cuerdas demasiado flojas (perdiendo 
                    definición y sustain) o demasiado tensas (dificultando la ejecución y arriesgando el instrumento).
                </p>
            </div>

            <div class="bg-white rounded-lg p-6 border-l-4 border-purple-500">
                <h4 class="font-semibold text-lg mb-3 text-gray-800">Gauge Master: Tu Calculadora de Precisión</h4>
                <p>
                    Con Gauge Master, puedes calcular exactamente qué calibre necesitas según tu escala y afinación preferida. 
                    La aplicación te ayuda a encontrar el equilibrio perfecto entre tensión, tono y comodidad, permitiéndote 
                    experimentar con diferentes configuraciones y guardar tus favoritas. Además, puedes comprar directamente 
                    los juegos de cuerdas personalizados que necesitas.
                </p>
            </div>

            <p class="text-center italic text-gray-600 pt-4">
                "El calibre correcto no solo mejora tu sonido, sino que protege tu instrumento y hace que tocar sea un placer."
            </p>
        </div>
    </section>
</div>
@endsection

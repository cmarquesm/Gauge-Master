@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto space-y-12">
    <!-- Tools Section -->
    <section class="space-y-8 bg-white rounded-xl p-8 border border-gray-100 shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Afinador Cromático -->
            <div class="bg-gray-50 rounded-xl p-6 shadow-sm border border-gray-100 flex flex-col items-center text-center">
                <div class="mb-4">
                    <span class="text-xs uppercase font-bold tracking-widest text-indigo-600">Chromatic Tuner</span>
                    <h4 class="text-lg font-bold text-gray-800">440Hz</h4>
                </div>
                
                <!-- Tuner Display -->
                <div class="relative w-48 h-48 flex items-center justify-center mb-6">
                    <svg class="absolute inset-0 w-full h-full -rotate-90" viewBox="0 0 100 100">
                        <circle cx="50" cy="50" r="45" fill="none" stroke="#e1e2e6" stroke-width="8" />
                        <circle id="tuner-gauge" cx="50" cy="50" r="45" fill="none" stroke="#4f46e5" stroke-width="8" 
                                stroke-dasharray="283" stroke-dashoffset="283" class="transition-all duration-100 ease-out" />
                    </svg>
                    <div class="flex flex-col items-center">
                        <span id="tuner-note" class="text-6xl font-black text-gray-800">--</span>
                        <span id="tuner-cents" class="text-sm font-mono text-gray-500 mt-1">0 cents</span>
                    </div>
                    <!-- Needle overlay -->
                    <div id="tuner-needle" class="absolute top-1/2 left-1/2 w-1 h-20 bg-red-500 -mt-20 origin-bottom transition-transform duration-100" style="transform: rotate(0deg)"></div>
                </div>

                <div class="w-full h-1 bg-gray-200 rounded-full relative mb-6 overflow-hidden">
                    <div id="tuner-bar" class="absolute h-full bg-green-500 left-1/2 -translate-x-1/2 transition-all duration-75" style="width: 0%"></div>
                </div>

                <button id="tuner-start" type="button" class="w-auto px-6 py-2 bg-black hover:bg-gray-800 text-white rounded-lg font-bold text-sm transition shadow-md flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7 4a3 3 0 016 0v4a3 3 0 11-6 0V4zm4 10.93A7.001 7.001 0 0017 8a1 1 0 10-2 0A5 5 0 015 8a1 1 0 00-2 0 7.001 7.001 0 006 6.93V17H6a1 1 0 100 2h8a1 1 0 100-2h-3v-2.07z" clip-rule="evenodd" />
                    </svg>
                    Iniciar Micrófono
                </button>
            </div>

            <!-- Note Player -->
            <div class="bg-gray-50 rounded-xl p-6 shadow-sm border border-gray-100 flex flex-col items-center text-center">
                <div class="mb-4">
                    <span class="text-xs uppercase font-bold tracking-widest text-green-600">Standard Guitar Tune Ref</span>
                </div>

                <div class="grid grid-cols-3 gap-3 w-full mb-6">
                    <button type="button" onclick="playNote(82.41, 'E2')" class="note-btn p-4 bg-white border-2 border-gray-100 rounded-lg hover:border-black hover:bg-gray-50 transition flex flex-col items-center group">
                        <span class="text-xs text-gray-500 group-hover:text-black">6ª</span>
                        <span class="text-xl font-bold">E2</span>
                    </button>
                    <button type="button" onclick="playNote(110.00, 'A2')" class="note-btn p-4 bg-white border-2 border-gray-100 rounded-lg hover:border-black hover:bg-gray-50 transition flex flex-col items-center group">
                        <span class="text-xs text-gray-500 group-hover:text-black">5ª</span>
                        <span class="text-xl font-bold">A2</span>
                    </button>
                    <button type="button" onclick="playNote(146.83, 'D3')" class="note-btn p-4 bg-white border-2 border-gray-100 rounded-lg hover:border-black hover:bg-gray-50 transition flex flex-col items-center group">
                        <span class="text-xs text-gray-500 group-hover:text-black">4ª</span>
                        <span class="text-xl font-bold">D3</span>
                    </button>
                    <button type="button" onclick="playNote(196.00, 'G3')" class="note-btn p-4 bg-white border-2 border-gray-100 rounded-lg hover:border-black hover:bg-gray-50 transition flex flex-col items-center group">
                        <span class="text-xs text-gray-500 group-hover:text-black">3ª</span>
                        <span class="text-xl font-bold">G3</span>
                    </button>
                    <button type="button" onclick="playNote(246.94, 'B3')" class="note-btn p-4 bg-white border-2 border-gray-100 rounded-lg hover:border-black hover:bg-gray-50 transition flex flex-col items-center group">
                        <span class="text-xs text-gray-500 group-hover:text-black">2ª</span>
                        <span class="text-xl font-bold">B3</span>
                    </button>
                    <button type="button" onclick="playNote(329.63, 'E4')" class="note-btn p-4 bg-white border-2 border-gray-100 rounded-lg hover:border-black hover:bg-gray-50 transition flex flex-col items-center group">
                        <span class="text-xs text-gray-500 group-hover:text-black">1ª</span>
                        <span class="text-xl font-bold">E4</span>
                    </button>
                </div>

                <div class="w-full p-4 bg-white rounded-lg border border-gray-100 italic text-[0.65rem] sm:text-xs text-gray-500">
                    Sintetización: Karplus-Strong
                </div>
            </div>
        </div>
    </section>

    <!-- Main Section -->
    <section class="text-center pt-8">
        <div class="flex justify-center mb-6">
            <img src="{{ asset('images/LOGO editar.png') }}" alt="Gauge Master Logo" class="h-20 w-auto drop-shadow-sm opacity-80">
        </div>
        <h2 class="text-3xl font-semibold mb-4 text-gray-800 uppercase tracking-tight">Sobre Gauge Master</h2>
        <p class="text-gray-600 leading-relaxed text-lg max-w-2xl mx-auto italic">
            Gauge Master es una aplicación para músicos y luthiers. Permite calcular tensiones y calibres
            según escala y afinación, guardar tus configuraciones y comprar cuerdas adaptadas.
        </p>
    </section>

    <!-- Gauge Importance Section -->
    <section class="bg-gray-50 rounded-lg p-8 shadow-sm">
        <h3 class="text-2xl font-semibold mb-6 text-gray-800">La Importancia de Elegir el Calibre Correcto</h3>
        
        <div class="space-y-6 text-gray-700 leading-relaxed">
            <p>
                El calibre de las cuerdas es uno de los factores más importantes para lograr el sonido y la sensación 
                ideal en tu guitarra. Elegir el calibre adecuado no es solo una cuestión de preferencia personal, sino 
                una decisión técnica que afecta directamente a la <strong>tensión</strong>, el <strong>tono</strong> y 
                la <strong>tocabilidad</strong> del instrumento.
            </p>

            <div class="bg-white rounded-lg p-6 border-l-4 border-black">
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

            <div class="bg-white rounded-lg p-6 border-l-4 border-black">
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

            <div class="bg-white rounded-lg p-6 border-l-4 border-black">
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



    <script>
        // TUNER LOGIC
        let audioCtx;
        let analyser;
        let microphone;
        let isTuning = false;

        const tunerNote = document.getElementById('tuner-note');
        const tunerCents = document.getElementById('tuner-cents');
        const tunerNeedle = document.getElementById('tuner-needle');
        const tunerStart = document.getElementById('tuner-start');

        const notes = ["C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B"];

        async function startTuning() {
            if (isTuning) return;
            
            console.log("Iniciando afinador...");
            tunerStart.textContent = "Conectando...";
            
            try {
                // Polyfill for older browsers
                if (navigator.mediaDevices === undefined) {
                    navigator.mediaDevices = {};
                }
                if (navigator.mediaDevices.getUserMedia === undefined) {
                    navigator.mediaDevices.getUserMedia = function(constraints) {
                        const getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
                        if (!getUserMedia) {
                            return Promise.reject(new Error('getUserMedia no está implementado en este navegador o entorno (¿Página no segura?)'));
                        }
                        return new Promise(function(resolve, reject) {
                            getUserMedia.call(navigator, constraints, resolve, reject);
                        });
                    }
                }

                if (!audioCtx) {
                    audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                }

                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                console.log("Acceso al micrófono concedido.");
                
                if (audioCtx.state === 'suspended') {
                    await audioCtx.resume();
                }
                
                microphone = audioCtx.createMediaStreamSource(stream);
                analyser = audioCtx.createAnalyser();
                analyser.fftSize = 2048;
                microphone.connect(analyser);
                
                isTuning = true;
                tunerStart.disabled = true;
                tunerStart.classList.add('opacity-50', 'cursor-not-allowed');
                tunerStart.textContent = "Escuchando...";
                updateTuner();
            } catch (err) {
                console.error("No se pudo acceder al micrófono:", err);
                tunerStart.textContent = "Error Micrófono";
                
                let msg = "No se pudo acceder al micrófono. ";
                if (window.isSecureContext === false) {
                    msg += "\n\nIMPORTANTE: El navegador bloquea el micrófono en páginas 'no seguras'. \n\nPara que funcione localmente, usa: \nhttp://localhost/... \no habilita SSL (HTTPS) en Laragon.";
                } else {
                    msg += "\nError: " + err.message;
                }
                alert(msg);
            }
        }

        function updateTuner() {
            if (!isTuning) return;
            const buffer = new Float32Array(analyser.fftSize);
            analyser.getFloatTimeDomainData(buffer);
            const freq = autoCorrelate(buffer, audioCtx.sampleRate);

            if (freq !== -1) {
                const noteInfo = getNoteFromFreq(freq);
                tunerNote.textContent = noteInfo.note;
                tunerCents.textContent = `${noteInfo.cents > 0 ? '+' : ''}${Math.round(noteInfo.cents)} cents`;
                
                // Needle animation (limited to +/- 50 cents)
                const rot = Math.max(-50, Math.min(50, noteInfo.cents));
                tunerNeedle.style.transform = `rotate(${rot}deg)`;
                
                // Precision color coding
                tunerNote.style.color = Math.abs(noteInfo.cents) < 5 ? '#10b981' : '#1f2937';
            }
            requestAnimationFrame(updateTuner);
        }

        function autoCorrelate(buf, sampleRate) {
            let SIZE = buf.length;
            let rms = 0;
            for (let i = 0; i < SIZE; i++) rms += buf[i] * buf[i];
            rms = Math.sqrt(rms / SIZE);
            if (rms < 0.01) return -1;

            let r1 = 0, r2 = SIZE - 1, thres = 0.2;
            for (let i = 0; i < SIZE / 2; i++) if (Math.abs(buf[i]) < thres) { r1 = i; break; }
            for (let i = 1; i < SIZE / 2; i++) if (Math.abs(buf[SIZE - i]) < thres) { r2 = SIZE - i; break; }
            buf = buf.slice(r1, r2);
            SIZE = buf.length;

            let c = new Float32Array(SIZE);
            for (let i = 0; i < SIZE; i++)
                for (let j = 0; j < SIZE - i; j++)
                    c[i] = c[i] + buf[j] * buf[j + i];

            let d = 0; while (c[d] > c[d + 1]) d++;
            let maxval = -1, maxpos = -1;
            for (let i = d; i < SIZE; i++) {
                if (c[i] > maxval) {
                    maxval = c[i];
                    maxpos = i;
                }
            }
            let T0 = maxpos;
            return sampleRate / T0;
        }

        function getNoteFromFreq(frequency) {
            const noteNum = 12 * (Math.log(frequency / 440) / Math.log(2));
            const rolledOut = Math.round(noteNum) + 69;
            const noteIndex = rolledOut % 12;
            const cents = (noteNum - Math.round(noteNum)) * 100;
            return { note: notes[noteIndex], cents: cents };
        }

        tunerStart.addEventListener('click', startTuning);

        // NOTE PLAYER LOGIC
        function playNote(freq) {
            if (!audioCtx) audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            if (audioCtx.state === 'suspended') audioCtx.resume();

            const duration = 2.0;
            const sampleRate = audioCtx.sampleRate;
            const bufferSize = audioCtx.sampleRate * duration;
            const buffer = audioCtx.createBuffer(1, bufferSize, sampleRate);
            const data = buffer.getChannelData(0);

            // Karplus-Strong Algorithm
            const period = Math.round(sampleRate / freq);
            let delayLine = new Float32Array(period);
            for (let i = 0; i < period; i++) delayLine[i] = Math.random() * 2 - 1;

            for (let i = 0; i < bufferSize; i++) {
                data[i] = delayLine[i % period];
                delayLine[i % period] = 0.996 * (delayLine[i % period] + delayLine[(i + 1) % period]) / 2;
            }

            const source = audioCtx.createBufferSource();
            source.buffer = buffer;
            const gain = audioCtx.createGain();
            gain.gain.setValueAtTime(0.5, audioCtx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + duration);
            
            source.connect(gain);
            gain.connect(audioCtx.destination);
            source.start();
        }
    </script>
</div>
@endsection


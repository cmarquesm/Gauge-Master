<div 
    x-data="{ 
        open: false, 
        message: '', 
        messages: [], 
        isLoading: false,
        toggle() { this.open = !this.open },
        async sendMessage() {
            if (!this.message.trim()) return;
            
            const userMsg = this.message;
            this.messages.push({ sender: 'user', text: userMsg });
            this.message = '';
            this.isLoading = true;

            // Capturar contexto de la calculadora si está disponible
            const context = this.captureCalculatorContext();

            try {
                const response = await fetch('/api/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ 
                        message: userMsg,
                        context: context
                    })
                });

                if (!response.ok) throw new Error('Network error');

                const data = await response.json();
                this.messages.push({ sender: 'bot', text: data.reply });
            } catch (error) {
                this.messages.push({ sender: 'bot', text: 'Error: No se pudo contactar con Caribou AI.' });
                console.error(error);
            } finally {
                this.isLoading = false;
                // Scroll to bottom
                this.$nextTick(() => {
                    const container = this.$refs.chatContainer;
                    container.scrollTop = container.scrollHeight;
                });
            }
        },
        formatMessage(text) {
            if (!text) return '';
            // Reemplazar **texto** por <b>texto</b>
            let formatted = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            // Reemplazar saltos de línea por <br>
            formatted = formatted.replace(/\n/g, '<br>');
            return formatted;
        },
        captureCalculatorContext() {
            // Intentar capturar valores de la calculadora
            const scaleInput = document.getElementById('scale');
            const presetTuning = document.getElementById('preset-tuning');
            const totalTensionEl = document.getElementById('total-tension');
            const gaugeInputs = document.querySelectorAll('.calibre-input');
            
            // Si no hay calculadora en la página, retornar null
            if (!scaleInput || !presetTuning || !totalTensionEl) {
                return null;
            }

            // Capturar calibres actuales
            const gauges = Array.from(gaugeInputs).map(input => input.value).join(', ');

            // Obtener nombre legible de la afinación
            const tuningMap = {
                'E_standard': 'E estándar',
                'Drop_D': 'Drop D',
                'Drop_B': 'Drop B',
                'Open_D': 'Open D'
            };

            return {
                scale_length: scaleInput.value,
                tuning_name: tuningMap[presetTuning.value] || presetTuning.value,
                total_tension: totalTensionEl.textContent,
                string_gauges: gauges
            };
        }
    }"
    class="fixed bottom-5 right-5 z-50 flex flex-col items-end"
>
    <!-- Chat Window -->
    <div 
        x-show="open" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        class="mb-4 w-[90vw] sm:w-[500px] bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden flex flex-col h-[600px] max-h-[80vh]"
        style="display: none;"
    >
        <div class="bg-indigo-600 p-4 text-white flex justify-between items-center">
            <h3 class="font-bold flex items-center gap-2">
                <img src="{{ asset('images/caribou-logo.png') }}" alt="Logo Caribou" class="h-6 w-6 rounded-full bg-white p-0.5">
                Caribou AI
            </h3>
            <button @click="toggle" class="hover:bg-indigo-700 rounded p-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <!-- Messages -->
        <div x-ref="chatContainer" class="flex-1 overflow-y-auto p-4 space-y-3 bg-gray-50 dark:bg-gray-900">
            <template x-for="(msg, index) in messages" :key="index">
                <div :class="msg.sender === 'user' ? 'text-right' : 'text-left'">
                    <div 
                        class="inline-block px-4 py-2 rounded-lg text-sm max-w-[85%] break-words"
                        :class="msg.sender === 'user' ? 'bg-indigo-600 text-white rounded-br-none' : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-bl-none'"
                        x-html="formatMessage(msg.text)"
                    ></div>
                </div>
            </template>
            
            <div x-show="isLoading" class="text-left">
                <div class="inline-block px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded-lg rounded-bl-none">
                    <div class="flex space-x-1">
                        <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce"></div>
                        <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                        <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                    </div>
                </div>
            </div>
            
            <div x-show="messages.length === 0" class="text-center text-gray-500 dark:text-gray-400 text-sm mt-4">
                ¡Pregúntame lo que quieras!
            </div>
        </div>

        <!-- Input -->
        <div class="p-3 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
            <form @submit.prevent="sendMessage" class="flex gap-2">
                <input 
                    type="text" 
                    x-model="message" 
                    placeholder="Escribe tu pregunta..." 
                    class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm"
                >
                <button 
                    type="submit" 
                    class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-md px-3 py-2 transition-colors disabled:opacity-50"
                    :disabled="isLoading || !message.trim()"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <!-- Toggle Button -->
    <div 
        x-show="!open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-50"
        x-transition:enter-end="opacity-100 scale-100"
        class="relative group"
    >
        <button 
            @click="toggle" 
            class="bg-white p-1 rounded-full shadow-2xl transition-all duration-500 hover:scale-110 focus:outline-none ring-4 ring-indigo-600/20 active:scale-95 animate-subtle-float"
        >
            <div class="relative flex items-center justify-center w-20 h-20 sm:w-24 sm:h-24">
                <!-- Circular Text -->
                <svg class="absolute w-full h-full animate-spin-slow" viewBox="0 0 100 100">
                    <defs>
                        <path id="circlePath" d="M 50, 50 m -37, 0 a 37,37 0 1,1 74,0 a 37,37 0 1,1 -74,0" />
                    </defs>
                    <text class="text-[10px] uppercase font-bold fill-indigo-600 tracking-[0.2em]">
                        <textPath xlink:href="#circlePath">Pregúntale a Caribou</textPath>
                    </text>
                </svg>
                <!-- Central Logo -->
                <img src="{{ asset('images/caribou-logo.png') }}" class="w-12 h-12 sm:w-14 sm:h-14 rounded-full shadow-lg" alt="Caribou">
            </div>
        </button>
    </div>

    <style>
        @keyframes subtle-float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        .animate-subtle-float {
            animation: subtle-float 3s ease-in-out infinite;
        }
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin-slow {
            animation: spin-slow 25s linear infinite;
        }
    </style>
</div>

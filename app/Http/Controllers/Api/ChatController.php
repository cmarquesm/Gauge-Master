<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GeminiService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    protected $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'context' => 'nullable|array',
        ]);

        $userMessage = $request->input('message');
        $context = $request->input('context');
        
        // System Prompt with context awareness
        $systemPrompt = $this->getSystemPrompt($context);

        $response = $this->geminiService->generateContent($userMessage, $systemPrompt);

        if ($response instanceof \Illuminate\Http\Client\Response) {
            $data = $response->json();
            $text = data_get($data, 'candidates.0.content.parts.0.text');

            // Si no hay texto, muéstrame el error real de Google para diagnosticar
            if (!$text) {
                return response()->json([
                    'reply' => 'Error de la IA: ' . ($data['error']['message'] ?? 'Respuesta vacía (posible filtro de seguridad).')
                ]);
            }

            return response()->json(['reply' => $text]);
        }

        return response()->json([
            'reply' => 'Hubo un error al procesar tu solicitud.'
        ]);
    }

    private function getSystemPrompt($context = null)
    {
        // Extraer datos del contexto o usar valores por defecto
        $scaleLength = $context['scale_length'] ?? 'no especificada';
        $tuningName = $context['tuning_name'] ?? 'no especificada';
        $totalTension = $context['total_tension'] ?? 'no calculada';
        $stringGauges = $context['string_gauges'] ?? 'no especificados';

        return <<<EOT
Eres "Gauge Master", un asistente experto en luthería y física acústica. Tu objetivo es asesorar al usuario sobre el calibre de sus cuerdas basándote en los datos reales de su calculadora.

DATOS ACTUALES DEL USUARIO:
- Escala: {$scaleLength} pulgadas.
- Afinación: {$tuningName}.
- Tensión Total: {$totalTension} lbs.
- Calibres actuales: {$stringGauges}.

INSTRUCCIONES DE COMPORTAMIENTO:
1. IDIOMA: Responde SIEMPRE en ESPAÑOL.
2. CONTEXTO: Utiliza los "DATOS ACTUALES" para personalizar tu respuesta. Si la tensión es mayor a 110 lbs, advierte que el tacto será duro. Si es menor a 80 lbs, advierte que las cuerdas pueden trastear o sentirse "blandas".
3. CONOCIMIENTO DE ARTISTAS: Conoces las afinaciones y calibres de guitarristas famosos (Slash, Angus Young, James Hetfield, Tony Iommi, Jimi Hendrix, Stevie Ray Vaughan, etc.). Relaciona sus configuraciones con lo que el usuario tiene en pantalla.
4. FÍSICA: Si el usuario cambia la afinación a una más grave sin subir el calibre, explícale mediante la Ley de Mersenne que la pérdida de frecuencia (f) requiere más masa (µ) para mantener la tensión (T).
5. ESTILO: Sé profesional, técnico pero accesible. Usa términos como "sustain", "inarmonía", "ataque" y "tensión de rotura".

CONSTANTES FÍSICAS Y FÓRMULAS:
- G = 386.4 (constante de gravedad para unidades imperiales)
- K_PLAIN = 0.222 (para cuerdas lisas, diámetro <= 0.018")
- K_WOUND = 0.180 (para cuerdas entorchadas, diámetro > 0.018")
- Escala de referencia estándar = 25.5 pulgadas

Fórmulas:
1. Frecuencia desde nota: 440 * 2^((MIDI - 69) / 12)
2. Calibre desde tensión: d = sqrt( (T * G) / (K * (2 * L * F)^2) )
3. Tensión desde calibre: T = (K * d^2 * (2 * L * F)^2) / G

Referencias de tensión (aproximadas para guitarra a 25.5"):
- Ligera: ~14-15 lbs por cuerda (Total ~85 lbs)
- Media: ~17 lbs por cuerda (Total ~102 lbs)
- Alta: ~20 lbs por cuerda (Total ~120 lbs)

EJEMPLOS DE CONFIGURACIONES DE ARTISTAS FAMOSOS:
- Slash: Gibson Les Paul (24.75"), afinación E estándar, calibres .010-.046
- Angus Young: Gibson SG (24.75"), afinación E estándar, calibres .009-.042
- James Hetfield: ESP (25.5"), afinación E estándar / Drop D, calibres .010-.046 o .011-.048
- Tony Iommi: Gibson SG (24.75"), afinaciones graves (C# estándar), calibres .008-.032 (por lesión en dedos)
- Jimi Hendrix: Fender Stratocaster (25.5"), afinación Eb estándar, calibres .010-.038
- Stevie Ray Vaughan: Fender Stratocaster (25.5"), afinación Eb estándar, calibres .013-.058 (muy pesados)

Si el usuario pregunta por un artista, identifica su equipo y compáralo con los datos actuales del usuario. Si no tienes datos actuales del usuario (valores "no especificada" o "no calculada"), simplemente proporciona información general sin hacer comparaciones.

Cuando respondas:
- Sé útil, conciso y preciso
- Si te piden cálculos, muestra tu trabajo o al menos los parámetros usados
- Mantén un tono profesional pero cercano, como un maestro luthier
EOT;
    }
}

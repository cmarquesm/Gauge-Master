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
        ]);

        $userMessage = $request->input('message');
        
        // System Prompt based on calculator.js logic
        $systemPrompt = $this->getSystemPrompt();

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

    private function getSystemPrompt()
    {
        return <<<EOT
        return <<<EOT
You are an expert in string instrument physics, specifically focused on string tension and gauge calculations.
Besides physics, you are a guitar historian. You know the gear of famous artists. If asked about a guitarist, identify their guitar, scale (e.g., Gibson 24.75", Fender 25.5") and usual tuning to provide advice based on stage reality.
You help users understand how string gauge, scale length, and tuning affect tension.

Here are the core physical constants and formulas you must use for any calculation:
- Unit Weight (UW) is calculated as: (Diameter^2 * Density) / 4. 
  (Simplified in the JS logic as constants K_PLAIN and K_WOUND).
- Generic Tension Formula (T): T = (UnitWeight * (2 * Length * Frequency)^2) / G
  Where G = 386.4 (Gravity constant for imperial units).

Constants from our internal calculator:
- G = 386.4
- K_PLAIN = 0.222 (for plain strings, typically diameter <= 0.018)
- K_WOUND = 0.180 (for wound strings, typically diameter > 0.018)
- Standard Scale Reference = 25.5 inches

Formulas:
1. Frequency from Note: 440 * 2^((MIDI - 69) / 12)
2. Gauge from Tension (d): 
   d = sqrt( (T * G) / (K * (2 * L * F)^2) )
3. Tension from Gauge (T):
   T = (K * d^2 * (2 * L * F)^2) / G

Reference Tensions (approximate for a guitar string at 25.5" scale):
- Light: ~14-15 lbs per string (Total ~85 lbs)
- Medium: ~17 lbs per string (Total ~102 lbs)
- High: ~20 lbs per string (Total ~120 lbs)

When answering:
- Be helpful, concise, and precise.
- If asked to calculate, show your work or at least the parameters used.
- If the user asks about "Drop D" or other tunings, explain how the change in frequency affects the tension if the gauge remains the same.
- Assume standard electric guitar strings unless specified otherwise.

"IMPORTANT: Always respond in Spanish, but keep the technical names of the notes (e.g., C, D, E) and physical constants as they are. Use a professional yet close tone, like a master luthier."
EOT;
    }
}

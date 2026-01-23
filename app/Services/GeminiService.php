<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;
    protected $baseUrl = 'https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash:generateContent';

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
    }

    public function generateContent($prompt, $systemInstruction = '')
    {
        if (!$this->apiKey) {
            Log::error('GEMINI_API_KEY is not set in .env');
            return 'Error: API Key not configured.';
        }

        $url = "{$this->baseUrl}?key={$this->apiKey}";

        $contents = [];

        if (!empty($systemInstruction)) {
             $contents[] = ['role' => 'user', 'parts' => [['text' => $systemInstruction]]];
             $contents[] = ['role' => 'model', 'parts' => [['text' => 'Understood. I am your String Physics Expert.']]];
        }

        $contents[] = ['role' => 'user', 'parts' => [['text' => $prompt]]];

        $payload = [
            'contents' => $contents,
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 800,
            ]
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->withoutVerifying()->post($url, $payload);

            return $response;
        } catch (\Exception $e) {
            Log::error('Gemini Service Exception: ' . $e->getMessage());
            return 'An unexpected error occurred.';
        }
    }
}

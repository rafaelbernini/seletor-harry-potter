<?php

class GeminiService {
    private $apiKey;
    private $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent';

    public function __construct() {
        $this->apiKey = GEMINI_API_KEY;
    }

    public function gerarDescricao($nome) {
        try {
            $prompt = "Atue como o Chapéu Seletor de Hogwarts. Analise o aluno {$nome} e gere:
                      1. Uma descrição detalhada de 100-150 palavras sobre suas características
                      2. Determine a casa mais adequada (Grifinória, Sonserina, Corvinal ou Lufa-Lufa)
                      3. Formate a resposta assim:
                      CASA: [nome da casa]
                      DESCRIÇÃO: [sua descrição]";

            $data = [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 800
                ]
            ];

            $headers = [
                'Content-Type: application/json',
                'x-goog-api-key: ' . $this->apiKey
            ];

            $ch = curl_init($this->apiUrl);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_SSL_VERIFYPEER => false
            ]);

            $response = curl_exec($ch);
            
            if (curl_errno($ch)) {
                throw new Exception('Erro Curl: ' . curl_error($ch));
            }

            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200) {
                $result = json_decode($response, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new Exception('Erro ao decodificar JSON: ' . json_last_error_msg());
                }
                return $this->processarResposta($result['candidates'][0]['content']['parts'][0]['text']);
            } else {
                throw new Exception('Erro na API (HTTP ' . $httpCode . '): ' . $response);
            }
        } catch (Exception $e) {
            error_log('Erro ao gerar descrição: ' . $e->getMessage());
            throw $e;
        }
    }

    private function processarResposta($texto) {
        // Extrair casa e descrição do texto
        preg_match('/CASA:\s*([^\n]+)/i', $texto, $casaMatch);
        preg_match('/DESCRIÇÃO:\s*(.+)/is', $texto, $descricaoMatch);

        return [
            'casa' => $casaMatch[1] ?? 'Indefinida',
            'descricao' => $descricaoMatch[1] ?? $texto
        ];
    }
} 
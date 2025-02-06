<?php

class OpenAIService {
    private $apiKey;
    private $apiUrl = 'https://api.openai.com/v1/chat/completions';

    public function __construct() {
        $this->apiKey = OPENAI_API_KEY;
    }

    public function gerarDescricao($nome) {
        try {
            $prompt = "Você é o Chapéu Seletor de Hogwarts. Gere uma descrição detalhada para o aluno {$nome}, " .
                     "focando em características de personalidade que se alinhem com as casas de Hogwarts " .
                     "(Grifinória, Sonserina, Corvinal e Lufa-Lufa). A descrição deve ter entre 100 e 150 palavras " .
                     "e incluir palavras-chave específicas das casas como coragem, ambição, inteligência, lealdade, etc.";

            $data = [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Você é o Chapéu Seletor de Hogwarts.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'temperature' => 0.7,
                'max_tokens' => 200
            ];

            $headers = [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->apiKey
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
                return $result['choices'][0]['message']['content'];
            } else {
                throw new Exception('Erro na API: ' . $response);
            }
        } catch (Exception $e) {
            error_log('Erro ao gerar descrição: ' . $e->getMessage());
            return false;
        }
    }
} 
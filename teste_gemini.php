<?php

require_once 'config.php';
require_once 'app/services/GeminiService.php';

try {
    $gemini = new GeminiService();
    $nome = "Harry Potter"; // Nome de teste
    
    echo "Iniciando teste com o nome: " . $nome . "\n\n";
    
    $resultado = $gemini->gerarDescricao($nome);
    
    if ($resultado) {
        echo "✅ Teste bem sucedido!\n\n";
        echo "Casa escolhida: " . $resultado['casa'] . "\n";
        echo "Descrição gerada:\n";
        echo "================\n";
        echo $resultado['descricao'] . "\n";
    } else {
        echo "❌ Falha ao gerar descrição\n";
    }
} catch (Exception $e) {
    echo "❌ Erro durante o teste: " . $e->getMessage() . "\n";
} 
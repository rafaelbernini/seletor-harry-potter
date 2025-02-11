<?php

require_once 'config.php';
require_once 'app/services/OpenAIService.php';

try {
    $openai = new OpenAIService();
    $nome = "Harry Potter"; // Nome de teste
    
    echo "Iniciando teste com o nome: " . $nome . "\n\n";
    
    // Ativar exibição de erros do PHP
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    
    $descricao = $openai->gerarDescricao($nome);
    
    if ($descricao) {
        echo "✅ Teste bem sucedido!\n\n";
        echo "Descrição gerada:\n";
        echo "================\n";
        echo $descricao . "\n";
    } else {
        echo "❌ Falha ao gerar descrição\n";
        // Verificar o log de erros
        $error = error_get_last();
        if ($error) {
            echo "Detalhes do erro: " . $error['message'] . "\n";
        }
    }
} catch (Exception $e) {
    echo "❌ Erro durante o teste: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
} 
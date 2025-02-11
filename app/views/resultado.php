<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resultado da Seleção</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Chapéu Seletor - Resultado</h1>

    <div id="selecao-container">
        <img src="C:/xampp/htdocs/seletor-harry-potter/public/img/chapeu.gif" alt="Chapéu Seletor" id="chapeu">
        <p id="pensando">Hmm... deixe-me pensar...</p>
    </div>

    <div id="resultado" style="display: none; max-width: 800px; margin: 0 auto; text-align: center;">

        <h2>
            <?php
            echo "Aluno: " . (isset($aluno['nome']) ? $aluno['nome'] : 'Nome não informado') . "<br>";
            echo "Turma: " . (isset($aluno['turma']) ? $aluno['turma'] : 'Turma não informada') . "<br>";
            echo "Perfil: " . (isset($perfil) ? $perfil : 'Perfil não definido') . "<br>";
            echo "Casa: <span id='casa'>" . (isset($casa) ? $casa : 'Casa não definida') . "</span>";
            ?>
        </h2>
    </div>

    <div id="botoes" style="display: none;">
        <a href="<?php echo BASE_URL; ?>">Cadastrar outro aluno</a>
        <a href="<?php echo BASE_URL; ?>?action=relatorio">Ver Relatório</a>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
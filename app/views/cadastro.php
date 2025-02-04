<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Aluno</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Chapéu Seletor - Cadastro</h1>
    <form action="?action=cadastrar" method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="turma">Turma:</label>
        <select id="turma" name="turma" required>
            <option value="DEV32025">DEV32025</option>
        </select><br><br>

        <label for="descricao">Descreva-se:</label><br>
        <textarea id="descricao" name="descricao" rows="4" cols="50" required></textarea><br><br>

        <button type="submit">Cadastrar</button>
    </form>

    <a href="?action=relatorio">Ver Relatório</a>
</body>
</html>
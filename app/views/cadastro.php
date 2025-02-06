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
        <textarea id="descricao" name="descricao" rows="4" cols="50" required></textarea><br>
        <!-- <button type="button" id="gerarDescricao">Gerar Descrição com IA</button><br><br>
-->
        <button type="submit" class="botao-hogwarts">
            <img src="../public/img/chapeu-de-bruxa.png" alt="Chapéu de Bruxa" class="icone-botao">
            <span>Descobrir minha Casa!</span>
        </button>
    </form>

    <a href="?action=relatorio">Ver Relatório</a>

    <script>
    /* document.getElementById('gerarDescricao').addEventListener('click', async () => {
        const nome = document.getElementById('nome').value;
        if (!nome) {
            alert('Por favor, preencha o nome primeiro!');
            return;
        }

        const button = document.getElementById('gerarDescricao');
        button.disabled = true;
        button.textContent = 'Gerando...';

        try {
            const response = await fetch('?action=gerarDescricao', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ nome: nome })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            console.log('Resposta do servidor:', data);

            if (data.descricao) {
                document.getElementById('descricao').value = data.descricao;
            } else {
                throw new Error('Resposta sem descrição: ' + JSON.stringify(data));
            }
        } catch (error) {
            console.error('Erro detalhado:', error);
            alert('Erro ao gerar descrição. Por favor, tente novamente. Detalhes: ' + error.message);
        } finally {
            button.disabled = false;
            button.textContent = 'Gerar Descrição com IA';
        }
    }); */
    </script>
</body>
</html>
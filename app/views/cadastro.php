<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Aluno</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div id="form-container">
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
            <button type="button" id="gerarDescricao">Gerar Descrição com IA</button><br><br>

            <button type="submit" class="botao-hogwarts">
                <img src="img/chapeu-de-bruxa.png" alt="Chapéu de Bruxa" class="icone-botao">
                <span>Descobrir minha Casa!</span>
            </button>
        </form>
    </div>

    <div id="selecao-container" style="display: none; text-align: center;">
        <img src="img/sorting-hat.gif" alt="Chapéu Seletor" style="max-width: 300px;">
        <div id="pensando" style="font-size: 24px; margin: 20px 0;"></div>
    </div>

    <div id="resultado-ia" style="display: none; text-align: center;">
        <h2>O Chapéu Seletor decidiu...</h2>
        <div id="casa-resultado" style="font-size: 28px; margin: 20px 0; font-weight: bold;"></div>
        <div id="descricao-resultado" style="margin: 20px 0;"></div>
        <button onclick="voltarFormulario()" class="botao-hogwarts">Voltar</button>
    </div>

    <a href="?action=relatorio">Ver Relatório</a>

    <script>
    const frasesPensamento = [
        "Hmm... interessante...",
        "Vejo muito potencial...",
        "Que mente fascinante...",
        "Deixe-me ver...",
        "Difícil... muito difícil..."
    ];

    function mostrarPensamentos() {
        const pensandoElement = document.getElementById("pensando");
        let i = 0;
        return setInterval(() => {
            pensandoElement.textContent = frasesPensamento[i % frasesPensamento.length];
            i++;
        }, 1000);
    }

    function voltarFormulario() {
        document.getElementById("resultado-ia").style.display = "none";
        document.getElementById("form-container").style.display = "block";
        document.getElementById("descricao").value = "";
    }

    document.getElementById('gerarDescricao').addEventListener('click', async () => {
        const nome = document.getElementById('nome').value;
        const turma = document.getElementById('turma').value;
        
        if (!nome) {
            alert('Por favor, preencha o nome primeiro!');
            return;
        }

        // Esconde o formulário e mostra a animação
        document.getElementById("form-container").style.display = "none";
        document.getElementById("selecao-container").style.display = "block";
        
        const intervalId = mostrarPensamentos();
        const button = document.getElementById('gerarDescricao');
        button.disabled = true;

        try {
            const response = await fetch('?action=gerarDescricao', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ 
                    nome: nome,
                    turma: turma
                })
            });

            const data = await response.json();
            
            if (data.erro) {
                throw new Error(data.erro);
            }

            // Após 3 segundos, mostra o resultado
            setTimeout(() => {
                clearInterval(intervalId);
                document.getElementById("selecao-container").style.display = "none";
                document.getElementById("resultado-ia").style.display = "block";
                
                document.getElementById("casa-resultado").textContent = data.casa;
                document.getElementById("descricao-resultado").textContent = data.descricao;
                document.getElementById("descricao").value = data.descricao;
                
                if (data.success) {
                    console.log('Dados salvos com sucesso no banco de dados!');
                }
            }, 3000);

        } catch (error) {
            clearInterval(intervalId);
            document.getElementById("selecao-container").style.display = "none";
            document.getElementById("form-container").style.display = "block";
            console.error('Erro detalhado:', error);
            alert('Erro ao gerar descrição. Por favor, tente novamente. Detalhes: ' + error.message);
        } finally {
            button.disabled = false;
        }
    });
    </script>
</body>
</html>
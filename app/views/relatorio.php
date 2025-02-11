<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório - Chapéu Seletor</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .relatorio-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
        }

        .estatisticas {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .casa-stats {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }

        .alunos-lista {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: rgba(255, 255, 255, 0.1);
        }

        .alunos-lista th, .alunos-lista td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid rgba(212, 175, 55, 0.3);
        }

        .alunos-lista th {
            background: rgba(212, 175, 55, 0.2);
            color: #d4af37;
        }

        .alunos-lista tr:hover {
            background: rgba(212, 175, 55, 0.1);
        }

        .descricao-cell {
            max-width: 400px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .descricao-cell:hover {
            white-space: normal;
            overflow: visible;
            background: rgba(0, 0, 0, 0.9);
            position: relative;
            z-index: 1;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .voltar-btn {
            margin: 20px 0;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="relatorio-container">
        <h1>Relatório do Chapéu Seletor</h1>

        <div class="estatisticas">
            <?php foreach ($estatisticas as $casa => $quantidade): ?>
            <div class="casa-stats <?= strtolower($casa) ?>">
                <h3><?= $casa ?></h3>
                <p><?= $quantidade ?> alunos</p>
            </div>
            <?php endforeach; ?>
        </div>

        <table class="alunos-lista">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Turma</th>
                    <th>Casa</th>
                    <th>Descrição</th>
                    <th>Data de Seleção</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alunos as $aluno): ?>
                <tr>
                    <td><?= htmlspecialchars($aluno['nome']) ?></td>
                    <td><?= htmlspecialchars($aluno['turma']) ?></td>
                    <td class="<?= strtolower($aluno['casa']) ?>"><?= htmlspecialchars($aluno['casa']) ?></td>
                    <td class="descricao-cell"><?= htmlspecialchars($aluno['descricao']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($aluno['created_at'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="<?= BASE_URL ?>" class="voltar-btn">Voltar ao Início</a>
    </div>

    <script>
    // Adiciona interatividade às descrições
    document.querySelectorAll('.descricao-cell').forEach(cell => {
        cell.addEventListener('click', function() {
            this.classList.toggle('expanded');
        });
    });
    </script>
</body>
</html>
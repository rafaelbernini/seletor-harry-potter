<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Relatório - Chapéu Seletor</h1>

    <h2>Distribuição por Casa:</h2>
    <ul>
        <li>Grifinória: <?php echo $totalGrifinoria; ?></li>
        <li>Sonserina: <?php echo $totalSonserina; ?></li>
        <li>Corvinal: <?php echo $totalCorvinal; ?></li>
        <li>Lufa-Lufa: <?php echo $totalLufaLufa; ?></li>
    </ul>

    <h2>Lista de Alunos:</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Turma</th>
                <th>Casa</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $alunos->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nome']; ?></td>
                <td><?php echo $row['turma']; ?></td>
                <td><?php echo $row['casa']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="<?php echo BASE_URL; ?>">Voltar</a>
</body>
</html>
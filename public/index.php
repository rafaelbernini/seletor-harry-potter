<?php
// Inicia o buffer de saída
ob_start();

require_once '../config.php';
require_once '../app/core/Database.php';
require_once '../app/controllers/SeletorController.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$controller = new SeletorController();

// Se for uma ação AJAX, não queremos o HTML da página
if ($action === 'gerarDescricao') {
    $controller->gerarDescricao();
    exit;
}

// Para outras ações, continuamos com o HTML normal
?>
<!DOCTYPE html>
<html>
<head>
    <audio autoplay loop id="bgMusic">
        <source src="assets/hogwarts.mp3" type="audio/mpeg">
        Seu navegador não suporta o elemento de áudio.
    </audio>
</head>
<body>
<?php
switch ($action) {
    case 'cadastrar':
        $controller->cadastrar();
        break;
    case 'selecionar':
        $controller->selecionar();
        break;
    case 'relatorio':
        $controller->relatorio();
        break;
    default:
        $controller->index();
        break;
}
?>
</body>
</html>
<?php
ob_end_flush();
?>
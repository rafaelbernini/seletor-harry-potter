<?php

require_once '../config.php';
require_once '../app/core/Database.php';
require_once '../app/controllers/SeletorController.php';

// Adiciona o elemento de áudio HTML antes de qualquer saída
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

$action = isset($_GET['action']) ? $_GET['action'] : 'index';

$controller = new SeletorController();

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
    case 'gerarDescricao':
        $controller->gerarDescricao();
        break;
    default:
        $controller->index();
        break;
}

?>
</body>
</html>
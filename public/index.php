<?php

require_once '../config.php';
require_once '../app/core/Database.php';
require_once '../app/controllers/SeletorController.php';

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
    default:
        $controller->index();
        break;
}
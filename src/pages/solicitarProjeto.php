<?php

require_once __DIR__ . "/../helpers/SessionManager.php";
require_once __DIR__ . "/../models/Projeto.php";
require_once __DIR__ . "/../controllers/AlunoController.php";


SessionManager::requireLogin(3);

if (isset($_GET['erro'])) {
    $erro = true;
}


$page = "solicitarProjeto";
$pageTitle = "Solicitação de Projeto";
include "../views/header.php";

$alunoController = new AlunoController();
$cursos = Projeto::buscaCursosDoBanco();
$temas = Projeto::buscaTemasDoBanco();
$alunos = $alunoController->consultaAlunos();

$etapa = 7;
$admin = False;
include "../views/formulario.php";
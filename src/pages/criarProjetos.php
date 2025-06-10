<?php

require_once __DIR__ . "/../helpers/SessionManager.php";
require_once __DIR__ . "/../models/Projeto.php";
require_once __DIR__ . "/../controllers/AlunoController.php";


SessionManager::requireLogin(2);

if (isset($_GET['erro'])) {
    $erro = true;
}


$page = "cadastroProjeto";
$pageTitle = "Cadastra Projeto";
include "../views/header.php";

$alunoController = new AlunoController();
$cursos = Projeto::buscaCursosDoBanco();
$temas = Projeto::buscaTemasDoBanco();
$alunos = $alunoController->consultaAlunos();

$etapa = 7;
$admin = True;
include "../views/formulario.php";

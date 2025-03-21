<?php

require_once __DIR__ . "/../helpers/SessionManager.php";
require_once "../models/Projeto.php";


SessionManager::requireLogin(2);

if (isset($_GET['erro'])) {
    $erro = true;
}


$page = "cadastroProjeto";
$pageTitle = "Cadastra Projeto";
include "../views/header.php";

$cursos = Projeto::buscaCursosDoBanco();
$temas = Projeto::buscaTemasDoBanco();

$etapa = 7;
include "../views/formulario.php";

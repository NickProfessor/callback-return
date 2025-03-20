<?php

require_once __DIR__ . "/../helpers/SessionManager.php";
require_once __DIR__ . "/../models/Projeto.php";

SessionManager::requireLogin(2);

$pageTitle = 'Cadastro de Aluno';
$page = "cadastroAluno";
$etapa = 9;
if (isset($_GET['erro'])) {
    $erro = true;
}

$cursos = Projeto::buscaCursosDoBanco();


include "../views/header.php";
include "../views/formulario.php";
include "../views/footer.php";
<?php
session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {


    header("Location: ../../index.php");

} else {
    if (isset($_GET['erro'])) {
        $erro = true;
    }
    require_once "../models/Projeto.php";

    $page = "cadastroProjeto";
    $pageTitle = "Cadastra Projeto";
    include "../views/header.php";

    $locais = Projeto::buscaSalasDoBanco();
    $cursos = Projeto::buscaCursosDoBanco();
    $temas = Projeto::buscaTemasDoBanco();

    $etapa = 7;
    include "../views/formulario.php";
}

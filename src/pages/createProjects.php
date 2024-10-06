<?php
$email = "teste@teste";
$senha = "teste";
if (isset($_POST['user-email']) && isset($_POST['user-password']) && $_POST['user-email'] == $email && $_POST['user-password'] == $senha) {
    require_once "../models/Projeto.php";

    $page = "cadastroProjeto";
    $pageTitle = "Cadastra Projeto";
    include "../views/header.php";
    $projetoController = new Projeto("Projeto de criação de teto", "22", "Muito incrível tetar", ["2", "5"], ["2"]);
    $projetoController->cadastraProjeto();
    // $listaDeProjetos = $projetoController->obterProjetos();

    // $etapa = 7;
    // include "../views/formulario.php";

} else {
    header("Location: ../../index.php");
}

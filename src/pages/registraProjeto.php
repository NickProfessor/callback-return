<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../index.php");
} else {
    if (isset($_POST['nome']) && isset($_POST['local']) && isset($_POST['descricao']) && isset($_POST['cursos']) && isset($_POST['temas']) && isset($_POST['integrantes'])) {
        $nomeProjeto = $_POST['nome'];
        $localProjeto = $_POST['local'];
        $descricaoProjeto = $_POST['descricao'];
        $temasProjeto = $_POST['temas'];
        $cursosProjeto = $_POST['cursos'];
        $integrantesProjeto = $_POST['integrantes'];
        require_once "../models/Projeto.php";
        if ($localProjeto == "outro") {
            $localProjeto = $_POST['novoLocal'];
        }
        $projetoController = new Projeto(
            $nomeProjeto,
            $localProjeto,
            $descricaoProjeto,
            $temasProjeto,
            $cursosProjeto,
            $integrantesProjeto
        );

        $projetoController->cadastraProjeto();

        $page = "registraProjeto";
        $pageTitle = "Projeto registrado";
        include "../views/header.php";
        $etapa = 8;
        include "../views/formulario.php";
    } else {
        header("Location: ./createProjects.php?erro=dados-insuficientes");
    }
}

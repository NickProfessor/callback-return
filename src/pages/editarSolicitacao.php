<?php

require_once "../helpers/SessionManager.php";
require_once "../controllers/AlunoController.php";
require_once "../models/Projeto.php";

SessionManager::requireLogin(3);
if (!isset($_GET['projeto']) || $_GET['projeto'] == '') {
    header("Location: ../../index.php?erro-edicao");
} else {
    // $projeto = Projeto::obterProjetoPeloId($_GET['projeto']);
    $solicitacao = True;
    $cursos = Projeto::buscaCursosDoBanco();
    $temas = Projeto::buscaTemasDoBanco();
    $projeto = Projeto::obterDetalhesDaSolicitacao($_GET['projeto']);
    $projetoCursos = explode(',', $projeto['cursos']); // Transforma em array
    $projetoTemas = explode(',', $projeto['temas']); // Transforma em array
    $alunoController = new AlunoController();
    $alunos = $alunoController->consultaAlunos();
    $alunosDoProjeto = Projeto::buscaAlunosDoProjeto($projeto['id_solicitacao']);
    $arquivoAtual = $projeto['projeto_material_apoio'] ?? null;
    $etapa = 11;
    $pageTitle = "Edição do projeto";
    $page = "editarProjeto";
    include "../views/header.php";
    include "../views/formulario.php";
}
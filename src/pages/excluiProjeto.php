<?php

require_once "../helpers/SessionManager.php";
require_once "../models/Projeto.php";

SessionManager::requireLogin(2);

if (!isset($_GET["projeto"]) || $_GET["projeto"] == "") {
    header("Location: ../../index.php?algo-deu-errado");
} else {
    $projeto_id = $_GET['projeto'];
    $projeto = Projeto::obterProjetoPeloId($projeto_id);
    if ($projeto) {
        $nomeProjeto = $projeto['nome'];
        Projeto::excluiProjeto($projeto_id);

        $page = "excluiProjeto";
        $pageTitle = "Projeto excluído com sucesso! | CallbackReturn";
        $etapa = 10;
        include "../views/header.php";
        include "../views/formulario.php";
    } else {
        header("Location: ../../index.php?projeto-nao-existe");
    }

}


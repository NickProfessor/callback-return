<?php

require_once "../helpers/SessionManager.php";
require_once "../models/Projeto.php";

SessionManager::requireLogin(2);

if (!isset($_GET["projeto"]) || $_GET["projeto"] == "") {
    header("Location: ../../index.php?algo-deu-errado");
} else {
    $projeto_id = $_GET['projeto'];
    Projeto::excluiProjeto($projeto_id);
    echo "projeto excluído :)";
    echo "<a href='../../index.php'> Voltar para tela principal</a>";
}


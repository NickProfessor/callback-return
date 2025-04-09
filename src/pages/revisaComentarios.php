<?php

require_once "../models/Projeto.php";
require_once "../helpers/SessionManager.php";

if (!isset($_GET['projeto']) and $_GET['projeto'] == '') {
    header("Location: ../../index.php?projeto-nao-informado");
} else {
    SessionManager::requireLogin(2);
    $idProjeto = $_GET['projeto'];
    $comentarios = Projeto::carregaComentarios($idProjeto);



    include '../views/tabelaDeComentarios.php';
    $page = 'revisaComentarios';
    $pageTitle = 'Revisando Comentários | Callback-return';
    include "../views/header.php";
    include "../views/footer.php";
}
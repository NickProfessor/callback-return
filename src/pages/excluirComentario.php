<?php

require_once "../models/Projeto.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_avaliacao = $_POST['id_avaliacao'];
    $projetoId = $_POST['id_projeto'];

    $excluido = Projeto::excluiComentario($id_avaliacao);
    if ($excluido) {
        header("Location: ./revisaComentarios.php?projeto=$projetoId&&sucesso=1");
    }
}
?>
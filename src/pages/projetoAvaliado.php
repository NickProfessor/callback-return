<?php 

$pageTitle = "Avaliado | CallBackReturn";
include "../views/header.php";

require_once "../models/Avaliacao.php";

$id_projeto = $_POST['id_projeto'];
$nota_projeto = $_POST['nota_projeto'];
$comentario_projeto = $_POST['comentario_projeto'];
$id_usuario = $_POST['id_usuario'];
$frase = $_POST['frase'];

$avaliacao = new Avaliacao(
    $nota_projeto, 
    $id_projeto, 
    $comentario_projeto, 
    $id_usuario, 
    $frase
);

$avaliacao->avaliaProjeto();

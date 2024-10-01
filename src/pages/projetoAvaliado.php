<?php

$pageTitle = "Avaliado | CallBackReturn";
$page = "projetoAvaliado";
require_once "../models/Avaliacao.php";



if (isset($_POST['id_projeto'], $_POST['nome_projeto'], $_POST['nota_projeto'], $_POST['comentario_projeto'], $_POST['id_usuario'], $_POST['frase'])) {
    // Dados foram passados corretamente
    $id_projeto = $_POST['id_projeto'];
    $projetoNome = $_POST['nome_projeto'];
    $nota_projeto = $_POST['nota_projeto'];
    $comentario_projeto = $_POST['comentario_projeto'];
    $id_usuario = $_POST['id_usuario'];
    $frase = $_POST['frase'];

    if ($nota_projeto > 10 || $nota_projeto < 1) {
        header("Location: avaliaProjeto.php?id=$id_projeto&erro=nota-invalida");
    } else {

        $avaliacao = new Avaliacao(
            $nota_projeto,
            $id_projeto,
            $comentario_projeto,
            $id_usuario,
            $frase
        );

        try {
            $sucesso = $avaliacao->avaliaProjeto();
            include "../views/header.php";

            $etapa = 6;
            include "../views/formulario.php";

        } catch (Exception $e) {
            include "../views/header.php";
            echo "Ocorreu um erro: " . $e->getMessage() . "<br>";
            echo "<a href='../../index.php'>Voltar para tela principal</a>";
        }
    }
} else {
    header("Location: ../../index.php");
}

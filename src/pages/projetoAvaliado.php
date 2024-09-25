<?php

$pageTitle = "Avaliado | CallBackReturn";
include "../views/header.php";

require_once "../models/Avaliacao.php";

if (isset($_POST['id_projeto'], $_POST['nota_projeto'], $_POST['comentario_projeto'], $_POST['id_usuario'], $_POST['frase'])) {
    // Dados foram passados corretamente
    $id_projeto = $_POST['id_projeto'];
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

            if ($sucesso) {
                echo "<p>Sua avaliação foi registrada com sucesso! Obrigado por contribuir.<p>";
                echo "<a href='../../index.php'>Voltar para tela principal</a>";
            } else {
                echo "<p>Não foi possível registrar sua avaliação. Verifique se você já avaliou este projeto ou se os dados estão corretos.</p>";
                echo "<a href='../../index.php'>Voltar para tela principal</a>";
            }

        } catch (Exception $e) {
            echo "Ocorreu um erro: " . $e->getMessage() . "<br>";
            echo "<a href='../../index.php'>Voltar para tela principal</a>";
        }
    }
} else {
    echo "Erro: Dados incompletos!";
    echo "<a href='../../index.php'>Voltar para tela principal</a>";
}

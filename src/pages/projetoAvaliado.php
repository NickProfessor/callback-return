<?php

$pageTitle = "Avaliado | CallBackReturn";
$page = "projetoAvaliado";
require_once "../models/Avaliacao.php";
require_once "../helpers/Logger.php";
require_once "../helpers/SessionManager.php";



if (isset($_POST['id_projeto'], $_POST['nome_projeto'], $_POST['nota_projeto'], $_POST['comentario_projeto'])) {
    // Dados foram passados corretamente
    $usuario = SessionManager::get('usuario');

    $id_projeto = $_POST['id_projeto'];
    $projetoNome = $_POST['nome_projeto'];
    $nota_projeto = $_POST['nota_projeto'];
    $comentario_projeto = $_POST['comentario_projeto'];
    $id_usuario = $usuario['id_usuario'];

    if ($nota_projeto > 10 || $nota_projeto < 1) {
        header("Location: avaliaProjeto.php?projeto=$id_projeto&erro=nota-invalida");
    } else {

        $avaliacao = new Avaliacao(
            $nota_projeto,
            $id_projeto,
            $comentario_projeto,
            $id_usuario,
        );

        try {
            $sucesso = $avaliacao->avaliaProjeto();
            include "../views/header.php";

            $etapa = 6;
            include "../views/formulario.php";

        } catch (Exception $e) {
            include "../views/header.php";
            Logger::log("Erro ao tentar avaliar projeto $id_projeto", "ERROR");
            echo "Erro ao tentar avaliar";
            echo "<a href='../../index.php'>Voltar para tela principal</a>";
        }
    }
} else {
    header("Location: ../../index.php?dados-incompletos");
}

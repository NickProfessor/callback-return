<?php

$pageTitle = 'Recuperando o ID | CallbackReturn';
require_once "../controllers/UserController.php";



if ($_SERVER["REQUEST_METHOD"] === "POST") {


    if (!isset($_POST['nome']) || !isset($_POST['dataNasc']) || !isset($_POST['sexo'])) {
        header("Location: ../../index.php?erro=frase");
        exit();
    }

    $nome = $_POST['nome'];
    $dataNasc = $_POST['dataNasc'];
    $sexo = $_POST['sexo'];

    $userController = new UserController();

    $data = [
        "nome" => $nome,
        "dataNasc" => $dataNasc,
        "sexo" => $sexo,
    ];

    $id = $userController->usuarioExiste($data['nome'], $data['dataNasc'], $data['sexo']);

    if ($id) {
        $page = "recuperaID";
        include "../views/header.php";
        $etapa = 3;
        $recuperado = true;
        include "../views/formulario.php";
    } else {
        header("Location: ../pages/esqueceuOID.php?erro=usuario-nao-existe");
    }

    include "../views/footer.php"
    ;

    session_unset();
    session_destroy();
} else {
    header("Location: ../../index.php");
    exit();
}
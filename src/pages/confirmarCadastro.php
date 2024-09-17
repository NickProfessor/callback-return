<?php

$pageTitle = 'Cadastro de Usuário';
require_once "../controllers/UserController.php";
include "../views/header.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$nome = $_POST['nome'];
$dataNasc = $_POST['dataNasc'];
$sexo = $_POST['sexo'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (strtotime($dataNasc) > time()) {
        header("Location: ./cadastroUsuario.php?erro=data");
    }

    $userController = new UserController();
    if (
        $mensagem = $userController->usuarioExiste(
            $nome,
            $dataNasc,
            $sexo
        )
    ) {
        echo "Você já está cadastrado no banco! Seu ID é o $mensagem";
        include "../views/footer.php";
        session_unset();
        session_destroy();
        exit();
    } else {
        $etapa = 2;
        $_SESSION['nome'] = $nome;
        $_SESSION['data_nasc'] = $dataNasc;
        $_SESSION['sexo'] = $sexo;
        include "../views/formulario.php";
    }
} else {
    header("Location: ../../index.php");
}


include "../views/footer.php";
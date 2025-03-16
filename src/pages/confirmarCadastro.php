<?php

$page = "confirmarCadastro";
require_once "../controllers/UserController.php";


$email = $_POST['email'];
$nome = $_POST['nome'];
$dataNasc = $_POST['dataNasc'];
$sexo = $_POST['sexo'];

$fraseSeguranca = $_POST["frase"] ?? null;
$fraseConfirmacao = $_POST['confirmacao'] ?? null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $userController = new UserController();
    if (
        $id = $userController->usuarioExiste(
            $email,
        )

    ) {
        $jaCadastrado = true;

        header("Location: ./login.php?ja-possui-cadastro");


    } else {
        $_SESSION['nome'] = $nome;
        $_SESSION['email'] = $email;
        $_SESSION['dataNasc'] = $dataNasc;
        $_SESSION['sexo'] = $sexo;
        if ($fraseSeguranca === null) {
            header("Location: cadastrado.php?cadastro-aluno");
        } else {
            $_SESSION['frase'] = $fraseSeguranca;
            $_SESSION['confirmacao'] = $fraseConfirmacao;
            header("Location: cadastrado.php");
        }
    }
} else {
    header("Location: ../../index.php");
}
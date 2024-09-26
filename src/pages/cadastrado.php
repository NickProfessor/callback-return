<?php

$pageTitle = 'Cadastrado';
$page = "cadastrado";
require_once "../controllers/UserController.php";
include "../views/header.php";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_POST['frase'] !== $_POST['confirmacao']) {
        header("Location: ./cadastroUsuario.php?erro=algo-deu-errado");
        exit();
    }


    if (!isset($_SESSION['nome']) || !isset($_SESSION['data_nasc']) || !isset($_SESSION['sexo']) || !isset($_POST["frase"])) {
        header("Location: ../../index.php?erro=frase");
        exit();
    }

    $nome = $_SESSION['nome'];
    $dataNasc = $_SESSION['data_nasc'];
    $sexo = $_SESSION['sexo'];
    $fraseSeguranca = $_POST["frase"];

    $userController = new UserController();

    $data = [
        "nome" => $nome,
        "dataNasc" => $dataNasc,
        "sexo" => $sexo,
        "fraseSeguranca" => $fraseSeguranca
    ];

    if ($userController->registraUsuario($data)) {
        $id = $userController->usuarioExiste($data['nome'], $data['dataNasc'], $data['sexo']);
        $registrado = true;
        $etapa = 3;
        include "../views/formulario.php";
    } else {
        echo "Não conseguiu registrar.";
        echo "<a href='../../index.php'>Voltar para página inicial</a>";
    }

    include "../views/footer.php"
    ;

    session_unset();
    session_destroy();
} else {
    header("Location: ../../index.php");
    exit();
}
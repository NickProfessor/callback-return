<?php

$pageTitle = 'Recuperando o ID | CallbackReturn';
require_once "../controllers/UserController.php";
include "../views/header.php";


if ($_SERVER["REQUEST_METHOD"] === "POST") {


    if (!isset($_POST['nome']) || !isset($_POST['data_nasc']) || !isset($_POST['sexo'])) {
        header("Location: ../../index.php?erro=frase");
        exit();
    }

    $nome = $_POST['nome'];
    $dataNasc = $_POST['data_nasc'];
    $sexo = $_POST['sexo'];

    $userController = new UserController();

    $data = [
        "nome" => $nome,
        "dataNasc" => $dataNasc,
        "sexo" => $sexo,
    ];

    $id = $userController->usuarioExiste($data['nome'], $data['dataNasc'], $data['sexo']);

    if ($id) {

        echo "<p>Seu id foi recuperado. Seu id é o $id</p>";
        echo "<a href='../../index.php'>Voltar para página inicial</a>";
    } else {
        echo "Não conseguimos encontrar seu cadastro. <a href='./cadastroUsuario.php'>Deseja se cadastrar?</a>";
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
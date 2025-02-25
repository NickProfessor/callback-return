<?php

$page = "confirmarCadastro";
$pageTitle = 'Cadastro de Usuário';
require_once "../controllers/UserController.php";




$email = $_POST['email'];
// $dataNasc = $_POST['dataNasc'];
// $sexo = $_POST['sexo'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // if (strtotime($dataNasc) > time()) {
    //     header("Location: ./cadastroUsuario.php?erro=data");
    // }

    $userController = new UserController();
    if (
        $id = $userController->usuarioExiste(
            $email,
        )
    ) {
        $jaCadastrado = true;
        $page = "cadastrado";
        $etapa = 3;
        include "../views/header.php";
        include "../views/formulario.php";
        include "../views/footer.php";
        session_unset();
        session_destroy();
        exit();
    } else {
        $etapa = 2;
        $_SESSION['nome'] = "nick";
        $_SESSION['data_nasc'] = '2024-05-29';
        $_SESSION['sexo'] = "masculino";
        include "../views/header.php";
        include "../views/formulario.php";
    }
} else {
    header("Location: ../../index.php");
}


include "../views/footer.php";
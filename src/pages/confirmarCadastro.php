<?php

$page = "confirmarCadastro";
require_once "../controllers/UserController.php";




$email = $_POST['email'];
$frase = $_POST['frase'];
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
        if ($userController->validaUsuario($id, $frase)) {
            $pageTitle = "Logado com sucesso!";
            $etapa = 3;
            $_SESSION['id'] = $id;
            include "../views/header.php";
            include "../views/formulario.php";
            include "../views/footer.php";
            exit();
        } else {
            echo "algo de errado ocorreu";
        }


    } else {
        $etapa = 2;
        $_SESSION['email'] = $email;
        include "../views/header.php";
        include "../views/formulario.php";
    }
} else {
    header("Location: ../../index.php");
}


include "../views/footer.php";
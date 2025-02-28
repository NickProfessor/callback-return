<?php
require_once __DIR__ . "/../controllers/UserController.php";
require_once __DIR__ . "/../helpers/SessionManager.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {


    $email = $_POST['email'];
    $frase = $_POST['frase'];

    $userController = new UserController();
    if (
        $id = $userController->usuarioExiste(
            $email,
        )

    ) {

        if ($userController->validaUsuario($id, $frase)) {
            SessionManager::set('usuario', $userController->consultaDadosDoUsuario($id));
            header("Location: ../../index.php?logado-com-sucesso");
        } else {
            header("Location: ./login.php?dados-incorretos");
        }

    } else {

        header("Location: ./login.php?dados-incorretos");
    }
} else {
    header("Location: ../../index.php");
}
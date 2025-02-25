<?php
require_once "../controllers/UserController.php";

$pageTitle = 'Cadastrado';
$page = "cadastrado";



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_POST['frase'] !== $_POST['confirmacao']) {
        header("Location: ./cadastroUsuario.php?erro=frase");
        exit();
    }

    $email = $_POST['email'];
    $nome = $_POST['nome'];
    $dataNasc = $_POST['dataNasc'];
    $sexo = $_POST['sexo'];
    $fraseSeguranca = $_POST["frase"];


    if (!isset($email) || !isset($nome) || !isset($dataNasc) || !isset($sexo) || !isset($fraseSeguranca)) {
        header("Location: ../../index.php?erro=algo-deu-errado");
        exit();
    }



    $userController = new UserController();

    $data = [
        "email" => $email,
        "nome" => $nome,
        "dataNasc" => $dataNasc,
        "sexo" => $sexo,
        "fraseSeguranca" => $fraseSeguranca
    ];

    if ($userController->registraUsuario($data)) {
        $id = $userController->usuarioExiste($data['email']);
        include "../views/header.php";
        $registrado = true;
        $etapa = 3;
        include "../views/formulario.php";
        $_SESSION['id'] = $id;
    } else {
        include "../views/header.php";
        echo "Não conseguiu registrar.";
        echo "<a href='../../index.php'>Voltar para página inicial</a>";
        session_unset();
        session_destroy();
    }

    include "../views/footer.php"
    ;


} else {
    header("Location: ../../index.php");
    exit();
}
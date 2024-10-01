<?php
require_once "../controllers/UserController.php";

$pageTitle = 'Cadastrado';
$page = "cadastrado";



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_POST['frase'] !== $_POST['confirmacao']) {
        header("Location: ./cadastroUsuario.php?erro=frase");
        exit();
    }


    if (!isset($_SESSION['nome']) || !isset($_SESSION['data_nasc']) || !isset($_SESSION['sexo']) || !isset($_POST["frase"])) {
        header("Location: ../../index.php?erro=algo-deu-errado");
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
        include "../views/header.php";
        $registrado = true;
        $etapa = 3;
        include "../views/formulario.php";
    } else {
        include "../views/header.php";
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
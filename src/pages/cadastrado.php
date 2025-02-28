<?php
require_once "../controllers/UserController.php";
require_once "../helpers/SessionManager.php";

$pageTitle = 'Cadastrado';
$page = "cadastrado";



if (isset($_SESSION['email'])) {
    if ($_SESSION['frase'] !== $_SESSION['confirmacao']) {
        header("Location: ./cadastroUsuario.php?erro=frase");
        exit();
    }

    $email = $_SESSION['email'];
    $nome = $_SESSION['nome'];
    $dataNasc = $_SESSION['dataNasc'];
    $sexo = $_SESSION['sexo'];
    $fraseSeguranca = $_SESSION["frase"];


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
        $usuario = $userController->consultaDadosDoUsuario($id);
        $registrado = true;
        SessionManager::destroy();
        SessionManager::set('usuario', $usuario);

        header("Location: ../../index.php?cadastrado-com-sucesso");
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
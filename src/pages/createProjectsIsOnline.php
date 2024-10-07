<?php
session_start(); // Iniciar a sessão

$email = "teste@teste";
$senha = "teste";

if (isset($_POST['user-email']) && isset($_POST['user-password']) && $_POST['user-email'] == $email && $_POST['user-password'] == $senha) {
    $_SESSION['logado'] = true;

    header("Location: ./createProjects.php");

} else {
    header("Location: ../../index.php");
}

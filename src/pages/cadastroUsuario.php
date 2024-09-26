<?php
$pageTitle = 'Cadastro de Usuário';
$page = "cadastroUsuario";
$etapa = 1;
if (isset($_GET['erro'])) {
    $erro = true;
}



include "../views/header.php";
include "../views/formulario.php";
include "../views/footer.php";
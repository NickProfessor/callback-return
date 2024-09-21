<?php
$page = "esqueceuOID";
$pageTitle = "Esqueci meu ID";
include "../views/header.php";
$etapa = 4;
if (isset($_GET['erro'])) {
    $erro = true;
}
include "../views/formulario.php";
include "../views/footer.php";
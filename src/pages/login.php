<?php
$page = "login";
$pageTitle = "Login";
include "../views/header.php";
$etapa = 2;
if (isset($_GET['erro'])) {
    $erro = true;
}
include "../views/formulario.php";
include "../views/footer.php";
<?php
require_once "./src/config/config.php";
require_once "./src/config/db_connect.php";

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>CallbackReturn</title>
    <link rel="stylesheet" href="./src/css/style.css">
</head>

<body>
    <h2>Hello world</h2>
    <a href="./src/pages/cadastroUsuario.php">cadastra usuario</a>


    <?php
    include "./src/views/footer.php";
    ?>
<?php
$pageTitle = "Esqueci meu ID";
include "../views/header.php";
?>

<body>
    <h1>Recupere seu ID</h1>

    <form action="recuperaId.php" method="POST">

        <label for="nome">Informe seu nome completo:</label>
        <input type="text" name="nome" id="nome" required>

        <label for="data_nasc">Informe sua data de nascimento</label>
        <input type="date" name="data_nasc" id="data_nasc" required>

        <p>Informe seu sexo:</p>
        <input type="radio" name="sexo" id="masculino" value="masculino" required>
        <label for="masculino">Masculino</label>

        <input type="radio" name="sexo" id="feminino" value="feminino" required>
        <label for="feminino">Feminino</label>

        <input type="radio" name="sexo" id="outro" value="outro" required>
        <label for="outro">Prefiro não informar</label>

        <button type="button" onclick="history.back()">Voltar para a tela principal</button>
        <input type="submit" name="submit" value="Continuar">

    </form>
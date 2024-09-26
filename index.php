<?php
require_once "./src/models/Projeto.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>CallbackReturn</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./src/assets/css/style.css">
    <link rel="stylesheet" href="./src/assets/css/pages/paginaPrincipal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <header>
        <h1 class="titulo-header">CallbackReturn</h1>
        <a href="./src/pages/cadastroUsuario.php" class="link-header">Cadastre se ou consulte o ID</a>
        <p>Salas</p>
    </header>
    <main>

        <?php
        $projeto = new Projeto();
        $listaDeSalas = $projeto->obterSalasComProjetos();

        if (empty($listaDeSalas)) {
            echo "Nenhuma sala com projetos encontrados.";
        } else {
            foreach ($listaDeSalas as $sala) {
                if (!empty($sala['lista_projetos'])) {
                    $salaNumero = $sala['sala_numero'];
                    $listaProjetosString = $sala['lista_projetos'];
                    $totalAvaliacoes = $sala['total_avaliacoes'];
                    $mediaNotas = $sala['media_notas'];


                    $listaProjetosArray = explode(',', $listaProjetosString);



                    include __DIR__ . "/src/views/cardSala.php";
                }
            }
        }
        ?>
    </main>
    <?php

    include "./src/views/footer.php";
    ?>
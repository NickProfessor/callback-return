<?php
require_once "./src/models/Projeto.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>CallbackReturn</title>
    <link rel="stylesheet" href=".assets/src/css/style.css">
</head>

<body>
    <h2>Hello world</h2>
    <a href="./src/pages/cadastroUsuario.php">Cadastrar usuário</a>

    <?php
    $projeto = new Projeto();
    $listaDeSalas = $projeto->obterSalasComProjetos();

    if (empty($listaDeSalas)) {
        echo "Nenhuma sala com projetos encontrados.";
    } else {
        foreach ($listaDeSalas as $sala) {
            if (!empty($sala['lista_projetos'])) {
                $salaNumero = $sala['sala_numero'];
                $listaProjetos = $sala['lista_projetos']; // projetos concatenados
                $totalAvaliacoes = $sala['total_avaliacoes'];
                $mediaNotas = $sala['media_notas'];

                // Inclua a view para exibir o card da sala
                include __DIR__ . "/src/views/cardSala.php";
            }
        }
    }

    include "./src/views/footer.php";
    ?>
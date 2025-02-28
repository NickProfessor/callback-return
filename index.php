<?php
require_once "./src/helpers/SessionManager.php";
require_once "./src/controllers/UserController.php";
require_once "./src/models/Projeto.php";

$usuario = SessionManager::get('usuario');
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
    <?php if ($usuario): ?>
        <header>
            <h1 class="titulo-header">Bem-vindo, <?php echo $usuario['nome']; ?></h1>
            <a href="./src/pages/logout.php" class="link-header">Logout</a>

            <?php
            $linkTexto = "";
            $linkURL = "#";

            switch ($usuario['tipo_usuario']) {
                case '1':
                    $linkTexto = "Sou usuário";
                    $linkURL = "./src/pages/perfilUsuario.php";
                    break;
                case '2':
                    $linkTexto = "Criar projeto";
                    $linkURL = "./src/pages/createProjects.php";
                    break;
                case '3':
                    $linkTexto = "Sou aluno";
                    $linkURL = "./src/pages/perfilAluno.php";
                    break;
                case '4':
                    $linkTexto = "Sou professor";
                    $linkURL = "./src/pages/dashboard.php";
                    break;
            }

            if ($linkTexto): ?>
                <a href="<?php echo $linkURL; ?>"><?php echo $linkTexto; ?></a>
            <?php endif; ?>

            <p>Salas</p>
        </header>
    <?php else: ?>
        <header>
            <h1 class="titulo-header">Bem-vindo</h1>
            <a href="./src/pages/login.php" class="link-header">Entre ou crie sua conta!</a>
            <p>Salas</p>
        </header>
    <?php endif; ?>

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
<?php
require_once "./src/helpers/SessionManager.php";
require_once "./src/controllers/UserController.php";
require_once "./src/models/Projeto.php";

$usuario = SessionManager::get('usuario');


$listaDeProjetos = Projeto::carregaProjetos();
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
                    $linkURL = "./src/pages/criarProjetos.php";
                    break;
                case '3':
                    $linkTexto = "Sou aluno";
                    $linkURL = "./src/pages/perfilAluno.php";
                    break;
                case '4':
                    $linkTexto = "Solicitações de projetos";
                    $linkURL = "./src/pages/solicitacoes.php";
                    break;
            }

            if ($linkTexto): ?>
                <a href="<?php echo $linkURL; ?>"><?php echo $linkTexto; ?></a>
            <?php endif; ?>

        </header>
    <?php else: ?>
        <header>
            <h1 class="titulo-header">Bem-vindo</h1>
            <a href="./src/pages/login.php" class="link-header">Entre ou crie sua conta!</a>
        </header>
    <?php endif; ?>

    <main>
        <?php

        if (empty($listaDeProjetos)) {
            echo "Nenhum projeto encontrado para a exibir.";
            echo "</main>";
        } else {

            foreach ($listaDeProjetos as $projeto) {

                $projetoId = $projeto['id_projeto'];
                $projetoNome = $projeto['projeto_nome'];
                $projetoCursos = $projeto['cursos'];
                $projetoResumo = $projeto['projeto_resumo'];
                $projetoAlunos = $projeto['alunos'];
                $projetoTemas = explode(',', $projeto['temas']);
                $projetoAvaliacoes = $projeto['total_avaliacoes'];
                $projetoMediaAvaliacoes = $projeto['media_notas'];
                include "src/views/cardProjeto.php";
            }
            echo "</main>";
        }

        include "src/views/footer.php";
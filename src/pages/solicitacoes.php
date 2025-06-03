<?php

require_once "../helpers/SessionManager.php";
require_once "../controllers/UserController.php";
require_once "../models/Projeto.php";

SessionManager::requireLogin(4);

$usuario = SessionManager::get('usuario');


$listaDeProjetos = Projeto::carregaProjetos();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>CallbackReturn</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/pages/paginaPrincipal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <header>
        <br>
        <h1 class="titulo-header">Aprove ou desaprove as solicitações dos alunos</h1>
        <br>
        <a href="../../index.php" class="link-header">Voltar para tela inicial!</a>
        <br>
    </header>
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

                $popularAdultos = isset($projeto['popular_adultos']) && $projeto['popular_adultos'];
                $popularJovens = isset($projeto['popular_jovens']) && $projeto['popular_jovens'];
                $popularIdosos = isset($projeto['popular_idosos']) && $projeto['popular_idosos'];
                $popularMulheres = isset($projeto['popular_mulheres']) && $projeto['popular_mulheres'];
                $popularHomens = isset($projeto['popular_homens']) && $projeto['popular_homens'];
                include "../views/cardProjeto.php";
            }
            echo "</main>";
        }

        include "../views/footer.php";
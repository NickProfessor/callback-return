<?php


require_once "../models/Projeto.php";

if (isset($_GET["id"]) && $_GET["id"] != "") {

    $sala = $_GET["id"];
    $pageTitle = "Sala $sala | CallbackReturn";
    include "../views/header.php";
    echo "<h1>Sala $sala</h1>";

    $projeto = new Projeto();

    $listaDeProjetos = $projeto->obterProjetosDaSala($sala);
    ?>
    <a href="../../index.php">Voltar para tela principal</a>
    <?php

    if (empty($listaDeProjetos)) {
        echo "Nenhum projeto encontrado para a sala $sala.";
    } else {

        foreach ($listaDeProjetos as $projeto) {

            $projetoId = $projeto['id_projeto'];
            $projetoNome = $projeto['projeto_nome'];
            $projetoSala = $projeto['sala_numero'];
            $projetoCursos = $projeto['cursos'];
            $projetoDescricao = $projeto['projeto_descricao'];
            $projetoIntegrantes = $projeto['integrantes'];
            $projetoTemas = $projeto['temas'];
            $projetoAvaliacoes = $projeto['total_avaliacoes'];
            $projetoMediaAvaliacoes = $projeto['media_notas'];

            $popularAdultos = isset($projeto['popular_adultos']) && $projeto['popular_adultos'];
            $popularJovens = isset($projeto['popular_jovens']) && $projeto['popular_jovens'];
            $popularIdosos = isset($projeto['popular_idosos']) && $projeto['popular_idosos'];
            $popularMulheres = isset($projeto['popular_mulheres']) && $projeto['popular_mulheres'];
            $popularHomens = isset($projeto['popular_homens']) && $projeto['popular_homens'];

            include "../views/cardProjeto.php";
        }
    }
} else {
    $pageTitle = "Não encontrado | CallbackReturn";
    include "../views/header.php";
    echo "Página não encontrada 404";
}

include "../views/footer.php";
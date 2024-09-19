<?php

require_once "../models/Projeto.php";

if (isset($_GET["id"]) && $_GET["id"] != "") {

    $projetoId = $_GET["id"];

    $projetoExiste = Projeto::obterProjetoPeloId($projetoId);

    if (!$projetoExiste) {
        $pageTitle = "Projeto não encontrado | CallbackReturn";
        include "../views/header.php";
        echo "<h1>Projeto não encontrado</h1>";
    } else {
        $projeto = Projeto::obterDetalhesDoProjeto($projetoId);

        $projetoNome = $projeto['projeto_nome'];
        $projetoSala = $projeto['sala_numero'];
        $projetoCursos = $projeto['cursos'];
        $projetoDescricao = $projeto['projeto_descricao'];
        $projetoIntegrantes = $projeto['integrantes'];
        $projetoTemas = $projeto['temas'];
        $projetoAvaliacoes = $projeto['total_avaliacoes'];
        $projetoMediaAvaliacoes = $projeto['media_notas'];

        $comentariosBrutos = explode(' | ', $projeto['comentarios']);

        // No seu arquivo PHP onde você processa os dados
        $projetoComentarios = array_filter($comentariosBrutos, function ($comentario) {
            // Remove espaços em branco antes e depois do comentário
            $comentario = trim($comentario);
            // Verifica se o comentário é exatamente "Sem comentario" ou "sem comentario"
            return $comentario !== 'Sem comentario' && $comentario !== 'sem comentario' && !empty($comentario);
        });




        $popularAdultos = isset($projeto['popular_adultos']) && $projeto['popular_adultos'];
        $popularJovens = isset($projeto['popular_jovens']) && $projeto['popular_jovens'];
        $popularIdosos = isset($projeto['popular_idosos']) && $projeto['popular_idosos'];
        $popularMulheres = isset($projeto['popular_mulheres']) && $projeto['popular_mulheres'];
        $popularHomens = isset($projeto['popular_homens']) && $projeto['popular_homens'];

        include "../views/projetoDetalhado.php";
    }
} else {
    $pageTitle = "Não encontrado | CallbackReturn";
    include "../views/header.php";
    echo "Página não encontrada 404";
}

include "../views/footer.php";

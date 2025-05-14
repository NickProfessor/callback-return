<?php

require_once "../helpers/SessionManager.php";
require_once "../models/Projeto.php";

if (isset($_GET["projeto"]) && $_GET["projeto"] != "") {

    $projetoId = $_GET["projeto"];

    $projetoExiste = Projeto::obterProjetoPeloId($projetoId);

    if (!$projetoExiste) {
        $page = "detalhesProjeto";
        $pageTitle = "Projeto não encontrado | CallbackReturn";
        include "../views/header.php";
        echo "<h1>Projeto não encontrado</h1>";
    } else {
        $usuario = SessionManager::get("usuario");
        $projeto = Projeto::obterDetalhesDoProjeto($projetoId);

        $projetoNome = $projeto['projeto_nome'];
        $projetoCursos = $projeto['cursos'];
        $projetoResumo = $projeto['projeto_resumo'];
        $projetoDescricao = $projeto['projeto_descricao']; // Não usamos nl2br aqui
        $projetoMaterialApoio = $projeto['projeto_material_apoio'] ?? null;
        $projetoAlunos = explode(',', $projeto['alunos']);
        $projetoTemas = explode(',', $projeto['temas']);
        $projetoAvaliacoes = $projeto['total_avaliacoes'];
        $projetoMediaAvaliacoes = $projeto['media_notas'];

        $comentariosBrutos = explode(' | ', $projeto['comentarios']);

        // Filtra comentários válidos
        $projetoComentarios = array_filter($comentariosBrutos, function ($comentario) {
            // Remove espaços em branco antes e depois do comentário
            $comentario = trim($comentario);
            // Verifica se o comentário é exatamente "Sem comentario" ou "sem comentario"
            return $comentario !== 'Sem comentario' && $comentario !== 'sem comentario' && !empty($comentario);
        });

        if (isset($usuario) && ($usuario['tipo_usuario'] == 2)) {
            $usuarioAdm = true;
        } elseif (isset($usuario) && $usuario['tipo_usuario'] == 4) {
            $usuarioProfessor = true;
        }

        $popularAdultos = isset($projeto['popular_adultos']) && $projeto['popular_adultos'];
        $popularJovens = isset($projeto['popular_jovens']) && $projeto['popular_jovens'];
        $popularIdosos = isset($projeto['popular_idosos']) && $projeto['popular_idosos'];
        $popularMulheres = isset($projeto['popular_mulheres']) && $projeto['popular_mulheres'];
        $popularHomens = isset($projeto['popular_homens']) && $projeto['popular_homens'];

        $page = "detalhesProjeto";
        $pageTitle = "$projetoNome | CallbackReturn";
        include "../views/header.php";
        include "../views/projetoDetalhado.php";
    }
} else {
    $pageTitle = "Não encontrado | CallbackReturn";
    include "../views/header.php";
    echo "Página não encontrada 404";
}


include "../views/footer.php";
?>
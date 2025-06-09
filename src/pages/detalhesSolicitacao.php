<?php

require_once "../helpers/SessionManager.php";
require_once "../models/Projeto.php";

if (isset($_GET["projeto"]) && $_GET["projeto"] != "") {

    $projetoId = $_GET["projeto"];

    $projetoExiste = Projeto::obterSolicitacaoPeloId($projetoId);

    if (!$projetoExiste) {
        $page = "detalhesProjeto";
        $pageTitle = "Solicitacão não encontrado | CallbackReturn";
        include "../views/header.php";
        echo "<h1>Projeto não encontrado</h1>";
    } else {
        $usuario = SessionManager::get("usuario");
        $projeto = Projeto::obterDetalhesDaSolicitacao($projetoId);

        $projetoNome = $projeto['projeto_nome'];
        $projetoCursos = $projeto['cursos'];
        $projetoResumo = $projeto['projeto_resumo'];
        $projetoDescricao = $projeto['projeto_descricao']; // Não usamos nl2br aqui
        $projetoMaterialApoio = $projeto['projeto_material_apoio'] ?? null;
        $projetoAlunos = explode(',', $projeto['alunos']);
        $projetoTemas = explode(',', $projeto['temas']);



        if (isset($usuario) && ($usuario['tipo_usuario'] == 2)) {
            $usuarioAdm = true;
        } elseif (isset($usuario) && $usuario['tipo_usuario'] == 4) {
            $usuarioProfessor = true;
        }

        $page = "detalhesProjeto";
        $pageTitle = "$projetoNome | CallbackReturn";
        include "../views/header.php";
        include "../views/solicitacaoDetalhada.php";
    }
} else {
    $pageTitle = "Não encontrado | CallbackReturn";
    include "../views/header.php";
    echo "Página não encontrada 404";
}


include "../views/footer.php";
?>
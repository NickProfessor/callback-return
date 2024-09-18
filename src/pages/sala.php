<?php

require_once "../models/Projeto.php";

$projeto = new Projeto();
$sala = "1";

$listaDeProjetos = $projeto->obterProjetosDaSala($sala);

if (empty($listaDeProjetos)) {
    echo "Nenhum projeto encontrado para a sala $sala.";
} else {

    foreach ($listaDeProjetos as $projeto) {

        echo "Nome do Projeto: " . $projeto['projeto_nome'] . "<br>";
        echo "Sala do Projeto: " . $projeto['sala_numero'] . "<br>";
        echo "Curso do Projeto: " . $projeto['cursos'] . "<br>";
        echo "Integrantes do Projeto: " . $projeto['integrantes'] . "<br>";
        echo "Temas do Projeto: " . $projeto['temas'] . "<br>";
        echo "Avaliações do Projeto: " . $projeto['total_avaliacoes'] . "<br>";
        echo "Média de avaliações do projeto" . $projeto['media_notas'] . "<br>";
        if ($projeto['popular_adultos']) {
            echo "Popular entre adultos <br>";
        }
        if ($projeto['popular_jovens']) {
            echo "Popular entre joves <br>";
        }
        if ($projeto['popular_idosos']) {
            echo "Popular entre idosos <br>";
        }
        if ($projeto['popular_mulheres']) {
            echo "Popular entre mulheres <br>";
        }
        if ($projeto['popular_homens']) {
            echo "Popular entre homens <br>";
        }
        echo "<br><br>";
    }
}
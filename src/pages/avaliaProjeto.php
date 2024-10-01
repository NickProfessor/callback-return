<?php
require_once "../models/Projeto.php";

$page = "avaliaProjeto";
$pageTitle = "Avaliando | CallBackReturn";




if (isset($_GET["id"]) && $_GET["id"] != "") {

    if (isset($_GET["erro"]) && $_GET["erro"] == "nota-invalida") {
        $notaInvalida = true;
    }
    $projetoId = $_GET["id"];
    $projeto = Projeto::obterProjetoPeloId($projetoId);

    $projetoNome = $projeto['nome'];

    include "../views/header.php";
    $etapa = 5;
    include "../views/formulario.php";
} else {
    include "../views/header.php";
    echo "Algo deu errado";
}
include "../views/footer.php";

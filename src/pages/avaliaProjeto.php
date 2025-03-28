<?php
require_once "../models/Projeto.php";
require_once "../helpers/SessionManager.php";

$page = "avaliaProjeto";
$pageTitle = "Avaliando | CallBackReturn";



include "../views/header.php";

if (isset($_GET["projeto"]) && $_GET["projeto"] != "") {
    if(SessionManager::isLoggedIn()) {
        if (isset($_GET["erro"]) && $_GET["erro"] == "nota-invalida") {
            $notaInvalida = true;
        }
        $projetoId = $_GET["projeto"];
        $projeto = Projeto::obterProjetoPeloId($projetoId);

        $projetoNome = $projeto['nome'];

        $etapa = 5;
        include "../views/formulario.php";
    }else {
        $etapa = 1;
        include "../views/formulario.php";
    }
} else {
    include "../views/header.php";
    echo "Algo deu errado";
}
include "../views/footer.php";

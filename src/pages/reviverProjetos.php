<?php

require_once __DIR__ . "/../../config/config.php";
require_once '../../config/db_connect.php';


global $conn;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reviver'])) {
    $sql = "UPDATE projeto SET ativo = 1 WHERE ativo = 0";
    if ($conn->query($sql) === TRUE) {
        echo "Todos os projetos excluídos foram reativados com sucesso!";
    } else {
        echo "Erro ao reativar os projetos: " . $conn->error;
    }
    echo "<br>";
    echo "<a href='../../index.php'>Voltar para página principal</a>";
}
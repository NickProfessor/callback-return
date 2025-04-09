<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reviver'])) {
    $sql = "UPDATE projetos SET ativo = 1 WHERE ativo = 0";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute()) {
        echo "Todos os projetos excluídos foram reativados com sucesso!";
    } else {
        echo "Erro ao reativar os projetos.";
    }
}
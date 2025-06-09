<?php
require_once "../models/Projeto.php"; // ou Solicitação.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idProjeto = $_POST['id_projeto'];
    $campos = ['titulo', 'cursos', 'temas', 'descricao', 'alunos', 'material'];
    $reprovado = false;
    $comentarios = [];

    foreach ($campos as $campo) {
        $status = $_POST["status_$campo"] ?? 'aprovado';
        $comentario = trim($_POST["comentario_$campo"] ?? '');

        if ($status === 'reprovado') {
            $reprovado = true;
        }

        $comentarios[$campo] = [
            'status' => $status,
            'comentario' => $comentario
        ];
    }

    if ($reprovado) {
        Projeto::registrarRevisaoComReprovacao($idProjeto, $comentarios);
        header("Location: revisaoConfirmada.php?status=reprovado");
        exit;
    }

    // Aprovação completa: deixamos para depois
}

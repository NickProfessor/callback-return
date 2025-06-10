<?php
require_once "../helpers/SessionManager.php";
require_once "../models/Projeto.php"; // ou Solicitação.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idProjeto = $_POST['id_projeto'];
    $campos = ['titulo', 'cursos', 'resumo', 'temas', 'descricao', 'alunos', 'material'];
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

    } else {
        $projetoTemp = SessionManager::get("projeto_temp");

        if (!$projetoTemp) {
            echo "⚠️ Dados não encontrados na sessão.";
            exit();
        }



        // Extrair apenas os IDs
        $temasIds = array_map(fn($t) => is_array($t) ? $t['id'] : $t, $projetoTemp['temas']);
        $cursosIds = array_map(fn($c) => is_array($c) ? $c['id'] : $c, $projetoTemp['cursos']);
        $alunosIds = array_map(fn($a) => is_array($a) ? $a['id'] : $a, $projetoTemp['alunos']);

        $projetoController = new Projeto(
            $projetoTemp['nome'],
            $projetoTemp['resumo'],
            $projetoTemp['descricao'],
            $temasIds,
            $cursosIds,
            $alunosIds,
            $projetoTemp['material_apoio'] ?? null
        );


        $projetoController->cadastraProjeto();
        $projetoController->aprovaSolicitacao($idProjeto);
        // Se chegou aqui, os dados existem:
        SessionManager::forget('projeto_temp');

        header("Location: revisaoConfirmada.php");
        // Aprovação completa: deixamos para depois
    }
}
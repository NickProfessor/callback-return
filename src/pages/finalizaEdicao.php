<?php
require_once "../models/Projeto.php";

$idProjeto = $_POST['id_projeto'];
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../index.php?impossivel-acessar-pagina");
    exit;
}

if (!isset($_POST['nome'], $_POST['descricao'], $_POST['cursos'], $_POST['temas'], $_POST['alunos'])) {
    header("Location: ./editarProjeto.php?projeto=$idProjeto&&erro=dados-insuficientes");
    exit;
}



$nomeProjeto = $_POST['nome'];
$resumoProjeto = $_POST['resumo'];
$descricaoProjeto = str_replace('<br>', "\n", $_POST['descricao']);
$temasProjeto = $_POST['temas'];
$cursosProjeto = $_POST['cursos'];

if (isset($_POST['alunos']) && is_array($_POST['alunos'])) {
    $alunosProjeto = $_POST['alunos']; // Array com IDs dos alunos selecionados
} else {
    header("Location: ./editarProjeto.php?projeto=$idProjeto&&erro=nao-contem-alunos");
}


// Diretório de upload
$diretorioDestino = __DIR__ . "/../uploads/";

// Cria o diretório, se não existir
if (!is_dir($diretorioDestino)) {
    mkdir($diretorioDestino, 0755, true);
}

$caminhoRelativo = null; // Caso não haja upload, o valor será NULL

$projeto = Projeto::obterDetalhesDoProjeto($idProjeto);
$arquivoAntigo = $projeto['projeto_material_apoio']; // exemplo

if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] === UPLOAD_ERR_OK) {
    $arquivo = $_FILES['arquivo'];

    // Extensões permitidas
    $extensoesPermitidas = ['pdf', 'ppt', 'pptx', 'doc', 'docx'];
    $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));

    if (!in_array($extensao, $extensoesPermitidas)) {
        header("Location: ./editarProjetos.php?projeto=$idProjeto&&erro=arquivo-invalido");
        exit;
    }

    // Nome único para evitar conflitos
    $novoNome = uniqid() . "." . $extensao;
    $caminhoFinal = $diretorioDestino . $novoNome;

    if (move_uploaded_file($arquivo['tmp_name'], $caminhoFinal)) {
        $caminhoRelativo = "uploads/" . $novoNome;

        // Excluir o arquivo antigo, se existir
        if (!empty($arquivoAntigo) && file_exists($arquivoAntigo)) {
            unlink($arquivoAntigo);
        }
    } else {
        header("Location: ./editarProjetos.php?projeto=$idProjeto&&erro=upload-falhou");
        exit;
    }
} else {
    // Nenhum novo arquivo enviado, mantém o arquivo antigo
    $caminhoRelativo = $arquivoAntigo;
}


$projetoController = new Projeto(
    $nomeProjeto,
    $resumoProjeto,
    $descricaoProjeto,
    $temasProjeto,
    $cursosProjeto,
    $alunosProjeto,
    $caminhoRelativo, // Adicionamos o caminho do arquivo ao objeto do projeto
    $idProjeto
);

$projetoController->editaProjeto();

// Página de confirmação
$page = "registraProjeto";
$pageTitle = "Projeto registrado";
include "../views/header.php";
$etapa = 8;
include "../views/formulario.php";
?>
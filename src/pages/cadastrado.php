<?php
require_once "../controllers/UserController.php";
require_once "../controllers/AlunoController.php";
require_once "../helpers/SessionManager.php";

$pageTitle = 'Cadastrado';
$page = "cadastrado";



if (isset($_SESSION['email'])) {

    $email = $_SESSION['email'];
    $nome = $_SESSION['nome'];
    $dataNasc = $_SESSION['dataNasc'];
    $sexo = $_SESSION['sexo'];
    $fraseSeguranca = $_SESSION["frase"] ?? $dataNasc;
    $fraseConfirmacao = $_SESSION["confirmacao"] ?? $dataNasc;

    if (isset($_GET['cadastro-aluno']) && $_GET['cadastro-aluno'] == true) {
        $ra = $_SESSION['ra'];
        $rm = $_SESSION['rm'];
        $serie = $_SESSION['serie'];
        $turma = $_SESSION['turma'];
        $curso = $_SESSION['curso'];
    } else {

        if ($fraseSeguranca !== $fraseConfirmacao) {
            header("Location: ./cadastroUsuario.php?erro=frase");
            exit();
        }




        if (!isset($email) || !isset($nome) || !isset($dataNasc) || !isset($sexo) || !isset($fraseSeguranca)) {
            header("Location: ../../index.php?erro=algo-deu-errado");
            exit();
        }
    }



    $userController = new UserController();

    $data = [
        "email" => $email,
        "nome" => $nome,
        "dataNasc" => $dataNasc,
        "sexo" => $sexo,
        "fraseSeguranca" => $fraseSeguranca,
    ];

    if (isset($_GET['cadastro-aluno']) && $_GET['cadastro-aluno'] == true) {
        $data['tipo_usuario'] = 3;
    }

    if ($userController->registraUsuario($data)) {
        $id = $userController->usuarioExiste($data['email']);
        if (isset($_GET['cadastro-aluno']) && $_GET['cadastro-aluno'] == true) {
            $alunoController = new AlunoController();
            $data = [
                "nome" => $nome,
                "ra" => $ra,
                "rm" => $rm,
                "turma" => $turma,
                "serie" => $serie,
                "curso" => $curso,
                "id_usuario" => $id
            ];
            $alunoController->registraAluno($data);
        }
        // TODO: REGISTRA O ALUNO E VERIFICA SE DEU TUDO CERTO
        $usuario = $userController->consultaDadosDoUsuario($id);
        SessionManager::destroy();
        SessionManager::set('usuario', $usuario);

        header("Location: ../../index.php?cadastrado-com-sucesso");
    } else {
        include "../views/header.php";
        echo "Não conseguiu registrar.";
        echo "<a href='../../index.php'>Voltar para página inicial</a>";
        session_unset();
        session_destroy();
    }

    include "../views/footer.php"
    ;


} else {
    header("Location: ../../index.php?email-nao-informado");
    exit();
}
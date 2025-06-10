<?php
$page = "projetoAvaliado";
$pageTitle = "Revisão feita";
include "../views/header.php";
?>

<?php
$status = $_GET['status'] ?? null
    ?>

<?php if (isset($status) && $status == 'reprovado'): ?>
    <h1 class="titulo-formulario">Solicitação reprovada com sucesso!</h1>
    <main>
        <p class="mensagem">Você reprovou a solicitação de projeto. Agora o aluno precisa revisar suas observações para
            enviar uma nova
            solicitação</p>
        <p class="mensagem">Agradecemos a colaboração</p>
        <a href="./solicitacoes.php" class="botao-padrao">Voltar para solicitações
            pendentes</a>
    </main>
<?php else: ?>
    <h1 class="titulo-formulario">Solicitação aprovada com sucesso!</h1>
    <main>
        <p class="mensagem">Você aprovou a solicitação. Agora a solicitação foi registrado no banco de dados como um projeto
        </p>
        <p class="mensagem">Agradecemos a colaboração</p>
        <a href="./solicitacoes.php" class="botao-padrao">Voltar para solicitações
            pendentes</a>
    </main>
<?php endif; ?>
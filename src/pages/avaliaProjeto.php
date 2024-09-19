<?php
$pageTitle = "Avaliando | CallBackReturn";
include "../views/header.php";

require_once "../models/Projeto.php";


if (isset($_GET["id"]) && $_GET["id"] != "") {
    $projetoId = $_GET["id"];
    $projeto = Projeto::obterProjetoPeloId($projetoId);
    ?>

    <p><?php echo htmlspecialchars($projeto['nome']) ?></p>

    <form action="projetoAvaliado.php" method="POST">
        <!-- Campo oculto para o ID do projeto -->
        <input type="hidden" name="id_projeto" value="<?php echo htmlspecialchars($projetoId); ?>">

        <label for="nota_projeto">Informe a nota</label>
        <input type="number" name="nota_projeto" id="nota_projeto" required>

        <label for="comentario_projeto">Faça algum comentário (opcional)</label>
        <textarea name="comentario_projeto" id="comentario_projeto" cols="40" rows="6"></textarea>

        <label for="id_usuario">Informe seu número de usuário:</label>
        <input type="number" name="id_usuario" id="id_usuario" required>

        <label for="frase">Informe sua frase de segurança</label>
        <input type="password" name="frase" id="frase" required>

        <input type="submit" value="Enviar nota">
    </form>


    <button type="button" onclick="history.back()">Voltar</button>
    <a href="./esqueceuOID.php">Esqueci meu ID</a>


    <?php
} else {
    echo "Algo deu errado";
}
include "../views/footer.php";
?>
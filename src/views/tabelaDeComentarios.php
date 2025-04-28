<main>
    <h1 class="titulo-formulario">Exclua comentários indesejados</h1>
    <a href="./detalhesProjeto.php?projeto=<?= $idProjeto ?>"> Voltar </a>
    <table class="tabela-padrao">
        <?php foreach ($comentarios as $comentario): ?>
            <tr>
                <td><?= $comentario['nome_usuario'] ?></td>
                <td>"<?= $comentario['comentario'] ?>"</td>
                <td><?= $comentario['data_avaliacao'] ?></td>
                <td class="celula-botao-excluir">
                    <form method='POST' action='excluirComentario.php'
                        onsubmit='return confirm(\"Tem certeza que deseja excluir este comentário?\")'>
                        <input type='hidden' name='id_avaliacao' value='<?= $comentario['id_avaliacao'] ?> '>
                        <input type='hidden' name="id_projeto" value="<?= $idProjeto ?>">
                        <button type='submit' class="botao-excluir">Excluir</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</main>
<div class="projeto-padrao" style="<?php if (isset($alunoRejeitado))
    echo 'background-color: rgb(252, 212, 208)'; ?>">
    <h2 class="projeto-titulo"><?php echo htmlspecialchars($projetoNome); ?></h2>
    <p class="projeto-cursos">Curso(s): <?php echo htmlspecialchars($projetoCursos); ?></p>
    <p class="projeto-temas">Temas:
        <?php foreach ($projetoTemas as $tema) {
            echo "$tema. ";
        } ?>
    </p>
    <p class="projeto-descricao">Resumo: <?php echo htmlspecialchars($projetoResumo); ?></p>


    <?php if ($projetoId): ?>
        <div class="projeto-final">
            <?php if (isset($solicitacao) && $solicitacao == true): ?>
                <br>
                <?php if (isset($alunoRejeitado)): ?>
                    <a href="./detalhesSolicitacaoRejeitada.php?projeto=<?php echo $projetoId ?> "
                        class="botao-padrao ver-detalhes-btn">Ver
                        detalhes <i class="fa-solid fa-arrow-right"></i></a>
                <?php else: ?>
                    <div class="projeto-secao-acoes">
                        <a href="./detalhesSolicitacao.php?projeto=<?php echo $projetoId ?> "
                            class="botao-padrao ver-detalhes-btn">Revisar projeto <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <?php if (isset($usuario) && ($usuario['tipo_usuario'] == 2 || $usuario['tipo_usuario'] == 4)): ?>
                    <div class="projeto-secao-avalia">
                        <i class="fa-solid fa-star"></i>
                        <p class="projeto-media">
                            <?php echo htmlspecialchars(number_format($projetoMediaAvaliacoes, 1)); ?>
                        </p>
                        <p class="projeto-avaliacoes">(<?php echo htmlspecialchars($projetoAvaliacoes); ?> avaliações)</p>
                    </div>
                <?php endif; ?>
                <div class="projeto-secao-acoes">
                    <a href="./src/pages/avaliaProjeto.php?projeto=<?php echo $projetoId ?>" class="projeto-avalia-btn">Avaliar
                        esse
                        projeto <i class="fa-solid fa-star black-star"></i></a>

                    <a href="./src/pages/detalhesProjeto.php?projeto=<?php echo $projetoId ?> "
                        class="botao-padrao ver-detalhes-btn">Ver
                        detalhes <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
<div class="projeto-padrao">
    <h2 class="projeto-titulo"><?php echo htmlspecialchars($projetoNome); ?></h2>
    <p class="projeto-cursos">Curso(s): <?php echo htmlspecialchars($projetoCursos); ?></p>
    <p class="projeto-temas">Temas:
        <?php foreach ($projetoTemas as $tema) {
            echo "$tema. ";
        } ?>
    </p>
    <p class="projeto-descricao">Descrição: <?php echo htmlspecialchars($projetoDescricao); ?></p>
    <div class="projeto-tags">
        <?php if ($popularJovens): ?>
            <img src="../assets/images/icone-jovem.svg" alt="" class="tag-jovem tag"
                title="Popular entre jovens de 0 a 21 anos">
        <?php endif; ?>

        <?php if ($popularAdultos): ?>
            <img src="../assets/images/icone-adulto.svg" alt="" class="tag-adulto tag"
                title="Popular entre adultos de 22 a 59 anos">
        <?php endif; ?>

        <?php if ($popularIdosos): ?>
            <img src="../assets/images/icone-idoso.svg" alt="" class="tag-idoso tag"
                title="Popular idosos com mais de 60 anos">
        <?php endif; ?>

        <?php if ($popularHomens): ?>
            <img src="../assets/images/icone-homem.svg" alt="" class="tag-homem tag" title="Popular entre homens">
        <?php endif; ?>

        <?php if ($popularMulheres): ?>
            <img src="../assets/images/icone-mulher.svg" alt="" class="tag-mulher tag" title="Popular entre mulheres">
        <?php endif; ?>

    </div>

    <?php if ($projetoId): ?>
        <div class="projeto-final">
            <div class="projeto-secao-avalia">
                <i class="fa-solid fa-star"></i>
                <p class="projeto-media">
                    <?php echo htmlspecialchars(number_format($projetoMediaAvaliacoes, 1)); ?>
                </p>
                <p class="projeto-avaliacoes">(<?php echo htmlspecialchars($projetoAvaliacoes); ?> avaliações)</p>
            </div>
            <div class="projeto-secao-acoes">
                <a href="./avaliaProjeto.php?id=<?php echo $projetoId ?>" class="projeto-avalia-btn">Avaliar esse projeto <i
                        class="fa-solid fa-arrow-right"></i></a>
                <a href="./detalhesProjeto.php?id=<?php echo $projetoId ?> " class="botao-padrao">Ver detalhes <i
                        class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
    <?php endif; ?>
</div>
<div class="sala-padrao">
    <?php if (is_numeric($salaNumero)): ?>
        <h2 class="sala-titulo">Sala <?php echo htmlspecialchars($salaNumero); ?></h2>
    <?php else: ?>
        <h2 class="sala-titulo"><?php echo htmlspecialchars($salaNumero); ?></h2>
    <?php endif; ?>
    <div class="sala-projetos">
        <?php
        foreach ($listaProjetosArray as $projeto) {
            echo "<p class='sala-projeto'>" . htmlspecialchars($projeto) . "</p>";
        }
        ?>
    </div>
    <div class="sala-final">
        <div class="sala-secao-avalia">
            <i class="fa-solid fa-star"></i>
            <p class="sala-media">
                <?php echo htmlspecialchars(number_format($mediaNotas, 1)); ?>
            </p>
            <p class="sala-avaliacoes">(<?php echo htmlspecialchars($totalAvaliacoes); ?> avaliações)</p>
        </div>
        <?php if (is_numeric($salaNumero)): ?>
            <a href='./src/pages/sala.php?local=<?php echo htmlspecialchars($salaNumero); ?>' class="botao-padrao">Ir para
                sala <i class="fa-solid fa-arrow-right"></i></a>
        <?php else: ?>
            <a href='./src/pages/sala.php?local=<?php echo htmlspecialchars($salaNumero); ?>' class="botao-padrao">Ir para
                local <i class="fa-solid fa-arrow-right"></i></a>
        <?php endif; ?>
    </div>
</div>
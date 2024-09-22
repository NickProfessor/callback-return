<div class="sala-padrao">
    <h2 class="sala-titulo">Sala <?php echo htmlspecialchars($salaNumero); ?></h2>
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
        <a href='./src/pages/sala.php?id=<?php echo htmlspecialchars($salaNumero); ?>' class="botao-padrao">Ir para
            sala <i class="fa-solid fa-arrow-right"></i></a>
    </div>
</div>
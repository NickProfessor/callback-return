<div>
    <div>
        <h2>Sala <?php echo htmlspecialchars($salaNumero); ?></h2>
        <p>Projetos: <?php echo htmlspecialchars($listaProjetos); ?></p>
        <p>Total de Avaliações: <?php echo htmlspecialchars($totalAvaliacoes); ?></p>
        <p>Média das Notas: <?php echo htmlspecialchars(number_format($mediaNotas, 2)); ?></p>
        <a href='./src/pages/sala.php?id=<?php echo htmlspecialchars($salaNumero); ?>'>Ir para sala</a>
    </div>
</div>
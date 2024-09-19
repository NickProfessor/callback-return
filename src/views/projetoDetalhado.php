<div>
    <h2><?php echo htmlspecialchars($projetoNome); ?></h2>
    <p>Sala <?php echo htmlspecialchars($projetoSala); ?></p>
    <p><?php echo htmlspecialchars($projetoCursos); ?></p>
    <p><?php echo htmlspecialchars($projetoTemas); ?></p>
    <p><?php echo htmlspecialchars($projetoDescricao); ?></p>
    <p>Integrantes: <?php echo htmlspecialchars($projetoIntegrantes); ?></p>
    <p><?php echo htmlspecialchars($projetoMediaAvaliacoes); ?></p>
    <p><?php echo htmlspecialchars($projetoAvaliacoes); ?></p>

    <?php if ($popularAdultos): ?>
        <p>Popular entre adultos</p>
    <?php endif; ?>

    <?php if ($popularJovens): ?>
        <p>Popular entre jovens</p>
    <?php endif; ?>

    <?php if ($popularIdosos): ?>
        <p>Popular entre idosos</p>
    <?php endif; ?>

    <?php if ($popularMulheres): ?>
        <p>Popular entre mulheres</p>
    <?php endif; ?>

    <?php if ($popularHomens): ?>
        <p>Popular entre homens</p>
    <?php endif; ?>

    <div>
        <h3>Comentários:</h3>
        <?php if (!empty($projetoComentarios)): ?>
            <ul>
                <?php foreach ($projetoComentarios as $comentario): ?>
                    <li><?php echo htmlspecialchars($comentario); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Sem comentários.</p>
        <?php endif; ?>
    </div>

    <?php if ($projetoId): ?>
        <a href="./avaliaProjeto.php?id=<?php echo $projetoId ?>">Avaliar projeto</a>
        <a href="./sala.php?id=<?php echo $projetoSala ?>">Voltar para a sala <?php echo $projetoSala ?></a>
    <?php endif; ?>
</div>
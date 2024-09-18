<div>
    <h2><?php echo htmlspecialchars($projetoNome); ?></h2>
    <p><?php echo htmlspecialchars($projetoCursos); ?></p>
    <p><?php echo htmlspecialchars($projetoTemas); ?></p>
    <p><?php echo htmlspecialchars($projetoDescricao); ?></p>
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
</div>
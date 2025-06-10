<body>
    <header>
        <h1 class="titulo-header">CallbackReturn</h1>
        <?php if (!isset($usuario)): ?>
            <a href="./cadastroUsuario.php" class="link-header">Cadastre se ou consulte o ID</a>
        <?php endif; ?>
        <a href="../../index.php" class="botao-padrao"><i class="fa-solid fa-arrow-left"></i>
            Voltar</a>
    </header>
    <main>
        <h2 class="projeto-titulo"><?php echo htmlspecialchars($projetoNome); ?></h2>

        <?php if (isset($usuarioAdm) || isset($usuarioProfessor)): ?>
            <div class="projeto-avaliacoes">
                <i class="fa-solid fa-star"></i>
                <p><?php echo htmlspecialchars(number_format($projetoMediaAvaliacoes, 1)); ?></p>
                <p>(<?php echo htmlspecialchars($projetoAvaliacoes); ?> avaliações)</p>
            </div>
        <?php endif; ?>
        <div class="projeto-info">
            <p>Curso(s):</p>
            <p class="projeto-info-desc"><?php echo htmlspecialchars($projetoCursos); ?></p>
        </div>
        <div class="projeto-info">
            <p>Temas:</p>
            <div class="projeto-info-desc">
                <?php foreach ($projetoTemas as $tema): ?>
                    <p><?php echo htmlspecialchars($tema); ?></p>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="projeto-info">
            <p>Descrição:</p>
            <p class="projeto-info-desc" id="projeto-descricao" style="white-space: pre-wrap;">
                <?php echo htmlspecialchars($projetoDescricao); ?>
            </p>
        </div>
        <div class="projeto-info">
            <p>Alunos:</p>
            <div class="projeto-info-desc">
                <?php foreach ($projetoAlunos as $aluno): ?>
                    <p><?php echo htmlspecialchars($aluno); ?></p>
                <?php endforeach; ?>
            </div>
        </div>


        <a href="./avaliaProjeto.php?projeto=<?php echo $projetoId ?>" class="botao-padrao">Clique aqui para avaliar o
            projeto</a>
        <?php if ($projetoMaterialApoio): ?>
            <a href="./../<?php echo $projetoMaterialApoio ?>" class="botao-padrao" target="_blank">Clique aqui para acessar
                o
                material</a>
        <?php endif; ?>
        <?php if (isset($usuarioAdm)): ?>
            <a href="./excluiProjeto.php?projeto=<?= $projetoId ?>" class="botao-padrao botao-excluir"
                onclick="return confirm('Tem certeza que deseja excluir este projeto?')">Excluir esse
                projeto</a>
            <a href="./revisaComentarios.php?projeto=<?= $projetoId ?>" class="botao-padrao botao-editar">Revisar
                comentários</a>
            <a href="./editarProjeto.php?projeto=<?= $projetoId ?>" class="botao-padrao botao-editar">Editar projeto</a>
        <?php endif; ?>

        <div class="projeto-comentarios">
            <p>Comentários:</p>
            <?php if (!empty($projetoComentarios)): ?>

                <?php foreach ($projetoComentarios as $comentario): ?>
                    <p class="projeto-comentario"><?php echo htmlspecialchars($comentario); ?></p>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Sem comentários.</p>
            <?php endif; ?>
        </div>




    </main>

    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
        var descricao = <?php echo json_encode($projetoDescricao, JSON_HEX_TAG); ?>;
        document.getElementById("projeto-descricao").innerHTML = marked.parse(descricao);
    </script>
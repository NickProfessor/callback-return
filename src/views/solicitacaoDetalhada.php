<body>
    <header>
        <h1 class="titulo-header">CallbackReturn</h1>
        <?php if (!isset($usuario)): ?>
            <a href="./cadastroUsuario.php" class="link-header">Cadastre se ou consulte o ID</a>
        <?php endif; ?>
        <a href="./solicitacoes.php" class="botao-padrao"><i class="fa-solid fa-arrow-left"></i>
            Voltar</a>
    </header>
    <main class="solicitacao">
        <p>O projeto será apresentado dessa forma na tela de DETALHES:</p>
        <br>
        <p>Nome do Projeto:</p>
        <h2 class="projeto-titulo"><?php echo htmlspecialchars($projetoNome); ?></h2>


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





    </main>
    <section class="revisao-section">
        <form method="POST" action="processaRevisao.php" class="form-revisao">
            <?php
            $campos = [
                'titulo' => 'Título do Projeto: ',
                'cursos' => 'Cursos do Projeto',
                'temas' => 'Temas do Projeto',
                'resumo' => "Resumo do Projeto (na tela inicial): '$projetoResumo'",
                'descricao' => 'Descrição do Projeto',
                'alunos' => 'Alunos do Projeto',
                'material' => 'Material de Apoio'
            ];

            foreach ($campos as $campo => $label):
                ?>
                <div class="bloco-revisao">
                    <h3>Sobre o <?php echo $label; ?></h3>
                    <label>
                        <input type="radio" name="status_<?php echo $campo; ?>" value="aprovado" required>
                        Aprovar
                    </label>
                    <label>
                        <input type="radio" name="status_<?php echo $campo; ?>" value="reprovado">
                        Reprovar
                    </label>
                    <textarea name="comentario_<?php echo $campo; ?>" placeholder="Comentário (se reprovado)"></textarea>
                </div>
            <?php endforeach; ?>

            <input type="hidden" name="id_projeto" value="<?php echo htmlspecialchars($projetoId); ?>">
            <button type="submit" class="botao-padrao">Enviar Revisão</button>
        </form>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
        var descricao = <?php echo json_encode($projetoDescricao, JSON_HEX_TAG); ?>;
        document.getElementById("projeto-descricao").innerHTML = marked.parse(descricao);
    </script>
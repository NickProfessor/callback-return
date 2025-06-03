<?php if ($etapa == 1): ?>

    </div>
    <h1 class="titulo-formulario">Registre-se para avaliar os projetos</h1>
    <form action="confirmarCadastro.php" method="POST" class="formulario-padrao">


        <a href="./login.php">Já tem cadastro?</a>
        <div class="form-group">
            <label for="nome">Informe seu nome:</label>
            <input type="nome" name="nome" id="nome" class="campo-texto" placeholder="Clóvis da Silva" required>
            <div class="form-group">
                <label for="nome">Informe seu email:</label>
                <input type="email" name="email" id="email" class="campo-texto" placeholder="Clóvis da Silva" required>
            </div>
            <div class="form-group">
                <label for="dataNasc">Informe sua data de nascimento</label>
                <input type="date" name="dataNasc" id="dataNasc" class="campo-texto" required>
            </div>
            <div class="form-group">
                <p>Informe seu sexo:</p>
                <div class="radio-formulario">
                    <input type="radio" name="sexo" id="masculino" value="masculino" required>
                    <label for="masculino">Masculino</label>
                </div>
                <div class="radio-formulario">
                    <input type="radio" name="sexo" id="feminino" value="feminino" required>
                    <label for="feminino">Feminino</label>
                </div>

                <div class="radio-formulario">
                    <input type="radio" name="sexo" id="outro" value="outro" required>
                    <label for="outro">Prefiro não informar</label>
                </div>
            </div>

            <div class="form-group">
                <label for="frase">Informe uma frase de segurança:</label>
                <input type="password" name="frase" id="frase" class="campo-texto" required>
            </div>
            <!-- Checkbox para mostrar/ocultar senha -->
            <div class="checkbox-formulario checkbox-exibeSenha">
                <input type="checkbox" id="mostrarSenha" onclick="toggleSenha()">
                <label for="mostrarSenha">Exibir frase de segurança</label>
            </div>
            <br>
            <div class="form-group">
                <label for="confirmacao">Repita a frase de segurança:</label>
                <input type="password" name="confirmacao" id="confirmacao" class="campo-texto" required>
            </div>



            <div class="checkbox-formulario">
                <input type="checkbox" name="termos" id="termos" required>
                <label for="termos">Aceito que o software utilize os dados coletados para fins acadêmicos</label>

            </div>
            <div class="botoes-formulario">
                <button type="button" onclick="history.back()">Voltar</button>
                <button>Continuar <i class="fa-solid fa-arrow-right"></i></button>
            </div>
    </form>


    <script>
        const fraseInput = document.querySelector("input[name='frase']");
        const confirmacaoInput = document.querySelector("input[name='confirmacao']");
        const formGroup = confirmacaoInput.parentNode;

        function validarFrases() {
            // Remove a mensagem de erro caso exista
            let erroExistente = document.querySelector(".erro-frase");
            if (erroExistente) {
                erroExistente.remove();
            }

            // Valida se as frases de segurança coincidem
            if (fraseInput.value !== confirmacaoInput.value) {
                const erroData = document.createElement("p");
                erroData.classList.add("erro-frase");
                erroData.style.color = "red";
                erroData.textContent = "As frases de segurança não coincidem!";

                // Insere o erro logo após o input de confirmação
                formGroup.appendChild(erroData);
            }
        }

        // Adiciona ouvintes de eventos para ambos os inputs
        fraseInput.addEventListener("input", validarFrases);
        confirmacaoInput.addEventListener("input", validarFrases);

        const form = document.querySelector("form");
        form.addEventListener("submit", validarFrase);

        function validarFrase(e) {
            var frase = document.getElementsByName('frase')[0].value;
            var confirmacaoFrase = document.getElementsByName('confirmacao')[0].value;

            if (frase !== confirmacaoFrase) {
                alert("As frases de segurança não coincidem!");
                e.preventDefault(); // Impede o envio do formulário
            }
        }

        function toggleSenha() {
            const frase = document.getElementById("frase");
            const confirmacao = document.getElementById("confirmacao");
            const tipo = frase.type === "password" ? "text" : "password";
            frase.type = tipo;
            confirmacao.type = tipo;
        }
    </script>



<?php elseif ($etapa == 2): ?>


    <h1 class="titulo-formulario">Entre na sua conta para avaliar projetos</h1>
    <form action="logado.php" method="POST" class="formulario-padrao">


        <?php if (isset($_GET['dados-incorretos'])): ?>
            <p class="mensagem-erro">Algo deu errado. Confirme os dados</p>
        <?php endif; ?>
        <a href="./cadastroUsuario.php">Não possui cadastro? Crie uma conta</a>
        <div class="form-group">
            <label for="nome">Informe seu email:</label>
            <input type="email" name="email" id="email" class="campo-texto" placeholder="Clóvis da Silva" required>
        </div>

        <div class="form-group">
            <label for="frase">Informe sua frase de segurança:</label>
            <input type="password" name="frase" id="frase" class="campo-texto" required>
        </div>
        <!-- Checkbox para mostrar/ocultar senha -->
        <div class="checkbox">
            <input type="checkbox" id="mostrarSenha" onclick="toggleSenha()">
            <label for="mostrarSenha">Exibir frase de segurança</label>
        </div>

        <div class="botoes-formulario">
            <button type="button" onclick="window.location.href='../../index.php'">Voltar para a tela principal</button>
            <button>Continuar <i class="fa-solid fa-arrow-right"></i></button>
        </div>

    </form>



    <script>
        const dataNascInput = document.querySelector("input[name='dataNasc']");

        dataNascInput.addEventListener("input", function () {
            const dataNasc = new Date(dataNascInput.value);
            const dataAtual = new Date();
            dataAtual.setHours(0, 0, 0, 0);

            // Verifica se o erro já existe, para evitar duplicação
            let erroExistente = document.querySelector(".erro-data");

            // Remove a mensagem de erro caso exista
            if (erroExistente) {
                erroExistente.remove();
            }

            // Valida a data
            if (dataNasc > dataAtual) {
                const erroData = document.createElement("p");
                erroData.classList.add("erro-data");
                erroData.textContent = "A data de nascimento não é válida.";

                // Insere o erro logo após o input de data
                dataNascInput.parentNode.appendChild(erroData);
            }
        });

        function toggleSenha() {
            const frase = document.getElementById("frase");
            const confirmacao = document.getElementById("confirmacao");
            const tipo = frase.type === "password" ? "text" : "password";
            frase.type = tipo;
            confirmacao.type = tipo;
        }
    </script>



<?php elseif ($etapa == 3): ?>


    <?php if (isset($registrado)): ?>
        <h1 class="titulo-formulario">Registrado com sucesso!</h1>
    <?php endif; ?>
    <?php if (isset($jaCadastrado)): ?>
        <h1 class="titulo-formulario">Você já possui cadastro!</h1>
    <?php endif; ?>
    <?php if (isset($recuperado)): ?>
        <h1 class="titulo-formulario">ID recuperado com sucesso!</h1>
    <?php endif; ?>
    <main>
        <p class="seu-id-eh">Seu ID é o </p>

        <p class="id-registrado" id="id-registrado"><?php echo htmlspecialchars($id) ?> <i
                class="fa-regular fa-copy icone-copiar" onclick="copiarTexto()"></i></p>
        <p class="alerta">Clique no ícone <i class="fa-regular fa-copy icone-texto" onclick="copiarTexto()"></i>
            para copiar o número
        </p>
        <p class="mensagem">Seu ID será necessário para avaliar qualquer projeto, então quarde ele</p>
        <a href="../../index.php" class="botao-voltar">Voltar para página principal</a>
    </main>
    <script>
        function copiarTexto() {
            // Seleciona o conteúdo da tag HTML
            const texto = document.getElementById("id-registrado").textContent;

            // Cria um elemento de input temporário para copiar o texto
            const inputTemporario = document.createElement("input");
            inputTemporario.setAttribute("value", texto);

            // Adiciona o input à página
            document.body.appendChild(inputTemporario);

            // Seleciona o conteúdo do input
            inputTemporario.select();
            inputTemporario.setSelectionRange(0, 99999); // Para dispositivos móveis

            // Copia o conteúdo selecionado para a área de transferência
            document.execCommand("copy");

            // Remove o input temporário da página
            document.body.removeChild(inputTemporario);

            // Cria a mensagem de feedback
            const mensagem = document.createElement("p");
            mensagem.textContent = "Texto copiado para a área de transferência!";
            mensagem.classList.add("mensagem-copiada"); // Classe opcional para estilização

            // Remove mensagem anterior, se existir
            const mensagemExistente = document.querySelector(".mensagem-copiada");
            if (mensagemExistente) {
                mensagemExistente.remove();
            }

            // Insere a mensagem logo após o ID registrado
            const idRegistrado = document.getElementById("id-registrado");
            idRegistrado.parentNode.insertBefore(mensagem, idRegistrado.nextSibling);
        }
    </script>
<?php elseif ($etapa == 4): ?>


    <h1 class="titulo-formulario">Recupere seu ID para avaliar projetos</h1>
    <form action="recuperaID.php" method="POST" class="formulario-padrao">
        <?php if (isset($erro)): ?>
            <p class="mensagem-erro">Dados incorretos. Certifique-se de que já tem um cadastro.</p>
        <?php endif; ?>
        <div class="form-group">
            <label for="nome">Informe seu nome completo:</label>
            <input type="text" name="nome" id="nome" class="campo-texto" placeholder="Clóvis da Silva" required>
        </div>
        <div class="form-group">
            <label for="dataNasc">Informe sua data de nascimento</label>
            <input type="date" name="dataNasc" id="dataNasc" class="campo-texto" required>
        </div>
        <div class="form-group">
            <p>Informe seu sexo:</p>
            <div class="radio-formulario">
                <input type="radio" name="sexo" id="masculino" value="masculino" required>
                <label for="masculino">Masculino</label>
            </div>
            <div class="radio-formulario">
                <input type="radio" name="sexo" id="feminino" value="feminino" required>
                <label for="feminino">Feminino</label>
            </div>

            <div class="radio-formulario">
                <input type="radio" name="sexo" id="outro" value="outro" required>
                <label for="outro">Prefiro não informar</label>
            </div>
        </div>
        <a href="./cadastroUsuario.php">Não tem cadastro?</a>

        <div class="botoes-formulario">
            <button type="button" onclick="window.location.href='../../index.php'">Voltar para a tela
                principal</button>
            <button>Continuar <i class="fa-solid fa-arrow-right"></i></button>
        </div>

    </form>



    <script>
        const dataNascInput = document.querySelector("input[name='dataNasc']");

        dataNascInput.addEventListener("input", function () {
            const dataNasc = new Date(dataNascInput.value);
            const dataAtual = new Date();
            dataAtual.setHours(0, 0, 0, 0);

            // Verifica se o erro já existe, para evitar duplicação
            let erroExistente = document.querySelector(".erro-data");

            // Remove a mensagem de erro caso exista
            if (erroExistente) {
                erroExistente.remove();
            }

            // Valida a data
            if (dataNasc > dataAtual) {
                const erroData = document.createElement("p");
                erroData.classList.add("erro-data");
                erroData.textContent = "A data de nascimento não é válida.";

                // Insere o erro logo após o input de data
                dataNascInput.parentNode.appendChild(erroData);
            }
        });
    </script>
<?php elseif ($etapa == 5): ?>


    <h1 class="titulo-formulario">Queremos saber sua opinião!</h1>

    <form action="projetoAvaliado.php" method="POST" class="formulario-padrao">
        <h2 class="projeto-nome"><?php echo htmlspecialchars($projeto['nome']) ?></h2>

        <?php if (isset($_GET['erro'])): ?>
            <p class="mensagem-erro">
                <?php
                switch ($_GET['erro']) {
                    case 'ja-avaliado':
                        echo "Você já avaliou esse projeto.";
                        break;
                    case 'falha-insercao':
                        echo "Ocorreu uma falha ao inserir sua avaliação. Tente novamente.";
                        break;
                    case 'preparacao-falha':
                        echo "Erro ao preparar a consulta. Entre em contato com o suporte.";
                        break;
                    case 'usuario-invalido':
                        echo "Usuário inválido ou frase de segurança incorreta.";
                        break;
                    default:
                        echo "Ocorreu um erro desconhecido.";
                }
                ?>
            </p>
        <?php endif; ?>
        <input type="hidden" name="id_projeto" value="<?php echo htmlspecialchars($projetoId); ?>">
        <input type="hidden" name="nome_projeto" value="<?php echo $projeto['nome'] ?>">
        <div class="form-group">
            <label for="nota_projeto">Como você avalia em geral esse projeto?</label>
            <div class="projeto-estrelas">
                <i class="fa-solid fa-star" data-value="1"></i>
                <i class="fa-solid fa-star" data-value="2"></i>
                <i class="fa-solid fa-star" data-value="3"></i>
                <i class="fa-solid fa-star" data-value="4"></i>
                <i class="fa-solid fa-star" data-value="5"></i>
                <i class="fa-solid fa-star" data-value="6"></i>
                <i class="fa-solid fa-star" data-value="7"></i>
                <i class="fa-solid fa-star" data-value="8"></i>
                <i class="fa-solid fa-star" data-value="9"></i>
                <i class="fa-solid fa-star" data-value="10"></i>
            </div>
            <input type="number" name="nota_projeto" id="nota_projeto" required style="display: none;">
        </div>

        <!-- PRECISA SER REFEITO!: -->
        <?php foreach ($perguntas as $pergunta): ?>
            <div class="form-group">
                <label for="pergunta<?= $pergunta['id_pergunta'] ?>">
                    <?= htmlspecialchars($pergunta['texto_pergunta']) ?>
                </label>

                <?php if ($pergunta['tipo_pergunta'] === "sim_nao"): ?>
                    <div class="form-group">
                        <div class="radio-formulario">
                            <input type="radio" name="pergunta[<?= $pergunta['id_pergunta'] ?>]"
                                id="resposta_sim_<?= $pergunta['id_pergunta'] ?>" value="sim" required>
                            <label for="resposta_sim_<?= $pergunta['id_pergunta'] ?>">Sim</label>
                        </div>
                        <div class="radio-formulario">
                            <input type="radio" name="pergunta[<?= $pergunta['id_pergunta'] ?>]"
                                id="resposta_nao_<?= $pergunta['id_pergunta'] ?>" value="não" required>
                            <label for="resposta_nao_<?= $pergunta['id_pergunta'] ?>">Não</label>
                        </div>
                    </div>
                <?php elseif ($pergunta['tipo_pergunta'] === "texto"): ?>
                    <textarea name="pergunta[<?= $pergunta['id_pergunta'] ?>]" id="pergunta<?= $pergunta['id_pergunta'] ?>"
                        cols="40" rows="6" class="campo-texto"></textarea>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <!-- PRECISA SER REFEITO!; -->
        <div class="form-group">
            <label for="comentario_projeto">Comente algo interessante (opcional)</label>
            <textarea name="comentario_projeto" id="comentario_projeto" cols="40" rows="6" class="campo-texto"></textarea>
        </div>



        <div class="checkbox-formulario">
            <input type="checkbox" name="termos" id="termos" required>
            <label for="termos">Aceito que o software utilize os dados coletados para fins acadêmicos</label>

        </div>




        <div class="botoes-formulario">
            <button type="button" onclick="history.back()">Voltar</button>
            <button>Avaliar projeto <i class="fa-solid fa-arrow-right"></i></button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const estrelas = document.querySelectorAll('.projeto-estrelas i');
            const notaInput = document.getElementById('nota_projeto');

            estrelas.forEach(estrela => {
                estrela.addEventListener('click', function () {
                    const valor = this.getAttribute('data-value');
                    notaInput.value = valor;

                    estrelas.forEach((estrela, index) => {
                        if (index < valor) {
                            estrela.classList.add('preenchida');
                        } else {
                            estrela.classList.remove('preenchida');
                        }
                    });
                });
            });
        });
    </script>


<?php elseif ($etapa == 6): ?>


    <?php if (isset($sucesso) && $sucesso == true): ?>
        <h1 class="titulo-formulario">Projeto avaliado com sucesso!</h1>
        <main>
            <p class="mensagem">Você avaliou o projeto "<?php echo $projetoNome ?>"</p>
            <p class="mensagem">Agradecemos a colaboração</p>
            <a href="./detalhesProjeto.php?projeto=<?php echo $id_projeto ?>" class="botao-padrao">Voltar para detalhes do
                projeto</a>
        </main>

    <?php else: ?>
        <h1 class="titulo-formulario">Algo deu errado...</h1>
        <main>
            <p class="mensagem">Algo não ocorreu como esperado. Certifique-se que é a primeira vez que está avaliando esse
                projeto</p>
            <p class="mensagem">Agradecemos a colaboração</p>
            <a href="./detalhesProjeto.php?projeto=<?php echo $id_projeto ?>" class="botao-padrao">Voltar para detalhes do
                projeto</a>
        </main>


    <?php endif; ?>

<?php elseif ($etapa == 7): ?>
    
     <?php if($admin): ?>
        <!-- REMOVER DEPOIS -->
    <a href="cadastroAluno.php">cadastrar aluno</a>
    <form method="POST" action="reviverProjetos.php">
        <button type="submit" name="reviver">Reviver todos os projetos excluídos</button>
    </form>

    <!-- REMOVER DEPOIS -->
    <h1 class="titulo-formulario">Registre um projeto</h1>
    <form action="registraProjeto.php" method="POST" class="formulario-padrao" enctype="multipart/form-data">
        <?php else:?>
            <h1 class="titulo-formulario">Solicite a criação de um projeto</h1>
    <form action="registraSolicitacao.php" method="POST" class="formulario-padrao" enctype="multipart/form-data">
    <?php endif;?>
        <?php if (isset($erro)): ?>
            <p class="mensagem-erro">

                <?php switch ($_GET['erro']) {
                    case 'projeto-ja-existe':
                        echo "Você já cadastrou esse projeto antes.";
                        break;
                    case 'dados-insuficientes':
                        echo "Você informou dados insuficientes.";
                        break;
                    default:
                        echo "Ocorreu um erro desconhecido.";
                } ?>
            </p>
        <?php endif; ?>
        <div class="form-group">
            <label for="nome">Informe o nome do projeto:</label>
            <input type="text" name="nome" id="nome" class="campo-texto" placeholder="Projeto de marketing" required>
        </div>

        <div class="form-group">
            <label for="arquivo">Anexe um arquivo (pdf, ppt, pptx, doc, docx):</label>
            <input type="file" name="arquivo" id="arquivo" class="campo-texto">
        </div>

        <div class="form-group">
            <label for="cursos">Informe os cursos do projeto</label>
            <div class="checkboxes">
                <?php foreach ($cursos as $id_curso => $curso): ?>
                    <div class="checkbox-formulario">
                        <input type="checkbox" name="cursos[]" id="<?php echo strtolower($curso) ?>"
                            value="<?php echo $id_curso ?>">
                        <label for="<?php echo strtolower($curso) ?>"><?php echo $curso ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>



        <div class="form-group">
            <label for="temas">Informe os temas do projeto</label>
            <div class="checkboxes">
                <?php foreach ($temas as $id_tema => $tema): ?>
                    <div class="checkbox-formulario">
                        <input type="checkbox" name="temas[]" id="<?php echo strtolower($tema . $id_tema) ?>"
                            value="<?php echo $id_tema ?>">
                        <label for="<?php echo strtolower($tema . $id_tema) ?>"><?php echo $tema ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="form-group">
            <label for="alunos">Selecione os alunos:</label>
            <div id="alunos-container">
                <div class="aluno-select">
                    <select name="alunos[]" class="aluno-dropdown" required>
                        <option value="">Selecione um aluno</option>
                        <?php foreach ($alunos as $aluno): ?>
                            <option value="<?= $aluno['id_aluno'] ?>"><?= $aluno['nome'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="button" class="remove-aluno" style="display:none;">Remover</button>
                </div>
            </div>
            <button type="button" id="add-aluno">Adicionar outro aluno</button>
        </div>


        <div class="form-group">
            <label for="resumo">Informe um resumo do projeto:</label>
            <textarea type="text" name="resumo" id="resumo" class="campo-texto" cols="40" rows="3" required></textarea>
        </div>

        <div class="form-group">
            <label for="descricao">Descreva com detalhes seu projeto:</label>
            <textarea type="text" id="descricao" class="campo-texto" cols="40" rows="8"></textarea>
            <input type="hidden" name="descricao" id="descricao-hidden" required>
        </div>


        <div class="botoes-formulario">
            <button type="button" onclick="window.location.href='../../index.php'">Voltar para a tela principal</button>
            <button type="submit">Continuar <i class="fa-solid fa-arrow-right"></i></button>
        </div>

    </form>
    <script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css">
    <script>
        document.getElementById("add-aluno").addEventListener("click", function () {
            let container = document.getElementById("alunos-container");

            // Criando novo select
            let div = document.createElement("div");
            div.classList.add("aluno-select");

            let select = document.createElement("select");
            select.name = "alunos[]";
            select.classList.add("aluno-dropdown");

            // Opção padrão
            let defaultOption = document.createElement("option");
            defaultOption.value = "";
            defaultOption.textContent = "Selecione um aluno";
            select.appendChild(defaultOption);

            // Adicionando alunos
            <?php foreach ($alunos as $aluno): ?>
                let option<?= $aluno['id_aluno'] ?> = document.createElement("option");
                option<?= $aluno['id_aluno'] ?>.value = "<?= $aluno['id_aluno'] ?>";
                option<?= $aluno['id_aluno'] ?>.textContent = "<?= $aluno['nome'] ?>";
                select.appendChild(option<?= $aluno['id_aluno'] ?>);
            <?php endforeach; ?>

            // Criando botão de remoção
            let removeButton = document.createElement("button");
            removeButton.type = "button";
            removeButton.classList.add("remove-aluno");
            removeButton.textContent = "Remover";

            removeButton.addEventListener("click", function () {
                div.remove();
            });

            div.appendChild(select);
            div.appendChild(removeButton);
            container.appendChild(div);
        });








        // Atualiza a pré-visualização ao digitar
        document.getElementById('descricao').addEventListener('input', function () {
            let inputText = this.value;
            let preview = document.getElementById('descricao-preview');

            preview.innerHTML = markdownToHtml(inputText);
        });



        var easyMDE = new EasyMDE({ element: document.getElementById("descricao") });

        document.querySelector("form").addEventListener("submit", function () {
            document.getElementById("descricao-hidden").value = easyMDE.value();
        });
    </script>


<?php elseif ($etapa == 8): ?>
    <h1 class="titulo-formulario">Projeto cadastrado com sucesso!</h1>
    <main>
        <p class="mensagem">Você cadastrou o projeto "<?php echo $nomeProjeto ?>"</p>
        <p class="mensagem">Agradecemos a colaboração</p>
        <a href="./criarProjetos.php" class="botao-padrao">Voltar para cadastrar mais projetos</a>
    </main>

<?php elseif ($etapa == 9): ?>
    <h1 class="titulo-formulario">Registre alunos</h1>
    <form action="confirmarCadastro.php" method="POST" class="formulario-padrao">


        <div class="form-group">
            <label for="nome">Informe o nome do aluno:</label>
            <input type="nome" name="nome" id="nome" class="campo-texto" placeholder="Clóvis da Silva" required>
        </div>
        <div class="form-group">
            <label for="nome">Informe o email do aluno:</label>
            <input type="email" name="email" id="email" class="campo-texto" placeholder="Clóvis da Silva" required>
        </div>
        <div class="form-group">
            <label for="dataNasc">Informe a data de nascimento do aluno</label>
            <input type="date" name="dataNasc" id="dataNasc" class="campo-texto" value="2000-01-01" required>
        </div>
        <div class="form-group">
            <p>Informe seu sexo:</p>
            <div class="radio-formulario">
                <input type="radio" name="sexo" id="masculino" value="masculino" required>
                <label for="masculino">Masculino</label>
            </div>
            <div class="radio-formulario">
                <input type="radio" name="sexo" id="feminino" value="feminino" required>
                <label for="feminino">Feminino</label>
            </div>

            <div class="radio-formulario">
                <input type="radio" name="sexo" id="outro" value="outro" checked required>
                <label for="outro">Prefiro não informar</label>
            </div>
        </div>

        <div class="form-group">
            <label for="ra">Informe o ra do aluno:</label>
            <input type="number" name="ra" id="ra" class="campo-texto" placeholder="11111" value="11111" required>
        </div>
        <div class="form-group">
            <label for="rm">Informe o rm do aluno:</label>
            <input type="number" name="rm" id="rm" class="campo-texto" placeholder="11111" value="11111" required>
        </div>

        <div class="form-group">
            <label for="serie">Informe a serie do aluno:</label>
            <input type="number" name="serie" id="serie" class="campo-texto" placeholder="11111" value="3" required>
        </div>

        <div class="form-group">
            <label for="turma">Informe a turma do aluno:</label>
            <input type="text" name="turma" id="turma" class="campo-texto" placeholder="11111" value="B" required>
        </div>


        <div class="form-group">
            <label for="cursos">Informe os cursos do projeto</label>
            <?php foreach ($cursos as $id_curso => $curso): ?>
                <div class="radio-formulario">
                    <input type="radio" name="curso" id="<?php echo strtolower($curso) ?>" value="<?php echo $id_curso ?>" <?php if ($id_curso == 8)
                              echo "checked" ?>>
                        <label for="<?php echo strtolower($curso) ?>"><?php echo $curso ?></label>
                </div>
            <?php endforeach; ?>
        </div>


        <div class="checkbox-formulario">
            <input type="checkbox" name="termos" id="termos" required>
            <label for="termos">Aceito que o software utilize os dados coletados para fins acadêmicos</label>

        </div>
        <div class="botoes-formulario">
            <button type="button" onclick="history.back()">Voltar</button>
            <button>Continuar <i class="fa-solid fa-arrow-right"></i></button>
        </div>
    </form>


    <script>
        const fraseInput = document.querySelector("input[name='frase']");
        const confirmacaoInput = document.querySelector("input[name='confirmacao']");
        const formGroup = confirmacaoInput.parentNode;

        function validarFrases() {
            // Remove a mensagem de erro caso exista
            let erroExistente = document.querySelector(".erro-frase");
            if (erroExistente) {
                erroExistente.remove();
            }

            // Valida se as frases de segurança coincidem
            if (fraseInput.value !== confirmacaoInput.value) {
                const erroData = document.createElement("p");
                erroData.classList.add("erro-frase");
                erroData.style.color = "red";
                erroData.textContent = "As frases de segurança não coincidem!";

                // Insere o erro logo após o input de confirmação
                formGroup.appendChild(erroData);
            }
        }

        // Adiciona ouvintes de eventos para ambos os inputs
        fraseInput.addEventListener("input", validarFrases);
        confirmacaoInput.addEventListener("input", validarFrases);

        const form = document.querySelector("form");
        form.addEventListener("submit", validarFrase);

        function validarFrase(e) {
            var frase = document.getElementsByName('frase')[0].value;
            var confirmacaoFrase = document.getElementsByName('confirmacao')[0].value;

            if (frase !== confirmacaoFrase) {
                alert("As frases de segurança não coincidem!");
                e.preventDefault(); // Impede o envio do formulário
            }
        }
    </script>


<?php elseif ($etapa == 10): ?>
    <h1 class="titulo-formulario">Projeto <b>excluído</b> com sucesso!</h1>
    <main>
        <p class="mensagem">Você excluiu o projeto "<?php echo $nomeProjeto ?>"</p>
        <p class="mensagem">Agradecemos a colaboração</p>
        <a href="../../index.php" class="botao-padrao">Voltar para a página principal</a>
    </main>

<?php elseif ($etapa == 11): ?>
    <h1 class="titulo-formulario">Editando um projeto</h1>
    <form action="finalizaEdicao.php" method="POST" class="formulario-padrao" enctype="multipart/form-data">
        <?php if (isset($erro)): ?>
            <p class="mensagem-erro">

                <?php switch ($_GET['erro']) {
                    case 'projeto-ja-existe':
                        echo "Você já cadastrou esse projeto antes.";
                        break;
                    case 'dados-insuficientes':
                        echo "Você informou dados insuficientes.";
                        break;
                    default:
                        echo "Ocorreu um erro desconhecido.";
                } ?>
            </p>
        <?php endif; ?>
        <input type="hidden" name="id_projeto" value="<?php echo $projeto['id_projeto']; ?>">

        <div class="form-group">
            <label for="nome">Informe o nome do projeto:</label>
            <input type="text" name="nome" id="nome" class="campo-texto" placeholder="Projeto de marketing"
                value="<?= $projeto['projeto_nome'] ?>" required>
        </div>

        <?php if($arquivoAtual):?>
        <label for="arquivo">Arquivo atual:</label><br>
    <a href="../<?php echo $arquivoAtual; ?>" target="_blank">Ver arquivo atual</a><br><br>

    <label for="arquivo">Trocar arquivo (opcional):</label><br>
    <input type="file" name="arquivo" id="arquivo"><br><br>

    <input type="hidden" name="arquivoAntigo" value="<?php echo $arquivoAtual; ?>">
    <?php else:?>
        <div class="form-group">
            <label for="arquivo">Anexe um arquivo (pdf, ppt, pptx, doc, docx):</label>
            <input type="file" name="arquivo" id="arquivo" class="campo-texto">
        </div>
        <?php endif;?>

        <div class="form-group">
            <label for="cursos">Informe os cursos do projeto</label>
            <div class="checkboxes">
                <?php foreach ($cursos as $id_curso => $curso): ?>
                    <div class="checkbox-formulario">
                        <?php foreach ($projetoCursos as $id_cursoProjeto => $cursoProjeto): ?>
                            <?php if ($cursoProjeto == $curso): ?>
                                <input type="checkbox" name="cursos[]" id="<?php echo strtolower($curso) ?>"
                                    value="<?php echo $id_curso ?>" checked>
                            <?php else: ?>
                                <input type="checkbox" name="cursos[]" id="<?php echo strtolower($curso) ?>"
                                    value="<?php echo $id_curso ?>">
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <label for="<?php echo strtolower($curso) ?>"><?php echo $curso ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>



        <div class="form-group">
            <label for="temas">Informe os temas do projeto</label>
            <div class="checkboxes">
                <?php foreach ($temas as $id_tema => $tema): ?>
                    <div class="checkbox-formulario">
                        <?php
                        $checked = in_array($tema, $projetoTemas) ? "checked" : "";
                        ?>
                        <input type="checkbox" name="temas[]" id="<?php echo strtolower($tema . $id_tema) ?>"
                            value="<?php echo $id_tema ?>" <?php echo $checked ?>>
                        <label for="<?php echo strtolower($tema . $id_tema) ?>"><?php echo $tema ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>






        <div class="form-group">
            <label for="alunos">Selecione os alunos:</label>
            <div id="alunos-container">
                <?php foreach ($alunosDoProjeto as $idSelecionado => $alunoDoProjeto): ?>
                    <div class="aluno-select">
                        <select name="alunos[]" class="aluno-dropdown" required>
                            <option value="">Selecione um aluno</option>
                            <?php foreach ($alunos as $aluno): ?>
                                <option value="<?= $aluno['id_aluno'] ?>" <?= $aluno['id_aluno'] == $idSelecionado ? 'selected' : '' ?>>
                                    <?= $aluno['nome'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="button" class="remove-aluno">Remover</button>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" id="add-aluno">Adicionar outro aluno</button>
        </div>


        <div class="form-group">
            <label for="resumo">Informe um resumo do projeto:</label>
            <textarea type="text" name="resumo" id="resumo" class="campo-texto" cols="40" rows="3"
                required><?= $projeto['projeto_resumo'] ?></textarea>
        </div>

        <div class="form-group">
            <label for="descricao">Descreva com detalhes seu projeto:</label>
            <textarea type="text" id="descricao" class="campo-texto" cols="40"
                rows="8"><?= $projeto['projeto_descricao'] ?></textarea>
            <input type="hidden" name="descricao" id="descricao-hidden" required>
        </div>


        <div class="botoes-formulario">
            <button type="button"
                onclick="window.location.href='./detalhesProjeto.php?projeto=<?= $projeto['id_projeto'] ?>'">Voltar para
                detalhes</button>
            <button type="submit">Continuar <i class="fa-solid fa-arrow-right"></i></button>
        </div>

    </form>
    <script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css">
    <script>
        document.getElementById("add-aluno").addEventListener("click", function () {
            let container = document.getElementById("alunos-container");

            // Criando novo select
            let div = document.createElement("div");
            div.classList.add("aluno-select");

            let select = document.createElement("select");
            select.name = "alunos[]";
            select.classList.add("aluno-dropdown");

            // Opção padrão
            let defaultOption = document.createElement("option");
            defaultOption.value = "";
            defaultOption.textContent = "Selecione um aluno";
            select.appendChild(defaultOption);

            // Adicionando alunos
            <?php foreach ($alunos as $aluno): ?>
                let option<?= $aluno['id_aluno'] ?> = document.createElement("option");
                option<?= $aluno['id_aluno'] ?>.value = "<?= $aluno['id_aluno'] ?>";
                option<?= $aluno['id_aluno'] ?>.textContent = "<?= $aluno['nome'] ?>";
                select.appendChild(option<?= $aluno['id_aluno'] ?>);
            <?php endforeach; ?>

            // Criando botão de remoção
            let removeButton = document.createElement("button");
            removeButton.type = "button";
            removeButton.classList.add("remove-aluno");
            removeButton.textContent = "Remover";

            removeButton.addEventListener("click", function () {
                div.remove();
            });

            

            div.appendChild(select);
            div.appendChild(removeButton);
            container.appendChild(div);
        });




// Delegação de eventos para remover alunos (funciona com elementos existentes e adicionados dinamicamente)
document.getElementById("alunos-container").addEventListener("click", function (event) {
    if (event.target.classList.contains("remove-aluno")) {
        event.target.parentElement.remove();
    }
});




        // Atualiza a pré-visualização ao digitar
        document.getElementById('descricao').addEventListener('input', function () {
            let inputText = this.value;
            let preview = document.getElementById('descricao-preview');

            preview.innerHTML = markdownToHtml(inputText);
        });



        var easyMDE = new EasyMDE({ element: document.getElementById("descricao") });

        document.querySelector("form").addEventListener("submit", function () {
            document.getElementById("descricao-hidden").value = easyMDE.value();
        });
    </script>
<?php endif; ?>
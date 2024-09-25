<?php if ($etapa == 1): ?>


    <h1 class="titulo-formulario">Registre-se para avaliar os projetos</h1>
    <form action="confirmarCadastro.php" method="POST" class="formulario-padrao">
        <div class="etapas-formulario">
            <img src="../assets/images/umDeDuas.png" alt="">
        </div>
        <?php if (isset($erro)): ?>
            <p class="mensagem-erro">Algo deu errado. Tente novamente</p>
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
        <a href="./esqueceuOID.php">Já tem cadastro?</a>

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
    </script>
<?php elseif ($etapa == 2): ?>



    <h1 class="titulo-formulario">Registre-se para avaliar os projetos</h1>
    <form action="cadastrado.php" method="POST" class="formulario-padrao">
        <div class="etapas-formulario">
            <img src="../assets/images/duasDeDuas.png" alt="">
        </div>

        <div class="form-group">
            <label for="frase">Informe uma frase de segurança:</label>
            <input type="password" name="frase" id="frase" class="campo-texto" required>
        </div>
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

        <?php if (isset($notaInvalida)): ?>
            <p>Informe uma nota válida</p>
        <?php endif; ?>

        <input type="hidden" name="id_projeto" value="<?php echo htmlspecialchars($projetoId); ?>">

        <div class="form-group">
            <label for="nota_projeto">Como avalia esse projeto?</label>
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

        <div class="form-group">
            <label for="comentario_projeto">Comente algo interessante (opcional)</label>
            <textarea name="comentario_projeto" id="comentario_projeto" cols="40" rows="6" class="campo-texto"></textarea>
        </div>

        <div class="form-group">
            <label for="id_usuario">Informe seu número de usuário (ID):</label>
            <input type="number" name="id_usuario" id="id_usuario" class="campo-texto" required>
        </div>

        <div class="form-group">
            <label for="frase">Informe sua frase de segurança</label>
            <input type="password" name="frase" id="frase" class="campo-texto" required>
        </div>

        <div class="checkbox-formulario">
            <input type="checkbox" name="termos" id="termos" required>
            <label for="termos">Aceito que o software utilize os dados coletados para fins acadêmicos</label>

        </div>

        <a href="./esqueceuOID.php">Esqueci meu ID</a>


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



<?php endif; ?>
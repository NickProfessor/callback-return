<?php

if ($etapa == 1) {
    ?>

    <body>
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

            <div class="botoes-formulario">
                <button type="button" onclick="window.location.href='../../index.php'">Voltar para a tela principal</button>
                <input type="submit" name="submit" value="Continuar">
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
        <?php
} else if ($etapa == 2) {
    ?>


            <body>
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
                        <button type="button" onclick="history.back()">Voltar para a tela principal</button>
                        <input type="submit" name="submit" value="Continuar">
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
            <?php
} else if ($etapa == 3) {
    ?>

                    <body>
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
                <?php
} else if ($etapa == 4) {
    ?>

                            <body>
                                <h1 class="titulo-formulario">Recupere seu ID para avaliar projetos</h1>
                                <form action="recuperaID.php" method="POST" class="formulario-padrao">
                        <?php if (isset($erro)): ?>
                                        <p class="mensagem-erro">Dados incorretos. Certifique-se de que já tem um cadastro.</p>
                        <?php endif; ?>
                                    <div class="form-group">
                                        <label for="nome">Informe seu nome completo:</label>
                                        <input type="text" name="nome" id="nome" class="campo-texto" placeholder="Clóvis da Silva"
                                            required>
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

                                    <div class="botoes-formulario">
                                        <button type="button" onclick="window.location.href='../../index.php'">Voltar para a tela
                                            principal</button>
                                        <input type="submit" name="submit" value="Continuar">
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
                    <?php
} ?>
<?php

if ($etapa == 1) {
    ?>

    <body>
        <h1>Registre-se para avaliar os projetos</h1>
        <div>
            <p>
                <?php echo htmlspecialchars($etapa); ?> de 2
            </p>
        </div>

        <form action="confirmarCadastro.php" method="POST">

            <label for="nome">Informe seu nome completo:</label>
            <input type="text" name="nome" id="nome" required>

            <label for="dataNasc">Informe sua data de nascimento</label>
            <input type="date" name="dataNasc" id="dataNasc" required>

            <p>Informe seu sexo:</p>
            <input type="radio" name="sexo" id="masculino" value="masculino" required>
            <label for="masculino">Masculino</label>

            <input type="radio" name="sexo" id="feminino" value="feminino" required>
            <label for="feminino">Feminino</label>

            <input type="radio" name="sexo" id="outro" value="outro" required>
            <label for="outro">Prefiro não informar</label>

            <button type="button" onclick="window.location.href='../../index.php'">Voltar para a tela principal</button>
            <input type="submit" name="submit" value="Continuar">

        </form>



        <script>
            const form = document.querySelector("form");


            form.addEventListener("submit", function (e) {
                const dataNascInput = document.querySelector("input[name='dataNasc']");
                const dataNasc = new Date(dataNascInput.value);
                const dataAtual = new Date();

                // Ajustar a data atual para a meia-noite para comparação correta
                dataAtual.setHours(0, 0, 0, 0);

                if (dataNasc > dataAtual) {
                    e.preventDefault(); // Impede o envio do formulário
                    alert("A data de nascimento não é válida.");
                }
            });
        </script>
        <?php
} else if ($etapa == 2) {
    ?>


            <h1>Registre-se para avaliar os projetos</h1>
            <div>
                <p><?php echo htmlspecialchars($etapa); ?> de 2</p>
            </div>

            <form action="cadastrado.php" method="POST">

                <label for="frase">Informe uma frase de segurança:</label>
                <input type="password" name="frase" id="frase" required>

                <label for="confirmacao">Repita a frase de segurança:</label>
                <input type="password" name="confirmacao" id="confirmacao" required>

                <input type="checkbox" name="termos" id="termos" required>
                <label for="termos">Aceito que o software utilize os dados coletados para fins acadêmicos</label>

                <button type="button" onclick="history.back()">Voltar para a tela principal</button>
                <input type="submit" name="submit" value="Continuar">

            </form>


            <script>
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
}
?>
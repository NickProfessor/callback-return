<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro | CallBackReturn</title>
</head>

<body>
    <h1>Registre-se para avaliar os projetos</h1>
    <div>1 de 2</div>

    <form action="confirmarCadastro.php" method="POST">

        <label for="nome">Informe seu nome completo:</label>
        <input type="text" name="nome" required>

        <label for="idade">Informe sua idade</label>
        <input type="number" name="idade" required>

        <input type="radio" name="sexo" value="masculino" required>
        <label for="masculino">Masculino</label>

        <input type="radio" name="sexo" value="feminino" required>
        <label for="feminino">Feminino</label>

        <input type="radio" name="sexo" value="outro" required>
        <label for="outro">Prefiro não informar</label>

        <button type="button">Voltar para a tela principal</button>
        <input type="submit" name="submit" value="Continuar">

    </form>
</body>

</html>
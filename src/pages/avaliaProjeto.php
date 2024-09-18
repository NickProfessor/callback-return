<?php

$pageTitle = "Avaliando | CallBackReturn";
include "../views/header.php";
?>

<form action="" method="POST">
    <label for="nota">Informe a nota</label>
    <input type="number" name="nota" id="nota" required>

    <label for="comentario">Faça algum comentário (opcional)</label>
    <textarea name="comentario" id="comentario" cols="40" rows="6"></textarea>

    <label for="id_usuario">Informe seu número de usuário:</label>
    <input type="number" name="id_usuario" id="id_usuario" required>

    <label for="frase">Informe sua frase de segurança</label>
    <input type="text" name="frase" id="frase" required>
    <input type="submit" value="Enviar nota">
</form>
<?php
include "../views/footer.php";
?>
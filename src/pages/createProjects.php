<?php
$email = "teste@teste";
$senha = "teste";
if (isset($_POST['user-email']) && isset($_POST['user-password']) && $_POST['user-email'] == $email && $_POST['user-password'] == $senha): ?>

    <a href="">aaa</a>

<?php else:
    header("Location: ../../index.php");
endif;
?>
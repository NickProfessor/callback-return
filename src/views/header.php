<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <?php if (isset($page)): ?>
        <?php if ($page === 'confirmarCadastro'): ?>
            <link rel="stylesheet" href="../assets/css/pages/confirmarCadastro.css">
        <?php elseif ($page === 'cadastroUsuario'): ?>
            <link rel="stylesheet" href="../assets/css/pages/cadastroUsuario.css">
        <?php endif; ?>
    <?php endif; ?>
</head>
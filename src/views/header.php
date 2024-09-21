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
        <?php elseif ($page === 'cadastrado' || $page == "recuperaID"): ?>
            <link rel="stylesheet" href="../assets/css/pages/cadastrado.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
                integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
                crossorigin="anonymous" referrerpolicy="no-referrer" />
        <?php elseif ($page === 'esqueceuOID'): ?>
            <link rel="stylesheet" href="../assets/css/pages/esqueceuOID.css">
        <?php endif; ?>
    <?php endif; ?>
</head>
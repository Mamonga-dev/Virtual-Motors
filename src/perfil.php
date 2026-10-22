<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$idUsuario = filter_var($_SESSION['usuario_id'] ?? null, FILTER_VALIDATE_INT);
if ($idUsuario === false || $idUsuario === null || $idUsuario < 1) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">
    <title>Meu perfil · Virtual Motors</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php
    $headerBasePath = '../';
    require __DIR__ . '/header.php';
    ?>
    <main class="container profile-placeholder">
        <h1>Meu perfil</h1>
        <p>A área para consultar e atualizar seus dados será implementada em breve.</p>
    </main>
    <script src="../script.js" defer></script>
</body>
</html>

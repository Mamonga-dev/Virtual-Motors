<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$headerBasePath = $headerBasePath ?? '../';
$headerPaginaInicial = $headerPaginaInicial ?? false;
$headerEmail = $_SESSION['usuario_email'] ?? null;
$headerNome = $headerEmail !== null ? explode('@', $headerEmail)[0] : null;
$headerCarrinho = $_SESSION['virtual_motors_carrinho'] ?? [];
$headerQuantidadeCarrinho = is_array($headerCarrinho)
    ? array_sum(array_map('intval', $headerCarrinho))
    : 0;
$headerInicio = $headerPaginaInicial ? '#inicio' : $headerBasePath . 'index.php#inicio';
$headerVeiculos = $headerPaginaInicial ? '#veiculos' : $headerBasePath . 'index.php#veiculos';
$headerSobre = $headerPaginaInicial ? '#sobre' : $headerBasePath . 'index.php#sobre';
$headerContato = $headerPaginaInicial ? '#contato' : $headerBasePath . 'index.php#contato';
$headerCarrinhoHref = $headerPaginaInicial ? './src/carrinho.php' : 'carrinho.php';
$headerLogin = $headerBasePath . 'src/login.php';
$headerCadastro = $headerBasePath . 'src/cadastro.php';
$headerLogout = $headerBasePath . 'src/logout.php';
?>
<header class="header">
    <div class="container header-content">
        <a href="<?= htmlspecialchars($headerInicio, ENT_QUOTES, 'UTF-8') ?>" class="logo">
            <img src="<?= htmlspecialchars($headerBasePath, ENT_QUOTES, 'UTF-8') ?>VM.png" alt="Virtual Motors">
        </a>

        <nav class="nav" id="mainNav">
            <a href="<?= htmlspecialchars($headerInicio, ENT_QUOTES, 'UTF-8') ?>">Início</a>
            <a href="<?= htmlspecialchars($headerVeiculos, ENT_QUOTES, 'UTF-8') ?>">Veículos</a>
            <a href="<?= htmlspecialchars($headerSobre, ENT_QUOTES, 'UTF-8') ?>">Sobre nós</a>
            <a href="<?= htmlspecialchars($headerContato, ENT_QUOTES, 'UTF-8') ?>">Contato</a>
            <a href="<?= htmlspecialchars($headerCarrinhoHref, ENT_QUOTES, 'UTF-8') ?>">Carrinho (<?= $headerQuantidadeCarrinho ?>)</a>
        </nav>

        <div class="user-menu-right">
            <?php if ($headerEmail !== null): ?>
                <span class="user-profile">
                    <svg class="user-avatar" viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="12" cy="12" r="10"></circle>
                        <circle cx="12" cy="9" r="3"></circle>
                        <path d="M6.5 19a5.5 5.5 0 0 1 11 0"></path>
                    </svg>
                    <span class="welcome-text">Olá, <?= htmlspecialchars($headerNome, ENT_QUOTES, 'UTF-8') ?></span>
                </span>
                <a class="logout-link" href="<?= htmlspecialchars($headerLogout, ENT_QUOTES, 'UTF-8') ?>">Sair</a>
            <?php else: ?>
                <a class="header-button" href="<?= htmlspecialchars($headerLogin, ENT_QUOTES, 'UTF-8') ?>">Entrar</a>
                <a class="header-button header-button-secondary" href="<?= htmlspecialchars($headerCadastro, ENT_QUOTES, 'UTF-8') ?>">Criar conta</a>
            <?php endif; ?>
            <button class="theme-toggle" id="themeToggle" type="button" aria-label="Ativar modo escuro" title="Ativar modo escuro">☾</button>
        </div>

        <button class="menu-button" id="menuButton" aria-label="Abrir menu" type="button">☰</button>
    </div>
</header>

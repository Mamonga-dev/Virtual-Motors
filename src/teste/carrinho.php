<?php
session_start();

// Inicializa carrinho se não existir
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Remover item
if (isset($_GET['remover'])) {
    $id = $_GET['remover'];
    unset($_SESSION['carrinho'][$id]);
    header("Location: carrinho.php");
    exit();
}

// Atualizar quantidade (caso envie dados via POST)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['atualizar'])) {
    if (isset($_POST['quantidade'])) {
        foreach ($_POST['quantidade'] as $id => $qtd) {
            if ($qtd > 0) {
                $_SESSION['carrinho'][$id]['quantidade'] = $qtd;
            } else {
                unset($_SESSION['carrinho'][$id]);
            }
        }
    }
    header("Location: carrinho.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras - Virtual Motors</title>
    <!-- Reaproveita o estilo global se houver, ou mantém a estilização integrada moderna -->
    <link rel="stylesheet" href="./style.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background-color: #f8f9fa;
            color: #111;
        }

        /* Header Padrão idêntico ao Index */
        .header {
            background-color: #111;
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo img {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }

        .nav {
            display: flex;
            align-items: center;
            gap: 30px;

        }

        .nav a {
            color: #fff;
            text-decoration: none;
         font-size: 14px;
    font-weight: 700;
            transition: color 0.2s;
            transition: 0.2s;
        }

        .nav a:hover {
            color: #ff0000;
        }

        .header-button {
            background: #ff0000;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
        }

        .header-button:hover {
            background: #cc0000;
        }

        /* Estrutura Principal do Carrinho */
        .cart-wrapper {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .cart-title-area {
            margin-bottom: 30px;
        }

        .cart-title-area span {
            color: #ff0000;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .cart-title-area h1 {
            font-size: 28px;
            color: #111;
            margin-top: 5px;
            font-weight: 800;
        }

        .cart-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            align-items: start;
        }

        @media (max-width: 900px) {
            .cart-layout {
                grid-template-columns: 1fr;
            }
        }

        /* Lista de Produtos (Cards) */
        .cart-items {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .cart-card {
            background: #ffffff;
            border: 1px solid #eaeaea;
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        }

        .cart-item-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .cart-item-info img {
            width: 140px;
            height: 90px;
            object-fit: cover;
            border-radius: 8px;
            background: #eee;
        }

        .cart-item-details h3 {
            font-size: 18px;
            color: #111;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .cart-item-tags {
            display: flex;
            gap: 8px;
        }

        .tag {
            background: #f1f3f5;
            color: #495057;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
        }

        .cart-item-right {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .cart-item-price {
            font-size: 18px;
            font-weight: 700;
            color: #111;
        }

        .btn-remove {
            background: #e7f5ff;
            color: #ff0000;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
            text-decoration: none;
        }

        .btn-remove:hover {
            background: #ff0000;
            color: #fff;
        }

        /* Resumo do Pedido (Card Lateral) */
        .order-summary {
            background: #ffffff;
            border: 1px solid #eaeaea;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        }

        .order-summary h3 {
            font-size: 18px;
            font-weight: 700;
            color: #111;
            margin-bottom: 20px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 14px;
            color: #666;
        }

        .summary-row.total {
            border-top: 1px solid #eaeaea;
            padding-top: 15px;
            margin-top: 15px;
            font-size: 18px;
            font-weight: 700;
            color: #111;
        }

        .summary-row.total span:last-child {
            color: #ff0000;
        }

        .btn-checkout {
            display: block;
            width: 100%;
            background: #ff0000;
            color: white;
            text-align: center;
            padding: 14px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            margin-top: 20px;
            transition: background 0.2s;
            border: none;
            cursor: pointer;
        }

        .btn-checkout:hover {
            background: #cc0000;
        }

        .empty-cart {
            text-align: center;
            padding: 60px 20px;
            background: #fff;
            border-radius: 12px;
            border: 1px solid #eaeaea;
        }

        .empty-cart p {
            color: #666;
            margin-bottom: 20px;
            font-size: 15px;
        }

        .btn-back {
            display: inline-block;
            background: #ff0000;
            color: #fff;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <!-- Header Principal Reaproveitado -->
    <header class="header">
        <div class="container header-content">
            <a href="index.php" class="logo">
                <img src="./VM.png" alt="Virtual Motors">
            </a>

            <nav class="nav" id="mainNav">
                <a href="index.php#inicio">Início</a>
                <a href="index.php#veiculos">Veículos</a>
                <a href="index.php#sobre">Sobre nós</a>
                <a href="index.php#contato">Contato</a>
                <a href="carrinho.php" style="color: #ff0000; font-weight: bold;">Carrinho</a>
                
                <?php if (isset($_SESSION['usuario_email'])): ?>
                    <?php 
                        $nome_usuario = explode('@', $_SESSION['usuario_email'])[0];
                    ?>
                    <span style="color: #fff; font-weight: bold; margin-left: 10px;">Olá, <?php echo htmlspecialchars($nome_usuario); ?></span>
                    <a href="logout.php" style="color: #ff4d4d; margin-left: 5px;">Sair</a>
                <?php else: ?>
                    <a href="login.php" class="login-link">Login</a>
                <?php endif; ?>
            </nav>

            <a href="index.php#veiculos" class="header-button">
                Ver veículos
            </a>
        </div>
    </header>

    <!-- Conteúdo do Carrinho -->
    <div class="cart-wrapper">
        <div class="cart-title-area">
            <span>Seu Carrinho</span>
            <h1>Carrinho de Compras</h1>
        </div>

        <?php if (empty($_SESSION['carrinho'])): ?>
            <div class="empty-cart">
                <p>O seu carrinho está atualmente vazio.</p>
                <a href="index.php" class="btn-back">Voltar para Página Inicial</a>
            </div>
        <?php else: ?>
            <div class="cart-layout">
                <!-- Lista de Cards dos Veículos -->
                <div class="cart-items">
                    <?php 
                    $subtotalGeral = 0;
                    foreach ($_SESSION['carrinho'] as $id => $item):
                        // Define valores padrão caso não venham preenchidos no array do item
                        $nome = $item['nome'] ?? 'Veículo';
                        $preco = $item['preco'] ?? 0;
                        $quantidade = $item['quantidade'] ?? 1;
                        $ano = $item['ano'] ?? '2023';
                        $km = $item['km'] ?? '0 km';
                        $imagem = $item['imagem'] ?? './VM.png'; // Imagem padrão se não houver
                        
                        $totalItem = $preco * $quantidade;
                        $subtotalGeral += $totalItem;
                    ?>
                        <div class="cart-card">
                            <div class="cart-item-info">
                                <img src="<?php echo htmlspecialchars($imagem); ?>" alt="<?php echo htmlspecialchars($nome); ?>">
                                <div class="cart-item-details">
                                    <h3><?php echo htmlspecialchars($nome); ?></h3>
                                    <div class="cart-item-tags">
                                        <span class="tag">Ano <?php echo htmlspecialchars($ano); ?></span>
                                        <span class="tag"><?php echo htmlspecialchars($km); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="cart-item-right">
                                <div class="cart-item-price">
                                    R$ <?php echo number_format($totalItem, 2, ',', '.'); ?>
                                </div>
                                <a href="carrinho.php?remover=<?php echo $id; ?>" class="btn-remove" title="Remover item">
                                    🗑️
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Resumo Lateral do Pedido -->
                <div class="order-summary">
                    <h3>Resumo do Pedido</h3>
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>R$ <?php echo number_format($subtotalGeral, 2, ',', '.'); ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Taxa de serviço</span>
                        <span>Grátis</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>R$ <?php echo number_format($subtotalGeral, 2, ',', '.'); ?></span>
                    </div>
                    
                    <a href="confirmar.php" class="btn-checkout">Finalizar Compra</a>
                </div>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
<?php

use VirtualMotors\Repository\CarroRepository;

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/CarroRepository.php';

session_start();

if (empty($_SESSION['usuario_email'])) {
    header('Location: login.php');
    exit;
}

$chaveCarrinho = 'virtual_motors_carrinho';
$itensCarrinho = $_SESSION[$chaveCarrinho] ?? [];
if (!is_array($itensCarrinho) || $itensCarrinho === []) {
    header('Location: carrinho.php');
    exit;
}

$veiculos = [];
$erroBanco = false;

try {
    $veiculos = (new CarroRepository())->buscarPorIds(array_keys($itensCarrinho));
} catch (PDOException $erro) {
    error_log($erro->getMessage());
    http_response_code(500);
    $erroBanco = true;
}

$totalPedido = 0;
$quantidadeCarrinho = array_sum(array_map('intval', $itensCarrinho));
$usuarioEmail = (string) $_SESSION['usuario_email'];
$nomeUsuario = explode('@', $usuarioEmail)[0];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Confira seu pedido Virtual Motors e preencha os dados de entrega.">
    <title>Pagamento - Virtual Motors</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" href="../assets/vm.png" type="image/png">
</head>
<body>
    <header class="header">
        <div class="container header-content">
            <a href="../index.php#inicio" class="logo">
                <img src="../VM.png" alt="Virtual Motors">
            </a>
            <nav class="nav" id="mainNav">
                <a href="../index.php#inicio">Início</a>
                <a href="../index.php#veiculos">Veículos</a>
                <a href="../index.php#sobre">Sobre nós</a>
                <a href="../index.php#contato">Contato</a>
                <a href="carrinho.php">Carrinho (<?= $quantidadeCarrinho ?>)</a>
            </nav>
            <div class="user-menu-right">
                <span class="welcome-text">Olá, <?= htmlspecialchars($nomeUsuario, ENT_QUOTES, 'UTF-8') ?></span>
                <a class="logout-link" href="logout.php">Sair</a>
            </div>
            <button class="menu-button" id="menuButton" aria-label="Abrir menu">☰</button>
        </div>
    </header>

    <main class="cart-wrapper checkout-wrapper">
        <div class="cart-title-area">
            <span>Finalização da compra</span>
            <h1>Entrega e pagamento</h1>
            <p>Preencha os dados para revisar seu pedido.</p>
        </div>

        <?php if ($erroBanco): ?>
            <p class="cart-message cart-error" role="alert">Não foi possível consultar os itens do pedido. Verifique a conexão com o banco e tente novamente.</p>
            <a class="button button-primary" href="carrinho.php">Voltar ao carrinho</a>
        <?php elseif ($veiculos === []): ?>
            <div class="empty-cart">
                <p>Não encontramos os veículos deste pedido no estoque.</p>
                <a href="carrinho.php" class="button button-primary">Voltar ao carrinho</a>
            </div>
        <?php else: ?>
            <div class="checkout-layout">
                <div class="checkout-form">
                    <p class="checkout-notice" role="note">
                        Esta página é uma prévia. O pagamento não está integrado; não informe dados reais de cartão.
                    </p>

                    <section class="checkout-section" aria-labelledby="deliveryTitle">
                        <div class="checkout-section-heading">
                            <span class="checkout-step">1</span>
                            <div>
                                <h2 id="deliveryTitle">Endereço de entrega</h2>
                                <p>Informe onde deseja receber o veículo.</p>
                            </div>
                        </div>

                        <div class="checkout-field checkout-cep-field">
                            <label for="cep">CEP</label>
                            <div class="cep-input-row">
                                <input id="cep" name="cep" type="text" inputmode="numeric" autocomplete="postal-code" maxlength="9" placeholder="00000-000">
                                <button class="button button-outline checkout-cep-button" id="consultCep" type="button">Consultar CEP</button>
                            </div>
                            <p class="checkout-help" id="cepStatus" role="status">A consulta de CEP será integrada em breve. Você pode preencher o endereço manualmente.</p>
                        </div>

                        <div class="checkout-fields-grid">
                            <div class="checkout-field checkout-field-wide">
                                <label for="address">Rua / avenida</label>
                                <input id="address" name="address" type="text" autocomplete="street-address" placeholder="Nome da rua ou avenida">
                            </div>
                            <div class="checkout-field">
                                <label for="addressNumber">Número</label>
                                <input id="addressNumber" name="addressNumber" type="text" autocomplete="address-line2" placeholder="Nº">
                            </div>
                            <div class="checkout-field">
                                <label for="addressComplement">Complemento <span>(opcional)</span></label>
                                <input id="addressComplement" name="addressComplement" type="text" placeholder="Apartamento, bloco...">
                            </div>
                            <div class="checkout-field">
                                <label for="neighborhood">Bairro</label>
                                <input id="neighborhood" name="neighborhood" type="text" autocomplete="address-level3" placeholder="Bairro">
                            </div>
                            <div class="checkout-field">
                                <label for="city">Cidade</label>
                                <input id="city" name="city" type="text" autocomplete="address-level2" placeholder="Cidade">
                            </div>
                            <div class="checkout-field">
                                <label for="state">Estado</label>
                                <select id="state" name="state" autocomplete="address-level1">
                                    <option value="">Selecione</option>
                                    <option value="AC">Acre</option>
                                    <option value="AL">Alagoas</option>
                                    <option value="AP">Amapá</option>
                                    <option value="AM">Amazonas</option>
                                    <option value="BA">Bahia</option>
                                    <option value="CE">Ceará</option>
                                    <option value="DF">Distrito Federal</option>
                                    <option value="ES">Espírito Santo</option>
                                    <option value="GO">Goiás</option>
                                    <option value="MA">Maranhão</option>
                                    <option value="MT">Mato Grosso</option>
                                    <option value="MS">Mato Grosso do Sul</option>
                                    <option value="MG">Minas Gerais</option>
                                    <option value="PA">Pará</option>
                                    <option value="PB">Paraíba</option>
                                    <option value="PR">Paraná</option>
                                    <option value="PE">Pernambuco</option>
                                    <option value="PI">Piauí</option>
                                    <option value="RJ">Rio de Janeiro</option>
                                    <option value="RN">Rio Grande do Norte</option>
                                    <option value="RS">Rio Grande do Sul</option>
                                    <option value="RO">Rondônia</option>
                                    <option value="RR">Roraima</option>
                                    <option value="SC">Santa Catarina</option>
                                    <option value="SP">São Paulo</option>
                                    <option value="SE">Sergipe</option>
                                    <option value="TO">Tocantins</option>
                                </select>
                            </div>
                        </div>
                    </section>

                    <section class="checkout-section" aria-labelledby="paymentTitle">
                        <div class="checkout-section-heading">
                            <span class="checkout-step">2</span>
                            <div>
                                <h2 id="paymentTitle">Forma de pagamento</h2>
                                <p>Escolha uma opção para visualizar os detalhes.</p>
                            </div>
                        </div>

                        <div class="payment-methods">
                            <label class="payment-method">
                                <input type="radio" name="paymentMethod" value="pix" checked>
                                <span><strong>Pix</strong><small>Pagamento instantâneo</small></span>
                            </label>
                            <label class="payment-method">
                                <input type="radio" name="paymentMethod" value="credit">
                                <span><strong>Cartão de crédito</strong><small>Dados não serão enviados</small></span>
                            </label>
                            <label class="payment-method">
                                <input type="radio" name="paymentMethod" value="boleto">
                                <span><strong>Boleto</strong><small>Opção demonstrativa</small></span>
                            </label>
                        </div>
                        <p class="payment-method-message" id="paymentMethodMessage" role="status">A opção Pix será disponibilizada quando a integração de pagamento estiver pronta.</p>
                    </section>

                    <p class="checkout-result" id="checkoutResult" role="status" aria-live="polite"></p>
                    <button class="button button-primary checkout-submit" id="reviewCheckout" type="button">Revisar pedido</button>
                </div>

                <aside class="order-summary checkout-summary">
                    <h2>Resumo do pedido</h2>
                    <?php foreach ($veiculos as $veiculo): ?>
                        <?php
                        $idCarro = (int) $veiculo['id_carro'];
                        $quantidade = (int) ($itensCarrinho[$idCarro] ?? 1);
                        $subtotal = (float) $veiculo['preco'] * $quantidade;
                        $totalPedido += $subtotal;
                        ?>
                        <div class="checkout-order-item">
                            <div>
                                <strong><?= htmlspecialchars($veiculo['nome'], ENT_QUOTES, 'UTF-8') ?></strong>
                                <span><?= $quantidade ?> unidade(s)</span>
                            </div>
                            <strong>R$ <?= number_format($subtotal, 2, ',', '.') ?></strong>
                        </div>
                    <?php endforeach; ?>
                    <div class="summary-row">
                        <span>Entrega</span>
                        <strong>A combinar</strong>
                    </div>
                    <div class="summary-row checkout-total">
                        <span>Total dos veículos</span>
                        <strong>R$ <?= number_format($totalPedido, 2, ',', '.') ?></strong>
                    </div>
                    <a class="cart-continue-link" href="carrinho.php">Voltar e alterar carrinho</a>
                </aside>
            </div>
        <?php endif; ?>
    </main>

    <script src="../script.js" defer></script>
</body>
</html>

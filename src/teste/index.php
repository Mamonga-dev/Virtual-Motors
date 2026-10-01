<?php
session_start();
include 'conexao.php';

function imagemPlaceholderCarro($idCarro)
{
    $imagens = [
        'https://upload.wikimedia.org/wikipedia/commons/0/0e/Lightning_McQueen_at_Disney%27s_Hollywood_Studios_%286746004967%29_%28cropped%29.jpg',
        'https://images.cults3d.com/NquXS0c6WJnjfMK6sWmyE_wIKpY=/516x516/filters:no_upscale()/https://fbi.cults3d.com/uploaders/15626700/illustration-file/aca07023-9fab-41c1-b768-de6470b5c57d/1.2.png',
        'https://i.ytimg.com/vi/V866TiCowqs/maxresdefault.jpg'
    ];

    return $imagens[(max(1, (int) $idCarro) - 1) % count($imagens)];
}

if (isset($_GET['adicionar'])) {
    $veiculoId = (int) $_GET['adicionar'];
    $stmt = $conn->prepare("SELECT id_carro AS id, nome, preco, cor, jogo_origem FROM carros WHERE id_carro = ?");
    $stmt->bind_param("i", $veiculoId);
    $stmt->execute();
    $veiculo = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($veiculo) {
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        if (!isset($_SESSION['carrinho'][$veiculoId])) {
            $_SESSION['carrinho'][$veiculoId] = [
                'nome' => $veiculo['nome'],
                'preco' => (float) $veiculo['preco'],
                'quantidade' => 1,
                'ano' => 'N/D',
                'km' => 'N/D',
                'imagem' => imagemPlaceholderCarro($veiculoId)
            ];
        } else {
            $_SESSION['carrinho'][$veiculoId]['quantidade']++;
        }

        header('Location: carrinho.php');
        exit;
    }
}

$veiculos = $conn->query("SELECT id_carro AS id, nome, preco, CONCAT_WS(' | ', IF(cor IS NOT NULL AND cor <> '', CONCAT('Cor: ', cor), NULL), CONCAT('Jogo: ', jogo_origem)) AS descricao, 'N/D' AS ano FROM carros ORDER BY id_carro LIMIT 6");
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Motors | Veículos Premium</title>
    <meta name="description" content="Encontre seu próximo veículo na Virtual Motors.">
    <link rel="stylesheet" href="./style.css">
</head>

<body>

    <header class="header">
        <div class="container header-content">

            <a href="#inicio" class="logo">
                <img src="./VM.png" alt="Virtual Motors">
            </a>

            <nav class="nav" id="mainNav">
                <a href="#inicio">Início</a>
                <a href="#veiculos">Veículos</a>
                <a href="#sobre">Sobre nós</a>
                <a href="#contato">Contato</a>
                <a href="carrinho.php">Carrinho</a>
                
                <?php if (isset($_SESSION['usuario_email'])): ?>
                    <?php $nome_usuario = explode('@', $_SESSION['usuario_email'])[0]; ?>
                    <span style="color: #fff; font-weight: bold; margin-left: 10px;">Olá, <?php echo htmlspecialchars($nome_usuario); ?></span>
                    <a href="logout.php" style="color: #ff4d4d; margin-left: 5px;">Sair</a>
                <?php else: ?>
                    <a href="login.php" class="login-link">Login</a>
                <?php endif; ?>
            </nav>

            <a href="#veiculos" class="header-button">
                Ver veículos
            </a>

            <button class="menu-button" id="menuButton" aria-label="Abrir menu">
                ☰
            </button>

        </div>
    </header>

    <main>

        <!-- HERO -->
        <section class="hero" id="inicio">

            <div class="container hero-content">

                <span class="hero-tag">
                    VIRTUAL MOTORS
                </span>

                <h1>
                    Seu próximo carro
                    <strong>está aqui.</strong>
                </h1>

                <p>
                    Veículos selecionados para quem busca qualidade,
                    confiança e uma experiência diferenciada.
                </p>

                <div class="hero-buttons">

                    <a href="#veiculos" class="button button-primary">
                        Ver veículos
                    </a>

                    <a href="#contato" class="button button-outline">
                        Fale conosco
                    </a>

                </div>

            </div>

        </section>


        <!-- BUSCA -->
        <section class="search-section">

            <div class="container">

                <div class="search-box">

                    <div class="search-title">

                        <span>🔎</span>

                        <div>
                            <h2>Encontre seu veículo</h2>
                            <p>
                                Pesquise entre nossos veículos disponíveis
                            </p>
                        </div>

                    </div>

                    <form class="search-form" id="searchForm">

                        <div class="input-group">

                            <label for="vehicleType">
                                Tipo
                            </label>

                            <select id="vehicleType">

                                <option value="">
                                    Todos
                                </option>

                                <option value="carro">
                                    Carros
                                </option>

                                <option value="suv">
                                    SUVs
                                </option>

                                <option value="pickup">
                                    Picapes
                                </option>

                                <option value="moto">
                                    Motos
                                </option>

                            </select>

                        </div>


                        <div class="input-group">

                            <label for="brand">
                                Marca
                            </label>

                            <select id="brand">

                                <option value="">
                                    Todas
                                </option>

                                <option value="toyota">
                                    Toyota
                                </option>

                                <option value="honda">
                                    Honda
                                </option>

                                <option value="volkswagen">
                                    Volkswagen
                                </option>

                                <option value="chevrolet">
                                    Chevrolet
                                </option>

                                <option value="ford">
                                    Ford
                                </option>

                            </select>

                        </div>


                        <div class="input-group">

                            <label for="price">
                                Preço máximo
                            </label>

                            <select id="price">

                                <option value="">
                                    Qualquer preço
                                </option>

                                <option value="50000">
                                    Até R$ 50 mil
                                </option>

                                <option value="100000">
                                    Até R$ 100 mil
                                </option>

                                <option value="150000">
                                    Até R$ 150 mil
                                </option>

                                <option value="200000">
                                    Até R$ 200 mil
                                </option>

                            </select>

                        </div>


                        <button
                            type="submit"
                            class="button button-primary search-button"
                        >
                            Buscar
                        </button>

                    </form>

                </div>

            </div>

        </section>


        <!-- VEÍCULOS -->
        <section class="vehicles-section" id="veiculos">

            <div class="container">

                <div class="section-header">

                    <div>

                        <span class="section-tag">
                            ESTOQUE
                        </span>

                        <h2>
                            Veículos em destaque
                        </h2>

                    </div>

                    <a href="#" class="view-all">
                        Ver todos →
                    </a>

                </div>


                <div class="vehicle-grid">
                    <?php if ($veiculos && $veiculos->num_rows > 0): ?>
                        <?php while ($veiculo = $veiculos->fetch_assoc()): ?>
                            <?php $imagem = imagemPlaceholderCarro((int) $veiculo['id']); ?>
                            <article class="vehicle-card">
                                <div class="vehicle-image">
                                    <span class="vehicle-badge">
                                        Destaque
                                    </span>
                                    <img src="<?php echo htmlspecialchars($imagem, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($veiculo['nome']); ?>">
                                </div>

                                <div class="vehicle-info">
                                    <span class="vehicle-year">
                                        <?php echo htmlspecialchars($veiculo['ano']); ?> • Disponível
                                    </span>

                                    <h3><?php echo htmlspecialchars($veiculo['nome']); ?></h3>

                                    <p class="vehicle-description">
                                        <?php echo htmlspecialchars($veiculo['descricao']); ?>
                                    </p>

                                    <div class="vehicle-footer">
                                        <div>
                                            <small>A partir de</small>
                                            <strong>R$ <?php echo number_format((float) $veiculo['preco'], 2, ',', '.'); ?></strong>
                                        </div>

                                        <a href="?adicionar=<?php echo (int) $veiculo['id']; ?>" class="vehicle-arrow" title="Adicionar ao carrinho">
                                            →
                                        </a>
                                    </div>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>Nenhum veículo disponível no momento.</p>
                    <?php endif; ?>
                </div>

            </div>

        </section>


        <!-- DIFERENCIAIS -->
        <section class="features-section" id="sobre">

            <div class="container">

                <div class="section-header centered">

                    <span class="section-tag">
                        POR QUE A VIRTUAL MOTORS?
                    </span>

                    <h2>
                        Comprar seu carro pode ser
                        uma experiência diferente.
                    </h2>

                </div>


                <div class="features-grid">

                    <div class="feature">

                        <div class="feature-icon">
                            ✓
                        </div>

                        <h3>
                            Veículos selecionados
                        </h3>

                        <p>
                            Trabalhamos com veículos escolhidos
                            para oferecer qualidade e segurança.
                        </p>

                    </div>


                    <div class="feature">

                        <div class="feature-icon">
                            ◆
                        </div>

                        <h3>
                            Atendimento personalizado
                        </h3>

                        <p>
                            Nossa equipe está pronta para ajudar
                            você a encontrar o veículo ideal.
                        </p>

                    </div>


                    <div class="feature">

                        <div class="feature-icon">
                            $
                        </div>

                        <h3>
                            Negociação transparente
                        </h3>

                        <p>
                            Condições claras e uma negociação
                            feita de forma simples e transparente.
                        </p>

                    </div>


                    <div class="feature">

                        <div class="feature-icon">
                            ★
                        </div>

                        <h3>
                            Experiência premium
                        </h3>

                        <p>
                            Uma experiência pensada para você
                            desde o primeiro contato.
                        </p>

                    </div>

                </div>

            </div>

        </section>


        <!-- CTA -->
        <section class="cta-section" id="contato">

            <div class="container">

                <div class="cta">

                    <div>

                        <span class="section-tag">
                            FALE CONOSCO
                        </span>

                        <h2>
                            Encontrou o carro ideal?
                        </h2>

                        <p>
                            Entre em contato com nossa equipe
                            e saiba mais sobre nossos veículos.
                        </p>

                    </div>

                    <a
                        href="https://wa.me/5500000000000"
                        class="button button-white"
                    >
                        Falar pelo WhatsApp
                    </a>

                </div>

            </div>

        </section>

    </main>


    <!-- FOOTER -->
    <footer class="footer">

        <div class="container footer-content">

            <div class="footer-brand">

                <img
                    src="VM.png"
                    alt="Virtual Motors"
                >

                <p>
                    Seu próximo veículo começa aqui.
                </p>

            </div>


            <div class="footer-column">

                <h4>
                    Empresa
                </h4>

                <a href="#sobre">
                    Sobre nós
                </a>

                <a href="#veiculos">
                    Veículos
                </a>

                <a href="#contato">
                    Contato
                </a>

            </div>


            <div class="footer-column">

                <h4>
                    Atendimento
                </h4>

                <a href="#contato">
                    WhatsApp
                </a>

                <a href="#">
                    Instagram
                </a>

                <a href="#">
                    Localização
                </a>

            </div>

        </div>


        <div class="footer-bottom">

            <div class="container">

                <p>
                    © 2026 Virtual Motors.
                    Todos os direitos reservados.
                </p>

            </div>

        </div>

    </footer>


    <script src="script.js"></script>

</body>

</html>
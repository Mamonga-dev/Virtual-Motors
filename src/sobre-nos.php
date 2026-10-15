<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <title>Sobre nós | Virtual Motors</title>
    <meta
        name="description"
        content="Conheça a Virtual Motors, nosso propósito e os valores que orientam cada experiência."
    >
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" href="../assets/vm.png" type="image/png" sizes="2048x2048">
    <link rel="apple-touch-icon" href="../assets/vm.png" type="image/png" sizes="2048x2048">
    <link rel="shortcut icon" href="../assets/vm.png" type="image/png" sizes="2048x2048">
</head>

<body class="about-page">
    <?php
    $headerBasePath = '../';
    $headerPaginaSobreNos = true;
    require __DIR__ . '/header.php';
    ?>

    <main>
        <section class="about-hero" id="inicio">
            <div class="container about-hero-content">
                <span class="hero-tag">VIRTUAL MOTORS</span>
                <h1>Sobre <span>nós.</span></h1>
                <p>Mais do que carros, entregamos confiança para você seguir em frente.</p>

                <aside class="about-project-note" aria-label="Informação sobre o projeto">
                    <span class="about-project-mark" aria-hidden="true">A</span>
                    <div>
                        <h2>Projeto acadêmico</h2>
                        <p>
                            A Virtual Motors é uma empresa fictícia, criada sob medida exclusivamente
                            para fins acadêmicos. Nomes, serviços, números e informações apresentados
                            neste site são parte de uma simulação.
                        </p>
                    </div>
                </aside>
            </div>
        </section>

        <section class="about-story" id="quem-somos">
            <div class="container about-story-grid">
                <div class="about-story-copy">
                    <span class="section-tag">QUEM SOMOS</span>
                    <h2>Paixão por carros. Respeito por <span>pessoas.</span></h2>
                    <p class="about-story-lead">
                        A Virtual Motors nasceu para tornar a compra de um veículo mais simples,
                        segura e transparente.
                    </p>
                    <p>
                        Neste projeto fictício, imaginamos uma empresa que reúne uma seleção
                        cuidadosa de veículos e uma equipe preparada para entender o que cada
                        cliente realmente procura. Nossa proposta é transformar dúvidas em boas
                        escolhas.
                    </p>
                    <p>
                        Da pesquisa ao pós-venda, cada etapa foi pensada para transmitir
                        confiança, qualidade e proximidade — valores essenciais para uma marca
                        automotiva moderna.
                    </p>
                </div>

                <figure class="about-story-visual">
                    <img
                        src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1200&q=85"
                        alt="Carro esportivo em uma garagem"
                        loading="lazy"
                    >
                    <figcaption class="about-since-card">
                        <span>DESDE 2025</span>
                        <p>Uma marca fictícia com grandes ideias.</p>
                    </figcaption>
                </figure>
            </div>
        </section>

        <section class="about-values" id="valores">
            <div class="container">
                <div class="about-values-heading">
                    <div>
                        <span class="section-tag">O QUE NOS MOVE</span>
                        <h2>Nossos valores<br>estão na <span>direção.</span></h2>
                    </div>
                    <p>
                        Criamos a personalidade da Virtual Motors sobre três pilares que fortalecem
                        sua proposta e a sua comunicação.
                    </p>
                </div>

                <div class="about-values-grid">
                    <article class="about-value">
                        <span class="about-value-number">01</span>
                        <div class="about-value-rule" aria-hidden="true"></div>
                        <h3>Confiança</h3>
                        <p>Negociações claras, veículos verificados e respeito em cada conversa.</p>
                    </article>

                    <article class="about-value">
                        <span class="about-value-number">02</span>
                        <div class="about-value-rule" aria-hidden="true"></div>
                        <h3>Qualidade</h3>
                        <p>Uma seleção criteriosa para oferecer segurança, desempenho e procedência.</p>
                    </article>

                    <article class="about-value">
                        <span class="about-value-number">03</span>
                        <div class="about-value-rule" aria-hidden="true"></div>
                        <h3>Experiência</h3>
                        <p>Atendimento próximo e uma jornada simples do primeiro contato à entrega.</p>
                    </article>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container footer-content">
            <div class="footer-brand">
                <img src="../VM.png" alt="Virtual Motors">
                <p>Seu próximo veículo começa aqui.</p>
            </div>

            <div class="footer-column">
                <h4>Empresa</h4>
                <a href="./sobre-nos.php">Sobre nós</a>
                <a href="../index.php#veiculos">Veículos</a>
                <a href="../index.php#contato">Contato</a>
            </div>

            <div class="footer-column">
                <h4>Atendimento</h4>
                <a href="../index.php#contato">WhatsApp</a>
                <a href="../index.php#contato">Instagram</a>
                <a href="../index.php#contato">Localização</a>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <p>© 2026 Virtual Motors. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="../script.js" defer></script>
</body>

</html>

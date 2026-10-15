-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql309.infinityfree.com
-- Tempo de geração: 15-Out-2026 às 08:05
-- Versão do servidor: 11.4.13-MariaDB
-- versão do PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `if0_43124603_loja_carros`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `carros`
--

CREATE TABLE `carros` (
  `id_carro` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cor` varchar(30) DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL,
  `jogo_origem` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Extraindo dados da tabela `carros`
--

INSERT INTO `carros` (`id_carro`, `nome`, `cor`, `preco`, `jogo_origem`) VALUES
(1, 'Ferrari 488 GTB', 'Vermelho', '2500000.00', 'Forza Horizon'),
(2, 'Lamborghini Huracán', 'Amarelo', '3000000.00', 'Forza Horizon'),
(3, 'Porsche 911', 'Preto', '1800000.00', 'Need for Speed'),
(4, 'Nissan Skyline GT-R', 'Azul', '900000.00', 'Need for Speed'),
(5, 'BMW M4', 'Branco', '1200000.00', 'Forza Horizon'),
(6, 'McLaren 720S', 'Laranja', '2800000.00', 'Forza Horizon');

-- --------------------------------------------------------

--
-- Estrutura da tabela `item_pedido`
--

CREATE TABLE `item_pedido` (
  `id_pedido` int(11) NOT NULL,
  `id_carro` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido`
--

CREATE TABLE `pedido` (
  `id_pedido` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `data_entrega` date DEFAULT NULL,
  `valor_total` decimal(10,2) NOT NULL,
  `pagamento` varchar(50) NOT NULL,
  `status_pedido` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `endereco` varchar(150) DEFAULT NULL,
  `tipo_usuario` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome`, `email`, `senha`, `telefone`, `endereco`, `tipo_usuario`) VALUES
(1, 'gg', 'gg@gmail.com', '$2y$12$nRBHXuj.9yAjoaPYjX3MHuVYS2.3XEiBgacpwtHcrq/0ZJ0kN6Xue', NULL, NULL, 'cliente'),
(2, 'tony', 'tony@gmail.com', '$2y$12$pd14ZhYlz3W0WdoSL89KmunEGbhfGjBrTOy9.PHahqoMu1iOSHfxS', NULL, NULL, 'cliente'),
(3, 'Jorge', 'Jorge@gmail.com', '$2y$12$zl6yquBvP4YSr5noZ4dPPO0vAuJDSdl8gFuc/VjraOvDUo9mzuNxm', NULL, NULL, 'cliente'),
(6, 'www', 'www@gmail.com', '$2y$12$10OfuvNnAzF7OK6bQUi4tuaRGLN8xi3717QSqSGiDD8PASnnGQsUa', NULL, NULL, 'cliente'),
(7, 'yuri', 'yuri@gmail.com', '$2y$12$xXdNISBXcv2NmtA0LkjOSesC1Xk3SrmFbyUb4CQppje3pU8UyzKo2', NULL, NULL, 'cliente');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `carros`
--
ALTER TABLE `carros`
  ADD PRIMARY KEY (`id_carro`);

--
-- Índices para tabela `item_pedido`
--
ALTER TABLE `item_pedido`
  ADD PRIMARY KEY (`id_pedido`,`id_carro`),
  ADD KEY `id_carro` (`id_carro`);

--
-- Índices para tabela `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `carros`
--
ALTER TABLE `carros`
  MODIFY `id_carro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

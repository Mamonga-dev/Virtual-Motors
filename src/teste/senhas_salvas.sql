CREATE DATABASE IF NOT EXISTS loja_carros
    CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE loja_carros;

CREATE TABLE IF NOT EXISTS usuario (
    id_usuario INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    telefone VARCHAR(20) DEFAULT NULL,
    endereco VARCHAR(150) DEFAULT NULL,
    tipo_usuario VARCHAR(20) NOT NULL,
    PRIMARY KEY (id_usuario),
    UNIQUE KEY email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
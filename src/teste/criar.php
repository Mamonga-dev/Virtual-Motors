<?php
$servername = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$sqlBanco = "CREATE DATABASE IF NOT EXISTS loja_carros CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
if (!$conn->query($sqlBanco)) {
    die("Erro ao criar banco: " . $conn->error);
}

if (!$conn->select_db("loja_carros")) {
    die("Erro ao selecionar banco: " . $conn->error);
}

$tabelas = [
    "CREATE TABLE IF NOT EXISTS usuario (
        id_usuario INT NOT NULL AUTO_INCREMENT,
        nome VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        senha VARCHAR(255) NOT NULL,
        telefone VARCHAR(20) DEFAULT NULL,
        endereco VARCHAR(150) DEFAULT NULL,
        tipo_usuario VARCHAR(20) NOT NULL,
        PRIMARY KEY (id_usuario),
        UNIQUE KEY email (email)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",
    "CREATE TABLE IF NOT EXISTS carros (
        id_carro INT NOT NULL AUTO_INCREMENT,
        nome VARCHAR(100) NOT NULL,
        cor VARCHAR(30) DEFAULT NULL,
        preco DECIMAL(10,2) NOT NULL,
        jogo_origem VARCHAR(100) NOT NULL,
        PRIMARY KEY (id_carro)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",
    "CREATE TABLE IF NOT EXISTS pedido (
        id_pedido INT NOT NULL AUTO_INCREMENT,
        id_usuario INT NOT NULL,
        data_entrega DATE DEFAULT NULL,
        valor_total DECIMAL(10,2) NOT NULL,
        pagamento VARCHAR(50) NOT NULL,
        status_pedido VARCHAR(30) NOT NULL,
        PRIMARY KEY (id_pedido),
        KEY id_usuario (id_usuario),
        CONSTRAINT pedido_ibfk_1 FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",
    "CREATE TABLE IF NOT EXISTS item_pedido (
        id_pedido INT NOT NULL,
        id_carro INT NOT NULL,
        PRIMARY KEY (id_pedido, id_carro),
        KEY id_carro (id_carro),
        CONSTRAINT item_pedido_ibfk_1 FOREIGN KEY (id_pedido) REFERENCES pedido (id_pedido),
        CONSTRAINT item_pedido_ibfk_2 FOREIGN KEY (id_carro) REFERENCES carros (id_carro)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"
];

foreach ($tabelas as $sqlTabela) {
    if (!$conn->query($sqlTabela)) {
        die("Erro ao criar tabela: " . $conn->error);
    }
}

echo "Banco 'loja_carros' e tabelas definidos com sucesso.";

$conn->close();
?>
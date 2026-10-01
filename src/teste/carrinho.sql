CREATE DATABASE IF NOT EXISTS loja_carros
    CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE loja_carros;

CREATE TABLE IF NOT EXISTS pedido (
    id_pedido INT NOT NULL AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    data_entrega DATE DEFAULT NULL,
    valor_total DECIMAL(10,2) NOT NULL,
    pagamento VARCHAR(50) NOT NULL,
    status_pedido VARCHAR(30) NOT NULL,
    PRIMARY KEY (id_pedido),
    KEY id_usuario (id_usuario),
    CONSTRAINT pedido_ibfk_1 FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS item_pedido (
    id_pedido INT NOT NULL,
    id_carro INT NOT NULL,
    PRIMARY KEY (id_pedido, id_carro),
    KEY id_carro (id_carro),
    CONSTRAINT item_pedido_ibfk_1 FOREIGN KEY (id_pedido) REFERENCES pedido (id_pedido),
    CONSTRAINT item_pedido_ibfk_2 FOREIGN KEY (id_carro) REFERENCES carros (id_carro)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
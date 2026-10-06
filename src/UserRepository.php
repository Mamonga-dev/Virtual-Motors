<?php

namespace VirtualMotors\Repository;

use PDO;
use VirtualMotors\Core\Database;

class UserRepository
{
    private PDO $connection;

    public function __construct(?PDO $connection = null)
    {
        $this->connection = $connection ?? Database::getConnection();
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->connection->prepare(
            'SELECT id_usuario AS id, nome, email, senha, tipo_usuario FROM usuario WHERE email = :email LIMIT 1'
        );
        $stmt->execute(['email' => $email]);

        $usuario = $stmt->fetch();

        return $usuario ?: null;
    }

    public function emailExists(string $email): bool
    {
        $stmt = $this->connection->prepare('SELECT 1 FROM usuario WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);

        return (bool) $stmt->fetchColumn();
    }

    public function create(string $nome, string $email, string $senhaHash, string $tipoUsuario = 'cliente'): bool
    {
        $stmt = $this->connection->prepare(
            'INSERT INTO usuario (nome, email, senha, tipo_usuario) VALUES (:nome, :email, :senha, :tipo_usuario)'
        );

        return $stmt->execute([
            'nome' => $nome,
            'email' => $email,
            'senha' => $senhaHash,
            'tipo_usuario' => $tipoUsuario,
        ]);
    }
}

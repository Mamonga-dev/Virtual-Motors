<?php

namespace VirtualMotors\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $connection = null;

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            $servidor = 'localhost';
            $usuario = 'root';
            $senha = '';
            $banco = 'loja_carros';

            try {
                self::$connection = new PDO(
                    "mysql:host={$servidor};dbname={$banco};charset=utf8mb4",
                    $usuario,
                    $senha,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );
            } catch (PDOException $e) {
                throw new PDOException('Não foi possível conectar ao banco de dados: ' . $e->getMessage(), (int) $e->getCode());
            }
        }

        return self::$connection;
    }
}

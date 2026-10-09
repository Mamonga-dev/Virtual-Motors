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
            $servidor = '127.0.0.1';
            $usuario = 'root';
            $senha = '';
            $banco = 'loja_carros';

            try {
                $socket = @stream_socket_client(
                    "tcp://{$servidor}:3306",
                    $codigoErro,
                    $mensagemErro,
                    1
                );

                if ($socket === false) {
                    throw new PDOException('O servidor MySQL não está disponível.', $codigoErro);
                }

                stream_set_timeout($socket, 1);
                $saudacaoMySql = fread($socket, 4);
                $tempoEsgotado = stream_get_meta_data($socket)['timed_out'];
                fclose($socket);

                if ($saudacaoMySql === false || strlen($saudacaoMySql) < 4 || $tempoEsgotado) {
                    throw new PDOException('O servidor MySQL não respondeu.', 2002);
                }

                self::$connection = new PDO(
                    "mysql:host={$servidor};port=3306;dbname={$banco};charset=utf8mb4;connect_timeout=1",
                    $usuario,
                    $senha,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                        PDO::ATTR_TIMEOUT => 1,
                    ]
                );
            } catch (PDOException $e) {
                error_log($e->getMessage());
                throw new PDOException(
                    'Não foi possível conectar ao banco de dados.',
                    (int) $e->getCode(),
                    $e
                );
            }
        }

        return self::$connection;
    }
}

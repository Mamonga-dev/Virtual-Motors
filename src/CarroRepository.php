<?php

namespace VirtualMotors\Repository;

use VirtualMotors\Core\Database;

class CarroRepository
{
    public function buscarPorIds(array $ids): array
    {
        $ids = array_values(array_unique(array_filter(
            array_map('intval', $ids),
            static fn (int $id): bool => $id > 0
        )));

        if ($ids === []) {
            return [];
        }

        $marcadores = implode(', ', array_fill(0, count($ids), '?'));
        $consulta = Database::getConnection()->prepare(
            "SELECT id_carro, nome, cor, preco, jogo_origem FROM carros WHERE id_carro IN ({$marcadores}) ORDER BY nome"
        );
        $consulta->execute($ids);

        return $consulta->fetchAll();
    }

    public function buscar(string $busca, ?float $precoMaximo = null): array
    {
        $condicoes = [];
        $parametros = [];

        if ($busca !== '') {
            $condicoes[] = '(nome LIKE :nome OR cor LIKE :cor OR jogo_origem LIKE :jogo_origem)';
            $termo = '%' . $busca . '%';
            $parametros['nome'] = $termo;
            $parametros['cor'] = $termo;
            $parametros['jogo_origem'] = $termo;
        }

        if ($precoMaximo !== null) {
            $condicoes[] = 'preco <= :preco_maximo';
            $parametros['preco_maximo'] = $precoMaximo;
        }

        $sql = 'SELECT id_carro, nome, cor, preco, jogo_origem FROM carros';
        if ($condicoes !== []) {
            $sql .= ' WHERE ' . implode(' AND ', $condicoes);
        }
        $sql .= ' ORDER BY nome';

        $consulta = Database::getConnection()->prepare($sql);
        $consulta->execute($parametros);

        return $consulta->fetchAll();
    }
}

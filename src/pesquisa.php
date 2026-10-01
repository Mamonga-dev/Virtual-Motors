<?php

header('Content-Type: application/json; charset=utf-8');

try {
    require_once __DIR__ . '/conexao.php';

    $busca = trim((string) ($_GET['busca'] ?? ''));
    $precoMaximo = $_GET['preco_max'] ?? '';
    $condicoes = [];
    $parametros = [];

    if ($busca !== '') {
        $condicoes[] = '(nome LIKE :nome OR cor LIKE :cor OR jogo_origem LIKE :jogo_origem)';
        $termo = '%' . $busca . '%';
        $parametros['nome'] = $termo;
        $parametros['cor'] = $termo;
        $parametros['jogo_origem'] = $termo;
    }

    if ($precoMaximo !== '') {
        $precoMaximo = filter_var($precoMaximo, FILTER_VALIDATE_FLOAT);
        if ($precoMaximo === false || $precoMaximo < 0) {
            http_response_code(400);
            echo json_encode(['erro' => 'O preço máximo informado é inválido.']);
            exit;
        }

        $condicoes[] = 'preco <= :preco_maximo';
        $parametros['preco_maximo'] = $precoMaximo;
    }

    $sql = 'SELECT id_carro, nome, cor, preco, jogo_origem FROM carros';
    if ($condicoes !== []) {
        $sql .= ' WHERE ' . implode(' AND ', $condicoes);
    }
    $sql .= ' ORDER BY nome';

    $consulta = $conexao->prepare($sql);
    $consulta->execute($parametros);

    echo json_encode($consulta->fetchAll(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} catch (PDOException $erro) {
    http_response_code(500);
    echo json_encode(['erro' => 'Não foi possível consultar os veículos. Verifique a conexão e o banco de dados.']);
}
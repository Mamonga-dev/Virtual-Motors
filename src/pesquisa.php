<?php

use VirtualMotors\Repository\CarroRepository;

header('Content-Type: application/json; charset=utf-8');

try {
    require_once __DIR__ . '/Database.php';
    require_once __DIR__ . '/CarroRepository.php';

    $busca = trim((string) ($_GET['busca'] ?? ''));
    $precoMaximo = $_GET['preco_max'] ?? '';

    if ($precoMaximo !== '') {
        $precoMaximo = filter_var($precoMaximo, FILTER_VALIDATE_FLOAT);
        if ($precoMaximo === false || $precoMaximo < 0) {
            http_response_code(400);
            echo json_encode(['erro' => 'O preço máximo informado é inválido.']);
            exit;
        }
    }

    $repository = new CarroRepository();
    $veiculos = $repository->buscar(
        $busca,
        $precoMaximo === '' ? null : (float) $precoMaximo
    );

    echo json_encode($veiculos, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} catch (PDOException $erro) {
    http_response_code(500);
    echo json_encode(['erro' => 'Não foi possível consultar os veículos. Verifique a conexão e o banco de dados.']);
}
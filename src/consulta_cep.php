<?php

header('Content-Type: application/json; charset=utf-8');

$cep = $_GET['cep'] ?? '';
if (!is_string($cep)) {
    http_response_code(400);
    echo json_encode(['erro' => 'Informe um CEP válido.'], JSON_UNESCAPED_UNICODE);
    exit;
}

$cep = preg_replace('/\D/', '', $cep);
if (strlen($cep) !== 8) {
    http_response_code(400);
    echo json_encode(['erro' => 'Digite um CEP com 8 números.'], JSON_UNESCAPED_UNICODE);
    exit;
}

if (!function_exists('curl_init')) {
    http_response_code(503);
    echo json_encode(['erro' => 'O serviço de consulta de CEP está indisponível.'], JSON_UNESCAPED_UNICODE);
    exit;
}

$conexao = curl_init("https://viacep.com.br/ws/{$cep}/json/");
if ($conexao === false) {
    http_response_code(502);
    echo json_encode(['erro' => 'Não foi possível consultar o serviço de CEP.'], JSON_UNESCAPED_UNICODE);
    exit;
}

curl_setopt_array($conexao, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CONNECTTIMEOUT => 3,
    CURLOPT_TIMEOUT => 8,
]);

$resposta = curl_exec($conexao);
$codigoHttp = (int) curl_getinfo($conexao, CURLINFO_HTTP_CODE);
curl_close($conexao);

if ($resposta === false || $codigoHttp !== 200) {
    http_response_code(502);
    echo json_encode(['erro' => 'Não foi possível consultar o serviço de CEP. Tente novamente.'], JSON_UNESCAPED_UNICODE);
    exit;
}

$endereco = json_decode($resposta, true);
if (!is_array($endereco)) {
    http_response_code(502);
    echo json_encode(['erro' => 'O serviço de CEP retornou uma resposta inválida.'], JSON_UNESCAPED_UNICODE);
    exit;
}

if (isset($endereco['erro'])) {
    http_response_code(404);
    echo json_encode(['erro' => 'CEP não encontrado.'], JSON_UNESCAPED_UNICODE);
    exit;
}

echo json_encode($endereco, JSON_UNESCAPED_UNICODE);

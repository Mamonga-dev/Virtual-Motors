<?php
$valorCarro = filter_input(INPUT_POST, 'valor_carro', FILTER_VALIDATE_FLOAT);
$quantidadeParcelas = filter_input(INPUT_POST, 'quantidade_parcelas', FILTER_VALIDATE_INT);

$valorParcela = null;
$erro = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if ($valorCarro === false || $valorCarro === null || $valorCarro <= 0) {
		$erro = 'Informe um valor de carro válido.';
	} elseif ($quantidadeParcelas === false || $quantidadeParcelas === null || $quantidadeParcelas <= 0) {
		$erro = 'Informe uma quantidade de parcelas válida.';
	} else {
		$valorParcela = $valorCarro / $quantidadeParcelas;
	}
}

if ($erro !== null) {
	echo htmlspecialchars($erro, ENT_QUOTES, 'UTF-8');
} elseif ($valorParcela !== null) {
	echo 'Valor de cada parcela: R$ ' . number_format($valorParcela, 2, ',', '.');
}

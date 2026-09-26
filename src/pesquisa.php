<? php 

require_once 'conexao.php';

$busca = $_GET['busca'] ?? ''; 

$resultados = [];

if (!EMPTY($busca)){
    $sql = "SELECT * FROM id_carros, nome, cor, descricao WHERE nome LIKE :busca OR descricao LIKE :busca";
    $stmt =pdo-> prepare($sql);
    $stmt-> eecute([':busca' => "%$busca%"]);

    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

}


?>

DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pesquisa de Carros</title>

    </head>
    <body>
        <h1>Pesquisa de Carros</h1>
        <form method="GET" action="pesquisa.php">
            <input type="text" name="busca" placeholder="Digite o nome ou descrição do carro" value="<?php echo htmlspecialchars($busca); ?>">
            <button type="submit">Pesquisar</button>
        </form>
        <?php if (!empty($busca)): ?>
            <h2>Resultados para: <?= htmlspecialchars($busca) ?></h2>
            <?php if (count($resultados) > 0): ?>
                <?php foreach ($resultados as $carro): ?>
                    <div>
                        <h3><?= htmlspecialchars($carro['nome']) ?></h3>
                        <p>Cor: <?= htmlspecialchars($carro['cor']) ?></p>
                        <p>Jogo de origem: <?= htmlspecialchars($carro['jogo_origem']) ?></p>
                        <p>Preço: R$ <?= number_format($carro['preco'], 2, ',', '.') ?></p>
                    </div>
                    <hr>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nenhum carro encontrado.</p>
            <?php endif; ?>
        <?php endif; ?>
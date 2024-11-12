<?php
include_once('includes/componentes/cabecalho.php');
include_once('includes/componentes/header.php');
include_once('includes/logica/conecta.php');

// sql pra somar a pontuação
$query = "
        SELECT codpessoa, nome,
               COALESCE(SUM(pontuacao), 0) AS total_pontuacao
        FROM pessoa p
        LEFT JOIN partida pa ON p.codpessoa = pa.codvencedor
        GROUP BY p.codpessoa, p.nome
        ORDER BY total_pontuacao DESC, p.nome ASC;
    ";

$stmt = $pdo->prepare($query);
$stmt->execute();
$ranking = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
</head>
<body id="body_ranking">
    <h1 id="titulo_ranking">Ranking de Jogadores</h1>
    <ul id="lista_ranking">
        <?php foreach ($ranking as $index => $jogador): ?>
            <li class="item_ranking">
                <?php echo ($index + 1) . 'º lugar: ' . htmlspecialchars($jogador['nome']) . ' - Pontuação: ' . htmlspecialchars($jogador['total_pontuacao']); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>


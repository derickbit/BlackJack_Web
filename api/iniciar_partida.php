<?php
session_start();
include_once('../includes/logica/conecta.php');
include_once('../includes/logica/Partida.php');
include_once('../includes/logica/PartidaController.php');

ini_set('display_errors', 1);
error_reporting(E_ALL);


if (!isset($_SESSION['codpessoa'])) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Usuário não autenticado']);
    exit();
}


header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = $pdo; 
    $partida = new Partida($pdo);
    $codJogador1 = $_SESSION['codpessoa'];
    $jogador2 = $partida->obterJogadorAleatorio($codJogador1);

    if ($jogador2 === null) {
        echo json_encode(['error' => 'Nenhum jogador disponível']); 
        exit();
    }

    $codVencedor = rand(0, 1) == 0 ? $codJogador1 : $jogador2;
    $pontuacao = rand(1, 5);

    $partida->registrarPartida($codJogador1, $jogador2, $codVencedor, $pontuacao);

    echo json_encode([
        'jogador2' => $jogador2, 
        'nome_jogador2' => $partida->obterNomeJogador($jogador2), 
        'vencedor' => $codVencedor, 
        'nome_vencedor' => $partida->obterNomeJogador($codVencedor), 
        'pontuacao' => $pontuacao
    ]);
    exit();
}


if (isset($_GET['historico']) && $_GET['historico'] === 'true') {
    $partida = new Partida($pdo);
    $partidaController = new PartidaController($partida);
    $historicoPartidas = $partidaController->listarHistorico($_SESSION['codpessoa']);

    echo json_encode($historicoPartidas);
    exit();
}
?>

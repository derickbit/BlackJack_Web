<?php
class PartidaController {
    private $model;

    public function __construct($partida) {
        $this->model = $partida;
    }

    public function registrarPartida($codJogador1, $codJogador2, $codVencedor, $pontuacao) {
        $this->model->setJogador1($codJogador1);
        $this->model->setJogador2($codJogador2);
        $this->model->setVencedor($codVencedor);
        $this->model->setPontuacao($pontuacao);
        $this->model->salvar();
    }

    public function listarHistorico($codJogador) {
        return $this->model->listarPorJogador($codJogador);
    }

    public function criarPartida($codJogador1) {
        $codJogador2 = $this->model->obterJogadorAleatorio($codJogador1);

        if ($codJogador2 === null) {
            return json_encode(['error' => 'Nenhum jogador disponível']);
        }

        $codVencedor = rand(0, 1) == 0 ? $codJogador1 : $codJogador2;
        $pontuacao = rand(1, 5);

        $this->model->registrarPartida($codJogador1, $codJogador2, $codVencedor, $pontuacao);

        return json_encode([
            'jogador2' => $codJogador2,
            'vencedor' => $codVencedor,
            'pontuacao' => $pontuacao
        ]);
    }
}
?>

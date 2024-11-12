<?php
class Partida {
    private $pdo;
    private $codJogador1;
    private $codJogador2;
    private $codVencedor;
    private $pontuacao;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function setJogador1($codJogador1) {
        $this->codJogador1 = $codJogador1;
    }

    public function setJogador2($codJogador2) {
        $this->codJogador2 = $codJogador2;
    }

    public function setVencedor($codVencedor) {
        $this->codVencedor = $codVencedor;
    }

    public function setPontuacao($pontuacao) {
        $this->pontuacao = $pontuacao;
    }

    public function salvar() {
        try {
            $query = $this->pdo->prepare("INSERT INTO partida (codjogador1, codjogador2, codvencedor, pontuacao) VALUES (?, ?, ?, ?)");
            $query->execute([$this->codJogador1, $this->codJogador2, $this->codVencedor, $this->pontuacao]);
        } catch (PDOException $e) {
            throw new Exception('Erro ao salvar a partida: ' . $e->getMessage());
        }
    }

    public function listarPorJogador($codJogador) {
        try {
            $query = $this->pdo->prepare("
                SELECT p.*, pj1.nome AS nome_jogador1, pj2.nome AS nome_jogador2, pv.nome AS nome_vencedor
                FROM partida p
                JOIN pessoa pj1 ON p.codjogador1 = pj1.codpessoa
                JOIN pessoa pj2 ON p.codjogador2 = pj2.codpessoa
                JOIN pessoa pv ON p.codvencedor = pv.codpessoa
                WHERE p.codjogador1 = ? OR p.codjogador2 = ?
                ORDER BY p.reg_date DESC
            ");
            $query->execute([$codJogador, $codJogador]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Erro ao listar as partidas: ' . $e->getMessage());
        }
    }

    public function obterJogadorAleatorio($codJogador1) {
        $query = $this->pdo->prepare("SELECT codpessoa FROM pessoa WHERE codpessoa <> ?");
        $query->execute([$codJogador1]);
        $pessoas = $query->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($pessoas)) {
            $indiceAleatorio = array_rand($pessoas);
            return $pessoas[$indiceAleatorio]['codpessoa'];
        }
        return null;
    }

    public function registrarPartida($codJogador1, $codJogador2, $codVencedor, $pontuacao) {
        $query = $this->pdo->prepare("INSERT INTO partida (codjogador1, codjogador2, codvencedor, pontuacao) VALUES (?, ?, ?, ?)");
        $query->execute([$codJogador1, $codJogador2, $codVencedor, $pontuacao]);
    }

    public function listarHistoricoPartidas($codJogador) {
        try {
            $query = $this->pdo->prepare("
                SELECT p.*, pj1.nome AS nome_jogador1, pj2.nome AS nome_jogador2, pv.nome AS nome_vencedor
                FROM partida p
                JOIN pessoa pj1 ON p.codjogador1 = pj1.codpessoa
                JOIN pessoa pj2 ON p.codjogador2 = pj2.codpessoa
                JOIN pessoa pv ON p.codvencedor = pv.codpessoa
                WHERE p.codjogador1 = ? OR p.codjogador2 = ?
                ORDER BY p.reg_date DESC
            ");
            $query->execute([$codJogador, $codJogador]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw new Exception('Erro ao listar o histórico de partidas: ' . $e->getMessage());
        }
    }

    public function obterNomeJogador($codJogador) {
        try {
            $query = $this->pdo->prepare("SELECT nome FROM pessoa WHERE codpessoa = ?");
            $query->execute([$codJogador]);
            $resultado = $query->fetch(PDO::FETCH_ASSOC);
            return $resultado ? $resultado['nome'] : null;
        } catch (PDOException $e) {
            throw new Exception('Erro ao obter o nome do jogador: ' . $e->getMessage());
        }
    }
}
?>

<?php
class Denuncia {
    private $pdo;
    private $coddenunciante;
    private $coddenunciado;
    private $descricao;
    private $imagem;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function setcoddenunciante($coddenunciante) {
        $this->coddenunciante = $coddenunciante;
    }

    public function setcoddenunciado($coddenunciado) {
        $this->coddenunciado = $coddenunciado;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setImagem($imagem) {
        $this->imagem = $imagem;
    }

    public function salvar() {
        try {
            $query = $this->pdo->prepare(
                "INSERT INTO denuncia (coddenunciante, coddenunciado, descricao, imagem, reg_date) 
                 VALUES (?, ?, ?, ?, CURDATE())"
            );
            $query->execute([$this->coddenunciante, $this->coddenunciado, $this->descricao, $this->imagem]);

            return $query->rowCount() > 0;
        } catch(PDOException $e) {
            throw new Exception('Erro ao salvar denúncia: ' . $e->getMessage());
        }
    }

    public function listarDenunciasDoUsuario($coddenunciante) {
        try {
            $query = $this->pdo->prepare(
                "SELECT d.coddenuncia, p1.nome AS nome_denunciante, p2.nome AS nome_denunciado, d.descricao, d.imagem, d.reg_date
                 FROM denuncia d
                 JOIN pessoa p1 ON d.coddenunciante = p1.codpessoa
                 JOIN pessoa p2 ON d.coddenunciado = p2.codpessoa
                 WHERE d.coddenunciante = ?"
            );
            $query->execute([$coddenunciante]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Erro ao listar denúncias: ' . $e->getMessage());
        }
    }

    public function removerDenuncia($coddenuncia) {
        try {
            $query = $this->pdo->prepare("DELETE FROM denuncia WHERE coddenuncia = ?");
            $resultado = $query->execute([$coddenuncia]);

            if ($resultado) {
                return "Denúncia excluída com sucesso.";
            } else {
                return "Erro ao excluir a denúncia.";
            }
        } catch (PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function processarImagem($arquivo) {
        if ($arquivo['error'] == UPLOAD_ERR_OK) {
            $nomeTemp = $arquivo['tmp_name'];
            $nomeArquivo = basename($arquivo['name']);
            $destino = __DIR__ . "/../../imagens/" . $nomeArquivo; 

            if (move_uploaded_file($nomeTemp, $destino)) {
                return $nomeArquivo;
            } else {
                throw new Exception('Erro ao mover a imagem para o diretório de destino.');
            }
        } else {
            return null;
        }
    }
}

?>

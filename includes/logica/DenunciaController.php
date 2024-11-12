<?php
class DenunciaController {
    private $denuncia;

    public function __construct(Denuncia $denuncia) {
        $this->denuncia = $denuncia;
    }

    public function criarDenuncia($coddenunciante, $coddenunciado, $descricao, $imagem) {
        $this->denuncia->setcoddenunciante($coddenunciante);
        $this->denuncia->setcoddenunciado($coddenunciado);
        $this->denuncia->setDescricao($descricao);

        try {
            if ($imagem && $imagem['error'] != UPLOAD_ERR_NO_FILE) {
                $nomeImagem = $this->denuncia->processarImagem($imagem);
                $this->denuncia->setImagem($nomeImagem);
            } else {
                $this->denuncia->setImagem(null);
            }
        } catch (Exception $e) {
            return 'Erro ao processar a imagem: ' . $e->getMessage();
        }

        if ($this->denuncia->salvar()) {
            return "Denúncia registrada com sucesso.";
        } else {
            return "Erro ao registrar a denúncia.";
        }
    }

    public function excluirDenuncia($coddenuncia) {
        return $this->denuncia->removerDenuncia($coddenuncia);
    }

    public function listarDenuncias($coddenunciante) {
        return $this->denuncia->listarDenunciasDoUsuario($coddenunciante);
    }
}

?>

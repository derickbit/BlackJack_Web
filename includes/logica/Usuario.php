<?php

class Usuario {
    private $pdo;
    private $codpessoa;
    private $nome;
    private $email;
    private $senha;
    private $nomeAntigo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getPdo() {
        return $this->pdo;
    }

    public function setCodpessoa($codpessoa) {
        $this->codpessoa = $codpessoa;
    }

    public function getCodpessoa() {
        return $this->codpessoa;
    }

    public function setNome($nome) {
        $this->nomeAntigo = $this->nome; // Armazenando o nome antigo
        $this->nome = $nome;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getNomeAntigo() {
        return $this->nomeAntigo;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getEmail() {
        return $this->email;
    }
    
    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function salvar() {
        if ($this->codpessoa) {
            $sql = "UPDATE pessoa SET nome = :nome, email = :email, senha = :senha WHERE codpessoa = :codpessoa";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['nome' => $this->nome, 'email' => $this->email, 'senha' => $this->senha, 'codpessoa' => $this->codpessoa]);
        } else {
            $sql = "INSERT INTO pessoa (nome, email, senha) VALUES (:nome, :email, :senha)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['nome' => $this->nome, 'email' => $this->email, 'senha' => $this->senha]);
        }
    }
    public function buscarPorEmail($email) {
        $stmt = $this->pdo->prepare("SELECT codpessoa, nome, email FROM pessoa WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function acessarUsuario() {
        $stmt = $this->pdo->prepare("SELECT * FROM pessoa WHERE email = ? AND senha = ?");
        $stmt->execute([$this->email, $this->senha]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

public function excluirConta() {
    if ($this->codpessoa) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM pessoa WHERE codpessoa = :codpessoa");
            $stmt->execute(['codpessoa' => $this->codpessoa]);

            // Destruindo a sessão para deslogar
            session_start(); // Garante que a sessão foi iniciada
            session_unset(); // Remove todas as variáveis de sessão
            session_destroy(); // Destrói a sessão

            return true;
        } catch (PDOException $e) {
            throw new Exception('Erro ao excluir conta: ' . $e->getMessage());
        }
    } else {
        throw new Exception('Código da pessoa não especificado.');
    }
}

public function buscarPessoa($codPessoa) {
    try {
        $query = $this->pdo->prepare("SELECT * FROM pessoa WHERE codpessoa = ?");
        if ($query->execute([$codPessoa])) {
            return $query->fetch(PDO::FETCH_ASSOC); 
        } else {
            return false; 
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        return false;
    }
}

}


?>
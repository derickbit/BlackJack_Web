<?php

class UsuarioController {
    private $model;
    private $pdo;
    
    public function __construct($model, $pdo) {
        $this->model = $model;
        $this->pdo = $pdo;
    }
    
    public function criarOuAtualizarUsuario($codpessoa, $nome, $email, $senha) {
        if ($codpessoa) {
            $this->model->setCodPessoa($codpessoa);
        }
        $nomeAntigo = $this->model->getNome(); // Obtenha o nome antigo antes de atualizá-lo (acabei não utilizando)
        $this->model->setNome($nome);
        $this->model->setEmail($email);
        $this->model->setSenha($senha);
        $this->model->salvar();

        // Atualizar o nome na sessão
        session_start();
        $_SESSION['nome'] = $nome;
        $_SESSION['codpessoa'] = $codpessoa;
    }

public function login() {
    $pessoa = $this->model->acessarUsuario();
    if ($pessoa) {
        session_start();
        $_SESSION['logado'] = true;
        $_SESSION['codpessoa'] = $pessoa['codpessoa'];
        $_SESSION['nome'] = $pessoa['nome'];
        header('Location: ../../index.php');
    } else {
        header('Location: ../../login.php');
    }
}

public function excluirConta($codpessoa) {
    $this->model->setCodPessoa($codpessoa);

    if ($this->model->excluirConta()) {
        header("Location: /projeto/index.php");
        exit;
    } else {
        die("Erro ao excluir a conta.");
    }
}
}
?>
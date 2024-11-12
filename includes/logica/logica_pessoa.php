<?php
    require_once('conecta.php');
    require_once 'Usuario.php'; 
    require_once 'Denuncia.php'; 
    require_once 'UsuarioController.php';
    require_once 'DenunciaController.php';


#CADASTRO PESSOA
if(isset($_POST['cadastrar'])){
    $usuario = new Usuario($pdo);

    $controller = new UsuarioController($usuario,$pdo);

    $codpessoa = isset($_POST['codpessoa']) ? $_POST['codpessoa'] : null;
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = MD5($_POST['senha']);

    $controller->criarOuAtualizarUsuario($codpessoa, $nome, $email, $senha);

    $pessoa = $usuario->buscarPorEmail($email);

    if ($pessoa) {
        session_start();
        $_SESSION['logado'] = true;
        $_SESSION['codpessoa'] = $pessoa['codpessoa'];
        $_SESSION['nome'] = $pessoa['nome'];

        header("Location: /projeto/index.php");
        exit;
    } else {
        die("Erro ao tentar logar o usuário.");
    }
}  
 
#ENTRAR
if (isset($_POST['entrar'])) {
    $email = $_POST['email'];
    $senha = MD5($_POST['senha']);
    $usuario = new Usuario($pdo);
    $usuario->setEmail($email);
    $usuario->setSenha($senha);
    $usuarioController = new UsuarioController($usuario,$pdo);
    $usuarioController->login();
}

#SAIR
    if(isset($_POST['sair'])){
            session_start();
            session_destroy();
            header('location:../../login.php');
    }

  
#ALTERAR PESSOA
if (isset($_POST['alterar'])) {
    $usuario = new Usuario($pdo);
    $controller = new UsuarioController($usuario, $pdo);

    $codpessoa = $_POST['codpessoa'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = MD5($_POST['senha']);

    $controller->criarOuAtualizarUsuario($codpessoa, $nome, $email, $senha);

        header("Location: /projeto/alterarPerfil.php?status=sucesso"); 
        exit;
}

#excluir denuncia
if (isset($_POST['excluir_denuncia'])) {
    $coddenuncia = $_POST['coddenuncia'];

    $denuncia = new Denuncia($pdo);
    $controller = new DenunciaController($denuncia);

    $mensagem = $controller->excluirDenuncia($coddenuncia);

    echo $mensagem;
    header("Location: /projeto/denuncias.php");
    exit;
}

    #EXCLUIR CONTA
    if (isset($_POST['excluirConta'])) {
        $codpessoa = isset($_POST['codpessoa']) ? $_POST['codpessoa'] : null;
    
        if ($codpessoa) {
            $usuario = new Usuario($pdo);
            $usuarioController = new UsuarioController($usuario, $pdo);
            $usuarioController->excluirConta($codpessoa);
        } else {
            die("Código da pessoa não especificado.");
        }
    }
    
?>
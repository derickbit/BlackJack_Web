<!DOCTYPE html>
<html>
<head>
<?php
include_once('includes/componentes/cabecalho.php');
include_once('includes/componentes/header.php');
include_once('includes/logica/Usuario.php');
include_once('includes/logica/conecta.php');

$codpessoa = $_SESSION['codpessoa'];
$usuario = new Usuario($pdo);
$pessoa = $usuario->buscarPessoa($codpessoa);

if (!$pessoa) {
    echo 'Pessoa não encontrada ou erro ao buscar.';
}

if (isset($_GET['status']) && $_GET['status'] === 'sucesso') {
    echo "<script>alert('Alteração realizada com sucesso!');</script>";
}
?>
</head>
<body id="body_editar_perfil">
    <h1 id="titulo_editar_perfil">Editar Perfil</h1>
    <main id="main_editar_perfil">
        <section id="section_editar_perfil">
            <form id="form_editar_perfil" action="includes/logica/logica_pessoa.php" method="post">
                <p><label for="nome">Nome: </label><input type="text" name="nome" value="<?php echo $pessoa['nome']; ?>"></p>
                <p><label for="email">Email: </label><input type="text" name="email" value="<?php echo $pessoa['email']; ?>"></p>
                <p><label for="senha">Senha: </label><input type="password" name="senha" value="<?php echo $pessoa['senha']; ?>"></p>
                <input type="hidden" name="codpessoa" value="<?php echo $pessoa['codpessoa']; ?>">
                <p><input type="submit" name="alterar" value="Alterar"></p>        
            </form>

            <form id="form_excluir_conta" action="includes/logica/logica_pessoa.php" method="post" onsubmit="return confirm('Confirma a exclusão da conta?');">
                <input type="hidden" name="codpessoa" value="<?php echo $_SESSION['codpessoa']; ?>">
                <button type="submit" name="excluirConta">Excluir Conta</button>
            </form>
        </section>
    </main>
<?php require('includes/componentes/footer.php');?>
</body>
</html>
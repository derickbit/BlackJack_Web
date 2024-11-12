<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="assets/js/validacao.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Cadastro BlackJack 2.0</title>
</head>
<body id="body_cadastro">
    <main id="main_cadastro">
        <img src="includes/blackjack_logo.jpg" alt="Logo Blackjack">
        <h1 id="titulo_cadastro">Cadastro</h1>
        <section id="section_cadastro_form">
            <form id="form_cadastro" action="includes/logica/logica_pessoa.php" method="post" enctype="multipart/form-data">
                <p id="paragrafo_nome">
                    <label for="nome">Nome: </label>
                    <input type="text" name="nome" id="nome">
                </p>
                <p id="paragrafo_email_cadastro">
                    <label for="email">Email: </label>
                    <input type="text" name="email" id="email">
                </p>
                <p id="paragrafo_senha_cadastro">
                    <label for="senha">Senha: </label>
                    <input type="password" name="senha" id="senha">
                </p>
                <p id="paragrafo_botao_cadastrar">
                    <button type="submit" id="btn_cadastrar" name="cadastrar" value="Cadastrar">Cadastrar</button>
                </p>    
            </form>
        </section>
        <h3 id="cadastro_prompt">Já possui cadastro?
                <a href="/projeto/login.php" id="link_cadastro">Login</a>
                </h3>
    </main>
    <?php require('includes/componentes/footer.php');?>
</body>
</html>
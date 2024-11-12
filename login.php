<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="assets/js/validacao.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Login</title>
</head>
<body id="body_login">
    <main id="main_login">
        <img src="includes/blackjack_logo.jpg" alt="Logo Blackjack">
        <h1 id="titulo_login">Login</h1>
        <section id="section_login_form">
            <form id="form_login" action="includes/logica/logica_pessoa.php" method="post">
                <p id="paragrafo_email">
                    <label for="email">Email: </label>
                    <input type="text" name="email" id="email">
                </p>
                <p id="paragrafo_senha">
                    <label for="senha">Senha: </label>
                    <input type="password" name="senha" id="senha">
                </p>
                <p id="paragrafo_botao_entrar">
                    <button type="submit" id="btn_entrar" name="entrar" value="Entrar">Entrar</button>
                </p>      
            </form>
        </section>
        <h3 id="cadastro_prompt">Não possui login? Faça um cadastro:
        <a href="/projeto/cadastrarPessoa.php" id="link_cadastro">Cadastro</a>
        </h3>
    </main>


</body>
</html>
<?php
include_once('includes/componentes/cabecalho.php');
include_once('includes/componentes/header.php');
include_once('includes/logica/conecta.php');
?>
</head>
<body id="body_home">  
    <main id="main_home">
        <h1 id="bem_vindo"> Bem vindo(a), <?php echo $_SESSION['nome']; ?> </h1>
        <h2 id="jogo_titulo">
            Apresentamos
            <a href="partida.php" id="link_jogo"><div id="jogo_imagem"><img src="includes/blackjack2.2.jpg" alt="Imagem do jogo Blackjack 2.0"/></div></a>
            Clique na imagem para jogar
        </h2>
    </main>
</body>
</html>
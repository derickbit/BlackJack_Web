<?php
include_once('includes/componentes/cabecalho.php');
include_once('includes/logica/conecta.php');
include_once('includes/logica/Denuncia.php');
include_once('includes/logica/DenunciaController.php');



// Criação dos objetos necessários
$denuncia = new Denuncia($pdo);
$controller = new DenunciaController($denuncia);

$denuncianteNome = $_SESSION['nome'];

// Obtendo o ID do denunciante
$query = $pdo->prepare("SELECT codpessoa FROM pessoa WHERE nome = ?");
$query->execute([$denuncianteNome]);
$coddenunciante = $query->fetchColumn();

if (!$coddenunciante) {
    die('Erro: Usuário não encontrado.');
}

// Se o formulário foi enviado
if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['registrar_denuncia'])) {
    $coddenunciado = $_POST['coddenunciado'];
    $descricao = $_POST['descricao'];
    $imagem = $_FILES['imagem']; // Captura o arquivo enviado

    // Cria a denúncia
    $mensagem = $controller->criarDenuncia($coddenunciante, $coddenunciado, $descricao, $imagem);

    header('Location: /projeto/denuncias.php');
}


// Listar as denúncias do usuário logado
$denuncias = $controller->listarDenuncias($coddenunciante);
?>
</head>
<body id="body_denunciar_jogador">
<?php require('includes/componentes/header.php'); ?>

<h1 id="titulo_denunciar_jogador">Denunciar Jogador</h1>

<main id="main_denunciar_jogador">
    <section id="section_denunciar_jogador">
        <form id="form_denunciar_jogador" action="" method="post" enctype="multipart/form-data">
            <p>
                <label for="coddenunciado">Jogador a ser denunciado: </label>
                <select name="coddenunciado" id="coddenunciado">
                    <?php
                    $query = $pdo->query("SELECT codpessoa, nome FROM pessoa");
                    $pessoas = $query->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($pessoas as $pessoa) {
                        if ($pessoa['codpessoa'] !== $coddenunciante) {
                            echo "<option value='".$pessoa['codpessoa']."'>".$pessoa['nome']."</option>";
                        }
                    }
                    ?>
                </select>
            </p>
            <p>
                <label for="descricao">Descrição da Denúncia: </label>
                <textarea name="descricao" id="descricao" maxlength="300" rows="4" cols="50"></textarea>
            </p>
            <p>
                <label for="imagem">Anexar Imagem (opcional): </label>
                <input type="file" name="imagem" id="imagem" accept="image/*">
            </p>
            <p>
                <button type="submit" id="registrar_denuncia" name="registrar_denuncia">Registrar Denúncia</button>
            </p>
        </form>
    </section>

    <section id="section_minhas_denuncias">
        <h3 id="titulo_minhas_denuncias">Minhas Denúncias</h3>
        <?php
        if (!empty($denuncias)) {
            echo '<table id="tabela_denuncias">';
            echo '<tr><th>Código</th><th>Denunciado</th><th>Descrição</th><th>Imagem</th><th>Data</th><th>Ações</th></tr>';
            foreach ($denuncias as $denuncia) {
                echo '<tr>';
                echo '<td>'.$denuncia['coddenuncia'].'</td>';
                echo '<td>'.$denuncia['nome_denunciado'].'</td>';
                echo '<td>'.$denuncia['descricao'].'</td>';
                echo '<td>';
                if (!empty($denuncia['imagem'])) {
                    echo '<img src="imagens/' . $denuncia['imagem'] . '" width="50">';
                } else {
                    echo 'Nenhuma imagem anexada';
                }
                echo '</td>';
                echo '<td>'.$denuncia['reg_date'].'</td>';
                echo '<td>
                        <form action="includes/logica/logica_pessoa.php"   method="post" class="form-excluir-denuncia">
                            <input type="hidden" name="coddenuncia" value="'.$denuncia['coddenuncia'].'">
                            <button type="submit" name="excluir_denuncia" id=excluir_denuncia class="btn-excluir-denuncia" onclick="return confirm(\'Você tem certeza que deseja excluir esta denúncia?\');">Excluir</button>
                        </form>
                      </td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p id="nenhuma_denuncia">Nenhuma denúncia registrada.</p>';
        }
        ?>
    </section>
</main>
</body>
</html>


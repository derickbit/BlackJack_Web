<?php
include_once('includes/logica/conecta.php');
include_once('includes/logica/Partida.php');
include_once('includes/logica/PartidaController.php');
include_once('includes/componentes/cabecalho.php');
include_once('includes/componentes/header.php');
?>
    <script>
        function iniciarPartida() {
            const resultadoDiv = document.getElementById('resultado');
            resultadoDiv.innerHTML = 'Encontrando adversário...';

            setTimeout(() => { 
                fetch('api/iniciar_partida.php', {
                    method: 'POST',
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        resultadoDiv.innerHTML = 'Erro ao iniciar a partida. ' + data.error;
                    } else {
                        resultadoDiv.innerHTML = `Adversário encontrado: ${data.nome_jogador2}. Boa partida!`;

                        setTimeout(() => {
                            resultadoDiv.innerHTML = `Partida encerrada. Vencedor: ${data.nome_vencedor}<br>Pontuação: ${data.pontuacao}`;
                            atualizarHistorico();
                        }, 3000);
                    }
                })
                .catch(error => {
                    resultadoDiv.innerHTML = 'Ocorreu um erro: ' + error.message;
                });
            }, 3000);
        }

        function atualizarHistorico() {
            fetch('api/iniciar_partida.php?historico=true')
            .then(response => response.json())
            .then(historicoPartidas => {
                let html = `<h2 id="historico_titulo">Histórico de Partidas</h2>`;
                
                historicoPartidas.forEach(partida => {
                    const dataPartida = new Date(partida.reg_date);
                    const dataFormatada = dataPartida.toLocaleDateString('pt-BR');
                    const nomeLogado = '<?php echo $_SESSION['nome']; ?>';
                    const jogador1 = partida.nome_jogador1 === nomeLogado ? `<strong>${partida.nome_jogador1}</strong>` : partida.nome_jogador1;
                    const jogador2 = partida.nome_jogador2 === nomeLogado ? `<strong>${partida.nome_jogador2}</strong>` : partida.nome_jogador2;
                    const vencedor = partida.nome_vencedor === nomeLogado ? `<strong>${partida.nome_vencedor}</strong>` : partida.nome_vencedor;

                    html += `<div class="historico_partida">
                                <p>Partida: ${jogador1} x ${jogador2}</p>
                                <p>Vencedor: ${vencedor}</p>
                                <p>Pontuação: ${partida.pontuacao}</p>
                                <p>Data: ${dataFormatada}</p>
                             </div><hr>`;
                });

                document.getElementById('historico').innerHTML = html;
            })
            .catch(error => {
                console.error('Erro ao atualizar o histórico:', error);
            });
        }
    </script>
</head>
<body id="body_simulador" onload="atualizarHistorico()">
    <h1 id="titulo_simulador">Simulador de partidas</h1>
    <button id="btn_iniciar_partida" onclick="iniciarPartida()">Iniciar Partida</button>
    <div id="resultado">Vamos jogar!</div>
    <div id="historico"></div>
</body>
</html>
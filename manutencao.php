<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dicas para Manutenção e Limpeza do PC - Tech Fácil</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&display=swap');

        body {
            margin: 0;
            font-family: 'Merriweather', serif;
            background-color: #f4f4f4;
            color: #333;
        }

        header {
            background-color: #138684;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .content {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .content h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .tabs {
            display: flex;
            border-bottom: 2px solid #ccc;
            margin-bottom: 20px;
        }

        .tab {
            padding: 10px 20px;
            cursor: pointer;
            background-color: #f4f4f4;
            border: 1px solid #ccc;
            border-bottom: none;
            transition: background-color 0.3s;
        }

        .tab:hover {
            background-color: #e0e0e0;
        }

        .tab.active {
            background-color: white;
            font-weight: bold;
            border-bottom: 2px solid white;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .tab-content img {
            max-width: 100%;
            border-radius: 8px;
            margin: 20px 0;
        }

        footer {
            background-color: #138684;
            color: white;
            padding: 20px;
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <?php include("header.php"); ?>
<br><br><br><br>
    <header>
        <h1>Dicas para Manutenção e Limpeza do PC</h1>
        <p>Aprenda a fazer manutenção física e melhorar o desempenho do seu computador.</p>
    </header>

    <div class="content">
        <div class="tabs">
            <div class="tab active" data-tab="visao-geral">Visão Geral</div>
            <div class="tab" data-tab="manutencao-fisica">Manutenção Física</div>
            <div class="tab" data-tab="limpeza">Limpeza do Computador</div>
            <div class="tab" data-tab="dicas-desempenho">Dicas para Desempenho</div>
        </div>

        <div class="tab-content active" id="visao-geral">
            <h2>O que é a Manutenção e Limpeza do PC?</h2>
            <p>A manutenção e limpeza do PC são processos essenciais para garantir que o computador funcione de maneira eficiente e prolongue a sua vida útil. A manutenção física envolve cuidados com o hardware, como o interior do gabinete e os componentes. A limpeza ajuda a remover poeira e sujeira, prevenindo o sobreaquecimento e danos aos componentes.</p>
            <center>
            <img src="laptop.png" alt="Manutenção do PC">
            </center>
        </div>

        <div class="tab-content" id="manutencao-fisica">
            <h2>Manutenção Física do Computador</h2>
            <p>A manutenção física do computador inclui a verificação e a limpeza de componentes internos e externos, como o processador, a memória RAM e o disco rígido.</p>
            <ol>
                <li><strong>Desligue o PC e desconecte da tomada:</strong> Sempre desligue o computador antes de realizar qualquer manutenção para evitar danos aos componentes.</li>
                <li><strong>Verifique as conexões internas:</strong> Abra o gabinete e verifique se todos os cabos estão bem conectados, sem sinais de desgaste.</li>
                <li><strong>Reveja o sistema de refrigeração:</strong> Verifique as ventoinhas e dissipadores de calor. Se necessário, substitua as ventoinhas que não estejam funcionando corretamente.</li>
                <li><strong>Verifique os componentes internos:</strong> Certifique-se de que não há peças soltas ou danificadas dentro do gabinete. Isso pode incluir a memória RAM, placa gráfica e outros periféricos internos.</li>
            </ol>
            <center>
            <img src="fisico.png" alt="Manutenção Interna do PC">
            </center>
        </div>

        <div class="tab-content" id="limpeza">
            <h2>Limpeza do Computador</h2>
            <p>Manter o computador limpo ajuda a melhorar o desempenho e prolonga a sua vida útil. A limpeza envolve tanto os componentes internos quanto os externos do computador.</p>
            <ol>
                <li><strong>Limpeza externa:</strong> Use um pano de microfibra para limpar o monitor, teclado e mouse. Evite o uso de produtos químicos agressivos.</li>
                <li><strong>Limpeza interna:</strong> Utilize ar comprimido para remover a poeira acumulada nos componentes internos, como a placa-mãe, ventoinhas e dissipadores de calor. Não toque diretamente nos componentes com as mãos para evitar danos.</li>
                <li><strong>Remova poeira do gabinete:</strong> Abra o gabinete e use um aspirador de pó ou ar comprimido para remover a poeira. Evite o uso de aspiradores de mão com muita potência, pois podem gerar estática.</li>
            </ol>
            <center>
            <img src="limpeza.png" alt="Limpeza do Computador">
            </center>
        </div>

        <div class="tab-content" id="dicas-desempenho">
            <h2>Dicas para Melhorar o Desempenho do Computador</h2>
            <ul>
                <li><strong>Atualize os drivers:</strong> Manter os drivers do hardware atualizados ajuda a melhorar a compatibilidade e o desempenho geral do sistema.</li>
                <li><strong>Desfragmente o disco rígido:</strong> Se estiver a usar um disco rígido HDD, a desfragmentação pode melhorar a velocidade de acesso aos dados.</li>
                <li><strong>Desative programas desnecessários:</strong> Muitos programas iniciam automaticamente com o Windows. Desative os que não são essenciais para liberar recursos do sistema.</li>
                <li><strong>Adicione mais memória RAM:</strong> Se o seu computador estiver a ficar lento ao executar múltiplas tarefas, considere adicionar mais memória RAM para melhorar o desempenho.</li>
                <li><strong>Verifique a utilização do processador:</strong> Utilize o Gerenciador de Tarefas para verificar se algum programa está a usar excessivamente o processador. Feche os que não são necessários.</li>
            </ul>
        </div>
    </div>

    <?php include("loginfooter.php"); ?>

    <script>
        const tabs = document.querySelectorAll('.tab');
        const contents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active'));
                contents.forEach(c => c.classList.remove('active'));

                tab.classList.add('active');
                document.getElementById(tab.dataset.tab).classList.add('active');
            });
        });
    </script>
</body>
</html>

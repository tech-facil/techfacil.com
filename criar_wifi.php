<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Como Criar uma Rede Wi-Fi - Tech Fácil</title>
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
        #img1
        {
            width:450px;
        }
    </style>
</head>
<body>
    <?php include("header.php"); ?>
<br><br><br><br>
    <header>
        <h1>Como Criar uma Rede Wi-Fi</h1>
        <p>Aprenda a configurar uma rede Wi-Fi segura em sua casa ou no trabalho.</p>
    </header>

    <div class="content">
        <div class="tabs">
            <div class="tab active" data-tab="visao-geral">Visão Geral</div>
            <div class="tab" data-tab="passos">Passos para Configurar</div>
            <div class="tab" data-tab="erros-comuns">Erros Comuns</div>
            <div class="tab" data-tab="dicas">Dicas Adicionais</div>
        </div>

        <div class="tab-content active" id="visao-geral">
            <h2>O que é uma Rede Wi-Fi?</h2>
            <p>Uma rede Wi-Fi é uma rede sem fio que permite a comunicação entre dispositivos, como smartphones, computadores e outros aparelhos, através de sinais de rádio. Com a rede Wi-Fi, pode aceder à Internet sem a necessidade de cabos.</p>
            <center>
            <img class= "#img1" src="wifi.png" alt="Ilustração de rede Wi-Fi">
            </center>
        </div>

        <div class="tab-content" id="passos">
            <h2>Passos para Configurar a Rede Wi-Fi</h2>
            <ol>
                <li><strong>Conecte o Roteador ao Modem</strong><br>
                    Ligue o seu roteador ao modem usando um cabo Ethernet. Certifique-se de que ambos os dispositivos estão devidamente conectados e ligados.
                </li>
                <li><strong>Acesse o Painel de Administração do Roteador</strong><br>
                    Abra um navegador e insira o endereço IP do seu roteador (geralmente, é 192.168.0.1 ou 192.168.1.1) na barra de endereços. Entre com o nome de utilizador e a palavra-passe do roteador.
                </li>
                <li><strong>Configure o Nome da Rede (SSID)</strong><br>
                    No painel de administração, procure pela opção de configuração do "Nome da Rede" ou "SSID". Escolha um nome único para a sua rede Wi-Fi.
                </li>
                <li><strong>Defina uma Palavra-Passe Forte</strong><br>
                    Configure uma palavra-passe segura para proteger a sua rede Wi-Fi. Utilize uma combinação de letras, números e símbolos para garantir a segurança.
                </li>
                <li><strong>Selecione o Tipo de Segurança</strong><br>
                    Escolha o tipo de segurança WPA2 ou WPA3 para garantir uma comunicação segura na sua rede.
                </li>
                <li><strong>Guarde as Configurações</strong><br>
                    Após terminar a configuração, guarde as alterações. O roteador pode reiniciar automaticamente.
                </li>
            </ol>
            <center>
            <img class= "img1" src="router.png" alt="Configuração do Router">
            </center>
        </div>

        <div class="tab-content" id="erros-comuns">
            <h2>Erros Comuns ao Configurar uma Rede Wi-Fi</h2>
            <ul>
                <li><strong>Problema de Conexão</strong>: Se os dispositivos não conseguem conectar à rede, verifique se a palavra-passe está correta e se o roteador está funcionando corretamente.</li>
                <li><strong>Rede Wi-Fi Não Aparece</strong>: Verifique se o SSID está visível nas configurações do roteador. Se estiver oculto, altere a configuração para torná-lo visível.</li>
                <li><strong>Interferências na Rede</strong>: Se a conexão estiver instável, tente mover o roteador para um local mais central e afastado de objetos metálicos ou eletrônicos que possam causar interferência.</li>
            </ul>
        </div>

        <div class="tab-content" id="dicas">
            <h2>Dicas para Melhorar o Desempenho da Rede Wi-Fi</h2>
            <ul>
                <li><strong>Escolha o Canal de Wi-Fi Certo:</strong> Se sua rede está congestionada, tente mudar o canal de Wi-Fi no painel do roteador para evitar interferências com redes próximas.</li>
                <li><strong>Coloque o Roteador em um Local Central:</strong> Colocar o roteador no centro da casa ou escritório ajuda a melhorar a cobertura e o desempenho da rede.</li>
                <li><strong>Atualize o Firmware do Roteador:</strong> Verifique regularmente se há atualizações de firmware para o seu roteador. Isso pode melhorar o desempenho e corrigir falhas de segurança.</li>
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

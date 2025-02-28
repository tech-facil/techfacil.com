<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuração do Hiren's Boot CD - Tech Fácil</title>
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
        <h1>Configuração de Hiren's Boot CD</h1>
        <p>Aprenda a utilizar o Hiren's Boot CD para manutenção e recuperação de sistemas.</p>
    </header>

    <div class="content">
        <div class="tabs">
            <div class="tab active" data-tab="geral">Visão Geral</div>
            <div class="tab" data-tab="erros-comuns">Erros Comuns</div>
            <div class="tab" data-tab="passo-a-passo">Passo a Passo</div>
            <div class="tab" data-tab="recursos">Recursos</div>
        </div>

        <div class="tab-content active" id="geral">
            <h2>O que é o Hiren's Boot CD?</h2>
            <p>O Hiren's Boot CD é uma ferramenta multifuncional para recuperação e manutenção de sistemas. Inclui uma variedade de ferramentas úteis para diagnóstico de hardware, recuperação de ficheiros e muito mais.</p>
            <center>
            <img src="hirens-boot-menu.png" alt="Visão Geral do Hiren's Boot CD">
            <center>

        </div>



        <div class="tab-content" id="erros-comuns">
    <h2>Erros Comuns</h2>
    <ul>
        <li>
            <strong>Erro ao iniciar a pen drive:</strong><br>
            Este erro pode ocorrer se a pen drive não for reconhecida corretamente pelo computador ou se a ordem de boot não estiver configurada. Para resolver:
            <ul>
                <li>Certifica-te de que a pen drive está bem conectada à porta USB.</li>
                <li>Verifica na BIOS se a ordem de boot está configurada para priorizar a pen drive USB.</li>
                <li>Se o computador tiver o "Secure Boot" ativado, desativa esta funcionalidade na BIOS.</li>
            </ul>
        </li>
        <br>
        <li>
            <strong>Ferramentas que não carregam corretamente:</strong><br>
            Algumas ferramentas podem falhar ao iniciar devido a incompatibilidades de hardware ou configurações do sistema. Soluções possíveis:
            <ul>
                <li>Certifica-te de que o modo "Legacy Boot" está ativado, especialmente em computadores com UEFI.</li>
                <li>Se o problema persistir, experimenta usar outra porta USB no computador.</li>
                <li>Garantimos que as nossas pens USB são testadas antes de serem enviadas, mas se encontrares algum problema, contacta-nos para suporte técnico.</li>
            </ul>
        </li>
        <br>
        <li>
            <strong>Problemas de compatibilidade com sistemas antigos:</strong><br>
            Em computadores mais antigos, pode haver dificuldades em reconhecer a pen drive ou executar ferramentas modernas. Para ultrapassar:
            <ul>
                <li>Certifica-te de que o computador suporta arranque por USB. Caso contrário, será necessário criar um CD com a imagem do Hiren's Boot.</li>
                <li>Contacta o nosso suporte técnico para assistência personalizada em sistemas mais antigos.</li>
            </ul>
        </li>
        <br> 
        <li>
            <strong>Configurações de BIOS difíceis de alterar:</strong><br>
            Muitos utilizadores têm dificuldade em alterar as configurações da BIOS, especialmente a ordem de boot. Para facilitar:
            <ul>
                <li>Consulta o manual do teu computador ou pesquisa pelo modelo para encontrar as teclas de acesso à BIOS (geralmente F2, DEL, ESC ou F12).</li>
                <li>Oferecemos um guia detalhado com as nossas pens USB para ajudar nesta configuração.</li>
            </ul>
        </li>
        <br>
    </ul>
    <p>As nossas pens USB vêm pré-configuradas para eliminar a necessidade de configurações complexas. Caso tenhas dúvidas ou precises de assistência, o nosso suporte técnico está sempre disponível para ajudar.</p>
    <center>
    <img src="erros.jfif" alt="Erros Comuns do Hiren's Boot CD">
    <center>
</div>



        <div class="tab-content" id="passo-a-passo">
            <h2>Guia Passo a Passo</h2>
            <p><strong>Nota:</strong> Para simplificar todo o processo, adquira uma das nossas <strong>pen drives USB, já configuradas com o Hiren's Boot CD.</strong> Disponível no <a href="loja.php">Tech Fácil</a></p>
                <ol>
                <li>
                    <strong>Adquira uma pen drive inicializável</strong><br>
                    Compre a nossa pen drive já configurada com o Hiren's Boot CD. Isso elimina a necessidade de baixar e configurar o software manualmente.
                    <center>
                    <img src="pen-drive-techfacil.jpg" alt="Pen drive inicializável Hiren's Boot CD" width="400px">
                    <center>
                </li>
                <li>
                    <strong>Insira a pen drive no computador</strong><br>
                    Conecte a pen drive ao computador. Certifique-se de que está bem conectada.
                </li>
                <li>
                    <strong>Acesse a BIOS</strong><br>
                    Reinicie o computador. Enquanto ele estiver ligando, fique atento à mensagem na tela que indica qual tecla pressionar para acessar a BIOS ou o Menu de Boot. Geralmente, são as teclas <strong>F2</strong>, <strong>DEL</strong>, <strong>ESC</strong> ou <strong>F12</strong>. Caso não saiba qual tecla pressionar, consulte o manual do seu computador ou procure online pelo modelo.
                    <center>
                    <img src="hirens-boot-access-bios.jpg" alt="Tela de acesso à BIOS">
                    <center>
                </li>
                <li>
                    <strong>Configure o boot pela BIOS</strong><br>
                    Ao acessar a BIOS, procure pela aba de ordem de boot ou "Boot Order". Altere a ordem para que a pen drive USB seja a primeira opção. Se o seu computador tiver UEFI ativado, habilite o "Modo Legacy" para garantir a compatibilidade com o Hiren's Boot CD.
                    <center>
                    <img src="hirens-boot-bios-config.jpg" alt="Configuração da BIOS">
                    <center>
                </li>
                <li>
                    <strong>Salve e saia da BIOS</strong><br>
                    Após configurar a ordem de boot, pressione a tecla para salvar as alterações (geralmente <strong>F10</strong>) e selecione "Yes" para confirmar. O computador reiniciará automaticamente.
                </li>
                <li>
                    <strong>Inicialize o Hiren's Boot CD</strong><br>
                    Com a pen drive configurada, o menu do Hiren's Boot CD aparecerá após o reinício. Navegue pelas opções usando as setas do teclado e selecione a ferramenta que deseja utilizar pressionando <strong>Enter</strong>.
                    <center>
                    <img src="hirens-boot-menu.png" alt="Menu do Hiren's Boot CD">
                    <center>
                </li>
                <li>
                    <strong>Resolva os problemas ou faça a manutenção</strong><br>
                    Agora pode usar as ferramentas disponíveis para diagnosticar, reparar ou recuperar seu sistema. Se precisar de ajuda, consulte os tutoriais incluídos na pen drive.
                </li>
            </ol>
        </div>

        <div class="tab-content" id="recursos">
            <h2>Recursos Adicionais</h2>
            <ul>
                <li>Tutoriais detalhados incluídos na pen drive.</li>
                <li>Suporte ao cliente exclusivo para compradores.</li>
                <li>FAQ completo disponível no Tech Fácil.</li>
            </ul>
            <img src="hirens-boot-resources.png" alt="Recursos do Hiren's Boot CD">
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

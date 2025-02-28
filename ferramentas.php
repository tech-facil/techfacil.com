<!DOCTYPE html>
<?php
session_start();
?>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ferramentas Online Úteis</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Open+Sans:wght@400;700&family=Lato:wght@400;700&family=Montserrat:wght@400;700&family=Poppins:wght@400;700&family=Merriweather:wght@400;700&family=Playfair+Display:wght@400;700&family=Lora:wght@400;700&family=Bitter:wght@400;700&family=Source+Serif+Pro:wght@400;700&family=Oswald:wght@400;700&family=Raleway:wght@400;700&family=Abril+Fatface&family=Pacifico&family=Dancing+Script&display=swap');
        
        body {
            margin: 0;
            font-family: 'Merriweather', serif;
            background-color: #d0e0e3;
            background-image: url('background.png');
        }

        .hero {
            text-align: center;
            padding: 50px 20px;
            background-color: #138684; /* Cor de fundo azul */
            color: white; /* Cor do texto em branco */
        }

        h1 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 50px 0;
        }

        .tools-gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 20px;
        }

        .tool-card {
            background-color: #fff;
            width: 220px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 150px; 
        }

        .tool-card.active {
            height: 350px; 
        }

        .tool-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .tool-card.active img {
            height: 150px; 
        }

        .tool-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .tool-card h3 {
            padding: 10px;
            background-color: #138684;
            color: #fff;
            margin: 0;
        }

        .tool-description {
            display: none;
            padding: 10px;
            background-color: #f4f4f4;
            color: #333;
            font-size: 14px;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .tool-card.active .tool-description {
            display: block;
        }

        @media screen and (max-width: 600px) {
            .tools-gallery {
                flex-direction: column;
                align-items: center;
            }
        }

        footer {
            background-color: #138684;
            color: white;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include ("header.php"); ?>
    <br><br><br>
    <!-- Seção Hero -->
    <div class="hero">
        <h1>Ferramentas Online Úteis</h1>
        <p>Descubra ferramentas poderosas para tornar seu trabalho mais eficiente e seguro.</p>
    </div>

    <div class="container">
        <div class="tools-gallery">
            <div class="tool-card" onclick="toggleDescription(this)">
                <img src="haveibeenpwned.png" alt="Have I Been Pwned">
                <h3>Have I Been Pwned</h3>
                <div class="tool-description">
                    <p>Verifique se seu e-mail foi exposto em brechas de segurança em vários sites e serviços online.</p>
                    <a href="https://haveibeenpwned.com/" target="_blank">Visitar</a>
                </div>
            </div>
            <div class="tool-card" onclick="toggleDescription(this)">
                <img src="proxynova.jpg" alt="ProxyNova">
                <h3>ProxyNova</h3>
                <div class="tool-description">
                    <p>Veja listas de proxies gratuitos e verifique seu IP público, além de testar a confiabilidade de proxies.</p>
                    <a href="https://www.proxynova.com/" target="_blank">Visitar</a>
                </div>
            </div>
            <div class="tool-card" onclick="toggleDescription(this)">
                <img src="virustotal.png" alt="VirusTotal">
                <h3>VirusTotal</h3>
                <div class="tool-description">
                    <p>Verifique arquivos e URLs suspeitos com múltiplos motores antivírus para verificar a presença de vírus e malwares.</p>
                    <a href="https://www.virustotal.com/" target="_blank">Visitar</a>
                </div>
            </div>
            <div class="tool-card" onclick="toggleDescription(this)">
                <img src="ipinfo.png" alt="IPinfo">
                <h3>IPinfo</h3>
                <div class="tool-description">
                    <p>Veja informações sobre o seu endereço IP, como a localização, provedor de internet e muito mais.</p>
                    <a href="https://ipinfo.io/" target="_blank">Visitar</a>
                </div>
            </div>
            <div class="tool-card" onclick="toggleDescription(this)">
                <img src="chatgpt.png" alt="ChatGPT">
                <h3>ChatGPT</h3>
                <div class="tool-description">
                <p>ChatGPT é um assistente virtual baseado em Int. Artificial que responde perguntas, cria conteúdos e auxilia em diversas tarefas.</p> 
                <a href="https://chatgpt.com" target="_blank">Visitar</a>
            </div>
           

            </div>
            <div class="tool-card" onclick="toggleDescription(this)">
                <img src="w3schools.png" alt="w3schools">
                <h3>W3SCHOOLS</h3>
                <div class="tool-description">
                    <p>Um dos websites mais conhecidos para aprender web design, HTML, CSS, JavaScript, SQL, e muito mais. </p>
                    <a href="https://www.w3schools.com" target="_blank">Visitar</a>
                </div>
            </div>
            <div class="tool-card" onclick="toggleDescription(this)">
                <img src="tinyurl.png" alt="TinyURL">
                <h3>TinyURL</h3>
                <div class="tool-description">
                    <p>Crie URLs curtas e personalizadas para compartilhar de forma mais conveniente.</p>
                    <a href="https://tinyurl.com/" target="_blank">Visitar</a>
                </div>
            </div>
            <div class="tool-card" onclick="toggleDescription(this)">
                <img src="github.png" alt="GitHub">
                <h3>GitHub</h3>
                <div class="tool-description">
                    <p>Plataforma de hospedagem de código com controle de versão e colaboração para programadores.</p>
                    <a href="https://github.com" target="_blank">Visitar</a>
                </div>
            </div>
        </div>
    </div>

    <?php include("loginfooter.php"); ?>

    <script>
        function toggleDescription(card) {
            var allCards = document.querySelectorAll('.tool-card');
            allCards.forEach(function(otherCard) {
                if (otherCard !== card) {
                    otherCard.classList.remove('active'); 
                }
            });

            card.classList.toggle('active'); 
        }
    </script>

</body>
</html>

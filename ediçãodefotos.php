<!DOCTYPE html>
<?php
session_start();
?>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ferramentas de Edição de Imagem</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');
        
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            background-image: url('background.png');

        }

        .hero {
            text-align: center;
            padding: 50px 20px;
            background-color: #138684;
            color: white;
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
    <?php include("header.php"); ?>
    <br><br><br>
    <!-- Seção Hero -->
    <div class="hero">
        <h1>Ferramentas de Edição de Imagem</h1>
        <p>Explore ferramentas que transformam suas imagens de forma prática e eficiente.</p>
    </div>

    <div class="container">
        <div class="tools-gallery">
            <div class="tool-card" onclick="toggleDescription(this)">
                <img src="photopea.png" alt="Photopea">
                <h3>Photopea</h3>
                <div class="tool-description">
                    <p>Editor de imagem online gratuito, semelhante ao Photoshop, com suporte para vários formatos de arquivo.</p>
                    <a href="https://www.photopea.com/" target="_blank">Visitar</a>
                </div>
            </div>
            <div class="tool-card" onclick="toggleDescription(this)">
                <img src="canva.png" alt="Canva">
                <h3>Canva</h3>
                <div class="tool-description">
                    <p>Ferramenta de design gráfico e edição de imagens com modelos prontos para uso.</p>
                    <a href="https://www.canva.com/" target="_blank">Visitar</a>
                </div>
            </div>
            <div class="tool-card" onclick="toggleDescription(this)">
                <img src="removebg.png" alt="Remove.bg">
                <h3>Remove.bg</h3>
                <div class="tool-description">
                    <p>Remova fundos de imagens automaticamente com inteligência artificial.</p>
                    <a href="https://www.remove.bg/" target="_blank">Visitar</a>
                </div>
            </div>
            <div class="tool-card" onclick="toggleDescription(this)">
                <img src="pixlr.png" alt="Pixlr">
                <h3>Pixlr</h3>
                <div class="tool-description">
                    <p>Editor de imagens online com ferramentas fáceis de usar e filtros criativos.</p>
                    <a href="https://pixlr.com/" target="_blank">Visitar</a>
                </div>
            </div>
            <div class="tool-card" onclick="toggleDescription(this)">
                <img src="dalle.png" alt="DALL-E">
                <h3>DALL·E</h3>
                <div class="tool-description">
                    <p>Gere imagens a partir de texto com inteligência artificial, criando obras criativas e exclusivas.</p>
                    <a href="https://openai.com/dall-e/" target="_blank">Visitar</a>
                </div>
            </div>
            <div class="tool-card" onclick="toggleDescription(this)">
                <img src="deepai.png" alt="DeepAI">
                <h3>DeepAI</h3>
                <div class="tool-description">
                    <p>Ferramenta poderosa para geração de arte e edição de imagens com algoritmos baseados em IA.</p>
                    <a href="https://deepai.org/" target="_blank">Visitar</a>
                </div>
            </div>
            <div class="tool-card" onclick="toggleDescription(this)">
                <img src="runway.png" alt="Runway">
                <h3>Runway</h3>
                <div class="tool-description">
                    <p>Edite vídeos e imagens com ferramentas de IA avançadas, incluindo remoção de objetos e geração de conteúdo.</p>
                    <a href="https://runwayml.com/" target="_blank">Visitar</a>
                </div>
            </div>
            <div class="tool-card" onclick="toggleDescription(this)">
                <img src="colorhunt.png" alt="Color Hunt">
                <h3>Color Hunt</h3>
                <div class="tool-description">
                    <p>Descubra paletas de cores incríveis para seus projetos de design e mantenha a consistência visual.</p>
                    <a href="https://colorhunt.co/" target="_blank">Visitar</a>
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

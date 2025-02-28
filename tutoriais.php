<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutoriais - Tech Fácil</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&display=swap');

        body {
            margin: 0;
            font-family: 'Merriweather', serif;
            background-color: #d0e0e3;
            background-image: url('background.png');
        }

        .hero {
            text-align: center;
            padding: 50px 20px;
            margin-top: 80px;
            background-color: #138684; 
            color: white; 
        }

        .hero h1 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .tutorials-section {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .tutorial-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 280px;
            text-align: center;
            padding: 20px;
            transition: transform 0.3s ease;
        }

        .tutorial-card:hover {
            transform: scale(1.05);
        }

        .tutorial-card h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .tutorial-card p {
            font-size: 14px;
            color: #555;
            margin-bottom: 15px;
        }

        .tutorial-card a {
            display: inline-block;
            background-color: #138684;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
        }

        .tutorial-card a:hover {
            background-color: #19b3b0;
        }

        footer {
            background-color: #138684;
            color: white;
            padding: 30px;
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <?php include("header.php"); ?>

    <div class="hero">
        <h1>Tutoriais</h1>
        <p>Aprenda a usar os nossos produtos e domine a informática com tutoriais detalhados.</p>
    </div>

    <div class="tutorials-section">
        <div class="tutorial-card">
            <h3>Configuração de Hirens Boot CD</h3>
            <p>Aprenda a utilizar o hirens boot CD</p>
            <a href="hirensbootcd.php">Ver Tutorial</a>
        </div>
        <div class="tutorial-card">
            <h3>Como Criar uma Rede Wi-Fi</h3>
            <p>Aprenda a configurar uma rede Wi-Fi segura em casa ou no trabalho.</p>
            <a href="criar_wifi.php">Ver Tutorial</a>
        </div>
        <div class="tutorial-card">
            <h3>Dicas para Manutenção e Limpeza do PC</h3>
            <p>Aprenda a fazer manutenção física e melhorar o desempenho do seu computador.</p>
            <a href="manutencao.php">Ver Tutorial</a>
        </div>
    </div>

    <?php include("loginfooter.php"); ?>
    
</body>
</html>

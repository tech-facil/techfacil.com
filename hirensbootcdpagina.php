<!DOCTYPE html>
<?php
session_start();
include("header.php");
?>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiren's Boot CD - Tech Fácil</title>
    <style>
        body {
            font-family: 'Merriweather', serif;
            margin: 0;
            background-color: #1a1a1a;
            background-image: url('maxresdefault.jpg');
            background-size: cover;
            background-attachment: fixed;
        }

        .hero {
            text-align: center;
            padding: 50px 20px;
            background-color: #138684;
            color: white;
        }

        .highlight {
            background-color: #138684;
            color: white;
            font-size: 20px;
            font-weight: bold;
            padding: 15px 20px;
            border-radius: 8px;
            display: inline-block;
            margin-top: 20px;
        }

        .content {
            margin: 30px auto;
            width: 90%;
            border-radius: 10px;
            padding: 20px;
        }

        .produto {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin: 20px auto;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 20px;
            width: 90%;
            max-width: 400px;
        }

        .produto img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .produto h3 {
            font-size: 24px;
            color: white;
            margin-bottom: 10px;
        }

        .produto p {
            font-size: 18px;
            color: white;
            margin-bottom: 15px;
        }

        .produto .price {
            font-size: 20px;
            font-weight: bold;
            color: white;
            margin: 10px 0;
        }

        .produto button {
            padding: 10px 20px;
            background-color: #138684;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
        }

        .produto button:hover {
            background-color: #0056b3;
        }

        .video-container {
            text-align: center;
            margin: 30px auto;
            width: 80%; 
            max-width: 800px;
            color: white;
        }

        .video-container h2 {
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .video-container p {
            font-size: 18px;
            margin-bottom: 20px;
            font-style: italic;
        }

        .video-thumbnail {
            width: 100%;
            max-width: 800px;
            height: 450px;
            background-size: cover;
            background-position: center;
            position: relative;
            border-radius: 10px;
            cursor: pointer;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease;
        }

        .video-thumbnail:hover {
            transform: scale(1.05);
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 10px;
        }

        .video-thumbnail:hover .overlay {
            opacity: 1;
        }

        .overlay span {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .play-icon {
            width: 50px;
            height: 50px;
        }

        .download-section {
            margin: 30px auto;
            width: 90%;
            border-radius: 10px;
            padding: 20px;
        }

        .download-section a {
            padding: 10px 20px;
            background-color: #138684;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 18px;
        }

        .download-section a:hover {
            background-color: #0056b3;
        }

        .download-section p {
            color: white;
        }

        footer {
            text-align: center;
            background-color: #138684;
            color: white;
            padding: 30px;
        }
    </style>
</head>
<body>
    <br><br><br>

    <div class="hero">
        <h1>Hiren's Boot CD - Kit de Recuperação Completo</h1>
        <span class="highlight">O pen drive essencial para recuperar o seu sistema em minutos.</span>
    </div>

    <div class="content">
        <div class="produto">
            <img src="pen-drive-techfacil.jpg" alt="Hiren's Boot CD - Pen Drive">
            <h3>Hiren's Boot CD</h3>
            <p>O Hiren's Boot CD é a ferramenta completa para emergências no Windows. Inclui manual e suporte técnico para garantir que tudo funciona perfeitamente.</p>
            <p class="price">€20,00</p>
            <button onclick="window.location.href='registar_hirens.php'">Comprar Agora</button>
            <br><br>
            <a href="hirensbootcd.php"><button>Ver Mais Informações</button></a>
        </div>

        <div class="video-container">
            <h2>Assista ao Tutorial Completo</h2>
            <p>Confira como usar o Hiren's Boot CD para recuperar o seu sistema Windows.</p>
            <a href="https://www.youtube.com/watch?v=XVc-NRIzzOU" target="_blank">
                <div class="video-thumbnail" style="background-image: url('https://img.youtube.com/vi/XVc-NRIzzOU/maxresdefault.jpg');">
                    <div class="overlay">
                        <span>Assista ao vídeo</span>
                        <img src="play-button.png" alt="Play" class="play-icon">
                    </div>
                </div>
            </a>
        </div>

        <center>
            <div class="download-section">
                <p>Baixe o manual completo com todas as instruções:</p>
                <a href="Manual do Kit Pen Drive de Resgate para Computadores.pdf" download>📥 Baixar Manual</a>
            </div>
        </center>
    </div>

    <?php include("loginfooter.php"); ?>
</body>
</html>

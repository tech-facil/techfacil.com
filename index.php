<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Fácil</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Merriweather:wght@400;700&display=swap');

        body {
            margin: 0;
            font-family: 'Merriweather', serif;
            background-color: #d0e0e3;          
            background-image: url('background.png');
            text-align: center;
        }

        .hero {
            text-align: center;
            padding: 100px 20px;
            position: relative;
            margin-top: 80px;
        }

        .bemvindo {
            background-color: white;
            padding: 40px 20px;
            border-radius: 8px;
            margin: 0 auto;
            max-width: 1000px;
        }

        .hero h1 {
            font-size: 48px;
            font-weight: 700;
            margin: 0;
            animation: fadeInDown 1s ease-in-out;
        }

        .hero p {
            font-size: 20px;
            margin: 20px 0;
            animation: fadeInUp 1.5s ease-in-out;
        }

        .btn-secondary {
            background-color: #138684;
            padding: 15px 40px;
            border-radius: 30px;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: transform 0.3s ease, background-color 0.3s;
        }

        .btn-secondary:hover {
            background-color: #19b3b0;
            transform: scale(1.05);
        }

        footer {
            background-color: #138684;
            color: white;
            padding: 30px;
            text-align: center;
        }

        .section {
            margin: 40px auto;
            padding: 20px;
            max-width: 1000px;
            background-color: white;
            border-radius: 8px;
            text-align: center;
        }

        .section h2 {
            font-size: 32px;
            margin-bottom: 20px;
            color: #138684;
        }

        .section ul {
            list-style: none;
            padding: 0;
        }

        .section ul li {
            margin: 20px 0;
        }

        .download-buttons {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .download-item {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            width: 250px;
        }

        .download-item h3 {
            font-size: 20px;
            color: #333;
        }

        .download-item p {
            margin: 10px 0 20px;
        }

        #cimafooter {
            color: white;
            padding: 70px 20px;
            background-color: #138684;
            text-align: center;
            border-radius: 0;
        }

        #cimafooter h2 {
            font-size: 32px;
            margin-bottom: 20px;
            color: white;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <?php 
    include("header.php");
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message']; 
        unset($_SESSION['message']); 
    }
    ?>

    <div class="hero">
        <div class="bemvindo">
            <h1>Bem Vindo ao Tech Fácil</h1>
            <p>A simplificar a informática para iniciantes com tutoriais, ferramentas e kits de reparação.</p>
            <a href="loja.php"><button class="btn-secondary">Explorar a loja</button></a>
        </div>
    </div>
    <div class="section">
        <h2>Ferramentas Úteis</h2>
        <div class="download-buttons">
            <div class="download-item">
                <h3>Diagnosticar Hardware</h3>
                <p>Identifique problemas no seu computador com um clique.</p>
                <br>
                <a href="https://www.cpuid.com/softwares/cpu-z.html" class="btn-secondary" target="_blank">Download</a>
                </div>
            <div class="download-item">
                <h3>Otimizar o seu Sistema</h3>
                <p>Melhore o desempenho do seu PC em minutos.</p>
                <br>
                <a href="https://www.ccleaner.com/" class="btn-secondary" target="_blank">Download</a>
                </div>
            <div class="download-item">
                <h3>Construtor online de PC</h3>
                <p>Organize e compre o seu computador de sonho</p>
                <br>
                <a href="https://www.pcbuildingsim.com/" class="btn-secondary" target="_blank">Download</a>   
            </div>
        </div>
    </div>

    <div class="section">
        <h2>Depoimentos</h2>
        <blockquote style="font-style: italic; border-left: 4px solid #138684; padding-left: 20px;">
            "O Tech Fácil me ajudou a entender conceitos básicos de informática que antes pareciam complicados!" - Joana S.
        </blockquote>
        <blockquote style="font-style: italic; border-left: 4px solid #138684; padding-left: 20px; margin-top: 20px;">
            "Adorei os tutoriais simples e diretos. Recomendo a todos os iniciantes!" - Carlos M.
        </blockquote>
    </div>

    
    <?php include("loginfooter.php"); ?>

    <script>
        function MostraModal() {
            document.getElementById('id01').style.display = 'block'; 
        }
    </script>
</body>
</html>

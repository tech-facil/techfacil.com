<!DOCTYPE html>
<?php
session_start();
?>
<?php include("header.php"); ?>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nós - Tech Fácil</title>
    <style>
        body {
            font-family: 'Merriweather', serif;
            background-color: #d0e0e3;
            margin: 0;
            font-size: 20px;
            background-image: url('background.png');
        }

        .hero {
            text-align: center;
            padding: 50px 20px;
            background-color: #138684;
            color: white;
        }

        .hero h1 {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .hero p {
            font-size: 20px;
            line-height: 1.6;
        }

        .about-container {
            width: 60%;
            margin: 30px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            text-align: center;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        footer {
            background-color: #138684;
            color: white;
            padding: 30px;
            text-align: center;
        }

        ul {
            text-align: left;
            margin: 20px auto;
            padding-left: 40px;
            list-style-type: disc;
        }
    </style>
</head>
<body>
     <br><br><br>
    <div class="hero">
        <h1>Sobre nós</h1>
    </div>

    <div class="about-container">
        <h3>Quem Somos</h3>
        <p>O Tech Fácil é uma plataforma online dedicada a facilitar o uso da informática para iniciantes. A nossa missão é tornar a tecnologia acessível e descomplicada, oferecendo produtos e serviços que ajudam a resolver problemas comuns do dia a dia na informática.</p>

        <h3>O que Oferecemos</h3>
        <p>Oferecemos uma variedade de produtos e serviços como:</p>
        <ul>
            <li>Hiren's Boot CD para recuperação e manutenção de sistemas</li>
            <li>Chaves de ativação do Windows e outras licenças de software</li>
            <li>Kits de reparação de hardware e ferramentas de diagnóstico</li>
            <li>Flipper Zero - Dispositivo multifuncional com funcionalidades para testar sistemas de rádio, RFID, infravermelhos e muito mais.</li>
            <li>Microcontroladores e Componentes Electrónicos - Componentes para projetos de eletrónica, robótica e automação.</li>
        </ul>

        <h3>O Nosso Compromisso</h3>
        <p>O nosso objetivo é fornecer aos nossos clientes soluções práticas e de qualidade, com suporte completo e materiais didáticos que tornam o aprendizado de informática fácil e acessível.</p>

        <h3>Por que Escolher o Tech Fácil?</h3>
        <p>Escolha o Tech Fácil porque somos uma equipa dedicada, com paixão por tecnologia e comprometida em oferecer as melhores soluções para os desafios do seu computador. Garantimos qualidade, segurança e um atendimento personalizado para que tenha a melhor experiência possível.</p>
    </div>
    <footer>
        <p>&copy; 2024, Tech Fácil. Todos os direitos reservados.</p>
    </footer>
</body>
</html>

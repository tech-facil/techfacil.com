<?php
session_start();
if (!isset($_SESSION['id_tipologin']) != 1) {
    header("Location: index.php");
    exit();
}
include('db.php');
$stmt = $conn->prepare("SELECT COUNT(*) AS total_novas_mensagens FROM mensagens_contacto WHERE lida = 0");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_novas_mensagens = $row['total_novas_mensagens'];
$stmt->close();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        .btn {
            display: inline-block;
            margin: 10px 0;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-mensagens {
            display: inline-block;
            margin: 10px 0;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            position: relative;
            text-align: center;
        }

        .btn-mensagens:hover {
            background-color: #0056b3;
        }

        .btn-mensagens .notificacao {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #dc3545;
            color: white;
            font-size: 12px;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            text-align: center;
            line-height: 20px;
        }

        .logout {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #f44336;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .logout:hover {
            background-color: #d32f2f;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        ul li {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bem-vindo, Administrador <?php echo $_SESSION['user_name']; ?></h1>
        <p>Aqui pode gerir as funcionalidades do sistema.</p>
        <ul>
            <li><a class="btn" href="gerir_utilizadores.php">Gerir Utilizadores</a></li>
            <li><a class="btn" href="gerir_produtos.php">Gerir Produtos</a></li>
            <li><a class="btn" href="gerir_pedidos.php">Gerir Pedidos</a></li> 
            <li><a class="btn" href="fornecedores.php">Gerir Fornecedores</a></li>
            <li><a class="btn" href="ver_relatorios.php">Ver relatórios</a></li>
                        <li>
                <a href="mensagens.php" class="btn-mensagens">Mensagens
                    <?php if ($total_novas_mensagens > 0): ?>
                        <span class="notificacao"><?php echo $total_novas_mensagens; ?></span>
                    <?php endif; ?>
                </a>
            </li>
        </ul>
        <a class="logout" href="index.php">Sair</a>
    </div>
</body>
</html>
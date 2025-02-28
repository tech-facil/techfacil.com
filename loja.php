<?php
session_start();
include("header.php");
include("db.php");

if (isset($_GET['id_produto']) && isset($_SESSION['user_id'])) {
    $id_produto = $_GET['id_produto'];
    $id_cliente = $_SESSION['user_id'];

    $query_carrinho = "SELECT id_carrinho FROM carrinhos WHERE id_cliente = '$id_cliente' AND Status = 'ativo'";
    $result_carrinho = mysqli_query($conn, $query_carrinho);

    if (mysqli_num_rows($result_carrinho) == 0) {
        $query_novo_carrinho = "INSERT INTO carrinhos (id_cliente, data_criacao, Status) VALUES ('$id_cliente', NOW(), 'ativo')";
        if (!mysqli_query($conn, $query_novo_carrinho)) {
            echo '<script>alert("Erro ao criar carrinho.");</script>';
            exit;
        }

        $id_carrinho = mysqli_insert_id($conn);
    } else {
        $row_carrinho = mysqli_fetch_assoc($result_carrinho);
        $id_carrinho = $row_carrinho['id_carrinho'];
    }

    $query_item = "SELECT * FROM itens_carrinho WHERE id_produto = '$id_produto' AND id_carrinho = '$id_carrinho'";
    $result_item = mysqli_query($conn, $query_item);

    if (mysqli_num_rows($result_item) > 0) {
        $row_item = mysqli_fetch_assoc($result_item);
        $quantidade_atual = $row_item['quantidade'];
        $nova_quantidade = $quantidade_atual + 1;
        $query_update = "UPDATE itens_carrinho SET quantidade = '$nova_quantidade' WHERE id_produto = '$id_produto' AND id_carrinho = '$id_carrinho'";
        mysqli_query($conn, $query_update);
    } else {
        $query_add = "INSERT INTO itens_carrinho (id_produto, id_carrinho, quantidade) VALUES ('$id_produto', '$id_carrinho', 1)";
        mysqli_query($conn, $query_add);
    }

    echo '<script>window.location.href = "loja.php?added=true";</script>';
}

$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';

$query = "SELECT p.id_produto, p.nome_produto, p.descricao, p.preco, p.ImagemURL 
          FROM produtos p
          INNER JOIN categoria c ON p.id_categoria = c.id_categoria";
if (!empty($categoria)) {
    $query .= " WHERE c.nome_categoria = '" . mysqli_real_escape_string($conn, $categoria) . "'";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja - Tech Fácil</title>
    <style>
        body {
            font-family: 'Merriweather', serif;
            background-color: #d0e0e3;
            margin: 0;
            font-size: 18px;
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

        .navbar {
            background-color: #138684;
            overflow: hidden;
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 14px 20px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            border-radius: 6px;
        }

        .navbar a:hover {
            background-color: #0e5d58;
        }

        .container {
            width: 90%;
            margin: 20px auto;
        }

        .produtos {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .produto {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
            transition: transform 0.3s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .produto:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .produto img {
            width: 100%;
            height: auto;
            max-height: 120px;
            object-fit: contain;
            margin-bottom: 10px;
        }

        .produto h3 {
            font-size: 16px;
            margin: 8px 0;
            color: #333;
        }

        .produto p {
            font-size: 14px;
            color: #666;
            margin: 5px 0;
        }

        .produto .price {
            font-size: 16px;
            font-weight: bold;
            color: #138684;
            margin: 8px 0;
        }

        .produto button {
            padding: 6px 12px;
            background-color: #138684;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .produto button:hover {
            background-color: #0e5d58;
        }

        footer {
            background-color: #138684;
            color: white;
            padding: 30px;
            text-align: center;
        }

        h2 {
            font-size: 28px;
            color: white;
            text-align: center;
            background-color: #138684;
            padding: 10px 20px;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: inline-block;
            margin-bottom: 20px;
        }

        .toaster {
            visibility: hidden;
            min-width: 250px;
            margin-left: -125px;
            background-color: #4CAF50;
            color: #fff;
            text-align: center;
            border-radius: 2px;
            padding: 16px;
            position: fixed;
            z-index: 1;
            left: 50%;
            bottom: 30px;
            font-size: 17px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .toaster.show {
            visibility: visible;
            animation: fadeInOut 4s;
        }

        @keyframes fadeInOut {
            0% {bottom: 30px; opacity: 0;}
            10% {bottom: 30px; opacity: 1;}
            90% {bottom: 30px; opacity: 1;}
            100% {bottom: 30px; opacity: 0;}
        }
    </style>
    <script>
        function showToaster(message) {
            var toaster = document.getElementById("toaster");
            toaster.textContent = message;
            toaster.className = "toaster show";

            setTimeout(function() {
                toaster.className = toaster.className.replace("show", "");
            }, 4000); // 4 seconds to hide toaster
        }

        // Display toaster if product was added to cart
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('added')) {
                showToaster("Produto adicionado ao carrinho!");
            }
        };
    </script>
</head>
<body>
<br><br>

    <div class="hero">
        <h1>Loja Tech Fácil</h1>
        <p>Explore as nossas categorias e encontre os produtos ideais para facilitar o seu dia a dia.</p>
    </div>

    <div class="navbar">
        <a href="?categoria=software" <?= $categoria === 'software' ? 'style="background-color:#0e5d58;"' : '' ?>>Software</a>
        <a href="?categoria=hardware" <?= $categoria === 'hardware' ? 'style="background-color:#0e5d58;"' : '' ?>>Hardware</a>
        <a href="?categoria=kits" <?= $categoria === 'kits' ? 'style="background-color:#0e5d58;"' : '' ?>>Kits de Reparação</a>
        <a href="?categoria=variados" <?= $categoria === 'variados' ? 'style="background-color:#0e5d58;"' : '' ?>>Variados</a>
        <a href="carrinho.php" style="background-color:#0e5d58;">Carrinho</a>
    </div>

    <div class="container">
        <h2>Produtos</h2>
        <div class="produtos">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="produto">';
                    echo '<img src="' . $row['ImagemURL'] . '" alt="' . $row['nome_produto'] . '">';
                    echo '<h3>' . $row['nome_produto'] . '</h3>';
                    echo '<p>' . $row['descricao'] . '</p>';
                    echo '<p class="price">€' . number_format($row['preco'], 2, ',', '.') . '</p>';

                    if ($row['nome_produto'] === "Pen Usb Hirens Boot") {
                        echo '<a href="hirensbootcdpagina.php?id_produto=' . $row['id_produto'] . '"><button>Ver mais</button></a>';
                    } else {
                        if (isset($_SESSION['user_id'])) {
                            echo '<a href="loja.php?id_produto=' . $row['id_produto'] . '"><button>Adicionar ao carrinho</button></a>';
                        } else {
                            echo '<p><em>Faça login para adicionar ao carrinho.</em></p>';
                        }
                    }

                    echo '</div>';
                }
            } else {
                echo '<p>Nenhum produto encontrado.</p>';
            }
            ?>
        </div>
    </div>

    <div id="toaster" class="toaster"></div>

    <?php include("loginfooter.php"); ?>
</body>
</html>
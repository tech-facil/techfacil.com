<?php
session_start();
include("header.php");
include("db.php");

if (!isset($_SESSION['user_id'])) {
    echo '<script>alert("Você precisa estar logado para acessar o carrinho!");</script>';
    echo '<script>window.location.href = "loja.php";</script>';
    exit;
}

$user_id = $_SESSION['user_id'];

// Obter o id_carrinho ativo do usuário
$query_carrinho = "SELECT id_carrinho FROM carrinhos WHERE id_cliente = '$user_id' AND Status = 'ativo'";
$result_carrinho = mysqli_query($conn, $query_carrinho);
$carrinho = mysqli_fetch_assoc($result_carrinho);
$id_carrinho_ativo = $carrinho['id_carrinho'] ?? null;

if (isset($_POST['id_item'])) {
    if (isset($_POST['quantidade'])) {
        $id_item = $_POST['id_item'];
        $quantidade = $_POST['quantidade'];
        $id_detalhe = $_POST['id_detalhe'];
        if ($quantidade < 1) {
            echo '<script>alert("A quantidade deve ser pelo menos 1.");</script>';
            echo '<script>window.location.href = "carrinho.php";</script>';
            exit;
        }

        $query = "UPDATE itens_carrinho SET quantidade = '$quantidade', id_detalhe = '$id_detalhe' 
                  WHERE id_item = '$id_item' AND id_carrinho = '$id_carrinho_ativo'";
        if (!mysqli_query($conn, $query)) {
            echo '<script>alert("Erro ao atualizar a quantidade ou o detalhe.");</script>';
        } else {
            echo '<script>window.location.href = "carrinho.php?update=success";</script>';
            exit;
        }
    } elseif (isset($_POST['remover'])) {
        $id_item = $_POST['id_item'];
        $query = "DELETE FROM itens_carrinho WHERE id_item = '$id_item' AND id_carrinho = '$id_carrinho_ativo'";
        if (!mysqli_query($conn, $query)) {
            echo '<script>alert("Erro ao remover o item do carrinho.");</script>';
        } else {
            echo '<script>window.location.href = "carrinho.php?remove=success";</script>';
            exit;
        }
    }
}

$query = "SELECT i.id_item, p.nome_produto, p.preco, i.quantidade, i.id_detalhe 
          FROM itens_carrinho i
          INNER JOIN produtos p ON i.id_produto = p.id_produto
          WHERE i.id_carrinho = '$id_carrinho_ativo'";
$result = mysqli_query($conn, $query);

$total_value = 0;

if (isset($_GET['order_status'])) {
    $order_status = $_GET['order_status'];
    if ($order_status == 'success') {
        echo '<script>showToaster("Pedido finalizado com sucesso!", "success");</script>';
    } elseif ($order_status == 'error') {
        echo '<script>showToaster("Erro ao finalizar o pedido. Tente novamente.", "error");</script>';
    }
}
?>

<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho - Tech Fácil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Merriweather', serif;
            background-color: #f5f5f5;
            margin: 0;
            font-size: 18px;
            background-image: url('background.png');
            background-size: cover;
            background-attachment: fixed;
        }

        .hero {
            text-align: center;
            padding: 50px 20px;
            background-color: #138684;
            color: white;
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
            padding: 20px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .produtos {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .produto {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .produto:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
        }

        .produto h3 {
            font-size: 20px;
            margin: 8px 0;
            color: #333;
        }

        .produto p {
            font-size: 16px;
            color: #666;
            margin: 5px 0;
        }

        .produto .price {
            font-size: 18px;
            font-weight: bold;
            color: #138684;
            margin: 8px 0;
        }

        .produto form {
            margin-top: 10px;
        }

        .produto select,
        .produto input[type="number"] {
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100px;
        }

        .produto button {
            padding: 10px 20px;
            background-color: #138684;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            margin: 5px;
        }

        .produto button:hover {
            background-color: #0e5d58;
        }

        .btn-finalizar {
            margin-top: 20px;
            width: auto;
            padding: 15px 30px;
            background-color: #138684;
            color: white;
            border: none;
            font-size: 18px;
            border-radius: 8px;
            cursor: pointer;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-finalizar:hover {
            background-color: #0e5d58;
        }

        h2 {
            font-size: 28px;
            color: #138684;
            text-align: center;
            margin-bottom: 20px;
        }

        .total {
            text-align: center;
            margin-top: 20px;
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

        .toaster.error {
            background-color: #f44336;
        }

        @keyframes fadeInOut {
            0% {bottom: 30px; opacity: 0;}
            10% {bottom: 30px; opacity: 1;}
            90% {bottom: 30px; opacity: 1;}
            100% {bottom: 30px; opacity: 0;}
        }

        .payment-methods {
            margin: 20px 0;
            text-align: center;
        }

        .payment-btn {
            margin: 10px;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            color: white;
            transition: transform 0.3s, opacity 0.3s;
        }

        .payment-btn:hover {
            transform: scale(1.05);
            opacity: 0.9;
        }

        .visa-btn {
            background-color: #1a1f71;
        }

        .mastercard-btn {
            background-color: #eb001b;
        }

        .paypal-btn {
            background-color: #0070ba;
        }

        .payment-details {
            display: none;
            margin: 20px auto;
            padding: 20px;
            width: 80%;
            max-width: 400px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
        }

        .payment-details.active {
            display: block;
        }

        .payment-details h3 {
            color: #138684;
            margin-bottom: 15px;
        }

        .payment-details input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .payment-details button {
            width: 100%;
            margin-top: 15px;
        }
    </style>
    <script>
        function showToaster(message, type) {
            const toaster = document.getElementById('toaster');
            toaster.textContent = message;
            toaster.classList.add('show');
            if (type === 'error') {
                toaster.classList.add('error');
            }
            setTimeout(() => {
                toaster.classList.remove('show');
                toaster.classList.remove('error');
            }, 4000);
        }

        function showPaymentDetails(method) {
            document.querySelectorAll('.payment-details').forEach(detail => {
                detail.classList.remove('active');
            });
            document.getElementById(`${method}-details`).classList.add('active');
        }
    </script>
</head>
<body>
    <br><br>
    <div class="hero">
        <h1>Carrinho - Tech Fácil</h1>
        <p>Veja os produtos no seu carrinho e faça as alterações necessárias.</p>
    </div>

    <div class="navbar">
        <a href="loja.php">Software</a>
        <a href="loja.php">Hardware</a>
        <a href="loja.php">Kits de Reparação</a>
        <a href="loja.php">Variados</a>
        <a href="carrinho.php" style="background-color:#0e5d58;">Carrinho</a>
    </div>
    <div class="container">
        <h2>Produtos no Carrinho</h2>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="produtos">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="produto">
                        <h3><?php echo $row['nome_produto']; ?></h3>
                        <p class="price">Preço: €<?php echo number_format($row['preco'], 2, ',', '.'); ?></p>

                        <?php
                        $item_total = $row['quantidade'] * $row['preco'];
                        $total_value += $item_total;
                        ?>

                        <form action="carrinho.php" method="POST">
                            <input type="hidden" name="id_item" value="<?php echo $row['id_item']; ?>">
                            <label>Quantidade:</label>
                            <input type="number" name="quantidade" value="<?php echo $row['quantidade']; ?>" min="1">
                            <br>
                            <label for="detalhe_<?php echo $row['id_item']; ?>">Detalhe:</label>
                            <select name="id_detalhe" id="detalhe_<?php echo $row['id_item']; ?>">
                                <option value="1">Escolha um detalhe</option>
                                <?php
                                $detalhes_query = "SELECT * FROM detalhes";
                                $detalhes_result = mysqli_query($conn, $detalhes_query);
                                while ($detalhe = mysqli_fetch_assoc($detalhes_result)) {
                                    $selected = ($row['id_detalhe'] == $detalhe['id_detalhe']) ? "selected" : "";
                                    echo "<option value='{$detalhe['id_detalhe']}' $selected>{$detalhe['nome_detalhe']}</option>";
                                }
                                ?>
                            </select>
                            <br>
                            <button type="submit">Atualizar</button>
                        </form>

                        <form action="carrinho.php" method="POST">
                            <input type="hidden" name="id_item" value="<?php echo $row['id_item']; ?>">
                            <input type="hidden" name="remover" value="1">
                            <button type="submit" style="background-color: red;">Remover</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            </div>

            <div class="total">
                <h3>Total do Carrinho: €<?php echo number_format($total_value, 2, ',', '.'); ?></h3>
            </div>

            <div class="payment-methods">
                <button class="payment-btn visa-btn" onclick="showPaymentDetails('visa')">Visa</button>
                <button class="payment-btn mastercard-btn" onclick="showPaymentDetails('mastercard')">Mastercard</button>
                <button class="payment-btn paypal-btn" onclick="showPaymentDetails('paypal')">PayPal</button>
            </div>

            <div id="visa-details" class="payment-details">
                <h3>Pagamento com Visa</h3>
                <form action="fazer_pedido.php" method="POST">
                    <input type="hidden" name="payment_method" value="visa">
                    <input type="hidden" name="id_carrinho" value="<?php echo $id_carrinho_ativo; ?>">
                    <input type="text" name="card_number" placeholder="Número do Cartão" required>
                    <input type="text" name="expiry" placeholder="MM/AA" required>
                    <input type="text" name="cvv" placeholder="CVV" required>
                    <input type="text" name="card_name" placeholder="Nome no Cartão" required>
                    <button type="submit" class="btn-finalizar">Pagar com Visa</button>
                </form>
            </div>

            <div id="mastercard-details" class="payment-details">
                <h3>Pagamento com Mastercard</h3>
                <form action="fazer_pedido.php" method="POST">
                    <input type="hidden" name="payment_method" value="mastercard">
                    <input type="hidden" name="id_carrinho" value="<?php echo $id_carrinho_ativo; ?>">
                    <input type="text" name="card_number" placeholder="Número do Cartão" required>
                    <input type="text" name="expiry" placeholder="MM/AA" required>
                    <input type="text" name="cvv" placeholder="CVV" required>
                    <input type="text" name="card_name" placeholder="Nome no Cartão" required>
                    <button type="submit" class="btn-finalizar">Pagar com Mastercard</button>
                </form>
            </div>

            <div id="paypal-details" class="payment-details">
                <h3>Pagamento com PayPal</h3>
                <form action="fazer_pedido.php" method="POST">
                    <input type="hidden" name="payment_method" value="paypal">
                    <input type="hidden" name="id_carrinho" value="<?php echo $id_carrinho_ativo; ?>">
                    <input type="email" name="paypal_email" placeholder="Email do PayPal" required>
                    <input type="password" name="paypal_password" placeholder="Senha do PayPal" required>
                    <button type="submit" class="btn-finalizar">Pagar com PayPal</button>
                </form>
            </div>

        <?php else: ?>
            <p>O seu carrinho está vazio.</p>
        <?php endif; ?>
    </div>
    <br><br><br>

    <div id="toaster" class="toaster"></div>

    <?php include("loginfooter.php"); ?>
</body>
</html>
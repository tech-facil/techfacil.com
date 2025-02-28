<?php
session_start();

if (!isset($_SESSION['id_tipologin']) != 1) {
    header("Location: index.php");
    exit();
}

include("db.php");

if (!isset($_GET['id'])) {
    header("Location: gerir_pedidos.php");
    exit();
}

$id_pedido = intval($_GET['id']);

$query = "SELECT p.id_pedido, p.id_cliente, p.datapedido, p.valortotal, p.id_estadopedido, 
                 c.Nome AS nome_cliente, e.estadopedido AS estado_pedido 
          FROM pedidos p
          LEFT JOIN clientes c ON p.id_cliente = c.id_cliente
          LEFT JOIN estado_pedido e ON p.id_estadopedido = e.id_estadopedido
          WHERE p.id_pedido = $id_pedido";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    echo "<script>alert('Pedido não encontrado.'); window.location.href = 'gerir_pedidos.php';</script>";
    exit();
}

$pedido = mysqli_fetch_assoc($result);

$estado_query = "SELECT id_estadopedido, estadopedido FROM estado_pedido";
$estado_result = mysqli_query($conn, $estado_query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $estado = trim(mysqli_real_escape_string($conn, $_POST['estado']));
    
    $estado_query = "SELECT id_estadopedido FROM estado_pedido WHERE estadopedido = '$estado'";
    $estado_result = mysqli_query($conn, $estado_query);

    if (mysqli_num_rows($estado_result) > 0) {
        $estado_data = mysqli_fetch_assoc($estado_result);
        $id_estado = $estado_data['id_estadopedido'];

        $update_query = "UPDATE pedidos SET id_estadopedido = $id_estado WHERE id_pedido = $id_pedido";
        
        if (mysqli_query($conn, $update_query)) {
            echo "<script>alert('Estado do pedido atualizado com sucesso!'); window.location.href = 'gerir_pedidos.php';</script>";
        } else {
            echo "<script>alert('Erro ao atualizar o estado do pedido.');</script>";
        }
    } else {
        echo "<script>alert('Estado inválido.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Estado do Pedido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
        }

        input, select, button {
            padding: 10px;
            margin-top: 5px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        input[readonly] {
            background-color: #e9ecef;
            cursor: not-allowed;
        }

        button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            color: #007BFF;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Estado do Pedido</h1>
        <form method="POST" action="">
            <label for="cliente">Cliente:</label>
            <input type="text" id="cliente" name="cliente" value="<?php echo $pedido['nome_cliente']; ?>" readonly>

            <label for="datapedido">Data do Pedido:</label>
            <input type="text" id="datapedido" name="datapedido" value="<?php echo $pedido['datapedido']; ?>" readonly>

            <label for="valortotal">Valor Total (€):</label>
            <input type="number" step="0.01" id="valortotal" name="valortotal" value="<?php echo $pedido['valortotal']; ?>" readonly>

            <label for="estado">Estado:</label>
            <select id="estado" name="estado" required>
                <?php
                while ($estado = mysqli_fetch_assoc($estado_result)) {
                    $selected = ($pedido['estado_pedido'] == $estado['estadopedido']) ? 'selected' : '';
                    echo "<option value='" . $estado['estadopedido'] . "' $selected>" . $estado['estadopedido'] . "</option>";
                }
                ?>
            </select>

            <button type="submit">Salvar Alterações</button>
        </form>
        <a href="gerir_pedidos.php">Voltar</a>
    </div>
</body>
</html>
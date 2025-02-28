<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    echo '<script>alert("Você precisa estar logado para fazer um pedido!");</script>';
    echo '<script>window.location.href = "loja.php";</script>';
    exit;
}

$user_id = $_SESSION['user_id'];
$payment_method = $_POST['payment_method'] ?? '';
$id_carrinho = $_POST['id_carrinho'] ?? null;

// Validação dos campos de pagamento
if ($payment_method === 'visa' || $payment_method === 'mastercard') {
    if (empty($_POST['card_number']) || empty($_POST['expiry']) || empty($_POST['cvv']) || empty($_POST['card_name'])) {
        echo '<script>alert("Por favor, preencha todos os campos do cartão!");</script>';
        echo '<script>window.location.href = "carrinho.php";</script>';
        exit;
    }
    $dados_pagamento = json_encode([
        'card_number' => substr($_POST['card_number'], -4), // Armazena apenas os últimos 4 dígitos
        'expiry' => $_POST['expiry'],
        'card_name' => $_POST['card_name']
    ]);
} elseif ($payment_method === 'paypal') {
    if (empty($_POST['paypal_email']) || empty($_POST['paypal_password'])) {
        echo '<script>alert("Por favor, preencha todos os campos do PayPal!");</script>';
        echo '<script>window.location.href = "carrinho.php";</script>';
        exit;
    }
    $dados_pagamento = json_encode([
        'paypal_email' => $_POST['paypal_email']
    ]);
} else {
    echo '<script>alert("Método de pagamento inválido!");</script>';
    echo '<script>window.location.href = "carrinho.php";</script>';
    exit;
}

$query_morada = "SELECT Morada FROM clientes WHERE id_cliente = '$user_id'";
$result_morada = mysqli_query($conn, $query_morada);
if (!$result_morada || mysqli_num_rows($result_morada) == 0) {
    echo '<script>alert("Erro ao recuperar a morada do cliente.");</script>';
    exit;
}
$row_morada = mysqli_fetch_assoc($result_morada);
$endereco_entrega = $row_morada['Morada'];

$query = "SELECT i.id_item, p.preco, i.quantidade 
          FROM itens_carrinho i
          INNER JOIN produtos p ON i.id_produto = p.id_produto
          WHERE i.id_carrinho = '$id_carrinho'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo '<script>alert("Seu carrinho está vazio!");</script>';
    echo '<script>window.location.href = "loja.php";</script>';
    exit;
}

$total = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $total += $row['preco'] * $row['quantidade'];
}

$id_estadopedido = 1;
$id_detalhe = 1;
$datapedido = date("Y-m-d H:i:s");

mysqli_begin_transaction($conn);

try {
    // Inserir o pedido
    $query_pedido = "INSERT INTO pedidos (id_cliente, datapedido, valortotal, id_estadopedido, id_detalhe, metodo_pagamento) 
                     VALUES ('$user_id', '$datapedido', '$total', '$id_estadopedido', '$id_detalhe', '$payment_method')";
    if (!mysqli_query($conn, $query_pedido)) {
        throw new Exception("Erro ao registrar o pedido.");
    }
    $id_pedido = mysqli_insert_id($conn);

    // Inserir os itens do pedido
    $query_itens = "SELECT i.id_produto, i.quantidade, p.preco 
                    FROM itens_carrinho i
                    INNER JOIN produtos p ON i.id_produto = p.id_produto
                    WHERE i.id_carrinho = '$id_carrinho'";
    $result_itens = mysqli_query($conn, $query_itens);
    if (!$result_itens) {
        throw new Exception("Erro ao recuperar os itens do carrinho.");
    }

    while ($row = mysqli_fetch_assoc($result_itens)) {
        $id_produto = $row['id_produto'];
        $quantidade = $row['quantidade'];
        $preco = $row['preco'];
        $query_inserir_item = "INSERT INTO itens_pedido (id_pedido, id_produto, quantidade, preco) 
                              VALUES ('$id_pedido', '$id_produto', '$quantidade', '$preco')";
        if (!mysqli_query($conn, $query_inserir_item)) {
            throw new Exception("Erro ao adicionar itens ao pedido.");
        }
    }

    // Registrar o pagamento
    $data_pagamento = date("Y-m-d H:i:s");
    $status_pagamento = 'pendente'; // Pode ser alterado para 'concluído' após confirmação real
    $query_pagamento = "INSERT INTO pagamentos (id_carrinho, metodo_pagamento, data_pagamento, status, dados_pagamento) 
                        VALUES ('$id_carrinho', '$payment_method', '$data_pagamento', '$status_pagamento', '$dados_pagamento')";
    if (!mysqli_query($conn, $query_pagamento)) {
        throw new Exception("Erro ao registrar o pagamento.");
    }

    // Limpar o carrinho
    $query_limpar_carrinho = "DELETE FROM itens_carrinho WHERE id_carrinho = '$id_carrinho'";
    if (!mysqli_query($conn, $query_limpar_carrinho)) {
        throw new Exception("Erro ao limpar o carrinho após o pedido.");
    }

    $query_atualizar_carrinho = "UPDATE carrinhos SET Status = 'inativo' WHERE id_carrinho = '$id_carrinho'";
    if (!mysqli_query($conn, $query_atualizar_carrinho)) {
        throw new Exception("Erro ao atualizar o status do carrinho.");
    }

    $query_novo_carrinho = "INSERT INTO carrinhos (id_cliente, Status) VALUES ('$user_id', 'ativo')";
    if (!mysqli_query($conn, $query_novo_carrinho)) {
        throw new Exception("Erro ao criar novo carrinho.");
    }

    mysqli_commit($conn);

    echo '<script>alert("Pedido e pagamento registrados com sucesso!");</script>';
    echo '<script>window.location.href = "loja.php?id_pedido=' . $id_pedido . '";</script>';
    exit;

} catch (Exception $e) {
    mysqli_rollback($conn);
    echo '<script>alert("' . $e->getMessage() . '");</script>';
    echo '<script>window.location.href = "carrinho.php?order_status=error";</script>';
    exit;
}
?>
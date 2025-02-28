<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    echo '<script>alert("Você precisa estar logado para realizar esta ação.");</script>';
    echo '<script>window.location.href = "hirensbootcdpagina.php";</script>';
    exit;
}

$user_id = $_SESSION['user_id'];
$id_produto = 6;
$preco = 20.00; 

$query_produto = "SELECT * FROM produtos WHERE id_produto = '$id_produto'";
$result_produto = mysqli_query($conn, $query_produto);

if (!$result_produto || mysqli_num_rows($result_produto) == 0) {
    echo '<script>alert("Erro: O produto selecionado não existe.");</script>';
    echo '<script>window.location.href = "hirensbootcdpagina.php";</script>';
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

$datapedido = date("Y-m-d H:i:s");
$id_estadopedido = 1; 
$id_detalhe = 1;

$query_pedido = "
    INSERT INTO pedidos (id_cliente, datapedido, valortotal, id_estadopedido, id_detalhe) 
    VALUES ('$user_id', '$datapedido', '$preco', '$id_estadopedido', '$id_detalhe')
";

if (!mysqli_query($conn, $query_pedido)) {
    echo '<script>alert("Erro ao registrar o pedido.");</script>';
    exit;
}

$id_pedido = mysqli_insert_id($conn);

$query_item = "
    INSERT INTO itens_pedido (id_pedido, id_produto, quantidade, preco) 
    VALUES ('$id_pedido', '$id_produto', 1, '$preco')
";

if (!mysqli_query($conn, $query_item)) {
    echo '<script>alert("Erro ao registrar o item do pedido.");</script>';
    exit;
}

echo '<script>alert("Pedido realizado com sucesso!");</script>';
echo '<script>window.location.href = "loja.php?id_pedido=' . $id_pedido . '";</script>';
exit;
?>

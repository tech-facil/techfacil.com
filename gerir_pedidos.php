<?php
session_start();

if (!isset($_SESSION['id_tipologin']) != 1) {
    header("Location: index.php");
    exit();
}

include("db.php");

$pedidos_por_pagina = 10;
$pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_atual - 1) * $pedidos_por_pagina;

$search_cliente = isset($_GET['search_cliente']) ? $_GET['search_cliente'] : '';
$search_estado = isset($_GET['search_estado']) ? $_GET['search_estado'] : '';

$query = "SELECT p.id_pedido, p.id_cliente, p.datapedido, p.valortotal, p.id_estadopedido, p.metodo_pagamento,
                 c.Nome AS nome_cliente, c.morada,
                 e.estadopedido AS estado_pedido, d.nome_detalhe,
                 ip.id_produto, pr.nome_produto, ip.quantidade, pr.preco,
                 pag.data_pagamento, pag.status AS status_pagamento, pag.dados_pagamento
          FROM pedidos p
          LEFT JOIN clientes c ON p.id_cliente = c.id_cliente
          LEFT JOIN estado_pedido e ON p.id_estadopedido = e.id_estadopedido
          LEFT JOIN detalhes d ON p.id_detalhe = d.id_detalhe
          LEFT JOIN itens_pedido ip ON p.id_pedido = ip.id_pedido
          LEFT JOIN produtos pr ON ip.id_produto = pr.id_produto
          LEFT JOIN pagamentos pag ON pag.id_carrinho = (
              SELECT id_carrinho 
              FROM carrinhos 
              WHERE id_cliente = p.id_cliente 
              AND Status = 'inativo' 
              ORDER BY id_carrinho DESC 
              LIMIT 1
          )";

$where = [];
if (!empty($search_cliente)) {
    $search = mysqli_real_escape_string($conn, $search_cliente);
    $where[] = "c.Nome LIKE '%$search%'";
}
if (!empty($search_estado)) {
    $estado = intval($search_estado);
    $where[] = "p.id_estadopedido = $estado";
}
if (!empty($where)) {
    $query .= " WHERE " . implode(" AND ", $where);
}

$query .= " ORDER BY p.datapedido DESC";

$count_query = "SELECT COUNT(DISTINCT p.id_pedido) as total FROM pedidos p";
if (!empty($where)) {
    $count_query .= " LEFT JOIN clientes c ON p.id_cliente = c.id_cliente WHERE " . implode(" AND ", $where);
}
$count_result = mysqli_query($conn, $count_query);
$total_pedidos = mysqli_fetch_assoc($count_result)['total'];
$total_paginas = ceil($total_pedidos / $pedidos_por_pagina);

$query .= " LIMIT $offset, $pedidos_por_pagina";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerir Pedidos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .search-container {
            margin-bottom: 20px;
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .search-box {
            padding: 10px;
            width: 300px;
            border: 2px solid #007BFF;
            border-radius: 25px;
            font-size: 16px;
            outline: none;
            transition: all 0.3s ease;
        }

        .search-box:focus {
            border-color: #0056b3;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        table th {
            background-color: #007BFF;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr.cancelado {
            background-color: #f8d7da;
            color: #721c24;
        }

        .btn {
            display: inline-block;
            margin: 5px;
            padding: 8px 15px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-edit {
            background-color: #ffc107;
        }

        .btn-edit:hover {
            background-color: #e0a800;
        }

        .produtos, .pagamento {
            margin-top: 10px;
            font-size: 14px;
        }

        .produtos td, .pagamento td {
            padding: 5px;
        }

        .produtos th {
            background-color: #28a745;
            color: white;
        }

        .pagamento th {
            background-color: #17a2b8;
            color: white;
        }

        .filter-form {
            display: flex;
            gap: 10px;
        }

        select {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .pagination {
            margin-top: 20px;
            text-align: center;
        }

        .pagination a {
            padding: 8px 15px;
            margin: 0 5px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .pagination a:hover {
            background-color: #0056b3;
        }

        .pagination .disabled {
            background-color: #cccccc;
            pointer-events: none;
        }

        .pagination .active {
            background-color: #0056b3;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <a class="btn" href="pagadmin.php">Voltar</a>
        <h1>Gerir Pedidos</h1>

        <div class="search-container">
            <form method="GET" class="filter-form">
                <input type="text" name="search_cliente" class="search-box" placeholder="Pesquisar por cliente..." value="<?php echo htmlspecialchars($search_cliente); ?>">
                <button type="submit" class="btn">Pesquisar</button>
            </form>
            
            <form method="GET" class="filter-form">
                <select name="search_estado">
                    <option value="">Todos os Estados</option>
                    <option value="1" <?php echo ($search_estado == 1) ? 'selected' : ''; ?>>Aceite</option>
                    <option value="2" <?php echo ($search_estado == 2) ? 'selected' : ''; ?>>Processamento</option>
                    <option value="3" <?php echo ($search_estado == 3) ? 'selected' : ''; ?>>Enviado</option>
                    <option value="4" <?php echo ($search_estado == 4) ? 'selected' : ''; ?>>Cancelado</option>
                </select>
                <button type="submit" class="btn">Filtrar Estado</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Cliente</th>
                    <th>Morada</th>
                    <th>Data do Pedido</th>
                    <th>Valor Total</th>
                    <th>Estado</th>
                    <th>Detalhes</th>
                    <th>Produtos</th>
                    <th>Pagamento</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $pedidos_atual = [];
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        if (!isset($pedidos_atual[$row['id_pedido']])) {
                            $pedidos_atual[$row['id_pedido']] = [
                                'id_pedido' => $row['id_pedido'],
                                'nome_cliente' => $row['nome_cliente'],
                                'morada' => $row['morada'],
                                'datapedido' => $row['datapedido'],
                                'valortotal' => $row['valortotal'],
                                'estado_pedido' => $row['estado_pedido'],
                                'nome_detalhe' => $row['nome_detalhe'],
                                'metodo_pagamento' => $row['metodo_pagamento'],
                                'data_pagamento' => $row['data_pagamento'],
                                'status_pagamento' => $row['status_pagamento'],
                                'dados_pagamento' => json_decode($row['dados_pagamento'], true),
                                'produtos' => [],
                                'id_estadopedido' => $row['id_estadopedido']
                            ];
                        }

                        if ($row['id_produto']) {
                            $pedidos_atual[$row['id_pedido']]['produtos'][] = [
                                'nome_produto' => $row['nome_produto'],
                                'quantidade' => $row['quantidade'],
                                'preco' => $row['preco']
                            ];
                        }
                    }

                    foreach ($pedidos_atual as $pedido) {
                        $row_class = ($pedido['id_estadopedido'] == 4) ? 'cancelado' : '';
                        
                        echo "<tr class='$row_class'>";
                        echo "<td>" . $pedido['id_pedido'] . "</td>";
                        echo "<td>" . $pedido['nome_cliente'] . "</td>";
                        echo "<td>" . $pedido['morada'] . "</td>";
                        echo "<td>" . $pedido['datapedido'] . "</td>";
                        echo "<td>" . number_format($pedido['valortotal'], 2) . " €</td>";
                        echo "<td>" . $pedido['estado_pedido'] . "</td>";
                        echo "<td>" . $pedido['nome_detalhe'] . "</td>";

                        // Produtos
                        echo "<td class='produtos'>";
                        if (count($pedido['produtos']) > 0) {
                            echo "<table>";
                            echo "<tr><th>Produto</th><th>Quantidade</th><th>Preço</th></tr>";
                            foreach ($pedido['produtos'] as $produto) {
                                echo "<tr>";
                                echo "<td>" . $produto['nome_produto'] . "</td>";
                                echo "<td>" . $produto['quantidade'] . "</td>";
                                echo "<td>" . number_format($produto['preco'], 2) . " €</td>";
                                echo "</tr>";
                            }
                            echo "</table>";
                        } else {
                            echo "Nenhum produto associado.";
                        }
                        echo "</td>";

                        // Informações de Pagamento
                        echo "<td class='pagamento'>";
                        if ($pedido['metodo_pagamento']) {
                            echo "<table>";
                            echo "<tr><th>Método</th><td>" . ucfirst($pedido['metodo_pagamento']) . "</td></tr>";
                            echo "<tr><th>Data</th><td>" . ($pedido['data_pagamento'] ?? 'N/A') . "</td></tr>";
                            echo "<tr><th>Status</th><td>" . ($pedido['status_pagamento'] ?? 'N/A') . "</td></tr>";
                            if ($pedido['dados_pagamento']) {
                                if ($pedido['metodo_pagamento'] === 'visa' || $pedido['metodo_pagamento'] === 'mastercard') {
                                    echo "<tr><th>Cartão</th><td>****-****-****-" . ($pedido['dados_pagamento']['card_number'] ?? 'N/A') . "</td></tr>";
                                    echo "<tr><th>Validade</th><td>" . ($pedido['dados_pagamento']['expiry'] ?? 'N/A') . "</td></tr>";
                                    echo "<tr><th>Nome</th><td>" . ($pedido['dados_pagamento']['card_name'] ?? 'N/A') . "</td></tr>";
                                } elseif ($pedido['metodo_pagamento'] === 'paypal') {
                                    echo "<tr><th>Email</th><td>" . ($pedido['dados_pagamento']['paypal_email'] ?? 'N/A') . "</td></tr>";
                                }
                            }
                            echo "</table>";
                        } else {
                            echo "Nenhum pagamento registrado.";
                        }
                        echo "</td>";

                        // Ações
                        echo "<td>";
                        if ($pedido['id_estadopedido'] != 4) {
                            echo "<a class='btn btn-edit' href='editar_pedido.php?id=" . $pedido['id_pedido'] . "'>Editar</a>";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>Nenhum pedido encontrado.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="pagination">
            <?php
            $params = [];
            if (!empty($search_cliente)) $params['search_cliente'] = $search_cliente;
            if (!empty($search_estado)) $params['search_estado'] = $search_estado;
            $query_string = !empty($params) ? '&' . http_build_query($params) : '';

            if ($pagina_atual > 1) {
                echo "<a href='?pagina=" . ($pagina_atual - 1) . "$query_string'>Anterior</a>";
            } else {
                echo "<a class='disabled'>Anterior</a>";
            }

            for ($i = 1; $i <= $total_paginas; $i++) {
                $active = ($i == $pagina_atual) ? 'active' : '';
                echo "<a href='?pagina=$i$query_string' class='$active'>$i</a>";
            }

            if ($pagina_atual < $total_paginas) {
                echo "<a href='?pagina=" . ($pagina_atual + 1) . "$query_string'>Próximo</a>";
            } else {
                echo "<a class='disabled'>Próximo</a>";
            }
            ?>
        </div>
    </div>
</body>
</html>
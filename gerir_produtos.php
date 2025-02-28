<?php
session_start();

if (!isset($_SESSION['id_tipologin']) != 1) {
    header("Location: index.php");
    exit();
}

include("db.php");

// Configuração da paginação
$produtos_por_pagina = 10;
$pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_atual - 1) * $produtos_por_pagina;

// Pegar filtros de pesquisa
$search_produto = isset($_GET['search_produto']) ? $_GET['search_produto'] : '';
$search_categoria = isset($_GET['search_categoria']) ? $_GET['search_categoria'] : '';

// Query base
$query = "SELECT p.id_produto, p.nome_produto, p.quantidade, p.ImagemURL, c.nome_categoria, p.id_categoria, p.id_fornecedor, p.descricao, p.preco 
          FROM produtos p
          LEFT JOIN categoria c ON p.id_categoria = c.id_categoria";

// Aplicar filtros de pesquisa
$where = [];
if (!empty($search_produto)) {
    $search = mysqli_real_escape_string($conn, $search_produto);
    $where[] = "p.nome_produto LIKE '%$search%'";
}
if (!empty($search_categoria)) {
    $categoria = mysqli_real_escape_string($conn, $search_categoria);
    $where[] = "c.nome_categoria = '$categoria'";
}
if (!empty($where)) {
    $query .= " WHERE " . implode(" AND ", $where);
}

// Contar total de produtos para paginação
$count_query = "SELECT COUNT(p.id_produto) as total 
                FROM produtos p 
                LEFT JOIN categoria c ON p.id_categoria = c.id_categoria";
if (!empty($where)) {
    $count_query .= " WHERE " . implode(" AND ", $where);
}
$count_result = mysqli_query($conn, $count_query);
$total_produtos = mysqli_fetch_assoc($count_result)['total'];
$total_paginas = ceil($total_produtos / $produtos_por_pagina);

// Adicionar limite à query principal
$query .= " LIMIT $offset, $produtos_por_pagina";
$result = mysqli_query($conn, $query);

// Query para obter todas as categorias disponíveis
$categorias_query = "SELECT DISTINCT nome_categoria FROM categoria ORDER BY nome_categoria";
$categorias_result = mysqli_query($conn, $categorias_query);

// Lógica para remover produto
if (isset($_GET['remover'])) {
    $id_produto = intval($_GET['remover']);
    $delete_query = "DELETE FROM produtos WHERE id_produto = $id_produto";
    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Produto removido com sucesso!'); window.location.href = 'gerir_produtos.php';</script>";
    } else {
        echo "<script>alert('Erro ao remover o produto.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerir Produtos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
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
            flex-wrap: wrap;
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

        .btn-danger {
            background-color: #f44336;
        }

        .btn-danger:hover {
            background-color: #d32f2f;
        }

        .btn-add {
            background-color: #28a745;
            padding: 10px 20px;
            font-size: 16px;
        }

        .btn-add:hover {
            background-color: #218838;
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

        img {
            max-width: 50px;
            max-height: 50px;
            object-fit: cover;
        }

        select {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        .filter-form {
            display: flex;
            gap: 10px;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <a class="btn" href="pagadmin.php">Voltar</a>
            <a href="adicionar_produto.php" class="btn btn-add">Adicionar Novo Produto</a>
        </div>
        <h1>Gerir Produtos</h1>

        <div class="search-container">
            <form method="GET" class="filter-form">
                <input type="text" name="search_produto" class="search-box" placeholder="Pesquisar por produto..." value="<?php echo htmlspecialchars($search_produto); ?>">
                <button type="submit" class="btn">Pesquisar</button>
            </form>
            
            <form method="GET" class="filter-form">
                <select name="search_categoria">
                    <option value="">Todas as Categorias</option>
                    <?php
                    while ($cat = mysqli_fetch_assoc($categorias_result)) {
                        $selected = ($search_categoria == $cat['nome_categoria']) ? 'selected' : '';
                        echo "<option value='" . htmlspecialchars($cat['nome_categoria']) . "' $selected>" . htmlspecialchars($cat['nome_categoria']) . "</option>";
                    }
                    ?>
                </select>
                <button type="submit" class="btn">Filtrar Categoria</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Quantidade</th>
                    <th>Imagem</th>
                    <th>Categoria</th>
                    <th>Categoria ID</th>
                    <th>Fornecedor</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id_produto'] . "</td>";
                        echo "<td>" . $row['nome_produto'] . "</td>";
                        echo "<td>" . $row['quantidade'] . "</td>";
                        echo "<td><img src='" . $row['ImagemURL'] . "' alt='" . $row['nome_produto'] . "'></td>";
                        echo "<td>" . $row['nome_categoria'] . "</td>";
                        echo "<td>" . $row['id_categoria'] . "</td>";
                        echo "<td>" . $row['id_fornecedor'] . "</td>";
                        echo "<td>" . $row['descricao'] . "</td>";
                        echo "<td>" . number_format($row['preco'], 2) . " €</td>";
                        echo "<td>";
                        echo "<a class='btn' href='editar_produto.php?id=" . $row['id_produto'] . "'>Editar</a>";
                        echo "<a class='btn btn-danger' href='gerir_produtos.php?remover=" . $row['id_produto'] . "' onclick=\"return confirm('Tem a certeza que deseja remover este produto?')\">Remover</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>Nenhum produto encontrado.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Paginação -->
        <div class="pagination">
            <?php
            $params = [];
            if (!empty($search_produto)) $params['search_produto'] = $search_produto;
            if (!empty($search_categoria)) $params['search_categoria'] = $search_categoria;
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
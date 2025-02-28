<?php
session_start();

if (!isset($_SESSION['id_tipologin']) != 1) {
    header("Location: index.php");
    exit();
}

include("db.php");

$utilizadores_por_pagina = 10;
$pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_atual - 1) * $utilizadores_por_pagina;

$search_nome = isset($_GET['search_nome']) ? $_GET['search_nome'] : '';
$search_tipologin = isset($_GET['search_tipologin']) ? $_GET['search_tipologin'] : '';

$query = "SELECT id_cliente, Nome, Email, Morada, DataDeRegistro, id_tipologin 
          FROM clientes";

$where = [];
if (!empty($search_nome)) {
    $search = mysqli_real_escape_string($conn, $search_nome);
    $where[] = "Nome LIKE '%$search%'";
}
if (!empty($search_tipologin)) {
    $tipologin = intval($search_tipologin);
    $where[] = "id_tipologin = $tipologin";
}
if (!empty($where)) {
    $query .= " WHERE " . implode(" AND ", $where);
}

$count_query = "SELECT COUNT(id_cliente) as total FROM clientes";
if (!empty($where)) {
    $count_query .= " WHERE " . implode(" AND ", $where);
}
$count_result = mysqli_query($conn, $count_query);
$total_utilizadores = mysqli_fetch_assoc($count_result)['total'];
$total_paginas = ceil($total_utilizadores / $utilizadores_por_pagina);

$query .= " LIMIT $offset, $utilizadores_por_pagina";
$result = mysqli_query($conn, $query);

if (isset($_GET['remover'])) {
    $id_cliente = intval($_GET['remover']);
    $delete_query = "DELETE FROM clientes WHERE id_cliente = $id_cliente";
    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Utilizador removido com sucesso!'); window.location.href = 'gerir_utilizadores.php';</script>";
    } else {
        echo "<script>alert('Erro ao remover o utilizador.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerir Utilizadores</title>
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
            <a href="adicionar_utilizador.php" class="btn btn-add">Adicionar Novo Utilizador</a>
        </div>
        <h1>Gerir Utilizadores</h1>

        <div class="search-container">
            <form method="GET" class="filter-form">
                <input type="text" name="search_nome" class="search-box" placeholder="Pesquisar por nome..." value="<?php echo htmlspecialchars($search_nome); ?>">
                <button type="submit" class="btn">Pesquisar</button>
            </form>
            
            <form method="GET" class="filter-form">
                <select name="search_tipologin">
                    <option value="">Todos os Tipos</option>
                    <option value="1" <?php echo ($search_tipologin == 1) ? 'selected' : ''; ?>>Cliente</option>
                    <option value="2" <?php echo ($search_tipologin == 2) ? 'selected' : ''; ?>>Administrador</option>
                </select>
                <button type="submit" class="btn">Filtrar Tipo</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Morada</th>
                    <th>Data de Registro</th>
                    <th>Tipo Login</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id_cliente'] . "</td>";
                        echo "<td>" . $row['Nome'] . "</td>";
                        echo "<td>" . $row['Email'] . "</td>";
                        echo "<td>" . $row['Morada'] . "</td>";
                        echo "<td>" . $row['DataDeRegistro'] . "</td>";
                        echo "<td>" . ($row['id_tipologin'] == 1 ? 'Cliente' : 'Administrador') . "</td>";
                        echo "<td>";
                        echo "<a class='btn' href='editar_utilizador.php?id=" . $row['id_cliente'] . "'>Editar</a>";
                        echo "<a class='btn btn-danger' href='gerir_utilizadores.php?remover=" . $row['id_cliente'] . "' onclick=\"return confirm('Tem a certeza que deseja remover este utilizador?')\">Remover</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Nenhum utilizador encontrado.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="pagination">
            <?php
            $params = [];
            if (!empty($search_nome)) $params['search_nome'] = $search_nome;
            if (!empty($search_tipologin)) $params['search_tipologin'] = $search_tipologin;
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
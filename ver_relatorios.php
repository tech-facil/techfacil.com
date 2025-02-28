<?php
session_start();

if (!isset($_SESSION['id_tipologin']) != 1) {
    header("Location: index.php");
    exit();
}

include("db.php");

$pedidos_query = "SELECT COUNT(id_pedido) AS total_pedidos, SUM(valortotal) AS total_valores 
                  FROM pedidos 
                  WHERE id_estadopedido != 4";
$pedidos_result = mysqli_query($conn, $pedidos_query);
$pedidos_data = mysqli_fetch_assoc($pedidos_result);

$estado_query = "SELECT estadopedido, COUNT(p.id_pedido) AS total_estado, p.id_estadopedido 
                 FROM pedidos p 
                 LEFT JOIN estado_pedido e ON p.id_estadopedido = e.id_estadopedido 
                 GROUP BY e.estadopedido, p.id_estadopedido";
$estado_result = mysqli_query($conn, $estado_query);

$cliente_query = "SELECT c.Nome AS cliente, COUNT(p.id_pedido) AS total_pedidos_cliente, SUM(p.valortotal) AS total_valores_cliente 
                  FROM pedidos p 
                  LEFT JOIN clientes c ON p.id_cliente = c.id_cliente 
                  WHERE p.id_estadopedido != 4
                  GROUP BY c.Nome";
$cliente_result = mysqli_query($conn, $cliente_query);

$detalhes_query = "SELECT nome_detalhe, COUNT(id_detalhe) AS total_detalhes 
                   FROM detalhes 
                   GROUP BY nome_detalhe";
$detalhes_result = mysqli_query($conn, $detalhes_query);

$media_clientes_query = "SELECT YEAR(DataDeRegistro) AS ano, 
                                MONTH(DataDeRegistro) AS mes, 
                                COUNT(id_cliente) AS total_clientes 
                         FROM clientes 
                         GROUP BY YEAR(DataDeRegistro), MONTH(DataDeRegistro)";
$media_clientes_result = mysqli_query($conn, $media_clientes_query);

$clientes_totais_query = "SELECT COUNT(id_cliente) AS total_clientes FROM clientes";
$clientes_totais_result = mysqli_query($conn, $clientes_totais_query);
$clientes_totais = mysqli_fetch_assoc($clientes_totais_result)['total_clientes'];

$mes_maior_registo_query = "SELECT YEAR(DataDeRegistro) AS ano, MONTH(DataDeRegistro) AS mes, COUNT(id_cliente) AS total_clientes 
                            FROM clientes 
                            GROUP BY YEAR(DataDeRegistro), MONTH(DataDeRegistro) 
                            ORDER BY total_clientes DESC 
                            LIMIT 1";
$mes_maior_registo_result = mysqli_query($conn, $mes_maior_registo_query);
$mes_maior_registo = mysqli_fetch_assoc($mes_maior_registo_result);

$meses_totais = mysqli_num_rows($media_clientes_result);
$media_mensal_registos = $meses_totais > 0 ? round($clientes_totais / $meses_totais, 2) : 0;

$metodos_pagamento_query = "SELECT metodo_pagamento, COUNT(id_pagamento) AS total_metodos 
                            FROM pagamentos 
                            GROUP BY metodo_pagamento";
$metodos_pagamento_result = mysqli_query($conn, $metodos_pagamento_query);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios de Pedidos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
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

        .report-section {
            margin-bottom: 30px;
        }

        .report-section h2 {
            color: #333;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .cancelado {
            background-color: #f8d7da;
            color: #721c24;
            font-weight: bold;
        }

        .statistics {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-top: 20px;
        }

        .statistics div {
            background-color: #007BFF;
            color: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            flex: 1;
            margin: 10px;
        }

        .statistics div h3 {
            margin: 0;
            font-size: 24px;
        }

        .statistics div p {
            margin: 5px 0;
            font-size: 16px;
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

        .btn {
            display: inline-block;
            margin: 0 5px;
            padding: 5px 10px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <h1>Relatórios de Pedidos</h1>
        <a href="pagadmin.php" class="btn">Voltar</a>

        <div class="statistics">
            <div>
                <h3>Total de Pedidos<br>(Exceto Cancelados)</h3>
                <p><?php echo $pedidos_data['total_pedidos']; ?></p>
            </div>
            <div>
                <h3>Total de Valor<br>(Exceto Cancelados)</h3>
                <p>€<?php echo number_format($pedidos_data['total_valores'], 2, ',', '.'); ?></p>
            </div>
            <div>
                <h3>Média Mensal de Registros</h3>
                <p><?php echo $media_mensal_registos; ?></p>
            </div>
            <div>
                <h3>Mês com Mais Registros</h3>
                <p><?php echo $mes_maior_registo['ano'] . ' - ' . str_pad($mes_maior_registo['mes'], 2, '0', STR_PAD_LEFT); ?></p>
                <p>Total: <?php echo $mes_maior_registo['total_clientes']; ?></p>
            </div>
        </div>

        <div class="report-section">
            <h2>Pedidos por Estado</h2>
            <table>
                <thead>
                    <tr>
                        <th>Estado</th>
                        <th>Total de Pedidos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($estado = mysqli_fetch_assoc($estado_result)) {
                        $class = ($estado['id_estadopedido'] == 4) ? 'cancelado' : '';
                        echo "<tr class='$class'>
                                <td>" . $estado['estadopedido'] . "</td>
                                <td>" . $estado['total_estado'] . "</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="report-section">
            <h2>Pedidos por Cliente (Exceto Cancelados)</h2>
            <table>
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Total de Pedidos</th>
                        <th>Total de Valor (€)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($cliente = mysqli_fetch_assoc($cliente_result)) {
                        echo "<tr>
                                <td>" . $cliente['cliente'] . "</td>
                                <td>" . $cliente['total_pedidos_cliente'] . "</td>
                                <td>€" . number_format($cliente['total_valores_cliente'], 2, ',', '.') . "</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="report-section">
            <h2>Detalhes de Pedidos</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nome do Detalhe</th>
                        <th>Total de Detalhes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($detalhe = mysqli_fetch_assoc($detalhes_result)) {
                        echo "<tr>
                                <td>" . $detalhe['nome_detalhe'] . "</td>
                                <td>" . $detalhe['total_detalhes'] . "</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="report-section">
            <h2>Média de Clientes Novos por Mês</h2>
            <canvas id="clientesChart"></canvas>
            <table>
                <thead>
                    <tr>
                        <th>Ano</th>
                        <th>Mês</th>
                        <th>Total de Clientes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $anos = [];
                    $meses = [];
                    $clientes_por_mes = [];

                    while ($cliente_mes = mysqli_fetch_assoc($media_clientes_result)) {
                        $anos[] = $cliente_mes['ano'];
                        $meses[] = str_pad($cliente_mes['mes'], 2, '0', STR_PAD_LEFT); 
                        $clientes_por_mes[] = $cliente_mes['total_clientes'];
                        echo "<tr>
                                <td>" . $cliente_mes['ano'] . "</td>
                                <td>" . $cliente_mes['mes'] . "</td>
                                <td>" . $cliente_mes['total_clientes'] . "</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="report-section">
            <h2>Métodos de Pagamento</h2>
            <table>
                <thead>
                    <tr>
                        <th>Método de Pagamento</th>
                        <th>Total de Utilizações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($metodo = mysqli_fetch_assoc($metodos_pagamento_result)) {
                        echo "<tr>
                                <td>" . ($metodo['metodo_pagamento'] ? ucfirst($metodo['metodo_pagamento']) : 'Não especificado') . "</td>
                                <td>" . $metodo['total_metodos'] . "</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        var anos = <?php echo json_encode($anos); ?>;
        var meses = <?php echo json_encode($meses); ?>;
        var clientesPorMes = <?php echo json_encode($clientes_por_mes); ?>;

        var ctx = document.getElementById('clientesChart').getContext('2d');
        var clientesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: meses.map((mes, index) => anos[index] + '-' + mes), 
                datasets: [{
                    label: 'Total de Clientes Registrados',
                    data: clientesPorMes,
                    backgroundColor: 'rgba(0, 123, 255, 0.5)', 
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Ano-Mês'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Total de Clientes'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
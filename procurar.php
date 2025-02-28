<?php
session_start();
include('db.php'); 
if (!isset($_GET['query'])) {
    header('Location: index.php'); 
    exit();
}

$query = $_GET['query']; 
$query = "%" . $query . "%"; 

$sql = "
    SELECT 'produtos' AS tabela, nome_produto AS titulo, descricao AS descricao, id_produto AS id
    FROM produtos
    WHERE nome_produto LIKE ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $query);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados da Pesquisa</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Merriweather:wght@400;700&display=swap');

        body {
            margin: 0;
            font-family: 'Merriweather', serif;
            background-color: #d0e0e3;
            background-image: url('background.png');
            text-align: center;
        }

        .results-container {
            margin: 80px auto 40px;
            max-width: 1000px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .results-container h1 {
            color: #138684;
            font-size: 36px;
            margin-bottom: 20px;
        }

        .result-item {
            text-align: left;
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }

        .result-item:last-child {
            border-bottom: none;
        }

        .result-item h3 {
            font-size: 22px;
            color: #138684;
            margin: 0 0 5px;
        }

        .result-item p {
            font-size: 16px;
            color: #555;
            margin: 0 0 10px;
        }

        .result-item a {
            color: #138684;
            text-decoration: none;
            font-weight: bold;
        }

        .result-item a:hover {
            text-decoration: underline;
        }

        .no-results {
            font-size: 18px;
            color: #888;
            margin-top: 20px;
        }

        footer {
            background-color: #138684;
            color: white;
            padding: 30px;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include("header.php"); ?>
    <br><br><br><br><br><br>
    <div class="results-container">
        <h1>Resultados da Pesquisa</h1>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="result-item">
                    <h3><?php echo htmlspecialchars($row['titulo']); ?></h3>
                    <p><?php echo htmlspecialchars($row['descricao']); ?></p>
                    <a href="detalhes.php?tabela=<?php echo $row['tabela']; ?>&id=<?php echo $row['id']; ?>">Ver Mais</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="no-results">Nenhum resultado encontrado para sua pesquisa.</p>
        <?php endif; ?>
    </div>

    <?php include("loginfooter.php"); ?>
</body>
</html>
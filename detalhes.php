<?php
session_start();
include('db.php');
if (!isset($_GET['tabela']) || !isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$tabela = $_GET['tabela'];
$id = intval($_GET['id']); 

if ($tabela === 'produtos') {
    $sql = "SELECT nome_produto AS titulo, descricao, preco, quantidade, ImagemURL 
            FROM produtos 
            WHERE id_produto = ?";
} elseif ($tabela === 'fornecedores') {
    $sql = "SELECT Nome AS titulo, Email AS descricao, Telefone, Morada 
            FROM fornecedores 
            WHERE id_fornecedor = ?";
} else {
    header('Location: index.php'); 
    exit();
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: index.php'); 
    exit();
}

$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes - <?php echo htmlspecialchars($data['titulo']); ?></title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Merriweather:wght@400;700&display=swap');

        body {
            margin: 0;
            font-family: 'Merriweather', serif;
            background-color: #d0e0e3;
            background-image: url('background.png');
            text-align: center;
        }

        .details-container {
            margin: 80px auto;
            max-width: 800px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .details-container h1 {
            color: #138684;
            font-size: 36px;
            margin-bottom: 20px;
        }

        .details-container p {
            font-size: 18px;
            color: #555;
            line-height: 1.6;
            text-align: left;
        }

        .details-container img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 20px 0;
        }

        .details-container .info {
            margin-top: 20px;
            text-align: left;
        }

        .details-container .info strong {
            color: #138684;
            font-weight: bold;
        }

        .back-button {
            background-color: #138684;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            transition: transform 0.3s ease, background-color 0.3s;
        }

        .back-button:hover {
            background-color: #19b3b0;
            transform: scale(1.05);
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

    <div class="details-container">
        <h1><?php echo htmlspecialchars($data['titulo']); ?></h1>
        
        <?php if ($tabela === 'produtos' && !empty($data['ImagemURL'])): ?>
            <img src="<?php echo htmlspecialchars($data['ImagemURL']); ?>" alt="Imagem de <?php echo htmlspecialchars($data['titulo']); ?>">
        <?php endif; ?>

        <p><?php echo nl2br(htmlspecialchars($data['descricao'])); ?></p>
        <div class="info">
            <?php if ($tabela === 'produtos'): ?>
                <p><strong>Preço:</strong> €<?php echo htmlspecialchars($data['preco']); ?></p>
            <?php elseif ($tabela === 'fornecedores'): ?>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($data['descricao']); ?></p>
                <p><strong>Telefone:</strong> <?php echo htmlspecialchars($data['Telefone']); ?></p>
                <p><strong>Morada:</strong> <?php echo htmlspecialchars($data['Morada']); ?></p>
            <?php endif; ?>
        </div>
        <a href="loja.php" class="back-button">Ver na loja</a>
        <a href="javascript:history.back()" class="back-button">Voltar</a>
    </div>

    <?php include("loginfooter.php"); ?>
</body>
</html>

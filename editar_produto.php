<?php
session_start();

if (!isset($_SESSION['id_tipologin']) != 1) {
    header("Location: index.php");
    exit();
}

include("db.php");

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Erro: ID do produto não foi fornecido.";
    exit();
}

$id_produto = mysqli_real_escape_string($conn, $_GET['id']);

$query = "SELECT * FROM produtos WHERE id_produto = '$id_produto'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    echo "Erro: Produto não encontrado.";
    exit();
}

$produto = mysqli_fetch_assoc($result);

if (isset($_POST['submit'])) {
    $nome_produto = mysqli_real_escape_string($conn, $_POST['nome_produto']);
    $quantidade = mysqli_real_escape_string($conn, $_POST['quantidade']);
    $id_categoria = mysqli_real_escape_string($conn, $_POST['id_categoria']);
    $id_fornecedor = mysqli_real_escape_string($conn, $_POST['id_fornecedor']);
    $descricao = mysqli_real_escape_string($conn, $_POST['descricao']);
    $preco = mysqli_real_escape_string($conn, $_POST['preco']);

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $imagem_nome = uniqid() . '-' . basename($_FILES['imagem']['name']);

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $imagem_nome)) {
            $query = "UPDATE produtos SET 
                nome_produto = '$nome_produto',
                quantidade = '$quantidade',
                ImagemURL = '$imagem_nome',
                id_categoria = '$id_categoria',
                id_fornecedor = '$id_fornecedor',
                descricao = '$descricao',
                preco = '$preco'
                WHERE id_produto = '$id_produto'";
        } else {
            echo "Erro ao fazer upload da nova imagem.";
            exit();
        }
    } else {
        $query = "UPDATE produtos SET 
            nome_produto = '$nome_produto',
            quantidade = '$quantidade',
            id_categoria = '$id_categoria',
            id_fornecedor = '$id_fornecedor',
            descricao = '$descricao',
            preco = '$preco'
            WHERE id_produto = '$id_produto'";
    }

    if (mysqli_query($conn, $query)) {
        header("Location: gerir_produtos.php");
        exit();
    } else {
        echo "Erro ao atualizar o produto.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
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

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"], input[type="number"], textarea, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .back-btn {
            margin-top: 20px;
            display: inline-block;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Editar Produto</h1>
    <form action="editar_produto.php?id=<?php echo $id_produto; ?>" method="POST" enctype="multipart/form-data">
        <label for="nome_produto">Nome do Produto:</label>
        <input type="text" id="nome_produto" name="nome_produto" value="<?php echo $produto['nome_produto']; ?>" required>

        <label for="quantidade">Quantidade:</label>
        <input type="number" id="quantidade" name="quantidade" value="<?php echo $produto['quantidade']; ?>" required>

        <label for="imagem">Imagem do Produto:</label>
        <input type="file" id="imagem" name="imagem" accept="image/*">
        <p>Imagem atual: <?php echo $produto['ImagemURL']; ?></p>

        <label for="id_categoria">Categoria:</label>
        <select id="id_categoria" name="id_categoria" required>
            <option value="9" <?php echo $produto['id_categoria'] == 9 ? 'selected' : ''; ?>>Software</option>
            <option value="10" <?php echo $produto['id_categoria'] == 10 ? 'selected' : ''; ?>>Hardware</option>
            <option value="11" <?php echo $produto['id_categoria'] == 11 ? 'selected' : ''; ?>>Kits de Reparação</option>
            <option value="12" <?php echo $produto['id_categoria'] == 12 ? 'selected' : ''; ?>>Variados</option>
        </select>

        <label for="id_fornecedor">Fornecedor:</label>
        <input type="text" id="id_fornecedor" name="id_fornecedor" value="<?php echo $produto['id_fornecedor']; ?>" required>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" rows="4" required><?php echo $produto['descricao']; ?></textarea>

        <label for="preco">Preço:</label>
        <input type="text" id="preco" name="preco" value="<?php echo $produto['preco']; ?>" required>

        <input type="submit" name="submit" value="Atualizar Produto">
    </form>

    <a href="gerir_produtos.php" class="back-btn btn">Voltar</a>
</div>

</body>
</html>

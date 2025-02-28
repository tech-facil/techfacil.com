<?php
session_start();

if (!isset($_SESSION['id_tipologin']) != 1) {
    header("Location: index.php");
    exit();
}

include("db.php");

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
            $query = "INSERT INTO produtos (nome_produto, quantidade, ImagemURL, id_categoria, id_fornecedor, descricao, preco)
                      VALUES ('$nome_produto', '$quantidade', '$imagem_nome', '$id_categoria', '$id_fornecedor', '$descricao', '$preco')";

            if (mysqli_query($conn, $query)) {
                header("Location: gerir_produtos.php");
                exit();
            } else {
                echo "Erro ao adicionar o produto.";
            }
        } else {
            echo "Erro ao fazer upload da imagem.";
        }
    } else {
        echo "Erro: Nenhuma imagem foi enviada ou houve um erro no upload.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Produto</title>
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
        <h1>Adicionar Novo Produto</h1>
        <form action="adicionar_produto.php" method="POST" enctype="multipart/form-data">
            <label for="nome_produto">Nome do Produto:</label>
            <input type="text" id="nome_produto" name="nome_produto" required>

            <label for="quantidade">Quantidade:</label>
            <input type="number" id="quantidade" name="quantidade" required>

            <label for="imagem">Imagem do Produto:</label>
            <input type="file" id="imagem" name="imagem" accept="image/*" required>

            <label for="id_categoria">Categoria:</label>
            <select id="id_categoria" name="id_categoria" required>
                <option value="9">Software</option>
                <option value="10">Hardware</option>
                <option value="11">Kits de Reparação</option>
                <option value="12">Variados</option>
            </select>

            <label for="id_fornecedor">Fornecedor:</label>
            <input type="text" id="id_fornecedor" name="id_fornecedor" required>

            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" rows="4" required></textarea>

            <label for="preco">Preço:</label>
            <input type="text" id="preco" name="preco" required>

            <input type="submit" name="submit" value="Adicionar Produto">
        </form>

        <a href="gerir_produtos.php" class="back-btn btn">Voltar</a>
    </div>

</body>
</html>

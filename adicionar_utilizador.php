<?php
session_start();

if (!isset($_SESSION['id_tipologin ']) != 1) {
    header("Location: index.php");
    exit();
}

include("db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = mysqli_real_escape_string($conn, $_POST['Nome']);
    $email = mysqli_real_escape_string($conn, $_POST['Email']);
    $password = password_hash($_POST['Password'], PASSWORD_DEFAULT); 
    $morada = mysqli_real_escape_string($conn, $_POST['Morada']);
    $id_tipologin = intval($_POST['id_tipologin']);

    $insert_query = "
        INSERT INTO clientes (Nome, Email, Password, Morada, DataDeRegistro, id_tipologin) 
        VALUES ('$nome', '$email', '$password', '$morada', NOW(), $id_tipologin)
    ";

    if (mysqli_query($conn, $insert_query)) {
        header("Location: gerir_utilizadores.php");
        exit();
    } else {
        echo "Erro ao adicionar utilizador: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Utilizador</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
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

        form {
            margin-top: 20px;
        }

        form label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        form input, form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        form button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #0056b3;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #007BFF;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Adicionar Utilizador</h1>
        <form method="POST">
            <label for="Nome">Nome</label>
            <input type="text" name="Nome" id="Nome" required>

            <label for="Email">Email</label>
            <input type="email" name="Email" id="Email" required>

            <label for="Password">Senha</label>
            <input type="password" name="Password" id="Password" required>

            <label for="Morada">Morada</label>
            <input type="text" name="Morada" id="Morada">

            <label for="id_tipologin">Tipo de Login</label>
            <select name="id_tipologin" id="id_tipologin" required>
                <option value="1">Cliente</option>
                <option value="2">Administrador</option>
            </select>

            <button type="submit">Adicionar Utilizador</button>
        </form>
        <a class="back-link" href="gerir_utilizadores.php">Voltar</a>
    </div>
</body>
</html>

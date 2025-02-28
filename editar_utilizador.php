<?php
session_start();

if (!isset($_SESSION['id_tipologin ']) != 1) {
    header("Location: index.php");
    exit();
}

include("db.php");

if (isset($_GET['id'])) {
    $id_cliente = intval($_GET['id']);
} else {
    header("Location: gerir_utilizadores.php");
    exit();
}

$query = "SELECT * FROM clientes WHERE id_cliente = $id_cliente";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
    $utilizador = mysqli_fetch_assoc($result);
} else {
    header("Location: gerir_utilizadores.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = mysqli_real_escape_string($conn, $_POST['Nome']);
    $email = mysqli_real_escape_string($conn, $_POST['Email']);
    $morada = mysqli_real_escape_string($conn, $_POST['Morada']);
    $id_tipologin = intval($_POST['id_tipologin']);

    $update_query = "
        UPDATE clientes 
        SET Nome = '$nome', Email = '$email', Morada = '$morada', id_tipologin = $id_tipologin
        WHERE id_cliente = $id_cliente
    ";

    if (mysqli_query($conn, $update_query)) {
        header("Location: gerir_utilizadores.php");
        exit();
    } else {
        echo "Erro ao atualizar: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Utilizador</title>
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
        <h1>Editar Utilizador</h1>
        <form method="POST">
            <label for="Nome">Nome</label>
            <input type="text" name="Nome" id="Nome" value="<?= htmlspecialchars($utilizador['Nome']); ?>" required>

            <label for="Email">Email</label>
            <input type="email" name="Email" id="Email" value="<?= htmlspecialchars($utilizador['Email']); ?>" required>

            <label for="Morada">Morada</label>
            <input type="text" name="Morada" id="Morada" value="<?= htmlspecialchars($utilizador['Morada']); ?>">

            <label for="id_tipologin">Tipo de Login</label>
            <select name="id_tipologin" id="id_tipologin" required>
                <option value="1" <?= $utilizador['id_tipologin'] == 1 ? 'selected' : ''; ?>>Cliente</option>
                <option value="2" <?= $utilizador['id_tipologin'] == 2 ? 'selected' : ''; ?>>Administrador</option>
            </select>

            <button type="submit">Salvar Alterações</button>
        </form>
        <a class="back-link" href="gerir_utilizadores.php">Voltar</a>
    </div>
</body>
</html>

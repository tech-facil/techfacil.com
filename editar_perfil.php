<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT Nome, Email, Morada FROM clientes WHERE id_cliente = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $morada = $_POST['morada'];
    $senha = $_POST['senha'];

    if (!empty($senha)) {
        $hashed_password = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE clientes SET Nome = ?, Morada = ?, Password = ? WHERE id_cliente = ?");
        $stmt->bind_param("sssi", $nome, $morada, $hashed_password, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE clientes SET Nome = ?, Morada = ? WHERE id_cliente = ?");
        $stmt->bind_param("ssi", $nome, $morada, $user_id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Perfil atualizado com sucesso!'); window.location.href = 'pagcliente.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar perfil. Tente novamente.');</script>";
    }

    $stmt->close();
}
?>
<br><br><br><br>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil - Tech Fácil</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .hero {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #fff;
            padding: 20px;
        }

        .bemvindo {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }

        .hero h1 {
            font-size: 32px;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 16px;
            color: #333;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            margin-bottom: 12px;
        }

        .form-group input[readonly] {
            background-color: #e9ecef;
            cursor: not-allowed;
        }

        .btn-secondary {
            background-color: #138684;
            color: white;
            padding: 12px 30px;
            border-radius: 30px;
            text-align: center;
            text-decoration: none;
            font-size: 18px;
            cursor: pointer;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #19b3b0;
        }

        footer {
            background-color: #138684;
            color: white;
            text-align: center;
            padding: 20px;
        }

        .password-container {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .password-container label {
            display: flex;
            align-items: center;
            gap: 5px;
        }
    </style>
    <script>
        function togglePassword() {
            var senha = document.getElementById("senha");
            senha.type = senha.type === "password" ? "text" : "password";
        }
    </script>
</head>
<body>

    <?php include("header.php"); ?>
<br><br><br>
    <div class="hero">
        <div class="bemvindo">
            <h1>Editar Perfil</h1>
            <form method="POST">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($user['Nome']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['Email']); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="morada">Morada:</label>
                    <input type="text" id="morada" name="morada" value="<?php echo htmlspecialchars($user['Morada']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="senha">Nova Senha:</label>
                    <input type="password" id="senha" name="senha" placeholder="Deixe em branco para não alterar">
                    </div>
                        <input type="checkbox" onclick="togglePassword()"> Mostrar senha
                    <br><br><br>
                    <div>
                </div>
                <button type="submit" class="btn-secondary">Salvar Alterações</button>
            </form>
        </div>
    </div>

    <?php include("loginfooter.php"); ?>

</body>
</html>
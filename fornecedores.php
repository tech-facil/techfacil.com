<?php
session_start();

if (!isset($_SESSION['id_tipologin']) != 1) {
    header("Location: index.php");
    exit();
}

include("db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['adicionar'])) {
        $nome = mysqli_real_escape_string($conn, $_POST['nome']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $telefone = (int)$_POST['telefone'];
        $morada = mysqli_real_escape_string($conn, $_POST['morada']);

        $query = "INSERT INTO fornecedores (Nome, Email, Telefone, Morada) 
                  VALUES ('$nome', '$email', '$telefone', '$morada')";
        if (mysqli_query($conn, $query)) {
            $mensagem = "Fornecedor adicionado com sucesso!";
        } else {
            $mensagem = "Erro ao adicionar fornecedor: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['editar'])) {
        $id_fornecedor = (int)$_POST['id_fornecedor'];
        $nome = mysqli_real_escape_string($conn, $_POST['nome']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $telefone = (int)$_POST['telefone'];
        $morada = mysqli_real_escape_string($conn, $_POST['morada']);

        $query = "UPDATE fornecedores 
                  SET Nome = '$nome', Email = '$email', Telefone = '$telefone', Morada = '$morada' 
                  WHERE id_fornecedor = $id_fornecedor";
        if (mysqli_query($conn, $query)) {
            $mensagem = "Fornecedor atualizado com sucesso!";
        } else {
            $mensagem = "Erro ao atualizar fornecedor: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['remover'])) {
        $id_fornecedor = (int)$_POST['id_fornecedor'];
        $query = "DELETE FROM fornecedores WHERE id_fornecedor = $id_fornecedor";
        if (mysqli_query($conn, $query)) {
            $mensagem = "Fornecedor removido com sucesso!";
        } else {
            $mensagem = "Erro ao remover fornecedor: " . mysqli_error($conn);
        }
    }
}

$query = "SELECT * FROM fornecedores ORDER BY Nome ASC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Fornecedores</title>
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
            margin-bottom: 20px;
        }

        .form-section {
            margin-bottom: 30px;
        }

        .form-section h2 {
            color: #333;
            margin-bottom: 15px;
        }

        .form-section form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 400px;
        }

        .form-section input[type="text"],
        .form-section input[type="email"],
        .form-section input[type="number"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-section button {
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .form-section button:hover {
            background-color: #0056b3;
        }

        .btn-remover {
            background-color: #dc3545;
        }

        .btn-remover:hover {
            background-color: #c82333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .btn {
            display: inline-block;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .btn-editar {
            background-color: #ffc107;
            color: #333;
        }

        .btn-editar:hover {
            background-color: #e0a800;
        }

        .btn-remover {
            background-color: #dc3545;
            color: white;
        }

        .btn-remover:hover {
            background-color: #c82333;
        }

        .mensagem {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .mensagem.sucesso {
            background-color: #d4edda;
            color: #155724;
        }

        .mensagem.erro {
            background-color: #f8d7da;
            color: #721c24;
        }

        a {
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gestão de Fornecedores</h1>
        <a href="pagadmin.php" class="btn" style="background-color: #007BFF; color: white;">Voltar</a>

        <?php if (isset($mensagem)): ?>
            <div class="mensagem <?php echo strpos($mensagem, 'Erro') === false ? 'sucesso' : 'erro'; ?>">
                <?php echo $mensagem; ?>
            </div>
        <?php endif; ?>

        <div class="form-section">
            <h2>Adicionar Fornecedor</h2>
            <form method="POST">
                <input type="text" name="nome" placeholder="Nome" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="number" name="telefone" placeholder="Telefone" required>
                <input type="text" name="morada" placeholder="Morada" required>
                <button type="submit" name="adicionar">Adicionar Fornecedor</button>
            </form>
        </div>

        <h2>Lista de Fornecedores</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Morada</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($fornecedor = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $fornecedor['id_fornecedor']; ?></td>
                            <td><?php echo $fornecedor['Nome']; ?></td>
                            <td><?php echo $fornecedor['Email']; ?></td>
                            <td><?php echo $fornecedor['Telefone']; ?></td>
                            <td><?php echo $fornecedor['Morada']; ?></td>
                            <td>
                                <a href="#" class="btn btn-editar" onclick="preencherFormulario(<?php echo $fornecedor['id_fornecedor']; ?>, '<?php echo addslashes($fornecedor['Nome']); ?>', '<?php echo addslashes($fornecedor['Email']); ?>', '<?php echo $fornecedor['Telefone']; ?>', '<?php echo addslashes($fornecedor['Morada']); ?>')">Editar</a>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja remover este fornecedor?');">
                                    <input type="hidden" name="id_fornecedor" value="<?php echo $fornecedor['id_fornecedor']; ?>">
                                    <button type="submit" name="remover" class="btn btn-remover">Remover</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">Nenhum fornecedor cadastrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="form-section" id="editar-form" style="display: none;">
            <h2>Editar Fornecedor</h2>
            <form method="POST">
                <input type="hidden" name="id_fornecedor" id="edit_id_fornecedor">
                <input type="text" name="nome" id="edit_nome" required>
                <input type="email" name="email" id="edit_email" required>
                <input type="number" name="telefone" id="edit_telefone" required>
                <input type="text" name="morada" id="edit_morada" required>
                <button type="submit" name="editar">Salvar Alterações</button>
            </form>
        </div>
    </div>

    <script>
        function preencherFormulario(id, nome, email, telefone, morada) {
            document.getElementById('edit_id_fornecedor').value = id;
            document.getElementById('edit_nome').value = nome;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_telefone').value = telefone;
            document.getElementById('edit_morada').value = morada;
            document.getElementById('editar-form').style.display = 'block';
            window.scrollTo(0, document.getElementById('editar-form').offsetTop);
        }
    </script>
</body>
</html>
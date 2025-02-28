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

$stmt_pedidos = $conn->prepare("SELECT p.id_pedido, p.datapedido, p.valortotal, e.estadopedido
                                FROM pedidos p
                                JOIN estado_pedido e ON p.id_estadopedido = e.id_estadopedido
                                WHERE p.id_cliente = ?");
$stmt_pedidos->bind_param("i", $user_id);
$stmt_pedidos->execute();
$pedidos_result = $stmt_pedidos->get_result();
$stmt_pedidos->close();

if (isset($_POST['cancelar_pedido_id'])) {
    $id_pedido = $_POST['cancelar_pedido_id'];
    $cancelar_stmt = $conn->prepare("UPDATE pedidos SET id_estadopedido = 4 WHERE id_pedido = ?");
    $cancelar_stmt->bind_param("i", $id_pedido);
    $cancelar_stmt->execute();
    $cancelar_stmt->close();
    header("Location: pagcliente.php");
    exit();
}

if (isset($_POST['submit_contact'])) {
    $contact_message = $_POST['contact_message'];

    $insert_stmt = $conn->prepare("INSERT INTO mensagens_contacto (id_cliente, mensagem) VALUES (?, ?)");
    $insert_stmt->bind_param("is", $user_id, $contact_message);
    $insert_stmt->execute();
    $insert_stmt->close();

    echo "<script>window.onload = function() { showToast('Mensagem enviada com sucesso! responderemos em breve...'); }</script>";
}

$stmt_mensagens = $conn->prepare("SELECT mc.id_mensagem, mc.mensagem, mc.data_envio, rm.resposta, rm.data_resposta
                                 FROM mensagens_contacto mc
                                 LEFT JOIN respostas_mensagens rm ON mc.id_mensagem = rm.id_mensagem
                                 WHERE mc.id_cliente = ? ORDER BY mc.data_envio ASC");
$stmt_mensagens->bind_param("i", $user_id);
$stmt_mensagens->execute();
$messages = $stmt_mensagens->get_result();
$stmt_mensagens->close();

$new_messages_query = $conn->prepare("SELECT COUNT(*) FROM mensagens_contacto WHERE id_cliente = ? AND lida = 0");
$new_messages_query->bind_param("i", $user_id);
$new_messages_query->execute();
$new_messages_result = $new_messages_query->get_result();
$new_messages_count = $new_messages_result->fetch_row()[0];
$new_messages_query->close();

echo "
<script>
    function showToast(message) {
        var toast = document.createElement('div');
        toast.classList.add('toast', 'show');
        toast.textContent = message;
        document.body.appendChild(toast);
        setTimeout(function() {
            toast.classList.remove('show');
            document.body.removeChild(toast);
        }, 3000);
    }
</script>
";
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Cliente - Tech Fácil</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Open+Sans:wght@400;700&family=Lato:wght@400;700&family=Montserrat:wght@400;700&family=Poppins:wght@400;700&family=Merriweather:wght@400;700&family=Playfair+Display:wght@400;700&family=Lora:wght@400;700&family=Bitter:wght@400;700&family=Source+Serif+Pro:wght@400;700&family=Oswald:wght@400;700&family=Raleway:wght@400;700&family=Abril+Fatface&family=Pacifico&family=Dancing+Script&display=swap');
        .pedidos-section {
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 1200px;
        }

        .pedido-item {
            display: flex;
            justify-content: space-between;
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            transition: transform 0.2s ease-in-out;
        }

        .pedido-item:hover {
            transform: scale(1.02);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .pedido-item.cancelado {
            background-color: #f8d7da;
            border-left: 5px solid #dc3545;
        }

        .btn-pedido {
            padding: 10px 20px;
            background-color: #138684;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn-pedido:hover {
            background-color: #19b3b0;
        }
        body {
            margin: 0;
            font-family: 'Merriweather', serif;
            background-color: #f4f4f4;
            background-image: url('background.png');
        }

        .hero {
            text-align: center;
            padding: 80px 20px;
            position: relative;
            overflow: hidden;
            margin-top: 60px;
        }

        .bemvindo {
            background-color: white;
            padding: 40px 20px;
            border-radius: 8px;
            margin: 0 20px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }

        .hero h1 {
            font-size: 48px;
            font-weight: 700;
            margin: 0;
            animation: fadeInDown 1s ease-in-out;
        }

        .hero p {
            font-size: 20px;
            margin: 20px 0;
            animation: fadeInUp 1.5s ease-in-out;
        }

        .btn-secondary {
            background-color: #138684;
            padding: 15px 40px;
            border-radius: 30px;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: transform 0.3s ease, background-color 0.3s;
            font-family: 'Merriweather', serif;
            z-index: 0;
        }

        .btn-secondary:hover {
            background-color: #19b3b0;
            transform: scale(1.05);
        }

        footer {
            background-color: #138684;
            color: white;
            padding: 30px;
            text-align: center;
        }

        .toast {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4CAF50; 
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            font-size: 16px;
            z-index: 9999;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .toast.error {
            background-color: #f44336; 
        }

        .toast.success {
            background-color: #4CAF50; 
        }

        .toast.show {
            opacity: 1;
        }

        .contact-section {
            margin: 40px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 1200px;
        }

        .contact-section h2 {
            font-size: 30px;
            margin-bottom: 20px;
        }

        .contact-section .messages-container {
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 20px;
            padding-right: 10px;
        }

        .contact-section .messages-container .message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 8px;
            background-color: #e9f7f5;
        }

        .contact-section .messages-container .user-message {
            background-color: #cce5ff;
            text-align: right;
        }

        .contact-section .messages-container .admin-message {
            background-color: #d4edda;
            text-align: left;
        }

        .contact-section textarea {
            width: 100%;
            height: 60px;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        .contact-section button {
            padding: 12px 30px;
            background-color: #138684;
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .contact-section button:hover {
            background-color: #19b3b0;
        }
    </style>
</head>
<body>
    <?php include("header.php"); ?>

    <div class="hero">
        <div class="bemvindo">
            <h1>Bem-vindo, <?php echo htmlspecialchars($user['Nome']); ?>!</h1>
            <p>Aqui está o seu painel de cliente. Você pode ver as suas informações, seus pedidos e fazer ajustes no seu perfil.</p>
            <a href="editar_perfil.php" class="btn-secondary">Editar Perfil</a>
        </div>
    </div>
    <center>
        <div class="pedidos-section">
            <h2>Seus Pedidos</h2>
            <?php while ($pedido = $pedidos_result->fetch_assoc()) { ?>
                <div class="pedido-item <?php echo ($pedido['estadopedido'] == 'Cancelado') ? 'cancelado' : ''; ?>">
                    <div>
                        <p><strong>Data do Pedido:</strong> <?php echo htmlspecialchars($pedido['datapedido']); ?></p>
                        <p><strong>Valor Total:</strong> €<?php echo htmlspecialchars($pedido['valortotal']); ?></p>
                        <p><strong>Estado:</strong> <?php echo htmlspecialchars($pedido['estadopedido']); ?></p>
                    </div>
                    <?php if ($pedido['estadopedido'] != 'Cancelado') { ?>
                        <form method="POST" onsubmit="return confirm('Tem certeza que deseja cancelar este pedido?');">
                            <input type="hidden" name="cancelar_pedido_id" value="<?php echo $pedido['id_pedido']; ?>">
                            <button type="submit" class="btn-pedido">Cancelar Pedido</button>
                        </form>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
        <div class="contact-section">
            <h2>Entre em Contato Conosco</h2>
            <div class="messages-container">
                <?php while ($row = $messages->fetch_assoc()) { ?>
                    <div class="message user-message">
                        <strong>Você:</strong> <?php echo htmlspecialchars($row['mensagem']); ?><br>
                        <small><?php echo $row['data_envio']; ?></small>
                    </div>
                    <?php if (!empty($row['resposta'])) { ?>
                        <div class="message admin-message">
                            <strong> Suporte:</strong> <?php echo htmlspecialchars($row['resposta']); ?><br>
                            <small><?php echo $row['data_resposta']; ?></small>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>

            <form method="POST">
                <textarea name="contact_message" required placeholder="Escreva a sua mensagem aqui..."></textarea>
                <br>
                <button type="submit" name="submit_contact">Enviar Mensagem</button>
            </form>
        </div>
    </center>
    <footer>
        <p>&copy; 2025 Tech Fácil. Todos os direitos reservados.</p>
    </footer>
    <script>
        if (<?php echo $new_messages_count; ?> > 0) {
            showToast('Você tem novas mensagens!');
        }
    </script>
</body>
</html>
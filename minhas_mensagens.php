<?php
session_start();
include('db.php');
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
$user_id = $_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['contact_message'])) {
    $contact_message = $_POST['contact_message'];
    $stmt = $conn->prepare("INSERT INTO mensagens_contacto (id_cliente, mensagem, data_envio, lida) VALUES (?, ?, NOW(), 0)");
    $stmt->bind_param("is", $user_id, $contact_message);
    $stmt->execute();
    $stmt->close();
    exit();
}
$stmt = $conn->prepare("SELECT mc.id_mensagem, mc.mensagem, mc.data_envio, rm.resposta, rm.data_resposta
                        FROM mensagens_contacto mc
                        LEFT JOIN respostas_mensagens rm ON mc.id_mensagem = rm.id_mensagem
                        WHERE mc.id_cliente = ? 
                        ORDER BY mc.data_envio ASC"); 
$stmt->bind_param("i", $user_id);
$stmt->execute();
$messages = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Chat - Entre em Contato</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
        }
        .chat-box {
            width: 80%;
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            max-width: 80%;
            word-wrap: break-word;
        }
        .user-message {
            background: #d1e7dd;
            text-align: right;
        }
        .admin-message {
            background: #f8d7da;
            text-align: left;
        }
        textarea {
            width: 100%;
            height: 80px;
            margin-top: 10px;
            border-radius: 5px;
            padding: 10px;
            border: 1px solid #ccc;
        }
        button {
            padding: 10px;
            margin-top: 5px;
            background: #138684;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        #messages {
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 20px;
            padding-right: 10px;
            border-bottom: 2px solid #ddd;
        }
        #messages::-webkit-scrollbar {
            width: 10px;
        }
        #messages::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 5px;
        }
        #messages::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        .btn-back {
            padding: 10px 20px;
            background-color: #6c757d;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            display: inline-block;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="chat-box">
        <h2>Mensagens</h2>
        <div id="messages">
            <?php while ($row = $messages->fetch_assoc()) { ?>
                <div class="message user-message">
                    <strong>Você:</strong> <?php echo htmlspecialchars($row['mensagem']); ?><br>
                    <small><?php echo $row['data_envio']; ?></small>
                </div>
                <?php if ($row['resposta']) { ?>
                    <div class="message admin-message">
                        <strong>Admin:</strong> <?php echo htmlspecialchars($row['resposta']); ?><br>
                        <small><?php echo $row['data_resposta']; ?></small>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
        <form id="chat-form">
            <textarea name="contact_message" id="contact_message" required placeholder="Digite sua mensagem..."></textarea>
            <button type="submit">Enviar</button>
            <a href="pagcliente.php" class="btn-back">Voltar</a> 
        </form>
    </div>

    <script>
        document.getElementById("chat-form").addEventListener("submit", function(event) {
            event.preventDefault();
            var message = document.getElementById("contact_message").value;
            var formData = new FormData();
            formData.append("contact_message", message);

            fetch("", {
                method: "POST",
                body: formData
            }).then(response => {
                var newMessage = ` 
                    <div class='message user-message'>
                        <strong>Você:</strong> ${message}<br>
                        <small>Agora</small>
                    </div>`;
                
                document.getElementById("messages").insertAdjacentHTML('beforeend', newMessage);

                document.getElementById("messages").scrollTop = document.getElementById("messages").scrollHeight;

                document.getElementById("contact_message").value = "";
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("messages").scrollTop = document.getElementById("messages").scrollHeight;
        });
    </script>
</body>
</html>

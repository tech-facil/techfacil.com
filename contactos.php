<?php
session_start();
include('db.php');

$is_logged_in = isset($_SESSION['user_id']);
$user_id = $is_logged_in ? $_SESSION['user_id'] : null;

if ($is_logged_in) {
    $stmt_mensagens = $conn->prepare("SELECT mc.id_mensagem, mc.mensagem, mc.data_envio, rm.resposta, rm.data_resposta
                                     FROM mensagens_contacto mc
                                     LEFT JOIN respostas_mensagens rm ON mc.id_mensagem = rm.id_mensagem
                                     WHERE mc.id_cliente = ? ORDER BY mc.data_envio ASC");
    $stmt_mensagens->bind_param("i", $user_id);
    $stmt_mensagens->execute();
    $messages = $stmt_mensagens->get_result();
    $stmt_mensagens->close();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_message'])) {
        $contact_message = $_POST['contact_message'];

        $insert_stmt = $conn->prepare("INSERT INTO mensagens_contacto (id_cliente, mensagem) VALUES (?, ?)");
        $insert_stmt->bind_param("is", $user_id, $contact_message);
        $success = $insert_stmt->execute();
        $insert_stmt->close();

        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
        exit();
    }

    if (isset($_GET['user_id']) && $_GET['user_id'] == $user_id) {
        $stmt_mensagens_json = $conn->prepare("SELECT mc.id_mensagem, mc.mensagem, mc.data_envio, rm.resposta, rm.data_resposta
                                              FROM mensagens_contacto mc
                                              LEFT JOIN respostas_mensagens rm ON mc.id_mensagem = rm.id_mensagem
                                              WHERE mc.id_cliente = ? ORDER BY mc.data_envio ASC");
        $stmt_mensagens_json->bind_param("i", $user_id);
        $stmt_mensagens_json->execute();
        $messages_json = $stmt_mensagens_json->get_result();
        $stmt_mensagens_json->close();

        $result = [];
        while ($row = $messages_json->fetch_assoc()) {
            $result[] = [
                'id_mensagem' => $row['id_mensagem'],
                'mensagem' => $row['mensagem'],
                'data_envio' => $row['data_envio'],
                'resposta' => $row['resposta'],
                'data_resposta' => $row['data_resposta'],
                'is_user' => true
            ];
            if (!empty($row['resposta'])) {
                $result[] = [
                    'id_mensagem' => $row['id_mensagem'],
                    'mensagem' => $row['resposta'],
                    'data_envio' => $row['data_resposta'],
                    'resposta' => null,
                    'data_resposta' => null,
                    'is_user' => false
                ];
            }
        }

        header('Content-Type: application/json');
        echo json_encode($result);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Tech Fácil</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');

        body {
            margin: 0;
            font-family: 'Merriweather', serif;
            background-color: #f4f4f4;
            background-image: url('background.png');
        }

        .hero {
            text-align: center;
            padding: 50px 20px;
            background-color: #138684;
            color: white;
        }

        .hero h1 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .contact-container {
            width: 60%;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .contact-info, .chat-section {
            margin-bottom: 20px;
        }

        .contact-info ul {
            list-style-type: none;
            padding: 0;
            margin: 10px 0;
        }

        .contact-info li {
            margin: 10px 0;
            font-size: 16px;
        }

        .contact-info a {
            color: #007bff;
            text-decoration: none;
        }

        .chat-section {
            max-width: 100%;
        }

        .chat-section h2 {
            font-size: 28px;
            color: #138684;
            margin-bottom: 15px;
        }

        .messages-container {
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 20px;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 10px;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 8px;
        }

        .user-message {
            background-color: #cce5ff;
            text-align: right;
        }

        .admin-message {
            background-color: #d4edda;
            text-align: left;
        }

        .message small {
            font-size: 12px;
            color: #666;
        }

        .chat-input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        .btn-chat {
            background: #138684;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 30px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-chat:hover {
            background: #19b3b0;
        }

        .chat-unavailable {
            color: #dc3545;
            font-size: 18px;
            padding: 20px;
            background: #f8d7da;
            border-radius: 10px;
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

        .toast.show {
            opacity: 1;
        }

        @media (max-width: 768px) {
            .contact-container {
                width: 90%;
            }
            .hero h1 { font-size: 28px; }
            .chat-section h2 { font-size: 24px; }
        }
    </style>
</head>
<body>
    <?php include("header.php"); ?>
<br><br><br>
    <div class="hero">
        <h1>Entre em Contacto Connosco</h1>
    </div>

    <div class="contact-container">
        <div class="contact-info">
            <p>Entre em contacto connosco através dos seguintes canais:</p>
            <ul>
                <li>Email: <a href="mailto:suporte@techfacil.com">suporte@techfacil.com</a></li>
                <li>Telefone: <a href="tel:+351943345212">+351 943 345 212</a></li>
                <li>WhatsApp: <a href="https://wa.me/351943345212" target="_blank">+351 943 345 212</a></li>
            </ul>
            <p>Para mais informações, consulte a nossa <a href="politicaprivacidade.php">Política de Privacidade</a>.</p>
        </div>

        <div class="chat-section">
            <?php if ($is_logged_in) { ?>
                <h2>Chat de Suporte</h2>
                <div class="messages-container" id="messagesContainer">
                    <?php while ($row = $messages->fetch_assoc()) { ?>
                        <div class="message user-message" data-id="<?php echo htmlspecialchars($row['id_mensagem']); ?>">
                            <strong>Você:</strong> <?php echo htmlspecialchars($row['mensagem']); ?><br>
                            <small><?php echo htmlspecialchars($row['data_envio']); ?></small>
                        </div>
                        <?php if (!empty($row['resposta'])) { ?>
                            <div class="message admin-message" data-id="<?php echo htmlspecialchars($row['id_mensagem']); ?>">
                                <strong>Suporte:</strong> <?php echo htmlspecialchars($row['resposta']); ?><br>
                                <small><?php echo htmlspecialchars($row['data_resposta']); ?></small>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>

                <form id="chatForm" method="POST" onsubmit="return submitChat(event);">
                    <textarea name="contact_message" class="chat-input" required placeholder="Escreva a sua mensagem aqui..."></textarea>
                    <br>
                    <button type="submit" class="btn-chat">Enviar Mensagem</button>
                </form>
            <?php } else { ?>
                <div class="chat-unavailable">
                    O chat está indisponível. Por favor, <a href="index.php">faça login</a> para utilizar esta funcionalidade.
                </div>
            <?php } ?>
        </div>
    </div>

    <?php include("loginfooter.php"); ?>

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

        function submitChat(event) {
            event.preventDefault();
            const formData = new FormData(document.getElementById('chatForm'));
            fetch('', { 
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Mensagem enviada com sucesso! Responderemos em breve...');
                    document.querySelector('textarea[name="contact_message"]').value = '';
                    fetchMessages(); 
                } else {
                    showToast('Erro ao enviar mensagem. Tente novamente.');
                }
            })
            .catch(error => {
                showToast('Erro ao enviar mensagem. Tente novamente.');
                console.error('Error:', error);
            });
            return false;
        }

        function fetchMessages() {
            if (!<?php echo $is_logged_in ? 'true' : 'false'; ?>) return;

            fetch(`?user_id=<?php echo $user_id; ?>`, { 
                method: 'GET'
            })
            .then(response => response.json())
            .then(messages => {
                const container = document.getElementById('messagesContainer');
                container.innerHTML = '';
                messages.forEach(msg => {
                    const messageDiv = document.createElement('div');
                    messageDiv.className = `message ${msg.is_user ? 'user-message' : 'admin-message'}`;
                    messageDiv.setAttribute('data-id', msg.id_mensagem);
                    messageDiv.innerHTML = `<strong>${msg.is_user ? 'Você' : 'Suporte'}:</strong> ${msg.mensagem}<br><small>${msg.data_envio}</small>`;
                    if (!msg.is_user && msg.resposta) {
                        const responseDiv = document.createElement('div');
                        responseDiv.className = 'message admin-message';
                        responseDiv.setAttribute('data-id', msg.id_mensagem);
                        responseDiv.innerHTML = `<strong>Suporte:</strong> ${msg.resposta}<br><small>${msg.data_resposta}</small>`;
                        container.appendChild(responseDiv);
                    }
                    container.appendChild(messageDiv);
                });
                container.scrollTop = container.scrollHeight; 
            })
            .catch(error => console.error('Error fetching messages:', error));
        }

        document.addEventListener('DOMContentLoaded', fetchMessages);

        setInterval(fetchMessages, 5000);
    </script>
</body>
</html>
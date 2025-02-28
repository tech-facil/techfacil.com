<?php
session_start();
if (!isset($_SESSION['id_tipologin']) != 1) {
    header("Location: index.php");
    exit();
}
include('db.php');

if (isset($_POST['alterar_lida'])) {
    $id_cliente = $_POST['id_cliente'];
    $stmt = $conn->prepare("UPDATE mensagens_contacto SET lida = 1 WHERE id_cliente = ?");
    $stmt->bind_param("i", $id_cliente);
    $stmt->execute();
    $stmt->close();
}

if (isset($_POST['responder'])) {
    $id_mensagem = $_POST['id_mensagem'];
    $resposta = $_POST['resposta'];
    $stmt = $conn->prepare("INSERT INTO respostas_mensagens (id_mensagem, resposta, data_resposta) VALUES (?, ?, NOW())");
    $stmt->bind_param("is", $id_mensagem, $resposta);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("SELECT id_cliente FROM mensagens_contacto WHERE id_mensagem = ?");
    $stmt->bind_param("i", $id_mensagem);
    $stmt->execute();
    $stmt->bind_result($id_cliente);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("UPDATE mensagens_contacto SET lida = 1 WHERE id_cliente = ?");
    $stmt->bind_param("i", $id_cliente);
    $stmt->execute();
    $stmt->close();
}

$stmt = $conn->prepare("SELECT mc.*, c.Nome, c.Email, r.resposta, r.data_resposta, 
                        (SELECT COUNT(*) FROM mensagens_contacto WHERE id_cliente = mc.id_cliente AND lida = 0) AS novas_mensagens,
                        (SELECT MAX(data_envio) FROM mensagens_contacto WHERE id_cliente = mc.id_cliente) AS ultima_mensagem
                        FROM mensagens_contacto mc 
                        JOIN clientes c ON mc.id_cliente = c.id_cliente 
                        LEFT JOIN respostas_mensagens r ON mc.id_mensagem = r.id_mensagem 
                        ORDER BY mc.data_envio ASC");
$stmt->execute();
$result = $stmt->get_result();
$mensagens = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$clientes = [];
foreach ($mensagens as $msg) {
    $id_cliente = $msg['id_cliente'];
    if (!isset($clientes[$id_cliente])) {
        $clientes[$id_cliente] = [
            'Nome' => $msg['Nome'],
            'Email' => $msg['Email'],
            'NovasMensagens' => $msg['novas_mensagens'],
            'UltimaMensagem' => $msg['ultima_mensagem'],
            'Mensagens' => []
        ];
    }
    $clientes[$id_cliente]['Mensagens'][] = $msg;
}

usort($clientes, function($a, $b) {
    return strtotime($b['UltimaMensagem']) - strtotime($a['UltimaMensagem']);
});
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat com Clientes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 28px;
        }

        .chat-container {
            margin-bottom: 40px;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }

        .chat-container h2 {
            color: #007BFF;
            font-size: 22px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .chat-box {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            background: #fafafa;
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 15px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .mensagem, .resposta {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 10px;
            max-width: 70%;
            word-wrap: break-word;
        }

        .mensagem {
            background: #007BFF;
            color: white;
            margin-right: auto;
        }

        .resposta {
            background: #28a745;
            color: white;
            margin-left: auto;
        }

        .mensagem p, .resposta p {
            margin: 0;
        }

        .mensagem small, .resposta small {
            font-size: 12px;
            opacity: 0.8;
        }

        .input-area {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        textarea {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            resize: vertical;
            transition: border-color 0.3s ease;
        }

        textarea:focus {
            border-color: #007BFF;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }

        .btn {
            padding: 10px 20px;
            background: #007BFF;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background: #0056b3;
        }

        .btn-danger {
            background: #dc3545;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .novo {
            color: #dc3545;
            font-weight: bold;
            font-size: 14px;
            background: #ffe5e7;
            padding: 2px 8px;
            border-radius: 12px;
        }

        .email-info {
            color: #666;
            font-size: 14px;
            margin-bottom: 15px;
        }

        /* Scrollbar personalizada */
        .chat-box::-webkit-scrollbar {
            width: 8px;
        }

        .chat-box::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .chat-box::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .chat-box::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Chat com Clientes</h1>
        <a href="pagadmin.php" class="btn">Voltar</a>
        
        <?php if (empty($clientes)): ?>
            <p style="text-align: center; color: #666;">Nenhuma mensagem encontrada.</p>
        <?php else: ?>
            <?php foreach ($clientes as $id_cliente => $cliente): ?>
                <div class="chat-container">
                    <h2>
                        <?php echo htmlspecialchars($cliente['Nome']); ?>
                        <?php if ($cliente['NovasMensagens'] > 0): ?>
                            <span class="novo"><?php echo $cliente['NovasMensagens']; ?> Novo<?php echo $cliente['NovasMensagens'] > 1 ? 's' : ''; ?></span>
                        <?php endif; ?>
                    </h2>
                    <p class="email-info"><strong>Email:</strong> <?php echo htmlspecialchars($cliente['Email']); ?></p>
                    <div class="chat-box" id="chat-<?php echo $id_cliente; ?>">
                        <?php foreach ($cliente['Mensagens'] as $msg): ?>
                            <div class="mensagem">
                                <p><strong>Cliente:</strong> <?php echo htmlspecialchars($msg['mensagem']); ?></p>
                                <p><small><?php echo date('d/m/Y H:i', strtotime($msg['data_envio'])); ?></small></p>
                            </div>
                            <?php if (!empty($msg['resposta'])): ?>
                                <div class="resposta">
                                    <p><strong>Admin:</strong> <?php echo htmlspecialchars($msg['resposta']); ?></p>
                                    <p><small><?php echo date('d/m/Y H:i', strtotime($msg['data_resposta'])); ?></small></p>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <form method="post" class="input-area">
                        <input type="hidden" name="id_mensagem" value="<?php echo end($cliente['Mensagens'])['id_mensagem']; ?>">
                        <textarea name="resposta" placeholder="Digite sua resposta..." required rows="3"></textarea>
                        <button type="submit" name="responder" class="btn">Enviar</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.chat-box').forEach(function(chatBox) {
                chatBox.scrollTop = chatBox.scrollHeight;
            });
        });
    </script>
</body>
</html>
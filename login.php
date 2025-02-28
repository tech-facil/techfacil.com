<?php
session_start();
include('db.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['psw']);

    $stmt = $conn->prepare("SELECT id_cliente, Nome, Password, id_tipologin FROM clientes WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();


        if (password_verify($password, $user['Password'])) {
            $_SESSION['user_id'] = $user['id_cliente'];
            $_SESSION['user_name'] = $user['Nome'];
            $_SESSION['user_type'] = $user['id_tipologin'];

            if ($user['id_tipologin'] == 2) {
                header("Location: pagadmin.php");
            } else {
                header("Location: pagcliente.php");
            }
            exit();
        } else {
            $_SESSION['message'] = "<div class='toast error'>Credenciais inválidas. Tente novamente.</div>";
        }
    } else {
        $_SESSION['message'] = "<div class='toast error'>Credenciais inválidas. Tente novamente.</div>";
    }

    $stmt->close();
    $conn->close();

    header("Location: index.php");
    exit();
}

?>

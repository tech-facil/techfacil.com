<?php
session_start();
include('db.php');

$errorMessage = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['name']);   
    $email = trim($_POST['email']); 
    $password = $_POST['password']; 
    $morada = trim($_POST['moradap']); 
    $id_tipologin = 1;

    $stmt = $conn->prepare("SELECT id_cliente FROM clientes WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $errorMessage = "Este e-mail já está registrado. Tente com outro.";
        
        echo "<script>
            alert('$errorMessage');
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 1);
        </script>";
        exit();
    } else {
    
        $stmt->close();

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $dataRegistro = date('Y-m-d H:i:s'); 

        $stmt = $conn->prepare("INSERT INTO clientes (Nome, Email, Password, Morada, DataDeRegistro, id_tipologin) 
                                VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $nome, $email, $hashed_password, $morada, $dataRegistro, $id_tipologin);

        if ($stmt->execute()) {
            $id_cliente = $stmt->insert_id;

            $_SESSION['user_id'] = $id_cliente;
            $_SESSION['user_name'] = $nome;
            $_SESSION['user_email'] = $email;

            $stmt->close();
            $conn->close();

            header("Location: pagcliente.php"); 
            exit();
        } else {
            $errorMessage = "Erro ao registrar o utilizador. Tente novamente.";
        }
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <style>
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
    </style>
</head>
<body>

<?php if (!empty($errorMessage)): ?>
    <div class="toast error show"><?php echo $errorMessage; ?></div>
    <script>
        setTimeout(function() {
            document.querySelector('.toast').classList.remove('show');
        }, 3000);
    </script>
<?php endif; ?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        function showToast() {
            var toast = document.querySelector('.toast');
            if (toast) {
                toast.classList.add('show'); 
                setTimeout(function() {
                    toast.classList.remove('show');
                }, 3000); 
            }
        }

        showToast();
    });
</script>

</body>
</html>

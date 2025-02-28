<?php
include('db.php');
?>
<style>
.modal {
    display: none; 
    position: fixed;
    z-index: 99999; 
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); 
  }

  .modal-content {
    background-color: #ffffff;
    border-radius: 10px;
    padding: 20px;
    width: 450px;
    max-width: 90%;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    animation: animatezoom 0.6s;
  }
  .buttonpassword {
    width: 45px;
    padding: 20px;
  }
  .error-message {
    color: red;
    font-size: 14px;
  }
</style>

<center>

<!-- Login Modal -->
<div id="id01" class="modal">
  <form class="modal-content animate" action="login.php" method="post">
    <div class="container">
        <img src="Logo.png" width="200" alt="Logo">
        <br>
        <label for="uname"><b>Email</b></label>
        <input type="text" placeholder="Escreva o seu email" name="email" class="inputestilo" required>
        <br>
        <label for="psw"><b>Password</b></label>
        <input type="password" placeholder="Escreva a sua Password" name="psw" id="password" class="inputestilo" required> 
        <br>
        <input type="checkbox" id="show-password"> Mostrar a sua Password
        <br>
        <button type="submit" class="buttonstart">Login</button>
        <span class="info">Não tem conta? clique <a href="#" onclick="openRegisterModal()">aqui</a></span>
        <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Voltar</button>
    </div>
</form>
<script>
    document.getElementById('show-password').addEventListener('change', function () {
        var passwordField = document.getElementById('password'); 
        passwordField.type = this.checked ? 'text' : 'password';
    });
</script>

<!-- Registo Modal -->
<div id="register-modal" class="modal">
    <form class="modal-content animate" action="register.php" method="post" id="register-form" onsubmit="return validateRegisterForm()">
        <div class="container">
            <h2>Registar</h2>
            <br>
            <label for="name"><b>Nome</b></label>
            <input type="text" placeholder="Seu nome completo" name="name" class="inputestilo" required>
            <br>
            <label for="email"><b>Email</b></label>
            <input type="email" placeholder="Seu email" name="email" class="inputestilo" required>
            <br>
            <label for="psw"><b>Password</b></label>
            <input id="password-register" type="password" placeholder="Sua senha (mínimo 8 caracteres)" name="password" class="inputestilo" required>
            <span id="password-error" class="error-message"></span>
            <br>
            <label>
                <input type="checkbox" id="show-password-register"> Mostrar a sua Password 
            </label>
            <br>
            <label for="morada"><b>Morada</b> <span style="color: red;">(Importante para entregas)</span></label>
            <input type="text" placeholder="Sua morada" name="moradap" class="inputestilo" required>
            <br>
            <button type="submit" class="buttonstart">Registar</button>
            <button type="button" onclick="closeRegisterModal()" class="cancelbtn">Cancelar</button>
        </div>
    </form>
</div>

</center>

<script>
    function openRegisterModal() {
        document.getElementById('register-modal').style.display = 'block';
    }

    function closeRegisterModal() {
        document.getElementById('register-modal').style.display = 'none';
    }

    document.getElementById('show-password-register').addEventListener('change', function () {
        var passwordField = document.getElementById('password-register'); 
        passwordField.type = this.checked ? 'text' : 'password';
    });

    function validateRegisterForm() {
        var password = document.getElementById('password-register').value;
        var passwordError = document.getElementById('password-error');

        if (password.length < 8) {
            passwordError.textContent = "A senha deve ter pelo menos 8 caracteres.";
            return false;
        } else {
            passwordError.textContent = "";
            return true;
        }
    }
</script>

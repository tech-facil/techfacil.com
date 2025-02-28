<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
  a 
  {
    text-decoration: none;
  }
  .menu-label {
    font-size: 16px;
    color: white;
    margin-left: 10px;
    font-weight: bold;
    opacity: 0.8;
  }

  .buttonstart {
    width: 100%;
    color: white;
    padding: 12px;
    margin: 10px 0;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    background-color: #2596be;
  }
  .buttonstart:hover {
    background-color: rgba(111, 162, 242, 0.5);
  }
.searchbox {
    width: 100%;
    max-width: 300px;
    padding: 8px 16px;
    margin: 10px 0;
    font-size: 16px;
    color: #333;
    background-color: #f9f9f9; 
    border: 2px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
    transition: all 0.3s ease; 
}

.searchbox::placeholder {
    color: #aaa;
    font-style: italic;
}

.searchbox:focus {
    border-color: #4CAF50; 
    background-color: #fff;
    outline: none; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}
  .container .inputestilo {
    width: 85%;
    padding: 10px;
    margin: 10px 0;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 8px;
    transition: border-color 0.3s ease;
  }
  .container .inputestilo:focus {
    border-color: #6200ea;
    box-shadow: 0 0 8px rgba(98, 0, 234, 0.2);
  }
  .cancelbtn {
    width: 100%;
    color: white;
    padding: 12px;
    margin: 10px 0;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  .cancelbtn {
    background-color: #f44336;
    width: 95%;
  }
  .cancelbtn:hover {
    background-color: #d32f2f;
  }
  .info {
    color: black;
    size: 10px;
  }
  @media screen and (max-width: 400px) {
    .modal-content {
      width: 90%;
      z-index: 100; 
    }
  }

  .header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 20px;
    background-color: #138684;
    color: white;
    position: fixed;
    width: 100%;
    top: 0;
    z-index: 1000;
    transition: top 0.3s;
  }

  .header .logo {
    display: flex;
    align-items: center;
  }

  .header .logo img {
    width: 100px;
  }

  .menu-button {
       font-size: 20px;
       cursor: pointer;
       margin-right: 20px;
       position: relative;
       overflow: hidden;
   }
   .buttonlogin, .menu-button {
       padding-bottom: 4px;
       position: relative;
   }
   .buttonlogin::after, .menu-button::after {
       content: '';
       position: absolute;
       left: 0;
       bottom: 0;
       width: 0;
       height: 2px;
       background-color: white;
       transition: width 0.3s ease;
   }
   .buttonlogin:hover::after, .menu-button:hover::after {
       width: 100%;
   }

  .buttonlogin {
    position: relative;
    background: none;
    color: white;
    font-size: 16px;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 5px;
  }
  .buttonlogin img {
    width: 20px;
    height: 20px;
  }
  .buttonlogin::after {
    content: "";
    display: block;
    position: absolute;
    bottom: -4px;
    left: 0;
    width: 0;
    height: 2px;
    background-color: white;
    transition: width 0.3s;
  }
  .buttonlogin:hover::after {
    width: 100%;
  }

  @keyframes animatezoom {
    from {transform: scale(0)}
    to {transform: scale(1)}
    0% { opacity: 0; }
    100% { opacity: 1; }
  }
  .close-btn {
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 24px;
    cursor: pointer;
    color: white;
  }

  /* Improved Side Menu Styles */
  .side-menu {
    position: fixed;
    top: 0;
    left: 0;
    width: 250px;
    height: 100%;
    background: linear-gradient(135deg, #138684 0%, #0f5e5e 100%);
    color: white;
    padding-top: 60px;
    transform: translateX(-100%);
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 1000;
    box-shadow: 2px 0 15px rgba(0, 0, 0, 0.3);
  }

  .side-menu.open {
    transform: translateX(0);
  }

  .side-menu .close-btn {
    font-size: 28px;
    transition: transform 0.3s ease;
  }

  .side-menu .close-btn:hover {
    transform: rotate(90deg);
  }

  .side-menu .menu-header {
    text-align: center;
    padding-bottom: 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
  }

  .side-menu .menu-header img {
    width: 80px;
    transition: transform 0.3s ease;
  }

  .side-menu .menu-header img:hover {
    transform: scale(1.1);
  }

  .side-menu .menu-image {
    width: 20%;
    margin: 20px auto;
    display: block;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 8px;
  }

  .side-menu .menu-image:hover {
    transform: scale(1.1);
    box-shadow: 0px 4px 15px rgba(255, 255, 255, 0.2);
  }

  .side-menu ul {
    list-style-type: none;
    padding: 0;
  }

  .imagensmenu {
    width: 45px;
  }

  .menu-content {
    display: flex;
    flex-direction: column;
    padding: 20px;
    background: none;
  }

  .menu-item {
    display: flex;
    align-items: center;
    color: white;
    font-size: 16px;
    padding: 12px 15px;
    border-radius: 8px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }

  .menu-item img {
    width: 40px;
    height: 40px;
    margin-right: 15px;
    transition: transform 0.3s ease;
  }

  .menu-item:hover {
    background-color: rgba(255, 255, 255, 0.1);
    transform: translateX(5px);
  }

  .menu-item:hover img {
    transform: scale(1.1);
  }

  .menu-item::after {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    width: 4px;
    height: 100%;
    background-color: #fff;
    transform: translateX(-100%);
    transition: transform 0.3s ease;
  }

  .menu-item:hover::after {
    transform: translateX(0);
  }

  .contact-div {
    background: none;
    padding: 20px;
    text-align: center;
    position: absolute;
    bottom: 0;
    width: 100%;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
  }

  .contact-div span {
    color: white;
    font-weight: bold;
    display: block;
    margin-bottom: 10px;
  }

  .contact-div .contact-icon {
    display: inline-block;
    margin: 0 10px;
    color: white;
    font-size: 24px;
    cursor: pointer;
    transition: color 0.3s ease, transform 0.3s ease;
  }

  .contact-div .contact-icon:hover {
    color: #4CAF50;
    transform: scale(1.2);
  }

  .logo2 {
    width: 10px;
  }

  .menu-button {
    font-size: 20px;
    cursor: pointer;
    margin-right: 20px;
    position: relative;
    overflow: hidden;
  }

  .user-dropdown {
    position: relative;
    display: inline-block;
  }

  .user-dropdown .dropbtn {
    background: none;
    border: none;
    color: white;
    font-size: 16px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 5px;
  }

  .user-dropdown .dropbtn img {
    width: 20px;
    height: 20px;
    border-radius: 50%;
  }

  .user-dropdown .dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    background-color: #f9f9f9;
    min-width: 150px;
    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
    z-index: 1;
    border-radius: 8px;
  }

  .user-dropdown .dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    font-size: 14px;
    border-bottom: 1px solid #ddd;
  }

  .user-dropdown .dropdown-content a:hover {
    background-color: #f1f1f1;
  }

  .user-dropdown:hover .dropdown-content {
    display: block;
  }

  .user-dropdown:hover .dropbtn {
    color: #ddd;
  }
</style>
</head>
<body>

<!-- Header -->
<div class="header" id="header">
  <div class="menu-button" onclick="toggleMenu(event)">
    <i class="fas fa-bars"></i>
  </div>

  <div class="logo"><a href="index.php">
    <img src="Logo.png">
  </div></a>
  
  <form action="procurar.php" method="GET">
    <input type="text" name="query" class="searchbox" placeholder=" (Escreva o que procura...)" required>
  </form>

   <?php if (isset($_SESSION['user_name'])): ?>
    <div class="user-dropdown">
      <button class="dropbtn">
      <?php echo htmlspecialchars($_SESSION['user_name']); ?>
      </button>
      <div class="dropdown-content">
        <a href="pagcliente.php">Painel do Cliente</a>
        <a href="logout.php">Sair</a>
      </div>
    </div>
  <?php else: ?>
    <button class="buttonlogin" onclick="document.getElementById('id01').style.display='block'">
      <img src="person.png" alt="Person Icon"> Aceder à minha conta
    </button>
  <?php endif; ?>

  <a href="sobre.php">
    <button class="buttonlogin">
      Sobre nós
    </button>
  </a>
  <a href="loja.php">
  <button class="buttonlogin">
    Loja
  </button>
  </a>
  a
</div>
</div>

<div id="sideMenu" class="side-menu">
  <span class="close-btn" onclick="toggleMenu(event)">×</span>
  
  <div class="menu-header">
    <img src="logo.png" alt="Tech_Facil Logo">
  </div>
  
  <div class="menu-content">    
    <a href="index.php" class="menu-item">
      <img src="home.png" alt="Início">
      <span>Início</span>
    </a>
    <a href="tutoriais.php" class="menu-item">
      <img src="tutoriais.png" alt="tutoriais">
      <span>Tutoriais</span>
    </a>
    <a href="loja.php" class="menu-item">
      <img src="loja.png" alt="Loja">
      <span>Loja</span>
    </a>
    <a href="contactos.php" class="menu-item">
      <img src="contactos.png" alt="Contactos">
      <span>Contactos</span>
    </a>
    <a href="ferramentas.php" class="menu-item">
      <img src="ferramentas.png" alt="ferramenta">
      <span>Ferramentas</span>
    </a>
    <a href="ediçãodefotos.php" class="menu-item">
      <img src="ediçãodefotos.png" alt="Edição de Fotos">
      <span>Edição de fotos</span>
    </a>
  </div>

    <a href="politicaprivacidade.php">
      Termos e condições
    </a>
  </div>
</div>

<?php include ("modal.php"); ?>
<script>
function toggleMenu(event) {
    event.stopPropagation();
    const sideMenu = document.getElementById("sideMenu");
    sideMenu.classList.toggle("open");
}

document.addEventListener("click", function(event) {
    const sideMenu = document.getElementById("sideMenu");
    const menuButton = document.querySelector(".menu-button");
    const modal = document.getElementById("id01");

    if (!sideMenu.contains(event.target) && !menuButton.contains(event.target) && sideMenu.classList.contains("open")) {
        sideMenu.classList.remove("open");
    }

    if (event.target == modal) {
        modal.style.display = "none";
    }
});

let prevScrollpos = window.pageYOffset;
const header = document.getElementById("header");

window.onscroll = function() {
    const currentScrollPos = window.pageYOffset;
    if (prevScrollpos > currentScrollPos) {
        header.style.top = "0";
    } else {
        header.style.top = "-19%";  
    }
    prevScrollpos = currentScrollPos;
}

document.querySelector(".searchbox").addEventListener("input", function() {
    const query = this.value;

    if (query.length > 2) {
        fetch('procurar.php?query=' + encodeURIComponent(query))
            .then(response => response.json())
            .then(data => {
                console.log(data);
            })
            .catch(error => console.error("Erro ao buscar:", error));
    }
});
</script>

</body>
</html>
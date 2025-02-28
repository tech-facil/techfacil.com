<style>
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
        padding: 40px 20px;
        color: white; 
        font-family: 'Merriweather', serif;
    }

    footer .footer-container {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
    }

    .footer-section {
        flex: 1 1 calc(33% - 20px);
        min-width: 200px;
    }

    .footer-section h3 {
        font-size: 18px;
        margin-bottom: 15px;
        color: #fff; 
    }

    .footer-section ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-section ul li {
        margin-bottom: 10px;
    }

    .footer-section ul li a {
        text-decoration: none;
        color: #d1f4f3; 
        transition: color 0.3s;
    }

    .footer-section ul li a:hover {
        color: #fff; 
    }

    #cimafooter {
        color: white;
        padding: 70px 20px;
        text-align: center;
        animation: slideIn 2s ease-in-out;
        border-radius: 0;
        z-index: 0; 
        width: 500px;
    }

    #cimafooter h2 {
        font-size: 32px;
        margin-bottom: 20px;
        color: black;
        font-family: 'Merriweather', serif;
    }

    .ver
    {
        background-color:white;
    }

    @media (max-width: 600px) {
        .footer-container {
            flex-direction: column;
        }

        #cimafooter h2 {
            font-size: 24px;
        }

        .btn-secondary {
            padding: 10px 30px;
            font-size: 16px;
        }
    }
</style>

<footer>
<h3>Formas de pagamento</h3>
<ul class="payment-methods">
    <img src="paypal.png" alt="PayPal" style="height: 25px; margin-right: 10px;">
    <img src="visa.png" alt="Visa" style="height: 25px; margin-right: 10px;">
    <img src="mastercard.png" alt="Mastercard" style="height: 25px; margin-right: 10px;">
</ul>

    <div class="footer-container">
        
            

        <div class="footer-section">
            <h3>Sobre nós</h3>
            <ul>
                <li><a href="sobre.php">A nossa história</a></li>
                <li><a href="tutoriais.php">Tutoriais</a></li>
                <li><a href="contactos.php">Contato</a></li>
            </ul>
        </div>

    </div>
    <footer>
        <p>&copy; 2024, TechFácil. Todos os direitos reservados.</p>
    </footer>
    
</footer>

<script>
    function showModalAndHideFooter() {
        document.getElementById('id01').style.display = 'block'; 
    }
</script>

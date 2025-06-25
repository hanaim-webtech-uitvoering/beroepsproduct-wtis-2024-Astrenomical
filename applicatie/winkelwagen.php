<?php
session_start();
$totaal= 0;
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"  href="Css/normalize.css">
    <link rel="stylesheet" href="Css/style.css">
    <title>Winkelwagen</title>
</head>
<body>
    <header>
        <!--Groene header voor elke pagina-->
            <a href="index.php">
            <img src="images/de-nerov2.png" alt="Website Mascotte" class="logo">
            </a>
            <h1>Pizza de Nero</h1>
            <a href="login.php">
            <img src="images/Profiel-pop.png" alt="Login icoon" class="login-icoon" title="Inloggen">
        </a>
        <a href="index.php" class="menu-knop"  title="Pizza menu">
            <p>Menu</p>
        </a>
        <a href="winkelwagen.php">
            <img src="images/winkelkar.png" alt="Winkelkar icoon" class="winkelkar-icoon" title="Bekijk winkelwagen">
        </a>
    
    </header>
    <main>
    <!--Invul plaats voor het adres van de klant-->
    <div class="adres-overzicht">
        <form class="adres-info" action="#" method="POST">
            <h2>Afleveradres</h2>
    
            <label for="postcode"><strong>Postcode:</strong></label>
            <input type="text" id="postcode" name="postcode" class="adres-gegevens">
    
            <label for="street"><strong>Straat & Huisnr:</strong></label>
            <input type="text" id="street" name="street" class="adres-gegevens">
    
            <label for="province"><strong>Provincie:</strong></label>
            <input type="text" id="province" name="province" class="adres-gegevens">
    
            <label for="comments">Opmerkingen:</label>
            <textarea id="comments" name="comments" rows="3" class="adres-gegevens"></textarea>
    </form>
    <!--Overzicht van welke pizza(s) de klant heeft besteld-->
    <div class="bestelling-overzicht">
        <div class="bestelling-info">
            <h2>Bestelling</h2>
            <div class="bestel-item">
                <span>1x Pepperoni Pizza</span>
                <span>€12,50</span>
            </div>
            <div class="kosten-bestelling">
                <strong>Totaal</strong>
                <strong>€12,50</strong>
            </div>
            <button type="submit" class="plaats-bestelling">Plaats bestelling</button>
        </div>
    </div>
</div>
</main>
    <!--Footer voor elke pagina met de privacy verklaring-->
    <footer>
        <p>Reno Swart</p>
        <a href="privacy.php">Privacy verklaring</a>
      </footer>      
</body>
</html>
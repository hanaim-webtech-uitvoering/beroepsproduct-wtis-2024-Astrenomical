<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"  href="Css/normalize.css">
    <link rel="stylesheet" href="Css/style.css">
    <title>Bestellings status</title>
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
      <!--Bestel status van de pizza-->
      <div class="bestelling-status">
        <h1>Bestelling status</h1>
        <!--3 knoppen om aan te duiden wat de status is-->
        <div class="bestelling-stap">
            <div class="bestel-status active">Bestelling geplaatst</div>
            <div class="bestel-status current">Bestelling in oven</div>
            <div class="bestel-status">Bestelling onderweg</div>
        </div>

        <!--Adres van de klant-->
        <div class="adres-details">
            <h3>Aflever adres:</h3>
            <p>Noordpool laan 32</p>
            <p>7831 GG</p>
            <p>Groningen</p>
        </div>

        <!--Verwachtte bezorgings tijd-->
        <div class="bezorgings-tijd">
            <p><strong>Verwachte bezorgings tijd:</strong> 19:32</p>
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
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"  href="Css/normalize.css">
    <link rel="stylesheet" href="Css/style.css">
    <title>Pizza de nero - Login</title>
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
    <!--Login overzicht-->
<div class="login-algemeen">
    <div class="login-input">
        <h2>Login</h2>
        <form action="#" method="POST">

            <!-- Gebruikersnaam Input -->
            <div class="input-group">
                <label for="username">Gebruikersnaam</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <!-- Wachtwoord Input -->
            <div class="input-group">
                <label for="password">Wachtwoord</label>
                <input type="password" id="password" name="password" required>
            </div>

            <!-- Login knop -->
            <button type="submit">Login</button>
        </form>

        <!-- Registratie link -->
        <p>
            Nog geen lid? Meld je dan <a href="registratie.php">hier</a> aan!
        </p>
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
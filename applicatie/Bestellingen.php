<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"  href="Css/normalize.css">
    <link rel="stylesheet" href="Css/style.css">
    <title>Bestelling overzicht</title>
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
    <!--Overzicht voor personeel van de actieve en oude bestellingen-->
    <div class="personeel-ID">Personeel ID: 123456</div>

    <div class="bestellingen">

        <!--Bestellingen container(s)-->
        <div class="bestellingenv2">
            <h2>Actieve bestellingen</h2>

            <div class="bestelling-details">
                <div>
                    <p>Pizza Mozzarella x2</p>
                    <p>Pizza Pepperoni x1</p>
                    <p>Geplaatst op 26-11-24 om 17:54</p>
                    <p>Totaal: €33.00</p>
                </div>

                <!--Wijzig bestelling knop-->
                <form action="#" method="get">
                    <button type="submit" class="knop-link">Bestelling inzien</button>
                </form>

            </div>
            <div class="bestelling-details">
                <div>
                    <p>Pizza Pepperoni x1</p>
                    <p>Geplaatst op 26-11-24 om 17:32</p>
                    <p>Totaal: €12.50</p>
                </div>

                <!--Wijzig bestelling knop-->
                <form action="#" method="get">
                    <button type="submit" class="knop-link">Bestelling inzien</button>
                </form>

            </div>
        </div>

        <!--Bestellingen container(s)-->
        <div class="bestellingenv2">
            <h2>Voltooide Bestellingen</h2>
            <div class="bestelling-details">
                <div>
                    <p>Pizza Mozzarella x2</p>
                    <p>Geplaatst op 22-11-24 om 18:00</p>
                    <p>Totaal: €21.00</p>
                </div>

                <!--Wijzig bestelling knop-->
                <form action="#" method="get">
                    <button type="submit" class="knop-link">Bestelling inzien</button>
                </form>

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

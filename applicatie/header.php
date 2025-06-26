<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//Toont aantal producten in winkelwagen
$winkelwagenAantal = 0;
if (isset($_SESSION['winkelwagen'])) {
    foreach ($_SESSION['winkelwagen'] as $aantal) {
        $winkelwagenAantal += $aantal;
    }
}
?>
<header>
    <!-- Linkerzijde: logo, titel, menu -->
    <div class="header-links">
        <a href="index.php">
            <img src="images/de-nerov2.png" alt="Website Mascotte" class="logo">
        </a>
        <h1>Pizza de Nero</h1>
        <a href="index.php" class="menu-knop" title="Pizza menu">
            <p>Menu</p>
        </a>
    </div>

    <!-- Rechterzijde: bestellingen overzicht, profiel, winkelwagen -->
    <div class="header-rechts">
        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'Personnel'): ?>
            <a href="bestellingen.php" class="bestellingen-knop" title="Bestellingen overzicht">
                <p>Bestellingen overzicht</p>
            </a>
        <?php endif; ?>

        <!-- profiel dropdown -->
        <div class="profiel-dropdown">
            <a href="#" class="profiel-link">
                <img src="images/Profiel-pop.png" alt="Login icoon" class="login-icoon" title="Profiel menu">
            </a>
            <div class="dropdown-content">
                <?php if (isset($_SESSION['user'])): ?>
                    <div class="dropdown-info">
                        <p>Ingelogd als:</p>
                        <p class="gebruikersnaam"><?= htmlspecialchars($_SESSION['user']['username']) ?></p>
                    </div>
                    <hr>
                    <a href="profiel.php">Profiel bekijken</a>
                    <a href="logout.php">Uitloggen</a>
                <?php else: ?>
                    <a href="login.php">Inloggen</a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Winkelwagen -->
        <a href="winkelwagen.php" class="winkelkar-container">
            <img src="images/winkelkar.png" alt="Winkelkar icoon" class="winkelkar-icoon" title="Bekijk winkelwagen">
            <?php if ($winkelwagenAantal > 0): ?>
                <span class="winkelkar-aantal"><?= $winkelwagenAantal ?></span>
            <?php endif; ?>
        </a>
    </div>
</header>
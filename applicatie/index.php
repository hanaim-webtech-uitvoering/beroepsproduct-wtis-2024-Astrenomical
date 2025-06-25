<?php
session_start();
require_once 'data_functies.php';

$productData = haalProductenOp();

// Groepeer producten per type
$productenPerType = [];

foreach ($productData as $product) {
    $type = strtolower($product['type_id']);
    $productenPerType[$type][] = $product;
}

$typeNamen = [
    'pizza' => 'Pizza’s',
    'drank' => 'Dranken',
    'maaltijd' => 'Maaltijden',
    'voorgerecht' => 'Voorgerechten'
];

?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Css/normalize.css">
    <link rel="stylesheet" href="Css/style.css">
    <title>hoofdpagina</title>
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
        <a href="index.php" class="menu-knop" title="Pizza menu">
            <p>Menu</p>
        </a>
        <a href="winkelwagen.php">
            <img src="images/winkelkar.png" alt="Winkelkar icoon" class="winkelkar-icoon" title="Bekijk winkelwagen">
        </a>

    </header>

    <main>
        <!-- Sidebar -->
        <nav class="sidebar">
            <ul>
                <li><a href="#voorgerecht">Voorgerechten</a></li>
                <li><a href="#maaltijd">Maaltijden</a></li>
                <li><a href="#pizza">Pizza’s</a></li>
                <li><a href="#drank">Dranken</a></li>
            </ul>
        </nav>

        <!-- Pizza Secties -->
        <div class="pizza-secties"></div>
        <?php
        $weergaveVolgorde = ['voorgerecht', 'maaltijd', 'pizza', 'drank'];

        foreach ($weergaveVolgorde as $type):
            if (!isset($productenPerType[$type]))
                continue;
            $producten = $productenPerType[$type];
            ?>
            <section>
                <div id="<?= htmlspecialchars($type) ?>" class="pizza-secties">
                    <h2><?= $typeNamen[$type] ?? ucfirst($type) ?></h2>
                    <div class="pizza-grid">
                        <?php foreach ($producten as $product): ?>
                            <div class="pizza-item">
                                <img src="images/<?= strtolower(str_replace(' ', '-', $product['name'])) ?>.png"
                                    alt="<?= $product['name'] ?>" class="pizza-afbeelding">
                                <h3><?= $product['name'] ?></h3>
                                <div class="prijs-info">
                                    <span>+</span>
                                    <span>-</span>
                                    <span>€ <?= number_format($product['price'], 2, ',', '.') ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endforeach; ?>
    </main>

    <!--Footer voor elke pagina met de privacy verklaring-->
    <footer>
        <p>Reno Swart</p>
        <a href="privacy.php">Privacy verklaring</a>
    </footer>
</body>

</html>
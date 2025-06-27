<?php
session_start();
require_once 'data_functies.php';

// Producten toevoegen aan en verwijderen van winkelwagen
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actie']) && isset($_POST['product_name'])) {
    $productNaam = $_POST['product_name'];

    if (!isset($_SESSION['winkelwagen'])) {
        $_SESSION['winkelwagen'] = [];
    }

    if ($_POST['actie'] === 'toevoegen') {
        if (isset($_SESSION['winkelwagen'][$productNaam])) {
            $_SESSION['winkelwagen'][$productNaam]++;
        } else {
            $_SESSION['winkelwagen'][$productNaam] = 1;
        }
    } elseif ($_POST['actie'] === 'verwijderen') {
        if (isset($_SESSION['winkelwagen'][$productNaam])) {
            $_SESSION['winkelwagen'][$productNaam]--;
            if ($_SESSION['winkelwagen'][$productNaam] <= 0) {
                unset($_SESSION['winkelwagen'][$productNaam]);
            }
        }
    }
}

$productData = haalProductenOp();

// Groepeer producten per type
$productenPerType = [];

foreach ($productData as $product) {
    $type = strtolower($product['type_id']);
    $productenPerType[$type][] = $product;
}

$typeNamen = [
    'pizza' => 'Pizzas',
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
    <?php require_once 'header.php'; ?>
    <main>
        <!-- Sidebar -->
        <nav class="sidebar">
            <ul>
                <li><a href="#voorgerecht">Voorgerechten</a></li>
                <li><a href="#maaltijd">Maaltijden</a></li>
                <li><a href="#pizza">Pizza's</a></li>
                <li><a href="#drank">Dranken</a></li>
            </ul>
        </nav>

        <!-- Producten -->
        <div class="pizza-secties"></div>
        <?php
        $weergaveVolgorde = ['voorgerecht', 'maaltijd', 'pizza', 'drank'];

        foreach ($weergaveVolgorde as $type) {
            if (!isset($productenPerType[$type])) {
                continue;
            }
            $producten = $productenPerType[$type];
            ?>
            <section>
                <div id="<?= htmlspecialchars($type) ?>" class="pizza-secties">
                    <h2><?= $typeNamen[$type] ?? ucfirst($type) ?></h2>
                    <div class="pizza-grid">
                        <?php
                        foreach ($producten as $product) {
                            ?>
                            <div class="pizza-item">
                                <img src="images/<?= strtolower(str_replace(' ', '-', $product['name'])) ?>.png"
                                    alt="<?= $product['name'] ?>" class="pizza-afbeelding">
                                <h3><?= $product['name'] ?></h3>
                                <div class="prijs-info">
                                    <form method="post" action="index.php" class="inline-form">
                                        <input type="hidden" name="product_name"
                                            value="<?= htmlspecialchars($product['name']) ?>">
                                        <button type="submit" name="actie" value="toevoegen"
                                            class="voeg-verwijder-knop">+</button>
                                    </form>

                                    <form method="post" action="index.php" class="inline-form">
                                        <input type="hidden" name="product_name"
                                            value="<?= htmlspecialchars($product['name']) ?>">
                                        <button type="submit" name="actie" value="verwijderen"
                                            class="voeg-verwijder-knop">−</button>
                                    </form>

                                    <span>€ <?= number_format($product['price'], 2, ',', '.') ?></span>
                                </div>

                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </section>
        <?php
        }
        ?>
    </main>

    <!--Footer voor elke pagina met de privacy verklaring-->
    <footer>
        <p>Reno Swart</p>
        <a href="privacy.php">Privacy verklaring</a>
    </footer>
</body>

</html>

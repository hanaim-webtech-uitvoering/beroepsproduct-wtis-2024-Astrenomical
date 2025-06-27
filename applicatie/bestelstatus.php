<?php
session_start();
require_once 'data_functies.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Haal order_id op via GET of POST
$order_id = null;
if (isset($_GET['order_id'])) {
    $order_id = (int) $_GET['order_id'];
} elseif (isset($_POST['order_id'])) {
    $order_id = (int) $_POST['order_id'];
}

if (!$order_id) {
    echo "Geen bestelling geselecteerd.";
    exit;
}

// Haal bestelling op uit DB
$bestelling = haalBestellingOp($order_id);

if (!$bestelling) {
    echo "Bestelling niet gevonden.";
    exit;
}

// Variabelen voor bestelgegevens en besteltijd
$productlijst = $bestelling['producten'] ?? [];
$adres = $bestelling['address'] ?? 'Adres niet beschikbaar';
$bestelTijd = date('H:i', strtotime($bestelling['datetime']));

// Bepaal status van bestelling
$statusIndex = 0;
switch ($bestelling['status']) {
    case 1:
        $statusIndex = 0; // Bestelling geplaatst
        break;
    case 2:
        $statusIndex = 1; // Bestelling in oven
        break;
    case 3:
        $statusIndex = 2; // Bestelling onderweg
        break;
    default:
        $statusIndex = 0;
}
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="Css/normalize.css" />
    <link rel="stylesheet" href="Css/style.css" />
    <title>Bestelling Status</title>
</head>
<body>
    <?php require_once 'header.php'; ?>
        <main>
        <div class="bestelling-status">
            <h1>Bestelling status #<?= htmlspecialchars($bestelling['order_id']) ?></h1>

            <!-- Status stappen -->
            <div class="bestel-status <?= $statusIndex === 0 ? 'active' : 'inactive' ?>">Bestelling geplaatst</div>
            <div class="bestel-status <?= $statusIndex === 1 ? 'active' : 'inactive' ?>">Bestelling in oven</div>
            <div class="bestel-status <?= $statusIndex === 2 ? 'active' : 'inactive' ?>">Bestelling onderweg</div>

            <!-- Overzicht producten -->
            <div class="bestelling-overzicht">
                <h2>Bestelde producten</h2>
                <?php if (!empty($productlijst)) { ?>
                    <ul>
                        <?php foreach ($productlijst as $product) { ?>
                            <li><?= htmlspecialchars($product['product_name']) ?> x <?= (int) $product['quantity'] ?></li>
                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <p>Geen producten gevonden.</p>
                <?php } ?>
            </div>

            <!-- Adresgegevens -->
            <div class="adres-details">
                <h3>Afleveradres:</h3>
                <p><?= nl2br(htmlspecialchars($adres)) ?></p>
            </div>

            <!-- Besteltijd -->
            <div class="bezorgings-tijd">
                <p><strong>Besteld om:</strong> <?= htmlspecialchars($bestelTijd) ?></p>
            </div>
        </div>
    </main>

    <footer>
        <p>Reno Swart</p>
        <a href="privacy.php">Privacy verklaring</a>
    </footer>
</body>

</html>
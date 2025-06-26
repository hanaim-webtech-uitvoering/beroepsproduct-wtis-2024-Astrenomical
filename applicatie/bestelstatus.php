<?php
session_start();

// Check of er een bestelling is
if (!isset($_SESSION['laatste_bestelling'])) {
    header('Location: winkelwagen.php');
    exit;
}

 // Bestelling verstuurd via POST, sla op in sessie
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $_SESSION['laatste_bestelling'] = [
        'order_id' => $_POST['order_id'],
        'tijd' => $_POST['tijd'],
        'producten' => json_decode($_POST['producten'], true),
        'adres' => [
            'straat' => $_POST['adres'] 
        ]
    ];
}

$bestelling = $_SESSION['laatste_bestelling'];
$productlijst = $bestelling['producten'] ?? [];
$adres = $bestelling['adres'] ?? [];

$bestelTijd = $bestelling['tijd'] ?? '';
$statusIndex = 0;

//Besteltijd van nu en het moment van bestellen
if (!empty($bestelTijd)) {
    $bestelMoment = DateTime::createFromFormat('H:i', $bestelTijd);
    $nu = new DateTime();
    $verschil = $bestelMoment ? $bestelMoment->diff($nu) : null;

    if ($verschil) {
        $minuten = ($verschil->h * 60) + $verschil->i;
        if ($minuten >= 10) {
            $statusIndex = 2; // Bestelling onderweg
        } elseif ($minuten >= 5) {
            $statusIndex = 1; // In oven
        } else {
            $statusIndex = 0; // Geplaatst
        }
    }
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
            <h1>Bestelling status</h1>

            <!-- Status stappen -->
            <div class="bestel-status <?= $statusIndex === 0 ? 'active' : 'inactive' ?>">Bestelling geplaatst</div>
            <div class="bestel-status <?= $statusIndex === 1 ? 'active' : 'inactive' ?>">Bestelling in oven</div>
            <div class="bestel-status <?= $statusIndex === 2 ? 'active' : 'inactive' ?>">Bestelling onderweg</div>


            <!-- Overzicht producten -->
            <div class="bestelling-overzicht">
                <h2>Bestelde producten</h2>
                <?php if (!empty($productlijst)): ?>
                    <ul>
                        <?php foreach ($productlijst as $product => $aantal): ?>
                            <li><?= htmlspecialchars($product) ?> x <?= (int) $aantal ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>Geen producten gevonden.</p>
                <?php endif; ?>
            </div>

            <!-- Adresgegevens -->
            <div class="adres-details">
                <h3>Afleveradres:</h3>
                <p><?= htmlspecialchars($adres['straat'] ?? '-') ?></p>
                <p><?= htmlspecialchars($adres['postcode'] ?? '-') ?></p>
                <p><?= htmlspecialchars($adres['provincie'] ?? '-') ?></p>
                <?php if (!empty($adres['opmerkingen'])): ?>
                    <p><em>Opmerkingen: <?= htmlspecialchars($adres['opmerkingen']) ?></em></p>
                <?php endif; ?>
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
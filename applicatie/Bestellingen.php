<?php
session_start();

require_once 'data_functies.php';


//Controleert of ingelogd gebruiker Personnel is
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Personnel') {
    header('Location: login.php');
    exit;
}

// Update bestelling status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_order_id'], $_POST['nieuwe_status'])) {
    updateBestellingStatus((int) $_POST['update_order_id'], (int) $_POST['nieuwe_status']);
}

// Haal alle bestellingen op uit DB
$bestellingen = haalAlleBestellingenOp();
$actief = $voltooid = [];
foreach ($bestellingen as $bestelling) {
    if ($bestelling['status'] < 3) {
        $actief[] = $bestelling;
    } else {
        $voltooid[] = $bestelling;
    }
}
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Css/normalize.css">
    <link rel="stylesheet" href="Css/style.css">
    <title>Bestellingen</title>
</head>

<body>
    <?php require_once 'header.php'; ?>
    <main>
        
        <!-- Toon ingelogde medewerker -->
        <div class="personeel-info">
            Personeel: <?= htmlspecialchars($_SESSION['user']['username']) ?>
        </div>

        <div class="bestellingen-wrap">
            <section>
                <h2>Actieve bestellingen</h2>
                <?php if (empty($actief)) { ?>
                    <p>Geen actieve bestellingen.</p>
                <?php } ?>
                <?php foreach ($actief as $b) { ?>

                    <div class="bestelling-card">
                        <p><strong>Order #<?= $b['order_id'] ?></strong>, geplaatst op
                            <?= date('d-m-Y H:i', strtotime($b['datetime'])) ?></p>
                        <p><strong>Adres:</strong> <?= htmlspecialchars($b['address']) ?></p>
                        <p><strong>Personeel:</strong> <?= htmlspecialchars($b['personnel_username']) ?></p>
                        <ul>
                            <?php foreach ($b['producten'] as $p) { ?>
                                <li><?= htmlspecialchars($p['product_name']) ?> x <?= (int) $p['quantity'] ?></li>
                            <?php } ?>
                        </ul>

                        <form method="GET" action="wijzigbestelling.php">
                            <input type="hidden" name="order_id" value="<?= $b['order_id'] ?>">
                            <button type="submit" class="knop-link">Bestelling inzien</button>
                        </form>
                    </div>
                <?php } ?>
            </section>

            <section>
                <h2>Voltooide bestellingen</h2>
                <?php if (empty($voltooid)) { ?>
                    <p>Geen voltooide bestellingen.</p>
                <?php } ?>
                <?php foreach ($voltooid as $b) { ?>
                    <div class="bestelling-card voltooid">
                        <p><strong>Order #<?= $b['order_id'] ?></strong>, geplaatst op
                            <?= date('d-m-Y H:i', strtotime($b['datetime'])) ?></p>
                        <p><strong>Adres:</strong> <?= htmlspecialchars($b['address']) ?></p>
                        <p><strong>Personeel:</strong> <?= htmlspecialchars($b['personnel_username']) ?></p>
                        <ul>
                            <?php foreach ($b['producten'] as $p) { ?>
                                <li><?= htmlspecialchars($p['product_name']) ?> x <?= (int) $p['quantity'] ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
            </section>

        </div>
    </main>
</body>

</html>

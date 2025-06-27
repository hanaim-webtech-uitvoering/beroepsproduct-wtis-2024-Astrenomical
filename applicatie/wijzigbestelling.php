<?php
session_start();
require_once 'data_functies.php';


if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Personnel') {
    header('Location: login.php');
    exit;
}

// Check of er een order_id in de URL zit
if (!isset($_GET['order_id'])) {
    echo "Geen bestelling geselecteerd.";
    exit;
}

$order_id = (int) $_GET['order_id'];

// Verwerk status update via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nieuwe_status'])) {
    $nieuwe_status = (int) $_POST['nieuwe_status'];
    updateBestellingStatus($order_id, $nieuwe_status);
    header("Location: wijzigbestelling.php?order_id=$order_id");
    exit;
}

// Haal bestelling info op voor weergave
$bestelling = haalBestellingOp($order_id);
if (!$bestelling) {
    echo "Bestelling niet gevonden.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Css/normalize.css">
    <link rel="stylesheet" href="Css/style.css">
    <title>Wijzig bestellingen</title>
</head>

<body>
    <?php require_once 'header.php'; ?>
    <main>

        <!--Knoppen voor de bestel status-->
        <div class="wijziging-overzicht">
            <div class="bestel-info">
                <div class="bestel-numner">Bestelling #<?= htmlspecialchars($bestelling['order_id']) ?></div>
                <div class="status-knoppen">
                    <h2>Wat is de status van de bestelling?</h2>
                    <form method="post" action="wijzigbestelling.php?order_id=<?= $bestelling['order_id'] ?>">
                        <input type="hidden" name="order_id" value="<?= $bestelling['order_id'] ?>">
                        <button type="submit" name="nieuwe_status" value="2" class="status-knop <?= ($bestelling['status'] == 2) ? 'groen' : 'grijs' ?>">In de oven</button>
                        <button type="submit" name="nieuwe_status" value="3" class="status-knop <?= ($bestelling['status'] == 3) ? 'groen' : 'grijs' ?>">Onderweg</button>
                    </form>
                </div>

            </div>


            <!--Adres overzicht van de bestelling-->
            <div class="adres-informatie">
                <p><strong>Adres:</strong> <?= nl2br(htmlspecialchars($bestelling['address'])) ?></p>
            </div>


            <!--Overzicht van de bestelling-->
            <div class="wijziging-overzicht">
                <div class="wijziging-details">
                    <h3>Bestelling overzicht</h3>
                    <div>
                        <?php foreach ($bestelling['producten'] as $product) { ?>
                            <p><?= htmlspecialchars($product['product_name']) ?> x<?= (int) $product['quantity'] ?></p>
                        <?php } ?>
                    </div>
                    <div class="wijziging-info">
                        <div><?= date('H:i, d-m-y', strtotime($bestelling['datetime'])) ?></div>
                        <div>
                            <?php
                            require_once 'data_functies.php';
                            $alleProducten = haalProductenOp();
                            $totaal = 0;
                            foreach ($bestelling['producten'] as $p) {
                                $prijs = vindPrijs($p['product_name'], $alleProducten);
                                $totaal += $prijs * $p['quantity'];
                            }
                            echo '€' . number_format($totaal, 2, ',', '');
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!--Footer voor elke pagina met de privacy verklaring-->
    <footer>
        <p>Reno Swart</p>
        <a href="privacy.php">Privacy verklaring</a>
    </footer>

</html>
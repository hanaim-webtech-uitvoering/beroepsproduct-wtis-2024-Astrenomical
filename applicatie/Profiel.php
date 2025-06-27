<?php
session_start();
require_once 'db_connectie.php';
require_once 'data_functies.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['user']['username'];

$conn = maakVerbinding();
$stmt = $conn->prepare("SELECT first_name, last_name, address FROM [User] WHERE username = ?");
$stmt->execute([$username]);
$gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$gebruiker) {
    die("Gebruiker niet gevonden.");
}

// Bestellingen ophalen
$bestellingen = haalBestellingenOpVoorUser($username);
//Adres ophalen
$laatsteAdres = haalLaatsteBestellingAdresOp($username);
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="Css/normalize.css" />
    <link rel="stylesheet" href="Css/style.css" />
    <title>Profiel pagina</title>
</head>

<body>
    <?php require_once 'header.php'; ?>
    <main>
        <div class="profiel-overzicht">
            
            <!-- PROFIELGEGEVENS -->
            <div class="profiel-info">
                <h2>Profielgegevens</h2>
                <p><strong>Gebruikersnaam</strong></p>
                <p><?= htmlspecialchars($username) ?></p>

                <p><strong>Naam</strong></p>
                <p><?= htmlspecialchars($gebruiker['first_name'] . ' ' . $gebruiker['last_name']) ?></p>

                <p><strong>Profieladres</strong></p>
                <p><?= nl2br(htmlspecialchars($gebruiker['address'] ?? 'Niet ingevuld')) ?></p>

                <p><strong>Laatste afleveradres</strong></p>
                <p><?= nl2br(htmlspecialchars($laatsteAdres ?? 'Geen afleveradres gevonden')) ?></p>
            </div>

            <!-- BESTELLINGSGESCHIEDENIS -->
            <div class="bestel-historie">
                <h2>Bestellingen overzicht</h2>

                <?php 
                if (empty($bestellingen)) {
                    ?>
                    <p>Je hebt nog geen bestellingen geplaatst.</p>
                    <?php
                } else {
                    foreach ($bestellingen as $bestelling) {
                        ?>
                        <div class="bestelde-items">
                            <p><strong>Bestelling #<?= htmlspecialchars($bestelling['order_id']) ?></strong> - <?= htmlspecialchars($bestelling['datetime']) ?></p>
                            <p><strong>Adres:</strong> <?= nl2br(htmlspecialchars($bestelling['address'])) ?></p>
                            <p><strong>Status:</strong>
                                <?php
                                switch ($bestelling['status']) {
                                    case 1:
                                        echo 'Bestelling geplaatst';
                                        break;
                                    case 2:
                                        echo 'Bestelling in oven';
                                        break;
                                    case 3:
                                        echo 'Bestelling onderweg';
                                        break;
                                    default:
                                        echo 'Onbekend';
                                }
                                ?>
                            </p>
                            <form action="bestelstatus.php" method="post">
                                <input type="hidden" name="order_id" value="<?= htmlspecialchars($bestelling['order_id']) ?>">
                                <button type="submit" class="status-knop">Bekijk bestelstatus</button>
                            </form>

                            <ul>
                                <?php
                                foreach ($bestelling['producten'] as $product) {
                                    ?>
                                    <li><?= htmlspecialchars($product['product_name']) ?> x <?= (int) $product['quantity'] ?></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </main>

    <footer>
        <p>Reno Swart</p>
        <a href="privacy.php">Privacy verklaring</a>
    </footer>
</body>

</html>
<?php
session_start();
require_once 'db_connectie.php';
require_once 'data_functies.php';
require_once 'header.php';


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

                <?php if (empty($bestellingen)): ?>
                    <p>Je hebt nog geen bestellingen geplaatst.</p>
                <?php else: ?>
                    <?php foreach ($bestellingen as $bestelling): ?>
                        <div class="bestelde-items">
                            <p><strong>Bestelling #<?= htmlspecialchars($bestelling['order_id']) ?></strong> -
                                <?= htmlspecialchars($bestelling['datetime']) ?>
                            </p>
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
                            <?php
                            // Bereken tijdsverschil in minuten
                            $bestelMoment = new DateTime($bestelling['datetime']);
                            $nu = new DateTime();
                            $verschil = $bestelMoment->diff($nu);
                            $minutenVerschil = ($verschil->h * 60) + $verschil->i;

                            // Toon knop als bestelling jonger is dan 10 minuten
                            if ($minutenVerschil < 10): ?>
                                <form action="bestelstatus.php" method="post">
                                    <input type="hidden" name="order_id" value="<?= htmlspecialchars($bestelling['order_id']) ?>">
                                    <input type="hidden" name="tijd" value="<?= $bestelMoment->format('H:i') ?>">
                                    <input type="hidden" name="producten"
                                        value="<?= htmlspecialchars(json_encode($bestelling['producten'])) ?>">
                                    <input type="hidden" name="adres" value="<?= htmlspecialchars($bestelling['address']) ?>">
                                    <button type="submit" class="status-knop">Bestelling status bekijken</button>
                                </form>
                            <?php endif; ?>

                            <ul>
                                <?php foreach ($bestelling['producten'] as $product): ?>
                                    <li><?= htmlspecialchars($product['product_name']) ?> x <?= (int) $product['quantity'] ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer>
        <p>Reno Swart</p>
        <a href="privacy.php">Privacy verklaring</a>
    </footer>
</body>

</html>
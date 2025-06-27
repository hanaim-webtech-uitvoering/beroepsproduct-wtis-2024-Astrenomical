<?php
session_start();
require_once 'data_functies.php';


$totaal = 0;
$alleProducten = haalProductenOp();

//Gebruiker ingelogd, vult automatisch adres
$postcodeValue = '';
$straatValue = '';
$provincieValue = '';

if (isset($_SESSION['user']['address'])) {
    // Adres uit string halen van DB
    $adresOnderdelen = explode(',', $_SESSION['user']['address']);
    $straatValue = trim($adresOnderdelen[0] ?? '');
    $postcodeValue = trim($adresOnderdelen[1] ?? '');
    $provincieValue = trim($adresOnderdelen[2] ?? '');
}

// Verwerk POST acties
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['actie']) && isset($_POST['product_name'])) {
        $naam = $_POST['product_name'];

        if ($_POST['actie'] === 'toevoegen') {
            $_SESSION['winkelwagen'][$naam] = ($_SESSION['winkelwagen'][$naam] ?? 0) + 1;
        } elseif ($_POST['actie'] === 'verwijderen') {
            if (isset($_SESSION['winkelwagen'][$naam])) {
                $_SESSION['winkelwagen'][$naam]--;
                if ($_SESSION['winkelwagen'][$naam] <= 0) {
                    unset($_SESSION['winkelwagen'][$naam]);
                }
            }
        }
    } elseif (isset($_POST['actie']) && $_POST['actie'] === 'leegmaken') {
        unset($_SESSION['winkelwagen']);
    } elseif (isset($_POST['actie']) && $_POST['actie'] === 'plaatsen') {
        if (empty($_SESSION['winkelwagen'])) {
            $_SESSION['foutmelding'] = 'Je winkelwagen is leeg.';
        } else {
            // Validatie adresvelden
            $postcode = trim($_POST['postcode'] ?? '');
            $straat = trim($_POST['street'] ?? '');
            $provincie = trim($_POST['province'] ?? '');
            $opmerkingen = trim($_POST['comments'] ?? '');

            if (empty($postcode) || empty($straat) || empty($provincie)) {
                $_SESSION['foutmelding'] = 'Vul alle verplichte velden in (postcode, straat en provincie).';
            } elseif (!isset($_SESSION['user']['username'])) {
                $_SESSION['foutmelding'] = 'Je moet ingelogd zijn om een bestelling te plaatsen.';
            } else {
                // Gebruiker info
                $username = $_SESSION['user']['username'];
                $voornaam = $_SESSION['user']['first_name'] ?? '';
                $achternaam = $_SESSION['user']['last_name'] ?? '';
                $naam = trim($voornaam . ' ' . $achternaam);

                // Producten en adres
                $producten = $_SESSION['winkelwagen'];
                $adresString = $straat . ', ' . $postcode . ', ' . $provincie;

                // Bestelling opslaan
                $order_id = plaatsNieuweBestelling($username, $naam, $adresString, $producten);

                if ($order_id) {
                    // Bestelling succesvol, gegevens opslaan voor bestelstatus
                    $_SESSION['laatste_bestelling'] = [
                        'order_id' => $order_id,
                        'producten' => $producten,
                        'adres' => [
                            'straat' => $straat,
                            'postcode' => $postcode,
                            'provincie' => $provincie,
                            'opmerkingen' => $opmerkingen
                        ],
                        'tijd' => date("H:i")
                    ];

                    unset($_SESSION['winkelwagen']);
                    $_SESSION['bestelling_succes'] = true;
                    header("Location: bestelstatus.php");
                    exit;
                } else {
                    $_SESSION['foutmelding'] = 'Er is iets misgegaan bij het plaatsen van je bestelling.';
                }
            }
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
    <title>Winkelwagen</title>
</head>

<body>
    <?php require_once 'header.php'; ?>
    <main>
        <div class="bestel-overzicht">
            <!-- Adresformulier -->
            <div class="adres-info">
                <form action="winkelwagen.php" method="POST" id="bestel-form">
                    <input type="hidden" name="actie" value="plaatsen">
                    <h2>Afleveradres</h2>

                    <?php if (isset($_SESSION['foutmelding'])) { ?>
                        <div class="fout-melding">
                            <p><?= htmlspecialchars($_SESSION['foutmelding']) ?></p>
                        </div>
                        <?php unset($_SESSION['foutmelding']); ?>
                    <?php } ?>

                    <label for="postcode">Postcode</label>
                    <input type="text" id="postcode" name="postcode" required
                        value="<?= htmlspecialchars($postcodeValue) ?>">
                    <label for="street">Straat</label>
                    <input type="text" id="street" name="street" required value="<?= htmlspecialchars($straatValue) ?>">
                    <label for="province">Provincie</label>
                    <input type="text" id="province" name="province" required
                        value="<?= htmlspecialchars($provincieValue) ?>">

                    <label for="comments">Opmerkingen:</label>
                    <textarea id="comments" name="comments" rows="3" class="adres-gegevens"></textarea>

                    <?php if (!empty($_SESSION['winkelwagen'])) { ?>
                        <button type="submit" class="plaats-bestelling">Plaats bestelling</button>
                    <?php } else { ?>
                        <p class="geen-producten">Voeg eerst producten toe aan je winkelwagen om een bestelling te kunnen
                            plaatsen.</p>
                    <?php } ?>
                </form>
            </div>

            <!-- Bestellingsoverzicht -->
            <div class="bestelling-overzicht">
                <div class="bestelling-info">
                    <h2>Bestelling</h2>
                    <?php if (isset($_SESSION['bestelling_succes'])) { ?>
                        <p class="succes-melding">Je bestelling is succesvol geplaatst!</p>
                        <?php unset($_SESSION['bestelling_succes']); ?>
                    <?php } ?>

                    <?php if (!empty($_SESSION['winkelwagen'])) {
                        foreach ($_SESSION['winkelwagen'] as $naam => $aantal) {
                            $prijs = vindPrijs($naam, $alleProducten);
                            $totaal += $prijs * $aantal;
                            ?>
                            <div class="bestel-item">
                                <form method="post" action="winkelwagen.php" class="inline-form">
                                    <input type="hidden" name="product_name" value="<?= htmlspecialchars($naam) ?>">
                                    <button type="submit" name="actie" value="verwijderen" class="winkelknop">−</button>
                                </form>

                                <span><?= htmlspecialchars($aantal) ?>x <?= htmlspecialchars($naam) ?></span>

                                <form method="post" action="winkelwagen.php" class="inline-form">
                                    <input type="hidden" name="product_name" value="<?= htmlspecialchars($naam) ?>">
                                    <button type="submit" name="actie" value="toevoegen" class="winkelknop">+</button>
                                </form>

                                <span>€ <?= number_format($prijs * $aantal, 2, ',', '.') ?></span>
                            </div>
                        <?php } ?>

                        <div class="kosten-bestelling">
                            <strong>Totaal</strong>
                            <span>€ <?= number_format($totaal, 2, ',', '.') ?></span>
                        </div>

                        <div class="bestel-acties">
                            <form method="post" action="winkelwagen.php" class="inline-form">
                                <button type="submit" name="actie" value="leegmaken" class="leeg-knop">Leeg
                                    winkelwagen</button>
                            </form>
                        </div>
                    <?php } else { ?>
                        <p>Je winkelwagen is leeg.</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <p>Reno Swart</p>
        <a href="privacy.php">Privacy verklaring</a>
    </footer>
</body>

</html>
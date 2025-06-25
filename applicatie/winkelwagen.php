<?php
session_start();
require_once 'data_functies.php';

$totaal = 0;
$alleProducten = haalProductenOp();

function vindPrijs($naam, $alleProducten)
{
    foreach ($alleProducten as $product) {
        if ($product['name'] === $naam) {
            return $product['price'];
        }
    }
    return 0;
}

// Verwerk acties (toevoegen, verwijderen, legen)
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
        if (!empty($_SESSION['winkelwagen'])) {
            $_SESSION['laatste_bestelling'] = [
                'producten' => $_SESSION['winkelwagen'],
                'tijd' => date('Y-m-d H:i:s'),
                'adres' => [
                    'postcode' => $_POST['postcode'] ?? '',
                    'straat' => $_POST['street'] ?? '',
                    'provincie' => $_POST['province'] ?? '',
                    'opmerkingen' => $_POST['comments'] ?? ''
                ]
            ];

            // Leeg winkelwagen na plaatsen
            unset($_SESSION['winkelwagen']);

            $_SESSION['bestelling_succes'] = true;


            header("Location: winkelwagen.php");
            exit;
        }
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
    <title>Winkelwagen</title>
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
        <!--Invul plaats voor het adres van de klant-->
        <div class="bestel-overzicht">
            <form class="adres-info" action="#" method="POST">
                <h2>Afleveradres</h2>

                <label for="postcode"><strong>Postcode:</strong></label>
                <input type="text" id="postcode" name="postcode" class="adres-gegevens">

                <label for="street"><strong>Straat & Huisnr:</strong></label>
                <input type="text" id="street" name="street" class="adres-gegevens">

                <label for="province"><strong>Provincie:</strong></label>
                <input type="text" id="province" name="province" class="adres-gegevens">

                <label for="comments">Opmerkingen:</label>
                <textarea id="comments" name="comments" rows="3" class="adres-gegevens"></textarea>
            </form>

            <!--Overzicht van welke pizza(s) de klant heeft besteld-->
            <div class="bestelling-overzicht">
                <div class="bestelling-info">
                    <h2>Bestelling</h2>
                    <?php if (isset($_SESSION['bestelling_succes'])): ?>
                        <p class="succes-melding">Je bestelling is succesvol geplaatst!</p>
                        <?php unset($_SESSION['bestelling_succes']); ?>
                    <?php endif; ?>
                    <?php if (!empty($_SESSION['winkelwagen'])): ?>
                        <?php foreach ($_SESSION['winkelwagen'] as $naam => $aantal):
                            $prijs = vindPrijs($naam, $alleProducten);
                            $totaal += $prijs * $aantal;
                            ?>
                            <div class="bestel-item">
                                <form method="post" action="winkelwagen.php" style="display:inline;">
                                    <input type="hidden" name="product_name" value="<?= htmlspecialchars($naam) ?>">
                                    <button type="submit" name="actie" value="verwijderen" class="winkelknop">−</button>
                                </form>

                                <span><?= htmlspecialchars($aantal) ?>x <?= htmlspecialchars($naam) ?></span>

                                <form method="post" action="winkelwagen.php" style="display:inline;">
                                    <input type="hidden" name="product_name" value="<?= htmlspecialchars($naam) ?>">
                                    <button type="submit" name="actie" value="toevoegen" class="winkelknop">+</button>
                                </form>
                                <span>€ <?= number_format($prijs * $aantal, 2, ',', '.') ?></span>
                            </div>
                        <?php endforeach; ?>
                        <div class="kosten-bestelling">
                            <strong>Totaal</strong>
                            <span>€ <?= number_format($totaal, 2, ',', '.') ?></span>
                        </div>

                        <div class="bestel-acties">
                            <form method="post" action="winkelwagen.php" style="display:inline;">
                                <button type="submit" name="actie" value="leegmaken" class="leeg-knop">Leeg
                                    winkelwagen</button>
                            </form>
                            <form method="post" action="winkelwagen.php" style="display:inline;">
                                <button type="submit" name="actie" value="plaatsen" class="plaats-bestelling">Plaats
                                    bestelling</button>
                            </form>
                        </div>

                    <?php else: ?>
                        <p>Je winkelwagen is leeg.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
    <!--Footer voor elke pagina met de privacy verklaring-->
    <footer>
        <p>Reno Swart</p>
        <a href="privacy.php">Privacy verklaring</a>
    </footer>
</body>

</html>
<?php
session_start();
require_once 'db_connectie.php';
require_once 'header.php';

// Als de gebruiker niet is ingelogd, redirect naar loginpagina
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

?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Css/normalize.css">
    <link rel="stylesheet" href="Css/style.css">
    <title>Profiel pagina</title>
</head>

<body>
    <main>
        <!--Profiel informatie van de klant aan linkerkant-->
        <div class="profiel-details">
            <h2>Profielgegevens</h2>
            <p><strong>Gebruikersnaam</strong></p>
            <p><?= htmlspecialchars($_SESSION['user']['username']) ?></p>

            <p><strong>Naam</strong></p>
            <p><?= htmlspecialchars($gebruiker['first_name'] . ' ' . $gebruiker['last_name']) ?></p>

            <p><strong>address</strong></p>
            <p><?= nl2br(htmlspecialchars($gebruiker['address'])) ?></p>
        </div>


        <!--De bestelling historie van de klant-->
        <div class="bestel-historie">
            <h2>Bestellingen overzicht</h2>

            <!--De pizzas die de klant heeft besteld-->

            <div class="bestelde-items">
                <p><strong>Pizza pepperoni x2</strong> 13-11-24</p>
                <p>€ 25,00</p>
            </div>

            <div class="bestelde-items">
                <p><strong>Pizza pepperoni x1</strong> 09-10-24</p>
                <p><strong>Pizza Mozzarella x1</strong></p>
                <p>€ 23,00</p>
            </div>

            <div class="bestelde-items">
                <p><strong>Pizza Vegan Delight x1</strong> 09-09-24</p>
                <p><strong>Pizza Veggie Supreme x1</strong></p>
                <p>€ 24,50</p>
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
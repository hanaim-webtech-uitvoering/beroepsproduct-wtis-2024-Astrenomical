<?php
session_start();
require_once 'db_connectie.php';
$conn = maakVerbinding();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Inputs veilig ophalen en valideren
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
    $last_name = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $postcode = isset($_POST['postcode']) ? trim($_POST['postcode']) : '';
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';
    $provincie = isset($_POST['provincie']) ? trim($_POST['provincie']) : '';


    // Adres samenvoegen tot 1 string 
    $address = $address . ', ' . $postcode . ', ' . $provincie;

    // Wachtwoord hashen
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Database check of username al bestaat
    $stmt = $conn->prepare("SELECT username FROM [User] WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        $error = "Deze gebruikersnaam is al in gebruik.";
    } else {
        $stmt = $conn->prepare("INSERT INTO [User] (username, password, first_name, last_name, address, role) VALUES (?, ?, ?, ?, ?, Client)");
        if ($stmt->execute([$username, $hashedPassword, $first_name, $last_name, $address])) {
            $_SESSION['registratie_success'] = "Registratie geslaagd! Je kan nu inloggen.";
            header("Location: login.php");
            exit;
        } else {
            $error = "Er is iets misgegaan, probeer het later opnieuw.";
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
    <title>Registratie pagina</title>
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
            <img src="images/winkelkar.png" alt="Winkelkar icoon" class="winkelkar-icoon" title="Bekijk">
        </a>

    </header>
    <main>
        <div class="registratie-form">
            <form action="#" method="POST">
                <h2>Vul de volgende gegevens in om te registreren.</h2>

                <?php if (isset($error)): ?>
                    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>

                <label for="username">Gebruikersnaam</label>
                <input type="text" id="username" name="username"
                    value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required>

                <label for="first_name">Voornaam</label>
                <input type="text" id="first_name" name="first_name"
                    value="<?= isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : '' ?>" required>

                <label for="last_name">Achternaam</label>
                <input type="text" id="last_name" name="last_name"
                    value="<?= isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : '' ?>" required>

                <label for="password">Wachtwoord</label>
                <input type="password" id="password" name="password" required>

                <label for="postcode">Postcode</label>
                <input type="text" id="postcode" name="postcode"
                    value="<?= isset($_POST['postcode']) ? htmlspecialchars($_POST['postcode']) : '' ?>" required>

                <label for="address">Straatnaam & Nummer</label>
                <input type="text" id="address" name="address"
                    value="<?= isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '' ?>" required>

                <label for="provincie">Provincie</label>
                <input type="text" id="provincie" name="provincie"
                    value="<?= isset($_POST['provincie']) ? htmlspecialchars($_POST['provincie']) : '' ?>" required>

                <div class="registreer-knop">
                    <button type="submit">Registreer</button>
                </div>
            </form>
        </div>
    </main>

    <!--Footer voor elke pagina met de privacy verklaring-->
    <footer>
        <p>Reno Swart</p>
        <a href="privacy.php">Privacy verklaring</a>
    </footer>
</body>

</html>
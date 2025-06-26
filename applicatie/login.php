<?php
session_start();
require_once 'db_connectie.php';

//Login functie
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        try {
            $conn = maakVerbinding();

            $stmt = $conn->prepare('SELECT * FROM [User] WHERE username = :username');
            $stmt->execute([':username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user'] = [
                        'username' => $user['username'],
                        'first_name' => $user['first_name'],
                        'last_name' => $user['last_name'],
                        'address' => $user['address'],
                        'role' => $user['role']  
                    ];
                    header('Location: profiel.php');
                    exit;
                } elseif ($password === $user['password']) {
                    $_SESSION['user'] = [
                        'username' => $user['username'],
                        'first_name' => $user['first_name'],
                        'last_name' => $user['last_name'],
                        'address' => $user['address'],
                        'role' => $user['role']
                    ];
                    header('Location: profiel.php');
                    exit;
                } else {
                    $error = 'Ongeldige gebruikersnaam of wachtwoord.';
                }
            } else {
                $error = 'Ongeldige gebruikersnaam of wachtwoord.';
            }
        } catch (PDOException $e) {
            $error = 'Er is een fout opgetreden: ' . $e->getMessage();
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
    <title>Pizza de nero - Login</title>
</head>

<body>
    <?php require_once 'header.php'; ?>
    <main>
        <!--Login overzicht-->
        <div class="login-algemeen">
            <div class="login-input">
                <h2>Login</h2>
                <form action="#" method="POST">

                    <!-- Gebruikersnaam Input -->
                    <div class="input-group">
                        <label for="username">Gebruikersnaam</label>
                        <input type="text" id="username" name="username" required>
                    </div>

                    <!-- Wachtwoord Input -->
                    <div class="input-group">
                        <label for="password">Wachtwoord</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <!-- Login knop -->
                    <button type="submit">Login</button>
                </form>

                <?php if (isset($error)): ?>
                    <p class="error-message"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>

                <!-- Registratie link -->
                <p>
                    Nog geen lid? Meld je dan <a href="registratie.php">hier</a> aan!
                </p>
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
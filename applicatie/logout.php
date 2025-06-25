<?php
session_start();          // Start of hervat sessie
session_destroy();        // Vernietig de sessie volledig

// Optioneel: cookie verwijderen
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redirect naar loginpagina
header("Location: login.php");
exit;
?>
<?php
session_start();          // Start of hervat sessie
session_destroy();        // Vernietig de sessie volledig

// Redirect naar loginpagina
header("Location: login.php");
exit;
?>
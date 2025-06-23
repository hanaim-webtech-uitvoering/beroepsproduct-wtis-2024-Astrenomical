<?php
require_once 'db_connectie.php';

// maak verbinding met de database (zie db_connection.php)
$db = maakVerbinding();

function haalProductenOp() {
    $sql = "SELECT name, price, type_id 
            FROM Product";
    $stmt = maakVerbinding()->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<?php
require_once 'db_connectie.php';

// maak verbinding met de database (zie db_connection.php)
$db = maakVerbinding();

//Haalt alle producten op uit de DB
function haalProductenOp()
{
    $sql = "SELECT name, price, type_id 
            FROM Product";
    $stmt = maakVerbinding()->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Price finder
function vindPrijs($naam, $alleProducten)
{
    foreach ($alleProducten as $product) {
        if ($product['name'] === $naam) {
            return $product['price'];
        }
    }
    return 0;
}

//Haal bestellingen op voor personeelsleden
function haalAlleBestellingenOp(): array {
    $conn = maakVerbinding();

    $stmtOrders = $conn->query("
        SELECT order_id, datetime, status, address, client_username, client_name, personnel_username
        FROM Pizza_order
        ORDER BY datetime DESC
    ");
    $orders = $stmtOrders->fetchAll(PDO::FETCH_ASSOC);

    foreach ($orders as &$order) {
        $stmtProducts = $conn->prepare("
            SELECT product_name, quantity 
            FROM Pizza_Order_Product 
            WHERE order_id = :order_id
        ");
        $stmtProducts->execute([':order_id' => $order['order_id']]);
        $order['producten'] = $stmtProducts->fetchAll(PDO::FETCH_ASSOC);
    }

    return $orders;
}


//Haalt gemaakte bestellingen op uit DB
function haalBestellingenOpVoorUser(string $username): array
{
    $conn = maakVerbinding();

    // Bestellingen van gebruiker ophalen, inclusief toegewezen personeel
    $stmtOrders = $conn->prepare("
        SELECT order_id, datetime, status, address, personnel_username
        FROM Pizza_order 
        WHERE client_username = :username 
        ORDER BY datetime DESC
    ");
    $stmtOrders->execute([':username' => $username]);
    $orders = $stmtOrders->fetchAll(PDO::FETCH_ASSOC);

    foreach ($orders as &$order) {
        $stmtProducts = $conn->prepare("
            SELECT product_name, quantity 
            FROM Pizza_Order_Product 
            WHERE order_id = :order_id
        ");
        $stmtProducts->execute([':order_id' => $order['order_id']]);
        $order['producten'] = $stmtProducts->fetchAll(PDO::FETCH_ASSOC);
    }

    return $orders;
}

//Haalt bestelling adres op van recente bestelling
function haalLaatsteBestellingAdresOp($gebruikersnaam)
{
    $conn = maakVerbinding();
    $stmt = $conn->prepare("
        SELECT TOP 1 address 
        FROM Pizza_order 
        WHERE client_username = ? 
        ORDER BY datetime DESC
    ");
    $stmt->execute([$gebruikersnaam]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['address'] ?? null;
}

// Voeg nieuwe bestellingen toe aan de DB
function plaatsNieuweBestelling(string $username, string $name, string $adres, array $producten): int
{
    $conn = maakVerbinding();

    // Kies random personeel
    $stmtPersoneel = $conn->prepare("SELECT username FROM [User] WHERE role = 'Personnel'");
    $stmtPersoneel->execute();
    $personeelLijst = $stmtPersoneel->fetchAll(PDO::FETCH_COLUMN);

    if (empty($personeelLijst)) {
        throw new Exception("Geen personeel beschikbaar");
    }
    $randomPersoneel = $personeelLijst[array_rand($personeelLijst)];

    // Insert in Pizza_order inclusief personeel_username
    $stmt = $conn->prepare("
        INSERT INTO Pizza_order (client_username, client_name, datetime, status, address, personnel_username)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $datum = date("Y-m-d H:i:s");
    $status = 1;
    $stmt->execute([$username, $name, $datum, $status, $adres, $randomPersoneel]);

    $order_id = $conn->lastInsertId();

    // Insert elk product
    $stmtProduct = $conn->prepare("
        INSERT INTO Pizza_Order_Product (order_id, product_name, quantity)
        VALUES (?, ?, ?)
    ");
    foreach ($producten as $productNaam => $aantal) {
        $stmtProduct->execute([$order_id, $productNaam, $aantal]);
    }

    return (int) $order_id;
}

function updateBestellingStatus(int $order_id, int $status): bool
{
    $conn = maakVerbinding();
    $stmt = $conn->prepare("UPDATE Pizza_order SET status = ? WHERE order_id = ?");
    return $stmt->execute([$status, $order_id]);
}


function haalBestellingOp(int $order_id): ?array
{
    $conn = maakVerbinding();

    // Haal ordergegevens op
    $stmtOrder = $conn->prepare("
        SELECT order_id, datetime, status, address, client_username, client_name, personnel_username
        FROM Pizza_order
        WHERE order_id = :order_id
    ");
    $stmtOrder->execute([':order_id' => $order_id]);
    $order = $stmtOrder->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        // Geen bestelling gevonden met dit order_id
        return null;
    }

    // Haal producten van deze bestelling op
    $stmtProducts = $conn->prepare("
        SELECT product_name, quantity 
        FROM Pizza_Order_Product 
        WHERE order_id = :order_id
    ");
    $stmtProducts->execute([':order_id' => $order_id]);
    $producten = $stmtProducts->fetchAll(PDO::FETCH_ASSOC);

    $order['producten'] = $producten;

    return $order;
}

?>
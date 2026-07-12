<?php
$httpHost = $_SERVER['HTTP_HOST'] ?? 'localhost';

if (in_array($httpHost, ['localhost', '127.0.0.1', 'agri.local', 'agrimarket.local'], true)) {
    $host = 'localhost';
    $dbname = 'shopping_cart_dbb';
    $username = 'root';
    $password = '';
} else {
    $host = 'sql100.infinityfree.com';
    $dbname = 'if0_41769329_shopping_cart_dbb';
    $username = 'if0_41769329';
    $password = 'ByrwPqY0fs';
}

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>

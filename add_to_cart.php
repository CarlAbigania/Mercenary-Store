<?php
session_start();

$product_id = $_POST['product_id'];
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id]++;
} else {
    $_SESSION['cart'][$product_id] = 1;
}
header("Location: product_listing.php");
exit;
?>

<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Check if the product exists in the cart
    if (isset($_SESSION['cart'][$product_id])) {
        // Remove the item from the cart
        unset($_SESSION['cart'][$product_id]);

        // If the cart is empty after removing the item, unset the cart session
        if (empty($_SESSION['cart'])) {
            unset($_SESSION['cart']);
        }
    }
}

// Redirect back to the cart page
header("Location: view_cart.php");
exit;
?>

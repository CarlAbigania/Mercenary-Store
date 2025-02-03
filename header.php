<?php 
require 'db.php'; 

// Get user data from session
if (isset($_SESSION['user_id'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];

    // If the user is a customer, get the number of items in the cart
    $cart_item_count = 0;
    if ($role == 'customer' && isset($_SESSION['cart'])) {
        $cart_item_count = count($_SESSION['cart']);
    }
} else {
    // Redirect to login if session is not active
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=MedievalSharp&display=swap" rel="stylesheet">
    <title>Website</title>
    <style>
        /* Header styling */
        .header {
            position: sticky;
            top: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            color: white;
            padding: 15px 20px;
            z-index: 1000;
        }

        .company-name {
            font-family: 'MedievalSharp', sans-serif;
            font-size: 24px;
            font-weight: bold;
            margin-left: 20px;
        }

        .user-info {
            font-family: 'MedievalSharp', sans-serif;
            display: flex;
            align-items: center;
            font-size: 18px;
            margin-right: 40px;
        }

        .logout-btn, .cart-btn {
            font-family: 'MedievalSharp', sans-serif;
            background-color: #4b5320; /* Dark Olive Green */
            color: #f0e68c; /* Light Golden Khaki for text */
            border: 2px solid #3e442b; /* Darker olive border */
            text-decoration: none;
            margin-left: 15px;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .logout-btn:hover, .cart-btn:hover {
            background-color: #45a049;
        }

        .cart-btn {
            position: relative;
        }

        .cart-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: red;
            color: white;
            border-radius: 50%;
            font-size: 14px;
            padding: 2px 6px;
        }

        body {
            font-family: 'MedievalSharp', sans-serif;
            margin: 0;
            padding-top: 80px;
        }
    </style>
</head>
<body>

<div class="header">
    <div class="company-name">Travelling Merchant</div>
    <div class="user-info">
        Hello, <?php echo htmlspecialchars($username); ?>!
        
        <!-- Show Cart button only for customers -->
        <?php if ($role == 'customer'): ?>
            <a href="view_cart.php" class="cart-btn">
                Cart <span class="cart-count"><?php echo $cart_item_count; ?></span>
            </a>
        <?php endif; ?>

        <!-- Logout button -->
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</div>

</body>
</html>

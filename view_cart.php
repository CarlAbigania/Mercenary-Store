<?php 
session_start();
require 'db.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    // Display a styled empty cart message with a background image
    echo '
    <!DOCTYPE html>
    <html>
    <head>
        <title>Your Cart</title>
            <link href="https://fonts.googleapis.com/css2?family=MedievalSharp&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: Arial, sans-serif;
                background-image: url("uploads/merchant_bg.jpg");
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }
            .empty-cart-container {
                font-family: "MedievalSharp", sans-serif;
                background-image:url("uploads/paper_bg.jpg");
                background-size: cover;      
                background-position: center; 
                background-repeat: no-repeat; 
                text-align: center;
                padding: 40px;
                border-radius: 8px;
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
                width: 80%;
                max-width: 500px;
            }
            .empty-cart-container h2 {
                color: #333;
                font-size: 1.5em;
                margin-bottom: 10px;
            }
            .empty-cart-container p {
                color: #666;
                font-size: 1em;
                margin-bottom: 20px;
            }
            .shop-btn {
                font-family: "MedievalSharp", sans-serif;
                background-color: #4b5320; /* Dark Olive Green */
                color: #f0e68c; /* Light Golden Khaki for text */
                border: 2px solid #3e442b; /* Darker olive border */
                display: inline-block;
                padding: 12px 24px;
                text-decoration: none;
                border-radius: 5px;
                font-size: 1em;
                transition: background-color 0.3s;
            }
            .shop-btn:hover {
                background-color: #45a049;
            }
        </style>
    </head>
    <body>
        <div class="empty-cart-container">
            <h2>Your Cart is Empty</h2>
            <p>It looks like you haven\'t added anything to your cart yet.</p>
            <a href="product_listing.php" class="shop-btn">Go Shopping</a>
        </div>
    </body>
    </html>
    ';
    exit;
}

// Fetch cart details
$product_ids = array_keys($_SESSION['cart']);
$stmt = $conn->prepare("SELECT * FROM products WHERE id IN (" . implode(',', $product_ids) . ")");
$stmt->execute();
$products = $stmt->fetchAll();
?>
<?php include('header.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <link href="https://fonts.googleapis.com/css2?family=MedievalSharp&display=swap" rel="stylesheet">
    <style>
        html, body {
            background-image: url('uploads/merchant_bg.jpg');
            background-size: cover;      
            background-position: center; 
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            height: 100%;
            overflow-x: hidden;
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
        }
        .container {
            background-image:url('uploads/paper_bg.jpg');
            background-size: cover;      
            background-position: center; 
            background-repeat: no-repeat; 
            font-family: "MedievalSharp", sans-serif;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .cart-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }
        .cart-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            margin-right: 20px;
            border-radius: 5px;
        }
        .cart-item h2 {
            margin: 0;
            font-size: 1.2em;
            color: #333;
        }
        .cart-item p {
            margin: 5px 0;
            color: #666;
        }
        .remove-btn {
            font-family: "MedievalSharp", sans-serif;
            padding: 5px 10px;
            font-size: 0.9em;
            color: #fff;
            background-color: #dc3545;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .remove-btn:hover {
            background-color: #c82333;
        }
        .checkout-btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 1em;
            background-color: #28a745;
            color: #fff;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            margin-top: 20px;
        }
        .checkout-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Cart</h1>
        
        <?php foreach ($products as $product): ?>
            <div class="cart-item">
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                <div>
                    <h2><?php echo $product['name']; ?></h2>
                    <p>Quantity: <?php echo $_SESSION['cart'][$product['id']]; ?></p>
                    <p>Price: $<?php echo number_format($product['price'], 2); ?></p>
                </div>
                <form action="remove_from_cart.php" method="post">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <button type="submit" class="remove-btn">Remove</button>
                </form>
            </div>
        <?php endforeach; ?>

        <div style="text-align: center;">
            <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
        </div>
    </div>
</body>
</html>

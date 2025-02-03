<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: product_listing.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$total = 0;
$order_items = [];

// Fetch the details of each product in the cart
$product_ids = array_keys($_SESSION['cart']);
$placeholders = implode(',', array_fill(0, count($product_ids), '?'));
$stmt = $conn->prepare("SELECT id, name, price FROM products WHERE id IN ($placeholders)");
$stmt->execute($product_ids);
$products = $stmt->fetchAll();

foreach ($products as $product) {
    $product_id = $product['id'];
    $quantity = $_SESSION['cart'][$product_id];
    $price = $product['price'];
    $subtotal = $price * $quantity;
    $total += $subtotal;

    // Add each item with its quantity and price to the order items array
    $order_items[] = [
        'product_id' => $product_id,
        'name' => $product['name'],
        'price' => $price,
        'quantity' => $quantity,
        'subtotal' => $subtotal
    ];
}

// Insert the order into the orders table
$order_data = json_encode($order_items);
$stmt = $conn->prepare("INSERT INTO orders (user_id, order_details, order_total) VALUES (?, ?, ?)");
$stmt->execute([$user_id, $order_data, $total]);

// Clear the cart after checkout
unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link href="https://fonts.googleapis.com/css2?family=MedievalSharp&display=swap" rel="stylesheet">
    <style>
        html, body {
            background-image:url('uploads/merchant_bg.jpg');
            background-size: cover;      
            background-position: center; 
            background-repeat: no-repeat;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
        }

        .order-confirmation {
            background-image:url('uploads/paper_bg.jpg');
            background-size: cover;      
            background-position: center; 
            background-repeat: no-repeat; 
            font-family: 'MedievalSharp', sans-serif;
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #2c3e50;
            text-align: center;
        }

        h2 {
            color: #34495e;
            margin-bottom: 20px;
        }

        .order-details table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            border: 1px solid #4CAF50; /* Added border color */
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #4CAF50; 
            color: #333; 
        }

        .total {
            font-size: 1.2em;
            margin-top: 20px;
            text-align: right;
        }

        .continue-shopping {
            text-align: center;
            margin-top: 20px;
        }

        .continue-shopping button {
            font-family: 'MedievalSharp', sans-serif;
            background-color: #4b5320; /* Dark Olive Green */
            color: #f0e68c; /* Light Golden Khaki for text */
            border: 2px solid #3e442b; /* Darker olive border */
            padding: 10px 20px;
            font-size: 1.1em;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .continue-shopping button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="order-confirmation">
        <h1>Thank You for Your Purchase!</h1>
        <p>Your order has been successfully placed. Here are the details of your purchase:</p>

        <div class="order-details">
            <h2>Order Summary</h2>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order_items as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                            <td>$<?php echo number_format($item['subtotal'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="total">
            <h3>Total: $<?php echo number_format($total, 2); ?></h3>
        </div>

        <div class="continue-shopping">
            <button onclick="window.location.href='product_listing.php';">Continue Shopping</button>
        </div>
    </div>
</body>
</html>

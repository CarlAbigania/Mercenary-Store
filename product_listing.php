<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$products = $conn->query("SELECT * FROM products")->fetchAll();
?>

<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Listing</title>
    <link href="https://fonts.googleapis.com/css2?family=MedievalSharp&display=swap" rel="stylesheet">
    <style>
        /* Reset default margin and padding */
        html, body {
            background-image:url('uploads/merchant_bg.jpg');
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

        /* Page title */
        h1 {
            font-family: 'MedievalSharp', sans-serif;
            text-align: center;
            color: white;
            margin-top: 20px;
        }

        /* Product container */
        .product-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            max-width: 1200px;
            margin: 20px auto;
            justify-content: center;
        }

        /* Individual product card */
        .product-card {
            font-family: 'MedievalSharp', sans-serif;
            background-image:url('uploads/paper_bg.jpg');
            background-size: cover;      
            background-position: center; 
            background-repeat: no-repeat; 
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            width: 200px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .product-card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        /* Product image */
        .product-card img {
            width: 100%;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        /* Product name */
        .product-card h2 {
            font-size: 1.1em;
            color: #333;
            margin: 10px 0;
        }

        /* Description */
        .product-description {
            font-size: 0.9em;
            color: #666;
            margin: 10px 0;
            flex-grow: 1;
        }

        /* Price */
        .product-price {
            font-size: 1em;
            color: #666;
            margin: 10px 0;
        }

        /* Quantity input */
        .quantity-input {
            width: 50px;
            padding: 5px;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        /* Add to Cart button styling */
        .product-card button {
            font-family: 'MedievalSharp', sans-serif;
            background-color: #4b5320; /* Dark Olive Green */
            color: #f0e68c; /* Light Golden Khaki for text */
            border: 2px solid #3e442b; /* Darker olive border */
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        .product-card button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Items from afar</h1>
    <div class="product-container">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <img src="<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                <p class="product-description"><?php echo htmlspecialchars($product['description']); ?></p>
                <p class="product-price">Price: $<?php echo number_format($product['price'], 2); ?></p>
                <form action="add_to_cart.php" method="post">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <button type="submit">Add to Cart</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>

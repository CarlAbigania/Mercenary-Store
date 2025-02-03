<?php
session_start();
require 'db.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$isEditing = false;
$productData = ['name' => '', 'price' => '', 'description' => '', 'image' => ''];

// Handle product add or update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    
    // Check if this is an update operation
    if (isset($_POST['update_product'])) {
        $productId = $_POST['product_id'];
        if ($_FILES['image']['error'] == 0) {
            $image = 'uploads/' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $image);
            $stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, description = ?, image = ? WHERE id = ?");
            $stmt->execute([$name, $price, $description, $image, $productId]);
        } else {
            $stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, description = ? WHERE id = ?");
            $stmt->execute([$name, $price, $description, $productId]);
        }
    } else { // Add new product
        if ($_FILES['image']['error'] == 0) {
            $image = 'uploads/' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $image);
            $stmt = $conn->prepare("INSERT INTO products (name, price, description, image) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $price, $description, $image]);
        }
    }

    // Redirect to refresh the page
    header("Location: admin_panel.php");
    exit;
}

// Handle product delete
if (isset($_GET['delete_id'])) {
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$_GET['delete_id']]);
    header("Location: admin_panel.php");
    exit;
}

// Handle product edit
if (isset($_GET['edit_id'])) {
    $isEditing = true;
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$_GET['edit_id']]);
    $productData = $stmt->fetch();
}
?>

<?php include('header.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=MedievalSharp&display=swap" rel="stylesheet">
    <title>Admin Panel</title>
    <style>
        /* Prevent horizontal overflow */
        body, html {
            overflow-x: hidden;
        }

        /* General styles for form and container */
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
        .container { 
            max-width: 100%; /* Ensure container width doesn't exceed viewport */
            padding: 20px; 
            box-sizing: border-box; /* Includes padding within width */
        }
        
        h2 { color: white; font-family: 'MedievalSharp', sans-serif; }
        form { 
            background-image:url('uploads/paper_bg.jpg');
            background-size: cover;      
            background-position: center; 
            background-repeat: no-repeat; 
            /* background: #fff;  */
            padding: 20px; 
            border-radius: 8px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
            margin-bottom: 20px;
            font-family: 'MedievalSharp', sans-serif;
        }
        form input[type="text"], form input[type="number"], form textarea, form input[type="file"] {
            width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ccc; border-radius: 4px;
        }
        form button { 
            font-family: 'MedievalSharp', sans-serif;
            background-color: #4b5320; /* Dark Olive Green */
            color: #f0e68c; /* Light Golden Khaki for text */
            border: 2px solid #3e442b; /* Darker olive border */
            padding: 10px 20px; 
            background: #28a745; 
            border-radius: 4px; 
            cursor: pointer; }
        form button:hover {            
            background-color: #45a049;
        }
        .product {
            background-image:url('uploads/paper_bg.jpg');
            background-size: cover;      
            background-position: center; 
            background-repeat: no-repeat; 
            display: flex; 
            justify-content: space-between;
            align-items: center;
            /* background: #fff;  */
            padding: 10px; 
            margin-bottom: 10px; 
            border-radius: 8px; 
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .product img { 
            width: 100px; 
            margin-right: 15px; 
            border-radius: 4px; 
        }
        .product .product-details { 
            font-family: 'MedievalSharp', sans-serif;
            flex-grow: 1;
        }
        .edit-link, .delete-link { 
            font-family: 'MedievalSharp', sans-serif;
            color: #007bff; 
            text-decoration: none; 
            margin-left: 10px;
        }
        .delete-link { 
            color: #dc3545; 
        }
        .edit-link:hover { 
            color: #0056b3; 
        }
        .delete-link:hover { 
            color: #c82333; 
        }

        /* Order table styles */
        .orders-table { 
            background-image:url('uploads/paper_bg.jpg');
            background-size: cover;      
            background-position: center; 
            background-repeat: no-repeat; 
            width: 100%; 
            margin-top: 30px; 
            border-collapse: collapse;
            font-family: 'MedievalSharp', sans-serif; 
        }
        .orders-table th, .orders-table td { 
            border: 1px solid #4CAF50; /* Added border color */
            padding: 8px; 
            text-align: left; 
        }
        .orders-table th { 
            background-color: #4CAF50; 
            color: #333; 
        }
        .order-items { 
            padding-left: 20px; 
            font-size: 0.9em; 
            color: black; 
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Panel - <?php echo $isEditing ? 'Edit Product' : 'Add New Product'; ?></h2>
        <form action="admin_panel.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="<?php echo $isEditing ? 'update_product' : 'add_product'; ?>" value="1">
            <?php if ($isEditing): ?>
                <input type="hidden" name="product_id" value="<?php echo $productData['id']; ?>">
            <?php endif; ?>
            
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($productData['name']); ?>" required>
            
            <label for="price">Price:</label>
            <input type="number" name="price" id="price" step="0.01" value="<?php echo htmlspecialchars($productData['price']); ?>" required>
            
            <label for="description">Description:</label>
            <textarea name="description" id="description" required><?php echo htmlspecialchars($productData['description']); ?></textarea>
            
            <label for="image">Image:</label>
            <?php if ($isEditing && $productData['image']): ?>
                <img src="<?php echo $productData['image']; ?>" width="100" alt="Current Image"><br>
            <?php endif; ?>
            <input type="file" name="image" id="image" accept="image/*" <?php echo $isEditing ? '' : 'required'; ?>>
            
            <button type="submit"><?php echo $isEditing ? 'Update Product' : 'Add Product'; ?></button>
        </form>

        <h2>Existing Products</h2>
        <?php
        $products = $conn->query("SELECT * FROM products")->fetchAll();
        foreach ($products as $product) {
            echo "<div class='product'>
                    <img src='{$product['image']}' alt='{$product['name']}'>
                    <div class='product-details'>
                        <h3>{$product['name']}</h3>
                        <p>{$product['description']}</p>
                        <p>\${$product['price']}</p>
                    </div>
                    <a class='edit-link' href='admin_panel.php?edit_id={$product['id']}'>Edit</a>
                    <a class='delete-link' href='admin_panel.php?delete_id={$product['id']}'>Delete</a>
                  </div>";
        }
        ?>

        <!-- Orders Section -->
        <h2>View All Orders</h2>
        <table class="orders-table">
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Order Date</th>
                <th>Total Amount</th>
                <th>Items</th>
            </tr>
            <?php
            $orders = $conn->query("
                SELECT orders.id, users.username AS customer_name, orders.created_at, orders.order_total, orders.order_details 
                FROM orders 
                JOIN users ON orders.user_id = users.id
                ORDER BY orders.created_at DESC
            ")->fetchAll();

            foreach ($orders as $order) {
                echo "<tr>
                        <td>{$order['id']}</td>
                        <td>{$order['customer_name']}</td>
                        <td>{$order['created_at']}</td>
                        <td>\${$order['order_total']}</td>
                        <td class='order-items'>";

                $items = json_decode($order['order_details'], true);
                foreach ($items as $item) {
                    echo "<div>{$item['name']} (Qty: {$item['quantity']}, Subtotal: \${$item['subtotal']})</div>";
                }

                echo "</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

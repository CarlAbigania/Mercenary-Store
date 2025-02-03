<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header("Location: " . ($user['role'] == 'admin' ? "admin_panel.php" : "product_listing.php"));
        exit;
    } else {
        $error = "Invalid login credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=MedievalSharp&display=swap" rel="stylesheet">
    <style>
        body {
            background-image:url('uploads/merchant_bg.jpg');
            background-size: cover;      
            background-position: center; 
            background-repeat: no-repeat; 
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            font-family: 'MedievalSharp', sans-serif;
            background-image:url('uploads/paper_bg.jpg');
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            font-family: 'MedievalSharp', sans-serif;
            text-align: center;
            color: black;
        }

        label {
            font-family: 'MedievalSharp', sans-serif;
            display: block;
            margin-bottom: 8px;
            color: black;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        button {
            font-family: 'MedievalSharp', sans-serif;
            background-color: #4b5320; /* Dark Olive Green */
            color: #f0e68c; /* Light Golden Khaki for text */
            border: 2px solid #3e442b; /* Darker olive border */
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            font-size: 14px;
            text-align: center;
        }

        p {
            text-align: center;
            font-size: 16px;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required><br>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br>

            <button type="submit">Login</button>
            <p>Don't have an account? <a href="register.php">Register here</a></p>

        </form>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    </div>

</body>
</html>

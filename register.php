<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Check if the username is already taken
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->rowCount() > 0) {
        echo "<p class='error'>Username is already taken.</p>";
    } else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->execute([$username, $password, $role]);
        echo "<p class='success'>Registration successful!</p>";
        header("Location: login.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css2?family=MedievalSharp&display=swap" rel="stylesheet">
    <style>
        /* General Styles */
        body {
            
            font-family: 'MedievalSharp', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        /* Container for center alignment */
        .container {
            background-image:url('uploads/merchant_bg.jpg');
            background-size: cover;      
            background-position: center; 
            background-repeat: no-repeat; 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f9;
        }

        .form-container {
            background-image:url('uploads/paper_bg.jpg');
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 400px;
            text-align: center;
        }

        h2 {
            color: #333;
        }

        /* Input Fields */
        input[type="text"], input[type="password"], select {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        button {
            font-family: 'MedievalSharp', sans-serif;
            background-color: #4b5320; /* Dark Olive Green */
            color: #f0e68c; /* Light Golden Khaki for text */
            border: 2px solid #3e442b; /* Darker olive border */
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        button:hover {
            background-color: #45a049;
        }

        /* Success and Error Messages */
        .success {
            color: green;
            margin-top: 20px;
        }

        .error {
            color: red;
            margin-top: 20px;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .form-container {
                width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="form-container">
            <h2>Register</h2>
            <form action="register.php" method="post">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>

                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>

                <label for="role">Role</label>
                <select name="role" id="role" required>
                    <option value="admin">Admin</option>
                    <option value="customer">Customer</option>
                </select>

                <button type="submit">Register</button>
                <p>Already have an account? <a href="login.php">Login here</a></p>
            </form>
        </div>
    </div>

</body>
</html>

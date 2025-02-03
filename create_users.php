<?php
require 'db.php';

// Drop users table if it already exists (use carefully)
$conn->exec("DROP TABLE IF EXISTS users");

// Create users table
$conn->exec("
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'customer') NOT NULL
)");

// Insert sample users with hashed passwords
$adminPassword = password_hash("admin", PASSWORD_DEFAULT);
$customerPassword = password_hash("customer", PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
$stmt->execute(['admin', $adminPassword, 'admin']);
$stmt->execute(['customer', $customerPassword, 'customer']);

echo "Users created successfully!";
?>

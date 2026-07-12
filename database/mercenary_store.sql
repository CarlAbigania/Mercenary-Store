CREATE DATABASE IF NOT EXISTS `shopping_cart_dbb`;
USE `shopping_cart_dbb`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `order_details` text NOT NULL,
  `order_total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`username`, `password`, `role`) VALUES
('admin', '$2y$10$Md7Xs3fZCu5yf9gXTM4SBOBvfWT7LYqg.xd9Efqq/PBw4tYArLlJC', 'admin'),
('customer', '$2y$10$B9q/M8k0XahkA5UBcuc5Ce2QiLzkkGeuoES0M0Pb1Hy1WOmairw02', 'customer');

INSERT INTO `products` (`name`, `price`, `description`, `image`) VALUES
('Iron Sword', 29.99, 'A finely crafted sword for battle.', 'uploads/sword.jpg'),
('Shield of Valor', 39.50, 'A sturdy shield to protect against attacks.', 'uploads/shield.jpg'),
('Healing Potion', 9.99, 'Restores health in an instant.', 'uploads/potion.jpg');

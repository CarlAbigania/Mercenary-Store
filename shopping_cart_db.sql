-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2024 at 05:54 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shopping_cart_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`order_details`)),
  `order_total` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_details`, `order_total`, `created_at`) VALUES
(2, 2, '[{\"product_id\":6,\"name\":\"Makima Plush\",\"price\":\"200.00\",\"quantity\":1,\"subtotal\":200}]', 200.00, '2024-11-13 13:06:35'),
(5, 2, '[{\"product_id\":6,\"name\":\"Makima Plush\",\"price\":\"200.00\",\"quantity\":3,\"subtotal\":600}]', 600.00, '2024-11-13 13:54:19'),
(6, 4, '[{\"product_id\":6,\"name\":\"Makima Plush\",\"price\":\"200.00\",\"quantity\":1,\"subtotal\":200},{\"product_id\":7,\"name\":\"Miku Plush\",\"price\":\"5000.00\",\"quantity\":1,\"subtotal\":5000}]', 5200.00, '2024-11-13 17:56:41'),
(7, 4, '[{\"product_id\":11,\"name\":\"Stand Arrow\",\"price\":\"20000.00\",\"quantity\":1,\"subtotal\":20000},{\"product_id\":12,\"name\":\"Shield of Tate no Y\\u016bsha\",\"price\":\"18000.00\",\"quantity\":1,\"subtotal\":18000},{\"product_id\":13,\"name\":\"The World Ender\",\"price\":\"30000.00\",\"quantity\":1,\"subtotal\":30000}]', 68000.00, '2024-11-14 02:39:13'),
(8, 4, '[{\"product_id\":6,\"name\":\"Makima Plush\",\"price\":\"6000.00\",\"quantity\":1,\"subtotal\":6000},{\"product_id\":10,\"name\":\"Love Potion\",\"price\":\"15000.00\",\"quantity\":1,\"subtotal\":15000}]', 21000.00, '2024-11-14 02:41:36'),
(9, 4, '[{\"product_id\":8,\"name\":\"Souls of the Damned\",\"price\":\"10000.00\",\"quantity\":1,\"subtotal\":10000}]', 10000.00, '2024-11-14 02:42:31'),
(10, 4, '[{\"product_id\":7,\"name\":\"Miku Plush\",\"price\":\"5000.00\",\"quantity\":1,\"subtotal\":5000}]', 5000.00, '2024-11-14 02:43:31'),
(17, 7, '[{\"product_id\":9,\"name\":\"Inferno\'s Edge\",\"price\":\"6000.00\",\"quantity\":1,\"subtotal\":6000},{\"product_id\":12,\"name\":\"Shield of Tate no Y\\u016bsha\",\"price\":\"18000.00\",\"quantity\":1,\"subtotal\":18000}]', 24000.00, '2024-11-14 03:37:33'),
(18, 10, '[{\"product_id\":6,\"name\":\"Makima Plush\",\"price\":\"6000.00\",\"quantity\":1,\"subtotal\":6000},{\"product_id\":7,\"name\":\"Miku Plush\",\"price\":\"5000.00\",\"quantity\":1,\"subtotal\":5000},{\"product_id\":8,\"name\":\"Souls of the Damned\",\"price\":\"10000.00\",\"quantity\":1,\"subtotal\":10000},{\"product_id\":10,\"name\":\"Love Potion\",\"price\":\"15000.00\",\"quantity\":1,\"subtotal\":15000},{\"product_id\":11,\"name\":\"Stand Arrow\",\"price\":\"20000.00\",\"quantity\":1,\"subtotal\":20000},{\"product_id\":12,\"name\":\"Shield of Tate no Y\\u016bsha\",\"price\":\"18000.00\",\"quantity\":1,\"subtotal\":18000},{\"product_id\":13,\"name\":\"The World Ender\",\"price\":\"30000.00\",\"quantity\":1,\"subtotal\":30000}]', 104000.00, '2024-11-14 04:35:09'),
(19, 7, '[{\"product_id\":6,\"name\":\"Makima Plush\",\"price\":\"6000.00\",\"quantity\":1,\"subtotal\":6000},{\"product_id\":7,\"name\":\"Miku Plush\",\"price\":\"5000.00\",\"quantity\":1,\"subtotal\":5000},{\"product_id\":11,\"name\":\"Stand Arrow\",\"price\":\"20000.00\",\"quantity\":1,\"subtotal\":20000}]', 31000.00, '2024-11-14 04:45:17');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `image`) VALUES
(6, 'Makima Plush', 6000.00, 'A deceptively charming and sinister item, imbued with an eerie, otherworldly power that allows its owner to subtly influence minds, control wills, and invoke fear with a single gaze.', 'uploads/makima-bean.jpg'),
(7, 'Miku Plush', 5000.00, 'Amplifies the user\'s creativity, allowing them to summon an ethereal voice capable of controlling soundwaves, manipulating emotions, and altering the very fabric of reality through music.', 'uploads/miku.jpg'),
(8, 'Souls of the Damned', 10000.00, 'Contains the tortured essence of lost souls, bestowing immense power at the cost of one\'s sanity, while whispering their eternal torment.', 'uploads/potion.jpg'),
(9, 'Inferno\'s Edge', 6000.00, ' A cursed sword forged in volcanic fire, scorching all it touches with the fury of hell itself.', 'uploads/evil_sword.jpg'),
(10, 'Love Potion', 15000.00, 'This glowing love potion stirs deep affection and desire in the drinker, binding their heart to the one they cherish.', 'uploads/love_potion.jpg'),
(11, 'Stand Arrow', 20000.00, 'A mysterious, ancient artifact that grants its wielder the ability to awaken a powerful, unique Stand by piercing their body with its deadly, otherworldly tip.', 'uploads/stand_arrow.jpg'),
(12, 'Shield of Tate no Yūsha', 18000.00, 'An indestructible, powerful artifact that grants its wielder the ability to defend against any attack, though it lacks offensive capabilities, forcing its user to rely on strategy and resilience.', 'uploads/shield.jpeg'),
(13, 'The World Ender', 30000.00, 'A massive, bloodthirsty blade imbued with the essence of a fallen god, capable of unleashing devastating slashes that drain life and bring death to all who stand in its path.', 'uploads/aatrox_sword.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2b$12$i0dO/Yz60Z/r8Q6cm2Ed9Opg4tI95kkW1yswKMCvBZkZdgnrP7bxG', 'admin'),
(2, 'customer', '$2b$12$ixWWoKEUwU1MfooQaPym8.oW1zQjfzeOvnMRrDd.LSCE.ARAowtpy', 'customer'),
(3, 'eggy', '$2y$10$WupNpCh49k/4YdwdKmlA5uAw5mlfml0Vzdgl9bgxooLASYfG6JLZ.', 'admin'),
(4, 'Iriz', '$2y$10$WzIz31vuAnmjcn5Xw0TRG.2Z0Il5HczyWnGmImslsFzxe1Mf1QkOa', 'customer'),
(6, 'Chloe', '$2y$10$OmC0O6PuduFUqI5mbcx1UOwd6nnmhVOHFHXnwFT2MAQqvBRkJjS46', 'customer'),
(7, 'Prince', '$2y$10$nYfnJNLFQY/3r2yuEMJkeuZk78N8HBlM6JoKop/snoUxWbvgbB/za', 'customer'),
(9, 'admin2', '$2y$10$E6zwtBnkHzRvL3gauEU/X.x.mRjBXfjk.QtsGuGy9upWwGGPUNrIq', 'admin'),
(10, 'Thristan', '$2y$10$a3lRymUs8cmGnQ/mfOeWVuyH0gwjpYHH1rKlbjaDblaPE3w4Z72ZS', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2026 at 08:32 PM
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
-- Database: `baking_valley`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`) VALUES
(18, 4, 12, 4),
(29, 5, 12, 2),
(30, 5, 9, 1),
(31, 5, 8, 1),
(32, 5, 10, 1),
(33, 5, 5, 1),
(34, 5, 4, 1),
(35, 5, 6, 1),
(36, 5, 14, 1),
(40, 9, 16, 1),
(41, 9, 15, 1),
(51, 1, 17, 1),
(52, 1, 16, 1),
(53, 1, 15, 1),
(57, 15, 16, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `customer_name`, `total_amount`, `status`, `created_at`, `order_date`) VALUES
(1, 7, 'priyonto saha', 500.00, 'Delivered', '2026-01-13 09:51:23', '2026-01-13 18:39:34'),
(2, 7, 'priyonto saha', 500.00, 'Cancelled', '2026-01-13 14:50:35', '2026-01-13 18:39:34'),
(3, 7, 'priyonto saha', 200.00, 'Pending', '2026-01-13 18:16:31', '2026-01-13 18:39:34'),
(4, 7, 'priyonto saha', 600.00, 'Pending', '2026-01-13 18:31:00', '2026-01-13 18:39:34'),
(5, 7, 'priyonto saha', 300.00, 'Pending', '2026-01-13 18:32:02', '2026-01-13 18:39:34'),
(6, 7, 'priyonto saha', 950.00, 'Pending', '2026-01-13 18:36:42', '2026-01-13 18:39:34'),
(7, 7, 'priyonto saha', 35.00, 'Pending', '2026-01-13 18:43:21', '2026-01-13 18:43:21'),
(8, 7, 'priyonto saha', 250.00, 'Pending', '2026-01-13 18:48:13', '2026-01-13 18:48:13'),
(9, 7, 'priyonto saha', 250.00, 'Pending', '2026-01-13 18:48:30', '2026-01-13 18:48:30'),
(10, 4, 'Mostafizur Rahman', 4105.00, 'Delivered', '2026-01-19 11:52:12', '2026-01-19 11:52:12'),
(11, 4, 'Mostafizur Rahman', 600.00, 'Pending', '2026-01-19 12:11:50', '2026-01-19 12:11:50'),
(12, 5, 'Abdur Rauf', 590.00, 'Delivered', '2026-01-19 15:24:39', '2026-01-19 15:24:39'),
(13, 5, 'Abdur Rauf', 180.00, 'Pending', '2026-01-19 15:31:57', '2026-01-19 15:31:57'),
(14, 5, 'Abdur Rauf', 760.00, 'Delivered', '2026-01-19 17:22:14', '2026-01-19 17:22:14'),
(15, 6, 'Abdur Rauf', 200.00, 'Pending', '2026-01-19 19:16:14', '2026-01-19 19:16:14'),
(16, 12, 'Md.Mostafizur Rahman', 1000.00, 'Pending', '2026-01-20 11:55:50', '2026-01-20 11:55:50'),
(17, 12, 'Md.Mostafizur Rahman', 200.00, 'Pending', '2026-01-20 11:57:20', '2026-01-20 11:57:20'),
(18, 12, 'Md.Mostafizur Rahman', 2500.00, 'Pending', '2026-01-20 12:04:15', '2026-01-20 12:04:15'),
(19, 12, 'Md.Mostafizur Rahman', 400.00, 'Pending', '2026-01-20 12:06:29', '2026-01-20 12:06:29'),
(20, 12, 'Md.Mostafizur Rahman', 200.00, 'Delivered', '2026-01-20 12:12:47', '2026-01-20 12:12:47'),
(21, 14, 'Md.Mostafizur Rahman', 1000.00, 'Pending', '2026-01-20 18:22:41', '2026-01-20 18:22:41'),
(22, 15, 'estiak', 700.00, 'Delivered', '2026-01-20 18:28:54', '2026-01-20 18:28:54');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 11, 6, 1, 600.00),
(2, 12, 10, 4, 35.00),
(3, 12, 14, 2, 200.00),
(4, 12, 12, 1, 50.00),
(5, 13, 12, 2, 50.00),
(6, 13, 13, 1, 80.00),
(7, 14, 12, 1, 50.00),
(8, 14, 13, 2, 80.00),
(9, 14, 14, 1, 200.00),
(10, 14, 15, 1, 200.00),
(11, 14, 9, 1, 150.00),
(12, 15, 14, 1, 200.00),
(13, 16, 14, 3, 200.00),
(14, 16, 15, 2, 200.00),
(15, 17, 14, 1, 200.00),
(16, 18, 14, 1, 200.00),
(17, 18, 17, 3, 600.00),
(18, 18, 16, 1, 500.00),
(19, 19, 15, 1, 200.00),
(20, 19, 14, 1, 200.00),
(21, 20, 14, 1, 200.00),
(22, 21, 16, 2, 500.00),
(23, 22, 16, 1, 500.00),
(24, 22, 15, 1, 200.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price`, `stock`, `image`) VALUES
(5, 'Cake Mold', 'Tools', 300.00, 25, 'cakemold.jpeg'),
(6, 'Cake Board', 'Tools', 600.00, 30, 'cakeboard.jpeg'),
(7, 'Silicone Brash', 'Tools', 100.00, 40, 'sliconbrush.jpeg'),
(8, 'Silicone Spatula', 'Tools', 100.00, 25, 'sliconspatula.jpeg'),
(9, ' Butter Knife', 'Tools', 150.00, 15, 'butterknife.jpeg'),
(10, 'Nozzle', 'Tools', 35.00, 100, 'nojel.webp'),
(11, 'Piping Bag', 'Tools', 170.00, 260, 'pipingbag.jpeg'),
(12, 'Rose Stand', 'Tools', 50.00, 140, 'rosestand.jpg'),
(13, 'Kitchen Scale', 'Tools', 80.00, 130, 'kitchenscale.webp'),
(14, 'Corn Flour', 'Cream', 200.00, 50, 'cornflour.jpeg'),
(15, 'Turn Table', 'Tools', 200.00, 150, 'turntable.jpeg'),
(16, 'Chocolate Cake', 'Cake', 500.00, 20, '1768854640_chocolate.jpg'),
(17, 'Vanilla Cake', 'Cake', 600.00, 25, '1768854674_Vanilla.webp');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Customer') NOT NULL DEFAULT 'Customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Main Admin', 'admin1@gmail.com', 'admin1234', 'Admin', '2026-01-17 09:33:04'),
(8, 'Md.Mostafizur Rahman', 'mostafizurrahman711@gmail.com', '12345', 'Customer', '2026-01-19 19:35:56'),
(9, 'mostafiz', 'mostafiz11@gmail.com', '123456', 'Customer', '2026-01-19 19:37:04'),
(10, 'Mostafizur Rahman', 'mostafizur11@gmail.com', '1234', 'Customer', '2026-01-20 09:58:11'),
(11, 'Md.Mostafizur Rahman', 'mostafizurrahman7023@gmail.com', '123456', 'Customer', '2026-01-20 10:16:18'),
(12, 'Md.Mostafizur Rahman', 'mos11@gmail.com', '1234', 'Customer', '2026-01-20 10:23:50'),
(13, 'raju', 'raju1@gmail.com', '1234', 'Customer', '2026-01-20 11:31:26'),
(14, 'Md.Mostafizur Rahman', 'mostafizz@gmail.com', '1234', 'Customer', '2026-01-20 18:03:17'),
(15, 'estiak', 'estiak1@gmail.com', '1234', 'Customer', '2026-01-20 18:27:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

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
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

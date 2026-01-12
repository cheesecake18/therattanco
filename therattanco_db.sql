-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2026 at 05:30 AM
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
-- Database: `therattanco_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `item_id` int(11) NOT NULL,
  `item` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`item_id`, `item`, `category`, `image`, `price`, `description`) VALUES
(1, 'Bali Luna Bag', 'Bags', '/therattanco/images/product2.png', 3830, 'Circular Crossbody'),
(2, 'Voyager Market Tote', 'Bags', '/therattanco/images/product3.png', 5010, 'Large Structured Tote'),
(3, 'Atoll Petite Bag', 'Bags', '/therattanco/images/product4.png', 3480, 'Small Structured Crossbody'),
(4, 'Solstice Clutch', 'Clutches', '/therattanco/images/product5.png', 2650, 'Half-Moon Clutch'),
(5, 'Coastal Picnic Basket', 'Baskets', '/therattanco/images/product6.png', 5600, 'Large Top Handle Basket'),
(6, 'Lombok Pouch', 'Clutches', '/therattanco/images/product7.png', 2300, 'Flat Envelope Clutch'),
(7, 'Bintan Barrel Bag', 'Bags', '/therattanco/images/product8.png', 4130, 'Small Cylinder Bag'),
(8, 'Artisan Box Bag', 'Clutches', '/therattanco/images/product9.png', 3240, 'Woven Box Clutch');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `default_province` varchar(255) DEFAULT NULL,
  `default_city` varchar(255) DEFAULT NULL,
  `default_barangay` varchar(255) DEFAULT NULL,
  `default_street` varchar(255) DEFAULT NULL,
  `last_payment` varchar(50) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `alt_province` varchar(255) DEFAULT NULL,
  `alt_city` varchar(255) DEFAULT NULL,
  `alt_barangay` varchar(255) DEFAULT NULL,
  `alt_street` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `default_province`, `default_city`, `default_barangay`, `default_street`, `last_payment`, `contact`, `alt_province`, `alt_city`, `alt_barangay`, `alt_street`, `first_name`, `last_name`) VALUES
(1, 'Cheska', 'jalotjot.cheska@icloud.com', '$2y$10$tB7SQNjmdvkIKrvdD9LApO3EIW30d3aOhnUUaGsWe8EJ.s1m3lKD6', '2025-11-21 13:09:22', 'bulacan', 'san jose del monte', 'gaya-gaya', 'phase 6C', 'gcash', '09941813832', NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

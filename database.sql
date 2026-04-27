-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Apr 27, 2026 at 07:52 AM
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
-- Database: `tours_travels`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'dhyani001', 'dhyani@001', '2025-08-26 08:21:55'),
(3, 'arpita002', 'arpita@002', '2025-10-05 07:22:52');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `package_id`, `booking_date`, `status`) VALUES
(3, 4, 4, '2025-10-03 16:33:01', 'confirmed'),
(8, 4, 5, '2025-10-06 08:28:30', 'confirmed'),
(11, 4, 8, '2025-11-16 07:14:54', 'confirmed'),
(12, 4, 4, '2025-11-16 08:29:37', 'confirmed'),
(13, 4, 4, '2025-11-17 03:55:22', 'pending'),
(14, 4, 5, '2025-11-17 03:57:11', 'pending'),
(15, 4, 4, '2025-11-17 03:59:32', 'confirmed'),
(16, 4, 4, '2025-11-17 04:18:32', 'confirmed');

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

CREATE TABLE `destinations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `location` varchar(255) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`id`, `name`, `description`, `location`, `price`, `image`, `created_at`) VALUES
(1, 'Goa Beach', 'A beautiful beach destination in south goa', 'Goa', 5000.00, '1756201109_pic1.jpg', '2025-08-26 09:38:29'),
(4, 'Manali Adventure Trip', 'Himalayan adventures with skiing, rafting, and trekking.', 'Himachal Pradesh', 15000.00, '1759591004_manali1.jpg', '2025-10-04 15:16:44'),
(5, 'Rajasthan Royal Tour', 'Visit forts, palaces, and desert experiences.', 'Rajasthan', 10000.00, '1759591190_rajasthan1.jpg', '2025-10-04 15:19:50');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `destination_id` int(11) DEFAULT NULL,
  `package_name` varchar(150) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `duration` varchar(100) NOT NULL,
  `details` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `destination_id`, `package_name`, `price`, `duration`, `details`) VALUES
(4, 1, 'Goa Adventure Trip', 15000.00, '5 days 4 nights', 'Includes trekking, river rafting, dolphin spotting, beach parties, and guided sightseeing of Goa’s forts and markets.'),
(5, 1, 'Goa Adventure Package', 18000.00, '6 Days/5 Nights', 'Parasailing, scuba diving, trekking, and offbeat adventure activities'),
(8, 5, 'Rajasthan Royal Tour', 20000.00, '6 Days/5 Nights', 'Jaipur, Udaipur, Jodhpur – forts, palaces, and royal experiences.');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_status` enum('pending','completed','failed') DEFAULT 'pending',
  `payment_method` enum('card','upi','netbanking','cash') DEFAULT 'card'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `booking_id`, `amount`, `payment_date`, `payment_status`, `payment_method`) VALUES
(2, 3, 15000.00, '2025-10-03 16:33:29', 'completed', 'netbanking'),
(11, 11, 20000.00, '2025-11-16 07:15:03', 'completed', 'netbanking'),
(12, 11, 20000.00, '2025-11-16 07:19:15', 'completed', 'netbanking'),
(13, 12, 15000.00, '2025-11-16 08:33:57', 'completed', 'card'),
(14, 12, 15000.00, '2025-11-16 08:34:16', 'completed', 'upi'),
(15, 12, 15000.00, '2025-11-16 08:34:28', 'completed', 'netbanking'),
(16, 12, 15000.00, '2025-11-16 08:34:39', 'completed', 'cash'),
(17, 12, 15000.00, '2025-11-16 08:36:16', 'completed', 'cash'),
(18, 15, 15000.00, '2025-11-17 03:59:59', 'completed', 'card'),
(19, 16, 15000.00, '2025-11-17 04:18:46', 'completed', 'upi'),
(20, 16, 15000.00, '2025-11-17 04:19:01', 'completed', 'upi');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `created_at`) VALUES
(4, 'army patel', 'armypatel@gmail.com', 'army001', '$2y$10$b/N/iGdeO30LrPyi3Z2DdeNNoQ1J/Ul3qC4kg8LH0hHb9LSJxEONe', '2025-10-03 06:02:39'),
(7, 'kavya patel', 'kavya@gmail.com', 'kavya002', '$2y$10$fc1U4mm36xH9L0T25j9bKOsM7keHhTXmkDJtbsfPNmqMMYIeYUOQu', '2025-10-05 07:26:06'),
(8, 'ronak patel', 'ronak@gmail.com', 'ronak003', '$2y$10$Ov1OhdTSKHC3WYxZAB18yumRIS6VxDIDMHWsdxKjTY/0YS0zFeTXS', '2025-10-05 07:31:57'),
(9, 'priya chaudhary', 'priyachaudhary30@gmail.com', 'priya004', '$2y$10$IR9Iv/e2SWTFSJUrVVsmmeG7dcVCFvUNjeOkocmxiVZQNjItMZYIm', '2025-10-05 07:33:32'),
(10, 'brijesh patel', 'brijesh@gmail.com', 'brijesh005', '$2y$10$fxCYZGNfOqEI1UpSnAkdHOu/Ql9B3nM1IiiyvFpuAo.I/EM/Fbbs2', '2025-10-05 07:34:55'),
(11, 'Rihana joshi', 'rihana56@gmail.com', 'rihana009', '$2y$10$XIm8yuDoXoMNEXTxubriYuy/UP77V.jvDvOJQoYJ3CJJUs/ud7Fwe', '2025-11-16 06:58:11'),
(12, 'mohan patel', 'mohan45@gmail.com', 'mohan10', '$2y$10$IJaWyrEfbQSTMRrCiuuUMen.BnIZuecc0p/6Sx52mPCYqO6TDFeO6', '2025-11-16 06:59:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `package_id` (`package_id`);

--
-- Indexes for table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `packages_ibfk_1` (`destination_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`);

--
-- Constraints for table `packages`
--
ALTER TABLE `packages`
  ADD CONSTRAINT `packages_ibfk_1` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

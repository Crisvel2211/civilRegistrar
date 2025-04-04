-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2025 at 09:38 AM
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
-- Database: `civilregistrar`
--

-- --------------------------------------------------------

--
-- Table structure for table `permit_requests`
--

CREATE TABLE `permit_requests` (
  `id` int(11) NOT NULL,
  `reference_number` varchar(50) NOT NULL,
  `permit_type` enum('exhumation','burial','cremation') NOT NULL,
  `resident_name` varchar(255) NOT NULL,
  `date_of_request` date NOT NULL,
  `additional_details` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `status` enum('pending','processing','completed') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permit_requests`
--

INSERT INTO `permit_requests` (`id`, `reference_number`, `permit_type`, `resident_name`, `date_of_request`, `additional_details`, `created_at`, `user_id`, `employee_id`, `status`) VALUES
(1, 'PR-FEA44DB7', 'burial', 'John Doe', '2025-04-01', 'Urgent request', '2025-04-01 11:13:31', 310, 302, 'pending'),
(2, 'PR-E547456F', 'burial', 'John Doe', '2025-04-01', 'Urgent request', '2025-04-03 03:13:36', 310, 302, 'pending'),
(3, 'PR-501B9DEF', 'cremation', 'ksnkkdsnkf', '2025-04-19', 'ksafjdiosjfojdjog', '2025-04-03 03:28:58', 312, 310, 'pending'),
(4, 'PR-FB130BE1', 'cremation', 'anoygodd', '2025-04-21', 'snknskldnfdlkds', '2025-04-03 03:30:50', 312, 310, 'pending');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `permit_requests`
--
ALTER TABLE `permit_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reference_number` (`reference_number`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `permit_requests`
--
ALTER TABLE `permit_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `permit_requests`
--
ALTER TABLE `permit_requests`
  ADD CONSTRAINT `permit_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `permit_requests_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

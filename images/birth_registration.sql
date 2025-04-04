-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2025 at 04:41 AM
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
-- Table structure for table `birth_registration`
--

CREATE TABLE `birth_registration` (
  `id` int(11) NOT NULL,
  `child_first_name` varchar(255) NOT NULL,
  `child_last_name` varchar(255) NOT NULL,
  `child_middle_name` varchar(255) NOT NULL,
  `child_sex` enum('male','female') NOT NULL,
  `child_date_of_birth` date NOT NULL,
  `child_time_of_birth` time NOT NULL,
  `child_place_of_birth` varchar(255) NOT NULL,
  `child_birth_type` enum('single','twin','triplet','other') NOT NULL,
  `child_birth_order` enum('first','second','third','other') NOT NULL,
  `father_first_name` varchar(255) NOT NULL,
  `father_last_name` varchar(255) NOT NULL,
  `father_middle_name` varchar(255) NOT NULL,
  `father_suffix` varchar(255) NOT NULL,
  `father_nationality` varchar(255) NOT NULL,
  `father_date_of_birth` date NOT NULL,
  `father_place_of_birth` varchar(255) NOT NULL,
  `mother_first_name` varchar(255) NOT NULL,
  `mother_last_name` varchar(255) NOT NULL,
  `mother_middle_name` varchar(255) NOT NULL,
  `mother_maiden_name` varchar(255) NOT NULL,
  `mother_nationality` varchar(255) NOT NULL,
  `mother_date_of_birth` date NOT NULL,
  `mother_place_of_birth` varchar(255) NOT NULL,
  `parents_married_at_birth` enum('yes','no') NOT NULL,
  `userId` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `status` enum('pending','processing','verified','completed') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reference_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `birth_registration`
--

INSERT INTO `birth_registration` (`id`, `child_first_name`, `child_last_name`, `child_middle_name`, `child_sex`, `child_date_of_birth`, `child_time_of_birth`, `child_place_of_birth`, `child_birth_type`, `child_birth_order`, `father_first_name`, `father_last_name`, `father_middle_name`, `father_suffix`, `father_nationality`, `father_date_of_birth`, `father_place_of_birth`, `mother_first_name`, `mother_last_name`, `mother_middle_name`, `mother_maiden_name`, `mother_nationality`, `mother_date_of_birth`, `mother_place_of_birth`, `parents_married_at_birth`, `userId`, `employee_id`, `status`, `created_at`, `reference_number`) VALUES
(197, 'Lance', 'Sanchez', 'Abastillas', 'male', '0001-03-02', '15:04:00', 'SKSD', 'single', 'second', 'hjvv', 'hgyyuvuy', 'hjj', 'yuguyyu', 'ugyuuy', '0003-03-02', 'mbuigui', 'ugugiu', 'ugugug', 'ftftyf', 't7r76tyi', 'uyfytf', '0006-05-03', 'gugiu', 'yes', 312, 310, 'pending', '2025-04-03 12:49:56', 'BR-67EE83F499B1C'),
(198, 'stuusdfu', 'ufyufy', 'uyuyfy', 'male', '0005-03-04', '15:04:00', 'cffhvh', 'single', 'second', 'chvhgjhvmn', 'hghgh', 'ftftyfjhg', 'gfyhm', 'yudytfy', '0004-03-02', 'htfh', 'yftyuguyj', 'gyuguy', 'gyugj', 'fyhgyu', 'gyuguy', '0002-03-02', 'iulyuguyg', 'yes', 312, 310, 'pending', '2025-04-03 12:59:00', 'BR-67EE8614B436F');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `birth_registration`
--
ALTER TABLE `birth_registration`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reference_number` (`reference_number`),
  ADD KEY `userId` (`userId`),
  ADD KEY `employee_id` (`employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `birth_registration`
--
ALTER TABLE `birth_registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

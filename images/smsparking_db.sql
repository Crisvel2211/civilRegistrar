-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2025 at 01:27 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smsparking_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `booked_parking_admin_tbl`
--

CREATE TABLE `booked_parking_admin_tbl` (
  `id` int(11) NOT NULL,
  `transaction_ID` varchar(255) NOT NULL,
  `vehicle_info` varchar(255) NOT NULL,
  `parking_date` date NOT NULL,
  `parking_time` varchar(255) NOT NULL,
  `payment_mode` varchar(255) NOT NULL,
  `owner_name` varchar(255) DEFAULT NULL,
  `user_pass` varchar(255) DEFAULT NULL,
  `plate_no` varchar(255) DEFAULT NULL,
  `parking_slot_no` int(11) NOT NULL,
  `book_reference_link` varchar(255) DEFAULT NULL,
  `book_reference_code` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) NOT NULL,
  `purpose` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booked_parking_admin_tbl`
--

INSERT INTO `booked_parking_admin_tbl` (`id`, `transaction_ID`, `vehicle_info`, `parking_date`, `parking_time`, `payment_mode`, `owner_name`, `user_pass`, `plate_no`, `parking_slot_no`, `book_reference_link`, `book_reference_code`, `payment_status`, `purpose`) VALUES
(36, 'WI-240320250841PM', 'YAMAHA NMAX 155 2023 - ABC1234', '2025-03-24', '7:38 PM', 'CASH', 'MIGUELITO MALAKAS', NULL, 'ABC1234', 42, NULL, NULL, 'WI - VISITOR', NULL),
(37, 'AL-240320250845PM', 'HONDA KICK 2022', '2025-03-24', '3:43 PM', 'CASH', 'SAMPLE VISITOR', NULL, 'TEXT1234', 43, NULL, NULL, 'AL - VISITOR', NULL),
(38, 'OL-240320250321PM', 'SUZUKI SMASH 115 2019 - XYZ2313', '2025-03-24', '6:00 am', 'ONLINE', 'JUAN DELA CRUZ', 'testadmin', 'XYZ2313', 44, 'https://pm.link/org-QxSea2x43uEdYc2Haw5Xkkow/test/9iai1ns', '9iai1ns', 'PAID', NULL),
(43, 'AL-010420250741AM', 'MOTORSTAR 100 2010', '2025-04-01', '5:00 pm', 'CASH', 'TEST1', NULL, 'TEXT3333', 42, NULL, NULL, 'CHECKOUT', NULL),
(44, 'AL-010420250750AM', 'SKYGO WAMPIPTI 120', '2025-04-01', '6:00 am', 'CASH', 'TEST2', NULL, 'GHJ1223', 42, NULL, NULL, 'CHECKOUT', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `parking_slot_tbl`
--

CREATE TABLE `parking_slot_tbl` (
  `id` int(11) NOT NULL,
  `slot_number` int(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parking_slot_tbl`
--

INSERT INTO `parking_slot_tbl` (`id`, `slot_number`, `status`) VALUES
(1, 1, 'VIP0'),
(2, 2, 'VIP0'),
(3, 3, 'VIP0'),
(4, 4, 'VIP0'),
(5, 5, 'VIP0'),
(6, 6, 'VIP0'),
(7, 7, 'VIP0'),
(8, 8, 'VIP0'),
(9, 9, 'VIP0'),
(10, 10, 'VIP0'),
(11, 11, 'VIP0'),
(12, 12, 'VIP0'),
(13, 13, 'VIP0'),
(14, 14, 'VIP0'),
(15, 15, 'VIP0'),
(16, 16, 'VIP0'),
(17, 17, 'VIP0'),
(18, 18, 'VIP0'),
(19, 19, 'VIP0'),
(20, 20, 'VIP0'),
(21, 21, 'VIP0'),
(22, 22, 'VIP0'),
(23, 23, 'VIP0'),
(24, 24, 'VIP0'),
(25, 25, 'VIP0'),
(26, 26, 'VIP0'),
(27, 27, 'VIP0'),
(28, 28, 'VIP0'),
(29, 29, 'VIP0'),
(30, 30, 'VIP0'),
(31, 31, 'VIP0'),
(32, 32, 'VIP0'),
(33, 33, 'VIP0'),
(34, 34, 'VIP0'),
(35, 35, 'VIP0'),
(36, 36, 'VIP0'),
(37, 37, 'VIP0'),
(38, 38, 'VIP0'),
(39, 39, 'VIP0'),
(40, 40, 'VIP0'),
(41, 41, 'VIP0'),
(42, 42, 'VACANT'),
(43, 43, 'VACANT'),
(44, 44, 'VACANT'),
(45, 45, 'VACANT'),
(46, 46, 'VACANT'),
(47, 47, 'VACANT'),
(48, 48, 'VACANT'),
(49, 49, 'VACANT'),
(50, 50, 'VACANT'),
(51, 51, 'VACANT'),
(52, 52, 'VACANT'),
(54, 54, 'VACANT'),
(55, 55, 'VACANT'),
(56, 56, 'VACANT'),
(57, 57, 'VACANT'),
(58, 58, 'VACANT'),
(59, 59, 'VACANT'),
(60, 60, 'VACANT'),
(61, 61, 'VACANT'),
(62, 62, 'VACANT'),
(63, 63, 'VACANT'),
(64, 64, 'VACANT'),
(65, 65, 'VACANT'),
(66, 66, 'VACANT'),
(67, 67, 'VACANT'),
(68, 68, 'VACANT'),
(69, 69, 'VACANT'),
(70, 70, 'VACANT'),
(71, 71, 'VACANT'),
(72, 72, 'VACANT'),
(73, 73, 'VACANT'),
(74, 74, 'VACANT'),
(75, 75, 'VACANT'),
(76, 76, 'VACANT'),
(77, 77, 'VACANT'),
(78, 78, 'VACANT'),
(79, 79, 'VACANT'),
(80, 80, 'VACANT'),
(81, 81, 'VACANT'),
(82, 82, 'VACANT'),
(83, 83, 'VACANT'),
(84, 84, 'VACANT'),
(85, 85, 'VACANT'),
(86, 86, 'VACANT'),
(87, 87, 'VACANT'),
(88, 88, 'VACANT'),
(89, 89, 'VACANT'),
(90, 90, 'VACANT'),
(91, 91, 'VACANT'),
(92, 92, 'VACANT'),
(93, 93, 'VACANT'),
(94, 94, 'VACANT'),
(95, 95, 'VACANT'),
(96, 96, 'VACANT'),
(97, 97, 'VACANT'),
(98, 98, 'VACANT'),
(99, 99, 'VACANT'),
(100, 100, 'VACANT'),
(101, 101, 'VACANT'),
(102, 102, 'VACANT'),
(103, 103, 'VACANT'),
(104, 104, 'VACANT'),
(105, 105, 'VACANT'),
(106, 106, 'VACANT'),
(107, 107, 'VACANT'),
(108, 108, 'VACANT'),
(109, 109, 'VACANT'),
(110, 110, 'VACANT'),
(111, 111, 'VACANT'),
(112, 112, 'VACANT'),
(113, 113, 'VACANT'),
(114, 114, 'VACANT'),
(115, 115, 'VACANT'),
(116, 116, 'VACANT'),
(117, 117, 'VACANT'),
(118, 118, 'VACANT'),
(119, 119, 'VACANT'),
(120, 120, 'VACANT'),
(121, 121, 'VACANT'),
(122, 122, 'VACANT'),
(123, 123, 'VACANT'),
(124, 124, 'VACANT'),
(125, 125, 'VACANT'),
(126, 126, 'VACANT'),
(127, 127, 'VACANT'),
(128, 128, 'VACANT'),
(129, 129, 'VACANT'),
(130, 130, 'VACANT'),
(131, 131, 'VACANT'),
(132, 132, 'VACANT'),
(133, 133, 'VACANT'),
(134, 134, 'VACANT'),
(135, 135, 'VACANT');

-- --------------------------------------------------------

--
-- Table structure for table `premium_application`
--

CREATE TABLE `premium_application` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `vehicleinfo` varchar(255) NOT NULL,
  `vehicletype` varchar(255) NOT NULL,
  `plateno` varchar(255) NOT NULL,
  `vehiclecolor` varchar(255) NOT NULL,
  `vehicle_img` varchar(255) NOT NULL,
  `orcr_img` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `dateapproved` varchar(255) DEFAULT NULL,
  `payment_url` varchar(255) DEFAULT NULL,
  `refcode` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `premium_application`
--

INSERT INTO `premium_application` (`id`, `name`, `vehicleinfo`, `vehicletype`, `plateno`, `vehiclecolor`, `vehicle_img`, `orcr_img`, `status`, `dateapproved`, `payment_url`, `refcode`) VALUES
(6, 'JUAN DELA CRUZ', 'HONDA CLICK 125 V2 BLACK 2019', 'MOTORCYCLE', 'TES1234', 'BLACK', 'certificate.png', 'logo.png', 'REGISTERED', '2025/03/21 11:44 pm', 'https://pm.link/org-QxSea2x43uEdYc2Haw5Xkkow/test/oETJAgM', 'oETJAgM'),
(7, 'JUAN DELA CRUZ', 'KAWASAKI NINJA 400', 'MOTORCYCLE', 'ABS3333', 'GREEN', 'gold-stevie-awards-2024.jpg', 'dilg-pcf-logo.png', 'REGISTERED', '2025/03/24 10:16 pm', 'https://pm.link/org-QxSea2x43uEdYc2Haw5Xkkow/test/1MUD54a', '1MUD54a');

-- --------------------------------------------------------

--
-- Table structure for table `reports_tbl`
--

CREATE TABLE `reports_tbl` (
  `id` int(11) NOT NULL,
  `caseID` varchar(255) NOT NULL,
  `filer_username` varchar(255) NOT NULL,
  `filer_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `datetimerep` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports_tbl`
--

INSERT INTO `reports_tbl` (`id`, `caseID`, `filer_username`, `filer_name`, `description`, `datetimerep`, `status`, `remarks`) VALUES
(6, 'SAMPLE', 'TEST', 'TEST REPORT', 'TEST HAS FILED A REPORT', '2025/03/23 4:00pm', 'UNRESOLVED', 'test1');

-- --------------------------------------------------------

--
-- Table structure for table `users_tbl`
--

CREATE TABLE `users_tbl` (
  `id` int(11) NOT NULL,
  `user_fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_vehicle_info` varchar(255) DEFAULT NULL,
  `user_vehicle_type` varchar(255) DEFAULT NULL,
  `user_vehicle_color` varchar(255) DEFAULT NULL,
  `user_plate_no` varchar(255) DEFAULT NULL,
  `user_username` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_pass_type` varchar(255) DEFAULT NULL,
  `user_type` varchar(255) NOT NULL,
  `otp` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_tbl`
--

INSERT INTO `users_tbl` (`id`, `user_fullname`, `email`, `user_vehicle_info`, `user_vehicle_type`, `user_vehicle_color`, `user_plate_no`, `user_username`, `user_password`, `user_pass_type`, `user_type`, `otp`) VALUES
(1, 'JUAN DELA CRUZ', 'putyouremailhere@gmail.com', 'HONDA CLICK 125 V2 BLACK 2019', 'MOTORCYCLE', 'BLACK', 'TES1234', 'jdelacruz', 'testadmin', 'REGISTERED', 'STUDENT', 'NULL'),
(2, 'TEST TEST', 'thiandysclayde20@gmail.com', 'YAMAHA NMAX 155 V2 BLACK', 'MOTORCYCLE', 'GRAY', 'SAM1234', 'testsamp', '1234', 'NO STICKER', 'EMPLOYEE', 'xwED7l5177'),
(3, 'JUAN DELA CRUZ', 'putyouremailhere@gmail.com', 'SUZUKI SMASH 115 2019', 'MOTORCYCLE', 'BLACK', 'XYZ2313', 'jdelacruz', 'testadmin', 'NO STICKER', 'STUDENT', 'NULL'),
(4, 'ADMIN SAMPLE', '', NULL, NULL, NULL, NULL, 'admin', 'testadmin', NULL, 'ADMIN', NULL),
(8, 'JUAN DELA CRUZ', 'putyouremailhere@gmail.com', 'KAWASAKI NINJA 400', 'MOTORCYCLE', 'GREEN', 'ABS3333', 'jdelacruz', 'testadmin', 'REGISTERED', 'STUDENT', 'NULL');

-- --------------------------------------------------------

--
-- Table structure for table `vip_ticket_tbl`
--

CREATE TABLE `vip_ticket_tbl` (
  `id` int(11) NOT NULL,
  `transaction_ID` varchar(255) NOT NULL,
  `vehicle_info` varchar(255) NOT NULL,
  `parkingdate` varchar(255) NOT NULL,
  `parkingtime` varchar(255) NOT NULL,
  `plateno` varchar(255) NOT NULL,
  `slotno` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `status_req` varchar(255) NOT NULL,
  `purpose` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booked_parking_admin_tbl`
--
ALTER TABLE `booked_parking_admin_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parking_slot_tbl`
--
ALTER TABLE `parking_slot_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `premium_application`
--
ALTER TABLE `premium_application`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports_tbl`
--
ALTER TABLE `reports_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_tbl`
--
ALTER TABLE `users_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vip_ticket_tbl`
--
ALTER TABLE `vip_ticket_tbl`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booked_parking_admin_tbl`
--
ALTER TABLE `booked_parking_admin_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `parking_slot_tbl`
--
ALTER TABLE `parking_slot_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `premium_application`
--
ALTER TABLE `premium_application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `reports_tbl`
--
ALTER TABLE `reports_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users_tbl`
--
ALTER TABLE `users_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `vip_ticket_tbl`
--
ALTER TABLE `vip_ticket_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

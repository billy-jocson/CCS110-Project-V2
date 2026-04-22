-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2026 at 05:33 PM
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
-- Database: `company_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `dept_id` int(11) NOT NULL,
  `dept_name` varchar(255) NOT NULL,
  `dept_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`dept_id`, `dept_name`, `dept_code`) VALUES
(1, 'Human Resources', 'HR'),
(2, 'IT Department', 'IT'),
(3, 'Finance', 'FIN'),
(4, 'Marketing', 'MKT'),
(5, 'Operations', 'OPS');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `contact_no` int(20) NOT NULL,
  `position` varchar(255) NOT NULL,
  `is_resigned` tinyint(1) NOT NULL COMMENT 'inadd q toh para d na natin im-move ung user sa new table pag resigned na sya\r\n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `dept_id`, `user_id`, `first_name`, `last_name`, `contact_no`, `position`, `is_resigned`) VALUES
(1, 1, 1, 'Billy John', 'Jocson', 2147483647, '123', 1),
(2, 1, 3, 'Spongebob', 'Squarepants', 999, 'Krusty Krab Worker', 0),
(3, 2, 4, 'Noel', 'Mercadal', 999, 'Backend Developer', 0),
(4, 2, 5, 'VINCENT LEMUEL', 'MANDAP', 2147483647, 'Admin', 0),
(5, 2, 6, 'VinzeL', 'Limwell', 923232323, 'Admin', 0);

-- --------------------------------------------------------

--
-- Table structure for table `resignation_request`
--

CREATE TABLE `resignation_request` (
  `resign_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `resignation_letter` varchar(1000) DEFAULT NULL,
  `request_date` date NOT NULL DEFAULT current_timestamp(),
  `desired_date` date NOT NULL COMMENT 'kung kelan nya gusto',
  `status` tinyint(4) NOT NULL COMMENT '0=pending 1=approved 2= rejected'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resignation_request`
--

INSERT INTO `resignation_request` (`resign_id`, `employee_id`, `resignation_letter`, `request_date`, `desired_date`, `status`) VALUES
(1, 1, 'I am moving to a new city.', '2026-04-19', '2026-05-20', 1),
(2, 2, 'Pursuing higher education.', '2026-04-19', '2026-06-01', 2),
(3, 3, 'Career change into tech.', '2026-04-19', '2026-05-15', 2),
(4, 4, 'Career change into tech.', '2026-04-20', '2026-05-15', 2),
(5, 5, '../upload/ITEW2-Week-16-Finals-Laboratory-Exercise-2-2ITB-Group-3.pdf', '2026-04-22', '0033-04-04', 0);

-- --------------------------------------------------------

--
-- Table structure for table `salary_history`
--

CREATE TABLE `salary_history` (
  `employee_id` int(11) NOT NULL,
  `salary_id` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `salary_amount` decimal(10,2) DEFAULT NULL,
  `history_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary_structure`
--

CREATE TABLE `salary_structure` (
  `salary_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `base_pay` decimal(10,2) DEFAULT NULL,
  `bonus` decimal(10,2) DEFAULT NULL,
  `deduction` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salary_structure`
--

INSERT INTO `salary_structure` (`salary_id`, `employee_id`, `base_pay`, `bonus`, `deduction`) VALUES
(4, 2, 25000.00, 1500.00, 500.00),
(5, 3, 32000.00, 2000.00, 750.00),
(6, 4, 28500.00, 1200.00, 600.00),
(7, 5, 25000.00, 1500.00, 500.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_link` varchar(255) NOT NULL COMMENT 'dko knows ung profile link kaya naka varchar sya',
  `is_admin` tinyint(1) NOT NULL,
  `is_paid` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `password`, `profile_link`, `is_admin`, `is_paid`) VALUES
(1, 'admin', '$2y$10$skaxOtESM99Dkss5XabmTupFKOX.ugz9df929o0XwpDfwtnhgGmKK', '../assets/images/userProfiles/Art Appreciation Assignment.png', 1, 0),
(3, 'spongebob123', '$2y$10$xWYH7jlPkUhPTsBSEsUzf.1AYevG577NaRR/tSj9l/C0LWKwOI2Ry', '../assets/images/userProfiles/Character.png', 0, 1),
(4, 'noelensaymada', '$2y$10$RAi00hEkqERwdYozf67Sq.K3Gg9ZFg.aUStGce3Q4TxAHNLz8lBpy', '../assets/images/userProfiles/John Doe.jpg', 0, 1),
(5, 'vinzel', '$2y$10$lMDts67k.aWkAEvmX5J5r.Nyc3dFrEXpzSXCWdnMGXN1fHESOrrh6', '../assets/images/userProfiles/WIN_20251101_01_47_33_Pro.jpg', 0, 1),
(6, 'riladmin', '$2y$10$IMBwG7n/XGbtEB4N4YP8mO4.TzuN5DynKKJkjU4mWU.k0Ylk09wKi', '../assets/images/userProfiles/WIN_20260317_10_35_19_Pro.jpg', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`),
  ADD KEY `dept_id` (`dept_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `resignation_request`
--
ALTER TABLE `resignation_request`
  ADD PRIMARY KEY (`resign_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `salary_history`
--
ALTER TABLE `salary_history`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `salary_structure`
--
ALTER TABLE `salary_structure`
  ADD PRIMARY KEY (`salary_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `index_user_name` (`user_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `resignation_request`
--
ALTER TABLE `resignation_request`
  MODIFY `resign_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `salary_history`
--
ALTER TABLE `salary_history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salary_structure`
--
ALTER TABLE `salary_structure`
  MODIFY `salary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `employees_ibfk_2` FOREIGN KEY (`dept_id`) REFERENCES `departments` (`dept_id`);

--
-- Constraints for table `resignation_request`
--
ALTER TABLE `resignation_request`
  ADD CONSTRAINT `resignation_request_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`);

--
-- Constraints for table `salary_history`
--
ALTER TABLE `salary_history`
  ADD CONSTRAINT `salary_history_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`);

--
-- Constraints for table `salary_structure`
--
ALTER TABLE `salary_structure`
  ADD CONSTRAINT `salary_structure_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

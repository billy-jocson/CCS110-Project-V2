-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2026 at 06:42 PM
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
-- Database: `company_db2`
--

-- --------------------------------------------------------

--
-- Table structure for table `company_transactions`
--

CREATE TABLE `company_transactions` (
  `transaction_id` int(11) NOT NULL,
  `amount` decimal(14,4) NOT NULL,
  `currency` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company_transactions`
--

INSERT INTO `company_transactions` (`transaction_id`, `amount`, `currency`, `description`) VALUES
(1, 145000000.0000, 'PHP', 'Deposit as company money.');

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
  `contact_no` varchar(20) NOT NULL,
  `position` varchar(255) NOT NULL,
  `is_resigned` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `position_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `position_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`position_id`, `dept_id`, `position_name`) VALUES
(1, 1, 'HR Manager'),
(2, 1, 'Recruitment Specialist'),
(3, 1, 'Compensation and Benefits Analyst'),
(4, 1, 'HR Generalist'),
(5, 1, 'Training and Development Coordinator'),
(6, 2, 'IT Manager'),
(7, 2, 'Software Engineer'),
(8, 2, 'Systems Administrator'),
(9, 2, 'Cybersecurity Analyst'),
(10, 2, 'Help Desk Technician'),
(11, 3, 'Finance Manager'),
(12, 3, 'Financial Analyst'),
(13, 3, 'Accountant'),
(14, 3, 'Payroll Specialist'),
(15, 3, 'Budget Analyst'),
(16, 4, 'Marketing Manager'),
(17, 4, 'Digital Marketing Specialist'),
(18, 4, 'Content Strategist'),
(19, 4, 'Brand Manager'),
(20, 4, 'Marketing Analyst'),
(21, 5, 'Operations Manager'),
(22, 5, 'Supply Chain Coordinator'),
(23, 5, 'Logistics Analyst'),
(24, 5, 'Quality Assurance Specialist'),
(25, 5, 'Operations Analyst');

-- --------------------------------------------------------

--
-- Table structure for table `position_salary`
--

CREATE TABLE `position_salary` (
  `position_salary_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `base_pay` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `position_salary`
--

INSERT INTO `position_salary` (`position_salary_id`, `position_id`, `base_pay`) VALUES
(1, 1, 85000.00),
(2, 2, 55000.00),
(3, 3, 62000.00),
(4, 4, 52000.00),
(5, 5, 58000.00),
(6, 6, 110000.00),
(7, 7, 95000.00),
(8, 8, 75000.00),
(9, 9, 90000.00),
(10, 10, 45000.00),
(11, 11, 90000.00),
(12, 12, 68000.00),
(13, 13, 60000.00),
(14, 14, 55000.00),
(15, 15, 65000.00),
(16, 16, 82000.00),
(17, 17, 54000.00),
(18, 18, 58000.00),
(19, 19, 72000.00),
(20, 20, 50000.00),
(21, 21, 88000.00),
(22, 22, 52000.00),
(23, 23, 59000.00),
(24, 24, 61000.00),
(25, 25, 57000.00);

-- --------------------------------------------------------

--
-- Table structure for table `resignation_request`
--

CREATE TABLE `resignation_request` (
  `resign_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `resignation_letter` blob NOT NULL,
  `request_date` date NOT NULL DEFAULT current_timestamp(),
  `desired_date` date NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=pending 1=approved 2=rejected'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary_history`
--

CREATE TABLE `salary_history` (
  `transaction_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `salary_id` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `salary_amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary_structure`
--

CREATE TABLE `salary_structure` (
  `salary_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `base_pay` int(11) NOT NULL,
  `bonus` int(11) NOT NULL,
  `deduction` int(11) NOT NULL,
  `is_available` tinyint(4) NOT NULL COMMENT '0 = Payroll not available; 1 = Payroll available; -1 Payroll accepted by employee'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_link` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `is_paid` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company_transactions`
--
ALTER TABLE `company_transactions`
  ADD PRIMARY KEY (`transaction_id`);

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
  ADD KEY `employees_ibfk_1` (`user_id`),
  ADD KEY `employees_ibfk_2` (`dept_id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`position_id`),
  ADD KEY `dept_id` (`dept_id`);

--
-- Indexes for table `position_salary`
--
ALTER TABLE `position_salary`
  ADD PRIMARY KEY (`position_salary_id`);

--
-- Indexes for table `resignation_request`
--
ALTER TABLE `resignation_request`
  ADD PRIMARY KEY (`resign_id`),
  ADD KEY `resignation_request_ibfk_1` (`employee_id`);

--
-- Indexes for table `salary_history`
--
ALTER TABLE `salary_history`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `salary_history_ibfk_1` (`employee_id`),
  ADD KEY `salary_history_ibfk_2` (`salary_id`);

--
-- Indexes for table `salary_structure`
--
ALTER TABLE `salary_structure`
  ADD PRIMARY KEY (`salary_id`),
  ADD KEY `salary_structure_ibfk_1` (`employee_id`),
  ADD KEY `fk_salary_structure_position` (`position_id`);

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
-- AUTO_INCREMENT for table `company_transactions`
--
ALTER TABLE `company_transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `position_salary`
--
ALTER TABLE `position_salary`
  MODIFY `position_salary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `resignation_request`
--
ALTER TABLE `resignation_request`
  MODIFY `resign_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salary_history`
--
ALTER TABLE `salary_history`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salary_structure`
--
ALTER TABLE `salary_structure`
  MODIFY `salary_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

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
-- Constraints for table `positions`
--
ALTER TABLE `positions`
  ADD CONSTRAINT `positions_ibfk_1` FOREIGN KEY (`dept_id`) REFERENCES `departments` (`dept_id`);

--
-- Constraints for table `resignation_request`
--
ALTER TABLE `resignation_request`
  ADD CONSTRAINT `resignation_request_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`);

--
-- Constraints for table `salary_history`
--
ALTER TABLE `salary_history`
  ADD CONSTRAINT `salary_history_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`),
  ADD CONSTRAINT `salary_history_ibfk_2` FOREIGN KEY (`salary_id`) REFERENCES `salary_structure` (`salary_id`);

--
-- Constraints for table `salary_structure`
--
ALTER TABLE `salary_structure`
  ADD CONSTRAINT `fk_salary_structure_position` FOREIGN KEY (`position_id`) REFERENCES `positions` (`position_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salary_structure_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

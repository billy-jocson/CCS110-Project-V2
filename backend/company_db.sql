-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2026 at 02:59 PM
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
(1, 144890000.0000, 'PHP', 'Deposit as company money.'),
(31, 144838000.0000, 'PHP', 'Gave payroll amounting: 52000 — to employee id: 3'),
(32, 144742600.0000, 'PHP', 'Gave payroll amounting: 95400 — to employee id: 7'),
(33, 144693600.0000, 'PHP', 'Gave payroll amounting: 49000 — to employee id: 10'),
(34, 144633600.0000, 'PHP', 'Gave payroll amounting: 60000 — to employee id: 13');

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

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `dept_id`, `user_id`, `first_name`, `last_name`, `contact_no`, `position`, `is_resigned`) VALUES
(2, 1, 2, 'Alice', 'Smith', '09171234562', '2', 0),
(3, 1, 3, 'Bob', 'williams', '09171234563', '4', 0),
(4, 1, 4, 'Jane', 'Brown', '09171234564', '3', 0),
(5, 1, 5, 'Mike', 'Garcia', '09171234565', '5', 0),
(6, 2, 6, 'Chris', 'Miller', '09171234566', '6', 0),
(7, 2, 7, 'David', 'Davis', '09171234567', '7', 0),
(8, 2, 8, 'Claire', 'Rodriguez', '09171234568', '8', 0),
(9, 2, 9, 'Sam', 'Martinez', '09171234569', '9', 0),
(10, 2, 10, 'Helen', 'Hernandez', '09171234570', '10', 0),
(11, 3, 11, 'Linda', 'Lopez', '09171234571', '11', 0),
(12, 3, 12, 'Gary', 'Gonzalez', '09171234572', '12', 0),
(13, 3, 13, 'William', 'Wilson', '09171234573', '13', 0),
(14, 3, 14, 'Amy', 'Anderson', '09171234574', '14', 0),
(15, 3, 15, 'Naomi', 'Thomas', '09171234575', '15', 0),
(16, 4, 16, 'Sarah', 'Taylor', '09171234576', '16', 0),
(17, 4, 17, 'Mark', 'Moore', '09171234577', '17', 0),
(18, 4, 18, 'Jack', 'Jackson', '09171234578', '18', 0),
(19, 4, 19, 'Rose', 'Martin', '09171234579', '19', 0),
(20, 4, 20, 'Lea', 'Lee', '09171234580', '20', 0),
(21, 5, 21, 'Paul', 'Perez', '09171234581', '21', 0),
(22, 5, 22, 'Tina', 'Thompson', '09171234582', '22', 0),
(23, 5, 23, 'Walter', 'White', '09171234583', '23', 0),
(24, 5, 24, 'Toph', 'Harris', '09171234584', '24', 0),
(25, 5, 25, 'Sofia', 'Sanchez', 'sanchez25', '25', 0);

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
  `salary_amount` int(11) NOT NULL,
  `base_pay` int(15) NOT NULL,
  `bonus` int(15) NOT NULL,
  `deduction` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salary_history`
--

INSERT INTO `salary_history` (`transaction_id`, `employee_id`, `salary_id`, `date`, `salary_amount`, `base_pay`, `bonus`, `deduction`) VALUES
(1, 6, 6, '2026-05-01', 110000, 0, 0, 0),
(2, 3, 3, '2026-05-01', 52000, 0, 0, 0),
(3, 3, 3, '2026-05-01', 52000, 0, 0, 0),
(4, 7, 7, '2026-05-01', 95400, 95000, 500, 100),
(5, 10, 10, '2026-05-01', 49000, 45000, 5000, 1000),
(6, 13, 13, '2026-05-01', 60000, 60000, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `salary_structure`
--

CREATE TABLE `salary_structure` (
  `salary_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `base_pay` int(11) NOT NULL,
  `deduction` int(11) NOT NULL,
  `bonus` int(11) NOT NULL,
  `is_available` tinyint(4) NOT NULL COMMENT '0 = Payroll not available; 1 = Payroll available; -1 Payroll accepted by employee'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salary_structure`
--

INSERT INTO `salary_structure` (`salary_id`, `position_id`, `employee_id`, `base_pay`, `deduction`, `bonus`, `is_available`) VALUES
(2, 2, 2, 55000, 0, 0, 0),
(3, 4, 3, 52000, 0, 0, 0),
(4, 3, 4, 62000, 10, 500, 0),
(5, 5, 5, 58000, 0, 0, 0),
(6, 6, 6, 110000, 0, 0, 0),
(7, 7, 7, 95000, 0, 0, 0),
(8, 8, 8, 75000, 0, 0, 0),
(9, 9, 9, 90000, 0, 0, 0),
(10, 10, 10, 45000, 1000, 5000, 0),
(11, 11, 11, 90000, 0, 0, 0),
(12, 12, 12, 68000, 0, 0, 0),
(13, 13, 13, 60000, 0, 0, 0),
(14, 14, 14, 55000, 0, 0, 0),
(15, 15, 15, 65000, 0, 0, 0),
(16, 16, 16, 82000, 0, 0, 0),
(17, 17, 17, 54000, 0, 0, 0),
(18, 18, 18, 58000, 0, 0, 0),
(19, 19, 19, 72000, 0, 0, 0),
(20, 20, 20, 50000, 0, 0, 0),
(21, 21, 21, 88000, 0, 0, 0),
(22, 22, 22, 52000, 0, 0, 0),
(23, 23, 23, 59000, 0, 0, 0),
(24, 24, 24, 61000, 0, 0, 0),
(25, 25, 25, 57000, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_link` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `password`, `profile_link`, `is_admin`) VALUES
(2, 'asmith2', '$2y$10$0Y/fm8xPLz9wUHkRcflgvO6TD4jl/8mMCtOSdeii4MZIXArTlVX6q', '../assets/images/userProfiles/[Fanart] Dorothy Unsworth, by Julio Leyva.jpg', 1),
(3, 'bwilliams3', '$2y$10$4BUdlZ7TJ4MwMyyAgptepuqnuhnCuWG2pSgwDsbV4aqyUOg.mFKqS', '../assets/images/userProfiles/FB_IMG_1751650973817.jpg', 1),
(4, 'jbrown4', '$2y$10$ULy1KSqajZjfy6ODNvjfpO9JkEUbVey5cJK7qDSgs3CDIipp6xlOq', '../assets/images/userProfiles/789467009717706742.jpg', 1),
(5, 'mgarcia5', '$2y$10$EMgtMWocMnDNLK3c/oSTBOxIG1mtFSJDxaxFoVDMh6/XtMWh1Da1O', '../assets/images/userProfiles/images (5).jpeg', 1),
(6, 'miller6', '$2y$10$HFjOwz0CDt.WKxbXkAlLl.7tLEsGNA5ELpVDOsi/g9ViWCtkJR5Tu', '../assets/images/userProfiles/bdbfcb6d12c0e1a92affe66462da54cf.jpg', 0),
(7, 'davis7', '$2y$10$T7KjxRKQ1q5bAdVwp.tV7uFfayM3/8MpjvVdK1zFeiJQplpIsYRUm', '../assets/images/userProfiles/cv-color-thumbnail.png', 0),
(8, 'crodriguez8', '$2y$10$vDtQFhbKBrBXakZ/LNgMHON9pQb5t0bY1.1Z3qWLsWzLPoIM3tAaW', '../assets/images/userProfiles/650865454c2393ac25712abe_professional_selfie_blur-bg-550x483.jpeg', 0),
(9, 'smartinez9', '$2y$10$5lGHLFj5J0914YrVpIQJxO.eokmdjueDN.lGr78i5glBKU3qrtVpC', '../assets/images/userProfiles/cv_photo_exemple_1.jpg', 0),
(10, 'hernandez10', '$2y$10$wQDaZNtJ3uXkxoDJL6iddeIBB0rwsr6PybqBx2cBUQqrhXHcKsKHq', '../assets/images/userProfiles/images.jpeg', 0),
(11, 'lopez11', '$2y$10$5insKfK2sUpIMlPy5V/5uOop.0nWb5605Phj93w2a7lWq45FW7mvm', '../assets/images/userProfiles/harry-potter-top-10-hermione-granger-moments-hermione-granger-358045.jpg', 0),
(12, 'gonzalez12', '$2y$10$aae4iFulU18MRBxsy5G3veco82b0d2RKkSjND93.cADJExooKO4vu', '../assets/images/userProfiles/Ryan-Reynolds-2011.jpg', 0),
(13, 'wilson13', '$2y$10$WK2ALSKMDWgRii5ZDiqdB.YB2bu7DAahRCYjssnxXvtgdGrMDkm6W', '../assets/images/userProfiles/5qHNjhtjMD4YWH3UP0rm4tKwxCL.jpg', 0),
(14, 'anderson14', '$2y$10$sxzNrEKnqWq1FnmmpY6SSO9aCotsTA12WLJ0WMHeW0TAIMiIhF1SG', '../assets/images/userProfiles/beauty-2013-06-emma-stone-baking-soda-skincare-secret-main.jpg', 0),
(15, 'thomas15', '$2y$10$XQYteFS1bygWhzBBVAGZKu.U.LqjsxgG6DDQ0u43w9Alfh6EsPAbG', '../assets/images/userProfiles/images.png', 0),
(16, 'taylor16', '$2y$10$oigAfgXq4sLdNSbhSyTd2.RmIf14S7Lp07uBn9XJeKYheufwjomQK', '../assets/images/userProfiles/7342ac705f31f9e9ceb9276b6208fed0.jpg', 0),
(17, 'moore17', '$2y$10$F3Um20HUfj9c90xWY0fVY.xTLYwvkUo1KWviN9M7ffeM0Pyjims5C', '../assets/images/userProfiles/27a008b28fa427f453829e91ee878d42.jpg', 0),
(18, 'jackson18', '$2y$10$BlKvkcB77uJad/ec.4SL0O0HHuDMwERpN1YBa0yP.peWSgaTbFqHq', '../assets/images/userProfiles/632-Tadashi-Hamada-Costume-featured_600x.png', 0),
(19, 'martin19', '$2y$10$VM8bp9jaTZ8LGd3/h/wpo.chx0RE..3AmXHDikzWSL72rwO4tDnYm', '../assets/images/userProfiles/Profile_-_Vanellope_Von_schweetz.png', 0),
(20, 'lee20', '$2y$10$H0DPbju6MihqcUXjs/PtYOkln8uCO6fui0AonB9.Mj.reS5EWXAx.', '../assets/images/userProfiles/new-official-elsa-picture-enhanced-in-better-quality-found-v0-e0spmk1ktm0d1.png', 0),
(21, 'perez21', '$2y$10$yWZQRMtKyIJgUeEh3lvFXOKDIoJL89TV6p3vfpI7D51OJvRLBSnBS', '../assets/images/userProfiles/images.jpeg', 0),
(22, 'thompson22', '$2y$10$kcFomdH24Q5VS2V/hy4YeuOOWiAhlIUCJDKm3TtZ8LXP4m17XFHEu', '../assets/images/userProfiles/tumblr_ab01ec99e8a7fda24a49a61b351e7e88_2c1146d2_640.png', 0),
(23, 'white23', '$2y$10$FFHn3KcJoFAXa0YTx1BHouVUkLV5.ommKCGKlEMHRfVHgUYbb09fK', '../assets/images/userProfiles/adult-swim-reviving-samurai-jack-in-2016.png', 0),
(24, 'harris24', '$2y$10$l/BzPm8O7a3mVeqkrQcaN.t/PyfhgRpm8IycOVicG5qa4jyosmh/a', '../assets/images/userProfiles/Toph_Beifong.png', 0),
(25, 'senchez25', '$2y$10$wRgL0G0awWwV34TZtR42JOVGCpDxaRSiTPKV7hLSpysXr0zXZMRPS', '../assets/images/userProfiles/tumblr_orruftJYU91urdh20o1_500.png', 0);

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
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `salary_structure`
--
ALTER TABLE `salary_structure`
  MODIFY `salary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

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

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2025 at 03:27 PM
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
-- Database: `printing_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `user_id` varchar(255) NOT NULL,
  `branch_name` text NOT NULL,
  `email` text NOT NULL,
  `location` text NOT NULL,
  `password` text NOT NULL,
  `token` text DEFAULT NULL,
  `user_type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`user_id`, `branch_name`, `email`, `location`, `password`, `token`, `user_type`) VALUES
('admin1262833278', 'admin', 'admin', 'admin', '$2y$10$lx3A4EZ/3jIkiQTdTLqwy.GPJphZunS/biZ1D7EoArrVAPwUffKOW', NULL, 'Admin'),
('asd444256545', 'asd', 'asdasd@gmail.com', 'asdasdas', '$2y$10$IzcFljAXLEG0BzbRtDbSqenk86ETXOusEV6JWijHFyJ5GY0X5576W', NULL, 'Staff'),
('asdasd335954883', 'asdasd', 'paytrickcorrexxa@gmail.com', 'sadasd', '$2y$10$ka0Z1AZTUfCwJsotKCHk6.c21M9EkTYuUM6rXGcpppmdKVkxiBMoC', NULL, 'Staff'),
('asdasdc1977529607', 'asdasdc', 'adminzz@gmail.com', 'adminzz@gmail.com', '$2y$10$b.NSCq867ZNWw8A6bFfiQuRHVYH7jTt6GyWjkEYj3yn6JNeIrEs0y', NULL, 'Staff'),
('ASDsad1411914780', 'ASDsad', 'paytrickcorrea@gmail.com', 'paytrickcorrea@gmail.com', '$2y$10$vDI6ebx1cj03UjIfMRgcKu.uovbuZF2vEUz0UXCUgmfe.kaE80JB2', '7d5f395b7eff459a3c322262b31b390cd28903d2d7c5630d4b9ca30c21389be7', 'Staff'),
('ddd1720527421', 'ddd', 'admin@gmail.com', 'adws', '$2y$10$QoVs8lQsMuyNlHZXrvmzFOoKvFT7FJkbU6OY3WYtHFny5fGXyIoSK', NULL, 'Staff');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `customer_fullname` text NOT NULL,
  `date_transaction` text NOT NULL,
  `time_transaction` text NOT NULL,
  `amount` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `action_id` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`invoice_id`, `user_id`, `customer_fullname`, `date_transaction`, `time_transaction`, `amount`, `quantity`, `action_id`) VALUES
('INV-1343463011', 'ASDsad1411914780', 'zsdasdasd', '2025-12-02', '07:22:29 pm', '80', '4', 'action_1636733259'),
('INV-2094853923', 'asdasdc1977529607', 'asdasdasd', '2025-12-02', '10:08:50 am', '12', '4', 'action_1553061976'),
('INV-390238641', 'asdasdc1977529607', 'asdasd', '2025-12-02', '10:07:26 am', '20', '1', 'action_84585998'),
('INV-551075180', 'asdasdc1977529607', 'asdasd', '2025-12-02', '07:09:51 pm', '3', '1', 'action_1586013716');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `user_id` text DEFAULT NULL,
  `date_sent` date NOT NULL,
  `time_sent` text NOT NULL,
  `seen` text NOT NULL,
  `receiver` text NOT NULL,
  `type` text NOT NULL,
  `file` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `message`, `user_id`, `date_sent`, `time_sent`, `seen`, `receiver`, `type`, `file`) VALUES
('315289725', 'patrick', 'ASDsad1411914780', '2025-12-28', '21:51:11', 'no', 'admin1262833278', '', ''),
('588507766', 'pre', 'admin1262833278', '2025-12-28', '21:51:35', '', 'ASDsad1411914780', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `paper_jam`
--

CREATE TABLE `paper_jam` (
  `paper_jam_id` varchar(255) NOT NULL,
  `pieces` varchar(255) NOT NULL,
  `type` text NOT NULL,
  `user_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paper_jam`
--

INSERT INTO `paper_jam` (`paper_jam_id`, `pieces`, `type`, `user_id`) VALUES
('1061961893', '1', 'Long Bond Paper', ''),
('1629799558', '2', 'Long Bond Paper', '');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `stock_id` varchar(255) NOT NULL,
  `laminating_plastic` varchar(255) NOT NULL,
  `long_bond_paper` varchar(255) NOT NULL,
  `photo_paper` text NOT NULL,
  `user_id` text NOT NULL,
  `short_bond_paper` text NOT NULL,
  `a4_bond_paper` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`stock_id`, `laminating_plastic`, `long_bond_paper`, `photo_paper`, `user_id`, `short_bond_paper`, `a4_bond_paper`) VALUES
('372256', '11', '1', '12', 'asdasdc1977529607', '11', '12'),
('530740', '14', '0', '20', 'ASDsad1411914780', '4', '20');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transaction_id` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `type` text NOT NULL,
  `quantity` text NOT NULL,
  `total` text NOT NULL,
  `user_id` text NOT NULL,
  `date_uploaded` text NOT NULL,
  `time_uploaded` text NOT NULL,
  `action_id` text NOT NULL,
  `copies` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transaction_id`, `file`, `type`, `quantity`, `total`, `user_id`, `date_uploaded`, `time_uploaded`, `action_id`, `copies`) VALUES
('transaction_692e49de2f7a1', 'Screenshot 2025-11-05 225039.png', 'Lamination', '1', '20', 'asdasdc1977529607', '2025-12-02', '10:07:26 am', 'action_84585998', '1'),
('transaction_692e4a32650c5', 'Screenshot 2025-11-05 225039.png', 'Printing Long Bond Paper', '4', '12', 'asdasdc1977529607', '2025-12-02', '10:08:50 am', 'action_1553061976', '2'),
('transaction_692e4a3268831', 'Screenshot 2025-11-05 231606.png', 'Printing Long Bond Paper', '0', '0', 'asdasdc1977529607', '2025-12-02', '10:08:50 am', 'action_1553061976', '1'),
('transaction_692ec8ff7a914', 'Screenshot (58).png', 'Printing Long Bond Paper', '1', '3', 'asdasdc1977529607', '2025-12-02', '07:09:51 pm', 'action_1586013716', '1'),
('transaction_692ecbf534771', 'Screenshot 2025-11-05 221829.png', 'Lamination', '4', '80', 'ASDsad1411914780', '2025-12-02', '07:22:29 pm', 'action_1636733259', '2'),
('transaction_692ecbf536764', 'Screenshot 2025-11-05 221832.png', 'Lamination', '0', '0', 'ASDsad1411914780', '2025-12-02', '07:22:29 pm', 'action_1636733259', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `paper_jam`
--
ALTER TABLE `paper_jam`
  ADD PRIMARY KEY (`paper_jam_id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transaction_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

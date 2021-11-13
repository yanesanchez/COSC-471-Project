-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 12, 2021 at 11:24 PM
-- Server version: 10.3.28-MariaDB-cll-lve
-- PHP Version: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yanelisa_3b-bookstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `REGISTERED_USER`
--

CREATE TABLE `REGISTERED_USER` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pin` int(11) NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip` char(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `credit_card_type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `credit_card_no` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `credit_card_exp` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `REGISTERED_USER`
--

INSERT INTO `REGISTERED_USER` (`id`, `username`, `pin`, `first_name`, `last_name`, `street`, `city`, `state`, `zip`, `credit_card_type`, `credit_card_no`, `credit_card_exp`) VALUES
(1, 'goodusername', 1234, 'Mary', 'Smith', '1010 Street Ave', 'Ypsilanti', 'Michigan', '48195', 'Visa', '1111000011110000', '2026-10-10'),
(2, 'bookworm', 5548, 'Avery', 'Ross', '852 Boulevard Dr', 'Toledo', 'Ohio', '43601', 'Discover', '111100001111', '2024-06-10'),
(3, 'catdad', 6679, 'Jose', 'Garcia', '987 Camino St', 'Chicago', 'Illinois', '85009', 'MasterCard', '1234567876543210', '2022-02-22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `REGISTERED_USER`
--
ALTER TABLE `REGISTERED_USER`
  ADD PRIMARY KEY (`id`,`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `REGISTERED_USER`
--
ALTER TABLE `REGISTERED_USER`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `REGISTERED_USER`
--
ALTER TABLE `REGISTERED_USER`
  ADD CONSTRAINT `REGISTERED_USER_ibfk_1` FOREIGN KEY (`id`) REFERENCES `USER` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

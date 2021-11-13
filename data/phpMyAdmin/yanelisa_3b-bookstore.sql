-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 12, 2021 at 11:18 PM
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
-- Table structure for table `ADMIN`
--

CREATE TABLE `ADMIN` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ADMIN`
--

INSERT INTO `ADMIN` (`id`, `username`, `pin`) VALUES
(7, 'admin1', 45678),
(8, 'admin2', 12345),
(9, 'admin3', 96385);

-- --------------------------------------------------------

--
-- Table structure for table `AUTHOR`
--

CREATE TABLE `AUTHOR` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `AUTHOR`
--

INSERT INTO `AUTHOR` (`id`, `first_name`, `last_name`) VALUES
(1, 'James', 'Clear'),
(2, 'Markus', 'Zusak'),
(3, 'Thomas', 'Byrom'),
(4, 'Edwin', 'Abbott'),
(5, 'Ryder', 'Carroll'),
(6, 'John', 'Yates PhD'),
(7, 'Barbara', 'Oakley PhD'),
(8, 'Bessel', 'van der Kolk MD'),
(9, 'Stephen', 'Chbosky');

-- --------------------------------------------------------

--
-- Table structure for table `BOOK`
--

CREATE TABLE `BOOK` (
  `isbn` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `publisher` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(20,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `BOOK`
--

INSERT INTO `BOOK` (`isbn`, `title`, `author_id`, `category_id`, `publisher`, `price`, `quantity`) VALUES
('9780385754729', 'The Book Thief', 2, 2, 'Alfred A Knopf/Random House LLC', 12.99, 3),
('9780525533337', 'The Bullet Journal Method', 5, 2, 'Portfolio/Penguin', 26.00, 2),
('9780735211292', 'Atomic Habits', 1, 1, 'Avery', 27.00, 5);

-- --------------------------------------------------------

--
-- Table structure for table `CART_ITEM`
--

CREATE TABLE `CART_ITEM` (
  `cart_id` int(11) NOT NULL,
  `isbn` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `CATEGORY`
--

CREATE TABLE `CATEGORY` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `CATEGORY`
--

INSERT INTO `CATEGORY` (`id`, `name`) VALUES
(1, 'Nonfiction'),
(2, 'Fiction'),
(3, 'Young Adult'),
(4, 'Philosophy'),
(5, 'Psychology');

-- --------------------------------------------------------

--
-- Table structure for table `ORDER_ITEM`
--

CREATE TABLE `ORDER_ITEM` (
  `order_id` int(11) NOT NULL,
  `isbn` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ORDER_PLACED`
--

CREATE TABLE `ORDER_PLACED` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `REVIEW`
--

CREATE TABLE `REVIEW` (
  `id` int(11) NOT NULL,
  `isbn` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `REVIEW`
--

INSERT INTO `REVIEW` (`id`, `isbn`, `description`) VALUES
(1, '9780385754729', 'I don\'t usually write review for books but above all the books I have read I can hands down say this is my favourite book I truly can\'t fault it i loved the story, how and when it\'s set and by far the POV from death it really is masterfully written and if anybody can recommend a book like it I\'m open to suggestions.'),
(2, '9780385754729', 'A wonderful story of youthful curiosity, tenacity and daring set against a backdrop of a society that controlled the minds and actions of its citizens with fear.'),
(3, '9780385754729', 'Such a great book! I love historicals. This one was set in Nazi Germany. So many of those stories are told from a Jewish person\'s point of view, but not this one. The main character is a young German girl, whose Communist father is taken away and her mother sends her to safety in another town. Took me a little while to get into the formatting, all the capital, bold type here and there. And I finally searched online to verify that yes, the narrator was Death. But once you get past those two things, the story is gripping, compelling. I loved this book.'),
(4, '9780525533337', 'I love this book! It\'s been so helpfull! I\'ll use some of the ideas in my journal. Thanks to the inventor and writer of this book Ryder Carroll.'),
(5, '9780525533337', 'As someone who has repeatedly failed to keep a traditional planner/journal, I appreciate the flexibility of the Bullet Journal method and am looking forward to developing the practice this year.'),
(6, '9780525533337', 'I listened to this on audiobook as well as read the physical book. Really enjoyed it, it\'s a great system and I love how much the book talks about reflection, goals, and that it\'s about using the system to help you in your goals. It\'s very easy to get distracted by the beautiful layouts out there, but the core of the system is about function. Helping you know where you are and get to where you want to be. So good!');

-- --------------------------------------------------------

--
-- Table structure for table `SHOPPING_CART`
--

CREATE TABLE `SHOPPING_CART` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total` decimal(50,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TEMP_CART_ITEM`
--

CREATE TABLE `TEMP_CART_ITEM` (
  `cart_id` int(11) NOT NULL,
  `isbn` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TEMP_SHOPPING_CART`
--

CREATE TABLE `TEMP_SHOPPING_CART` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total` decimal(50,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `TEMP_USER`
--

CREATE TABLE `TEMP_USER` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `USER`
--

CREATE TABLE `USER` (
  `id` int(11) NOT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `USER`
--

INSERT INTO `USER` (`id`, `type`) VALUES
(1, 'REGISTERED'),
(2, 'REGISTERED'),
(3, 'REGISTERED'),
(4, 'TEMP'),
(5, 'TEMP'),
(6, 'TEMP'),
(7, 'ADMIN'),
(8, 'ADMIN'),
(9, 'ADMIN');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ADMIN`
--
ALTER TABLE `ADMIN`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `AUTHOR`
--
ALTER TABLE `AUTHOR`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `BOOK`
--
ALTER TABLE `BOOK`
  ADD PRIMARY KEY (`isbn`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `CART_ITEM`
--
ALTER TABLE `CART_ITEM`
  ADD PRIMARY KEY (`cart_id`,`isbn`),
  ADD KEY `isbn` (`isbn`);

--
-- Indexes for table `CATEGORY`
--
ALTER TABLE `CATEGORY`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ORDER_ITEM`
--
ALTER TABLE `ORDER_ITEM`
  ADD PRIMARY KEY (`order_id`,`isbn`),
  ADD KEY `isbn` (`isbn`);

--
-- Indexes for table `ORDER_PLACED`
--
ALTER TABLE `ORDER_PLACED`
  ADD PRIMARY KEY (`id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `REGISTERED_USER`
--
ALTER TABLE `REGISTERED_USER`
  ADD PRIMARY KEY (`id`,`username`);

--
-- Indexes for table `REVIEW`
--
ALTER TABLE `REVIEW`
  ADD PRIMARY KEY (`id`,`isbn`),
  ADD KEY `isbn` (`isbn`);

--
-- Indexes for table `SHOPPING_CART`
--
ALTER TABLE `SHOPPING_CART`
  ADD PRIMARY KEY (`id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `TEMP_CART_ITEM`
--
ALTER TABLE `TEMP_CART_ITEM`
  ADD PRIMARY KEY (`cart_id`,`isbn`),
  ADD KEY `isbn` (`isbn`);

--
-- Indexes for table `TEMP_SHOPPING_CART`
--
ALTER TABLE `TEMP_SHOPPING_CART`
  ADD PRIMARY KEY (`id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `TEMP_USER`
--
ALTER TABLE `TEMP_USER`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `USER`
--
ALTER TABLE `USER`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `AUTHOR`
--
ALTER TABLE `AUTHOR`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `CATEGORY`
--
ALTER TABLE `CATEGORY`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ORDER_PLACED`
--
ALTER TABLE `ORDER_PLACED`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `REGISTERED_USER`
--
ALTER TABLE `REGISTERED_USER`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `REVIEW`
--
ALTER TABLE `REVIEW`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `SHOPPING_CART`
--
ALTER TABLE `SHOPPING_CART`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TEMP_SHOPPING_CART`
--
ALTER TABLE `TEMP_SHOPPING_CART`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `USER`
--
ALTER TABLE `USER`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ADMIN`
--
ALTER TABLE `ADMIN`
  ADD CONSTRAINT `ADMIN_ibfk_1` FOREIGN KEY (`id`) REFERENCES `USER` (`id`);

--
-- Constraints for table `BOOK`
--
ALTER TABLE `BOOK`
  ADD CONSTRAINT `BOOK_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `AUTHOR` (`id`),
  ADD CONSTRAINT `BOOK_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `CATEGORY` (`id`);

--
-- Constraints for table `CART_ITEM`
--
ALTER TABLE `CART_ITEM`
  ADD CONSTRAINT `CART_ITEM_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `SHOPPING_CART` (`id`),
  ADD CONSTRAINT `CART_ITEM_ibfk_2` FOREIGN KEY (`isbn`) REFERENCES `BOOK` (`isbn`);

--
-- Constraints for table `ORDER_ITEM`
--
ALTER TABLE `ORDER_ITEM`
  ADD CONSTRAINT `ORDER_ITEM_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `ORDER_PLACED` (`id`),
  ADD CONSTRAINT `ORDER_ITEM_ibfk_2` FOREIGN KEY (`isbn`) REFERENCES `BOOK` (`isbn`);

--
-- Constraints for table `ORDER_PLACED`
--
ALTER TABLE `ORDER_PLACED`
  ADD CONSTRAINT `ORDER_PLACED_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `USER` (`id`);

--
-- Constraints for table `REGISTERED_USER`
--
ALTER TABLE `REGISTERED_USER`
  ADD CONSTRAINT `REGISTERED_USER_ibfk_1` FOREIGN KEY (`id`) REFERENCES `USER` (`id`);

--
-- Constraints for table `REVIEW`
--
ALTER TABLE `REVIEW`
  ADD CONSTRAINT `REVIEW_ibfk_1` FOREIGN KEY (`isbn`) REFERENCES `BOOK` (`isbn`);

--
-- Constraints for table `SHOPPING_CART`
--
ALTER TABLE `SHOPPING_CART`
  ADD CONSTRAINT `SHOPPING_CART_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `USER` (`id`);

--
-- Constraints for table `TEMP_CART_ITEM`
--
ALTER TABLE `TEMP_CART_ITEM`
  ADD CONSTRAINT `TEMP_CART_ITEM_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `TEMP_SHOPPING_CART` (`id`),
  ADD CONSTRAINT `TEMP_CART_ITEM_ibfk_2` FOREIGN KEY (`isbn`) REFERENCES `BOOK` (`isbn`);

--
-- Constraints for table `TEMP_SHOPPING_CART`
--
ALTER TABLE `TEMP_SHOPPING_CART`
  ADD CONSTRAINT `TEMP_SHOPPING_CART_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `USER` (`id`);

--
-- Constraints for table `TEMP_USER`
--
ALTER TABLE `TEMP_USER`
  ADD CONSTRAINT `TEMP_USER_ibfk_1` FOREIGN KEY (`id`) REFERENCES `USER` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

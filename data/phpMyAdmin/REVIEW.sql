-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 12, 2021 at 11:25 PM
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `REVIEW`
--
ALTER TABLE `REVIEW`
  ADD PRIMARY KEY (`id`,`isbn`),
  ADD KEY `isbn` (`isbn`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `REVIEW`
--
ALTER TABLE `REVIEW`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `REVIEW`
--
ALTER TABLE `REVIEW`
  ADD CONSTRAINT `REVIEW_ibfk_1` FOREIGN KEY (`isbn`) REFERENCES `BOOK` (`isbn`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

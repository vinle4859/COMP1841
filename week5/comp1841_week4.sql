-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2025 at 12:04 PM
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
-- Database: `comp1841_week4`
--

-- --------------------------------------------------------

--
-- Table structure for table `joke`
--

CREATE TABLE `joke` (
  `jokeid` int(11) NOT NULL,
  `joketext` varchar(255) DEFAULT NULL,
  `jokedate` datetime DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `joke`
--

INSERT INTO `joke` (`jokeid`, `joketext`, `jokedate`, `image`) VALUES
(1, 'Why don\'t scientists trust atoms? Because they make up everything!', '2025-10-10 00:00:00', 'bridge_4.jpg'),
(2, 'I told my wife she was drawing her eyebrows too high. She looked surprised.', '2025-10-09 00:00:00', 'island_2.jpg'),
(3, 'Why did the scarecrow win an award? Because he was outstanding in his field.', '2025-10-08 00:00:00', 'mountain_3.jpg'),
(4, 'What do you call a fake noodle? An impasta.', '2025-10-07 00:00:00', 'waterfall_2.jpg'),
(8, 'fasdfdsa', '2025-10-17 00:00:00', 'sky_1.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `joke`
--
ALTER TABLE `joke`
  ADD PRIMARY KEY (`jokeid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `joke`
--
ALTER TABLE `joke`
  MODIFY `jokeid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

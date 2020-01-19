-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2017 at 05:04 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pagination`
--

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE `page` (
  `book_id` int(11) NOT NULL,
  `title` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`book_id`, `title`) VALUES
(1, 'A Darkling Plain'),
(2, 'Death Be Not Proud'),
(3, 'The Doors of Perception'),
(4, 'Down to a Sunless Sea'),
(5, 'Dying of the Light'),
(6, 'East of Eden'),
(7, 'Fame Is the Spur'),
(8, 'A Fanatic Heart'),
(9, 'The Far-Distant Oxus'),
(10, 'A Farewell to Arms'),
(11, 'Far From the Madding Crowd'),
(12, 'Fear and Trembling'),
(13, 'For a Breath I Tarry'),
(14, 'For Whom the Bell Tolls'),
(15, 'Frequent Hearses'),
(16, 'From Here to Eternity'),
(17, 'A Glass of Blessings'),
(18, 'The Glory and the Dream'),
(19, 'The Golden Apples of the Sun'),
(20, 'The Golden Bowl'),
(21, 'Gone with the Wind'),
(22, 'The Grapes of Wrath'),
(23, 'Great Work of Time'),
(24, 'The Green Bay Tree'),
(25, 'A Handful of Dust'),
(26, 'Have His Carcase'),
(27, 'The Heart Is a Lonely Hunter'),
(28, 'His Dark Materials'),
(29, 'The House of Mirth'),
(30, 'I Know Why the Caged Bird Sings	'),
(31, 'I Know Why the Caged Bird Sings	'),
(32, 'I Sing the Body Electric'),
(33, 'I Will Fear No Evil'),
(34, 'In a Dry Season'),
(35, 'In a Glass Darkly	'),
(36, 'In Death Ground'),
(37, 'In Dubious Battle'),
(38, 'An Instant in the Wind'),
(39, 'It''s a Battlefield'),
(40, 'Jacob Have I Loved	');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`book_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

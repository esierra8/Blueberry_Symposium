-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2017 at 05:32 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.5.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uncommonhack`
--

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `author` text NOT NULL,
  `version` text NOT NULL,
  `lang` text NOT NULL,
  `date` text NOT NULL,
  `plays` int(11) NOT NULL,
  `downloads` int(11) NOT NULL,
  `ext` text NOT NULL,
  `dld` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `name`, `description`, `author`, `version`, `lang`, `date`, `plays`, `downloads`, `ext`, `dld`) VALUES
(19, 'StarFall', 'You act as a block flying through the galaxy, eating planets as you travel. It is your task to eat as many planets as you can before the falling stars hit you.\r\n\r\n/api/add_score.php?game=19&category=Points&name=NAME&score=SCORE', 'Ruvim Nochvay', '1.0', 'Python', 'January 15, 2017', 35, 2, 'PNG', 'zip'),
(21, 'Snake', 'Keep eating food, dont eat yourself or hit the wall!', 'Nathaniel Hayes', '1.02', 'JavaScript', 'January 15, 2017', 13, 2, 'png', 'php'),
(22, 'Alienweras', 'Spaceships fighting aliens! What more could you want! Classic Arcade Game!', 'Esteban Sierra', '1.0', 'Python', 'January 15, 2017', 56, 42, 'png', 'zip'),
(23, 'Lunar Turrets', 'Alien warfare on the moon! With only your trust turrets to help defend your base, will you last long enough to become immortal? Nope...', 'Nathaniel Hayes', '1.0', 'C++', 'January 15, 2017', 22, 1, 'jpg', 'zip'),
(24, 'The Run', 'An unending race against the clock!', 'Nathaniel Hayes', '1.2', 'JavaScript', 'January 15, 2017', 0, 2, 'png', 'php');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

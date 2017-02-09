-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Host: 172.17.0.2:3306
-- Generation Time: Feb 09, 2017 at 02:42 PM
-- Server version: 10.1.20-MariaDB-1~jessie
-- PHP Version: 5.6.9-1+deb.sury.org~trusty+2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `letscreate`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL COMMENT 'Name of the event',
  `description` text COMMENT 'Description of the event',
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `creator_id` int(11) DEFAULT NULL COMMENT 'Foreign key to the user',
  `banner_url` text NOT NULL COMMENT 'banner image url'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `description`, `start_date`, `end_date`, `creator_id`, `banner_url`) VALUES
(1, 'THE EYESLICER SEASON ONE', NULL, '2017-04-21 00:00:00', '2017-04-30 00:00:00', NULL, 'images/events/event-1.png');
INSERT INTO `events` (`id`, `name`, `description`, `start_date`, `end_date`, `creator_id`, `banner_url`) VALUES
(2, 'Peter Evans and Taylor Ho Bynum', NULL, '2017-04-23 00:00:00', '2017-04-30 00:00:00', NULL, 'images/events/event-2.png');
INSERT INTO `events` (`id`, `name`, `description`, `start_date`, `end_date`, `creator_id`, `banner_url`) VALUES
(3, 'Second Sundays', NULL, '2017-04-24 00:00:00', '2017-04-30 00:00:00', NULL, 'images/events/event-3.png');
INSERT INTO `events` (`id`, `name`, `description`, `start_date`, `end_date`, `creator_id`, `banner_url`) VALUES
(4, 'Building and Improvising with Analog Circuitry', NULL, '2017-04-25 00:00:00', '2017-04-30 00:00:00', NULL, 'images/events/event-4.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

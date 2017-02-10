-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Host: 172.17.0.2:3306
-- Generation Time: Feb 10, 2017 at 01:49 PM
-- Server version: 10.1.21-MariaDB-1~jessie
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
(1, 'THE EYESLICER SEASON ONE', NULL, '2017-04-21 00:00:00', '2017-04-30 00:00:00', NULL, 'images/events/event-1.png'),
(2, 'Peter Evans and Taylor Ho Bynum', NULL, '2017-04-23 00:00:00', '2017-04-30 00:00:00', NULL, 'images/events/event-2.png'),
(3, 'Second Sundays', NULL, '2017-04-24 00:00:00', '2017-04-30 00:00:00', NULL, 'images/events/event-3.png'),
(4, 'Building and Improvising with Analog Circuitry', NULL, '2017-04-25 00:00:00', '2017-04-30 00:00:00', NULL, 'images/events/event-4.png');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `url` text NOT NULL,
  `creator_id` int(11) NOT NULL COMMENT 'Foreign key to user'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `url`, `creator_id`) VALUES
(1, 'images/community/community-1.png', 1),
(2, 'images/community/community-2.png', 2),
(3, 'images/community/community-3.png', 3),
(4, 'images/community/community-4.png', 4),
(1, 'images/community/community-1.png', 1),
(2, 'images/community/community-2.png', 2),
(3, 'images/community/community-3.png', 3),
(4, 'images/community/community-4.png', 4),
(1, 'images/community/community-1.png', 1),
(2, 'images/community/community-2.png', 2),
(3, 'images/community/community-3.png', 3),
(4, 'images/community/community-4.png', 4),
(5, 'images/community/community-5.png', 5),
(6, 'images/community/community-6.png', 6),
(7, 'images/community/community-7.png', 7),
(8, 'images/community/community-8.png', 8),
(9, 'images/community/community-9.png', 9);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` text NOT NULL,
  `display_picture` int(11) NOT NULL COMMENT 'This is a foreign key to media table',
  `activity_score` int(100) NOT NULL,
  `last_loggedin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `display_picture`, `activity_score`, `last_loggedin`, `firstname`, `lastname`) VALUES
(1, 'petemure', 'petemure', 'pete@lc.com', 1, 23, '2017-02-10 03:42:05', 'Pete', 'Mure'),
(2, 'jwilson', 'jwilson', 'jwilson@rc.com', 2, 43, '2017-02-10 03:42:05', 'Josh', 'Wilson'),
(3, 'mkleinz', 'mkleinz', 'mk@rc.com', 3, 12, '2017-02-10 03:43:58', 'Mich', 'Kleinz'),
(4, 'rmukherjee', 'rmukherjee', 'rm@rc.com', 4, 23, '2017-02-10 03:43:58', 'Rishi', 'Mukherjee'),
(5, 'viraj', 'viraj', 'vr@rc.com', 5, 32, '2017-02-10 03:43:58', 'Vikram', 'Raj'),
(6, 'sanborn', 'sanborn', 'sanborn@rc.com', 6, 21, '2017-02-10 03:43:58', 'Sanborn', 'Sen'),
(7, 'michv', 'michv', 'michv@rc.com', 7, 21, '2017-02-10 03:43:58', 'Michael', 'Virgil'),
(8, 'luna', 'luna', 'luna@rc.com', 8, 29, '2017-02-10 03:43:58', 'Luna', 'Virgil'),
(9, 'naina', 'naina', 'naina@rc.com', 9, 29, '2017-02-10 03:43:58', 'Naina', 'Kaur');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

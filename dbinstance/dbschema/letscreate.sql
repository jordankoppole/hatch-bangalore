-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Host: 172.17.0.3:3306
-- Generation Time: Mar 09, 2017 at 06:56 AM
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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `fieldname` varchar(150) NOT NULL,
  `name` varchar(200) NOT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `fieldname`, `name`, `parent_id`) VALUES
(1, 'visualarts', 'Visual Arts', NULL),
(2, 'performingarts', 'Performing Arts', NULL),
(3, 'painting', 'Painting', 1),
(4, 'illustration', 'Illustration', 1),
(5, 'music', 'Music', 2),
(6, 'dance', 'Dance', 2);

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `state_id` int(11) NOT NULL COMMENT 'Foreign key to state',
  `code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `name`, `state_id`, `code`) VALUES
(1, 'Bangalore', 1, 'BLR'),
(2, 'Kolkata', 2, 'KOL'),
(3, 'Charlotte', 3, 'CLT'),
(4, 'Minneapolis', 4, 'MN');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `code` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `name`, `code`) VALUES
(1, 'India', 'IN'),
(2, 'United States', 'US');

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
-- Table structure for table `interest`
--

CREATE TABLE `interest` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `interest`
--

INSERT INTO `interest` (`id`, `user_id`, `category_id`) VALUES
(1, 9, 4),
(2, 9, 6);

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
(5, 'images/community/community-5.png', 5),
(6, 'images/community/community-6.png', 6),
(7, 'images/community/community-7.png', 7),
(8, 'images/community/community-8.png', 8),
(9, 'images/community/community-9.png', 9);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'Artist'),
(2, 'Painter'),
(3, 'Designer');

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `country_id` int(11) NOT NULL COMMENT 'Foreign key to country',
  `code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`id`, `name`, `country_id`, `code`) VALUES
(1, 'Karnataka', 1, 'KA'),
(2, 'West bengal', 1, 'WB'),
(3, 'North Carolina', 2, 'NC'),
(4, 'Minnesota', 2, 'MN');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` int(11) NOT NULL,
  `token` text NOT NULL,
  `expiry` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`id`, `token`, `expiry`, `user_id`) VALUES
(1, 'x8KDGlMljfoaESkGqG24mH7o5JVvmoaC9yKy0U0ACltXx02hLB2EpHv2NTWvWI1I', '2017-03-09 07:54:58', 9);

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
  `lastname` varchar(100) NOT NULL,
  `pw_reset_code` text,
  `professionaltitle` varchar(200) NOT NULL,
  `statement` text NOT NULL,
  `yourself` text NOT NULL,
  `country_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `youtube` text NOT NULL,
  `behance` text NOT NULL,
  `linkedin` text NOT NULL,
  `facebook` text NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `contrubutor` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `display_picture`, `activity_score`, `last_loggedin`, `firstname`, `lastname`, `pw_reset_code`, `professionaltitle`, `statement`, `yourself`, `country_id`, `city_id`, `state_id`, `youtube`, `behance`, `linkedin`, `facebook`, `active`, `contrubutor`) VALUES
(1, 'petemure', 'petemure', 'pete@lc.com', 1, 23, '2017-02-10 15:18:05', 'Pete', 'Mure', NULL, '', '', '', 0, 0, 0, '', '', '', '', 0, 0),
(2, 'jwilson', 'jwilson', 'jwilson@rc.com', 2, 43, '2017-02-10 15:18:09', 'Josh', 'Wilson', NULL, '', '', '', 0, 0, 0, '', '', '', '', 0, 0),
(3, 'mkleinz', 'mkleinz', 'mk@rc.com', 3, 12, '2017-02-10 15:18:10', 'Mich', 'Kleinz', NULL, '', '', '', 0, 0, 0, '', '', '', '', 0, 0),
(4, 'rmukherjee', 'rmukherjee', 'rm@rc.com', 4, 23, '2017-02-10 15:18:52', 'Rishi', 'Mukherjee', NULL, '', '', '', 0, 0, 0, '', '', '', '', 0, 0),
(5, 'viraj', 'viraj', 'vr@rc.com', 5, 32, '2017-02-10 15:18:55', 'Vikram', 'Raj', NULL, '', '', '', 0, 0, 0, '', '', '', '', 0, 0),
(6, 'sanborn', 'sanborn', 'sanborn@rc.com', 6, 21, '2017-02-10 15:18:57', 'Sanborn', 'Sen', NULL, '', '', '', 0, 0, 0, '', '', '', '', 0, 0),
(7, 'michv', 'michv', 'michv@rc.com', 7, 21, '2017-02-10 15:18:59', 'Michael', 'Virgil', NULL, '', '', '', 0, 0, 0, '', '', '', '', 0, 0),
(8, 'luna', 'luna', 'luna@rc.com', 8, 29, '2017-02-10 15:19:00', 'Luna', 'Virgil', NULL, '', '', '', 0, 0, 0, '', '', '', '', 0, 0),
(9, 'naina', 'naina', 'naina@rc.com', 9, 29, '2017-02-10 15:19:02', 'Naina', 'Kaur', NULL, '', '', '', 0, 0, 0, '', '', '', '', 0, 0),
(10, 'sanborn2', 'a91c170933a7deb1906e4747a6daa946', 'sanborn.sen+2@gmail.com', 0, 1, '2017-03-09 04:40:08', 'Sudipta', 'Sen', NULL, '', '', '', 0, 0, 0, '', '', '', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `user_id`, `role_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 1),
(5, 5, 2),
(6, 6, 3),
(7, 7, 1),
(8, 8, 2),
(9, 9, 3),
(10, 9, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `interest`
--
ALTER TABLE `interest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `interest`
--
ALTER TABLE `interest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

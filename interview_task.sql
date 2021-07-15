-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2021 at 04:31 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `interview_task`
--

-- --------------------------------------------------------

--
-- Table structure for table `an_content`
--

CREATE TABLE `an_content` (
  `content_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content_tag` varchar(50) NOT NULL,
  `content_author` varchar(50) NOT NULL,
  `content_title` varchar(255) NOT NULL,
  `content_story_text` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `an_user`
--

CREATE TABLE `an_user` (
  `user_id` int(11) NOT NULL,
  `user_first_name` varchar(100) NOT NULL,
  `user_last_name` varchar(100) NOT NULL,
  `user_email` varchar(150) NOT NULL,
  `user_phone` varchar(15) NOT NULL,
  `user_dob` varchar(15) NOT NULL,
  `user_country` varchar(10) NOT NULL,
  `user_subscription` varchar(20) NOT NULL,
  `user_password` varchar(150) NOT NULL,
  `user_created_at` datetime NOT NULL,
  `user_updated_at` datetime NOT NULL,
  `user_login_attempt` int(11) NOT NULL,
  `user_last_login_attempt` datetime NOT NULL,
  `user_code` varchar(150) NOT NULL,
  `user_role` varchar(15) NOT NULL,
  `user_status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `an_user`
--

INSERT INTO `an_user` (`user_id`, `user_first_name`, `user_last_name`, `user_email`, `user_phone`, `user_dob`, `user_country`, `user_subscription`, `user_password`, `user_created_at`, `user_updated_at`, `user_login_attempt`, `user_last_login_attempt`, `user_code`, `user_role`, `user_status`) VALUES
(16, 'Admin', 'Admin', 'admin@gmail.com', '0111111111', '07/12/2021', 'UK', 'story', '$2y$09$XTqES7k5ARi0B4cfIiJ9oe.N18ie.YdbAvpOrXsTwd0S..G7PxuoK', '0000-00-00 00:00:00', '2021-07-15 19:13:28', 0, '2021-07-15 19:57:22', '2dac13bae8a71b007a3fa039cf443d3de86e9192', 'administrator', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `an_content`
--
ALTER TABLE `an_content`
  ADD PRIMARY KEY (`content_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `an_user`
--
ALTER TABLE `an_user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_email` (`user_email`),
  ADD KEY `user_code` (`user_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `an_content`
--
ALTER TABLE `an_content`
  MODIFY `content_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=381;

--
-- AUTO_INCREMENT for table `an_user`
--
ALTER TABLE `an_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

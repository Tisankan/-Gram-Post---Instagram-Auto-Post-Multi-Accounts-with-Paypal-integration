-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2017 at 04:34 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_instagram_post2`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `data` text,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `instagram_accounts`
--

DROP TABLE IF EXISTS `instagram_accounts`;
CREATE TABLE `instagram_accounts` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `fid` varchar(32) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `instagram_schedules`
--

DROP TABLE IF EXISTS `instagram_schedules`;
CREATE TABLE `instagram_schedules` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `account_name` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `group_id` varchar(255) DEFAULT NULL,
  `group_type` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `privacy` varchar(255) DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4,
  `title` varchar(255) DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4,
  `url` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `time_post` datetime DEFAULT NULL,
  `time_post_show` datetime DEFAULT NULL,
  `delete_post` int(1) DEFAULT '0',
  `deplay` int(11) DEFAULT NULL,
  `repeat_post` int(1) DEFAULT '0',
  `repeat_time` int(11) DEFAULT NULL,
  `repeat_end` date DEFAULT NULL,
  `result` varchar(255) DEFAULT NULL,
  `message_error` text,
  `status` int(1) DEFAULT '1',
  `changed` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `save`
--

DROP TABLE IF EXISTS `save`;
CREATE TABLE `save` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `message` text,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `caption` varchar(255) DEFAULT NULL,
  `url` text,
  `image` text,
  `status` int(1) DEFAULT '1',
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `website_title` text,
  `website_description` text,
  `website_keyword` text,
  `logo` varchar(255) DEFAULT NULL,
  `theme_color` varchar(255) DEFAULT NULL,
  `timezone` varchar(255) DEFAULT NULL,
  `upload_max_size` int(11) DEFAULT '5',
  `register` int(1) DEFAULT '1',
  `auto_active_user` int(1) DEFAULT '1',
  `default_language` varchar(255) DEFAULT NULL,
  `default_deplay` int(11) DEFAULT NULL,
  `default_deplay_post_now` int(11) DEFAULT NULL,
  `minimum_deplay` int(11) DEFAULT NULL,
  `minimum_deplay_post_now` int(11) NOT NULL,
  `maximum_account_default` int(11) DEFAULT '0',
  `trial` int(11) DEFAULT NULL,
  `purchase_code` varchar(255) DEFAULT NULL,
  `facebook_id` varchar(255) DEFAULT NULL,
  `facebook_secret` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `google_secret` varchar(255) DEFAULT NULL,
  `twitter_id` varchar(255) DEFAULT NULL,
  `twitter_secret` varchar(255) DEFAULT NULL,
  `facebook_page` varchar(255) DEFAULT NULL,
  `twitter_page` varchar(255) DEFAULT NULL,
  `pinterest_page` varchar(255) DEFAULT NULL,
  `instagram_page` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `website_title`, `website_description`, `website_keyword`, `logo`, `theme_color`, `timezone`, `upload_max_size`, `register`, `auto_active_user`, `default_language`, `default_deplay`, `default_deplay_post_now`, `minimum_deplay`, `minimum_deplay_post_now`, `maximum_account_default`, `trial`, `purchase_code`, `facebook_id`, `facebook_secret`, `google_id`, `google_secret`, `twitter_id`, `twitter_secret`, `facebook_page`, `twitter_page`, `pinterest_page`, `instagram_page`) VALUES
(1, 'GRAMPOSTER - Instagram Auto Post Multi Accounts', 'The ultimate way to help your marketing effectiveness on Instagram today', 'The ultimate way to help your marketing effectiveness on Instagram today', 'assets/images/logo.png', 'red', 'admin_timezone', 30, 1, 1, 'en', 5, 10, 5, 10, 5, 3, 'ITEM-PURCHASE-CODE', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_management`
--

DROP TABLE IF EXISTS `user_management`;
CREATE TABLE `user_management` (
  `id` int(11) NOT NULL,
  `admin` int(1) DEFAULT '0',
  `type` varchar(255) DEFAULT NULL,
  `pid` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `maximum_account` int(11) DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `history_id` text,
  `timezone` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `changed` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_management`
--

INSERT INTO `user_management` (`id`, `admin`, `type`, `pid`, `fullname`, `email`, `password`, `maximum_account`, `expiration_date`, `history_id`, `timezone`, `status`, `changed`, `created`) VALUES
(1, 1, 'direct', NULL, 'admin_fullname', 'admin_email', 'admin_password', 1, '2016-12-25', NULL, 'admin_timezone', 1, '2017-01-03 14:11:55', '2016-09-30 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `instagram_accounts`
--
ALTER TABLE `instagram_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `instagram_schedules`
--
ALTER TABLE `instagram_schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `save`
--
ALTER TABLE `save`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_management`
--
ALTER TABLE `user_management`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `instagram_accounts`
--
ALTER TABLE `instagram_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `instagram_schedules`
--
ALTER TABLE `instagram_schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `save`
--
ALTER TABLE `save`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user_management`
--
ALTER TABLE `user_management`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 06, 2021 at 08:02 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food_order`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_username` varchar(255) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `admin_username`, `admin_email`, `admin_password`) VALUES
(1, 'admin', 'atechseva@gmail.com', '$2y$10$VuYmnw5u7THH0RTiDRGOSOpZxF/rH7Pvnc6DzKqaGOJ1IVjCxwo9S');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category`, `order_number`, `status`, `added_on`) VALUES
(8, 'sagar kumar', '10', 1, '2021-08-05 17:04:14'),
(4, 'VEGi', '5', 0, '2021-08-03 21:13:16'),
(5, 'hello word', 'bjb', 1, '2021-08-05 05:10:23'),
(6, '', '', 1, '2021-08-03 21:25:13'),
(9, 'dlt', '44', 1, '2021-08-05 05:07:15'),
(10, 'Men', 'cd', 1, '2021-08-05 05:07:31'),
(11, 'welcome', '20', 1, '2021-08-05 05:08:03'),
(12, 'Menjnnnnnnnnnnnnnnnn', '66', 1, '2021-08-05 05:09:28'),
(13, 'hi', '4', 1, '2021-08-05 05:14:25'),
(14, 'sagar', '4', 1, '2021-08-05 05:14:54');

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

DROP TABLE IF EXISTS `coupon`;
CREATE TABLE IF NOT EXISTS `coupon` (
  `coupon_id` int(11) NOT NULL AUTO_INCREMENT,
  `coupon_code` varchar(255) NOT NULL,
  `coupon_type` enum('P','F') NOT NULL,
  `coupon_value` varchar(255) NOT NULL,
  `cart_min_value` varchar(255) NOT NULL,
  `expired_on` datetime DEFAULT NULL,
  `status` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  PRIMARY KEY (`coupon_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coupon`
--

INSERT INTO `coupon` (`coupon_id`, `coupon_code`, `coupon_type`, `coupon_value`, `cart_min_value`, `expired_on`, `status`, `added_on`) VALUES
(5, 'atechseva1', 'P', '50', '500', '2021-08-08 00:00:00', 1, '2021-08-05 08:19:11');

-- --------------------------------------------------------

--
-- Table structure for table `delievery_boy`
--

DROP TABLE IF EXISTS `delievery_boy`;
CREATE TABLE IF NOT EXISTS `delievery_boy` (
  `delievery_boy_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  PRIMARY KEY (`delievery_boy_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delievery_boy`
--

INSERT INTO `delievery_boy` (`delievery_boy_id`, `name`, `mobile`, `password`, `status`, `added_on`) VALUES
(2, 'hi', '48548', '', 0, '2021-08-24 18:16:35'),
(3, 'sagar kumar', 'ss', 's', 1, '2021-08-05 06:37:04'),
(4, '', '', '', 1, '2021-08-05 06:37:18'),
(5, 'testatechweb', 'a55', 'ss', 1, '2021-08-05 06:38:30'),
(6, 'nj5555', 'njin', 'ini', 1, '2021-08-05 06:38:47');

-- --------------------------------------------------------

--
-- Table structure for table `dish`
--

DROP TABLE IF EXISTS `dish`;
CREATE TABLE IF NOT EXISTS `dish` (
  `dish_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `dish` varchar(255) NOT NULL,
  `dish_detail` longtext NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  PRIMARY KEY (`dish_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dish`
--

INSERT INTO `dish` (`dish_id`, `category_id`, `dish`, `dish_detail`, `image`, `status`, `added_on`) VALUES
(3, 10, 'men kum', 'men detail', '', 1, '2021-08-06 12:33:44'),
(4, 14, 'newwwwww', 'new dish', NULL, 1, '2021-08-06 12:45:00'),
(5, 13, 'hi', 'hi', NULL, 1, '2021-08-06 12:46:16');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `email`, `mobile`, `password`, `status`, `added_on`) VALUES
(2, 'sagar ', 'sagar10@gmail.com', '07017742830', '', 1, '2021-08-03 17:33:13');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

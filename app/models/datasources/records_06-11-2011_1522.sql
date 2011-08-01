-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 10, 2011 at 07:42 PM
-- Server version: 5.5.9
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `records`
--

-- --------------------------------------------------------

--
-- Table structure for table `rclocks`
--

CREATE TABLE `rclocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `complete` tinyint(1) NOT NULL DEFAULT '0',
  `in` datetime NOT NULL,
  `out` datetime NOT NULL,
  `break` int(20) NOT NULL,
  `rate` decimal(8,2) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `rclocks`
--

INSERT INTO `rclocks` VALUES(9, 1, 1, '2011-05-31 12:22:19', '2011-05-31 12:24:00', 0, 25.00, 0.70, '2011-05-31 12:22:19', '2011-05-31 12:24:54');
INSERT INTO `rclocks` VALUES(11, 1, 1, '2011-05-31 17:35:14', '2011-06-08 00:04:53', 0, 25.00, 0.00, '2011-05-31 17:35:14', '2011-06-08 00:04:53');
INSERT INTO `rclocks` VALUES(15, 12, 0, '2011-06-08 00:07:31', '0000-00-00 00:00:00', 0, 7.55, 0.00, '2011-06-08 00:07:31', '2011-06-08 00:07:31');

-- --------------------------------------------------------

--
-- Table structure for table `rpayments`
--

CREATE TABLE `rpayments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `tip` decimal(10,2) NOT NULL,
  `type` varchar(15) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `rpayments`
--

INSERT INTO `rpayments` VALUES(1, 129, 11.33, 0.00, 'cash', '2011-06-09 03:10:45', '2011-06-09 03:10:45');

-- --------------------------------------------------------

--
-- Table structure for table `rseats`
--

CREATE TABLE `rseats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL,
  `seat` int(8) NOT NULL,
  `orig_seat` int(8) NOT NULL,
  `items` text NOT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `void` text,
  `group` int(2) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76 ;

--
-- Dumping data for table `rseats`
--

INSERT INTO `rseats` VALUES(65, 125, 1, 0, '2(5:),', NULL, NULL, NULL, '2011-06-07 16:04:13', '2011-06-07 16:04:13');
INSERT INTO `rseats` VALUES(74, 129, 1, 0, '4(1:),17(),', 9.18, NULL, NULL, '2011-06-07 23:50:37', '2011-06-07 23:50:37');
INSERT INTO `rseats` VALUES(75, 129, 2, 0, '14(),', 1.29, NULL, NULL, '2011-06-07 23:50:37', '2011-06-07 23:50:37');

-- --------------------------------------------------------

--
-- Table structure for table `rtickets`
--

CREATE TABLE `rtickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dailyid` int(11) NOT NULL,
  `original_id` int(11) NOT NULL,
  `original_daily_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `table` varchar(250) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `type_id` int(11) NOT NULL,
  `amount` int(7) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=131 ;

--
-- Dumping data for table `rtickets`
--

INSERT INTO `rtickets` VALUES(125, 2, 0, 0, 12, '7', 0, 1, 0, '2011-06-07 16:04:09', '2011-06-07 16:04:09');
INSERT INTO `rtickets` VALUES(129, 3, 0, 0, 1, '5', 2, 1, 0, '2011-06-07 23:50:23', '2011-06-09 03:10:45');
INSERT INTO `rtickets` VALUES(130, 4, 0, 0, 12, '6', 0, 1, 0, '2011-06-09 21:07:24', '2011-06-09 21:07:24');

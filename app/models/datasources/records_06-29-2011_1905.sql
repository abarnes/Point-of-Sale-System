-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 29, 2011 at 07:05 PM
-- Server version: 5.1.44
-- PHP Version: 5.3.2

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
-- Table structure for table `clocks`
--

CREATE TABLE `clocks` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `clocks`
--

INSERT INTO `clocks` VALUES(15, 21, 1, '2011-06-17 11:44:21', '2011-06-17 12:33:30', 0, 25.00, 20.48, '2011-06-17 11:44:21', '2011-06-17 12:33:30');
INSERT INTO `clocks` VALUES(16, 21, 1, '2011-06-17 12:37:01', '2011-06-17 13:31:20', 0, 25.00, 22.63, '2011-06-17 12:37:01', '2011-06-17 13:31:20');
INSERT INTO `clocks` VALUES(17, 21, 1, '2011-06-17 13:31:31', '2011-06-17 20:25:40', 0, 25.00, 172.56, '2011-06-17 13:31:31', '2011-06-17 20:25:40');
INSERT INTO `clocks` VALUES(19, 21, 1, '2011-06-25 11:23:31', '2011-06-25 14:05:39', 0, 25.00, 67.56, '2011-06-24 10:25:31', '2011-06-25 14:05:39');
INSERT INTO `clocks` VALUES(20, 21, 1, '2011-06-25 16:44:23', '2011-06-25 22:30:19', 0, 25.00, 144.14, '2011-06-25 16:44:23', '2011-06-25 22:30:19');
INSERT INTO `clocks` VALUES(21, 22, 1, '2011-06-25 22:30:23', '2011-06-25 22:30:32', 0, 10.00, 0.03, '2011-06-25 22:30:23', '2011-06-25 22:30:32');
INSERT INTO `clocks` VALUES(22, 21, 1, '2011-06-25 22:30:38', '2011-06-28 11:11:24', 0, 25.00, 1516.99, '2011-06-25 22:30:38', '2011-06-28 11:11:24');
INSERT INTO `clocks` VALUES(23, 21, 1, '2011-06-28 11:11:48', '2011-06-28 11:30:57', 0, 25.00, 7.98, '2011-06-28 11:11:48', '2011-06-28 11:30:57');
INSERT INTO `clocks` VALUES(24, 22, 1, '2011-06-28 11:49:22', '2011-06-28 11:52:06', 0, 10.00, 0.46, '2011-06-28 11:49:22', '2011-06-28 11:52:06');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `tip` decimal(10,2) NOT NULL,
  `type` varchar(15) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` VALUES(8, 165, 21, 7.98, 0.00, 'cash', '2011-06-28 17:42:04', '2011-06-29 17:42:04');
INSERT INTO `payments` VALUES(7, 166, 21, 41.19, 12.50, 'credit', '2011-06-28 17:41:56', '2011-06-29 17:41:56');
INSERT INTO `payments` VALUES(6, 166, 21, 10.00, 0.00, 'check', '2011-06-28 17:41:56', '2011-06-29 17:41:56');
INSERT INTO `payments` VALUES(5, 166, 21, 20.00, 0.00, 'cash', '2011-06-28 17:41:56', '2011-06-29 17:41:56');

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=98 ;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` VALUES(75, 129, 2, 0, '14(),', 1.29, NULL, NULL, '2011-06-07 23:50:37', '2011-06-11 15:18:30');
INSERT INTO `seats` VALUES(74, 129, 1, 0, '4(1:),17(),', 9.18, NULL, NULL, '2011-06-07 23:50:37', '2011-06-07 23:50:37');
INSERT INTO `seats` VALUES(65, 125, 1, 0, '2(5:),', NULL, NULL, NULL, '2011-06-07 16:04:13', '2011-06-07 16:04:13');
INSERT INTO `seats` VALUES(89, 166, 1, 0, '2(1:),14(),13(),', 8.47, NULL, NULL, '2011-06-29 17:40:00', '2011-06-29 17:40:00');
INSERT INTO `seats` VALUES(91, 166, 3, 0, '10(),14(),', 5.28, NULL, NULL, '2011-06-29 17:40:00', '2011-06-29 17:40:00');
INSERT INTO `seats` VALUES(92, 166, 4, 0, '1(2:6:7:8:9:),17(15:),11(),', 9.65, NULL, NULL, '2011-06-29 17:40:00', '2011-06-29 17:40:00');
INSERT INTO `seats` VALUES(90, 166, 2, 0, '15(9:1:),14(),', 5.57, NULL, NULL, '2011-06-29 17:40:00', '2011-06-29 17:40:00');
INSERT INTO `seats` VALUES(93, 166, 5, 0, '4(1:3:),12(),', 6.88, NULL, NULL, '2011-06-29 17:40:00', '2011-06-29 17:40:00');
INSERT INTO `seats` VALUES(94, 166, 6, 0, '15(2:6:),11(),', 5.48, NULL, NULL, '2011-06-29 17:40:00', '2011-06-29 17:40:00');
INSERT INTO `seats` VALUES(95, 166, 7, 0, '4(1:3:4:),9(),', 6.88, NULL, NULL, '2011-06-29 17:40:00', '2011-06-29 17:40:00');
INSERT INTO `seats` VALUES(96, 166, 8, 0, '3(5:),', 4.99, NULL, NULL, '2011-06-29 17:40:00', '2011-06-29 17:40:00');
INSERT INTO `seats` VALUES(97, 166, 9, 0, '16(),6(1:2:6:),13(),9(),', 12.56, NULL, NULL, '2011-06-29 17:40:00', '2011-06-29 17:40:00');
INSERT INTO `seats` VALUES(88, 165, 1, 0, '7(4:10:),9(),', 7.37, NULL, NULL, '2011-06-29 17:37:50', '2011-06-29 17:37:50');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dailyid` int(11) NOT NULL,
  `original_id` int(11) DEFAULT NULL,
  `original_daily_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `table` varchar(250) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `type_id` int(11) NOT NULL,
  `amount` int(7) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=167 ;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` VALUES(131, 5, 0, 0, 1, '6', 0, 1, 0, '2011-06-10 13:31:08', '2011-06-10 13:31:08');
INSERT INTO `tickets` VALUES(130, 4, 0, 0, 1, '6', 0, 1, 0, '2011-06-10 11:51:07', '2011-06-10 11:51:07');
INSERT INTO `tickets` VALUES(129, 3, 0, 0, 1, '5', 0, 1, 0, '2011-06-07 23:50:23', '2011-06-09 15:44:12');
INSERT INTO `tickets` VALUES(125, 2, 0, 0, 12, '7', 0, 1, 0, '2011-06-07 16:04:09', '2011-06-07 16:04:09');
INSERT INTO `tickets` VALUES(166, 3, NULL, NULL, 21, '55', 2, 1, 0, '2011-06-28 17:38:00', '2011-06-29 17:41:56');
INSERT INTO `tickets` VALUES(165, 2, NULL, NULL, 21, '1', 2, 1, 0, '2011-06-28 17:37:42', '2011-06-29 17:42:04');

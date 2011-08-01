-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 23, 2011 at 04:28 PM
-- Server version: 5.1.44
-- PHP Version: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `barnespossystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `apis`
--

CREATE TABLE `apis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `results` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `apis`
--


-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `enable` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` VALUES(4, 'Lunch', 1, '2011-01-18 15:03:49', '2011-01-18 15:03:49');
INSERT INTO `categories` VALUES(3, 'Breakfast', 1, '2011-01-18 15:01:43', '2011-01-18 15:01:43');
INSERT INTO `categories` VALUES(7, 'Dessert', 0, '2011-01-18 21:43:28', '2011-01-18 21:43:28');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `extra` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `enable` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` VALUES(1, 4, 'Single Steakburger', 'Plain, single burger.  Delicious with bacon.', '', 3.69, 1, '2011-01-18 18:57:57', '2011-01-18 22:07:46');
INSERT INTO `items` VALUES(2, 4, 'Frisco Melt', 'Delicious.', '', 5.19, 1, '2011-01-18 21:23:28', '2011-01-18 22:11:04');
INSERT INTO `items` VALUES(3, 3, 'Country Scrambler', 'Eggs smothered in gravy', '', 4.99, 1, '2011-01-18 21:26:40', '2011-01-18 22:08:03');

-- --------------------------------------------------------

--
-- Table structure for table `items_modifiers`
--

CREATE TABLE `items_modifiers` (
  `item_id` int(11) NOT NULL,
  `modifier_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items_modifiers`
--

INSERT INTO `items_modifiers` VALUES(2, 1);
INSERT INTO `items_modifiers` VALUES(1, 2);
INSERT INTO `items_modifiers` VALUES(1, 1);
INSERT INTO `items_modifiers` VALUES(1, 3);
INSERT INTO `items_modifiers` VALUES(2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `modifiers`
--

CREATE TABLE `modifiers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `enable` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `modifiers`
--

INSERT INTO `modifiers` VALUES(1, 'Ketchup', 'Heinz Ketchup', 0.00, 1, '2011-01-18 18:55:25', '2011-01-18 18:55:25');
INSERT INTO `modifiers` VALUES(2, 'Lettuce', 'Crisp Lettuce', 0.00, 1, '2011-01-18 18:55:36', '2011-01-18 18:55:36');
INSERT INTO `modifiers` VALUES(3, 'BBQ Sauce', 'Tangy, Texas-style BBQ sauce', 0.10, 1, '2011-01-18 21:38:35', '2011-01-18 22:09:51');

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL,
  `items` text NOT NULL,
  `void` text,
  `group` int(2) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `seats`
--


-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dailyid` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `table` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `type_id` int(11) NOT NULL,
  `amount` int(7) NOT NULL,
  `pay_method` varchar(50) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` VALUES(20, 1, 0, 21, 0, 1, 0, '', '2011-01-23 15:24:55', '2011-01-23 15:24:55');

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `use_seats` tinyint(1) NOT NULL,
  `enable` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `types`
--

INSERT INTO `types` VALUES(1, 'Dine-In', 1, 1, '2011-01-21 16:37:32', '2011-01-21 16:37:32');
INSERT INTO `types` VALUES(2, 'Drive-Thru', 0, 0, '2011-01-21 16:37:43', '2011-01-21 16:38:38');
INSERT INTO `types` VALUES(3, 'Carry-Out', 0, 1, '2011-01-21 16:37:51', '2011-01-21 16:38:46');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `level` tinyint(1) NOT NULL DEFAULT '2',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` VALUES(1, 'austin', 'e36ceb97a9d4141a430a7d9230b4a119c2714ed3', 'austin@austinbarnes.net', 1, '2011-01-18 14:54:09', '2011-01-18 14:54:09');
INSERT INTO `users` VALUES(2, 'Bob the Waiter', '7fa70bb584e082ed14443bdfb3dbe0bad0eea84b', 'bob@email34.com', 2, '2011-01-18 21:40:23', '2011-01-18 22:01:02');
INSERT INTO `users` VALUES(12, 'kyle', '7fa70bb584e082ed14443bdfb3dbe0bad0eea84b', 'kylebarnes@kentium.net', 1, '2011-01-18 22:30:31', '2011-01-18 22:30:31');

-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 29, 2011 at 10:01 PM
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` VALUES(4, 'Lunch', 1, '2011-01-18 15:03:49', '2011-01-18 15:03:49');
INSERT INTO `categories` VALUES(3, 'Breakfast', 1, '2011-01-18 15:01:43', '2011-01-18 15:01:43');
INSERT INTO `categories` VALUES(7, 'Dessert', 1, '2011-01-18 21:43:28', '2011-01-29 13:32:37');
INSERT INTO `categories` VALUES(8, 'Drinks', 1, '2011-01-29 19:44:26', '2011-01-29 19:44:26');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_name` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `mods_on` tinyint(1) NOT NULL,
  `extra` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `enable` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` VALUES(1, 4, 'Single Steakburger', 'Single Stk', 'Plain, single burger.  Delicious with bacon.', 1, '', 3.69, 1, '2011-01-18 18:57:57', '2011-01-29 21:37:10');
INSERT INTO `items` VALUES(2, 4, 'Frisco Melt', 'Frisco Mlt', 'Delicious.', 1, '', 5.19, 1, '2011-01-18 21:23:28', '2011-01-18 22:11:04');
INSERT INTO `items` VALUES(3, 3, 'Country Scrambler', 'Country Scr', 'Eggs smothered in gravy', 1, '', 4.99, 1, '2011-01-18 21:26:40', '2011-01-29 21:38:25');
INSERT INTO `items` VALUES(4, 4, 'Chicken Melt', 'Chicken Mlt', 'Delicious', 1, '', 5.29, 1, '2011-01-29 15:08:48', '2011-01-29 21:38:33');
INSERT INTO `items` VALUES(5, 4, 'Apple Walnut Chicken Salad', 'Apl Walnut', 'Salad', 1, '', 5.99, 1, '2011-01-29 15:09:15', '2011-01-29 21:39:04');
INSERT INTO `items` VALUES(6, 4, 'Triple Steakburger', 'Triple Stk', 'Big burger', 1, '', 4.99, 1, '2011-01-29 15:10:17', '2011-01-29 21:39:23');
INSERT INTO `items` VALUES(7, 4, 'Turkey Club', 'Turkey Cl', 'Sandwich', 1, '', 4.89, 1, '2011-01-29 15:12:15', '2011-01-29 21:39:34');
INSERT INTO `items` VALUES(8, 4, 'Chicken Finger Dinner', 'Chk Fn Dinner', 'Chicken fingers', 1, '', 5.49, 1, '2011-01-29 15:13:42', '2011-01-29 21:40:12');
INSERT INTO `items` VALUES(9, 8, 'Coke', 'Coke', 'Coke', 0, '', 1.49, 1, '2011-01-29 19:44:40', '2011-01-29 21:40:20');

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
INSERT INTO `items_modifiers` VALUES(4, 2);
INSERT INTO `items_modifiers` VALUES(4, 1);
INSERT INTO `items_modifiers` VALUES(4, 3);
INSERT INTO `items_modifiers` VALUES(5, 2);
INSERT INTO `items_modifiers` VALUES(6, 2);
INSERT INTO `items_modifiers` VALUES(6, 1);
INSERT INTO `items_modifiers` VALUES(6, 3);
INSERT INTO `items_modifiers` VALUES(7, 2);
INSERT INTO `items_modifiers` VALUES(7, 1);
INSERT INTO `items_modifiers` VALUES(7, 3);
INSERT INTO `items_modifiers` VALUES(8, 3);

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
  `seat` int(5) NOT NULL,
  `items` text NOT NULL,
  `void` text,
  `group` int(2) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` VALUES(38, 34, 2, '5(2:),9(),', NULL, NULL, '2011-01-29 21:42:55', '2011-01-29 21:42:55');
INSERT INTO `seats` VALUES(37, 34, 1, '8(3:),2(1:),', NULL, NULL, '2011-01-29 21:42:55', '2011-01-29 21:42:55');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` VALUES(35, 2, 1, 20, 0, 1, 0, '', '2011-01-29 21:45:36', '2011-01-29 21:45:36');
INSERT INTO `tickets` VALUES(34, 1, 1, 20, 0, 1, 0, '', '2011-01-29 21:41:47', '2011-01-29 21:41:47');

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

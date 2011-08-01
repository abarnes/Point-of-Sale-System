-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 08, 2011 at 12:15 AM
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` VALUES(4, 'Lunch/Dinner', 1, '2011-01-18 15:03:49', '2011-01-29 23:36:23');
INSERT INTO `categories` VALUES(3, 'Breakfast', 1, '2011-01-18 15:01:43', '2011-01-18 15:01:43');
INSERT INTO `categories` VALUES(7, 'Dessert', 1, '2011-01-18 21:43:28', '2011-01-30 17:44:39');
INSERT INTO `categories` VALUES(8, 'Drinks', 1, '2011-01-29 19:44:26', '2011-01-29 19:44:26');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `clocks`
--

INSERT INTO `clocks` VALUES(9, 1, 1, '2011-05-31 12:22:19', '2011-05-31 12:24:00', 0, 25.00, 0.70, '2011-05-31 12:22:19', '2011-05-31 12:24:54');
INSERT INTO `clocks` VALUES(11, 1, 1, '2011-05-31 17:35:14', '2011-06-08 00:04:53', 0, 25.00, 0.00, '2011-05-31 17:35:14', '2011-06-08 00:04:53');
INSERT INTO `clocks` VALUES(15, 12, 0, '2011-06-08 00:07:31', '0000-00-00 00:00:00', 0, 7.55, 0.00, '2011-06-08 00:07:31', '2011-06-08 00:07:31');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

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
INSERT INTO `items` VALUES(10, 3, 'French Toast', 'Fr Toast', 'French Toast topped with strawberries', 0, '', 3.99, 1, '2011-01-29 23:29:16', '2011-01-29 23:29:16');
INSERT INTO `items` VALUES(11, 8, 'Sweet Tea', 'Sweet Tea', 'Sweet Tea', 0, '', 1.49, 1, '2011-01-29 23:29:59', '2011-01-29 23:29:59');
INSERT INTO `items` VALUES(12, 8, 'Dr. Pepper', 'Dr. Pepper', 'Dr. Pepper', 0, '', 1.49, 0, '2011-01-29 23:31:01', '2011-01-30 17:44:54');
INSERT INTO `items` VALUES(13, 7, 'Hot Fudge Sundae', 'HF Sundae', 'Hot Fudge Sundae', 0, '', 1.99, 1, '2011-01-29 23:32:25', '2011-01-29 23:32:25');
INSERT INTO `items` VALUES(14, 8, 'Coffee', 'Coffee', 'Regular Coffee', 0, '', 1.29, 1, '2011-01-29 23:34:08', '2011-01-29 23:34:08');
INSERT INTO `items` VALUES(15, 4, 'Spicy Chicken Sandwich', 'Spicy Chk', 'Spicy Chicken Sandwich', 1, '', 3.99, 1, '2011-01-29 23:35:17', '2011-01-29 23:35:17');
INSERT INTO `items` VALUES(16, 4, 'Chili 3-way', 'Chili 3-way', 'Chili on Spaghetti Noodles', 0, '', 4.09, 1, '2011-01-29 23:45:46', '2011-01-29 23:45:46');
INSERT INTO `items` VALUES(17, 4, 'Double Steakburger', 'Dbl Stk', 'Two steak patties on a bun.', 1, '', 3.89, 1, '2011-01-30 17:10:18', '2011-01-30 17:10:18');

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
INSERT INTO `items_modifiers` VALUES(5, 4);
INSERT INTO `items_modifiers` VALUES(8, 4);
INSERT INTO `items_modifiers` VALUES(4, 4);
INSERT INTO `items_modifiers` VALUES(3, 4);
INSERT INTO `items_modifiers` VALUES(2, 4);
INSERT INTO `items_modifiers` VALUES(1, 4);
INSERT INTO `items_modifiers` VALUES(6, 4);
INSERT INTO `items_modifiers` VALUES(7, 4);
INSERT INTO `items_modifiers` VALUES(5, 5);
INSERT INTO `items_modifiers` VALUES(8, 5);
INSERT INTO `items_modifiers` VALUES(4, 5);
INSERT INTO `items_modifiers` VALUES(3, 5);
INSERT INTO `items_modifiers` VALUES(2, 5);
INSERT INTO `items_modifiers` VALUES(1, 5);
INSERT INTO `items_modifiers` VALUES(6, 5);
INSERT INTO `items_modifiers` VALUES(7, 5);
INSERT INTO `items_modifiers` VALUES(5, 6);
INSERT INTO `items_modifiers` VALUES(8, 6);
INSERT INTO `items_modifiers` VALUES(4, 6);
INSERT INTO `items_modifiers` VALUES(3, 6);
INSERT INTO `items_modifiers` VALUES(2, 6);
INSERT INTO `items_modifiers` VALUES(1, 6);
INSERT INTO `items_modifiers` VALUES(6, 6);
INSERT INTO `items_modifiers` VALUES(7, 6);
INSERT INTO `items_modifiers` VALUES(5, 7);
INSERT INTO `items_modifiers` VALUES(8, 7);
INSERT INTO `items_modifiers` VALUES(4, 7);
INSERT INTO `items_modifiers` VALUES(2, 7);
INSERT INTO `items_modifiers` VALUES(1, 7);
INSERT INTO `items_modifiers` VALUES(6, 7);
INSERT INTO `items_modifiers` VALUES(7, 7);
INSERT INTO `items_modifiers` VALUES(4, 8);
INSERT INTO `items_modifiers` VALUES(2, 8);
INSERT INTO `items_modifiers` VALUES(1, 8);
INSERT INTO `items_modifiers` VALUES(6, 8);
INSERT INTO `items_modifiers` VALUES(7, 8);
INSERT INTO `items_modifiers` VALUES(4, 9);
INSERT INTO `items_modifiers` VALUES(2, 9);
INSERT INTO `items_modifiers` VALUES(1, 9);
INSERT INTO `items_modifiers` VALUES(6, 9);
INSERT INTO `items_modifiers` VALUES(7, 9);
INSERT INTO `items_modifiers` VALUES(4, 10);
INSERT INTO `items_modifiers` VALUES(3, 10);
INSERT INTO `items_modifiers` VALUES(2, 10);
INSERT INTO `items_modifiers` VALUES(1, 10);
INSERT INTO `items_modifiers` VALUES(6, 10);
INSERT INTO `items_modifiers` VALUES(7, 10);
INSERT INTO `items_modifiers` VALUES(4, 11);
INSERT INTO `items_modifiers` VALUES(2, 11);
INSERT INTO `items_modifiers` VALUES(1, 11);
INSERT INTO `items_modifiers` VALUES(6, 11);
INSERT INTO `items_modifiers` VALUES(7, 11);
INSERT INTO `items_modifiers` VALUES(7, 12);
INSERT INTO `items_modifiers` VALUES(6, 12);
INSERT INTO `items_modifiers` VALUES(15, 12);
INSERT INTO `items_modifiers` VALUES(1, 12);
INSERT INTO `items_modifiers` VALUES(15, 9);
INSERT INTO `items_modifiers` VALUES(4, 12);
INSERT INTO `items_modifiers` VALUES(15, 10);
INSERT INTO `items_modifiers` VALUES(15, 3);
INSERT INTO `items_modifiers` VALUES(15, 11);
INSERT INTO `items_modifiers` VALUES(15, 7);
INSERT INTO `items_modifiers` VALUES(15, 1);
INSERT INTO `items_modifiers` VALUES(15, 2);
INSERT INTO `items_modifiers` VALUES(15, 6);
INSERT INTO `items_modifiers` VALUES(15, 5);
INSERT INTO `items_modifiers` VALUES(15, 8);
INSERT INTO `items_modifiers` VALUES(15, 4);
INSERT INTO `items_modifiers` VALUES(16, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `modifiers`
--

INSERT INTO `modifiers` VALUES(1, 'Ketchup', 'Heinz Ketchup', 0.00, 1, '2011-01-18 18:55:25', '2011-01-18 18:55:25');
INSERT INTO `modifiers` VALUES(2, 'Lettuce', 'Crisp Lettuce', 0.00, 1, '2011-01-18 18:55:36', '2011-01-18 18:55:36');
INSERT INTO `modifiers` VALUES(3, 'BBQ Sauce', 'Tangy, Texas-style BBQ sauce', 0.10, 1, '2011-01-18 21:38:35', '2011-01-18 22:09:51');
INSERT INTO `modifiers` VALUES(4, 'Tomato', 'Tomato', 0.00, 1, '2011-01-29 22:47:29', '2011-01-29 22:47:29');
INSERT INTO `modifiers` VALUES(5, 'Pickles', 'Pickles', 0.00, 1, '2011-01-29 22:49:18', '2011-01-29 22:49:18');
INSERT INTO `modifiers` VALUES(6, 'Onion', 'Onion', 0.00, 1, '2011-01-29 22:49:52', '2011-01-29 22:49:52');
INSERT INTO `modifiers` VALUES(7, 'Honey Mustard', 'Honey Mustard', 0.00, 1, '2011-01-29 22:50:35', '2011-01-29 22:50:35');
INSERT INTO `modifiers` VALUES(8, 'Swiss', 'Swiss Cheese', 0.29, 1, '2011-01-29 22:52:07', '2011-01-29 22:52:07');
INSERT INTO `modifiers` VALUES(9, 'American', 'American Cheese', 0.29, 1, '2011-01-29 22:53:12', '2011-01-29 22:53:12');
INSERT INTO `modifiers` VALUES(10, 'Bacon', 'Crispy Bacon', 0.99, 1, '2011-01-29 22:54:27', '2011-01-29 22:54:27');
INSERT INTO `modifiers` VALUES(11, 'Grilled Onions', 'Sweet Grilled Onions', 0.49, 1, '2011-01-29 22:55:32', '2011-01-29 22:55:32');
INSERT INTO `modifiers` VALUES(12, 'Avocado', '', 0.39, 1, '2011-01-29 22:56:57', '2011-01-30 17:45:07');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `tip` decimal(10,2) NOT NULL,
  `type` varchar(15) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `payments`
--


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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76 ;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` VALUES(65, 125, 1, 0, '2(5:),', NULL, NULL, NULL, '2011-06-07 16:04:13', '2011-06-07 16:04:13');
INSERT INTO `seats` VALUES(74, 129, 1, 0, '4(1:),17(),', 9.18, NULL, NULL, '2011-06-07 23:50:37', '2011-06-07 23:50:37');
INSERT INTO `seats` VALUES(75, 129, 2, 0, '14(),', 1.29, NULL, NULL, '2011-06-07 23:50:37', '2011-06-07 23:50:37');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=130 ;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` VALUES(125, 2, 0, 0, 12, '7', 0, 1, 0, '2011-06-07 16:04:09', '2011-06-07 16:04:09');
INSERT INTO `tickets` VALUES(129, 3, 0, 0, 1, '5', 0, 1, 0, '2011-06-07 23:50:23', '2011-06-07 23:50:23');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `types`
--

INSERT INTO `types` VALUES(1, 'Dine-In', 1, 1, '2011-01-21 16:37:32', '2011-01-21 16:37:32');
INSERT INTO `types` VALUES(2, 'Drive-Thru', 0, 0, '2011-01-21 16:37:43', '2011-01-30 17:44:29');
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
  `rate1` decimal(10,2) NOT NULL,
  `rate2` decimal(10,2) NOT NULL,
  `rate3` decimal(10,2) NOT NULL,
  `enable` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` VALUES(1, 'austin', 'e36ceb97a9d4141a430a7d9230b4a119c2714ed3', 'austin@austinbarnes.net', 1, 25.00, 12.35, 0.00, 1, '2011-01-18 14:54:09', '2011-01-18 14:54:09');
INSERT INTO `users` VALUES(2, 'Bob the Waiter', '2ae92c101e9adb85e81f26b3fc6b0e76961b9552', 'bob@email4.com', 2, 8.10, 11.10, 7.75, 1, '2011-01-18 21:40:23', '2011-01-30 17:41:49');
INSERT INTO `users` VALUES(12, 'kyle', '7fa70bb584e082ed14443bdfb3dbe0bad0eea84b', 'kylebarnes@kentium.net', 1, 7.55, 10.50, 0.00, 1, '2011-01-18 22:30:31', '2011-01-18 22:30:31');

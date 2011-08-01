-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 28, 2011 at 12:46 PM
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
  `name` varchar(255) DEFAULT NULL,
  `enable` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` VALUES(4, 'Lunch/Dinner', 1, '2011-01-18 15:03:49', '2011-01-29 23:36:23');
INSERT INTO `categories` VALUES(3, 'Breakfast', 1, '2011-06-14 00:28:00', '2011-06-14 00:28:02');
INSERT INTO `categories` VALUES(7, 'Dessert', 1, '2011-01-18 21:43:28', '2011-01-30 17:44:39');
INSERT INTO `categories` VALUES(8, 'Drinks', 1, '2011-06-14 21:09:00', '2011-06-14 21:09:02');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

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
INSERT INTO `clocks` VALUES(25, 21, 0, '2011-06-28 11:50:56', '0000-00-00 00:00:00', 0, 25.00, 0.00, '2011-06-28 11:50:56', '2011-06-28 11:50:56');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `short_name` varchar(20) DEFAULT NULL,
  `description` text,
  `mods_on` tinyint(1) NOT NULL DEFAULT '0',
  `extra` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `enable` tinyint(1) NOT NULL DEFAULT '1',
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
INSERT INTO `items` VALUES(9, 8, 'Coke', 'Coke', 'Coke', 0, '', 1.49, 1, '2011-01-29 19:44:40', '2011-06-10 12:41:22');
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
INSERT INTO `items_modifiers` VALUES(9, 6);
INSERT INTO `items_modifiers` VALUES(9, 8);
INSERT INTO `items_modifiers` VALUES(5, 15);
INSERT INTO `items_modifiers` VALUES(8, 15);
INSERT INTO `items_modifiers` VALUES(4, 15);
INSERT INTO `items_modifiers` VALUES(16, 15);
INSERT INTO `items_modifiers` VALUES(14, 15);
INSERT INTO `items_modifiers` VALUES(9, 15);
INSERT INTO `items_modifiers` VALUES(3, 15);
INSERT INTO `items_modifiers` VALUES(17, 15);
INSERT INTO `items_modifiers` VALUES(12, 15);
INSERT INTO `items_modifiers` VALUES(10, 15);
INSERT INTO `items_modifiers` VALUES(2, 15);
INSERT INTO `items_modifiers` VALUES(13, 15);
INSERT INTO `items_modifiers` VALUES(1, 15);
INSERT INTO `items_modifiers` VALUES(15, 15);
INSERT INTO `items_modifiers` VALUES(11, 15);
INSERT INTO `items_modifiers` VALUES(6, 15);
INSERT INTO `items_modifiers` VALUES(7, 15);

-- --------------------------------------------------------

--
-- Table structure for table `modifiers`
--

CREATE TABLE `modifiers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `price` decimal(10,2) DEFAULT NULL,
  `enable` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

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
INSERT INTO `modifiers` VALUES(14, 'Ranch', '', 0.00, 1, '2011-06-13 20:14:39', '2011-06-13 20:14:39');
INSERT INTO `modifiers` VALUES(15, 'Do Not Make', 'Tells kitchen not to make this item.  It is useful when you need to add an item to a ticket but don''t want it prepared, and it is not recommended to remove this modifier.', NULL, 1, '2011-06-14 13:01:26', '2011-06-14 13:01:26');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `tip` decimal(10,2) DEFAULT NULL,
  `type` varchar(15) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` VALUES(4, 0, 0.00, NULL, '', '2011-06-11 14:22:22', '2011-06-11 14:22:22');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=86 ;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` VALUES(82, 158, 1, 0, '1(3:6:),13(),', 5.78, NULL, NULL, '2011-06-24 13:41:46', '2011-06-24 13:41:46');
INSERT INTO `seats` VALUES(76, 147, 1, 0, '2(9:10:),12(),', 7.96, NULL, NULL, '2011-06-11 18:07:46', '2011-06-13 16:28:04');
INSERT INTO `seats` VALUES(83, 158, 2, 0, '12(),10(),1(1:3:4:6:7:),', 9.27, NULL, NULL, '2011-06-24 13:41:46', '2011-06-24 13:41:46');
INSERT INTO `seats` VALUES(77, 146, 2, 0, '16(1:),14(),', 5.38, NULL, NULL, '2011-06-11 18:07:46', '2011-06-13 16:28:04');
INSERT INTO `seats` VALUES(78, 146, 3, 0, '13(),11(),', 3.48, NULL, NULL, '2011-06-11 18:07:46', '2011-06-13 16:28:04');
INSERT INTO `seats` VALUES(85, 158, 4, 0, '15(1:7:),', 3.99, NULL, NULL, '2011-06-24 13:41:46', '2011-06-24 13:41:46');
INSERT INTO `seats` VALUES(84, 158, 3, 0, '10(),', 3.99, NULL, NULL, '2011-06-24 13:41:46', '2011-06-24 13:41:46');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_name` varchar(255) NOT NULL,
  `address1` varchar(255) NOT NULL,
  `address2` varchar(255) NOT NULL,
  `address3` varchar(255) NOT NULL,
  `phone1` varchar(255) NOT NULL,
  `phone2` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `cc_process` tinyint(1) NOT NULL,
  `cc_processor` varchar(100) DEFAULT NULL,
  `authnet_loginID` varchar(255) DEFAULT NULL,
  `authnet_transkey` varchar(255) NOT NULL,
  `paypal_wpp_username` varchar(255) NOT NULL,
  `paypal_wpp_password` varchar(255) NOT NULL,
  `paypal_wpp_signature` varchar(255) NOT NULL,
  `tax` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` VALUES(1, 'Barnes POS Systems', 'add1', 'add2', '', '214-555-4444', 'phone2', 'barnespos.com', 1, '', NULL, '', '', '', '', 8.2500, '2011-06-08 13:33:57', '2011-06-14 11:53:03');

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
  `table` varchar(250) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `type_id` int(11) NOT NULL,
  `amount` int(7) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=164 ;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` VALUES(147, 10, 144, 8, 1, '5', 2, 1, 0, '2011-06-13 16:28:04', '2011-06-13 16:28:04');
INSERT INTO `tickets` VALUES(146, 9, 144, 8, 1, '5', 2, 1, 0, '2011-06-13 16:28:04', '2011-06-13 16:28:04');
INSERT INTO `tickets` VALUES(153, 12, NULL, NULL, 21, '98', 0, 1, 0, '2011-06-17 20:26:59', '2011-06-17 20:26:59');
INSERT INTO `tickets` VALUES(157, 16, NULL, NULL, 21, '2', 0, 1, 0, '2011-06-24 13:27:04', '2011-06-24 13:27:04');
INSERT INTO `tickets` VALUES(158, 17, NULL, NULL, 21, '5', 2, 1, 0, '2011-06-24 13:40:39', '2011-06-24 13:40:39');
INSERT INTO `tickets` VALUES(159, 18, NULL, NULL, 21, '199', 0, 1, 0, '2011-06-24 13:43:39', '2011-06-24 13:43:39');
INSERT INTO `tickets` VALUES(160, 19, NULL, NULL, 21, '8', 0, 1, 0, '2011-06-24 14:02:20', '2011-06-24 14:02:20');
INSERT INTO `tickets` VALUES(162, 21, NULL, NULL, 21, '2', 0, 1, 0, '2011-06-24 14:03:36', '2011-06-24 14:03:36');
INSERT INTO `tickets` VALUES(163, 22, NULL, NULL, 21, '2', 0, 1, 0, '2011-06-24 14:09:22', '2011-06-24 14:09:22');

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `use_seats` tinyint(1) NOT NULL,
  `use_tables` tinyint(1) NOT NULL,
  `enable` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `types`
--

INSERT INTO `types` VALUES(1, 'Dine-In', 1, 1, 1, '2011-01-21 16:37:32', '2011-01-21 16:37:32');
INSERT INTO `types` VALUES(2, 'Drive-Thru', 0, 0, 0, '2011-01-21 16:37:43', '2011-01-30 17:44:29');
INSERT INTO `types` VALUES(3, 'Carry-Out', 0, 0, 1, '2011-01-21 16:37:51', '2011-01-21 16:38:46');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `shortcut` int(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `level` int(1) NOT NULL DEFAULT '2',
  `rate1` decimal(10,2) NOT NULL,
  `rate2` decimal(10,2) DEFAULT NULL,
  `rate3` decimal(10,2) DEFAULT NULL,
  `enable` tinyint(1) NOT NULL DEFAULT '1',
  `notes` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` VALUES(21, 'austin', 'Austin', 'Barnes', 'e36ceb97a9d4141a430a7d9230b4a119c2714ed3', 12345, 'austin@barnespos.com', 1, 25.00, NULL, NULL, 1, '', '2011-06-12 13:49:54', '2011-06-14 00:03:45');
INSERT INTO `users` VALUES(22, 'test', 'test', 'test', 'c587f686c02dd00975974ff574580838bd053451', 99999, '', 2, 10.00, NULL, NULL, 1, '', '2011-06-14 15:24:01', '2011-06-14 15:24:53');

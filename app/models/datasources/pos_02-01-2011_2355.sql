-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 01, 2011 at 11:55 PM
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

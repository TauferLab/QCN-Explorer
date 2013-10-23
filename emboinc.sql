-- phpMyAdmin SQL Dump
-- version 3.5.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 29, 2013 at 04:38 AM
-- Server version: 5.1.67
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `emboinc`
--

-- --------------------------------------------------------

--
-- Table structure for table `simulations`
--

CREATE TABLE IF NOT EXISTS `simulations` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `save_time` datetime NOT NULL,
  `owner` int(11) NOT NULL DEFAULT '0',
  `name` text NOT NULL,
  `user_trace` text,
  `wu_trace` text,
  `debug` tinyint(1) DEFAULT NULL,
  `verbose` tinyint(1) NOT NULL DEFAULT '0',
  `rand_num_seed` int(11) DEFAULT NULL,
  `cuttime` int(11) DEFAULT NULL,
  `sim_start_time` int(11) DEFAULT NULL,
  `trickle_ups` tinyint(1) NOT NULL DEFAULT '1',
  `description` text,
  `perfect_hosts` tinyint(1) NOT NULL,
  `weibull` tinyint(1) NOT NULL,
  `featured` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

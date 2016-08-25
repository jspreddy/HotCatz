-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 10, 2014 at 10:39 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hotcatz`
--

-- --------------------------------------------------------

--
-- Table structure for table `cat`
--

CREATE TABLE IF NOT EXISTS `cat` (
  `catId_pk` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId_fk` int(11) unsigned NOT NULL,
  `cname` varchar(256) NOT NULL,
  `cimage` varchar(256) NOT NULL,
  `voteweight` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`catId_pk`),
  UNIQUE KEY `cname` (`cname`),
  KEY `userId_fk` (`userId_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
	`id` varchar(40) NOT NULL,
	`ip_address` varchar(45) NOT NULL,
	`timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
	`data` blob NOT NULL,
	KEY `ci_sessions_timestamp` (`timestamp`)
);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userId_pk` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uname` varchar(256) NOT NULL,
  `email_verified` tinyint(1) NOT NULL,
  `passwd` varchar(256) NOT NULL,
  `veri_code` varchar(6) NOT NULL,
  `voteToken` varchar(6) DEFAULT NULL,
  `cat1_fk` int(11) unsigned DEFAULT NULL,
  `cat2_fk` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`userId_pk`),
  KEY `cat1_fk` (`cat1_fk`,`cat2_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;


-- --------------------------------------------------------

--
-- Table structure for table `vote`
--

CREATE TABLE IF NOT EXISTS `vote` (
  `voteId_pk` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId_fk` int(11) unsigned NOT NULL,
  `cat1_fk` int(11) unsigned NOT NULL,
  `cat2_fk` int(11) unsigned NOT NULL,
  `votedFor_fk` int(11) unsigned NOT NULL,
  `dateTime` datetime NOT NULL,
  PRIMARY KEY (`voteId_pk`),
  KEY `userId_fk` (`userId_fk`,`cat1_fk`,`cat2_fk`,`votedFor_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

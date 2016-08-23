-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2014 at 02:30 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `createobackend`
--
CREATE DATABASE IF NOT EXISTS `createobackend` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `createobackend`;

-- --------------------------------------------------------

--
-- Table structure for table `accesslevel`
--

CREATE TABLE IF NOT EXISTS `accesslevel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `accesslevel`
--

INSERT INTO `accesslevel` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'Operator'),
(3, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `crudtype`
--

CREATE TABLE IF NOT EXISTS `crudtype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `crudtype`
--

INSERT INTO `crudtype` (`id`, `name`) VALUES
(1, 'create'),
(2, 'update'),
(3, 'delete'),
(4, 'view');

-- --------------------------------------------------------

--
-- Table structure for table `demo`
--

CREATE TABLE IF NOT EXISTS `demo` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `field`
--

CREATE TABLE IF NOT EXISTS `field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table` int(11) NOT NULL,
  `sqlname` varchar(255) NOT NULL,
  `sqltype` varchar(255) NOT NULL,
  `isprimary` varchar(255) NOT NULL,
  `defaultvalue` varchar(255) NOT NULL,
  `isnull` varchar(255) NOT NULL,
  `autoincrement` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `placeholder` varchar(255) NOT NULL,
  `showinview` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `field`
--

INSERT INTO `field` (`id`, `table`, `sqlname`, `sqltype`, `isprimary`, `defaultvalue`, `isnull`, `autoincrement`, `title`, `type`, `placeholder`, `showinview`) VALUES
(1, 1, 'sql', '2', 'no', '0', 'no', 'no', 'id', '2', 'id', 'top'),
(4, 4, 'asa1', '1', 'FALSE', '0', 'TRUE', 'FALSE', 'HTC test', '1', '3', 'top');

-- --------------------------------------------------------

--
-- Table structure for table `fieldselectfield`
--

CREATE TABLE IF NOT EXISTS `fieldselectfield` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `fieldselectfield`
--

INSERT INTO `fieldselectfield` (`id`, `field`, `name`, `value`) VALUES
(1, 1, 'subcat1', '30');

-- --------------------------------------------------------

--
-- Table structure for table `fieldtype`
--

CREATE TABLE IF NOT EXISTS `fieldtype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `fieldtype`
--

INSERT INTO `fieldtype` (`id`, `name`) VALUES
(1, 'text'),
(2, 'textarea'),
(3, 'select'),
(4, 'selectfromtable'),
(5, 'multiselect'),
(6, 'multiselectfromtable'),
(7, 'hidden'),
(8, 'email'),
(9, 'number'),
(10, 'file'),
(11, 'date');

-- --------------------------------------------------------

--
-- Table structure for table `fieldvalidation`
--

CREATE TABLE IF NOT EXISTS `fieldvalidation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field` int(11) NOT NULL,
  `validation` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `fieldvalidation`
--

INSERT INTO `fieldvalidation` (`id`, `field`, `validation`) VALUES
(1, 1, 'required'),
(2, 2, 'trim'),
(4, 1, 'trim');

-- --------------------------------------------------------

--
-- Table structure for table `logintype`
--

CREATE TABLE IF NOT EXISTS `logintype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `logintype`
--

INSERT INTO `logintype` (`id`, `name`) VALUES
(1, 'Facebook'),
(2, 'Twitter'),
(3, 'Email'),
(4, 'Google');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `url` text NOT NULL,
  `linktype` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `isactive` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `icon` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `description`, `keyword`, `url`, `linktype`, `parent`, `isactive`, `order`, `icon`) VALUES
(1, 'Users', '', '', 'site/viewusers', 1, 0, 1, 1, 'icon-user'),
(4, 'Dashboard', '', '', 'site/index', 1, 0, 1, 0, 'icon-dashboard'),
(18, 'Project', '', '', 'site/viewproject', 1, 0, 1, 2, 'icon-dashboard'),
(19, 'Table', '', '', 'site/viewtable', 1, 0, 1, 3, 'icon-dashboard'),
(20, 'Field', '', '', 'site/viewfield', 1, 0, 1, 4, 'icon-dashboard'),
(21, 'Pages', '', '', 'site/viewpage', 1, 0, 1, 5, 'icon-dashboard');

-- --------------------------------------------------------

--
-- Table structure for table `menuaccess`
--

CREATE TABLE IF NOT EXISTS `menuaccess` (
  `menu` int(11) NOT NULL,
  `access` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menuaccess`
--

INSERT INTO `menuaccess` (`menu`, `access`) VALUES
(1, 1),
(4, 1),
(2, 1),
(3, 1),
(5, 1),
(6, 1),
(7, 1),
(7, 3),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table` int(11) NOT NULL,
  `navigationname` varchar(255) NOT NULL,
  `navigationtype` varchar(255) NOT NULL,
  `navigationparent` varchar(255) NOT NULL,
  `crudtype` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`id`, `table`, `navigationname`, `navigationtype`, `navigationparent`, `crudtype`) VALUES
(1, 1, '1', '1', '1', 1),
(2, 1, 'aas', 'saxs', 'axa', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pageaccesslevel`
--

CREATE TABLE IF NOT EXISTS `pageaccesslevel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` int(11) NOT NULL,
  `accesslevel` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `pageaccesslevel`
--

INSERT INTO `pageaccesslevel` (`id`, `page`, `accesslevel`) VALUES
(1, 4, 'user'),
(2, 4, 'admin'),
(3, 2, 'admin'),
(4, 2, 'operator');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `databasename` varchar(255) NOT NULL,
  `databasepassword` varchar(255) NOT NULL,
  `hostname` varchar(255) NOT NULL,
  `userpassword` varchar(255) NOT NULL,
  `mandrillid` varchar(255) NOT NULL,
  `mandrillpassword` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `name`, `email`, `databasename`, `databasepassword`, `hostname`, `userpassword`, `mandrillid`, `mandrillpassword`) VALUES
(1, 'toykraft', 'toykraft@email.com', 'toykraft', 'toykraft123', 'localhost', 'toykraft123', 'toykraftmandrill', 'toykraft123'),
(2, 'sergy', 'sergy@email.com', 'sergy', 'chintan1234', 'sergy123', 'chintan1234', 'sergy@email.com', 'sergy123');

-- --------------------------------------------------------

--
-- Table structure for table `projectaccesslevel`
--

CREATE TABLE IF NOT EXISTS `projectaccesslevel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project` int(11) NOT NULL,
  `accesslevel` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `projectaccesslevel`
--

INSERT INTO `projectaccesslevel` (`id`, `project`, `accesslevel`) VALUES
(2, 1, 'admin'),
(3, 2, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `sqltype`
--

CREATE TABLE IF NOT EXISTS `sqltype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `sqltype`
--

INSERT INTO `sqltype` (`id`, `name`) VALUES
(1, 'int'),
(2, 'varchar'),
(3, 'double'),
(4, 'timestamp'),
(5, 'text'),
(6, 'date');

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE IF NOT EXISTS `statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`) VALUES
(1, 'inactive'),
(2, 'Active'),
(3, 'Waiting'),
(4, 'Active Waiting'),
(5, 'Blocked');

-- --------------------------------------------------------

--
-- Table structure for table `table`
--

CREATE TABLE IF NOT EXISTS `table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project` int(11) NOT NULL,
  `tablename` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `table`
--

INSERT INTO `table` (`id`, `project`, `tablename`) VALUES
(1, 1, 'category'),
(4, 1, 'demo');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `accesslevel` int(11) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `socialid` varchar(255) NOT NULL,
  `logintype` int(11) NOT NULL,
  `json` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `password`, `email`, `accesslevel`, `timestamp`, `status`, `image`, `username`, `socialid`, `logintype`, `json`) VALUES
(1, 'wohlig', 'a63526467438df9566c508027d9cb06b', 'wohlig@wohlig.com', 1, '0000-00-00 00:00:00', 1, NULL, '', '', 0, ''),
(4, 'pratik', '0cb2b62754dfd12b6ed0161d4b447df7', 'pratik@wohlig.com', 1, '2014-05-12 06:52:44', 1, NULL, 'pratik', '1', 1, ''),
(5, 'wohlig123', 'wohlig123', 'wohlig1@wohlig.com', 1, '2014-05-12 06:52:44', 1, NULL, '', '', 0, ''),
(6, 'wohlig1', 'a63526467438df9566c508027d9cb06b', 'wohlig2@wohlig.com', 1, '2014-05-12 06:52:44', 1, NULL, '', '', 0, ''),
(7, 'Avinash', '7b0a80efe0d324e937bbfc7716fb15d3', 'avinash@wohlig.com', 1, '2014-10-17 06:22:29', 1, NULL, '', '', 0, ''),
(9, 'avinash', 'a208e5837519309129fa466b0c68396b', 'a@email.com', 2, '2014-12-03 11:06:19', 3, '', '', '123', 1, 'demojson'),
(13, 'aaa', 'a208e5837519309129fa466b0c68396b', 'aaa3@email.com', 3, '2014-12-04 06:55:42', 3, NULL, '', '1', 2, 'userjson');

-- --------------------------------------------------------

--
-- Table structure for table `userlog`
--

CREATE TABLE IF NOT EXISTS `userlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `onuser` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `userlog`
--

INSERT INTO `userlog` (`id`, `onuser`, `status`, `description`, `timestamp`) VALUES
(1, 1, 1, 'User Address Edited', '2014-05-12 06:50:21'),
(2, 1, 1, 'User Details Edited', '2014-05-12 06:51:43'),
(3, 1, 1, 'User Details Edited', '2014-05-12 06:51:53'),
(4, 4, 1, 'User Created', '2014-05-12 06:52:44'),
(5, 4, 1, 'User Address Edited', '2014-05-12 12:31:48'),
(6, 23, 2, 'User Created', '2014-10-07 06:46:55'),
(7, 24, 2, 'User Created', '2014-10-07 06:48:25'),
(8, 25, 2, 'User Created', '2014-10-07 06:49:04'),
(9, 26, 2, 'User Created', '2014-10-07 06:49:16'),
(10, 27, 2, 'User Created', '2014-10-07 06:52:18'),
(11, 28, 2, 'User Created', '2014-10-07 06:52:45'),
(12, 29, 2, 'User Created', '2014-10-07 06:53:10'),
(13, 30, 2, 'User Created', '2014-10-07 06:53:33'),
(14, 31, 2, 'User Created', '2014-10-07 06:55:03'),
(15, 32, 2, 'User Created', '2014-10-07 06:55:33'),
(16, 33, 2, 'User Created', '2014-10-07 06:59:32'),
(17, 34, 2, 'User Created', '2014-10-07 07:01:18'),
(18, 35, 2, 'User Created', '2014-10-07 07:01:50'),
(19, 34, 2, 'User Details Edited', '2014-10-07 07:04:34'),
(20, 18, 2, 'User Details Edited', '2014-10-07 07:05:11'),
(21, 18, 2, 'User Details Edited', '2014-10-07 07:05:45'),
(22, 18, 2, 'User Details Edited', '2014-10-07 07:06:03'),
(23, 7, 6, 'User Created', '2014-10-17 06:22:29'),
(24, 7, 6, 'User Details Edited', '2014-10-17 06:32:22'),
(25, 7, 6, 'User Details Edited', '2014-10-17 06:32:37'),
(26, 8, 6, 'User Created', '2014-11-15 12:05:52'),
(27, 9, 6, 'User Created', '2014-12-02 10:46:36'),
(28, 9, 6, 'User Details Edited', '2014-12-02 10:47:34'),
(29, 4, 6, 'User Details Edited', '2014-12-03 10:34:49'),
(30, 4, 6, 'User Details Edited', '2014-12-03 10:36:34'),
(31, 4, 6, 'User Details Edited', '2014-12-03 10:36:49'),
(32, 8, 6, 'User Details Edited', '2014-12-03 10:47:16');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

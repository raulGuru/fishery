-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2017 at 10:00 PM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fishery`
--
CREATE DATABASE IF NOT EXISTS `fishery` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `fishery`;

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(15) NOT NULL,
  `date` date NOT NULL,
  `time` int(2) NOT NULL,
  `userid` int(2) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(1) NOT NULL,
  `type` varchar(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `adult` int(5) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `type`, `name`, `adult`, `timestamp`) VALUES
(1, 'GV', 'General Visitor', 60, '2017-08-04 09:32:19'),
(2, 'GVC', 'General Visitor Child', 30, '2017-08-09 13:39:59'),
(3, 'EI', 'Educational Institute Visitor', 30, '2017-08-04 09:32:03'),
(4, 'RP', 'Retired Person', 40, '2017-08-04 09:32:54'),
(5, 'GE', 'Govt Employess', 30, '2017-08-04 09:32:34'),
(6, 'IV', 'International Visitor', 200, '2017-08-04 09:32:45'),
(7, 'IVC', 'International Visitor Child', 100, '2017-08-09 13:39:59'),
(8, 'PH', 'Differently Abled', 30, '2017-08-04 09:31:23');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(15) NOT NULL,
  `bookingid` int(15) NOT NULL,
  `transactionid` varchar(255) NOT NULL,
  `adult` int(5) NOT NULL,
  `visitoramount` int(10) NOT NULL,
  `photography` varchar(25) DEFAULT NULL,
  `photographyamount` int(5) NOT NULL DEFAULT '0',
  `createdon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `photography`
--

CREATE TABLE `photography` (
  `id` int(1) NOT NULL,
  `type` varchar(25) NOT NULL,
  `name` varchar(100) NOT NULL,
  `rate` int(5) NOT NULL,
  `createdon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `photography`
--

INSERT INTO `photography` (`id`, `type`, `name`, `rate`, `createdon`) VALUES
(1, '0', '', 0, '2017-08-04 16:33:53'),
(2, '1', 'Mobile', 500, '2017-08-10 09:18:46'),
(3, '2', 'Video/Digital Camera', 1000, '2017-08-04 16:35:38'),
(4, '3', 'Commercial Still', 5000, '2017-08-10 09:18:52'),
(5, '4', 'Commercial Videography', 10000, '2017-08-04 16:35:38');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('active','inactive') DEFAULT NULL,
  `lastlogin` datetime NOT NULL,
  `updatedon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `status`, `lastlogin`, `updatedon`) VALUES
(1, 'admin', 'ZGVwdGZfYWRtaW4=', 'active', '2017-08-12 00:00:00', '2017-08-11 23:03:32');

-- --------------------------------------------------------

--
-- Table structure for table `visitor`
--

CREATE TABLE `visitor` (
  `id` int(15) NOT NULL,
  `bookingid` int(15) NOT NULL,
  `category` varchar(5) NOT NULL,
  `adult` int(3) NOT NULL,
  `adultrate` int(4) NOT NULL,
  `totalamount` int(10) NOT NULL,
  `createdon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `photography`
--
ALTER TABLE `photography`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitor`
--
ALTER TABLE `visitor`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `photography`
--
ALTER TABLE `photography`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `visitor`
--
ALTER TABLE `visitor`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

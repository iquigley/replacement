-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 31, 2020 at 03:29 PM
-- Server version: 5.7.25
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `piece_request`
--
CREATE DATABASE IF NOT EXISTS `piece_request` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `piece_request`;

-- --------------------------------------------------------

--
-- Table structure for table `brand_types`
--

CREATE TABLE `brand_types` (
  `id` int(11) NOT NULL,
  `uuid` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `date_created` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `brand_types`
--

INSERT INTO `brand_types` (`id`, `uuid`, `name`, `date_created`) VALUES
(1, '5e8372c4a55bb', 'Denby', 1585672798),
(2, '5e8372ef89ba7', 'Lenox', 1585672800),
(3, '5e8372fa36928', 'Noritake', 1585672852);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `uuid` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(128) NOT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `date_created` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customer_request`
--

CREATE TABLE `customer_request` (
  `id` int(11) NOT NULL,
  `uuid` varchar(64) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `customer_uuid` varchar(64) NOT NULL,
  `date_created` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `piece_types`
--

CREATE TABLE `piece_types` (
  `id` int(11) NOT NULL,
  `uuid` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `date_created` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `piece_types`
--

INSERT INTO `piece_types` (`id`, `uuid`, `name`, `date_created`) VALUES
(1, '5e83721ce2aa2', 'Dinner Plate', 1585672798),
(2, '5e837240eeb53', 'Salad Plate', 1585672800),
(3, '5e837284947bf', 'Saucer', 1585672852);

-- --------------------------------------------------------

--
-- Table structure for table `request_with_pieces`
--

CREATE TABLE `request_with_pieces` (
  `id` int(11) NOT NULL,
  `uuid` varchar(64) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `request_uuid` varchar(64) NOT NULL,
  `piece_type_uuid` varchar(64) NOT NULL,
  `brand_type_uuid` varchar(64) NOT NULL,
  `number_requested` int(16) NOT NULL DEFAULT '1',
  `date_created` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand_types`
--
ALTER TABLE `brand_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`) USING BTREE;

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`);

--
-- Indexes for table `customer_request`
--
ALTER TABLE `customer_request`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`);

--
-- Indexes for table `piece_types`
--
ALTER TABLE `piece_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`);

--
-- Indexes for table `request_with_pieces`
--
ALTER TABLE `request_with_pieces`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand_types`
--
ALTER TABLE `brand_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `customer_request`
--
ALTER TABLE `customer_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `piece_types`
--
ALTER TABLE `piece_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `request_with_pieces`
--
ALTER TABLE `request_with_pieces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

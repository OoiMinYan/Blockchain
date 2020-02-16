-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2019 at 05:59 PM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blockchain_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_name` varchar(20) NOT NULL,
  `admin_pass` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_name`, `admin_pass`) VALUES
('Admin1', '$2y$10$wMEvxf3DdkcjUdDrojS5f.rliV93HSVZTSjLjhsDDYUXzG6vdU1n6'),
('Admin2', '$2y$10$UVj5LU4.9e7QWMCeYAXiuepR03vHcfsb0ym2JKkFTBZ/CUqWJA2BC');

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `contractid` int(11) NOT NULL,
  `vin` varchar(20) NOT NULL,
  `seller_nric` varchar(12) DEFAULT NULL,
  `nric` varchar(12) NOT NULL,
  `dateofreg` date DEFAULT NULL,
  `bank` varchar(20) NOT NULL,
  `borrowamount` int(10) NOT NULL,
  `overyear` int(10) NOT NULL,
  `installment` decimal(10,0) NOT NULL,
  `vprice` int(20) NOT NULL,
  `signa` text NOT NULL,
  `dateapply` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `owner_details`
--

CREATE TABLE `owner_details` (
  `nric` varchar(12) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `pnumber` varchar(15) NOT NULL,
  `epf` varchar(7) NOT NULL,
  `annual` varchar(50) NOT NULL,
  `payslip` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `u_name` varchar(20) NOT NULL,
  `u_pass` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_details`
--

CREATE TABLE `vehicle_details` (
  `vin` varchar(20) NOT NULL,
  `brand` varchar(20) NOT NULL,
  `model` varchar(20) NOT NULL,
  `colour` varchar(20) NOT NULL,
  `price` int(11) NOT NULL,
  `odometer` int(50) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_items`
--

CREATE TABLE `vehicle_items` (
  `vid` int(11) NOT NULL,
  `vbrand` varchar(20) NOT NULL,
  `vmodel` varchar(20) NOT NULL,
  `vcolour` varchar(20) NOT NULL,
  `vprice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicle_items`
--

INSERT INTO `vehicle_items` (`vid`, `vbrand`, `vmodel`, `vcolour`, `vprice`) VALUES
(1, 'Ford', 'Fiesta', 'Red', 83400),
(2, 'Ford', 'Fiesta', 'Black', 83400),
(3, 'Ford', 'Ranger', 'Black', 199888),
(4, 'Honda', 'City', 'White', 84000),
(5, 'Honda', 'City', 'Silver', 84000),
(6, 'Honda', 'HR-V', 'Black', 124800),
(7, 'Honda', 'City', 'White', 84000),
(8, 'Toyota', 'Vios', 'Black', 77200),
(9, 'Toyota', 'Innova', 'Black', 132400),
(10, 'Honda', 'City', 'Red', 123000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_name`);

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`contractid`);

--
-- Indexes for table `owner_details`
--
ALTER TABLE `owner_details`
  ADD PRIMARY KEY (`nric`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`u_name`);

--
-- Indexes for table `vehicle_details`
--
ALTER TABLE `vehicle_details`
  ADD PRIMARY KEY (`vin`);

--
-- Indexes for table `vehicle_items`
--
ALTER TABLE `vehicle_items`
  ADD PRIMARY KEY (`vid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `contractid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vehicle_items`
--
ALTER TABLE `vehicle_items`
  MODIFY `vid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2022 at 11:40 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bank`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_`
--

CREATE TABLE `account_` (
  `cid` varchar(20) NOT NULL,
  `account_number` int(11) NOT NULL,
  `account_balance` bigint(20) NOT NULL,
  `branch_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `account_`
--

INSERT INTO `account_` (`cid`, `account_number`, `account_balance`, `branch_id`) VALUES
('C1', 100, 68000, 'BR100'),
('C2', 101, 10000, 'BR101'),
('C4', 102, 250000, 'BR102'),
('C4', 103, 15000, 'BR103'),
('C5', 104, 550, 'BR104'),
('C6', 105, 68000, 'BR102');

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `branch_id` varchar(20) NOT NULL,
  `branch_ifsc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branch_id`, `branch_ifsc`) VALUES
('BR100', 'IFSC100'),
('BR101', 'IFSC101'),
('BR102', 'IFSC102'),
('BR103', 'IFSC103');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `cid` varchar(20) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email_id` varchar(255) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `dob` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`cid`, `first_name`, `last_name`, `phone`, `address`, `email_id`, `gender`, `dob`) VALUES
('C1', 'Adams', 'Baker', 918756455854, '110, 1st Floor, Anant Laxmi Chambers, Naupada, Above Thane Janta Bank, Thane (west)', 'adams@gmail.com', 'Male', '1994-06-30'),
('C2', 'Clark', 'Davis', 912245678520, '58-59, World Trade Centre, Connaught Place', 'clark@yahoo.com', 'Male', '2001-01-10'),
('C3', 'Evans', 'Frank', 918461048259, '305, Jumma Masjid Road, O P H Road', 'evans.frank@gmail.com', 'Female', '1993-12-23'),
('C4', 'Ghosh', 'Hills', 918832045067, '6668, Khari Baoli, Delhi', 'hills@yahoo.in', 'Male', '2001-05-12'),
('C5', 'Irwin', 'Jones', 918832045067, '9/9, Ground Magadi Mn, Nr Jaimuni Rao Circle, Agrahara Dasarahalli', 'irwin@gmail.com', 'Female', '1993-12-23'),
('C6', 'Klein', 'Lopez', 918461048259, '2nd Floor, 37, Maskati Corner, Altamount Road, Opp. Bank Of Baroda, Kemps Corner', 'klein.lopez@gmail.com', 'Female', '1999-01-10');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `sender_account_number` int(11) NOT NULL,
  `receiver_account_number` int(11) NOT NULL,
  `sender_ifsc` varchar(20) NOT NULL,
  `receiver_ifsc` varchar(20) NOT NULL,
  `amount` bigint(20) NOT NULL,
  `date_time` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`sender_account_number`, `receiver_account_number`, `sender_ifsc`, `receiver_ifsc`, `amount`, `date_time`) VALUES
(100, 101, 'IFSC100', 'IFSC101', 100, '2022-06-28 11:36:58'),
(101, 100, 'IFSC101', 'IFSC100', 100, '2022-06-28 11:37:59');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2026 at 04:50 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crms`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `FullName` varchar(200) NOT NULL,
  `AdminEmail` varchar(200) NOT NULL,
  `UserName` varchar(200) NOT NULL,
  `Password` varchar(200) NOT NULL,
  `updationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `FullName`, `AdminEmail`, `UserName`, `Password`, `updationDate`) VALUES
(1, 'Admin', 'admin@gmail.com', 'admin', '5c428d8875d2948607f3e3fe134d71b4', '2026-03-06 14:28:04');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_chargesheet`
--

CREATE TABLE `tbl_chargesheet` (
  `id` int(11) NOT NULL,
  `FIRID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `PoliceID` int(11) NOT NULL,
  `ChargeSheet` text NOT NULL,
  `ChargeSheetDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_chargesheet`
--

INSERT INTO `tbl_chargesheet` (`id`, `FIRID`, `UserID`, `PoliceID`, `ChargeSheet`, `ChargeSheetDate`) VALUES
(1, 1, 1, 3, 'bbjasabjcvsdbj', '2026-03-06 14:33:48'),
(2, 1, 1, 3, 'hgfdjhvx', '2026-03-06 14:34:49');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_crimecategory`
--

CREATE TABLE `tbl_crimecategory` (
  `id` int(11) NOT NULL,
  `CrimeCategory` varchar(200) NOT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_crimecategory`
--

INSERT INTO `tbl_crimecategory` (`id`, `CrimeCategory`, `CreationDate`) VALUES
(1, 'Robbery', '2026-03-06 14:28:04'),
(2, 'Murder', '2026-03-06 14:28:04'),
(3, 'Theft', '2026-03-06 14:28:04'),
(4, 'Drug Trafficking', '2026-03-06 14:28:04'),
(5, 'Cybercrime', '2026-03-06 14:28:04'),
(6, 'rape and murder', '2026-03-15 09:06:26');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_criminal`
--

CREATE TABLE `tbl_criminal` (
  `id` int(11) NOT NULL,
  `CriminalName` varchar(200) NOT NULL,
  `CriminalPhoto` varchar(200) DEFAULT NULL,
  `CriminalAddress` text NOT NULL,
  `CrimeCategoryID` int(11) NOT NULL,
  `PoliceStationID` int(11) NOT NULL,
  `PoliceID` int(11) NOT NULL,
  `DateOfCrime` date NOT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_fir`
--

CREATE TABLE `tbl_fir` (
  `id` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `PoliceStationID` int(11) NOT NULL,
  `CrimeCategoryID` int(11) NOT NULL,
  `FIRSubject` varchar(300) NOT NULL,
  `FIRDetail` text NOT NULL,
  `FIRDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `FIRStatus` varchar(50) NOT NULL DEFAULT 'Pending' COMMENT 'Pending,Inprogress,Solved',
  `PoliceRemark` text DEFAULT NULL,
  `PoliceID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_fir`
--

INSERT INTO `tbl_fir` (`id`, `UserID`, `PoliceStationID`, `CrimeCategoryID`, `FIRSubject`, `FIRDetail`, `FIRDate`, `FIRStatus`, `PoliceRemark`, `PoliceID`) VALUES
(2, 4, 1, 2, 'as a victim i seen the murder i frount of my house and i give the statement of this', 'I wake up early in the morning of 15 March 2025 at 6 o\'clock and I seen the murder in front of my house and I shocked and suddenly call to the police this all happened that day I am 100% sure this is murder', '2026-03-15 08:18:51', 'Pending', NULL, NULL),
(3, 4, 1, 5, 'iam the victim hear and someone did fraud with me and cleared my bank account', 'As a victim I received the call on 14th March 2025 at across 1 o\'clock and the person taken my OTP and clear the bank account 9975459615 this is the number of fraud', '2026-03-15 08:28:41', 'Pending', NULL, NULL),
(4, 4, 1, 4, 'Their behavior looked illegal', 'I woke up early in the morning on 15 March 2025 at 6 o\'clock and went outside my house. I saw two suspicious people exchanging packets secretly near the street corner. Their behavior looked illegal and I strongly suspected it was drug trafficking. I was shocked by what I saw and immediately called the police to report the incident. I am 100% sure that illegal drugs were being sold at that time.', '2026-03-15 08:34:16', 'Pending', NULL, NULL),
(5, 4, 1, 5, 'I later discovered that money was withdrawn from my account without my permission.', 'On 15 March 2025, around 10:30 in the morning, I received a message on my phone saying that my bank account needed verification. When I clicked the link and entered my details, I later discovered that money was withdrawn from my account without my permission. I realized that this was a cybercrime fraud. I was shocked and immediately contacted the bank and reported the incident to the cybercrime police.', '2026-03-15 08:35:22', 'Pending', NULL, NULL),
(6, 4, 1, 1, 'He forcefully took money from the cash counter and ran away quickly', 'On 15 March 2025 at about 8:00 PM, while I was walking near the market area, a man suddenly came and threatened a shopkeeper with a knife. He forcefully took money from the cash counter and ran away quickly. I witnessed the entire incident and I am 100% sure it was a robbery. I was shocked and immediately informed the police about what happened.', '2026-03-15 08:36:02', 'Pending', NULL, NULL),
(7, 4, 1, 3, 'I am sure that someone stole my bicycle during the night', 'On 15 March 2025 at around 7:00 AM, when I came outside my house, I noticed that my bicycle which I had parked in front of my house was missing. I also saw that the lock was broken and thrown on the ground. I am sure that someone stole my bicycle during the night. I was shocked and immediately reported the theft to the police.', '2026-03-15 08:36:39', 'Pending', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_police`
--

CREATE TABLE `tbl_police` (
  `id` int(11) NOT NULL,
  `PoliceStationID` int(11) NOT NULL,
  `PoliceID` varchar(100) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `MobileNumber` varchar(15) NOT NULL,
  `Address` text NOT NULL,
  `Password` varchar(200) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=Inactive,1=Active',
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_police`
--

INSERT INTO `tbl_police` (`id`, `PoliceStationID`, `PoliceID`, `Name`, `Email`, `MobileNumber`, `Address`, `Password`, `Status`, `CreationDate`) VALUES
(4, 1, 'CNTD02', 'Syed Sameer s', 'syedsameers2007@gmail.com', '09448927651', 'Main Road Near Bus Stand Gyarej Camp Singanamane Bhadra Reservoir Project Bhadravati Shivamogga\r\nGyarej Camp', '81dc9bdb52d04dc20036dbd8313ed055', 1, '2026-03-07 03:42:32');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_policestation`
--

CREATE TABLE `tbl_policestation` (
  `id` int(11) NOT NULL,
  `PoliceStationName` varchar(200) NOT NULL,
  `PoliceStationCode` varchar(100) NOT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_policestation`
--

INSERT INTO `tbl_policestation` (`id`, `PoliceStationName`, `PoliceStationCode`, `CreationDate`) VALUES
(1, 'Central Delhi Police Stations', 'CDP501', '2026-03-06 14:28:04'),
(2, 'Laxmi Nagar East Delhi Police Stations', 'LND09', '2026-03-06 14:28:04'),
(3, 'Rajeev Chowk Police Station New Delhi', 'RCPSD212', '2026-03-06 14:28:04');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `FullName` varchar(200) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `MobileNumber` varchar(15) NOT NULL,
  `Password` varchar(200) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=Inactive,1=Active',
  `RegistrationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `FullName`, `Email`, `MobileNumber`, `Password`, `Status`, `RegistrationDate`) VALUES
(3, 'Syed Adil S', 'syedadil.s20004@gmail.com', '07676846405', 'e10adc3949ba59abbe56e057f20f883e', 1, '2026-03-15 07:21:58'),
(4, 'syedsameers', 'sameer1234@gmail.com', '9448927651', '81dc9bdb52d04dc20036dbd8313ed055', 1, '2026-03-15 07:39:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_chargesheet`
--
ALTER TABLE `tbl_chargesheet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_crimecategory`
--
ALTER TABLE `tbl_crimecategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_criminal`
--
ALTER TABLE `tbl_criminal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_fir`
--
ALTER TABLE `tbl_fir`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_police`
--
ALTER TABLE `tbl_police`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_policestation`
--
ALTER TABLE `tbl_policestation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_chargesheet`
--
ALTER TABLE `tbl_chargesheet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_crimecategory`
--
ALTER TABLE `tbl_crimecategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_criminal`
--
ALTER TABLE `tbl_criminal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_fir`
--
ALTER TABLE `tbl_fir`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_police`
--
ALTER TABLE `tbl_police`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_policestation`
--
ALTER TABLE `tbl_policestation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

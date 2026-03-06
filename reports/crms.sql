-- Crime Record Management System
-- PHPGurukul | crms.sql

CREATE DATABASE IF NOT EXISTS `crms`;
USE `crms`;

-- Admin Table
CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FullName` varchar(200) NOT NULL,
  `AdminEmail` varchar(200) NOT NULL,
  `UserName` varchar(200) NOT NULL,
  `Password` varchar(200) NOT NULL,
  `updationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tbl_admin` (`FullName`,`AdminEmail`,`UserName`,`Password`) VALUES
('Admin','admin@gmail.com','admin',md5('Test@12345'));

-- Police Station Table
CREATE TABLE `tbl_policestation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `PoliceStationName` varchar(200) NOT NULL,
  `PoliceStationCode` varchar(100) NOT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tbl_policestation` (`PoliceStationName`,`PoliceStationCode`) VALUES
('Central Delhi Police Stations','CDP501'),
('Laxmi Nagar East Delhi Police Stations','LND09'),
('Rajeev Chowk Police Station New Delhi','RCPSD212');

-- Police Table
CREATE TABLE `tbl_police` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `PoliceStationID` int(11) NOT NULL,
  `PoliceID` varchar(100) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `MobileNumber` varchar(15) NOT NULL,
  `Address` text NOT NULL,
  `Password` varchar(200) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=Inactive,1=Active',
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tbl_police` (`PoliceStationID`,`PoliceID`,`Name`,`Email`,`MobileNumber`,`Address`,`Password`,`Status`) VALUES
(1,'CNTD01','Rahul Kumar','rk@test.com','1425369852','Central Delhi','6c28e3a52f45c91c35d06bd8cc9571e8',1),
(2,'LNPSD123','Amit Gupta','amitk@test.com','7895410236','Laxmi Nagar Delhi','6c28e3a52f45c91c35d06bd8cc9571e8',1);

-- Crime Category Table
CREATE TABLE `tbl_crimecategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CrimeCategory` varchar(200) NOT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tbl_crimecategory` (`CrimeCategory`) VALUES
('Robbery'),('Murder'),('Theft'),('Drug Trafficking'),('Cybercrime');

-- User Table
CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FullName` varchar(200) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `MobileNumber` varchar(15) NOT NULL,
  `Password` varchar(200) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=Inactive,1=Active',
  `RegistrationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Criminal Table
CREATE TABLE `tbl_criminal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CriminalName` varchar(200) NOT NULL,
  `CriminalPhoto` varchar(200) DEFAULT NULL,
  `CriminalAddress` text NOT NULL,
  `CrimeCategoryID` int(11) NOT NULL,
  `PoliceStationID` int(11) NOT NULL,
  `PoliceID` int(11) NOT NULL,
  `DateOfCrime` date NOT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- FIR Table
CREATE TABLE `tbl_fir` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `PoliceStationID` int(11) NOT NULL,
  `CrimeCategoryID` int(11) NOT NULL,
  `FIRSubject` varchar(300) NOT NULL,
  `FIRDetail` text NOT NULL,
  `FIRDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `FIRStatus` varchar(50) NOT NULL DEFAULT 'Pending' COMMENT 'Pending,Inprogress,Solved',
  `PoliceRemark` text DEFAULT NULL,
  `PoliceID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Charge Sheet Table
CREATE TABLE `tbl_chargesheet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FIRID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `PoliceID` int(11) NOT NULL,
  `ChargeSheet` text NOT NULL,
  `ChargeSheetDate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

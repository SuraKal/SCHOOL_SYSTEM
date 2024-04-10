-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2024 at 07:57 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `orgtbl`
--

CREATE TABLE `orgtbl` (
  `Id` int(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `domain` varchar(255) NOT NULL,
  `supportEmail` varchar(255) NOT NULL,
  `orgProfile` varchar(100) NOT NULL,
  `IdTemplete` varchar(255) NOT NULL,
  `certefiTemplete` varchar(255) NOT NULL,
  `dateCreated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orgtbl`
--

INSERT INTO `orgtbl` (`Id`, `name`, `phone`, `domain`, `supportEmail`, `orgProfile`, `IdTemplete`, `certefiTemplete`, `dateCreated`) VALUES
(1, 'BootStrap', '0989675645', 'abebe.com', 'abebe@mail.com', '../Photo/orgLogo.jpg', '../Photo/ID templete.jpg', '../Photo/Certeficate templete.jpg', '2022-07-12 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `Id` int(10) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`Id`, `firstName`, `lastName`, `emailAddress`, `password`) VALUES
(1, 'Admin', '', 'admin@mail.com', 'Ennliteadmin');

-- --------------------------------------------------------

--
-- Table structure for table `tblattendance`
--

CREATE TABLE `tblattendance` (
  `Id` int(10) NOT NULL,
  `admissionNo` varchar(255) NOT NULL,
  `classId` varchar(10) NOT NULL,
  `classArmId` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL,
  `time` time NOT NULL,
  `dateTimeTaken` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblattendance`
--

INSERT INTO `tblattendance` (`Id`, `admissionNo`, `classId`, `classArmId`, `status`, `time`, `dateTimeTaken`) VALUES
(162, 'WE/045/23', '2', '2', '1', '00:00:00', '2020-07-19'),
(163, 'WE/032/23', '2', '2', '0', '00:00:00', '2020-07-19'),
(171, 'PE/825/23', '4', '6', '0', '00:00:00', '2020-07-21'),
(170, 'PE/025/23', '4', '6', '1', '00:00:00', '2020-07-21'),
(204, 'PE/681/24', '4', '6', '1', '07:04:10', '2024-04-01'),
(205, 'PE/535/24', '4', '6', '1', '07:04:10', '2024-04-01'),
(206, 'PE/916/24', '4', '6', '0', '07:04:10', '2024-04-01'),
(207, 'CY/529/24', '5', '10', '1', '07:04:59', '2024-04-01');

-- --------------------------------------------------------

--
-- Table structure for table `tblclass`
--

CREATE TABLE `tblclass` (
  `Id` int(10) NOT NULL,
  `className` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblclass`
--

INSERT INTO `tblclass` (`Id`, `className`) VALUES
(2, 'Web Development'),
(4, 'Personal Development'),
(5, 'Cyber security'),
(7, 'Interor design');

-- --------------------------------------------------------

--
-- Table structure for table `tblclassarms`
--

CREATE TABLE `tblclassarms` (
  `Id` int(10) NOT NULL,
  `classId` varchar(10) NOT NULL,
  `classArmName` varchar(255) NOT NULL,
  `isAssigned` varchar(10) NOT NULL,
  `teacherId` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblclassarms`
--

INSERT INTO `tblclassarms` (`Id`, `classId`, `classArmName`, `isAssigned`, `teacherId`) VALUES
(2, '2', 'Febrary 1', '0', '1'),
(6, '4', 'June 1', '1', '7'),
(10, '5', 'March 2', '1', '8');

-- --------------------------------------------------------

--
-- Table structure for table `tblclassteacher`
--

CREATE TABLE `tblclassteacher` (
  `Id` int(10) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phoneNo` varchar(50) NOT NULL,
  `classId` varchar(11) NOT NULL,
  `classArmId` text NOT NULL,
  `dateCreated` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblclassteacher`
--

INSERT INTO `tblclassteacher` (`Id`, `firstName`, `lastName`, `emailAddress`, `password`, `phoneNo`, `classId`, `classArmId`, `dateCreated`) VALUES
(8, 'Koki', 'Janeb', 'koki68@mail.com', 'db12fdcfe62bc36b6faa1154d3fd342d6978d58841d96f8ddeef52f38709a47c', '0987654345', '5', '10', '24-04-01'),
(7, 'Hana', 'Jabra', 'hana68@gmail.com', 'fcf12d91686f829286406ecf9397b6ddc8355a28d62a80a4fc495376d9da4c6b', '098765432', '4', '6', '24-03-20');

-- --------------------------------------------------------

--
-- Table structure for table `tblreport`
--

CREATE TABLE `tblreport` (
  `Id` int(10) NOT NULL,
  `classId` varchar(10) NOT NULL,
  `classArmId` varchar(10) NOT NULL,
  `issueTittle` varchar(50) NOT NULL,
  `issueDis` text NOT NULL,
  `recommond` text NOT NULL,
  `status` varchar(3) NOT NULL,
  `staff` varchar(3) NOT NULL,
  `teacherId` varchar(40) NOT NULL,
  `student` varchar(15) NOT NULL,
  `dateCreated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblreport`
--

INSERT INTO `tblreport` (`Id`, `classId`, `classArmId`, `issueTittle`, `issueDis`, `recommond`, `status`, `staff`, `teacherId`, `student`, `dateCreated`) VALUES
(1, '2', '2', 'Teacher Late', 'Teacher being Late', 'More time management', '0', '2', 'eden68@gmail.com', 'WE/045/23', '2022-07-12 00:00:00'),
(6, '5', '10', 'He is late 3', '        He is late 3                    ', ' He is late 3                             \r\n                            ', '1', '2', '8', 'CY/529/24', '2024-04-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tblschedules`
--

CREATE TABLE `tblschedules` (
  `Id` int(10) NOT NULL,
  `classId` varchar(10) NOT NULL,
  `classArmId` varchar(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `Reference` varchar(200) NOT NULL,
  `timeFrom` time NOT NULL,
  `timeTo` time NOT NULL,
  `date` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `Doc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblschedules`
--

INSERT INTO `tblschedules` (`Id`, `classId`, `classArmId`, `title`, `description`, `Reference`, `timeFrom`, `timeTo`, `date`, `date_created`, `Doc`) VALUES
(3, '2', '2', 'HTML', 'HTML markup', 'online', '00:00:00', '09:00:00', '2020-10-20', '2020-10-20 15:51:01', '../Doc/0e.docx'),
(4, '', '--Select--', 'HTML markup', 'HTML Mark up is a very basic and important topic of this week', 'http://localhost/SCHOOL_SYSTEM_2/ClassTeacher/ViewScedule.php', '12:24:00', '01:24:00', '2024-04-01', '2024-04-01 00:00:00', '../Doc/e820e09c6dcf56311a32f0eb1174bf0e.'),
(6, '4', '6', 'HTML markup', 'HTML Mark up is a very basic and important topic of this week', 'http://localhost/SCHOOL_SYSTEM_2/ClassTeacher/ViewScedule.php', '11:23:00', '02:23:00', '2024-04-03', '2024-04-01 00:00:00', '../Doc/8653818c1a06b98dde2e974b1bd675ba.jpg'),
(7, '5', '10', 'CSS', 'CSS styles', 'http://localhost/SCHOOL_SYSTEM_2/ClassTeacher/ViewScedule.php', '01:48:00', '03:48:00', '2024-04-01', '2024-04-01 00:00:00', '../Doc/7efa90dd11cd7864efb8560ba8e984b0.png');

-- --------------------------------------------------------

--
-- Table structure for table `tblsessionterm`
--

CREATE TABLE `tblsessionterm` (
  `Id` int(11) NOT NULL,
  `sessionName` varchar(50) NOT NULL,
  `isActive` varchar(10) NOT NULL,
  `dateCreated` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblsessionterm`
--

INSERT INTO `tblsessionterm` (`Id`, `sessionName`, `isActive`, `dateCreated`) VALUES
(1, '2021/2022', '1', '2020-07-05'),
(3, '2021/2022', '1', '2020-07-05');

-- --------------------------------------------------------

--
-- Table structure for table `tblstudents`
--

CREATE TABLE `tblstudents` (
  `Id` int(10) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `admissionNumber` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `classId` varchar(11) NOT NULL,
  `classArmId` varchar(11) NOT NULL,
  `stuProfile` varchar(100) NOT NULL,
  `stuPhone` varchar(100) NOT NULL,
  `dateCreated` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblstudents`
--

INSERT INTO `tblstudents` (`Id`, `firstName`, `lastName`, `email`, `admissionNumber`, `password`, `classId`, `classArmId`, `stuProfile`, `stuPhone`, `dateCreated`) VALUES
(1, 'Selam', 'Fekru', 'selam@mail.com', 'PE/681/24', '12345', '4', '6', '../Photo/426978c82bfc0c6d0a32027140c2193a.jpg', '09876543', '2024-03-20'),
(6, 'Fekr', 'Kaleab', 'Fekr@mail.com', 'PE/535/24', '12345', '4', '6', '../Photo/02319c01817575e285ef4a1114b5959b.jpg', '09876543', '2024-03-20'),
(18, 'Jan', 'Kalem', 'jan68@mail.com', 'PE/916/24', '12345', '4', '6', '../Photo/1eed8cfb6bf340edbec2cf143ab7ef3c.jpg', '08762898376', '2024-03-20'),
(19, 'Kaiow', 'Oamsn', 'k@mail.com', 'CY/529/24', '12345', '5', '10', '../Photo/ee316ae7e9fba490a105f288096cc976.jpg', '0965432332', '2024-04-01');

-- --------------------------------------------------------

--
-- Table structure for table `tblsubadmin`
--

CREATE TABLE `tblsubadmin` (
  `Id` int(10) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblsubadmin`
--

INSERT INTO `tblsubadmin` (`Id`, `firstName`, `lastName`, `emailAddress`, `password`) VALUES
(2, 'Abebe', 'Kalem', 'abe@mail.com', 'd81a65c1de02e17d9cfd88d68a8768fd1e3262f5e2fb859382fe33734b3f3ca8');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orgtbl`
--
ALTER TABLE `orgtbl`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblattendance`
--
ALTER TABLE `tblattendance`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblclass`
--
ALTER TABLE `tblclass`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblclassarms`
--
ALTER TABLE `tblclassarms`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblclassteacher`
--
ALTER TABLE `tblclassteacher`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblreport`
--
ALTER TABLE `tblreport`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblschedules`
--
ALTER TABLE `tblschedules`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblsessionterm`
--
ALTER TABLE `tblsessionterm`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblstudents`
--
ALTER TABLE `tblstudents`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblsubadmin`
--
ALTER TABLE `tblsubadmin`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orgtbl`
--
ALTER TABLE `orgtbl`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblattendance`
--
ALTER TABLE `tblattendance`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208;

--
-- AUTO_INCREMENT for table `tblclass`
--
ALTER TABLE `tblclass`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblclassarms`
--
ALTER TABLE `tblclassarms`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tblclassteacher`
--
ALTER TABLE `tblclassteacher`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblreport`
--
ALTER TABLE `tblreport`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblschedules`
--
ALTER TABLE `tblschedules`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblsessionterm`
--
ALTER TABLE `tblsessionterm`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblstudents`
--
ALTER TABLE `tblstudents`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tblsubadmin`
--
ALTER TABLE `tblsubadmin`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2022 at 09:57 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `attendancemsystem`
--

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`Id`, `firstName`, `lastName`, `emailAddress`, `password`) VALUES
(1, 'Admin', '', 'admin@mail.com', 'Ennliteadmin');

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tblsubadmin` (
  `Id` int(10) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tblsubadmin` (`Id`, `firstName`, `lastName`, `emailAddress`, `password`) VALUES
(1, 'Ennlite', 'sub', 'EnnliteSub@gmail.com', 'EnnliteSub');

-- --------------------------------------------------------

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
  `dateTimeTaken` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblattendance`
--

INSERT INTO `tblattendance` (`Id`, `admissionNo`, `classId`, `classArmId`, `status`, `dateTimeTaken`) VALUES
(162, 'WE/045/23', '2', '2','1', '2020-07-19'),
(163, 'WE/032/23', '2', '2','0', '2020-07-19'),
(171, 'PE/825/23', '4', '6','0', '2020-07-21'),
(170, 'PE/025/23', '4', '6','1', '2020-07-21');

--
-- Table structure for table `tblsessionterm`
--

CREATE TABLE `tblsessionterm` (
  `Id` int(11) NOT NULL,
  `sessionName` varchar(50) NOT NULL,
  `isActive` varchar(10) NOT NULL,
  `dateCreated` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblsessionterm`
--

INSERT INTO `tblsessionterm` (`Id`, `sessionName`, `isActive`, `dateCreated`) VALUES
(1, '2021/2022', '1', '2020-07-05'),
(3, '2021/2022', '1', '2020-07-05');


-- --------------------------------------------------------

--
-- Table structure for table `tblclass`
--

CREATE TABLE `tblclass` (
  `Id` int(10) NOT NULL,
  `className` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblclass`
--

INSERT INTO `tblclass` (`Id`, `className`) VALUES
(2, 'Web Development'),
(4, 'Personal Development');

-- --------------------------------------------------------

--
-- Table structure for table `tblclassarms`
--

CREATE TABLE `tblclassarms` (
  `Id` int(10) NOT NULL,
  `classId` varchar(10) NOT NULL,
  `classArmName` varchar(255) NOT NULL,
  `isAssigned` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblclassarms`
--

INSERT INTO `tblclassarms` (`Id`, `classId`, `classArmName`, `isAssigned`,`teacherId`) VALUES
(2, '2', 'Febrary 1', '1','1'),
(6, '4', 'June 1', '1','6');

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblclassteacher`
--

INSERT INTO `tblclassteacher` (`Id`, `firstName`, `lastName`, `emailAddress`, `password`, `phoneNo`, `classId`, `classArmId`, `dateCreated`) VALUES
(1, 'Eden', 'Samson', 'eden68@gmail.com', 'eden68', '0908989899', '2', '2', '2022-10-31'),
(6, 'Dagim', 'Keroche', 'dagim68@gmail.com', 'dagim68', '09890000030', '4', '6', '2022-10-07');
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblstudents`
--

INSERT INTO `tblstudents` (`Id`, `firstName`, `lastName`,`email`, `admissionNumber`, `password`, `classId`, `classArmId`, `stuProfile`,`dateCreated`) VALUES
(1, 'Selam', 'Fekru','selam@mail.com', 'WE/045/23', '12345', '2', '2','../Photo/studentProfile.jpg','2022-07-16'),
(6, 'Fekr', 'Kaleab', 'Fekr@mail.com','PE/825/23', '12345', '4', '6','../Photo/studentProfile.jpg','2022-07-16'),

--
-- Table structure for schedule
--
CREATE TABLE `tblschedules` (
  `Id` int(30) NOT NULL,
  `classId` varchar(10) NOT NULL,
  `classArmId` varchar(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `Reference` varchar(200) NOT NULL,
  `timeFrom` time NOT NULL,
  `timeTo` time NOT NULL,
  `date` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `Doc`  varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedules`
--

INSERT INTO `tblschedules` (`Id`, `classId`,`classArmId`, `title`, `description`, `Reference`, `timeFrom`, `timeTo`, `date`, `date_created`,`Doc`) VALUES
(3, 2, 2 ,  'HTML', 'HTML markup', 'online', '0000-00-00', '09:00:00', '2020-10-20', '2020-10-20 15:51:01', '../Doc/0e.docx');

-- --------------------------------------------
-- Table structure for report
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblreport`
--

INSERT INTO `tblreport` (`Id`, `classId`,`classArmId`, `issueTittle`, `issueDis`, `recommond`, `status`, `staff`, `teacherId`,`student`, `dateCreated`) VALUES
(1, 2, 2 ,  'Teacher Late', 'Teacher being Late', 'More time management', '0', '2', 'eden68@gmail.com','WE/045/23', '2022/7/12');

-- --------------------------------------------
-- Table structure for Organization detail
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedules`
--

INSERT INTO `orgtbl` (`Id`, `name`,`phone`,`domain`,`supportEmail`,`orgProfile`,`IdTemplete`, `certefiTemplete` ,`dateCreated`) VALUES
(1, "BootStrap", "0989675645" ,'abebe.com','abebe@mail.com','../Photo/orgLogo.jpg','../Photo/ID templete.jpg' , '../Photo/Certeficate templete.jpg','2022/7/12');


-- 
--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`Id`);
-- 
--
-- Indexes for table `tblsubadmin`
--
ALTER TABLE `tblsubadmin`
  ADD PRIMARY KEY (`Id`);
--
-- Indexes for table `orgtbl`
--
ALTER TABLE `orgtbl`
  ADD PRIMARY KEY (`Id`);
--
-- Indexes for table `tblattendance`
--
ALTER TABLE `tblattendance`
  ADD PRIMARY KEY (`Id`);
--
-- Indexes for table `tblsessionterm`
--
ALTER TABLE `tblsessionterm`
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
--
-- Indexes for table `tblstudents`
--
ALTER TABLE `tblstudents`
  ADD PRIMARY KEY (`Id`);

--
  -- Indexes for table `tblschedule`
--
ALTER TABLE `tblschedules`
  ADD PRIMARY KEY (`Id`);

  -- Indexes for table `tblreport`
--
ALTER TABLE `tblreport`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `orgtbl`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--

-- AUTO_INCREMENT for table `tblsubadmin`
--
ALTER TABLE `tblsubadmin`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


--
-- AUTO_INCREMENT for table `tblattendance`
--
ALTER TABLE `tblattendance`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;
--
-- AUTO_INCREMENT for table `tblsessionterm`
--
ALTER TABLE `tblsessionterm`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tblclass`
--
ALTER TABLE `tblclass`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblclassarms`
--
ALTER TABLE `tblclassarms`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblclassteacher`
--
ALTER TABLE `tblclassteacher`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;


--
-- AUTO_INCREMENT for table `tblstudents`
--
ALTER TABLE `tblstudents`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
--

-- AUTO_INCREMENT for table `tblschedules`
--
ALTER TABLE `tblschedules`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

-- AUTO_INCREMENT for table `tblschedules`
--
ALTER TABLE `tblreport`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

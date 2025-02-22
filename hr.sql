-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 11, 2025 at 09:38 PM
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
-- Database: `hr`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `AdminID_PK` int(11) NOT NULL,
  `userName` varchar(50) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`AdminID_PK`, `userName`, `Email`, `password`) VALUES
(1, 'naziha', 'naziha@gmail.com', '199694'),
(2, 'amin', NULL, '1234'),
(3, 'amini', NULL, 'tggggg');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `ClassID` int(11) NOT NULL,
  `SubjectID_FK` int(11) NOT NULL,
  `OpenDate` datetime DEFAULT NULL,
  `IsActive` bit(1) DEFAULT NULL,
  `classname` varchar(30) DEFAULT NULL,
  `LectureName` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`ClassID`, `SubjectID_FK`, `OpenDate`, `IsActive`, `classname`, `LectureName`) VALUES
(42, 2, '2024-10-25 00:00:00', b'1', 'تجربة', 'محاضرة تجربة'),
(43, 1, '2024-10-25 00:00:00', b'1', 'تجربة 2', 'خالد'),
(44, 10, '2024-10-31 00:00:00', b'1', 'فصل 2025 خريف', 'خالد'),
(45, 10, '2025-01-10 00:00:00', b'1', 'تجربة last', 'محاضرة تجربة');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `CourseiID` int(11) NOT NULL,
  `ClassID_FK` int(11) NOT NULL,
  `CourseName` varchar(50) DEFAULT NULL,
  `OpenDate` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`CourseiID`, `ClassID_FK`, `CourseName`, `OpenDate`) VALUES
(23, 42, 'محاضرة 1', '25-10-2024'),
(24, 43, 'محاضرة 1', '25-10-2024'),
(25, 44, 'محاضرة 1 الاولى', '31-10-2024'),
(26, 45, 'first test', '10-01-2025');

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `DeviceID_PK` int(11) NOT NULL,
  `DeviceName` varchar(50) DEFAULT NULL,
  `DeviceTCP_IP` int(11) DEFAULT NULL,
  `DevicePort` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `infostd`
--

CREATE TABLE `infostd` (
  `Uid` int(4) NOT NULL,
  `STD_id` int(4) DEFAULT NULL,
  `Name` varchar(30) DEFAULT NULL,
  `InRollNumber` int(15) DEFAULT NULL,
  `Phone` int(12) DEFAULT NULL,
  `Password` int(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `infostd`
--

INSERT INTO `infostd` (`Uid`, `STD_id`, `Name`, `InRollNumber`, `Phone`, `Password`) VALUES
(1, 1, 'aminhassal', 111212, 9289198, 0),
(17, NULL, 'عائشة', 1535789, 89563, 123),
(18, NULL, 'amin', 123, 123, 123);

-- --------------------------------------------------------

--
-- Table structure for table `masterofcourse`
--

CREATE TABLE `masterofcourse` (
  `MasterOfCourseID_PK` int(11) NOT NULL,
  `StudentUID` int(11) NOT NULL,
  `ClassID_FK` int(11) NOT NULL,
  `RecordID_FK` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `records`
--

CREATE TABLE `records` (
  `RecordID_PK` int(11) NOT NULL,
  `StudentUID` int(11) DEFAULT NULL,
  `RecordStatus` varchar(50) DEFAULT NULL,
  `RecordDate` date DEFAULT NULL,
  `RecordTime` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `records`
--

INSERT INTO `records` (`RecordID_PK`, `StudentUID`, `RecordStatus`, `RecordDate`, `RecordTime`) VALUES
(103, 1, 'Check In', '2024-10-25', '20:02:00'),
(104, 18, 'Check In', '2025-01-08', '20:02:00');

-- --------------------------------------------------------

--
-- Stand-in structure for view `reportview`
-- (See below for the actual view)
--
CREATE TABLE `reportview` (
`StudentClassID` int(11)
,`Uid` int(4)
,`Name` varchar(30)
,`InRollNumber` int(15)
,`Date` datetime
,`RecordStatus` varchar(50)
,`ClassID` int(11)
,`classname` varchar(30)
,`subjectname` varchar(15)
,`RecordDate` date
,`RecordTime` varchar(10)
);

-- --------------------------------------------------------

--
-- Table structure for table `studentclass`
--

CREATE TABLE `studentclass` (
  `StudentClassID` int(11) NOT NULL,
  `ClassID` int(11) NOT NULL,
  `StdUid_FK` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `studentclass`
--

INSERT INTO `studentclass` (`StudentClassID`, `ClassID`, `StdUid_FK`) VALUES
(19, 42, 1),
(20, 43, 1),
(24, 44, 1),
(25, 43, 17),
(27, 45, 18);

-- --------------------------------------------------------

--
-- Stand-in structure for view `studentinsubjects`
-- (See below for the actual view)
--
CREATE TABLE `studentinsubjects` (
`ClassID` int(11)
,`Name` varchar(30)
,`InRollNumber` int(15)
,`StdUid_FK` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `student_in_class`
-- (See below for the actual view)
--
CREATE TABLE `student_in_class` (
`StudentClassID` int(11)
,`Uid` int(4)
,`Name` varchar(30)
,`InRollNumber` int(15)
,`ClassID` int(11)
,`Date` datetime
,`classname` varchar(30)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `student_records`
-- (See below for the actual view)
--
CREATE TABLE `student_records` (
`InRollNumber` int(15)
,`Name` varchar(30)
,`RecordStatus` varchar(50)
,`RecordDate` date
,`RecordTime` varchar(10)
,`SubjectName` varchar(15)
);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `SubjectID_PK` int(11) NOT NULL,
  `SubjectName` varchar(15) NOT NULL,
  `SubjectCode` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`SubjectID_PK`, `SubjectName`, `SubjectCode`) VALUES
(1, 'إنجليزي', '[ENG102]'),
(2, 'رياضة 1', 'math101'),
(10, 'مادة الاحصاء', 'ART101');

-- --------------------------------------------------------

--
-- Stand-in structure for view `vrecords`
-- (See below for the actual view)
--
CREATE TABLE `vrecords` (
`StudentClassID` int(11)
,`Uid` int(4)
,`Name` varchar(30)
,`InRollNumber` int(15)
,`Date` datetime
,`RecordStatus` varchar(50)
,`ClassID` int(11)
);

-- --------------------------------------------------------

--
-- Structure for view `reportview`
--
DROP TABLE IF EXISTS `reportview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `reportview`  AS SELECT `sic`.`StudentClassID` AS `StudentClassID`, `sic`.`Uid` AS `Uid`, `sic`.`Name` AS `Name`, `sic`.`InRollNumber` AS `InRollNumber`, `sic`.`Date` AS `Date`, `r`.`RecordStatus` AS `RecordStatus`, `sic`.`ClassID` AS `ClassID`, `sic`.`classname` AS `classname`, `sr`.`SubjectName` AS `subjectname`, `sr`.`RecordDate` AS `RecordDate`, `sr`.`RecordTime` AS `RecordTime` FROM ((`student_in_class` `sic` left join `records` `r` on(`sic`.`Date` = `r`.`RecordDate`)) join `student_records` `sr` on(`sic`.`Name` = `sr`.`Name`)) ;

-- --------------------------------------------------------

--
-- Structure for view `studentinsubjects`
--
DROP TABLE IF EXISTS `studentinsubjects`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `studentinsubjects`  AS SELECT `studentclass`.`ClassID` AS `ClassID`, `infostd`.`Name` AS `Name`, `infostd`.`InRollNumber` AS `InRollNumber`, `studentclass`.`StdUid_FK` AS `StdUid_FK` FROM ((`infostd` join `studentclass` on(`infostd`.`Uid` = `studentclass`.`StdUid_FK`)) join `class` on(`studentclass`.`ClassID` = `class`.`ClassID`)) ;

-- --------------------------------------------------------

--
-- Structure for view `student_in_class`
--
DROP TABLE IF EXISTS `student_in_class`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `student_in_class`  AS SELECT `studentclass`.`StudentClassID` AS `StudentClassID`, `infostd`.`Uid` AS `Uid`, `infostd`.`Name` AS `Name`, `infostd`.`InRollNumber` AS `InRollNumber`, `studentclass`.`ClassID` AS `ClassID`, `class`.`OpenDate` AS `Date`, `class`.`classname` AS `classname` FROM (((`class` join `subjects` on(`class`.`SubjectID_FK` = `subjects`.`SubjectID_PK`)) join `studentclass` on(`class`.`ClassID` = `studentclass`.`ClassID`)) join `infostd` on(`studentclass`.`StdUid_FK` = `infostd`.`Uid`)) ;

-- --------------------------------------------------------

--
-- Structure for view `student_records`
--
DROP TABLE IF EXISTS `student_records`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `student_records`  AS SELECT `infostd`.`InRollNumber` AS `InRollNumber`, `infostd`.`Name` AS `Name`, `records`.`RecordStatus` AS `RecordStatus`, `records`.`RecordDate` AS `RecordDate`, `records`.`RecordTime` AS `RecordTime`, `subjects`.`SubjectName` AS `SubjectName` FROM ((((`subjects` join `class` on(`subjects`.`SubjectID_PK` = `class`.`SubjectID_FK`)) join `studentclass` on(`class`.`ClassID` = `studentclass`.`ClassID`)) join `infostd` on(`studentclass`.`StdUid_FK` = `infostd`.`Uid`)) join `records` on(`infostd`.`Uid` = `records`.`StudentUID`)) ;

-- --------------------------------------------------------

--
-- Structure for view `vrecords`
--
DROP TABLE IF EXISTS `vrecords`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vrecords`  AS select `sic`.`StudentClassID` AS `StudentClassID`,`sic`.`Uid` AS `Uid`,`sic`.`Name` AS `Name`,`sic`.`InRollNumber` AS `InRollNumber`,`sic`.`Date` AS `Date`,`r`.`RecordStatus` AS `RecordStatus`,`sic`.`ClassID` AS `ClassID` from (`hr-class`.`student_in_class` `sic` left join `hr-class`.`records` `r` on(`sic`.`Date` = `r`.`RecordDate` and `sic`.`Uid` = `r`.`StudentUID`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`AdminID_PK`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`ClassID`),
  ADD KEY `SubjectID_FK` (`SubjectID_FK`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`CourseiID`),
  ADD KEY `CorseTOclass` (`ClassID_FK`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`DeviceID_PK`);

--
-- Indexes for table `infostd`
--
ALTER TABLE `infostd`
  ADD PRIMARY KEY (`Uid`);

--
-- Indexes for table `masterofcourse`
--
ALTER TABLE `masterofcourse`
  ADD PRIMARY KEY (`MasterOfCourseID_PK`),
  ADD KEY `B` (`ClassID_FK`),
  ADD KEY `StudentUID` (`StudentUID`),
  ADD KEY `RecordID_FK` (`RecordID_FK`);

--
-- Indexes for table `records`
--
ALTER TABLE `records`
  ADD PRIMARY KEY (`RecordID_PK`),
  ADD KEY `StudentUID` (`StudentUID`);

--
-- Indexes for table `studentclass`
--
ALTER TABLE `studentclass`
  ADD PRIMARY KEY (`StudentClassID`),
  ADD KEY `STDclassStudents` (`StdUid_FK`),
  ADD KEY `STDclassClasses` (`ClassID`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`SubjectID_PK`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `AdminID_PK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `ClassID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `CourseiID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `DeviceID_PK` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `infostd`
--
ALTER TABLE `infostd`
  MODIFY `Uid` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `masterofcourse`
--
ALTER TABLE `masterofcourse`
  MODIFY `MasterOfCourseID_PK` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `records`
--
ALTER TABLE `records`
  MODIFY `RecordID_PK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `studentclass`
--
ALTER TABLE `studentclass`
  MODIFY `StudentClassID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `SubjectID_PK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `ClassTOSubject` FOREIGN KEY (`SubjectID_FK`) REFERENCES `subjects` (`SubjectID_PK`) ON UPDATE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `CorseTOclass` FOREIGN KEY (`ClassID_FK`) REFERENCES `class` (`ClassID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `masterofcourse`
--
ALTER TABLE `masterofcourse`
  ADD CONSTRAINT `CLASSTOMASTER` FOREIGN KEY (`ClassID_FK`) REFERENCES `class` (`ClassID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `RecordToMasterOfCourse` FOREIGN KEY (`RecordID_FK`) REFERENCES `records` (`RecordID_PK`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Std_To_Master` FOREIGN KEY (`StudentUID`) REFERENCES `infostd` (`Uid`) ON UPDATE CASCADE;

--
-- Constraints for table `records`
--
ALTER TABLE `records`
  ADD CONSTRAINT `InfoSTDtoRecord` FOREIGN KEY (`StudentUID`) REFERENCES `infostd` (`Uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `studentclass`
--
ALTER TABLE `studentclass`
  ADD CONSTRAINT `STDclassClasses` FOREIGN KEY (`ClassID`) REFERENCES `class` (`ClassID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `STDclassStudents` FOREIGN KEY (`StdUid_FK`) REFERENCES `infostd` (`Uid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 06, 2020 at 03:21 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `roozterdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `Admin_ID` int(11) NOT NULL AUTO_INCREMENT,
  `User_Name` text NOT NULL,
  `Password` varchar(32) NOT NULL,
  `Email` text DEFAULT NULL,
  `Verified` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = no 1 = yes',
  PRIMARY KEY (`Admin_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Admin_ID`, `User_Name`, `Password`, `Email`, `Verified`) VALUES
(1, 'admin', '68eacb97d86f0c4621fa2b0e17cabd8c', NULL, 1),
(2, 'Admin2', '6f9dff5af05096ea9f23cc7bedd65683', NULL, 1),
(3, 'admin3', '874fcc6e14275dde5a23319c9ce5f8e4', NULL, 1),
(4, 'admin4', 'b025a0d0ec287ba8ad0d90f4ff69158f', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `classroom`
--

DROP TABLE IF EXISTS `classroom`;
CREATE TABLE IF NOT EXISTS `classroom` (
  `ClassroomID` int(11) NOT NULL AUTO_INCREMENT,
  `Classroom_Name` text NOT NULL,
  `Capacity` int(11) NOT NULL DEFAULT 30,
  PRIMARY KEY (`ClassroomID`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classroom`
--

INSERT INTO `classroom` (`ClassroomID`, `Classroom_Name`, `Capacity`) VALUES
(1, 'J04', 40),
(2, 'Q1-01', 30),
(3, 'Q1-02', 30),
(4, 'Q1-03', 30),
(5, 'Q1-04', 30),
(6, 'Q2-01', 30),
(7, 'Q2-02', 30),
(8, 'Q2-03', 30),
(9, 'Q2-04', 30),
(10, 'K1', 30),
(11, 'K2', 30),
(12, 'K3', 30),
(13, 'K4', 30),
(15, 'ETA', 30),
(16, 'MULTIMEDIA', 30),
(17, 'ICT-LAB', 30),
(18, 'NETWORK', 30),
(21, '[TEST]', 30),
(24, 'test class', 8);

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `EventID` int(11) NOT NULL AUTO_INCREMENT,
  `Event_Name` text NOT NULL,
  PRIMARY KEY (`EventID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`EventID`, `Event_Name`) VALUES
(1, 'College'),
(2, 'Conferentie'),
(3, 'Course'),
(4, 'Guest'),
(5, 'Hertentamen'),
(6, 'Informatieavond'),
(7, 'Inzage'),
(8, 'Kntl'),
(9, 'Lezing'),
(10, 'Meeting'),
(11, 'Other'),
(12, 'Pre-graduation'),
(13, 'Presentatie'),
(14, 'Project Tentamen'),
(15, 'Symposium'),
(16, 'Tentamen');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

DROP TABLE IF EXISTS `faculty`;
CREATE TABLE IF NOT EXISTS `faculty` (
  `FacultyID` int(11) NOT NULL AUTO_INCREMENT,
  `Faculty_Name` text NOT NULL,
  PRIMARY KEY (`FacultyID`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`FacultyID`, `Faculty_Name`) VALUES
(1, 'FdTW'),
(2, 'AF'),
(3, 'FdR'),
(4, 'FMG'),
(5, 'FdSEW'),
(6, 'Algemeen'),
(7, 'TEMP');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE IF NOT EXISTS `schedule` (
  `ScheduleID` int(11) NOT NULL AUTO_INCREMENT,
  `Start` time NOT NULL,
  `End` time NOT NULL,
  `TeacherID` int(11) NOT NULL,
  `ClassroomID` int(11) NOT NULL,
  `FacultyID` int(11) NOT NULL,
  `EventID` int(11) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `Status` int(11) NOT NULL COMMENT 'Cancelled? 0 = no 1 = yes',
  `Date` date NOT NULL,
  PRIMARY KEY (`ScheduleID`),
  KEY `FacultyID` (`FacultyID`),
  KEY `schedule_ibfk_3` (`TeacherID`),
  KEY `schedule_ibfk_1` (`EventID`),
  KEY `ClassroomID` (`ClassroomID`),
  KEY `SubjectID` (`SubjectID`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`ScheduleID`, `Start`, `End`, `TeacherID`, `ClassroomID`, `FacultyID`, `EventID`, `SubjectID`, `Status`, `Date`) VALUES
(2, '06:00:00', '08:00:00', 7, 4, 1, 1, 2, 0, '2020-03-19'),
(19, '01:00:00', '13:01:00', 1, 16, 1, 12, 1, 0, '2020-05-06'),
(21, '12:00:00', '16:00:00', 3, 2, 1, 1, 14, 0, '2020-04-19'),
(22, '09:10:00', '14:00:00', 12, 11, 4, 3, 53, 1, '2020-04-20'),
(24, '14:00:00', '16:30:00', 2, 6, 1, 1, 2, 0, '2020-04-21'),
(25, '14:00:00', '16:00:00', 1, 1, 1, 3, 14, 0, '2020-04-20'),
(26, '05:00:00', '07:00:00', 3, 1, 1, 1, 14, 0, '2020-05-02'),
(27, '18:00:00', '19:00:00', 1, 1, 1, 3, 14, 0, '2020-04-20'),
(28, '14:00:00', '15:00:00', 2, 1, 1, 1, 14, 0, '2020-05-03'),
(31, '01:00:00', '13:00:00', 10, 1, 2, 1, 53, 0, '2020-05-06'),
(32, '13:00:00', '16:00:00', 1, 10, 1, 1, 1, 1, '2020-05-12'),
(33, '10:00:00', '00:00:00', 2, 1, 1, 1, 14, 0, '2020-05-20'),
(34, '10:00:00', '00:00:00', 2, 1, 1, 1, 14, 0, '2020-05-27'),
(35, '10:00:00', '00:00:00', 2, 1, 1, 1, 14, 0, '2020-06-03'),
(43, '13:00:00', '16:00:00', 3, 15, 1, 1, 1, 0, '2020-05-28'),
(44, '13:00:00', '16:00:00', 3, 15, 1, 1, 1, 0, '2020-06-04'),
(47, '13:00:00', '16:00:00', 3, 15, 1, 1, 1, 0, '2020-06-04'),
(48, '13:00:00', '17:00:00', 2, 10, 1, 1, 14, 0, '2020-05-21'),
(49, '13:00:00', '17:00:00', 2, 10, 1, 1, 14, 0, '2020-05-28'),
(50, '13:00:00', '17:00:00', 2, 10, 1, 1, 14, 0, '2020-06-04'),
(51, '01:00:00', '04:20:00', 2, 16, 1, 7, 2, 0, '2020-06-26');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

DROP TABLE IF EXISTS `subject`;
CREATE TABLE IF NOT EXISTS `subject` (
  `SubjectID` int(11) NOT NULL AUTO_INCREMENT,
  `Subject_Name` text NOT NULL,
  `FacultyID` int(11) NOT NULL DEFAULT 7,
  PRIMARY KEY (`SubjectID`),
  KEY `FacultyID` (`FacultyID`)
) ENGINE=InnoDB AUTO_INCREMENT=142 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`SubjectID`, `Subject_Name`, `FacultyID`) VALUES
(1, 'Energietechniek 5', 1),
(2, 'Technische begeleiding(T-TECHB) ', 1),
(3, 'Computervaardighecien{T-COMPV) ', 7),
(4, 'Nederlands Productietechniek 3 ', 7),
(5, 'Algemene Werktuigbouwkunde 3 ', 7),
(6, 'Kwantitatieveondoeksmethoden', 7),
(7, 'Engelse taalvaardigheid 1 ', 7),
(8, 'Onderhoudsnianagament ', 7),
(9, 'Lezen en schrijven 1', 7),
(10, 'Nederlands Productietechniek 3', 7),
(11, 'System Analysis', 7),
(12, 'B2-AC-Cost and Management Accounting 2', 7),
(13, 'P-BMSa-PrinMark', 7),
(14, 'Operating Systems', 1),
(15, 'Inleiding in Social Work', 7),
(16, 'Meeting', 7),
(17, '	P-FCa-Economics', 7),
(18, 'B2-FC-Project Financial Consulting', 7),
(19, 'B1-HRM-Management Tools for Organization Effectiveness', 7),
(20, 'B2-AC-Advanced Financial Accounting 1', 7),
(22, '	Ontwikkelingspsychologie', 7),
(23, '	Project Woning', 7),
(24, 'Sociaal agogisch handelen', 7),
(25, 'B2-BMS-GlobStratMgt', 7),
(26, 'Informatievaardigheden HBO Fisc', 7),
(27, 'BHV', 7),
(28, '	Bespreking', 7),
(29, 'Professional Master Talen', 7),
(30, 'Practicum ACT', 7),
(31, 'B2-BMS-SpanBusComm2', 7),
(32, 'B2-FC-FinRepA', 7),
(33, 'P-BMSa-DutchBusComm2', 7),
(34, 'B2-AC-AcadSkill', 7),
(35, 'Aspects of Australia 3.3 / Lit. 3.3', 7),
(36, 'Verdieping psychologie/pedagogiek 2.3', 7),
(37, 'Integrated Skills 1.3	', 7),
(38, '	Didaktika di idioma', 7),
(39, '	P-FCa-Dutch Business Communication', 7),
(40, 'B2-BMS-IntregMrk', 7),
(41, '	Studieloopbaanbegeleiding 2', 7),
(42, 'P-HR1-Dutch Proficiency 2', 7),
(43, 'B1-HRM-Business English 2', 7),
(44, 'B1-FCa-Professional Development 3', 7),
(45, 'Beginselen van het Privaatrecht', 7),
(46, '	Criminologie', 7),
(47, 'Beginselen van het Privaatrecht', 7),
(48, 'Betonconstructie 2', 7),
(49, '	B2-FC-MgtControl 2', 7),
(50, 'P-HR1-Business Communication', 7),
(52, 'P-FCa-EnglishBusComm2', 7),
(53, '	Project 2.3', 6),
(54, '	GeÃ¯ntegr. taalvaardigheid', 7),
(55, 'Ned. in Paptalige context 3.3', 7),
(56, 'Aspects of the Caribbean 2.3 / Lit. 2.3', 7),
(58, 'B2-BMS-BrandMgtStrat', 7),
(60, '	PG', 7),
(61, 'B1-FC-TaxMeth1', 7),
(62, '	Meeting', 7),
(63, '	P-HR1-Organizational Behavior: Individual Behavior, Business Ethics and Governance', 7),
(64, 'B2-FC-ApplFinMgt', 7),
(66, 'B1-AC-Statistics', 7),
(67, 'ORV Workshops', 7),
(68, 'Materiaalkunde 2', 7),
(69, '	Hydrologie', 7),
(70, 'P-FCa-PrinBus	', 7),
(71, 'P-BMSa-EnglishBusComm2	', 7),
(72, 'Materialen', 7),
(73, 'Energietechniek 3	', 7),
(74, 'Telecommunicatie Netwerken	', 7),
(75, 'Telecommunicatie Netwerken	', 7),
(76, 'Basissupervisie', 7),
(77, 'Zonne-energie', 7),
(78, 'B3-HRM-Professional Skills and Personal Development 8	', 7),
(79, 'Engelse taalvaardigheid 1	', 7),
(80, 'Kwantitatieve onderzoeksmethoden	', 7),
(81, 'Meeting', 7),
(82, 'Telecommunicatie', 7),
(83, 'Windenergie', 7),
(84, 'P-FC-IntroAIS	', 7),
(85, 'SLB', 7),
(86, 'P-HR1-Project 2: Developing HR Documents	', 7),
(87, 'P-BMSa-ProfessionalDevelopment 2	', 7),
(88, 'Taalvaardigheid Pap.	', 7),
(89, 'B1-AC-Accounting Methods	', 7),
(90, 'Energietechniek 1', 7),
(91, 'Prac. CAD	', 7),
(92, 'Fundering', 7),
(93, 'Theoretische Mechanica 3	', 7),
(94, 'B1-BMSa-FinMgt	', 7),
(95, 'Meeting', 7),
(96, 'Oplossingsgericht werken	', 7),
(97, 'P-FCa-LegalAsp	', 7),
(98, 'Inleiding pedagogiek 1.3	', 7),
(99, 'B3-BIS-Mentoring 7	', 7),
(100, 'Conferentie FMG	', 7),
(101, 'Studieloopbaanbegeleiding 2	', 7),
(102, 'Studieloopbaanbegeleiding 3	', 7),
(103, 'Studieloopbaanbegeleiding 4	', 7),
(104, 'B1-FC-FinanSocSupp	', 7),
(105, 'B1-HRM-Management Tools for Organization Effectiveness	', 7),
(106, 'P-HR1-English Proficiency 2	', 7),
(107, 'Communicatieve Vaardigheden 2	', 7),
(108, 'B2-AC-Strategic Management	', 7),
(109, 'Project Management HBO Fiscaal	', 7),
(110, '	Begeleiding 1.3', 7),
(111, 'B3-FM-Mentoring 7	', 7),
(112, 'Luistervaardigh. 1.2	', 7),
(113, 'Studieloopbaanbegeleiding 4	', 7),
(114, 'B2-FC-EconMonBank	', 7),
(115, 'Technisch Lezen	', 7),
(116, 'Schrijfvh./Leesvh. 2.3	', 7),
(117, 'Grammatica 2.3	', 7),
(118, 'Schrijfvh/Leesvh 1.3	', 7),
(119, 'P-HR1-Spanish Proficiency 2	', 7),
(120, 'Vakdidactiek 2.3	', 7),
(121, 'P-FC-PrinMgtAcc	', 7),
(122, 'Did. Grammatica 2.3	', 7),
(123, 'Begeleiding 3.3	', 7),
(124, 'B1-BMS-IntlBusiness	', 7),
(125, 'B2-AC-Accounting Information Systems 1	', 7),
(126, 'B1-HRM-Profesional Skills and Personal Development 4	', 7),
(127, 'Schrijfvaardigheid 1.3	', 7),
(128, 'Grammatica 2.3	', 7),
(129, 'B2-AC-Taxation	', 7),
(130, 'Project 3.3	', 7),
(131, 'ICT	', 7),
(132, 'Practicum Civil 3D	', 7),
(133, 'B2-AC-Auditing Principles	', 7),
(134, 'B1-BMS-Statistics	', 7),
(135, 'Fundamentals 1.3	', 7),
(136, 'Schrijfvaardigh 1.2	', 7),
(137, 'B2-FC-ApplFinMgt	', 7),
(138, 'PAK Gastdocententraject	', 7),
(139, 'Meeting', 7),
(140, 'B1-FC-TaxMeth1	', 7);

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

DROP TABLE IF EXISTS `teacher`;
CREATE TABLE IF NOT EXISTS `teacher` (
  `TeacherID` int(11) NOT NULL AUTO_INCREMENT,
  `Teacher_Lastname` text NOT NULL,
  `Teacher_Firstname` text NOT NULL,
  `FacultyID` int(11) NOT NULL,
  PRIMARY KEY (`TeacherID`),
  KEY `teacher_ibfk_1` (`FacultyID`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`TeacherID`, `Teacher_Lastname`, `Teacher_Firstname`, `FacultyID`) VALUES
(1, 'Alexander', 'Lesley', 1),
(2, 'Betrian', 'Sharlon', 1),
(3, 'Cruden', 'Henry', 1),
(4, 'Felipa', 'Rinnus', 1),
(5, 'Locadia', 'Ulysses', 1),
(6, 'Maduro', 'Alwin', 6),
(7, 'Schoop ', 'Ramphis', 1),
(8, 'van Nierop', 'Caroline ', 1),
(9, 'Ladeira', 'Luis', 1),
(10, 'Bremmers', 'Jerome', 2),
(11, 'Adeler', 'Jeroen', 3),
(12, 'Bakhuis', 'Yadira', 4),
(19, 'resster', 'Testteach', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`EventID`) REFERENCES `event` (`EventID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `schedule_ibfk_2` FOREIGN KEY (`FacultyID`) REFERENCES `faculty` (`FacultyID`) ON DELETE NO ACTION,
  ADD CONSTRAINT `schedule_ibfk_3` FOREIGN KEY (`TeacherID`) REFERENCES `teacher` (`TeacherID`) ON DELETE NO ACTION,
  ADD CONSTRAINT `schedule_ibfk_4` FOREIGN KEY (`ClassroomID`) REFERENCES `classroom` (`ClassroomID`),
  ADD CONSTRAINT `schedule_ibfk_5` FOREIGN KEY (`SubjectID`) REFERENCES `subject` (`SubjectID`) ON DELETE NO ACTION;

--
-- Constraints for table `subject`
--
ALTER TABLE `subject`
  ADD CONSTRAINT `subject_ibfk_1` FOREIGN KEY (`FacultyID`) REFERENCES `faculty` (`FacultyID`);

--
-- Constraints for table `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `teacher_ibfk_1` FOREIGN KEY (`FacultyID`) REFERENCES `faculty` (`FacultyID`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Creato il: Gen 13, 2020 alle 16:04
-- Versione del server: 5.7.26
-- Versione PHP: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school_db`
--

DROP DATABASE IF EXISTS school_db;
DROP DATABASE IF EXISTS schooldb;

CREATE DATABASE IF NOT EXISTS `school_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `school_db`;

-- --------------------------------------------------------

--
-- Struttura della tabella `assignments`
--

DROP TABLE IF EXISTS `assignments`;
CREATE TABLE IF NOT EXISTS `assignments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(300) NOT NULL,
  `subject` varchar(45) NOT NULL,
  `topic` varchar(300) NOT NULL,
  `date` varchar(45) NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `idTeach` int(11) NOT NULL,
  `idClass` varchar(45) NOT NULL,
  `deadline` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `assignments`
--

INSERT INTO `assignments` (`id`, `text`, `subject`, `topic`, `date`, `attachment`, `idTeach`, `idClass`, `deadline`) VALUES
(1, 'Page 294, Ex. 1, 2 and 3.', 'Biology', 'Amphibians', '2019-12-2', '20191203172240.pdf', 1, '1A', '2019-12-9'),
(2, 'Study mammals at pages 35-40', 'Biology', 'Mammals', '2019-12-12', NULL, 1, '1B', '2019-12-19');

-- --------------------------------------------------------

--
-- Struttura della tabella `classroom`
--

DROP TABLE IF EXISTS `classroom`;
CREATE TABLE IF NOT EXISTS `classroom` (
  `id` varchar(45) NOT NULL,
  `capacity` int(20) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `classroom`
--

INSERT INTO `classroom` (`id`, `capacity`, `description`, `created_at`, `updated_at`) VALUES
('1A', 25, 'This class has a LIM', '2019-12-02 19:10:48', '2019-12-02 19:10:48'),
('1B', 25, 'This class has many desks.', '2019-12-02 19:11:57', '2019-12-02 19:11:57'),
('1C', 25, 'This class has wonderful chairs.', '2019-12-02 19:12:25', '2019-12-02 19:12:25'),
('1D', 25, 'This class has a beautiful view on the garden.', '2019-12-02 19:13:22', '2019-12-02 19:13:22');

-- --------------------------------------------------------

--
-- Struttura della tabella `class_coordinator`
--

DROP TABLE IF EXISTS `class_coordinator`;
CREATE TABLE IF NOT EXISTS `class_coordinator` (
  `idTeach` int(11) NOT NULL,
  `idClass` varchar(45) NOT NULL,
  PRIMARY KEY (`idTeach`,`idClass`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `class_coordinator`
--

INSERT INTO `class_coordinator` (`idTeach`, `idClass`) VALUES
(1, '1A');

-- --------------------------------------------------------

--
-- Struttura della tabella `communications`
--

DROP TABLE IF EXISTS `communications`;
CREATE TABLE IF NOT EXISTS `communications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idAdmin` int(11) NOT NULL,
  `description` varchar(300) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `communications`
--

INSERT INTO `communications` (`id`, `idAdmin`, `description`, `date`) VALUES
(1, 1, 'Dear all,\r\nit is my duty to inform you that the Secretariat will be closed during Winter festivities.\r\nMy sincerest.', '2019-12-02 20:53:03');

-- --------------------------------------------------------

--
-- Struttura della tabella `final_grades`
--

DROP TABLE IF EXISTS `final_grades`;
CREATE TABLE IF NOT EXISTS `final_grades` (
  `idStudent` int(11) NOT NULL,
  `idSubject` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `idClass` varchar(45) NOT NULL,
  `finalgrade` int(11) NOT NULL,
  PRIMARY KEY (`idStudent`,`idSubject`,`year`),
  KEY `subject` (`idSubject`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `lecturetopic`
--

DROP TABLE IF EXISTS `lecturetopic`;
CREATE TABLE IF NOT EXISTS `lecturetopic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idClass` varchar(45) NOT NULL,
  `idTeach` int(11) NOT NULL,
  `subject` varchar(45) NOT NULL,
  `date` varchar(45) NOT NULL,
  `topic` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `lecturetopic`
--

INSERT INTO `lecturetopic` (`id`, `idClass`, `idTeach`, `subject`, `date`, `topic`) VALUES
(1, '1A', 1, 'Biology', '2019-12-2', 'Amphibians'),
(2, '1B', 1, 'Biology', '2019-12-2', 'Amphibians and Reptiles'),
(3, '1B', 1, 'Biology', '2019-12-12', 'Mammals');

-- --------------------------------------------------------

--
-- Struttura della tabella `marks`
--

DROP TABLE IF EXISTS `marks`;
CREATE TABLE IF NOT EXISTS `marks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idClass` varchar(45) NOT NULL,
  `idTeach` int(11) NOT NULL,
  `idStudent` int(11) NOT NULL,
  `date` date NOT NULL,
  `mark` float NOT NULL,
  `subject` varchar(255) NOT NULL,
  `topic` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `marks`
--

INSERT INTO `marks` (`id`, `idClass`, `idTeach`, `idStudent`, `date`, `mark`, `subject`, `topic`) VALUES
(1, '1A', 1, 1, '2019-12-02', 8.5, 'Biology', 'Rhynos'),
(2, '1A', 1, 2, '2019-12-02', 6.25, 'Biology', 'Rhynos'),
(3, '1B', 1, 5, '2019-12-02', 2, 'Biology', 'Not Prepared'),
(4, '1A', 1, 11, '2019-12-12', 4.5, 'Biology', 'Mammals');

-- --------------------------------------------------------

--
-- Struttura della tabella `meetings`
--

DROP TABLE IF EXISTS `meetings`;
CREATE TABLE IF NOT EXISTS `meetings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idTimeslot` int(11) NOT NULL,
  `idTeacher` int(11) NOT NULL,
  `idweek` varchar(8) NOT NULL,
  `isBooked` tinyint(1) NOT NULL DEFAULT '0',
  `idParent` bigint(20) DEFAULT NULL,
  `idStud` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `availability` (`idTeacher`,`idTimeslot`,`idweek`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=153 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `meetings`
--

INSERT INTO `meetings` (`id`, `idTimeslot`, `idTeacher`, `idweek`, `isBooked`, `idParent`, `idStud`) VALUES
(64, 3, 1, '2019-W50', 0, NULL, NULL),
(66, 21, 1, '2019-W50', 0, NULL, NULL),
(67, 3, 1, '2019-W51', 0, NULL, NULL),
(68, 9, 1, '2019-W51', 0, NULL, NULL),
(69, 21, 1, '2019-W51', 0, NULL, NULL),
(70, 3, 1, '2020-W02', 0, NULL, NULL),
(71, 9, 1, '2020-W02', 0, NULL, NULL),
(72, 21, 1, '2020-W02', 0, NULL, NULL),
(73, 3, 1, '2020-W03', 0, NULL, NULL),
(74, 9, 1, '2020-W03', 1, 4, 1),
(76, 3, 1, '2020-W04', 0, NULL, NULL),
(77, 9, 1, '2020-W04', 0, NULL, NULL),
(78, 21, 1, '2020-W04', 0, NULL, NULL),
(79, 3, 1, '2020-W05', 0, NULL, NULL),
(80, 9, 1, '2020-W05', 0, NULL, NULL),
(81, 21, 1, '2020-W05', 0, NULL, NULL),
(82, 3, 1, '2020-W06', 0, NULL, NULL),
(83, 9, 1, '2020-W06', 0, NULL, NULL),
(84, 21, 1, '2020-W06', 0, NULL, NULL),
(85, 3, 1, '2020-W07', 0, NULL, NULL),
(86, 9, 1, '2020-W07', 0, NULL, NULL),
(87, 21, 1, '2020-W07', 0, NULL, NULL),
(88, 3, 1, '2020-W08', 0, NULL, NULL),
(89, 9, 1, '2020-W08', 0, NULL, NULL),
(90, 21, 1, '2020-W08', 0, NULL, NULL),
(91, 3, 1, '2020-W09', 0, NULL, NULL),
(92, 9, 1, '2020-W09', 0, NULL, NULL),
(93, 21, 1, '2020-W09', 0, NULL, NULL),
(94, 3, 1, '2020-W10', 0, NULL, NULL),
(95, 9, 1, '2020-W10', 0, NULL, NULL),
(96, 21, 1, '2020-W10', 0, NULL, NULL),
(97, 3, 1, '2020-W11', 0, NULL, NULL),
(98, 9, 1, '2020-W11', 0, NULL, NULL),
(99, 21, 1, '2020-W11', 0, NULL, NULL),
(100, 3, 1, '2020-W12', 0, NULL, NULL),
(101, 9, 1, '2020-W12', 0, NULL, NULL),
(102, 21, 1, '2020-W12', 0, NULL, NULL),
(103, 3, 1, '2020-W13', 0, NULL, NULL),
(104, 9, 1, '2020-W13', 0, NULL, NULL),
(105, 21, 1, '2020-W13', 0, NULL, NULL),
(106, 3, 1, '2020-W14', 0, NULL, NULL),
(107, 9, 1, '2020-W14', 0, NULL, NULL),
(108, 21, 1, '2020-W14', 0, NULL, NULL),
(109, 3, 1, '2020-W15', 0, NULL, NULL),
(110, 9, 1, '2020-W15', 0, NULL, NULL),
(111, 21, 1, '2020-W15', 0, NULL, NULL),
(112, 3, 1, '2020-W16', 0, NULL, NULL),
(113, 9, 1, '2020-W16', 0, NULL, NULL),
(114, 21, 1, '2020-W16', 0, NULL, NULL),
(115, 3, 1, '2020-W17', 0, NULL, NULL),
(116, 9, 1, '2020-W17', 0, NULL, NULL),
(117, 21, 1, '2020-W17', 0, NULL, NULL),
(118, 3, 1, '2020-W18', 0, NULL, NULL),
(119, 9, 1, '2020-W18', 0, NULL, NULL),
(120, 21, 1, '2020-W18', 0, NULL, NULL),
(121, 3, 1, '2020-W19', 0, NULL, NULL),
(122, 9, 1, '2020-W19', 0, NULL, NULL),
(123, 21, 1, '2020-W19', 0, NULL, NULL),
(124, 3, 1, '2020-W20', 0, NULL, NULL),
(125, 9, 1, '2020-W20', 0, NULL, NULL),
(126, 21, 1, '2020-W20', 0, NULL, NULL),
(127, 3, 1, '2020-W21', 0, NULL, NULL),
(128, 9, 1, '2020-W21', 0, NULL, NULL),
(129, 21, 1, '2020-W21', 0, NULL, NULL),
(130, 3, 1, '2020-W22', 0, NULL, NULL),
(131, 9, 1, '2020-W22', 0, NULL, NULL),
(132, 21, 1, '2020-W22', 0, NULL, NULL),
(133, 3, 1, '2020-W23', 0, NULL, NULL),
(134, 9, 1, '2020-W23', 0, NULL, NULL),
(135, 21, 1, '2020-W23', 0, NULL, NULL),
(136, 3, 1, '2020-W24', 0, NULL, NULL),
(137, 9, 1, '2020-W24', 0, NULL, NULL),
(138, 21, 1, '2020-W24', 0, NULL, NULL),
(139, 3, 1, '2020-W25', 0, NULL, NULL),
(140, 9, 1, '2020-W25', 0, NULL, NULL),
(141, 21, 1, '2020-W25', 0, NULL, NULL),
(142, 3, 1, '2020-W26', 0, NULL, NULL),
(143, 9, 1, '2020-W26', 0, NULL, NULL),
(144, 21, 1, '2020-W26', 0, NULL, NULL),
(145, 3, 1, '2020-W27', 0, NULL, NULL),
(146, 9, 1, '2020-W27', 0, NULL, NULL),
(147, 21, 1, '2020-W27', 0, NULL, NULL),
(148, 3, 1, '2020-W28', 0, NULL, NULL),
(149, 9, 1, '2020-W28', 0, NULL, NULL),
(150, 21, 1, '2020-W28', 0, NULL, NULL),
(151, 15, 1, '2019-W50', 0, NULL, NULL),
(152, 19, 1, '2020-W03', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `notes`
--

DROP TABLE IF EXISTS `notes`;
CREATE TABLE IF NOT EXISTS `notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idClass` varchar(45) NOT NULL,
  `idTeach` int(11) NOT NULL,
  `idStudent` int(11) NOT NULL,
  `subject` varchar(45) NOT NULL,
  `date` varchar(45) NOT NULL,
  `note` varchar(300) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idClass` (`idClass`),
  KEY `idTeach` (`idTeach`),
  KEY `idStudent` (`idStudent`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `notes`
--

INSERT INTO `notes` (`id`, `idClass`, `idTeach`, `idStudent`, `subject`, `date`, `note`) VALUES
(1, '1A', 1, 1, 'Biology', '2019-12-02', 'The student takes a bottle and does unspeakable things.'),
(2, '1B', 1, 5, 'Biology', '2019-12-02', 'The student talks with his deskmate during the lecture'),
(3, '1A', 1, 1, 'Biology', '2019-12-02', 'The student keeps shouting to the teacher.'),
(4, '1B', 1, 6, 'Biology', '2019-12-12', 'The student is not in class when the teacher arrives.');

-- --------------------------------------------------------

--
-- Struttura della tabella `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(45) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'Admin'),
(2, 'Teacher'),
(3, 'Parent'),
(4, 'Class Coordinator'),
(5, 'Super Admin'),
(6, 'Principal');

-- --------------------------------------------------------

--
-- Struttura della tabella `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(45) DEFAULT NULL,
  `lastName` varchar(45) DEFAULT NULL,
  `birthday` varchar(45) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `postCode` varchar(10) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `gender` enum('F','M') DEFAULT 'M',
  `skill` int(11) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `classId` varchar(45) DEFAULT NULL,
  `firstYear` enum('yes','no') NOT NULL DEFAULT 'yes',
  `birthPlace` varchar(45) DEFAULT NULL,
  `fiscalCode` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `mailParent1` varchar(255) DEFAULT NULL,
  `mailParent2` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ClassId_idx` (`classId`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `student`
--

INSERT INTO `student` (`id`, `firstName`, `lastName`, `birthday`, `address`, `phone`, `postCode`, `photo`, `gender`, `skill`, `description`, `email`, `classId`, `firstYear`, `birthPlace`, `fiscalCode`, `created_at`, `updated_at`, `mailParent1`, `mailParent2`) VALUES
(1, 'Giacomo', 'Poretti', '2006-04-26', 'Via Flanagan, 67', NULL, NULL, '20200113135819.jpg', 'M', 8, 'The pinnacle of all students in Milan.', 'student1@test.com', '1A', 'yes', 'Milano', 'FRNGTN68S45A794O', '2019-12-02 19:26:51', '2019-12-02 19:26:51', 'parent1@test.com', 'parent2@test.com'),
(2, 'Simone', 'Giuffrida', '2006-10-18', NULL, NULL, NULL, NULL, 'M', 8, 'A great mbare.', 'student2@test.com', '1A', 'yes', 'Catania', NULL, '2019-12-02 19:33:47', '2019-12-02 19:33:47', 'sasagiuffrid@test.com', 'agatasanta@test.com'),
(3, 'Filippo', 'Pofilli', '2006-05-31', NULL, NULL, NULL, NULL, 'M', 6, NULL, 'student3@test.com', '1A', 'yes', 'Benevento', NULL, '2019-12-02 19:36:30', '2019-12-02 19:36:30', 'gpoliffo@test.com', 'mama@test.com'),
(4, 'Virginia', 'Turati', '2006-03-15', NULL, NULL, NULL, NULL, 'F', 7, NULL, NULL, '1A', 'yes', 'Torino', NULL, '2019-12-02 19:37:51', '2019-12-02 19:37:51', 'rodolfot@test.com', 'yolaskov@test.com'),
(5, 'Lorenzo', 'Russo', '2006-07-03', NULL, NULL, NULL, NULL, 'M', 10, NULL, NULL, '1B', 'yes', 'Catania', NULL, '2019-12-02 19:39:12', '2019-12-02 19:39:12', 'hubertrusso@test.com', 'rosalbadege@test.com'),
(6, 'Gabriel', 'Barbosa', '2006-07-02', NULL, NULL, NULL, NULL, 'M', 8, NULL, NULL, '1B', 'yes', 'Medellin', NULL, '2019-12-02 19:40:36', '2019-12-02 19:40:36', 'lbarbosa@test.com', 'kzapata@test.com'),
(7, 'Arturo', 'Montalbano', '2006-11-06', NULL, NULL, NULL, NULL, 'M', 6, NULL, NULL, '1C', 'yes', 'Agrigento', NULL, '2019-12-02 19:41:54', '2019-12-02 19:41:54', 'mmont@test.com', 'grodriguez@test.com'),
(8, 'Angelo', 'Neri', '2006-08-08', NULL, NULL, NULL, NULL, 'M', 7, NULL, NULL, '1C', 'yes', 'Bologna', NULL, '2019-12-02 19:43:24', '2019-12-02 19:43:24', 'ignatius@test.com', 'conci@test.com'),
(9, 'Giada', 'Bella', '2006-11-07', NULL, NULL, NULL, NULL, 'F', 8, NULL, NULL, '1D', 'yes', 'Torino', NULL, '2019-12-02 19:45:54', '2019-12-02 19:45:54', 'tereso@test.com', 'stefy@test.com'),
(10, 'LeBron', 'James', '2006-06-26', NULL, NULL, NULL, NULL, 'M', 7, NULL, NULL, '1D', 'yes', 'Ontario', NULL, '2019-12-02 19:48:12', '2019-12-02 19:48:12', 'jj@test.com', 'fridafungo@test.com'),
(11, 'Giovanni', 'Storti', '2006-02-20', NULL, NULL, NULL, '20200113135625.jpg', 'M', 10, 'He does what he can.', 'student11@test.com', '1A', 'yes', 'Milano', 'FRNGTN68S45A794O', '2019-12-02 21:17:39', '2019-12-02 21:17:39', 'parent1@test.com', 'parent2@test.com');

-- --------------------------------------------------------

--
-- Struttura della tabella `student_attendance`
--

DROP TABLE IF EXISTS `student_attendance`;
CREATE TABLE IF NOT EXISTS `student_attendance` (
  `studentId` int(11) NOT NULL,
  `teacherId` int(11) NOT NULL,
  `classId` varchar(45) NOT NULL,
  `lectureDate` date NOT NULL,
  `status` enum('present','absent') NOT NULL DEFAULT 'present',
  `presence_status` enum('full','early','late') NOT NULL DEFAULT 'full',
  `description` text,
  PRIMARY KEY (`studentId`,`teacherId`,`classId`,`lectureDate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `studforparent`
--

DROP TABLE IF EXISTS `studforparent`;
CREATE TABLE IF NOT EXISTS `studforparent` (
  `idParent` int(11) NOT NULL,
  `idStudent` int(11) NOT NULL,
  PRIMARY KEY (`idParent`,`idStudent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `studforparent`
--

INSERT INTO `studforparent` (`idParent`, `idStudent`) VALUES
(3, 1),
(3, 11),
(4, 1),
(4, 11),
(5, 2),
(6, 2),
(7, 3),
(8, 3),
(9, 4),
(10, 4),
(11, 5),
(12, 5),
(13, 6),
(14, 6),
(15, 7),
(16, 7),
(17, 8),
(18, 8),
(19, 9),
(20, 9),
(21, 10),
(22, 10);

-- --------------------------------------------------------

--
-- Struttura della tabella `subjects`
--

DROP TABLE IF EXISTS `subjects`;
CREATE TABLE IF NOT EXISTS `subjects` (
  `subjectId` int(11) NOT NULL AUTO_INCREMENT,
  `subjectName` varchar(45) NOT NULL,
  PRIMARY KEY (`subjectId`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `subjects`
--

INSERT INTO `subjects` (`subjectId`, `subjectName`) VALUES
(1, 'Math'),
(2, 'Italian'),
(3, 'Art'),
(4, 'Latin'),
(5, 'History'),
(6, 'English'),
(7, 'Gym'),
(8, 'Physics'),
(9, 'Science'),
(10, 'Religion');

-- --------------------------------------------------------

--
-- Struttura della tabella `subject_programming`
--

DROP TABLE IF EXISTS `subject_programming`;
CREATE TABLE IF NOT EXISTS `subject_programming` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idTeaching` int(11) NOT NULL,
  `totalHours` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idTeaching` (`idTeaching`,`totalHours`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `subject_programming`
--

INSERT INTO `subject_programming` (`id`, `idTeaching`, `totalHours`) VALUES
(1, 1, 2),
(2, 3, 3),
(3, 4, 2),
(4, 5, 1),
(5, 6, 4),
(6, 7, 4),
(7, 8, 2),
(8, 9, 5),
(9, 10, 2),
(10, 11, 2),
(11, 12, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `suppmaterial`
--

DROP TABLE IF EXISTS `suppmaterial`;
CREATE TABLE IF NOT EXISTS `suppmaterial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idClass` varchar(45) NOT NULL,
  `idTeach` int(11) NOT NULL,
  `subject` varchar(45) NOT NULL,
  `material` varchar(255) NOT NULL,
  `date` varchar(45) NOT NULL,
  `mdescription` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `suppmaterial`
--

INSERT INTO `suppmaterial` (`id`, `idClass`, `idTeach`, `subject`, `material`, `date`, `mdescription`) VALUES
(1, '1A', 1, 'Biology', '20191202204056.pdf', '2019-12-02', 'Documentation about Amphibians');

-- --------------------------------------------------------

--
-- Struttura della tabella `teacher`
--

DROP TABLE IF EXISTS `teacher`;
CREATE TABLE IF NOT EXISTS `teacher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(45) DEFAULT NULL,
  `lastName` varchar(45) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `userId` bigint(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `postCode` varchar(10) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `gender` enum('M','F') DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `birthPlace` varchar(45) DEFAULT NULL,
  `fiscalCode` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `teacher`
--

INSERT INTO `teacher` (`id`, `firstName`, `lastName`, `birthday`, `userId`, `address`, `phone`, `postCode`, `photo`, `gender`, `description`, `birthPlace`, `fiscalCode`, `created_at`, `updated_at`) VALUES
(1, 'Gastani', 'Frinzi', '1968-11-05', 2, 'Via Garibaldi, 17', '3245895657', '24121', '20191202192026.jpg', 'F', 'Very strict.', 'Bergamo', 'FRNGTN68S45A794O', '2019-12-02 19:20:27', '2019-12-02 19:20:27'),
(2, 'Aldo', 'Baglio', '1958-09-28', 24, NULL, NULL, NULL, NULL, 'M', NULL, 'Palermo', NULL, '2019-12-02 20:56:23', '2019-12-02 20:56:23'),
(3, 'Virginio', 'Sciabica', NULL, 25, NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, '2019-12-02 21:00:42', '2019-12-02 21:00:42'),
(4, 'Nino', 'Frassica', '1950-12-11', 26, NULL, NULL, NULL, NULL, 'M', NULL, 'Messina', NULL, '2019-12-02 21:03:47', '2019-12-02 21:03:47'),
(5, 'Pippo', 'Franco', '1940-09-02', 27, NULL, NULL, NULL, NULL, 'M', NULL, 'Roma', NULL, '2019-12-02 21:05:01', '2019-12-02 21:05:01'),
(6, 'Mara', 'Maionchi', '1941-04-22', 28, NULL, NULL, NULL, NULL, 'F', NULL, 'Bologna', NULL, '2019-12-02 21:06:39', '2019-12-02 21:06:39'),
(7, 'Alberto', 'Angelo', '1962-04-08', 29, NULL, NULL, NULL, NULL, 'M', NULL, 'Paris', NULL, '2019-12-02 21:08:16', '2019-12-02 21:08:16');

-- --------------------------------------------------------

--
-- Struttura della tabella `teaching`
--

DROP TABLE IF EXISTS `teaching`;
CREATE TABLE IF NOT EXISTS `teaching` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idClass` varchar(45) NOT NULL,
  `idTeach` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `teaching`
--

INSERT INTO `teaching` (`id`, `idClass`, `idTeach`, `subject`) VALUES
(1, '1A', 1, 'Biology'),
(2, '1B', 1, 'Biology'),
(3, '1A', 2, 'English'),
(4, '1A', 2, 'Art'),
(5, '1A', 3, 'Religion'),
(6, '1A', 4, 'Italian'),
(7, '1A', 4, 'Latin'),
(8, '1A', 5, 'Physics'),
(9, '1A', 6, 'Math'),
(10, '1A', 7, 'History'),
(11, '1A', 7, 'Gym'),
(12, '1A', 0, 'Free');

-- --------------------------------------------------------

--
-- Struttura della tabella `timeslots`
--

DROP TABLE IF EXISTS `timeslots`;
CREATE TABLE IF NOT EXISTS `timeslots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hour` varchar(255) NOT NULL,
  `day` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `timeslot_index` (`hour`,`day`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `timeslots`
--

INSERT INTO `timeslots` (`id`, `hour`, `day`) VALUES
(27, '10:00', 'Friday'),
(3, '10:00', 'Monday'),
(33, '10:00', 'Saturday'),
(21, '10:00', 'Thursday'),
(9, '10:00', 'Tuesday'),
(15, '10:00', 'Wednesday'),
(28, '11:00', 'Friday'),
(4, '11:00', 'Monday'),
(34, '11:00', 'Saturday'),
(22, '11:00', 'Thursday'),
(10, '11:00', 'Tuesday'),
(16, '11:00', 'Wednesday'),
(29, '12:00', 'Friday'),
(5, '12:00', 'Monday'),
(35, '12:00', 'Saturday'),
(23, '12:00', 'Thursday'),
(11, '12:00', 'Tuesday'),
(17, '12:00', 'Wednesday'),
(30, '13:00', 'Friday'),
(6, '13:00', 'Monday'),
(36, '13:00', 'Saturday'),
(24, '13:00', 'Thursday'),
(12, '13:00', 'Tuesday'),
(18, '13:00', 'Wednesday'),
(25, '8:00', 'Friday'),
(1, '8:00', 'Monday'),
(31, '8:00', 'Saturday'),
(19, '8:00', 'Thursday'),
(7, '8:00', 'Tuesday'),
(13, '8:00', 'Wednesday'),
(26, '9:00', 'Friday'),
(2, '9:00', 'Monday'),
(32, '9:00', 'Saturday'),
(20, '9:00', 'Thursday'),
(8, '9:00', 'Tuesday'),
(14, '9:00', 'Wednesday');

-- --------------------------------------------------------

--
-- Struttura della tabella `timetable`
--

DROP TABLE IF EXISTS `timetable`;
CREATE TABLE IF NOT EXISTS `timetable` (
  `idClass` varchar(45) NOT NULL,
  `idTimeslot` int(11) NOT NULL,
  `idTeacher` int(11) NOT NULL,
  `subject` varchar(300) NOT NULL,
  UNIQUE KEY `lecture` (`idClass`,`idTimeslot`) USING BTREE,
  UNIQUE KEY `lecture_teacher` (`idTimeslot`,`idTeacher`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `timetable`
--

INSERT INTO `timetable` (`idClass`, `idTimeslot`, `idTeacher`, `subject`) VALUES
('1A', 1, 6, 'Math'),
('1A', 2, 4, 'Italian'),
('1A', 3, 2, 'Art'),
('1A', 4, 4, 'Latin'),
('1A', 5, 4, 'Latin'),
('1A', 6, 1, 'Biology'),
('1A', 7, 0, 'History'),
('1A', 8, 4, 'Italian'),
('1A', 9, 2, 'English'),
('1A', 10, 0, 'Gym'),
('1A', 11, 6, 'Math'),
('1A', 12, 5, 'Physics'),
('1A', 13, 4, 'Italian'),
('1A', 14, 4, 'Italian'),
('1A', 15, 2, 'English'),
('1A', 16, 1, 'Biology'),
('1A', 17, 4, 'Latin'),
('1A', 18, 0, ''),
('1A', 19, 2, 'English'),
('1A', 20, 0, 'History'),
('1A', 21, 6, 'Math'),
('1A', 22, 6, 'Math'),
('1A', 23, 3, 'Religion'),
('1A', 24, 0, ''),
('1A', 25, 5, 'Physics'),
('1A', 26, 0, 'Gym'),
('1A', 27, 4, 'Latin'),
('1A', 28, 1, 'Biology'),
('1A', 29, 6, 'Math'),
('1A', 30, 2, 'Art');

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `roleId` int(11) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('active','deactive') DEFAULT 'active',
  `photo` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_role_idx` (`roleId`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `roleId`, `remember_token`, `created_at`, `updated_at`, `status`, `photo`) VALUES
(1, 'Goffredo Signori', 'admin@test.com', NULL, '$2y$10$vd9VFlvgQoa6nhSVgYkPZeo6W1yi0eOT1exCqwhVI5FLrIMI3pTCS', 1, NULL, '2019-12-02 18:08:41', '2019-12-02 18:08:41', 'active', '20200113142346.png'),
(2, 'Gastani Frinzi', 'teacher1@test.com', NULL, '$2y$10$wdRhCjB8/1xsVh3rqmDXW.XtfeYKQtlf2FzdEB..xBD8lhMEThWSS', 4, NULL, '2019-12-02 19:20:26', '2019-12-02 19:20:26', 'active', '20200113142536.jpg'),
(3, 'Sig. Rezzonico', 'parent1@test.com', NULL, '$2y$10$RivLv7d53MpgBwaEHLu6peHYWgwwitfHu3J3xcE4/95crlsQXIG26', 3, NULL, '2019-12-02 19:27:36', '2019-12-02 19:27:36', 'active', '20200113134753.jpg'),
(4, 'Marina Massironi', 'parent2@test.com', NULL, '$2y$10$hu28uMNO2soJPRpwBdin/.u6FYIg9LIDEaGqonBj/A7k0lNXCucCu', 3, NULL, '2019-12-02 19:32:22', '2019-12-02 19:32:22', 'active', '20200113142615.jpg'),
(5, 'Salvatore Giuffrida', 'sasagiuffrid@test.com', NULL, '$2y$10$Ir6XjaqqdDKbZ.btyt1ZiOy9t0oQt9tin4PipI1PnJv0UTp7/nz4e', 3, NULL, '2019-12-02 19:34:40', '2019-12-02 19:34:40', 'active', NULL),
(6, 'Agata Santa', 'agatasanta@test.com', NULL, '$2y$10$yygBBahMD0MlHabu2y2zlOWMQhdcd8Bt3umQf3DQrq4DgY.10XTEe', 3, NULL, '2019-12-02 19:34:42', '2019-12-02 19:34:42', 'active', NULL),
(7, 'Giorgio Pofillo', 'gpoliffo@test.com', NULL, '$2y$10$yY/dUxmlPCbHj.1BLr5C4ewQ4OkMlNJE3DpspnwSOoK.fVK5WrXQW', 3, NULL, '2019-12-02 19:36:55', '2019-12-02 19:36:55', 'active', NULL),
(8, 'Maria Mariana', 'mama@test.com', NULL, '$2y$10$6OZJU7bJU7BZ6uJot9W2Euyfkn6DSzIqwOK4xXjNlAbTlSxKuxoWO', 3, NULL, '2019-12-02 19:36:57', '2019-12-02 19:36:57', 'active', NULL),
(9, 'Rodolfo Turati', 'rodolfot@test.com', NULL, '$2y$10$fL.oKyoPjG7VKfqx58/rH.dplfioyMZppFD2oqFvj5hiAP036ksIq', 3, NULL, '2019-12-02 19:38:35', '2019-12-02 19:38:35', 'active', NULL),
(10, 'Yolanda Skov-Olsen', 'yolaskov@test.com', NULL, '$2y$10$iwNl6uiGB0pvrPbgIMrcMufAFyCa/OwoNyXeEbNNdyW2nCAmfdY5O', 3, NULL, '2019-12-02 19:38:37', '2019-12-02 19:38:37', 'active', NULL),
(11, 'Hubert Russo', 'hubertrusso@test.com', NULL, '$2y$10$C5swK4cmzBhtBwDq50Gouep1mtzsE5JV3aT5rKV0AyKthJOrF0AtC', 3, NULL, '2019-12-02 19:39:48', '2019-12-02 19:39:48', 'active', NULL),
(12, 'Rosalba DeGenastri', 'rosalbadege@test.com', NULL, '$2y$10$JOh5AH/N3RQSrnHr/gcbLuaZkdtZ08e3e6mzOEl1kcvVB9kxJiMUq', 3, NULL, '2019-12-02 19:39:50', '2019-12-02 19:39:50', 'active', NULL),
(13, 'Luis Barbosa', 'lbarbosa@test.com', NULL, '$2y$10$iih1bKRxcd6axcCaUUTrhutoFf0KCMnIEeITmc.b1pt2q0kCg0gVW', 3, NULL, '2019-12-02 19:41:09', '2019-12-02 19:41:09', 'active', NULL),
(14, 'Kayle Zapata', 'kzapata@test.com', NULL, '$2y$10$G0CdhlJfO9LdgwdgRhrSXeGieGK6uM2MDX9b9y2VXnCT7TOXNyH5.', 3, NULL, '2019-12-02 19:41:11', '2019-12-02 19:41:11', 'active', NULL),
(15, 'Marco Montalbano', 'mmont@test.com', NULL, '$2y$10$IS8Xs/aHjMqgH9LgwCG31Oq.XPRwAhiU5zCaCYzTRaF7PX0i3N2K.', 3, NULL, '2019-12-02 19:42:41', '2019-12-02 19:42:41', 'active', NULL),
(16, 'Georgina Rodriguez', 'grodriguez@test.com', NULL, '$2y$10$V21qQPWfguDpd3kmD.X1nOmhnL2LKP7oc9UK7Q7EWrepjBSCgHuD2', 3, NULL, '2019-12-02 19:42:43', '2019-12-02 19:42:43', 'active', NULL),
(17, 'Ignazio Neri', 'ignatius@test.com', NULL, '$2y$10$mVSLRuuHD/qyqMbK1hd4zeEzzeEpUpUFHOCU9nz1qOulRBp3JkLSC', 3, NULL, '2019-12-02 19:43:58', '2019-12-02 19:43:58', 'active', NULL),
(18, 'Concetta Lauricella', 'conci@test.com', NULL, '$2y$10$RqyIG6MZ2BUb5OTIXBpJRO2tNR2ouojmddL25qJQ2SITAILnSU29m', 3, NULL, '2019-12-02 19:44:00', '2019-12-02 19:44:00', 'active', NULL),
(19, 'Tereso Molise', 'tereso@test.com', NULL, '$2y$10$zw36xaFAfICqXMpGC0P6d.hz76IB9Jwp/4DabohGelEW.EYytGwn6', 3, NULL, '2019-12-02 19:46:43', '2019-12-02 19:46:43', 'active', NULL),
(20, 'Stefania Grigi', 'stefy@test.com', NULL, '$2y$10$oZcMPWuH5CxaV9WiijhaQeJhFq6cMbtl7X7FMo5zxq8Wns1J1VXaa', 3, NULL, '2019-12-02 19:46:45', '2019-12-02 19:46:45', 'active', NULL),
(21, 'James James', 'jj@test.com', NULL, '$2y$10$pILvPNAfJYZ527TqDBHQ6e19pF4QKmNYMMLLdSer1y0JPxel7l3MW', 3, NULL, '2019-12-02 19:48:33', '2019-12-02 19:48:33', 'active', NULL),
(22, 'Frida Fungo', 'fridafungo@test.com', NULL, '$2y$10$5HYwhxDItf7AGNfOJdM3E..k1oyOtiQ1JbMquMIZ.eaHgn2bKQDJe', 3, NULL, '2019-12-02 19:48:35', '2019-12-02 19:48:35', 'active', NULL),
(23, 'SysAdmin', 'sadmin@test.com', NULL, '$2y$10$9s6hkG1Cjde/5kjDoYMTZekc2jg064aeb0O6Ipt9LrMZCN31Qr9ta', 5, NULL, '2019-11-27 12:35:42', '2019-11-27 12:35:42', 'active', '20200113142719.jpg'),
(24, 'Aldo Baglio', 'teacher2@test.com', NULL, '$2y$10$yF6635CbXH2VuIoBwrZ1puzJxML3uH.FKA.Joz1rn3TtJ6ZU0i0T2', 2, NULL, '2019-12-02 20:56:23', '2019-12-02 20:56:23', 'active', '20200113142551.jpg'),
(25, 'Virginio Sciabica', 'teacher3@test.com', NULL, '$2y$10$wG/FmpDIgcljtKqiqMwFjOX0zSfPKzaeUmpZuElymorBMlC6Cl3/G', 2, NULL, '2019-12-02 21:00:42', '2019-12-02 21:00:42', 'active', NULL),
(26, 'Nino Frassica', 'teacher4@test.com', NULL, '$2y$10$E08VWonlWCnwXNIYFnxqZuaRZygLKWFvka4Cue0PKyQuUbb0iuEsC', 2, NULL, '2019-12-02 21:03:47', '2019-12-02 21:03:47', 'active', NULL),
(27, 'Pippo Franco', 'teacher5@test.com', NULL, '$2y$10$a9Pcsi12yHZR1d0cNJaKHuJpGLxMLYzmNVxfXF6n.dra.fxPXGAr6', 2, NULL, '2019-12-02 21:05:01', '2019-12-02 21:05:01', 'active', NULL),
(28, 'Mara Maionchi', 'teacher6@test.com', NULL, '$2y$10$TAOdnl21j06i/sKXNmBcuOHX49dnH45WiMCJ8ST9/LpPAQc6P7bTe', 2, NULL, '2019-12-02 21:06:39', '2019-12-02 21:06:39', 'active', NULL),
(29, 'Alberto Angelo', 'teacher7@test.com', NULL, '$2y$10$cVwJdCowlsu4lg7J9nqOMOUSv2Xze18kq2J//Zp9nW4apxyI6Kd2u', 2, NULL, '2019-12-02 21:08:16', '2019-12-02 21:08:16', 'active', NULL),
(30, 'Seymour Skinner', 'principal@test.com', NULL, '$2y$10$CsrAAwgQ.2JVOXAIudlp4uvMjzi8mtIZj9ZX4SC14fojg8aE2H4Pq', 6, NULL, '2020-01-13 11:39:42', '2020-01-13 11:39:42', 'active', '20200113133710.png');

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `final_grades`
--
ALTER TABLE `final_grades`
  ADD CONSTRAINT `student` FOREIGN KEY (`idStudent`) REFERENCES `student` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `subject` FOREIGN KEY (`idSubject`) REFERENCES `subjects` (`subjectId`) ON UPDATE CASCADE;

--
-- Limiti per la tabella `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `student_constraint` FOREIGN KEY (`idStudent`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `teacher_constraint` FOREIGN KEY (`idTeach`) REFERENCES `teacher` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `user_role` FOREIGN KEY (`roleId`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

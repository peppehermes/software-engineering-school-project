-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Creato il: Dic 02, 2019 alle 21:22
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
CREATE DATABASE school_db;

USE school_db;

-- --------------------------------------------------------

--
-- Struttura della tabella `assignments`
--

CREATE TABLE IF NOT EXISTS `assignments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(300) NOT NULL,
  `subject` varchar(45) NOT NULL,
  `topic` varchar(300) NOT NULL,
  `date` varchar(45) NOT NULL,
  `attachment` varchar(255),
  `idTeach` int(11) NOT NULL,
  `idClass` varchar(45) NOT NULL,
  `deadline` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `assignments`
--

INSERT INTO `assignments` (`id`, `text`, `subject`, `topic`, `date`, `attachment`,`idTeach`, `idClass`, `deadline`) VALUES
(1, 'Page 294, Ex. 1, 2 and 3.', 'Biology', 'Amphibians', '2019-12-2','20191203172240.pdf',1, '1A', '2019-12-9');

-- --------------------------------------------------------

--
-- Struttura della tabella `classroom`
--

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
-- Struttura della tabella `communications`
--

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
-- Struttura della tabella `lecturetopic`
--

CREATE TABLE IF NOT EXISTS `lecturetopic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idClass` varchar(45) NOT NULL,
  `idTeach` int(11) NOT NULL,
  `subject` varchar(45) NOT NULL,
  `date` varchar(45) NOT NULL,
  `topic` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `lecturetopic`
--

INSERT INTO `lecturetopic` (`id`, `idClass`, `idTeach`, `subject`, `date`, `topic`) VALUES
(1, '1A', 1, 'Biology', '2019-12-2', 'Amphibians'),
(2, '1B', 1, 'Biology', '2019-12-2', 'Amphibians and Reptiles');

-- --------------------------------------------------------

--
-- Struttura della tabella `marks`
--

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `marks`
--

INSERT INTO `marks` (`id`, `idClass`, `idTeach`, `idStudent`, `date`, `mark`, `subject`, `topic`) VALUES
(1, '1A', 1, 1, '2019-12-02', 8.5, 'Biology', 'Rhynos'),
(2, '1A', 1, 2, '2019-12-02', 6.25, 'Biology', 'Rhynos'),
(3, '1B', 1, 5, '2019-12-02', 2, 'Biology', 'Not Prepared');

-- --------------------------------------------------------

--
-- Struttura della tabella `migrations`
--

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `notes`
--

INSERT INTO `notes` (`id`, `idClass`, `idTeach`, `idStudent`, `subject`, `date`, `note`) VALUES
(1, '1A', 1, 1, 'Biology', '2019-12-02', 'The student takes a bottle and does unspeakable things.'),
(2, '1B', 1, 5, 'Biology', '2019-12-02', 'The student talks with his deskmate during the lecture'),
(3, '1A', 1, 1, 'Biology', '2019-12-02', 'The student keeps shouting to the teacher.');

-- --------------------------------------------------------

--
-- Struttura della tabella `password_resets`
--

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
  `description` varchar(500) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `classId` varchar(45) DEFAULT NULL,
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

INSERT INTO `student` (`id`, `firstName`, `lastName`, `birthday`, `address`, `phone`, `postCode`, `photo`, `gender`, `description`, `email`, `classId`, `birthPlace`, `fiscalCode`, `created_at`, `updated_at`, `mailParent1`, `mailParent2`) VALUES
(1, 'Giacomo', 'Poretti', '2006-04-26', 'Via Flanagan, 67', NULL, NULL, NULL, 'M', 'Very funny boy.', 'student1@test.com', '1A', 'Milano', NULL, '2019-12-02 19:26:51', '2019-12-02 19:26:51', 'parent1@test.com', 'parent2@test.com'),
(2, 'Simone', 'Giuffrida', '2006-10-18', NULL, NULL, NULL, NULL, 'M', 'A great mbare.', 'student2@test.com', '1A', 'Catania', NULL, '2019-12-02 19:33:47', '2019-12-02 19:33:47', 'sasagiuffrid@test.com', 'agatasanta@test.com'),
(3, 'Filippo', 'Pofilli', '2006-05-31', NULL, NULL, NULL, NULL, 'M', NULL, 'student3@test.com', '1A', 'Benevento', NULL, '2019-12-02 19:36:30', '2019-12-02 19:36:30', 'gpoliffo@test.com', 'mama@test.com'),
(4, 'Virginia', 'Turati', '2006-03-15', NULL, NULL, NULL, NULL, 'F', NULL, NULL, '1A', 'Torino', NULL, '2019-12-02 19:37:51', '2019-12-02 19:37:51', 'rodolfot@test.com', 'yolaskov@test.com'),
(5, 'Lorenzo', 'Russo', '2006-07-03', NULL, NULL, NULL, NULL, 'M', NULL, NULL, '1B', 'Catania', NULL, '2019-12-02 19:39:12', '2019-12-02 19:39:12', 'hubertrusso@test.com', 'rosalbadege@test.com'),
(6, 'Gabriel', 'Barbosa', '2006-07-02', NULL, NULL, NULL, NULL, 'M', NULL, NULL, '1B', 'Medellin', NULL, '2019-12-02 19:40:36', '2019-12-02 19:40:36', 'lbarbosa@test.com', 'kzapata@test.com'),
(7, 'Arturo', 'Montalbano', '2006-11-06', NULL, NULL, NULL, NULL, 'M', NULL, NULL, '1C', 'Agrigento', NULL, '2019-12-02 19:41:54', '2019-12-02 19:41:54', 'mmont@test.com', 'grodriguez@test.com'),
(8, 'Angelo', 'Neri', '2006-08-08', NULL, NULL, NULL, NULL, 'M', NULL, NULL, '1C', 'Bologna', NULL, '2019-12-02 19:43:24', '2019-12-02 19:43:24', 'ignatius@test.com', 'conci@test.com'),
(9, 'Giada', 'Bella', '2006-11-07', NULL, NULL, NULL, NULL, 'F', NULL, NULL, '1D', 'Torino', NULL, '2019-12-02 19:45:54', '2019-12-02 19:45:54', 'tereso@test.com', 'stefy@test.com'),
(10, 'LeBron', 'James', '2006-06-26', NULL, NULL, NULL, NULL, 'M', NULL, NULL, '1D', 'Ontario', NULL, '2019-12-02 19:48:12', '2019-12-02 19:48:12', 'jj@test.com', 'fridafungo@test.com'),
(11, 'Giovanni', 'Storti', '2006-02-20', NULL, NULL, NULL, NULL, 'M', NULL, 'student11@test.com', '1A', 'Milano', NULL, '2019-12-02 21:17:39', '2019-12-02 21:17:39', 'parent1@test.com', 'parent2@test.com');

-- --------------------------------------------------------

--
-- Struttura della tabella `student_attendance`
--

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
-- Struttura della tabella `suppmaterial`
--

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

CREATE TABLE IF NOT EXISTS `teaching` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idClass` varchar(45) NOT NULL,
  `idTeach` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

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
(11, '1A', 7, 'Gym');

-- --------------------------------------------------------

--
-- Struttura della tabella `timeslots`
--

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

CREATE TABLE IF NOT EXISTS `timetable` (
  `idClass` varchar(45) NOT NULL,
  `idTimeslot` int(11) NOT NULL,
  `idTeacher` int(11) NOT NULL,
  `subject` varchar(300) NOT NULL,
  UNIQUE KEY `lecture` (`idClass`,`idTimeslot`) USING BTREE
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
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `roleId`, `remember_token`, `created_at`, `updated_at`, `status`, `photo`) VALUES
(1, 'Goffredo Signori', 'admin@test.com', NULL, '$2y$10$vd9VFlvgQoa6nhSVgYkPZeo6W1yi0eOT1exCqwhVI5FLrIMI3pTCS', 1, NULL, '2019-12-02 18:08:41', '2019-12-02 18:08:41', 'active', NULL),
(2, 'Gastani Frinzi', 'teacher1@test.com', NULL, '$2y$10$wdRhCjB8/1xsVh3rqmDXW.XtfeYKQtlf2FzdEB..xBD8lhMEThWSS', 2, NULL, '2019-12-02 19:20:26', '2019-12-02 19:20:26', 'active', NULL),
(3, 'Sig. Rezzonico', 'parent1@test.com', NULL, '$2y$10$RivLv7d53MpgBwaEHLu6peHYWgwwitfHu3J3xcE4/95crlsQXIG26', 3, NULL, '2019-12-02 19:27:36', '2019-12-02 19:27:36', 'active', NULL),
(4, 'Marina Massironi', 'parent2@test.com', NULL, '$2y$10$hu28uMNO2soJPRpwBdin/.u6FYIg9LIDEaGqonBj/A7k0lNXCucCu', 3, NULL, '2019-12-02 19:32:22', '2019-12-02 19:32:22', 'active', NULL),
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
(23, 'SysAdmin', 'sadmin@test.com', NULL, '$2y$10$9s6hkG1Cjde/5kjDoYMTZekc2jg064aeb0O6Ipt9LrMZCN31Qr9ta', 5, NULL, '2019-11-27 12:35:42', '2019-11-27 12:35:42', 'active', NULL),
(24, 'Aldo Baglio', 'teacher2@test.com', NULL, '$2y$10$yF6635CbXH2VuIoBwrZ1puzJxML3uH.FKA.Joz1rn3TtJ6ZU0i0T2', 2, NULL, '2019-12-02 20:56:23', '2019-12-02 20:56:23', 'active', NULL),
(25, 'Virginio Sciabica', 'teacher3@test.com', NULL, '$2y$10$BXbqtQZNKjcHr3HGCtIf9.0i.Yq/4v9qNgB2g6S2SSawMI4ojB8xG', 2, NULL, '2019-12-02 21:00:42', '2019-12-02 21:00:42', 'active', NULL),
(26, 'Nino Frassica', 'teacher4@test.com', NULL, '$2y$10$E08VWonlWCnwXNIYFnxqZuaRZygLKWFvka4Cue0PKyQuUbb0iuEsC', 2, NULL, '2019-12-02 21:03:47', '2019-12-02 21:03:47', 'active', NULL),
(27, 'Pippo Franco', 'teacher5@test.com', NULL, '$2y$10$a9Pcsi12yHZR1d0cNJaKHuJpGLxMLYzmNVxfXF6n.dra.fxPXGAr6', 2, NULL, '2019-12-02 21:05:01', '2019-12-02 21:05:01', 'active', NULL),
(28, 'Mara Maionchi', 'teacher6@test.com', NULL, '$2y$10$TAOdnl21j06i/sKXNmBcuOHX49dnH45WiMCJ8ST9/LpPAQc6P7bTe', 2, NULL, '2019-12-02 21:06:39', '2019-12-02 21:06:39', 'active', NULL),
(29, 'Alberto Angelo', 'teacher7@test.com', NULL, '$2y$10$cVwJdCowlsu4lg7J9nqOMOUSv2Xze18kq2J//Zp9nW4apxyI6Kd2u', 2, NULL, '2019-12-02 21:08:16', '2019-12-02 21:08:16', 'active', NULL);

--
-- Limiti per le tabelle scaricate
--

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

-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Creato il: Nov 30, 2019 alle 23:05
-- Versione del server: 5.7.24
-- Versione PHP: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school_db2`
--

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
  `idTeach` int(11) NOT NULL,
  `idClass` varchar(45) NOT NULL,
  `deadline` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `assignments`
--

INSERT INTO `assignments` (`id`, `text`, `subject`, `topic`, `date`, `idTeach`, `idClass`, `deadline`) VALUES
(1, 'Exercise N. 1', 'Math', 'Expressions', '2019-11-25', 1, '1A', '2019-11-30');

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
('1A', 20, 'This class contains a LIM.', '2019-11-24 20:09:21', '2019-11-24 20:09:21'),
('2A', 20, 'none', '2019-11-25 15:05:49', '2019-11-25 15:05:49');

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `communications`
--

INSERT INTO `communications` (`id`, `idAdmin`, `description`, `date`) VALUES
(3, 1, 'All Students must die.', '2019-11-29 16:45:48'),
(4, 1, 'All Students must live eternally.', '2019-11-29 16:46:56'),
(5, 1, 'Let Me In.', '2019-11-29 16:50:33'),
(6, 1, 'Yowie-Wowie.', '2019-11-29 16:51:10'),
(7, 1, 'New Timetable', '2019-11-30 17:16:11'),
(8, 1, 'New Timetable', '2019-11-30 21:30:55'),
(9, 1, 'New Timetable', '2019-11-30 22:15:31'),
(10, 1, 'New Timetable', '2019-11-30 22:16:40'),
(11, 1, 'New Timetable', '2019-11-30 22:18:21'),
(12, 1, 'New Timetable', '2019-11-30 22:18:47');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `lecturetopic`
--

INSERT INTO `lecturetopic` (`id`, `idClass`, `idTeach`, `subject`, `date`, `topic`) VALUES
(1, '1A', 1, 'Math', '2019-11-25', 'Expressions');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `marks`
--

INSERT INTO `marks` (`id`, `idClass`, `idTeach`, `idStudent`, `date`, `mark`, `subject`, `topic`) VALUES
(1, '1A', 1, 1, '2019-11-25', 7, 'Math', 'Expressions');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `notes`
--

INSERT INTO `notes` (`id`, `idClass`, `idTeach`, `idStudent`, `subject`, `date`, `note`) VALUES
(1, '1A', 1, 1, 'Math', '2019-11-25', 'The student keeps on talking with her classmate despite of multiple recalls by the teacher.');

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
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `student`
--

INSERT INTO `student` (`id`, `firstName`, `lastName`, `birthday`, `address`, `phone`, `postCode`, `photo`, `gender`, `description`, `email`, `classId`, `birthPlace`, `fiscalCode`, `created_at`, `updated_at`, `mailParent1`, `mailParent2`) VALUES
(1, 'Sara', 'Silvio', '2007-02-21', 'Corso Degli duca Abruzzi,25', '3362718391', '10137', NULL, 'F', NULL, 'sara.silvio@test.com', '1A', 'Milan', 'SDTSHR92L44424Xd', '2019-11-24 20:21:05', '2019-11-24 20:21:05', 'parent1@test.com', 'parent2@test.com'),
(2, 'Francesco', 'Barbagallo', '2004-06-23', 'Via Garibaldi, 4', '123456789', '12345', NULL, 'M', NULL, 'giovannimosa@test.com', '2A', 'Acireale', 'ABCDEFGH', '2019-11-25 18:28:53', '2019-11-25 18:28:53', NULL, NULL);

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
(4, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `teacher`
--

INSERT INTO `teacher` (`id`, `firstName`, `lastName`, `birthday`, `userId`, `address`, `phone`, `postCode`, `photo`, `gender`, `description`, `birthPlace`, `fiscalCode`, `created_at`, `updated_at`) VALUES
(1, 'John', 'Alva', '1993-07-29', 2, 'Via Paolo Gaidano,103/22', '3364728191', '10137', '20191124201116.jpg', 'M', NULL, 'Turin', 'SDTSHLS2L21224Xd', '2019-11-24 20:11:16', '2019-11-24 20:11:16'),
(2, 'Glori', 'Bianca', '1983-06-29', 5, 'Corso Giovanni Agnelli, 117', '3362718492', '10134', '20191124203933.jpg', 'F', NULL, 'Turin', 'SDTSHR92KS1Z224X', '2019-11-24 20:39:33', '2019-11-24 20:39:33'),
(3, 'Mattia', 'Merlin', '1997-06-10', 13, 'Corso Cosenza,34', '3362718271', '10135', NULL, 'M', NULL, 'Milan', 'SDTSHR84KS1Z224X', '2019-11-30 13:57:28', '2019-11-30 13:57:28'),
(4, 'Laura', 'Capra', '1993-07-15', 14, 'Via Po,15', '3362719361', '10127', NULL, 'F', NULL, 'Turin', NULL, '2019-11-30 15:08:50', '2019-11-30 15:08:50'),
(5, 'Riccardo', 'Renari', '1993-03-24', 15, 'Corso Orbassano,9', '3362718193', NULL, NULL, 'M', NULL, 'Rome', NULL, '2019-11-30 15:20:41', '2019-11-30 15:20:41'),
(6, 'Alessandra', 'Pavanello', '1983-07-27', 16, 'Corso Degli duca Abruzzi,8', '3362718392', NULL, NULL, 'F', NULL, 'Turin', NULL, '2019-11-30 15:23:34', '2019-11-30 15:23:34'),
(7, 'Claudia', 'Bollero', '1986-08-21', 17, 'Via Lagrange, 9', '3362718391', NULL, NULL, 'F', NULL, 'Turin', NULL, '2019-11-30 15:26:04', '2019-11-30 15:26:04'),
(8, 'Mattia', 'Picca', '1994-08-05', 18, 'Via Principe Amadeo', '3362718492', NULL, NULL, 'M', NULL, 'Cuneo', NULL, '2019-11-30 17:01:13', '2019-11-30 17:01:13'),
(9, 'test', 'test', NULL, 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-11-30 22:54:21', '2019-11-30 22:54:21');

-- --------------------------------------------------------

--
-- Struttura della tabella `teaching`
--

DROP TABLE IF EXISTS `teaching`;
CREATE TABLE IF NOT EXISTS `teaching` (
  `idClass` varchar(45) NOT NULL,
  `idTeach` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  PRIMARY KEY (`idClass`,`idTeach`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `teaching`
--

INSERT INTO `teaching` (`idClass`, `idTeach`, `subject`) VALUES
('1A', 1, 'Math'),
('1A', 2, 'Art'),
('1A', 4, 'English'),
('2A', 1, 'Physics'),
('2A', 3, 'History'),
('2A', 4, 'Italian'),
('2A', 5, 'Latin'),
('2A', 6, 'Religion'),
('2A', 7, 'Gym'),
('2A', 8, 'Science'),
('2A', 9, 'Computer');

-- --------------------------------------------------------

--
-- Struttura della tabella `timeslots`
--

DROP TABLE IF EXISTS `timeslots`;
CREATE TABLE IF NOT EXISTS `timeslots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hour` varchar(300) NOT NULL,
  `day` varchar(300) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `timeslot_index` (`hour`,`day`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `timeslots`
--

INSERT INTO `timeslots` (`id`, `hour`, `day`) VALUES
(27, '10:00', 'Friday'),
(3, '10:00', 'Monday'),
(21, '10:00', 'Thursday'),
(9, '10:00', 'Tuesday'),
(15, '10:00', 'Wednesday'),
(28, '11:00', 'Friday'),
(4, '11:00', 'Monday'),
(22, '11:00', 'Thursday'),
(10, '11:00', 'Tuesday'),
(16, '11:00', 'Wednesday'),
(29, '12:00', 'Friday'),
(5, '12:00', 'Monday'),
(23, '12:00', 'Thursday'),
(11, '12:00', 'Tuesday'),
(17, '12:00', 'Wednesday'),
(30, '13:00', 'Friday'),
(6, '13:00', 'Monday'),
(24, '13:00', 'Thursday'),
(12, '13:00', 'Tuesday'),
(18, '13:00', 'Wednesday'),
(25, '8:00', 'Friday'),
(1, '8:00', 'Monday'),
(19, '8:00', 'Thursday'),
(7, '8:00', 'Tuesday'),
(13, '8:00', 'Wednesday'),
(26, '9:00', 'Friday'),
(2, '9:00', 'Monday'),
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
  UNIQUE KEY `lecture` (`idClass`,`idTimeslot`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `timetable`
--

INSERT INTO `timetable` (`idClass`, `idTimeslot`, `idTeacher`, `subject`) VALUES
('1A', 1, 1, 'Math'),
('1A', 2, 4, 'Italian'),
('1A', 3, 2, 'Art'),
('1A', 4, 5, 'Latin'),
('1A', 5, 5, 'Latin'),
('1A', 6, 0, ''),
('1A', 7, 3, 'History'),
('1A', 8, 4, 'Italian'),
('1A', 9, 4, 'English'),
('1A', 10, 7, 'Gym'),
('1A', 11, 1, 'Math'),
('1A', 12, 1, 'Physics'),
('1A', 13, 4, 'Italian'),
('1A', 14, 4, 'Italian'),
('1A', 15, 4, 'English'),
('1A', 16, 8, 'Science'),
('1A', 17, 5, 'Latin'),
('1A', 18, 0, ''),
('1A', 19, 4, 'English'),
('1A', 20, 3, 'History'),
('1A', 21, 1, 'Math'),
('1A', 22, 1, 'Math'),
('1A', 23, 6, 'Religion'),
('1A', 24, 0, ''),
('1A', 25, 1, 'Physics'),
('1A', 26, 7, 'Gym'),
('1A', 27, 5, 'Latin'),
('1A', 28, 8, 'Science'),
('1A', 29, 1, 'Math'),
('1A', 30, 2, 'Art'),
('2A', 1, 1, 'Math'),
('2A', 2, 4, 'Italian'),
('2A', 3, 2, 'Art'),
('2A', 4, 5, 'Latin'),
('2A', 5, 5, 'Latin'),
('2A', 6, 0, ''),
('2A', 7, 3, 'History'),
('2A', 8, 4, 'Italian'),
('2A', 9, 4, 'English'),
('2A', 10, 7, 'Gym'),
('2A', 11, 1, 'Math'),
('2A', 12, 1, 'Physics'),
('2A', 13, 4, 'Italian'),
('2A', 14, 4, 'Italian'),
('2A', 15, 4, 'English'),
('2A', 16, 8, 'Science'),
('2A', 17, 5, 'Latin'),
('2A', 18, 0, ''),
('2A', 19, 4, 'English'),
('2A', 20, 3, 'History'),
('2A', 21, 1, 'Math'),
('2A', 22, 1, 'Math'),
('2A', 23, 6, 'Religion'),
('2A', 24, 0, ''),
('2A', 25, 1, 'Physics'),
('2A', 26, 7, 'Gym'),
('2A', 27, 5, 'Latin'),
('2A', 28, 8, 'Science'),
('2A', 29, 1, 'Math'),
('2A', 30, 2, 'Art');

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roleId` int(11) NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('active','deactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `photo` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_role_idx` (`roleId`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `roleId`, `remember_token`, `created_at`, `updated_at`, `status`, `photo`) VALUES
(1, 'Admin', 'admin@test.com', NULL, '$2y$10$3QCuQiTo1EULmEHmQzR0quelwceD.IuAghfLp94vMJ9eZarS2j/iC', 1, NULL, '2019-11-14 12:31:10', '2019-11-14 12:31:10', 'active', NULL),
(2, 'John Alva', 'john.alva@test.com', NULL, '$2y$10$3QCuQiTo1EULmEHmQzR0quelwceD.IuAghfLp94vMJ9eZarS2j/iC', 2, NULL, '2019-11-24 20:10:33', '2019-11-24 20:10:33', 'active', NULL),
(4, 'Daniele Silvio', 'daniele.silvio@test.com', NULL, '$2y$10$jorrMyHebqOtjrPa0jMF4e5MaDbR8I7Wf0on.neie4FduGY1IvQQm', 3, NULL, '2019-11-24 20:25:29', '2019-11-24 20:25:29', 'active', NULL),
(5, 'Kate Alba', 'kate.alba@test.com', NULL, '$2y$10$wryKF.e1bUEMbizD3byW9.lAK.HuEnJSiNf9QClIJ8/mtWjHIFi16', 3, NULL, '2019-11-24 20:25:31', '2019-11-24 20:25:31', 'active', NULL),
(8, 'Glori Bianca', 'glori.bianca@test.com', NULL, '$2y$10$lfr0bU6xCwy4d5/miAGcPebHflOl51gqFu5fC9ral6A.dN3HNn2US', 2, NULL, '2019-11-24 20:39:33', '2019-11-24 20:39:33', 'active', NULL),
(9, 'Elia Luca', 'elia.luca@test.com', NULL, '$2y$10$upjYe/X9cTfi1gQQ0JgxGuHaMaqdb.p8j6Vz3F9xkPRWG4IBeRj42', 2, NULL, '2019-11-25 19:47:34', '2019-11-25 19:47:34', 'active', NULL),
(10, 'Michele Grassi', 'michele.grassi@test.com', NULL, '$2y$10$YVzdSlTxJWnGoKbSXiALneSsExSBH6.gO2ZGYXjIuerh.9o20cYi2', 3, NULL, '2019-11-25 19:48:53', '2019-11-25 19:48:53', 'active', '20191125214500.jpg'),
(12, 'Super Admin', 'super.admin@test.com', NULL, '$2y$10$3QCuQiTo1EULmEHmQzR0quelwceD.IuAghfLp94vMJ9eZarS2j/iC', 5, NULL, '2019-11-26 16:05:35', '2019-11-26 16:05:35', 'active', NULL),
(13, 'Mattia Merlin', 'mattia.merlin@test.com', NULL, '$2y$10$P3tOVPBk8vWLXU2mndgqueNaOT5SpUKCg/F5OIry68Mm51Z8elCA.', 2, NULL, '2019-11-30 13:57:28', '2019-11-30 13:57:28', 'active', NULL),
(14, 'Laura Capra', 'laura.capra@test.com', NULL, '$2y$10$dUBMGLq5MBZUlJxWxgCrE.MwUZw7by0gUXkANqgJnTMXOicw9UNCm', 2, NULL, '2019-11-30 15:08:50', '2019-11-30 15:08:50', 'active', NULL),
(15, 'Riccardo Renari', 'riccardo.renari@test.com', NULL, '$2y$10$ONE1JZWNWPdgFbe9r4fDUeMTZ1CalZG25e7OglqOmcjzXLTXNqTPu', 2, NULL, '2019-11-30 15:20:41', '2019-11-30 15:20:41', 'active', NULL),
(16, 'Alessandra Pavanello', 'alessandra.pavanello@test.com', NULL, '$2y$10$ae8zuGiks/MtCPm0tAVcQuaPND00U02oMb1c5IAd.3c8cQHa0vNk2', 2, NULL, '2019-11-30 15:23:34', '2019-11-30 15:23:34', 'active', NULL),
(17, 'Claudia Bollero', 'Claudia.bollero@test.com', NULL, '$2y$10$k7dkXKU6Xd5QMjonsIlgOO3gTyUm9Lgys.zpMy8lek2Kp.d8d2JpS', 2, NULL, '2019-11-30 15:26:04', '2019-11-30 15:26:04', 'active', NULL),
(18, 'Mattia Picca', 'Mattia.picca@test.com', NULL, '$2y$10$VLYUsJcGRbAOUjqacZCweOZI0xzOV5t5bcZOdI6dFbFWREqn/dBKu', 2, NULL, '2019-11-30 17:01:13', '2019-11-30 17:01:13', 'active', NULL),
(19, 'test test', 'test2@test.com', NULL, '$2y$10$p8r35mjRaEbbMDxd406NheR5R22FwvT4/sd2RdQ4/MGB.7y.NuaES', 2, NULL, '2019-11-30 22:54:21', '2019-11-30 22:54:21', 'active', NULL);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `user_role` FOREIGN KEY (`roleId`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

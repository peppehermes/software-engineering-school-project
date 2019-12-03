-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Creato il: Nov 30, 2019 alle 18:09
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
-- Database: `school`
--

-- --------------------------------------------------------

DROP DATABASE IF EXISTS school_db;
DROP DATABASE IF EXISTS schooldb;
CREATE DATABASE school_db;

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

INSERT INTO `assignments` (`id`, `text`, `subject`, `topic`, `date`,`attachment`, `idTeach`, `idClass`, `deadline`) VALUES
(1, 'Exercise N. 1', 'Math', 'Expressions', '2019-11-25',NULL, 1, '1A', '2019-11-30');

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
('1A', 20, 'This class contains a LIM.', '2019-11-24 20:09:21', '2019-11-24 20:09:21'),
('2A', 20, 'none', '2019-11-25 15:05:49', '2019-11-25 15:05:49');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `communications`
--

INSERT INTO `communications` (`id`, `idAdmin`, `description`, `date`) VALUES
(3, 1, 'All Students must die.', '2019-11-29 16:45:48'),
(4, 1, 'All Students must live eternally.', '2019-11-29 16:46:56'),
(5, 1, 'Let Me In.', '2019-11-29 16:50:33'),
(6, 1, 'Yowie-Wowie.', '2019-11-29 16:51:10');

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
(4, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `teacher`
--

INSERT INTO `teacher` (`id`, `firstName`, `lastName`, `birthday`, `userId`, `address`, `phone`, `postCode`, `photo`, `gender`, `description`, `birthPlace`, `fiscalCode`, `created_at`, `updated_at`) VALUES
(1, 'John', 'Alva', '1993-07-29', 2, 'Via Paolo Gaidano,103/22', '3364728191', '10137', '20191124201116.jpg', 'M', NULL, 'Turin', 'SDTSHLS2L21224Xd', '2019-11-24 20:11:16', '2019-11-24 20:11:16'),
(2, 'Glori', 'Bianca', '1983-06-29', 5, 'Corso Giovanni Agnelli, 117', '3362718492', '10134', '20191124203933.jpg', 'F', NULL, 'Turin', 'SDTSHR92KS1Z224X', '2019-11-24 20:39:33', '2019-11-24 20:39:33');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `teaching`
--

INSERT INTO `teaching` (`id`, `idClass`, `idTeach`, `subject`) VALUES
(1, '1A', 1, 'Math'),
(2, '1A', 2, 'Art'),
(3, '2A', 1, 'Physics');

-- --------------------------------------------------------

--
-- Struttura della tabella `timeslots`
--

CREATE TABLE IF NOT EXISTS `timeslots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hour` varchar(300) NOT NULL,
  `day` varchar(300) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `roleId`, `remember_token`, `created_at`, `updated_at`, `status`, `photo`) VALUES
(1, 'Admin', 'admin@test.com', NULL, '$2y$10$3QCuQiTo1EULmEHmQzR0quelwceD.IuAghfLp94vMJ9eZarS2j/iC', 1, NULL, '2019-11-14 12:31:10', '2019-11-14 12:31:10', 'active', NULL),
(2, 'John Alva', 'teacher1@test.com', NULL, '$2y$10$LiGIGkYQYt9R7vxS/FtfAOeSJzpfDkQWEKSoHWHSTFT1C.DWm98VO', 2, NULL, '2019-11-24 20:10:33', '2019-11-24 20:10:33', 'active', NULL),
(3, 'Daniele Silvio', 'parent1@test.com', NULL, '$2y$10$26DjY58oBtQXwljEE/jD1.b7oJW7lMFB02uidI5L6Pt1adjYjKP.C', 3, NULL, '2019-11-24 20:25:29', '2019-11-24 20:25:29', 'active', NULL),
(4, 'Kate Alba', 'parent2@test.com', NULL, '$2y$10$Z3KodCOh3mfc/xJAkqcQ.uBGuku3mHT8zVa83kYSlH2wmqnJeBqBi', 3, NULL, '2019-11-24 20:25:31', '2019-11-24 20:25:31', 'active', NULL),
(5, 'Glori Bianca', 'teacher2@test.com', NULL, '$2y$10$/2mLmszFz9h/FbwdU/Wrf.zPdZRQpXz.wm/3Gw47pj3PgRWMjuLde', 2, NULL, '2019-11-24 20:39:33', '2019-11-24 20:39:33', 'active', NULL),
(6, 'SysAdmin', 'sadmin@test.com', NULL, '$2y$10$9s6hkG1Cjde/5kjDoYMTZekc2jg064aeb0O6Ipt9LrMZCN31Qr9ta', 5, NULL, '2019-11-27 13:35:42', '2019-11-27 13:35:42', 'active', NULL);

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

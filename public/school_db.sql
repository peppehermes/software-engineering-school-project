-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Creato il: Nov 13, 2019 alle 15:14
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

--
-- Struttura della tabella `classroom`
--

DROP TABLE IF EXISTS `classroom`;
CREATE TABLE IF NOT EXISTS `classroom` (
  `id` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `capacity` int(20) DEFAULT NULL,
  `description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `classroom`
--

INSERT INTO `classroom` (`id`, `capacity`, `description`, `created_at`, `updated_at`) VALUES
('11A', 30, 'This class has a video projector', '2019-11-07 16:53:15', '2019-11-07 16:53:15'),
('30B', 25, 'This class has 2 black boards', '2019-11-07 16:53:15', '2019-11-07 16:53:15');

-- --------------------------------------------------------

--
-- Struttura della tabella `lecturetopic`
--

DROP TABLE IF EXISTS `lecturetopic`;
CREATE TABLE IF NOT EXISTS `lecturetopic` (
  `idClass` varchar(45) NOT NULL,
  `idTeach` int(11) NOT NULL,
  `subject` int(11) NOT NULL,
  `date` date NOT NULL,
  `topic` varchar(300) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf32;

-- --------------------------------------------------------

--
-- Struttura della tabella `marks`
--

DROP TABLE IF EXISTS `marks`;
CREATE TABLE IF NOT EXISTS `marks` (
  `idClass` varchar(45) NOT NULL,
  `idTeach` int(11) NOT NULL,
  `idStudent` int(11) NOT NULL,
  `date` date NOT NULL,
  `mark` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `topic` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf32;

--
-- Dump dei dati per la tabella `marks`
--

INSERT INTO `marks` (`idClass`, `idTeach`, `idStudent`, `date`, `mark`, `subject`, `topic`) VALUES
('11A', 1, 1, '2019-11-11', 9, 'Math', 'Functions and Asymptotes');

-- --------------------------------------------------------

--
-- Struttura della tabella `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'Admin'),
(2, 'Teacher'),
(3, 'Parent'),
(4, 'Class Coordinator');

-- --------------------------------------------------------

--
-- Struttura della tabella `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastName` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthday` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postCode` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` enum('F','M') COLLATE utf8_unicode_ci DEFAULT 'M',
  `description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `classId` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `mailParent1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mailParent2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ClassId_idx` (`classId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `student`
--

INSERT INTO `student` (`id`, `firstName`, `lastName`, `birthday`, `address`, `phone`, `postCode`, `photo`, `gender`, `description`, `email`, `classId`, `created_at`, `updated_at`, `mailParent1`, `mailParent2`) VALUES
(1, 'Matteo', 'Fresco', NULL, NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, '2019-11-12 11:53:28', '2019-11-12 11:53:28', 'calogerofresco@gmail.com', ''),
(2, 'Marco', 'Fresco', NULL, NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, '2019-11-12 11:56:29', '2019-11-12 11:56:29', 'calogerofresco@gmail.com', '');

-- --------------------------------------------------------

--
-- Struttura della tabella `studforparent`
--

DROP TABLE IF EXISTS `studforparent`;
CREATE TABLE IF NOT EXISTS `studforparent` (
  `idParent` int(11) NOT NULL,
  `idStudent` int(11) NOT NULL,
  PRIMARY KEY (`idParent`,`idStudent`)
) ENGINE=MyISAM DEFAULT CHARSET=utf32;

--
-- Dump dei dati per la tabella `studforparent`
--

INSERT INTO `studforparent` (`idParent`, `idStudent`) VALUES
(2, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `teacher`
--

DROP TABLE IF EXISTS `teacher`;
CREATE TABLE IF NOT EXISTS `teacher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastName` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthday` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `userId` bigint(20) DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postCode` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` enum('M','F') COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `teacher`
--

INSERT INTO `teacher` (`id`, `firstName`, `lastName`, `birthday`, `userId`, `address`, `phone`, `postCode`, `photo`, `gender`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Cristina', 'Cassaro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-11-13 14:22:45', '2019-11-13 14:22:45');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf32;

--
-- Dump dei dati per la tabella `teaching`
--

INSERT INTO `teaching` (`idClass`, `idTeach`, `subject`) VALUES
('11A', 1, 'Math');

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roleId` int(11) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('active','deactive') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  PRIMARY KEY (`id`),
  KEY `user_role_idx` (`roleId`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `roleId`, `remember_token`, `created_at`, `updated_at`, `status`) VALUES
(1, 'Matteo', 'mfresco@gmail.com', NULL, '$2y$10$TQtWmTA0jkMlUiDSM8m2Ou2LxHATUd./koA6yTUNhxD9Sxf8r3ZyW', 1, NULL, '2019-11-12 10:41:22', '2019-11-12 10:41:22', 'active'),
(2, 'Calogero', 'calogerofresco@gmail.com', NULL, '$2y$10$75Dsm3E3wRQGGtqNm9eMquohGUFx5e1fi9Rck7VqTqiA4AcGVmB0m', 3, NULL, '2019-11-12 11:58:45', '2019-11-12 11:58:45', 'active');

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

CREATE TABLE `password_resets` (
  `email` VARCHAR(45) NOT NULL,
  `token` VARCHAR(255) NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`email`));


ALTER TABLE student`
ADD COLUMN `birthPlace` VARCHAR(45) NULL AFTER `classId`,
ADD COLUMN `fiscalCode` VARCHAR(45) NULL AFTER `birthPlace`;

ALTER TABLE `teacher`
ADD COLUMN `birthPlace` VARCHAR(45) NULL AFTER `description`,
ADD COLUMN `fiscalCode` VARCHAR(45) NULL AFTER `birthPlace`;

ALTER TABLE `users`
ADD COLUMN `photo` VARCHAR(45) NULL AFTER `status`;



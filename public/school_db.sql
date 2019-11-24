-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Creato il: Nov 24, 2019 alle 20:40
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
('1A', 20, 'This class is so big.', '2019-11-24 20:09:21', '2019-11-24 20:09:21');

-- --------------------------------------------------------

--
-- Struttura della tabella `lecturetopic`
--

DROP TABLE IF EXISTS `lecturetopic`;
CREATE TABLE IF NOT EXISTS `lecturetopic` (
                                              `id` int(11) NOT NULL AUTO_INCREMENT,
                                              `idClass` varchar(45) CHARACTER SET utf32 NOT NULL,
                                              `idTeach` int(11) NOT NULL,
                                              `subject` varchar(45) CHARACTER SET utf32 NOT NULL,
                                              `date` varchar(45) CHARACTER SET utf32 NOT NULL,
                                              `topic` varchar(300) CHARACTER SET utf32 NOT NULL,
                                              PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `marks`
--

DROP TABLE IF EXISTS `marks`;
CREATE TABLE IF NOT EXISTS `marks` (
                                       `idClass` varchar(45) CHARACTER SET utf32 NOT NULL,
                                       `idTeach` int(11) NOT NULL,
                                       `idStudent` int(11) NOT NULL,
                                       `date` date NOT NULL,
                                       `mark` int(11) NOT NULL,
                                       `subject` varchar(255) CHARACTER SET utf32 NOT NULL,
                                       `topic` varchar(255) CHARACTER SET utf32 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
-- Struttura della tabella `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
                                                 `email` varchar(45) CHARACTER SET latin1 NOT NULL,
                                                 `token` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
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
(4, 'Class Coordinator');

-- --------------------------------------------------------

--
-- Struttura della tabella `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
                                         `id` int(11) NOT NULL AUTO_INCREMENT,
                                         `firstName` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                                         `lastName` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                                         `birthday` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                                         `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                                         `phone` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                                         `postCode` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                                         `photo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                                         `gender` enum('F','M') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT 'M',
                                         `description` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                                         `email` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                                         `classId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                                         `birthPlace` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                                         `fiscalCode` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                                         `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                                         `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                                         `mailParent1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                                         `mailParent2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                                         PRIMARY KEY (`id`),
                                         KEY `fk_ClassId_idx` (`classId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `student`
--

INSERT INTO `student` (`id`, `firstName`, `lastName`, `birthday`, `address`, `phone`, `postCode`, `photo`, `gender`, `description`, `email`, `classId`, `birthPlace`, `fiscalCode`, `created_at`, `updated_at`, `mailParent1`, `mailParent2`) VALUES
(1, 'Sara', 'Silvio', '2007-02-21', 'Corso Degli duca Abruzzi,25', '3362718391', '10137', NULL, 'F', NULL, 'sara.silvio@test.com', '1A', 'Milan', 'SDTSHR92L44424Xd', '2019-11-24 20:21:05', '2019-11-24 20:21:05', 'daniele.silvio@test.com', 'kate.alba@test.com');

-- --------------------------------------------------------

--
-- Struttura della tabella `student_attendance`
--

DROP TABLE IF EXISTS `student_attendance`;
CREATE TABLE IF NOT EXISTS `student_attendance` (
                                                    `studentId` int(11) NOT NULL,
                                                    `teacherId` int(11) NOT NULL,
                                                    `classId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                                                    `lectureDate` date NOT NULL,
                                                    `status` enum('present','absent') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'present',
                                                    `presence_status` enum('full','early','late') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'full',
                                                    `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
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
(4, 1),
(5, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `suppmaterial`
--

DROP TABLE IF EXISTS `suppmaterial`;
CREATE TABLE IF NOT EXISTS `suppmaterial` (
                                              `id` int(11) NOT NULL AUTO_INCREMENT,
                                              `idClass` varchar(45) CHARACTER SET latin1 NOT NULL,
                                              `idTeach` int(11) NOT NULL,
                                              `subject` varchar(45) CHARACTER SET latin1 NOT NULL,
                                              `material` varchar(255) CHARACTER SET latin1 NOT NULL,
                                              `date` varchar(45) CHARACTER SET latin1 NOT NULL,
                                              `mdescription` varchar(255) CHARACTER SET latin1 NOT NULL,
                                              PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `teacher`
--

DROP TABLE IF EXISTS `teacher`;
CREATE TABLE IF NOT EXISTS `teacher` (
                                         `id` int(11) NOT NULL AUTO_INCREMENT,
                                         `firstName` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                                         `lastName` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                                         `birthday` date DEFAULT NULL,
                                         `userId` bigint(20) DEFAULT NULL,
                                         `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                                         `phone` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                                         `postCode` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                                         `photo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                                         `gender` enum('M','F') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                                         `description` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                                         `birthPlace` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                                         `fiscalCode` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                                         `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                                         `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                                         PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `teacher`
--

INSERT INTO `teacher` (`id`, `firstName`, `lastName`, `birthday`, `userId`, `address`, `phone`, `postCode`, `photo`, `gender`, `description`, `birthPlace`, `fiscalCode`, `created_at`, `updated_at`) VALUES
(1, 'John', 'Alva', '1993-07-29', 2, 'Via Paolo Gaidano,103/22', '3364728191', '10137', '20191124201116.jpg', 'M', NULL, 'Turin', 'SDTSHLS2L21224Xd', '2019-11-24 20:11:16', '2019-11-24 20:11:16'),
(3, 'Glori', 'Bianca', '1983-06-29', 8, 'Corso Giovanni Agnelli, 117', '3362718492', '10134', '20191124203933.jpg', 'F', NULL, 'Turin', 'SDTSHR92KS1Z224X', '2019-11-24 20:39:33', '2019-11-24 20:39:33');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `teaching`
--

INSERT INTO `teaching` (`idClass`, `idTeach`, `subject`) VALUES
('1A', 1, 'Math'),
('1A', 2, 'fgsdfg'),
('1A', 3, 'Art');

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `roleId`, `remember_token`, `created_at`, `updated_at`, `status`, `photo`) VALUES
(1, 'Admin', 'admin@test.com', NULL, '$2y$10$3QCuQiTo1EULmEHmQzR0quelwceD.IuAghfLp94vMJ9eZarS2j/iC', 1, NULL, '2019-11-14 12:31:10', '2019-11-14 12:31:10', 'active', NULL),
(2, 'John Alva', 'john.alva@test.com', NULL, '$2y$10$a7c5xuwL72GZ/GtpBaaQWO.HQ9rcZUXZIOBgfsstTGT0EnQoFIMKu', 2, NULL, '2019-11-24 20:10:33', '2019-11-24 20:10:33', 'active', NULL),
(4, 'Daniele Silvio', 'daniele.silvio@test.com', NULL, '$2y$10$jorrMyHebqOtjrPa0jMF4e5MaDbR8I7Wf0on.neie4FduGY1IvQQm', 3, NULL, '2019-11-24 20:25:29', '2019-11-24 20:25:29', 'active', NULL),
(5, 'Kate Alba', 'kate.alba@test.com', NULL, '$2y$10$wryKF.e1bUEMbizD3byW9.lAK.HuEnJSiNf9QClIJ8/mtWjHIFi16', 3, NULL, '2019-11-24 20:25:31', '2019-11-24 20:25:31', 'active', NULL),
(8, 'Glori Bianca', 'glori.bianca@test.com', NULL, '$2y$10$lfr0bU6xCwy4d5/miAGcPebHflOl51gqFu5fC9ral6A.dN3HNn2US', 2, NULL, '2019-11-24 20:39:33', '2019-11-24 20:39:33', 'active', NULL);

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

-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Creato il: Nov 11, 2019 alle 15:14
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
-- Database: `school_db`
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
  PRIMARY KEY (`id`),
  KEY `fk_ClassId_idx` (`classId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `student`
--

INSERT INTO `student` (`id`, `firstName`, `lastName`, `birthday`, `address`, `phone`, `postCode`, `photo`, `gender`, `description`, `email`, `classId`, `created_at`, `updated_at`) VALUES
(2, 'test', 'test', '2011-10-12', 'Via Paolo Gaidano,103/22, Scala C, Turrisi', '3393420967', '10137', '20191111095357.jpg', 'M', 'desc', 'test1@gmail.com', '11A', '2019-11-09 09:42:30', '2019-11-09 09:42:30'),
(3, 'Sahar4', 'Saadatmandi', '2011-9-12', 'Via Paolo Gaidano,103/22, Scala C, Turrisi', '3393420967', '10137', '20191109095141.jpg', 'M', 'fffffff', 'sahar.saadatmandii4@gmail.com', '30B', '2019-11-09 09:51:41', '2019-11-09 09:51:41'),
(4, 'Sahar444', 'Saadatmandi', '2011-9-12', 'Via Paolo Gaidano,103/22, Scala C, Turrisi', '3393420967', '10137', '20191109095959.jpg', 'M', 'fffffff', 'sahar.saadatmandii4@gmail.com', '30B', '2019-11-09 09:59:59', '2019-11-09 09:59:59');

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
(1, 'teacher1', 't1', '2013-8-9', NULL, 'Via Paolo Gaidano,103/22, Scala C,', '3393420967', '10137', '20191109112811.jpg', 'M', 'dddddd', '2019-11-09 11:28:11', '2019-11-09 11:28:11'),
(2, 'teacher 2', 't', '1972-10-16', NULL, 'asd', '3393420967', '10137', '20191111102613.jpg', 'F', 'adsda', '2019-11-11 10:26:13', '2019-11-11 10:26:13'),
(3, 'aa', 'aaa', '--', NULL, 'aaaa', '3393420967', '10137', NULL, 'M', 'fsdfsf', '2019-11-11 11:38:57', '2019-11-11 11:38:57'),
(4, 'aa', 'aaa', '--', 3, 'aaaa', '3393420967', '10137', NULL, 'M', 'fsdfsf', '2019-11-11 11:39:21', '2019-11-11 11:39:21'),
(5, 'aa', 'aaa', '--', 4, 'aaaa', '3393420967', '10137', NULL, 'M', 'fsdfsf', '2019-11-11 11:39:35', '2019-11-11 11:39:35'),
(6, 't3', 'teacher', '--', 8, 'Via Paolo Gaidano,103/22, Scala C, Turrisi', '3393420967', '10137', NULL, NULL, NULL, '2019-11-11 11:42:17', '2019-11-11 11:42:17'),
(7, 't3', 'teacher', '--', 9, 'Via Paolo Gaidano,103/22, Scala C, Turrisi', '3393420967', '10137', '20191111143957.jpg', 'F', NULL, '2019-11-11 11:42:42', '2019-11-11 11:42:42');

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `roleId`, `remember_token`, `created_at`, `updated_at`, `status`) VALUES
(1, 'Sahar Saadatmandi', 'sahar.saadatmandii@gmail.com', NULL, '$2y$10$68E0r8pHxdu.h3od87Q1WuSwgcQfPZEr5wluNRQFK6bbne8JyMpzW', 1, NULL, '2019-11-06 08:58:02', '2019-11-06 08:58:02', 'active'),
(3, 'teacher1', 'teacher1@mail.com', NULL, '$2y$10$EUf/4B.uDtLpTGoQ0FfcVOxB/pO6H6UQPX2qIe99lBfaNfXlx4uNG', 2, NULL, '2019-11-11 09:52:20', '2019-11-11 09:52:20', 'active'),
(4, 'teacher 2 t', 'teacher2@mail.com', NULL, '$2y$10$v1Qfh9Hme4WfeGrdjvdvU.iayP0bJ1oIcYGsAt53geyBq3/IaEuVm', 2, NULL, '2019-11-11 10:26:13', '2019-11-11 10:26:13', 'active'),
(5, 'aa aaa', 'sahar.saadatmandi@outlook.it', NULL, '$2y$10$rhGy4vVbcHgCvUMuqC9L1.fJnv9oUgXylKEYXAZ3J4/Egm83pfnnO', 2, NULL, '2019-11-11 11:38:57', '2019-11-11 11:38:57', 'active'),
(6, 'aa aaa', 'sahar.saadatmandi@outlook.it', NULL, '$2y$10$vWMwT8tWZmBsA4Vnv53IUeD5ZfMKfVtz7ShtRqdF8ZfiqrdAQl8AO', 2, NULL, '2019-11-11 11:39:21', '2019-11-11 11:39:21', 'active'),
(7, 'aa aaa', 'sahar.saadatmandi@outlook.it', NULL, '$2y$10$ElFB3jxr1qf9iVOTFXRPQuRYgyTflfDu2Gq5xpKgb6mJ4cmS4X1Z6', 2, NULL, '2019-11-11 11:39:35', '2019-11-11 11:39:35', 'active'),
(8, 't3 teacher', 'sahar.saadatmandi@hotmail.com', NULL, '$2y$10$IgPkNyTE1VeBq5wGHlxZsODHcvbX3vSkkSyXNkrBtylUNqctPzbpu', 2, NULL, '2019-11-11 11:42:17', '2019-11-11 11:42:17', 'active'),
(9, 't3 teacher', 'sahar.saadatmandi@hotmail.com', NULL, '$2y$10$MONGx9fR8B22nlUK3OG7KO3ZKnE4N9ajvGdxxokrGizXqGsGUXGTW', 2, NULL, '2019-11-11 11:42:43', '2019-11-11 11:42:43', 'active');

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

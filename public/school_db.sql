-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Nov 14, 2019 alle 16:49
-- Versione del server: 10.1.40-MariaDB
-- Versione PHP: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `schooldb3`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `classroom`
--

CREATE TABLE `classroom` (
  `id` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `capacity` int(20) DEFAULT NULL,
  `description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
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

CREATE TABLE `lecturetopic` (
  `id` int(11) NOT NULL,
  `idClass` varchar(45) NOT NULL,
  `idTeach` int(11) NOT NULL,
  `subject` varchar(45) NOT NULL,
  `date` varchar(45) NOT NULL,
  `topic` varchar(300) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf32;

--
-- Dump dei dati per la tabella `lecturetopic`
--

INSERT INTO `lecturetopic` (`id`, `idClass`, `idTeach`, `subject`, `date`, `topic`) VALUES
(1, '11A', 8, 'Math', '2019-11-14', 'Tante belle cose'),
(2, '11B', 8, 'Math', '2019-10-13', 'Altre belle cose'),
(3, '10A', 8, 'italian', '2019-2-6', 'Altre tante belle cose');

-- --------------------------------------------------------

--
-- Struttura della tabella `marks`
--

CREATE TABLE `marks` (
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

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(45) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL
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

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
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
  `birthPlace` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fiscalCode` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `mailParent1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mailParent2` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `student`
--

INSERT INTO `student` (`id`, `firstName`, `lastName`, `birthday`, `address`, `phone`, `postCode`, `photo`, `gender`, `description`, `email`, `classId`, `birthPlace`, `fiscalCode`, `created_at`, `updated_at`, `mailParent1`, `mailParent2`) VALUES
(1, 'Matteo', 'Fresco', NULL, NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, NULL, NULL, '2019-11-12 11:53:28', '2019-11-12 11:53:28', 'calogerofresco@gmail.com', ''),
(2, 'Marco', 'Fresco', NULL, NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, NULL, NULL, '2019-11-12 11:56:29', '2019-11-12 11:56:29', 'calogerofresco@gmail.com', '');

-- --------------------------------------------------------

--
-- Struttura della tabella `studforparent`
--

CREATE TABLE `studforparent` (
  `idParent` int(11) NOT NULL,
  `idStudent` int(11) NOT NULL
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

CREATE TABLE `teacher` (
  `id` int(11) NOT NULL,
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
  `birthPlace` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fiscalCode` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `teacher`
--

INSERT INTO `teacher` (`id`, `firstName`, `lastName`, `birthday`, `userId`, `address`, `phone`, `postCode`, `photo`, `gender`, `description`, `birthPlace`, `fiscalCode`, `created_at`, `updated_at`) VALUES
(1, 'Cristina', 'Cassaro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-11-13 14:22:45', '2019-11-13 14:22:45'),
(8, 'Salvo', 'Capizzi', '1960-5-5', 14, 'Viale della concordia', '3404578456', '95132', NULL, 'M', NULL, 'Catania', 'CPZSLV65A06C351T', '2019-11-14 13:32:09', '2019-11-14 13:32:09');

-- --------------------------------------------------------

--
-- Struttura della tabella `teaching`
--

CREATE TABLE `teaching` (
  `idClass` varchar(45) NOT NULL,
  `idTeach` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf32;

--
-- Dump dei dati per la tabella `teaching`
--

INSERT INTO `teaching` (`idClass`, `idTeach`, `subject`) VALUES
('11A', 1, 'Math'),
('10A', 8, 'Italian');

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roleId` int(11) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('active','deactive') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `photo` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `roleId`, `remember_token`, `created_at`, `updated_at`, `status`, `photo`) VALUES
(1, 'Matteo', 'mfresco@gmail.com', NULL, '$2y$10$TQtWmTA0jkMlUiDSM8m2Ou2LxHATUd./koA6yTUNhxD9Sxf8r3ZyW', 1, NULL, '2019-11-12 10:41:22', '2019-11-12 10:41:22', 'active', NULL),
(2, 'Calogero', 'calogerofresco@gmail.com', NULL, '$2y$10$75Dsm3E3wRQGGtqNm9eMquohGUFx5e1fi9Rck7VqTqiA4AcGVmB0m', 3, NULL, '2019-11-12 11:58:45', '2019-11-12 11:58:45', 'active', NULL),
(13, 'andrea', 'andrea@gmail.com', NULL, '$2y$10$3QCuQiTo1EULmEHmQzR0quelwceD.IuAghfLp94vMJ9eZarS2j/iC', 1, NULL, '2019-11-14 12:31:10', '2019-11-14 12:31:10', 'active', NULL),
(14, 'Salvo Capizzi', 'salvo@gmail.com', NULL, '$2y$10$hinrWMs7lZnvWvX5toCzROwOUb6oW4h0MmGzRPhM9dLIZ23Msj8B.', 2, NULL, '2019-11-14 13:32:09', '2019-11-14 13:32:09', 'active', NULL);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `classroom`
--
ALTER TABLE `classroom`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `lecturetopic`
--
ALTER TABLE `lecturetopic`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indici per le tabelle `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ClassId_idx` (`classId`);

--
-- Indici per le tabelle `studforparent`
--
ALTER TABLE `studforparent`
  ADD PRIMARY KEY (`idParent`,`idStudent`);

--
-- Indici per le tabelle `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `teaching`
--
ALTER TABLE `teaching`
  ADD PRIMARY KEY (`idClass`,`idTeach`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_role_idx` (`roleId`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `lecturetopic`
--
ALTER TABLE `lecturetopic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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

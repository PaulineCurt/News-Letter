-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 02, 2023 at 01:07 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `subscribers-01`
--

-- --------------------------------------------------------

--
-- Table structure for table `interests`
--

CREATE TABLE `interests` (
  `id` int NOT NULL,
  `interestLabel` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `interests`
--

INSERT INTO `interests` (`id`, `interestLabel`) VALUES
(1, 'Peinture'),
(2, 'Sculpture'),
(3, 'Photographie'),
(4, 'Art contemporain'),
(5, 'Films'),
(6, 'Art numérique'),
(7, 'Installations');

-- --------------------------------------------------------

--
-- Table structure for table `origins`
--

CREATE TABLE `origins` (
  `id` int NOT NULL,
  `originLabel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `origins`
--

INSERT INTO `origins` (`id`, `originLabel`) VALUES
(2, 'Un ami m’en a parlé'),
(3, 'Recherche sur internet'),
(4, 'Publicité dans un magazine');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int NOT NULL,
  `dateTime` datetime NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `originId` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `dateTime`, `email`, `firstname`, `lastname`, `originId`) VALUES
(44, '2023-03-02 10:39:05', 'cutpauline@gmail.com', 'Pauline', 'Curt', 4),
(45, '2023-03-02 10:40:35', 'pauline@gmail.com', 'Pauline', 'Curt', 4),
(46, '2023-03-02 11:21:43', 'okkok@gmail.com', 'Pauline', 'Curt', 2),
(47, '2023-03-02 11:25:28', 'okoko@gmail.com', 'Pauline', 'Curt', 4),
(48, '2023-03-02 11:27:05', 'jdej@gmail.com', 'Pauline', 'Curt', 4),
(49, '2023-03-02 11:46:26', 'curtpauline@gmail.com', 'Pauline', 'Curt', 3),
(50, '2023-03-02 11:00:08', 'alfred.dupont@gmail.com', 'Alfred', 'Dupont', NULL),
(51, '2023-03-02 11:00:08', 'b.lav@hotmail.fr', 'Bertrand', 'Lavoisier', NULL),
(52, '2023-03-02 11:00:08', 'sarahlamine@gmail.com', 'Sarah', 'Lamine', NULL),
(53, '2023-03-02 11:00:08', 'mo78@laposte.net', 'Mohamed', 'Ben Salam', NULL),
(54, '2023-03-02 14:07:18', 'toto@gmail.com', 'Pauline', 'Curt', 4);

-- --------------------------------------------------------

--
-- Table structure for table `subscribers_interest`
--

CREATE TABLE `subscribers_interest` (
  `interestId` int NOT NULL,
  `subscriberId` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscribers_interest`
--

INSERT INTO `subscribers_interest` (`interestId`, `subscriberId`) VALUES
(5, 44),
(3, 44),
(7, 45),
(1, 45),
(5, 46),
(7, 46),
(1, 46),
(1, 47),
(1, 48),
(7, 49),
(3, 49),
(1, 54),
(3, 54);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `interests`
--
ALTER TABLE `interests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `origins`
--
ALTER TABLE `origins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_origins` (`originId`);

--
-- Indexes for table `subscribers_interest`
--
ALTER TABLE `subscribers_interest`
  ADD KEY `fk_interestId` (`interestId`),
  ADD KEY `fk_subscribersId` (`subscriberId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `interests`
--
ALTER TABLE `interests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `origins`
--
ALTER TABLE `origins`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD CONSTRAINT `fk_origins` FOREIGN KEY (`originId`) REFERENCES `origins` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `subscribers_interest`
--
ALTER TABLE `subscribers_interest`
  ADD CONSTRAINT `fk_interestId` FOREIGN KEY (`interestId`) REFERENCES `interests` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_subscribersId` FOREIGN KEY (`subscriberId`) REFERENCES `subscribers` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

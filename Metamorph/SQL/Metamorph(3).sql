-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 28, 2025 at 05:34 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Metamorph`
--

-- --------------------------------------------------------

--
-- Table structure for table `Celle`
--

CREATE TABLE `Celle` (
  `obsv_id` int(255) NOT NULL,
  `cell_id` int(2) NOT NULL,
  `temperature` float NOT NULL,
  `humidity` float NOT NULL,
  `food` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `larvae_count` int(255) NOT NULL,
  `pupae_count` int(255) NOT NULL,
  `adult_count` int(255) NOT NULL,
  `total_individuals` int(255) NOT NULL,
  `total_female` int(255) NOT NULL,
  `total_male` int(255) NOT NULL,
  `user_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Lepidoptera`
--

CREATE TABLE `Lepidoptera` (
  `lep_id` int(255) NOT NULL,
  `species` varchar(255) NOT NULL,
  `sex` enum('maschio','femmina','sconosciuto','') NOT NULL,
  `weight` float NOT NULL,
  `lenght` float NOT NULL,
  `stage` enum('uovo','larva','pupa','adulto') NOT NULL,
  `obsv_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `user_id` int(255) NOT NULL,
  `username` text DEFAULT NULL,
  `password` text DEFAULT NULL,
  `role` enum('Amministratore','Tecnico','Studente','') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Celle`
--
ALTER TABLE `Celle`
  ADD PRIMARY KEY (`obsv_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `Lepidoptera`
--
ALTER TABLE `Lepidoptera`
  ADD PRIMARY KEY (`lep_id`),
  ADD UNIQUE KEY `obsv_id` (`obsv_id`,`user_id`),
  ADD KEY `obsv_id_2` (`obsv_id`,`user_id`),
  ADD KEY `FK_2` (`user_id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Celle`
--
ALTER TABLE `Celle`
  MODIFY `obsv_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Lepidoptera`
--
ALTER TABLE `Lepidoptera`
  MODIFY `lep_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Celle`
--
ALTER TABLE `Celle`
  ADD CONSTRAINT `FK_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`);

--
-- Constraints for table `Lepidoptera`
--
ALTER TABLE `Lepidoptera`
  ADD CONSTRAINT `FK_2` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`),
  ADD CONSTRAINT `FK_3` FOREIGN KEY (`obsv_id`) REFERENCES `Celle` (`obsv_id`);

--
-- Constraints for table `Users`
--
ALTER TABLE `Users`
  ADD CONSTRAINT `Users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Celle` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

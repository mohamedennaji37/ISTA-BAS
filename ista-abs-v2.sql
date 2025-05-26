-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2025 at 02:53 AM
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
-- Database: `ista-abs-v2`
--

-- --------------------------------------------------------

--
-- Table structure for table `absencejustification`
--

CREATE TABLE `absencejustification` (
  `justification_id` int(11) NOT NULL,
  `absence_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `justification_text` text DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `justification_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `absences`
--

CREATE TABLE `absences` (
  `absence_id` int(11) NOT NULL,
  `stagiaire_id` int(11) DEFAULT NULL,
  `seance_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `recorded_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absences`
--

INSERT INTO `absences` (`absence_id`, `stagiaire_id`, `seance_id`, `user_id`, `status`, `recorded_at`) VALUES
(14, 1, 11, 5, 'Absent', '2025-04-30 02:30:54');

-- --------------------------------------------------------

--
-- Table structure for table `anneuniversitaire`
--

CREATE TABLE `anneuniversitaire` (
  `anne_id` int(11) NOT NULL,
  `anneUinversitiaire` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anneuniversitaire`
--

INSERT INTO `anneuniversitaire` (`anne_id`, `anneUinversitiaire`) VALUES
(1, 2023),
(2, 2024);

-- --------------------------------------------------------

--
-- Table structure for table `auditlog`
--

CREATE TABLE `auditlog` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(100) DEFAULT NULL,
  `table_name` varchar(100) DEFAULT NULL,
  `record_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enseignant`
--

CREATE TABLE `enseignant` (
  `enseignant_id` int(11) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enseignant`
--

INSERT INTO `enseignant` (`enseignant_id`, `first_name`, `last_name`, `email`, `phone`) VALUES
(1, 'Youssef', 'El Amrani', 'youssef.e@example.com', '0645678901'),
(2, 'Salma', 'Alaoui', 'salma.a@example.com', '0656789012');

-- --------------------------------------------------------

--
-- Table structure for table `filiere`
--

CREATE TABLE `filiere` (
  `filiere_id` int(11) NOT NULL,
  `filiere_name` varchar(100) DEFAULT NULL,
  `secteur_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `filiere`
--

INSERT INTO `filiere` (`filiere_id`, `filiere_name`, `secteur_id`) VALUES
(1, 'Développement Web', 1),
(2, 'Réseaux Informatiques', 1),
(3, 'Comptabilité', 2),
(4, 'SMPC', 3),
(5, 'Rasem', 4),
(6, 'Droit General', 5);

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `module_id` int(11) NOT NULL,
  `module_name` varchar(100) DEFAULT NULL,
  `filiere_id` int(11) DEFAULT NULL,
  `enseignant_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`module_id`, `module_name`, `filiere_id`, `enseignant_id`) VALUES
(1, 'HTML/CSS', 1, 1),
(2, 'Systèmes d’exploitation', 2, 1),
(3, 'Comptabilité Générale', 3, 2),
(7, 'Language JAVA', 1, 1),
(8, 'Cyeber Security', 2, 1),
(9, 'Statistiques', 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `seance`
--

CREATE TABLE `seance` (
  `seance_id` int(11) NOT NULL,
  `seance_date` date DEFAULT NULL,
  `seance_time` enum('1','2','3','4') DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `anne_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seance`
--

INSERT INTO `seance` (`seance_id`, `seance_date`, `seance_time`, `module_id`, `anne_id`) VALUES
(11, '2025-04-30', '1', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `secteur`
--

CREATE TABLE `secteur` (
  `secteur_id` int(11) NOT NULL,
  `secteur_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `secteur`
--

INSERT INTO `secteur` (`secteur_id`, `secteur_name`) VALUES
(1, 'Informatique'),
(2, 'Gestion'),
(3, 'Science'),
(4, 'Arts'),
(5, 'Droits');

-- --------------------------------------------------------

--
-- Table structure for table `stagiaire`
--

CREATE TABLE `stagiaire` (
  `stagiaire_id` int(11) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `filiere_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stagiaire`
--

INSERT INTO `stagiaire` (`stagiaire_id`, `first_name`, `last_name`, `email`, `phone`, `filiere_id`) VALUES
(1, 'Sara', 'Benali', 'sara.benali@example.com', '0612345678', 1),
(2, 'Omar', 'Tahiri', 'omar.tahiri@example.com', '0623456789', 1),
(3, 'Khadija', 'Moussaoui', 'khadija.m@example.com', '0634567890', 3),
(4, 'Anas', 'IBRAHIMI', 'anas@gmail.com', '639000276', 4),
(5, 'Zakaria', 'ABDELHAY', 'zakaria@gmail.com', '663636662', 5),
(6, 'Mohammed', 'Ennaji', 'mohamed@gmail.com', '627365241', 6);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `blocked` tinyint(1) DEFAULT 0 CHECK (`blocked` in (0,1))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`, `blocked`) VALUES
(4, 'anas', '$2a$12$cM8slzyDIRhJSs4w.gyOTuhgNzAUe8DvDFlVRKgBaaV41VxI98dE6', 'user', 1),
(5, 'admin', '$2a$12$oiFiM5ubBGyvh7nlHJIM5.ptidx5gf1kKqvjuTaWv0G2xh8bXXL66', 'admin', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absencejustification`
--
ALTER TABLE `absencejustification`
  ADD PRIMARY KEY (`justification_id`),
  ADD KEY `absence_id` (`absence_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `absences`
--
ALTER TABLE `absences`
  ADD PRIMARY KEY (`absence_id`),
  ADD KEY `stagiaire_id` (`stagiaire_id`),
  ADD KEY `seance_id` (`seance_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `anneuniversitaire`
--
ALTER TABLE `anneuniversitaire`
  ADD PRIMARY KEY (`anne_id`);

--
-- Indexes for table `auditlog`
--
ALTER TABLE `auditlog`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `enseignant`
--
ALTER TABLE `enseignant`
  ADD PRIMARY KEY (`enseignant_id`);

--
-- Indexes for table `filiere`
--
ALTER TABLE `filiere`
  ADD PRIMARY KEY (`filiere_id`),
  ADD KEY `secteur_id` (`secteur_id`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`module_id`),
  ADD KEY `filiere_id` (`filiere_id`),
  ADD KEY `enseignant_id` (`enseignant_id`);

--
-- Indexes for table `seance`
--
ALTER TABLE `seance`
  ADD PRIMARY KEY (`seance_id`),
  ADD KEY `module_id` (`module_id`),
  ADD KEY `anne_id` (`anne_id`);

--
-- Indexes for table `secteur`
--
ALTER TABLE `secteur`
  ADD PRIMARY KEY (`secteur_id`);

--
-- Indexes for table `stagiaire`
--
ALTER TABLE `stagiaire`
  ADD PRIMARY KEY (`stagiaire_id`),
  ADD KEY `filiere_id` (`filiere_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absencejustification`
--
ALTER TABLE `absencejustification`
  MODIFY `justification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `absences`
--
ALTER TABLE `absences`
  MODIFY `absence_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `anneuniversitaire`
--
ALTER TABLE `anneuniversitaire`
  MODIFY `anne_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `auditlog`
--
ALTER TABLE `auditlog`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `enseignant`
--
ALTER TABLE `enseignant`
  MODIFY `enseignant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `filiere`
--
ALTER TABLE `filiere`
  MODIFY `filiere_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `seance`
--
ALTER TABLE `seance`
  MODIFY `seance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `secteur`
--
ALTER TABLE `secteur`
  MODIFY `secteur_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stagiaire`
--
ALTER TABLE `stagiaire`
  MODIFY `stagiaire_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absencejustification`
--
ALTER TABLE `absencejustification`
  ADD CONSTRAINT `absencejustification_ibfk_1` FOREIGN KEY (`absence_id`) REFERENCES `absences` (`absence_id`),
  ADD CONSTRAINT `absencejustification_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `absences`
--
ALTER TABLE `absences`
  ADD CONSTRAINT `absences_ibfk_1` FOREIGN KEY (`stagiaire_id`) REFERENCES `stagiaire` (`stagiaire_id`),
  ADD CONSTRAINT `absences_ibfk_2` FOREIGN KEY (`seance_id`) REFERENCES `seance` (`seance_id`),
  ADD CONSTRAINT `absences_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `auditlog`
--
ALTER TABLE `auditlog`
  ADD CONSTRAINT `auditlog_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `filiere`
--
ALTER TABLE `filiere`
  ADD CONSTRAINT `filiere_ibfk_1` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`secteur_id`);

--
-- Constraints for table `module`
--
ALTER TABLE `module`
  ADD CONSTRAINT `module_ibfk_1` FOREIGN KEY (`filiere_id`) REFERENCES `filiere` (`filiere_id`),
  ADD CONSTRAINT `module_ibfk_2` FOREIGN KEY (`enseignant_id`) REFERENCES `enseignant` (`enseignant_id`);

--
-- Constraints for table `seance`
--
ALTER TABLE `seance`
  ADD CONSTRAINT `seance_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `module` (`module_id`),
  ADD CONSTRAINT `seance_ibfk_2` FOREIGN KEY (`anne_id`) REFERENCES `anneuniversitaire` (`anne_id`);

--
-- Constraints for table `stagiaire`
--
ALTER TABLE `stagiaire`
  ADD CONSTRAINT `stagiaire_ibfk_1` FOREIGN KEY (`filiere_id`) REFERENCES `filiere` (`filiere_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

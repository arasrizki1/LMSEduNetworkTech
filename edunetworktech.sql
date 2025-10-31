-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 30, 2025 at 05:09 PM
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
-- Database: `edunetworktech`
--

-- --------------------------------------------------------

--
-- Table structure for table `diskusi`
--

CREATE TABLE `diskusi` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `pesan` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `diskusi`
--

INSERT INTO `diskusi` (`id`, `user_id`, `pesan`, `image_path`, `created_at`) VALUES
(1, 2, 'test', NULL, '2025-10-30 16:48:17'),
(2, 3, '', 'uploads/chat/chat_690398218ce4d.jpeg', '2025-10-30 16:53:53'),
(3, 3, 'holaaaa', NULL, '2025-10-30 16:54:13'),
(4, 2, 'tes', NULL, '2025-10-30 17:07:28'),
(5, 2, '', 'uploads/chat/chat_69039b5a59f2f.png', '2025-10-30 17:07:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Instruktur','Peserta') NOT NULL,
  `full_name` varchar(200) DEFAULT NULL,
  `birth_place` varchar(150) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` enum('Laki-laki','Perempuan','Lainnya') DEFAULT NULL,
  `religion` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` text,
  `hobbies` text,
  `last_education` varchar(150) DEFAULT NULL,
  `current_education` varchar(150) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `cohort` varchar(50) DEFAULT NULL,
  `year_entry` year DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `full_name`, `birth_place`, `birth_date`, `gender`, `religion`, `phone`, `address`, `hobbies`, `last_education`, `current_education`, `photo`, `cohort`, `year_entry`, `created_at`) VALUES
(2, 'instruktur', 'instruktur@gmail.com', '$2y$10$s9AakREr0dKVJv2DQF.Ik.m2vkJLA8Ym/ZxkoSVYJE.G0zLv2dANG', 'Instruktur', 'instruktur', 'jakarta', '1993-02-25', 'Laki-laki', 'islam', '82125223733', 'jakarta timur', '-', 's1', '-', 'p_69036affa9b33.jpg', 'satu', '2019', '2025-10-30 13:41:19'),
(3, 'peserta1', 'peserta1@gmail.com', '$2y$10$gVAh0WqYktWoG7kZQ.ITGeLhRedFUsYUYtq/AbRmZmRy4y2a0a4Eq', 'Peserta', 'peserta pertama', 'jakarta', '1993-02-25', 'Laki-laki', 'islam', '82125223733', 'jakarta', '', '', 's1', '1761842152_Black and Gold Profesional Manager Id Card Portrait (3).png', 'dua', '2021', '2025-10-30 13:42:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `diskusi`
--
ALTER TABLE `diskusi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `diskusi`
--
ALTER TABLE `diskusi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `diskusi`
--
ALTER TABLE `diskusi`
  ADD CONSTRAINT `diskusi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

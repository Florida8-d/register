-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2025 at 11:44 AM
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
-- Database: `users_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `surname` varchar(20) NOT NULL,
  `number` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `adress` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `surname`, `number`, `email`, `adress`, `password`) VALUES
(28, 'artiola', 'Dedenikaj', '696969699', 'florartflorart88@gmail.com', 'RRUGA EMIL LEGRAND', '$2y$10$HSHyQWvSVWJgJN.bi4MsteX7VwdzBbYQ/H6gmGud9J9QXmI5XxT6e'),
(29, 'Florida', 'Dedenikaj', '0696969699', 'dedenikajflorida@gmail.com', 'RRUGA EMIL LEGRAND', '$2y$10$Y29U1pgTynYcfDFGonipOepSeh4W0bEn65CRnq8qpKm6UcLemzcem'),
(30, 'krista', 'Dedenikaj', '686868688', 'floridadedeniku20@gmail.com', 'RRUGA EMIL LEGRAND', '$2y$10$jfII9I8xSMH5ReE5CLRitefGIR6oER.B0V52qz/FBP6oBd3fQJZDq');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `user`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

ALTER TABLE `user`
ADD COLUMN `role` VARCHAR(20) NOT NULL DEFAULT 'user';

UPDATE `user`
SET `role` = 'admin'
WHERE `email` = 'dedenikajflorida@gmail.com';






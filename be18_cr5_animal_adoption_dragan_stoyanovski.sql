-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2023 at 11:32 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `be18_cr5_animal_adoption_dragan_stoyanovski`
--
CREATE DATABASE IF NOT EXISTS `be18_cr5_animal_adoption_dragan_stoyanovski` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `be18_cr5_animal_adoption_dragan_stoyanovski`;

-- --------------------------------------------------------

--
-- Table structure for table `animal`
--

CREATE TABLE `animal` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `breed` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `vaccine` varchar(255) NOT NULL,
  `pedigree` varchar(255) NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `animal`
--

INSERT INTO `animal` (`id`, `first_name`, `address`, `age`, `breed`, `size`, `gender`, `vaccine`, `pedigree`, `price`, `image`) VALUES
(1, 'Snake', 'Erstegasse 21', 8, 'Rattle Snake', 'Large', 'Female', 'Yes', 'No', '119.99', 'snake.jpg'),
(2, 'Eagle', 'Zweittegasse 26', 10, 'Eagle', 'Large', 'Male', 'Yes', 'Yes', '319.99', 'eagle.jpg'),
(3, 'Fish', 'Drittegasse 1', 2, 'Gold Fish', 'Small', 'Female', 'No', 'No', '29.99', 'fish.jpg'),
(4, 'Dog', 'Viertegasse 36', 9, 'House Dog', 'large', 'Male', 'Yes', 'Yes', '499.99', 'dog.jpg'),
(5, 'Fox', 'Funftegasse 45', 11, 'Wild Fox', 'Small', 'Female', 'No', 'No', '239.99', 'fox.jpg'),
(6, 'Hedgehod', 'Erstegasse 39', 6, 'House Hedgehod', 'Small', 'Male', 'Yes', 'Yes', '139.99', 'hedgehod.jpg'),
(7, 'Bird', 'Zweittegasse 34', 9, 'Kingfisher Bird', 'Small', 'Female', 'Yes', 'No', '79.99', 'kingfisher_bird.jpg'),
(8, 'Parrot', 'Siebtegasse 52', 10, 'King Parrot', 'Small', 'Male', 'Yes', 'Yes', '209.99', 'parrot.jpg'),
(9, 'Rabbit', 'Rabbitgasse 43', 8, 'Wild Rabbit', 'Small', 'Male', 'Yes', 'Yes', '119.99', 'rabbit.jpg'),
(10, 'Squirrel', 'Squirellgasse 52', 5, 'Wild Squirell', 'Small', 'Male', 'No', 'No', '259.99', 'squirrel.jpg'),
(11, 'Butterfly', 'Funftegasse 21', 1, 'Butterfly', 'Small', 'male', 'no', 'Yes', '99.99', '6427f7061ef8f.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `gender`
--

CREATE TABLE `gender` (
  `gender_id` int(11) NOT NULL,
  `male_female` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gender`
--

INSERT INTO `gender` (`gender_id`, `male_female`) VALUES
(1, 'male'),
(2, 'female');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(5) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `password`, `date_of_birth`, `email`, `image`, `status`) VALUES
(8, 'useruser', 'useruser', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', '2023-03-09', 'user@gmail.com', '6427ea45647f3.png', 'user'),
(9, 'adminn', 'adminn', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', '2023-03-16', 'admin@gmail.com', '6426c3ff4dcb0.jpg', 'adm');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `animal`
--
ALTER TABLE `animal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gender`
--
ALTER TABLE `gender`
  ADD PRIMARY KEY (`gender_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `animal`
--
ALTER TABLE `animal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `gender`
--
ALTER TABLE `gender`
  MODIFY `gender_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2024 at 05:55 PM
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
-- Database: `be22_exam5_animal_adoption_joshua`
--
CREATE DATABASE IF NOT EXISTS `be22_exam5_animal_adoption_joshua` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `be22_exam5_animal_adoption_joshua`;

-- --------------------------------------------------------

--
-- Table structure for table `animals`
--

CREATE TABLE `animals` (
  `animal_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `size` varchar(50) NOT NULL,
  `age` int(11) NOT NULL,
  `vaccinated` tinyint(1) NOT NULL,
  `breed` varchar(50) NOT NULL,
  `status` enum('Adopted','Available','Pending') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `animals`
--

INSERT INTO `animals` (`animal_id`, `name`, `photo`, `location`, `description`, `size`, `age`, `vaccinated`, `breed`, `status`) VALUES
(1, 'Buddy', './images/66af9fcf9ab79.jpg', 'Praterstrasse 10', 'Friendly dog looking for a home', 'Medium', 5, 0, 'Labrador', 'Available'),
(2, 'Milo', 'images/Siamese.jpg', 'Main Street 5', 'Playful cat, loves attention', 'Small', 2, 1, 'Siamese', 'Available'),
(3, 'Bella', 'images/German Shepherd.jpg', 'Baker Street 221B', 'Loyal companion, great with kids', 'Large', 9, 1, 'German Shepherd', 'Available'),
(4, 'Lucy', 'images/Great Dane.jpg', 'Oak Avenue 10', 'Gentle giant, very calm', 'Large', 10, 1, 'Great Dane', 'Available'),
(5, 'Chirpy', 'images/Canary.jpg', 'Maple Lane 20', 'Singing bird, very cheerful', 'Small', 1, 0, 'Canary', 'Available'),
(6, 'Hoppy', 'images/Holland Lop.jpg', 'River Road 8', 'Friendly and playful rabbit', 'Small', 2, 0, 'Holland Lop', 'Available'),
(7, 'Shelly', 'images/Red-Eared Slider.jpg', 'Ocean View 32', 'Quiet and calm turtle', 'Small', 15, 0, 'Red-Eared Slider', 'Available'),
(8, 'Nibbles', 'images/Hamster.jpg', 'Forest Lane 6', 'Active and loves to chew', 'Small', 4, 1, 'Hamster', 'Available'),
(9, 'Charlie', 'images/Poodle.jpg', 'Elm Street 12', 'Senior dog, very loving', 'Medium', 12, 1, 'Poodle', 'Available'),
(10, 'Spike', 'images/Iguana.jpg', 'Cactus Road 14', 'Calm and friendly', 'Medium', 8, 0, 'Iguana', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `email`, `phone_number`, `address`, `picture`, `password`, `status`) VALUES
(10, 'Admin', 'Joshua', 'Admin@hotmail.com', '4354252532', 'AdminStrasse', 'user.png', '7789f80c52a801c43c52f12ee50df3b095530faa44a62a8d0f700329431f0774', 'adm'),
(11, 'joshua', 'erwr', 'tumae@hotmail.com', '233144121', 'gegagre', 'user.png', '4e5bdba8e9947fa42b2d14e966daa44fc2c497ae6dba63ccd756dfddc4f83c79', 'user'),
(12, 'Admins', 'Admins', 'Admin2@hotmail.com', '123122344324', 'Admin2', 'user.png', '1009407d93c32e951429cf120698a648ffcb84fcc6907128e49b8c5dc6d8b132', 'user'),
(13, 'user', 'user', 'user@hotmail.com', '1243232512', 'user', 'user.png', 'fa4b67bced5bd2ef704839422b275dd9c37660a4fdf06ddddfbaae6d3076e381', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `user_animals`
--

CREATE TABLE `user_animals` (
  `user_id` int(11) NOT NULL,
  `animal_id` int(11) NOT NULL,
  `adoption_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user_animals`
--

INSERT INTO `user_animals` (`user_id`, `animal_id`, `adoption_date`) VALUES
(13, 2, '2024-08-29'),
(13, 3, '2024-08-23'),
(13, 4, '2024-08-15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`animal_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_animals`
--
ALTER TABLE `user_animals`
  ADD PRIMARY KEY (`user_id`,`animal_id`),
  ADD KEY `animal_id` (`animal_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `animals`
--
ALTER TABLE `animals`
  MODIFY `animal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_animals`
--
ALTER TABLE `user_animals`
  ADD CONSTRAINT `user_animals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_animals_ibfk_2` FOREIGN KEY (`animal_id`) REFERENCES `animals` (`animal_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

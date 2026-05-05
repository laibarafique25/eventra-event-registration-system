-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2026 at 06:08 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `codealpha_events`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'Super Admin', 'admin@codealpha.com', '$2y$10$LzIwVZTB2SqNU/ILdmm3deFk8I8g1Zh7kU9uOK1a.j3yzkUJrDbei', '2026-05-04 15:29:19');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `event_date`, `location`, `image_url`) VALUES
(4, 'Tech Conference 2026', 'A deep dive into AI and Future Tech with industry leaders.', '2026-06-15', 'Karachi Expo Center', 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800'),
(5, 'UI/UX Workshop', 'Master the art of clean, modern, user-centered design.', '2026-07-10', 'Online', 'https://images.unsplash.com/photo-1559028012-481c04fa702d?w=800'),
(6, 'Startup Connect', 'Networking event for young entrepreneurs and investors.', '2026-08-05', 'PC Hotel Karachi', 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=800'),
(7, 'Global Marketing Summit', 'Learn the latest trends in digital marketing and brand growth.', '2026-09-12', 'Marriott Hotel, Karachi', 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?w=800'),
(8, 'Cyber Security Bootcamp', 'Hands-on training on protecting data and ethical hacking.', '2026-10-05', 'NED University, Karachi', 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?w=800'),
(9, 'Photography Masterclass', 'Capture stunning visuals with professional lighting techniques.', '2026-11-20', 'Clifton Beach Studio', 'https://images.unsplash.com/photo-1452587925148-ce544e77e70d?w=800'),
(10, 'E-commerce Expo 2026', 'Building the future of online retail and logistics.', '2026-12-10', 'Expo Center, Karachi', 'https://images.unsplash.com/photo-1563013544-824ae1b704d3?w=800'),
(11, 'Mental Health Awareness', 'A seminar on mindfulness and workplace well-being.', '2027-01-15', 'Online (Zoom)', 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=800'),
(12, 'Full Stack Dev Meetup', 'Connecting PHP and Node.js developers for collaboration.', '2027-02-28', 'Basecamp Karachi', 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=800');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`id`, `user_id`, `event_id`, `reg_date`) VALUES
(2, 1, 6, '2026-05-04 17:18:02'),
(3, 2, 8, '2026-05-04 17:23:47'),
(4, 2, 4, '2026-05-04 17:24:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'laiba rafique', 'laibarafiqueee@gmail.com', '$2y$10$ISCtJ1WwNv4CZ/Jo6Ei5pedJWeIRpaKpQClZMUVH2pKNEDxUePcOS'),
(2, 'zumar', 'zumar@gmail.com', '$2y$10$AEXUkjPHN8MfocJHViJZre0gL726FlPz5GS0f09Uf4e.JDzswmLua');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `registrations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `registrations_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 13, 2025 at 08:40 AM
-- Server version: 10.5.29-MariaDB
-- PHP Version: 8.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mominul_event_registration`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$fTTrcL7BpCOQLGhGORQmJO2hOptdJxwmOb/LyQmJGJ5foCuCs1Vh6');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `date`, `location`, `description`) VALUES
(1, 'SP V - Project Show', '2025-04-16 10:30:00', 'Daffodil International University', 'Student will display their final project and report to course teachers.'),
(2, 'SP VI - Project Show	', '2025-04-16 11:00:00', 'Daffodil International University	', 'Student will show their final project and report to course teacher.'),
(3, 'Pohela Boishakh 2025', '2025-04-14 09:30:00', 'DIU Smart City', 'à¦¬à§ˆà¦¶à¦¾à¦–à§‡à¦° à¦°à¦™, à¦°à§‚à¦ª à¦“ à¦¸à¦‚à¦¸à§à¦•à§ƒà¦¤à¦¿à¦° à¦®à¦¿à¦²à¦¨à¦®à§‡à¦²à¦¾à§Ÿ à¦†à¦ªà¦¨à¦¾à¦¦à§‡à¦° à¦…à¦‚à¦¶à¦—à§à¦°à¦¹à¦£ à¦à¦‡ à¦‰à§Žà¦¸à¦¬à¦•à§‡ à¦†à¦°à§‹ à¦ªà§à¦°à¦¾à¦£à¦¬à¦¨à§à¦¤ à¦•à¦°à§‡ à¦¤à§à¦²à¦¬à§‡à¥¤ à¦†à¦¸à§à¦¨, à¦†à¦®à¦°à¦¾ à¦¸à¦¬à¦¾à¦‡ à¦®à¦¿à¦²à§‡ à¦¬à¦¾à¦‚à¦²à¦¾ à¦¨à¦¤à§à¦¨ à¦¬à¦›à¦°à¦•à§‡ à¦¸à§à¦¬à¦¾à¦—à¦¤ à¦œà¦¾à¦¨à¦¾à¦‡à¥¤'),
(4, 'Pohela Boishakh Special Daffodil Startup Market', '2025-04-12 02:36:00', 'Student Lounge, KT', 'If you are interested in participating, you must register online by 10th April at 12:00 PM to ensure your place in this exciting event. Whether you are showcasing traditional food, handmade crafts, fashion, or any innovative product, the market is an excellent platform to highlight your creativity and entrepreneurial spirit.\r\n\r\n'),
(5, 'Test Event at Daffodil', '2025-04-15 04:45:00', 'KT', 'Description text goes here...'),
(6, 'Test Past Event 2', '2025-04-10 04:49:00', 'DIU Smart City', 'Description goes here...'),
(7, 'Test Event 4', '2025-04-10 05:32:00', 'DIU Campus', 'Description text goes here...');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `registration_time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`id`, `event_id`, `name`, `student_id`, `email`, `phone`, `registration_time`) VALUES
(3, 1, 'Test3', '111', 'test3@gmail.com', '88888881', '2025-04-12 17:13:24'),
(4, 2, 'Mominul Islam', '192-15-13156', 'hello@mominulislam.com', '01778661144', '2025-04-12 17:23:53'),
(5, 1, 'sss', '444', 'test7@gmail.com', '000042112', '2025-04-12 18:02:38'),
(10, 1, 'Test User 18', '1114441', 'email@gdggd.com', '73767763', '2025-04-15 01:56:11'),
(11, 2, 'Hkjsdhf', '32989873', 'fhfh@dhhd.com', '3883893', '2025-04-22 03:55:16'),
(12, 2, 'Tes 9', '1939333', 'sk@gma.com', '3333', '2025-08-21 20:54:21'),
(13, 4, 'Test', '125454', 'test@gmail.com', '01778661144', '2025-12-10 00:08:26'),
(14, 7, 'Test6', '4565544', 'tesjbs@dhhd.com', '555556', '2025-12-10 00:38:01');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `registrations_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2025 at 02:22 AM
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
-- Database: `shmopdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `classrooms`
--

CREATE TABLE `classrooms` (
  `id` int(11) NOT NULL,
  `class_code` varchar(50) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classrooms`
--

INSERT INTO `classrooms` (`id`, `class_code`, `subject`, `teacher_id`, `created_at`) VALUES
(1, '123', 'MATH', 2, '2025-02-25 01:20:37');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `classroom_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `enrolled_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `classroom_id`, `student_id`, `enrolled_at`) VALUES
(1, 1, 7, '2025-02-25 01:21:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `role` enum('admin','teacher','student') NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `lastname`, `firstname`, `username`, `role`, `password`, `created_at`) VALUES
(1, '', '', 'admin', 'admin', '$2y$10$PYO3nGsgDYod6Ue0W1zkEuB0Klw99OX3rqstoYONr6CCBRQlOe0Xm', '2025-02-25 01:16:30'),
(2, 'Teacher1', 'First1', 'teacher1', 'teacher', '$2y$10$ixCMqsos4YEdu8UhVbOz9ObT8I4zV4319EmpeVQOvYO1ny3dTEFca', '2025-02-25 01:17:00'),
(3, 'Teacher2', 'First2', 'teacher2', 'teacher', '$2y$10$NPPQX1DTpYB1Bne0InaevukMHl0Lf3FblTntfWSAj5QafpiofbyAO', '2025-02-25 01:17:01'),
(4, 'Teacher3', 'First3', 'teacher3', 'teacher', '$2y$10$LOQd1QB9h0U04LjaJUg8UewWHbDGJKzrcadnD0uE13sNNVKIoZogG', '2025-02-25 01:17:01'),
(5, 'Teacher4', 'First4', 'teacher4', 'teacher', '$2y$10$kh9ayDxteqkokAmAQg1BW.jeV8e/AaS3TAfPGmlvClEzGDenHgxRi', '2025-02-25 01:17:01'),
(6, 'Teacher5', 'First5', 'teacher5', 'teacher', '$2y$10$jX9Gil513fHqrE7Gc1fmo.6UTzszTYG1.e21lk8aemZg8P18P97.a', '2025-02-25 01:17:01'),
(7, 'Student1', 'First1', 'student1', 'student', '$2y$10$QZwR1yUwJRQwBwEgPa4to.6jmE.ti3Gqs2B9/09/FnuLI9pyJ9syu', '2025-02-25 01:17:30'),
(8, 'Student2', 'First2', 'student2', 'student', '$2y$10$jJaVGTBe6qcNBuD555VRl.DBeyMfJccZ8hCX9yBIl9ZQoqAquE5Eq', '2025-02-25 01:17:30'),
(9, 'Student3', 'First3', 'student3', 'student', '$2y$10$IO4RljldkmWq0FCj0.B/keZwhLKhMniHFckmRGLvcZNmoxIkpHP6i', '2025-02-25 01:17:31'),
(10, 'Student4', 'First4', 'student4', 'student', '$2y$10$rOXLf6lo6gd8hDvsoy7em.7deIgB0vtR2fN0//wmUB9RKsUYfvv5q', '2025-02-25 01:17:31'),
(11, 'Student5', 'First5', 'student5', 'student', '$2y$10$YX7Efe3EckmITF2FUk/vZe1q6HKHmbk/53VXdQsSxMj9bUZg1pNqy', '2025-02-25 01:17:31'),
(12, 'Student6', 'First6', 'student6', 'student', '$2y$10$oO4DObHyOhusIFRDdVFLiueBn0rA174LAYf5KOrgoXV94OyXW5LuS', '2025-02-25 01:17:31'),
(13, 'Student7', 'First7', 'student7', 'student', '$2y$10$aFmKKuCO0G2IiEleHJzlpu2XnN.z2aE/8ATe.KgD.0AZsxYgpo/zS', '2025-02-25 01:17:31'),
(14, 'Student8', 'First8', 'student8', 'student', '$2y$10$0.H4n4prwMvoIQBh6NP2Fed.vmo9uN/fFStslTUNs453p2N8Kh0wW', '2025-02-25 01:17:31'),
(15, 'Student9', 'First9', 'student9', 'student', '$2y$10$qM4f6pASFS7aBuug5yQ39.OBz/a/C35AR0WvTpNa8odchL.91M1e.', '2025-02-25 01:17:31'),
(16, 'Student10', 'First10', 'student10', 'student', '$2y$10$Ui4gnHhRV1N8qLJGxnm9VOPz2FhFzQZHxG0OUUk5fHWD4OvZmxkmG', '2025-02-25 01:17:32'),
(17, 'Student11', 'First11', 'student11', 'student', '$2y$10$W25Bvu/ZCoIW9OC0HIoZ1OeRdM9dAdUgs2HJKOvkfiVEdq8Dm9UK.', '2025-02-25 01:17:32'),
(18, 'Student12', 'First12', 'student12', 'student', '$2y$10$rl1JSTR1MkVnK8hrVDQ5..L7rRBwfEA.lFNxETH0f5mqlE0fjf6yW', '2025-02-25 01:17:32'),
(19, 'Student13', 'First13', 'student13', 'student', '$2y$10$uqlvmNyFxlxfQvi2PQb8Meum1EjGsrThY5tqOQ5qvxYoK2.cn2OGq', '2025-02-25 01:17:32'),
(20, 'Student14', 'First14', 'student14', 'student', '$2y$10$YNi.UVy4oXeV9l0udOP9uuS2v0Teb4/aEp6l842z8o3HT6JUjKQ9S', '2025-02-25 01:17:32'),
(21, 'Student15', 'First15', 'student15', 'student', '$2y$10$KYm1aTX72qO0seduSvClu.ttdarngTDN6hKPxOlYbfQyINh6lqIYG', '2025-02-25 01:17:32'),
(22, 'Student16', 'First16', 'student16', 'student', '$2y$10$KvfHicAgZcRjhqT/ouUbleFrsUmtVYO/MWH85MYPTmbgoEh7FCaMu', '2025-02-25 01:17:32'),
(23, 'Student17', 'First17', 'student17', 'student', '$2y$10$Ql1LWSCsPRyTd1utqdazXuADQW3t1ZiFCv31Cs.tCggJqDV39q3R.', '2025-02-25 01:17:32'),
(24, 'Student18', 'First18', 'student18', 'student', '$2y$10$9tNx6DgcC3otI17kqnxXV.xj44ScvNPPys1Iy9YYrumbZBsN8phBe', '2025-02-25 01:17:33'),
(25, 'Student19', 'First19', 'student19', 'student', '$2y$10$Q/uY6AVHi6SPry7tMu69sOFbfzW3sDyBt1KhbL5hywJ4cVBXaVa0W', '2025-02-25 01:17:33'),
(26, 'Student20', 'First20', 'student20', 'student', '$2y$10$BBOJn/swI0re/0qpK3BB/.a1JBJTPgkhsOxuPRGTcuNKr/LeoEK5e', '2025-02-25 01:17:33'),
(27, 'Student21', 'First21', 'student21', 'student', '$2y$10$c7Qk.Ij7boKq.UDjfqV1ROowb5ZjQCBqOC2AYnU7zRt7RJt1F7SLq', '2025-02-25 01:17:33'),
(28, 'Student22', 'First22', 'student22', 'student', '$2y$10$h0LzImf1ETTkOgLwfdh.8uP6xqWUc5wSfKUVmEj4DvkmqRlY1MGS.', '2025-02-25 01:17:33'),
(29, 'Student23', 'First23', 'student23', 'student', '$2y$10$MzVBnK//Lv1R3as4k6m6cOgaDNH14MUH/8LUDvHb5OpkuOnrGYZ.6', '2025-02-25 01:17:33'),
(30, 'Student24', 'First24', 'student24', 'student', '$2y$10$aUh0bG6Pm8Xoyv7zOcXXLuSDKCyIfQpxKmnWx0TSuWWo4NgPwIlYW', '2025-02-25 01:17:33'),
(31, 'Student25', 'First25', 'student25', 'student', '$2y$10$eQ6Ry.lV7R2GbOGjpuiuw./WPmZpMgUQ2LufpNGULlP47Tiep0LZO', '2025-02-25 01:17:33'),
(32, 'Student26', 'First26', 'student26', 'student', '$2y$10$3r/tlNLeTpVd22k6RaVF5exsY1S.07chC3KF01U12xG3LyYC6KJAq', '2025-02-25 01:17:34'),
(33, 'Student27', 'First27', 'student27', 'student', '$2y$10$eFMieEmk0MbiK7hJAWzHyOmyw4XOaNdkDbR1h/PqY6goLFlLxYqeG', '2025-02-25 01:17:34'),
(34, 'Student28', 'First28', 'student28', 'student', '$2y$10$FBWi0C4TD/C2xQmfRdM4U.D/un0Es44PJYQjBDuU3dyseMNXAVGk2', '2025-02-25 01:17:34'),
(35, 'Student29', 'First29', 'student29', 'student', '$2y$10$7ewEYdw4U5k19hIKr6wkWOKYI57b2D.I5e498rZO3ToOEDbcrq1xG', '2025-02-25 01:17:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classrooms`
--
ALTER TABLE `classrooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `class_code` (`class_code`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `classroom_id` (`classroom_id`,`student_id`),
  ADD KEY `student_id` (`student_id`);

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
-- AUTO_INCREMENT for table `classrooms`
--
ALTER TABLE `classrooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classrooms`
--
ALTER TABLE `classrooms`
  ADD CONSTRAINT `classrooms_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`classroom_id`) REFERENCES `classrooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

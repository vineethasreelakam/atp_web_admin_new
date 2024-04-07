-- phpMyAdmin SQL Dump
-- version 5.1.4deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 27, 2024 at 03:10 PM
-- Server version: 8.0.33-0ubuntu0.22.10.2
-- PHP Version: 8.1.7-1ubuntu3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vineetha_atp`
--

-- --------------------------------------------------------

--
-- Table structure for table `form_master`
--

CREATE TABLE `form_master` (
  `id` int NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text,
  `status` int DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `form_master`
--

INSERT INTO `form_master` (`id`, `title`, `image`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Form1', NULL, NULL, NULL, NULL, NULL),
(2, 'Form2', NULL, NULL, NULL, NULL, NULL),
(3, 'Form3', NULL, NULL, NULL, NULL, NULL),
(4, 'Form4', NULL, NULL, NULL, NULL, NULL),
(5, 'Form5', NULL, NULL, NULL, NULL, NULL),
(6, 'Form6', NULL, NULL, NULL, NULL, NULL),
(7, 's', 'Screenshot from 2024-03-14 19-45-05.png', 's', NULL, '2024-03-15', '2024-03-15');

-- --------------------------------------------------------

--
-- Table structure for table `form_questions`
--

CREATE TABLE `form_questions` (
  `id` int NOT NULL,
  `form_id` int DEFAULT NULL,
  `question` text,
  `question_no` int DEFAULT NULL,
  `question_type_id` int DEFAULT NULL,
  `section_id` int DEFAULT NULL,
  `rule_id` int DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `form_questions`
--

INSERT INTO `form_questions` (`id`, `form_id`, `question`, `question_no`, `question_type_id`, `section_id`, `rule_id`, `created_at`, `updated_at`) VALUES
(1, 7, 'w2', NULL, 1, 4, 1, '2024-03-20', '2024-03-21'),
(2, 7, 'w', NULL, 1, 4, 2, '2024-03-21', '2024-03-21'),
(3, 7, 'w', 2, 1, 4, 2, '2024-03-21', '2024-03-26'),
(4, 7, 'a', 2, 1, 4, 2, '2024-03-26', '2024-03-26');

-- --------------------------------------------------------

--
-- Table structure for table `form_questions_types`
--

CREATE TABLE `form_questions_types` (
  `id` int NOT NULL,
  `question_type` varchar(255) DEFAULT NULL,
  `values_required` enum('0','1') DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `form_questions_types`
--

INSERT INTO `form_questions_types` (`id`, `question_type`, `values_required`, `created_at`, `updated_at`) VALUES
(1, 'Dropdown', '1', NULL, NULL),
(2, 'Textbox', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `form_questions_values`
--

CREATE TABLE `form_questions_values` (
  `id` int NOT NULL,
  `question_id` int DEFAULT NULL,
  `option_value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `form_questions_values`
--

INSERT INTO `form_questions_values` (`id`, `question_id`, `option_value`, `created_at`, `updated_at`) VALUES
(1, 3, '7', '2024-03-26', '2024-03-26'),
(2, 3, 'd', '2024-03-26', '2024-03-26'),
(3, 3, 'f', '2024-03-26', '2024-03-26'),
(4, 4, '2', '2024-03-26', '2024-03-26'),
(5, 4, '3', '2024-03-26', '2024-03-26'),
(6, 4, '1', '2024-03-26', '2024-03-26');

-- --------------------------------------------------------

--
-- Table structure for table `form_question_rules`
--

CREATE TABLE `form_question_rules` (
  `id` int NOT NULL,
  `rule_code` varchar(255) DEFAULT NULL,
  `description` text,
  `value_1` text,
  `value_2` text,
  `value_3` text,
  `value_4` text,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `form_question_rules`
--

INSERT INTO `form_question_rules` (`id`, `rule_code`, `description`, `value_1`, `value_2`, `value_3`, `value_4`, `created_at`, `updated_at`) VALUES
(2, '1w2e', 'gggg', 'g', 'g', 'g', 'g', '2024-03-21', '2024-03-21');

-- --------------------------------------------------------

--
-- Table structure for table `form_question_sections`
--

CREATE TABLE `form_question_sections` (
  `id` int NOT NULL,
  `form_id` int DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `section_type` varchar(255) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `form_question_sections`
--

INSERT INTO `form_question_sections` (`id`, `form_id`, `title`, `section_type`, `created_at`, `updated_at`) VALUES
(3, 6, 'g', 'g', '2024-03-20', '2024-03-20'),
(4, 7, 'ssss', 'ssss', '2024-03-20', '2024-03-20');

-- --------------------------------------------------------

--
-- Table structure for table `privillege_master`
--

CREATE TABLE `privillege_master` (
  `id` int NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `value` text NOT NULL,
  `status` int DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `privillege_master`
--

INSERT INTO `privillege_master` (`id`, `title`, `value`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Form Read', 'form_read', NULL, '2024-03-01', '2024-03-01'),
(2, 'Form Write', 'form_write', NULL, '2024-03-01', '2024-03-01'),
(3, 'Form Edit', 'form_edit', NULL, '2024-03-01', '2024-03-01'),
(4, 'Form Pdf', 'form_pdf', NULL, '2024-03-01', '2024-03-01'),
(5, 'User Manage', 'user_manage', NULL, '2024-03-01', '2024-03-01'),
(6, 'Subadmin Manage', 'subadmin_manage', NULL, '2024-03-01', '2024-03-01');

-- --------------------------------------------------------

--
-- Table structure for table `role_access`
--

CREATE TABLE `role_access` (
  `id` int NOT NULL,
  `role_id` int DEFAULT NULL,
  `privillege_id` int DEFAULT NULL,
  `form_id` int DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `status` int DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `role_access`
--

INSERT INTO `role_access` (`id`, `role_id`, `privillege_id`, `form_id`, `type`, `status`, `created_at`, `updated_at`) VALUES
(3, 16, 4, NULL, 'privillege', NULL, '2024-03-02', '2024-03-02'),
(4, 17, 1, NULL, 'privillege', NULL, '2024-03-02', '2024-03-02'),
(5, 17, 3, NULL, 'privillege', NULL, '2024-03-02', '2024-03-02'),
(6, 18, 2, NULL, 'privillege', NULL, '2024-03-02', '2024-03-02'),
(7, 18, 2, 2, 'form', NULL, '2024-03-02', '2024-03-02'),
(8, 18, 2, 3, 'form', NULL, '2024-03-02', '2024-03-02'),
(9, 18, 2, 4, 'form', NULL, '2024-03-02', '2024-03-02'),
(10, 20, 2, NULL, 'privillege', NULL, '2024-03-02', '2024-03-02'),
(11, 20, NULL, 3, 'form', NULL, '2024-03-02', '2024-03-02'),
(12, 20, NULL, 4, 'form', NULL, '2024-03-02', '2024-03-02'),
(13, 21, 5, NULL, 'privillege', NULL, '2024-03-02', '2024-03-02'),
(14, 21, NULL, 3, 'form', NULL, '2024-03-02', '2024-03-02'),
(15, 21, NULL, 5, 'form', NULL, '2024-03-02', '2024-03-02'),
(16, 22, 2, NULL, 'privillege', NULL, '2024-03-02', '2024-03-02'),
(17, 22, 3, NULL, 'privillege', NULL, '2024-03-02', '2024-03-02'),
(18, 22, 5, NULL, 'privillege', NULL, '2024-03-02', '2024-03-02'),
(19, 22, NULL, 3, 'form', NULL, '2024-03-02', '2024-03-02'),
(20, 22, NULL, 5, 'form', NULL, '2024-03-02', '2024-03-02'),
(21, 23, 3, NULL, 'privillege', NULL, '2024-03-02', '2024-03-02'),
(22, 23, 5, NULL, 'privillege', NULL, '2024-03-02', '2024-03-02'),
(23, 23, NULL, 3, 'form', NULL, '2024-03-02', '2024-03-02'),
(24, 23, NULL, 5, 'form', NULL, '2024-03-02', '2024-03-02');

-- --------------------------------------------------------

--
-- Table structure for table `role_master`
--

CREATE TABLE `role_master` (
  `id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `admin` enum('0','1') NOT NULL,
  `status` int DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `role_master`
--

INSERT INTO `role_master` (`id`, `title`, `admin`, `status`, `created_at`, `updated_at`) VALUES
(1, 'vvvv', '1', NULL, '2024-03-02', '2024-03-02'),
(16, 'wwwww', '0', NULL, '2024-03-02', '2024-03-02'),
(17, 'wssssssssssss', '0', NULL, '2024-03-02', '2024-03-02'),
(18, 'gggg', '0', NULL, '2024-03-02', '2024-03-02'),
(20, 'hhhhhhh', '0', NULL, '2024-03-02', '2024-03-02'),
(21, 'cccc', '0', NULL, '2024-03-02', '2024-03-02'),
(22, 'cccc', '0', NULL, '2024-03-02', '2024-03-02'),
(23, 'cccc', '0', NULL, '2024-03-02', '2024-03-02');

-- --------------------------------------------------------

--
-- Table structure for table `tournament_master`
--

CREATE TABLE `tournament_master` (
  `id` int NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `tournament_date` date DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `description` text,
  `status` enum('1','0') DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tournament_master`
--

INSERT INTO `tournament_master` (`id`, `title`, `tournament_date`, `category`, `description`, `status`, `created_at`, `updated_at`) VALUES
(2, 's', '2024-06-21', 'DAVIS CUP', 's', NULL, '2024-03-11', '2024-03-15'),
(3, 's', '2024-03-12', 'ATP 500', 's', NULL, '2024-03-12', '2024-03-12'),
(4, 'd', '2024-03-12', 'ATP 500', 'd', NULL, '2024-03-12', '2024-03-12'),
(5, 'd', '2024-04-03', 'DAVIS CUP', 'd', NULL, '2024-03-12', '2024-03-12'),
(6, 'n', '2024-03-07', 'ATP MASTERS 1000', 'n', NULL, '2024-03-12', '2024-03-12'),
(7, 'd', '2024-03-09', 'ATP MASTERS 1000', 'd', NULL, '2024-03-12', '2024-03-12'),
(8, 'd', '2024-03-08', 'ATP MASTERS 1000', 'd', NULL, '2024-03-12', '2024-03-12'),
(9, 's', '2024-03-18', 'DAVIS CUP', 's', NULL, '2024-03-12', '2024-03-12'),
(10, 'f', '2024-03-26', 'ATP MASTERS 1000', 'f', NULL, '2024-03-12', '2024-03-12'),
(11, 'f', '2024-04-01', 'OLYMPICS', 'f', NULL, '2024-03-12', '2024-03-12'),
(12, 't', '2024-04-05', 'DAVIS CUP', 'd', NULL, '2024-03-12', '2024-03-12'),
(15, 's', '2024-03-18', 'ATP 500', 's', NULL, '2024-03-12', '2024-03-12'),
(16, 's', '2024-03-24', 'GRAND SLAM', 's', NULL, '2024-03-15', '2024-03-15'),
(17, 's', '2012-11-29', 'ATP 250', 's', NULL, '2024-03-15', '2024-03-15'),
(18, 'x', '2024-03-10', 'DAVIS CUP', 'x', NULL, '2024-03-15', '2024-03-15'),
(19, 's', '2024-09-25', 'GRAND SLAM', 's', NULL, '2024-03-15', '2024-03-15'),
(20, 'd', '2024-07-24', 'DAVIS CUP', 'd', NULL, '2024-03-15', '2024-03-15'),
(21, 'x', '2024-09-27', 'GRAND SLAM', 'x', NULL, '2024-03-15', '2024-03-15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `admin` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `role_id` int DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `status` enum('1','0') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `mobile`, `admin`, `role_id`, `type`, `status`) VALUES
(1, 'Vineetha', 'test@gmail.com', '$2y$10$1hOt1bd4.KUMHX4OISp5heETuakaKRujK1OZLgZsJTwiiSQgUGSvK', '8907689346', '1', 1, 'super_admin', '1'),
(2, 'Sub Admin1', 'admin@mail.com', '$2y$10$1hOt1bd4.KUMHX4OISp5heETuakaKRujK1OZLgZsJTwiiSQgUGSvK', NULL, '1', 20, NULL, '1'),
(27, 'v', 'vineethavavachi@gmail.com', '$2y$10$uyyWRGs2/PEisxFaVLaWVuNJGk8ByCoraiHWMj1ANvzghnUSVtIsi', NULL, '0', 18, 'user', '1'),
(28, 'w', 'vineetha@manvia.in', '$2y$10$7UnSWvkf85PtIjK1crmqvePER/4qmKemUzEl6cJgq.HI1UEHrLvuK', NULL, '0', 16, 'user', '1'),
(29, 'x', 'x@gmail.com', '$2y$10$tD0GQly4XfnAeUFSRw3FzeeZ8ULmBWHInsx.4cU/v2hQq87EGzFvm', NULL, '0', 20, 'user', '1'),
(30, 'Sub Admin1', 'akhilk1904@gmail.com', '$2y$10$UFksQH4THZnbEoVCMmK/EOhhOut6/mY8cBfY9HDic5i1zP4Jt011y', NULL, '0', 20, 'user', '1'),
(37, 'q', 'ds@gmail.com', '$2y$10$.OEzJ77r11QV5J1SItGOBOizFDdmAsYt4tfliXHUuQP5mx9/kLxQO', NULL, '0', 18, 'user', '1'),
(38, 'w', 'w@gmail.com', '$2y$10$lLoAxzLatJ3nOULpjvkO/ufMFd5V3ZgL7eMKgN65HWdisGRyIjkum', NULL, '1', 1, 'admin', '1');

-- --------------------------------------------------------

--
-- Table structure for table `user_access`
--

CREATE TABLE `user_access` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `privillege_id` int DEFAULT NULL,
  `tournament_id` int DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_access`
--

INSERT INTO `user_access` (`id`, `user_id`, `privillege_id`, `tournament_id`, `type`, `created_at`, `updated_at`) VALUES
(32, 3, 1, NULL, 'privillege', '2024-03-07', '2024-03-07'),
(33, 3, 2, NULL, 'privillege', '2024-03-07', '2024-03-07'),
(34, 3, 3, NULL, 'privillege', '2024-03-07', '2024-03-07'),
(35, 3, 4, NULL, 'privillege', '2024-03-07', '2024-03-07'),
(36, 3, 5, NULL, 'privillege', '2024-03-07', '2024-03-07'),
(45, 5, 1, NULL, 'privillege', '2024-03-07', '2024-03-07'),
(46, 5, 2, NULL, 'privillege', '2024-03-07', '2024-03-07'),
(47, 5, 3, NULL, 'privillege', '2024-03-07', '2024-03-07'),
(48, 5, 5, NULL, 'privillege', '2024-03-07', '2024-03-07'),
(53, 4, 1, NULL, 'privillege', '2024-03-07', '2024-03-07'),
(54, 4, 2, NULL, 'privillege', '2024-03-07', '2024-03-07'),
(55, 4, 3, NULL, 'privillege', '2024-03-07', '2024-03-07'),
(56, 4, 4, NULL, 'privillege', '2024-03-07', '2024-03-07'),
(57, 4, 6, NULL, 'privillege', '2024-03-07', '2024-03-07'),
(63, 8, 61, NULL, 'privillege', '2024-03-07', '2024-03-07'),
(64, 8, 62, NULL, 'privillege', '2024-03-07', '2024-03-07'),
(65, 9, 61, NULL, 'privillege', '2024-03-07', '2024-03-07'),
(66, 9, 62, NULL, 'privillege', '2024-03-07', '2024-03-07'),
(69, 10, 1, NULL, 'privillege', '2024-03-07', '2024-03-07'),
(70, 10, 2, NULL, 'privillege', '2024-03-07', '2024-03-07'),
(71, 11, 1, NULL, 'privillege', '2024-03-07', '2024-03-07'),
(72, 11, 4, NULL, 'privillege', '2024-03-07', '2024-03-07'),
(73, 12, 2, NULL, 'privillege', '2024-03-12', '2024-03-12'),
(74, 14, 1, NULL, 'privillege', '2024-03-13', '2024-03-13'),
(75, 14, 4, NULL, 'privillege', '2024-03-13', '2024-03-13'),
(76, 15, 1, NULL, 'privillege', '2024-03-13', '2024-03-13'),
(77, 15, 4, NULL, 'privillege', '2024-03-13', '2024-03-13'),
(78, 16, 1, NULL, 'privillege', '2024-03-13', '2024-03-13'),
(79, 16, 4, NULL, 'privillege', '2024-03-13', '2024-03-13'),
(80, 17, 1, NULL, 'privillege', '2024-03-13', '2024-03-13'),
(81, 17, 4, NULL, 'privillege', '2024-03-13', '2024-03-13'),
(82, 18, NULL, 5, 'tournament', '2024-03-13', '2024-03-13'),
(83, 18, NULL, 9, 'tournament', '2024-03-13', '2024-03-13'),
(84, 18, 1, 9, 'privillege', '2024-03-13', '2024-03-13'),
(85, 18, 4, 9, 'privillege', '2024-03-13', '2024-03-13'),
(86, 19, NULL, 4, 'tournament', '2024-03-14', '2024-03-14'),
(87, 19, NULL, 11, 'tournament', '2024-03-14', '2024-03-14'),
(90, 19, 1, NULL, 'privillege', '2024-03-14', '2024-03-14'),
(91, 19, 4, NULL, 'privillege', '2024-03-14', '2024-03-14'),
(92, 20, NULL, 4, 'tournament', '2024-03-14', '2024-03-14'),
(93, 20, NULL, 15, 'tournament', '2024-03-14', '2024-03-14'),
(94, 20, NULL, 8, 'tournament', '2024-03-14', '2024-03-14'),
(95, 20, NULL, 11, 'tournament', '2024-03-14', '2024-03-14'),
(96, 21, NULL, 8, 'tournament', '2024-03-14', '2024-03-14'),
(97, 21, NULL, 10, 'tournament', '2024-03-14', '2024-03-14'),
(98, 21, NULL, 11, 'tournament', '2024-03-14', '2024-03-14'),
(101, 21, 1, NULL, 'privillege', '2024-03-14', '2024-03-14'),
(102, 21, 4, NULL, 'privillege', '2024-03-14', '2024-03-14'),
(103, 21, NULL, 4, 'tournament', '2024-03-14', '2024-03-14'),
(104, 21, NULL, 7, 'tournament', '2024-03-14', '2024-03-14'),
(105, 21, NULL, 8, 'tournament', '2024-03-14', '2024-03-14'),
(106, 21, NULL, 11, 'tournament', '2024-03-14', '2024-03-14'),
(107, 22, NULL, 4, 'tournament', '2024-03-14', '2024-03-14'),
(108, 22, NULL, 6, 'tournament', '2024-03-14', '2024-03-14'),
(109, 22, NULL, 7, 'tournament', '2024-03-14', '2024-03-14'),
(110, 22, NULL, 8, 'tournament', '2024-03-14', '2024-03-14'),
(111, 22, NULL, 2, 'tournament', '2024-03-14', '2024-03-14'),
(112, 22, NULL, 9, 'tournament', '2024-03-14', '2024-03-14'),
(113, 22, NULL, 11, 'tournament', '2024-03-14', '2024-03-14'),
(114, 22, 1, NULL, 'privillege', '2024-03-14', '2024-03-14'),
(115, 22, 4, NULL, 'privillege', '2024-03-14', '2024-03-14'),
(116, 23, NULL, 4, 'tournament', '2024-03-14', '2024-03-14'),
(117, 23, NULL, 15, 'tournament', '2024-03-14', '2024-03-14'),
(118, 23, NULL, 11, 'tournament', '2024-03-14', '2024-03-14'),
(123, 23, NULL, 4, 'tournament', '2024-03-14', '2024-03-14'),
(124, 23, NULL, 15, 'tournament', '2024-03-14', '2024-03-14'),
(125, 23, NULL, 11, 'tournament', '2024-03-14', '2024-03-14'),
(126, 23, 1, NULL, 'privillege', '2024-03-14', '2024-03-14'),
(127, 23, 4, NULL, 'privillege', '2024-03-14', '2024-03-14'),
(128, 23, NULL, 4, 'tournament', '2024-03-14', '2024-03-14'),
(129, 23, NULL, 15, 'tournament', '2024-03-14', '2024-03-14'),
(130, 23, NULL, 11, 'tournament', '2024-03-14', '2024-03-14'),
(131, 24, NULL, 3, 'tournament', '2024-03-14', '2024-03-14'),
(132, 24, NULL, 4, 'tournament', '2024-03-14', '2024-03-14'),
(133, 24, NULL, 9, 'tournament', '2024-03-14', '2024-03-14'),
(134, 24, NULL, 12, 'tournament', '2024-03-14', '2024-03-14'),
(135, 24, 1, NULL, 'privillege', '2024-03-14', '2024-03-14'),
(136, 24, 4, NULL, 'privillege', '2024-03-14', '2024-03-14'),
(151, 25, 1, NULL, 'privillege', '2024-03-15', '2024-03-15'),
(152, 25, 2, NULL, 'privillege', '2024-03-15', '2024-03-15'),
(153, 25, NULL, 3, 'tournament', '2024-03-15', '2024-03-15'),
(154, 26, NULL, 3, 'tournament', '2024-03-15', '2024-03-15'),
(155, 26, NULL, 5, 'tournament', '2024-03-15', '2024-03-15'),
(165, 1, 1, NULL, 'privillege', '2024-03-18', '2024-03-18'),
(166, 1, 2, NULL, 'privillege', '2024-03-18', '2024-03-18'),
(167, 1, 3, NULL, 'privillege', '2024-03-18', '2024-03-18'),
(168, 1, NULL, 17, 'tournament', '2024-03-18', '2024-03-18'),
(187, 27, 2, NULL, 'privillege', '2024-03-18', '2024-03-18'),
(188, 27, 3, NULL, 'privillege', '2024-03-18', '2024-03-18'),
(189, 2, 6, NULL, 'privillege', '2024-03-18', '2024-03-18'),
(190, 2, NULL, 17, 'tournament', '2024-03-18', '2024-03-18'),
(191, 2, NULL, 15, 'tournament', '2024-03-18', '2024-03-18'),
(193, 28, 1, NULL, 'privillege', '2024-03-18', '2024-03-18'),
(194, 28, 2, NULL, 'privillege', '2024-03-18', '2024-03-18'),
(195, 28, 3, NULL, 'privillege', '2024-03-18', '2024-03-18'),
(201, 29, 1, NULL, 'privillege', '2024-03-18', '2024-03-18'),
(202, 29, 2, NULL, 'privillege', '2024-03-18', '2024-03-18'),
(203, 29, 3, NULL, 'privillege', '2024-03-18', '2024-03-18'),
(204, 29, NULL, 17, 'tournament', '2024-03-18', '2024-03-18'),
(270, 30, 2, NULL, 'privillege', '2024-03-19', '2024-03-19'),
(271, 30, 3, NULL, 'privillege', '2024-03-19', '2024-03-19'),
(276, 30, NULL, 17, 'tournament', '2024-03-19', '2024-03-19'),
(277, 30, NULL, 3, 'tournament', '2024-03-19', '2024-03-19'),
(278, 30, NULL, 5, 'tournament', '2024-03-19', '2024-03-19'),
(300, 37, 1, NULL, 'privillege', '2024-03-19', '2024-03-19'),
(301, 37, 2, NULL, 'privillege', '2024-03-19', '2024-03-19'),
(305, 37, NULL, 3, 'tournament', '2024-03-19', '2024-03-19'),
(307, 37, NULL, 11, 'tournament', '2024-03-19', '2024-03-19'),
(318, 38, 1, NULL, 'privillege', '2024-03-26', '2024-03-26'),
(319, 38, 2, NULL, 'privillege', '2024-03-26', '2024-03-26'),
(320, 38, NULL, 3, 'tournament', '2024-03-26', '2024-03-26'),
(321, 38, NULL, 2, 'tournament', '2024-03-26', '2024-03-26');

-- --------------------------------------------------------

--
-- Table structure for table `user_form`
--

CREATE TABLE `user_form` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `form_id` int DEFAULT NULL,
  `tournament_id` int DEFAULT NULL,
  `status` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_form`
--

INSERT INTO `user_form` (`id`, `user_id`, `form_id`, `tournament_id`, `status`, `created_at`, `updated_at`) VALUES
(59, 37, 2, 3, '1', '2024-03-19', '2024-03-19'),
(65, 37, 3, 3, '1', '2024-03-19', '2024-03-19'),
(66, 37, 2, 11, '1', '2024-03-19', '2024-03-19'),
(67, 37, 3, 11, '1', '2024-03-19', '2024-03-19'),
(68, 38, 1, 3, '1', '2024-03-26', '2024-03-26'),
(70, 38, 1, 2, '1', '2024-03-26', '2024-03-26'),
(72, 38, 3, 3, '1', '2024-03-26', '2024-03-26'),
(73, 38, 3, 2, '1', '2024-03-26', '2024-03-26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `form_master`
--
ALTER TABLE `form_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_questions`
--
ALTER TABLE `form_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_questions_types`
--
ALTER TABLE `form_questions_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_questions_values`
--
ALTER TABLE `form_questions_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_question_rules`
--
ALTER TABLE `form_question_rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_question_sections`
--
ALTER TABLE `form_question_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `privillege_master`
--
ALTER TABLE `privillege_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_access`
--
ALTER TABLE `role_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_master`
--
ALTER TABLE `role_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tournament_master`
--
ALTER TABLE `tournament_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_access`
--
ALTER TABLE `user_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_form`
--
ALTER TABLE `user_form`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `form_master`
--
ALTER TABLE `form_master`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `form_questions`
--
ALTER TABLE `form_questions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `form_questions_types`
--
ALTER TABLE `form_questions_types`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `form_questions_values`
--
ALTER TABLE `form_questions_values`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `form_question_rules`
--
ALTER TABLE `form_question_rules`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `form_question_sections`
--
ALTER TABLE `form_question_sections`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `privillege_master`
--
ALTER TABLE `privillege_master`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `role_access`
--
ALTER TABLE `role_access`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `role_master`
--
ALTER TABLE `role_master`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tournament_master`
--
ALTER TABLE `tournament_master`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `user_access`
--
ALTER TABLE `user_access`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=322;

--
-- AUTO_INCREMENT for table `user_form`
--
ALTER TABLE `user_form`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 31, 2019 at 10:32 AM
-- Server version: 5.7.26-0ubuntu0.18.04.1
-- PHP Version: 7.3.4-1+ubuntu18.04.1+deb.sury.org+3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravelQuiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `average_scores`
--

CREATE TABLE `average_scores` (
  `avgid` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `quiz_id` int(10) UNSIGNED NOT NULL,
  `avg_score` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `appear_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `average_scores`
--

INSERT INTO `average_scores` (`avgid`, `user_id`, `quiz_id`, `avg_score`, `created_at`, `updated_at`, `appear_count`) VALUES
(1, 1, 2, '0.64', '2019-05-27 09:33:06', '2019-05-28 08:04:33', 14),
(3, 1, 3, '2.17', '2019-05-27 11:23:28', '2019-05-27 12:31:18', 6),
(4, 3, 3, '4.00', '2019-05-27 12:45:03', '2019-05-27 12:45:56', 2),
(6, 2, 2, '2.00', '2019-05-28 09:43:57', '2019-05-28 09:47:33', 2);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_05_06_062638_create_quizzes_table', 1),
(4, '2019_05_06_062705_create_questions_table', 1),
(5, '2019_05_07_132644_add_question_duration_column', 1),
(6, '2019_05_09_120204_add_total_question_in_quiz', 1),
(7, '2019_05_11_123740_create_quiz_appears_table', 1),
(8, '2019_05_11_124112_create_user_responses_table', 1),
(9, '2019_05_24_104643_create_average_scores_table', 1),
(10, '2019_05_24_123457_add__column_no_of_times_appeared', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('b@b.com', '$2y$10$bfXVKBvyqvqNQnjBLc7B..Wn3Z68Zu2eAoYivrZBTlHgJQpkbXE0q', '2019-05-27 12:08:14');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `questionid` int(10) UNSIGNED NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_type` enum('mcq','tf','fib') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'mcq',
  `option_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `option_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `option_3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `option_4` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `answer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quiz_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `question_duration` int(11) NOT NULL DEFAULT '300'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`questionid`, `question`, `question_type`, `option_1`, `option_2`, `option_3`, `option_4`, `answer`, `quiz_id`, `user_id`, `created_at`, `updated_at`, `question_duration`) VALUES
(6, '43-24 = __', 'fib', NULL, NULL, NULL, NULL, '19', 2, 3, '2019-05-24 10:59:53', '2019-05-24 10:59:53', 200),
(7, '33-17 = 16', 'tf', NULL, NULL, NULL, NULL, '1', 2, 3, '2019-05-24 11:00:27', '2019-05-24 11:00:27', 200),
(8, '197-56-45 = 86', 'tf', NULL, NULL, NULL, NULL, '0', 2, 3, '2019-05-24 11:01:06', '2019-05-24 11:01:06', 200),
(9, '459-32-23-43-145 = __', 'fib', NULL, NULL, NULL, NULL, '216', 2, 3, '2019-05-24 11:02:57', '2019-05-24 11:02:57', 200),
(10, '5+(5*6/2)-8 = __', 'fib', NULL, NULL, NULL, NULL, '12', 3, 2, '2019-05-24 11:46:11', '2019-05-24 11:46:11', 200),
(11, '45 + 45 +90 - 67 - 67 = 66', 'tf', NULL, NULL, NULL, NULL, '0', 3, 2, '2019-05-24 11:47:13', '2019-05-24 11:47:13', 25),
(12, '45+65+43-67 = __', 'fib', NULL, NULL, NULL, NULL, '86', 3, 2, '2019-05-24 11:47:49', '2019-05-24 11:47:49', 23),
(13, '43+65+76-55 = __', 'fib', NULL, NULL, NULL, NULL, '129', 3, 2, '2019-05-24 11:49:15', '2019-05-24 11:49:15', 28),
(14, '4+7', 'mcq', '10', '11', '12', '32', '11', 3, 2, '2019-05-27 11:22:45', '2019-05-27 11:22:45', 10);

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `quizid` int(10) UNSIGNED NOT NULL,
  `permitted` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_of_questions` smallint(6) NOT NULL DEFAULT '5',
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `total_questions` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`quizid`, `permitted`, `title`, `no_of_questions`, `user_id`, `created_at`, `updated_at`, `total_questions`) VALUES
(2, 1, 'Subtraction', 4, 3, '2019-05-24 10:59:18', '2019-05-24 10:59:18', 4),
(3, 1, 'Algebric', 4, 2, '2019-05-24 11:45:30', '2019-05-24 11:45:30', 5),
(5, 0, 'sfg', 2, 5, '2019-05-24 11:52:46', '2019-05-24 11:52:46', 0),
(6, 0, 'fvgfg', 2, 1, '2019-05-30 12:28:26', '2019-05-30 12:28:26', 0),
(7, 0, 'fghgfhfgh', 2, 1, '2019-05-31 04:56:34', '2019-05-31 04:56:34', 0),
(8, 0, 'bfdgfdfgddffsdfsfsdffdsfsdfsdfsf', 2, 1, '2019-05-31 04:56:45', '2019-05-31 04:56:45', 0);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_appears`
--

CREATE TABLE `quiz_appears` (
  `quizappearid` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `marks_scored` decimal(5,2) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `quiz_id` int(10) UNSIGNED NOT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quiz_appears`
--

INSERT INTO `quiz_appears` (`quizappearid`, `created_at`, `updated_at`, `marks_scored`, `user_id`, `quiz_id`, `user_name`) VALUES
(1, '2019-05-27 09:32:17', '2019-05-27 09:32:17', '0.00', 1, 2, 'Bhavik'),
(2, '2019-05-27 09:52:25', '2019-05-27 09:52:25', '0.00', 1, 2, 'Bhavik'),
(3, '2019-05-27 10:00:46', '2019-05-27 10:00:46', '0.00', 1, 2, 'Bhavik'),
(4, '2019-05-27 10:08:27', '2019-05-27 10:08:27', '0.00', 1, 2, 'Bhavik'),
(7, '2019-05-27 11:23:17', '2019-05-27 11:23:17', '1.00', 1, 3, 'Bhavik'),
(8, '2019-05-27 11:26:03', '2019-05-27 11:26:03', '0.00', 1, 3, 'Bhavik'),
(9, '2019-05-27 11:26:49', '2019-05-27 11:26:49', '1.00', 1, 3, 'Bhavik'),
(10, '2019-05-27 11:31:04', '2019-05-27 11:31:04', '1.00', 1, 3, 'Bhavik'),
(11, '2019-05-27 11:59:13', '2019-05-27 11:59:13', '0.00', 1, 2, 'Bhavik'),
(12, '2019-05-27 12:29:11', '2019-05-27 12:29:11', '5.00', 1, 3, 'Bhavik'),
(13, '2019-05-27 12:30:58', '2019-05-27 12:30:58', '5.00', 1, 3, 'Bhavik'),
(14, '2019-05-27 12:44:46', '2019-05-27 12:44:46', '3.00', 3, 3, 'Foram'),
(15, '2019-05-27 12:45:34', '2019-05-27 12:45:34', '5.00', 3, 3, 'Foram'),
(17, '2019-05-28 04:33:49', '2019-05-28 04:33:49', '1.00', 1, 2, 'Bhavik'),
(18, '2019-05-28 04:33:50', '2019-05-28 04:33:50', '3.00', 1, 2, 'Bhavik'),
(19, '2019-05-28 05:07:50', '2019-05-28 05:07:50', '0.00', 1, 2, 'Bhavik'),
(20, '2019-05-28 05:09:45', '2019-05-28 05:09:45', '0.00', 1, 2, 'Bhavik'),
(21, '2019-05-28 05:15:16', '2019-05-28 05:15:16', '0.00', 1, 2, 'Bhavik'),
(22, '2019-05-28 05:19:13', '2019-05-28 05:19:13', '0.00', 1, 2, 'Bhavik'),
(23, '2019-05-28 05:33:56', '2019-05-28 05:33:56', '0.00', 1, 2, 'Bhavik'),
(24, '2019-05-28 07:25:12', '2019-05-28 07:25:12', '3.00', 1, 2, 'Bhavik'),
(25, '2019-05-28 08:04:20', '2019-05-28 08:04:20', '2.00', 1, 2, 'Bhavik'),
(28, '2019-05-28 09:43:12', '2019-05-28 09:43:12', '4.00', 2, 2, 'Happy'),
(29, '2019-05-28 09:47:24', '2019-05-28 09:47:24', '0.00', 2, 2, 'Happy'),
(30, '2019-05-28 11:58:03', '2019-05-28 11:58:03', '0.00', 1, 2, 'Bhavik'),
(31, '2019-05-28 13:37:51', '2019-05-28 13:37:51', '0.00', 1, 2, 'Bhavik');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Bhavik', 'b@b.com', NULL, '$2y$10$wTGR6TfeqsRQYp7JPZiBQePnHDAP2JfxW6OLlxIsqUV.Asdoq2L4W', NULL, '2019-05-24 05:25:39', '2019-05-24 05:25:39'),
(2, 'Happy', 'h@h.com', NULL, '$2y$10$ZUZtellU.2eBD4X0AKiWhOtoAyXG55aIXTmB3eDkjoq6mN4sKTOOu', NULL, '2019-05-24 05:25:55', '2019-05-24 05:25:55'),
(3, 'Foram', 'f@f.com', NULL, '$2y$10$Lv4Q9ppbkw5pmj0r4xvbeOuc5ZbdgPKJ2h09ifvDudQyBcOG9Kyw6', NULL, '2019-05-24 05:26:09', '2019-05-24 05:26:09'),
(4, 'Raj', 'r@r.com', NULL, '$2y$10$zNi39EK1A9i1TETmvMe.OOpUH.L/FsEbQ/eEuLm0m1AmZZcosdXkW', NULL, '2019-05-24 09:33:55', '2019-05-24 09:33:55'),
(5, 'Vivek', 'v@v.com', NULL, '$2y$10$1hskjcjSrckF5B0Rk7tNpe7NEs6kdJVSvVqRUPJ7Vonz1qlHNO60S', NULL, '2019-05-24 09:34:26', '2019-05-24 09:34:26'),
(6, 'Swati', 's@s.com', NULL, '$2y$10$3enET8kU.SQnq.63frX8vucvQqoSPO0RGCduHitNk5TppqMInkugK', NULL, '2019-05-30 06:15:53', '2019-05-30 06:15:53');

-- --------------------------------------------------------

--
-- Table structure for table `user_responses`
--

CREATE TABLE `user_responses` (
  `responseid` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `userData_appear` int(10) UNSIGNED NOT NULL,
  `quiz_id` int(10) UNSIGNED NOT NULL,
  `question_id` int(10) UNSIGNED NOT NULL,
  `user_response` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correct` tinyint(1) NOT NULL DEFAULT '0',
  `time_taken` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_responses`
--

INSERT INTO `user_responses` (`responseid`, `user_id`, `userData_appear`, `quiz_id`, `question_id`, `user_response`, `correct`, `time_taken`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 6, 'Not Answered', 0, 10, '2019-05-27 09:32:17', '2019-05-27 09:32:17'),
(2, 1, 1, 2, 7, 'Not Answered', 0, 8, '2019-05-27 09:32:25', '2019-05-27 09:32:25'),
(3, 1, 1, 2, 8, 'Not Answered', 0, 15, '2019-05-27 09:32:41', '2019-05-27 09:32:41'),
(4, 1, 1, 2, 9, 'Not Answered', 0, 25, '2019-05-27 09:33:06', '2019-05-27 09:33:06'),
(5, 1, 1, 2, 9, 'Not Answered', 0, 25, '2019-05-27 09:33:52', '2019-05-27 09:33:52'),
(6, 1, 1, 2, 9, 'Not Answered', 0, 25, '2019-05-27 09:36:08', '2019-05-27 09:36:08'),
(7, 1, 2, 2, 6, 'Not Answered', 0, 10, '2019-05-27 09:52:25', '2019-05-27 09:52:25'),
(8, 1, 2, 2, 7, 'Not Answered', 0, 8, '2019-05-27 09:52:43', '2019-05-27 09:52:43'),
(9, 1, 2, 2, 8, 'Not Answered', 0, 15, '2019-05-27 09:53:09', '2019-05-27 09:53:09'),
(10, 1, 2, 2, 9, 'Not Answered', 0, 25, '2019-05-27 09:53:58', '2019-05-27 09:53:58'),
(11, 1, 2, 2, 9, 'Not Answered', 0, 25, '2019-05-27 09:56:16', '2019-05-27 09:56:16'),
(12, 1, 2, 2, 9, 'Not Answered', 0, 25, '2019-05-27 09:56:59', '2019-05-27 09:56:59'),
(13, 1, 2, 2, 9, 'Not Answered', 0, 25, '2019-05-27 09:57:39', '2019-05-27 09:57:39'),
(14, 1, 2, 2, 9, 'Not Answered', 0, 25, '2019-05-27 09:59:53', '2019-05-27 09:59:53'),
(15, 1, 2, 2, 9, 'Not Answered', 0, 25, '2019-05-27 10:00:18', '2019-05-27 10:00:18'),
(16, 1, 2, 2, 9, 'Not Answered', 0, 25, '2019-05-27 10:00:20', '2019-05-27 10:00:20'),
(17, 1, 3, 2, 6, 'Not Answered', 0, 10, '2019-05-27 10:00:46', '2019-05-27 10:00:46'),
(18, 1, 3, 2, 7, 'Not Answered', 0, 8, '2019-05-27 10:00:55', '2019-05-27 10:00:55'),
(19, 1, 3, 2, 8, 'Not Answered', 0, 15, '2019-05-27 10:01:22', '2019-05-27 10:01:22'),
(20, 1, 3, 2, 9, 'Not Answered', 0, 25, '2019-05-27 10:01:48', '2019-05-27 10:01:48'),
(21, 1, 3, 2, 9, 'Not Answered', 0, 25, '2019-05-27 10:04:12', '2019-05-27 10:04:12'),
(22, 1, 3, 2, 9, 'Not Answered', 0, 25, '2019-05-27 10:06:26', '2019-05-27 10:06:26'),
(23, 1, 3, 2, 9, 'Not Answered', 0, 25, '2019-05-27 10:06:27', '2019-05-27 10:06:27'),
(24, 1, 3, 2, 9, 'Not Answered', 0, 25, '2019-05-27 10:06:55', '2019-05-27 10:06:55'),
(25, 1, 4, 2, 6, 'Not Answered', 0, 10, '2019-05-27 10:08:27', '2019-05-27 10:08:27'),
(26, 1, 4, 2, 7, 'Not Answered', 0, 8, '2019-05-27 10:08:35', '2019-05-27 10:08:35'),
(27, 1, 4, 2, 8, 'Not Answered', 0, 15, '2019-05-27 10:08:51', '2019-05-27 10:08:51'),
(40, 1, 7, 3, 10, 'Not Answered', 0, 7, '2019-05-27 11:23:17', '2019-05-27 11:23:17'),
(41, 1, 7, 3, 11, '1', 0, 3, '2019-05-27 11:23:20', '2019-05-27 11:23:20'),
(42, 1, 7, 3, 12, 'Not Answered', 0, 1, '2019-05-27 11:23:22', '2019-05-27 11:23:22'),
(43, 1, 7, 3, 13, 'Not Answered', 0, 1, '2019-05-27 11:23:24', '2019-05-27 11:23:24'),
(44, 1, 7, 3, 14, '11', 1, 4, '2019-05-27 11:23:28', '2019-05-27 11:23:28'),
(45, 1, 8, 3, 10, 'tht', 0, 3, '2019-05-27 11:26:03', '2019-05-27 11:26:03'),
(46, 1, 8, 3, 11, '1', 0, 1, '2019-05-27 11:26:05', '2019-05-27 11:26:05'),
(47, 1, 8, 3, 12, 'rg', 0, 1, '2019-05-27 11:26:07', '2019-05-27 11:26:07'),
(48, 1, 8, 3, 13, 'gr', 0, 1, '2019-05-27 11:26:08', '2019-05-27 11:26:08'),
(49, 1, 9, 3, 10, 'rt', 0, 2, '2019-05-27 11:26:50', '2019-05-27 11:26:50'),
(50, 1, 9, 3, 11, '1', 0, 2, '2019-05-27 11:26:52', '2019-05-27 11:26:52'),
(51, 1, 9, 3, 12, 'gtrr', 0, 1, '2019-05-27 11:26:54', '2019-05-27 11:26:54'),
(52, 1, 9, 3, 13, 'gg', 0, 1, '2019-05-27 11:26:56', '2019-05-27 11:26:56'),
(53, 1, 9, 3, 14, '11', 1, 5, '2019-05-27 11:27:02', '2019-05-27 11:27:02'),
(54, 1, 10, 3, 10, 'Not Answered', 0, 20, '2019-05-27 11:31:04', '2019-05-27 11:31:04'),
(55, 1, 10, 3, 11, 'Not Answered', 0, 25, '2019-05-27 11:31:31', '2019-05-27 11:31:31'),
(56, 1, 10, 3, 12, 'Not Answered', 0, 23, '2019-05-27 11:31:55', '2019-05-27 11:31:55'),
(57, 1, 10, 3, 13, 'Not Answered', 0, 28, '2019-05-27 11:32:25', '2019-05-27 11:32:25'),
(58, 1, 10, 3, 14, '11', 1, 10, '2019-05-27 11:33:15', '2019-05-27 11:33:15'),
(59, 1, 11, 2, 6, 'Not Answered', 0, 10, '2019-05-27 11:59:13', '2019-05-27 11:59:13'),
(60, 1, 11, 2, 7, 'Not Answered', 0, 8, '2019-05-27 11:59:29', '2019-05-27 11:59:29'),
(61, 1, 11, 2, 8, 'Not Answered', 0, 15, '2019-05-27 11:59:54', '2019-05-27 11:59:54'),
(62, 1, 11, 2, 9, 'Not Answered', 0, 25, '2019-05-27 12:00:21', '2019-05-27 12:00:21'),
(63, 1, 11, 2, 9, 'Not Answered', 0, 25, '2019-05-27 12:03:41', '2019-05-27 12:03:41'),
(64, 1, 12, 3, 10, '12', 1, 6, '2019-05-27 12:29:11', '2019-05-27 12:29:11'),
(65, 1, 12, 3, 11, '0', 1, 22, '2019-05-27 12:29:35', '2019-05-27 12:29:35'),
(66, 1, 12, 3, 12, '86', 1, 12, '2019-05-27 12:29:48', '2019-05-27 12:29:48'),
(67, 1, 12, 3, 13, '129', 1, 15, '2019-05-27 12:30:04', '2019-05-27 12:30:04'),
(68, 1, 12, 3, 14, '11', 1, 5, '2019-05-27 12:30:10', '2019-05-27 12:30:10'),
(69, 1, 13, 3, 10, '12', 1, 8, '2019-05-27 12:30:58', '2019-05-27 12:30:58'),
(70, 1, 13, 3, 11, '0', 1, 2, '2019-05-27 12:31:00', '2019-05-27 12:31:00'),
(71, 1, 13, 3, 12, '86', 1, 6, '2019-05-27 12:31:07', '2019-05-27 12:31:07'),
(72, 1, 13, 3, 13, '129', 1, 7, '2019-05-27 12:31:15', '2019-05-27 12:31:15'),
(73, 1, 13, 3, 14, '11', 1, 1, '2019-05-27 12:31:18', '2019-05-27 12:31:18'),
(74, 3, 14, 3, 10, '12', 1, 4, '2019-05-27 12:44:46', '2019-05-27 12:44:46'),
(75, 3, 14, 3, 11, '0', 1, 2, '2019-05-27 12:44:49', '2019-05-27 12:44:49'),
(76, 3, 14, 3, 12, '332', 0, 3, '2019-05-27 12:44:53', '2019-05-27 12:44:53'),
(77, 3, 14, 3, 13, '323', 0, 2, '2019-05-27 12:44:57', '2019-05-27 12:44:57'),
(78, 3, 14, 3, 14, '11', 1, 5, '2019-05-27 12:45:03', '2019-05-27 12:45:03'),
(79, 3, 15, 3, 10, '12', 1, 7, '2019-05-27 12:45:34', '2019-05-27 12:45:34'),
(80, 3, 15, 3, 11, '0', 1, 2, '2019-05-27 12:45:37', '2019-05-27 12:45:37'),
(81, 3, 15, 3, 12, '86', 1, 7, '2019-05-27 12:45:45', '2019-05-27 12:45:45'),
(82, 3, 15, 3, 13, '129', 1, 8, '2019-05-27 12:45:54', '2019-05-27 12:45:54'),
(83, 3, 15, 3, 14, '11', 1, 1, '2019-05-27 12:45:56', '2019-05-27 12:45:56'),
(85, 1, 17, 2, 6, '19', 1, 9, '2019-05-28 04:33:50', '2019-05-28 04:33:50'),
(86, 1, 18, 2, 6, '19', 1, 10, '2019-05-28 04:33:50', '2019-05-28 04:33:50'),
(87, 1, 18, 2, 7, '1', 1, 6, '2019-05-28 04:33:57', '2019-05-28 04:33:57'),
(88, 1, 18, 2, 8, '0', 1, 8, '2019-05-28 04:34:06', '2019-05-28 04:34:06'),
(89, 1, 18, 2, 9, '543', 0, 6, '2019-05-28 04:34:13', '2019-05-28 04:34:13'),
(90, 1, 19, 2, 6, 'Not Answered', 0, 10, '2019-05-28 05:07:50', '2019-05-28 05:07:50'),
(91, 1, 19, 2, 7, 'Not Answered', 0, 8, '2019-05-28 05:07:59', '2019-05-28 05:07:59'),
(92, 1, 19, 2, 8, 'Not Answered', 0, 15, '2019-05-28 05:08:26', '2019-05-28 05:08:26'),
(93, 1, 20, 2, 6, 'Not Answered', 0, 10, '2019-05-28 05:09:45', '2019-05-28 05:09:45'),
(94, 1, 20, 2, 7, 'Not Answered', 0, 8, '2019-05-28 05:09:53', '2019-05-28 05:09:53'),
(95, 1, 20, 2, 8, 'Not Answered', 0, 15, '2019-05-28 05:10:09', '2019-05-28 05:10:09'),
(96, 1, 20, 2, 9, 'Not Answered', 0, 25, '2019-05-28 05:10:34', '2019-05-28 05:10:34'),
(97, 1, 21, 2, 6, 'Not Answered', 0, 10, '2019-05-28 05:15:16', '2019-05-28 05:15:16'),
(98, 1, 21, 2, 7, 'Not Answered', 0, 8, '2019-05-28 05:15:24', '2019-05-28 05:15:24'),
(99, 1, 21, 2, 8, 'Not Answered', 0, 15, '2019-05-28 05:15:39', '2019-05-28 05:15:39'),
(100, 1, 21, 2, 9, 'Not Answered', 0, 25, '2019-05-28 05:17:57', '2019-05-28 05:17:57'),
(101, 1, 22, 2, 6, 'Not Answered', 0, 10, '2019-05-28 05:19:13', '2019-05-28 05:19:13'),
(102, 1, 22, 2, 7, 'Not Answered', 0, 8, '2019-05-28 05:19:24', '2019-05-28 05:19:24'),
(103, 1, 22, 2, 8, 'Not Answered', 0, 15, '2019-05-28 05:20:05', '2019-05-28 05:20:05'),
(104, 1, 22, 2, 9, 'Not Answered', 0, 200, '2019-05-28 05:20:32', '2019-05-28 05:20:32'),
(105, 1, 23, 2, 6, 'Not Answered', 0, 6, '2019-05-28 05:33:56', '2019-05-28 05:33:56'),
(106, 1, 23, 2, 7, 'Not Answered', 0, 2, '2019-05-28 05:33:59', '2019-05-28 05:33:59'),
(107, 1, 23, 2, 8, 'Not Answered', 0, 3, '2019-05-28 05:34:08', '2019-05-28 05:34:08'),
(108, 1, 23, 2, 9, 'Not Answered', 0, 1, '2019-05-28 05:34:10', '2019-05-28 05:34:10'),
(109, 1, 24, 2, 6, '19', 1, 15, '2019-05-28 07:25:12', '2019-05-28 07:25:12'),
(110, 1, 24, 2, 7, '1', 1, 7, '2019-05-28 07:25:20', '2019-05-28 07:25:20'),
(111, 1, 24, 2, 8, '0', 1, 24, '2019-05-28 07:25:45', '2019-05-28 07:25:45'),
(112, 1, 24, 2, 9, '656', 0, 46, '2019-05-28 07:26:33', '2019-05-28 07:26:33'),
(113, 1, 25, 2, 6, 'g', 0, 7, '2019-05-28 08:04:20', '2019-05-28 08:04:20'),
(114, 1, 25, 2, 7, '1', 1, 1, '2019-05-28 08:04:22', '2019-05-28 08:04:22'),
(115, 1, 25, 2, 8, '0', 1, 1, '2019-05-28 08:04:24', '2019-05-28 08:04:24'),
(116, 1, 25, 2, 9, 'j', 0, 8, '2019-05-28 08:04:33', '2019-05-28 08:04:33'),
(127, 2, 28, 2, 6, '19', 1, 7, '2019-05-28 09:43:12', '2019-05-28 09:43:12'),
(128, 2, 28, 2, 7, '1', 1, 8, '2019-05-28 09:43:21', '2019-05-28 09:43:21'),
(129, 2, 28, 2, 8, '0', 1, 29, '2019-05-28 09:43:51', '2019-05-28 09:43:51'),
(130, 2, 28, 2, 9, '216', 1, 5, '2019-05-28 09:43:57', '2019-05-28 09:43:57'),
(131, 2, 29, 2, 6, '55', 0, 2, '2019-05-28 09:47:24', '2019-05-28 09:47:24'),
(132, 2, 29, 2, 7, '0', 0, 2, '2019-05-28 09:47:27', '2019-05-28 09:47:27'),
(133, 2, 29, 2, 8, '1', 0, 3, '2019-05-28 09:47:30', '2019-05-28 09:47:30'),
(134, 2, 29, 2, 9, '554', 0, 2, '2019-05-28 09:47:33', '2019-05-28 09:47:33'),
(135, 1, 30, 2, 6, 'Not Answered', 0, 23, '2019-05-28 11:58:03', '2019-05-28 11:58:03'),
(136, 1, 31, 2, 6, 'fgdd', 0, 3, '2019-05-28 13:37:51', '2019-05-28 13:37:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `average_scores`
--
ALTER TABLE `average_scores`
  ADD PRIMARY KEY (`avgid`),
  ADD KEY `average_scores_user_id_foreign` (`user_id`),
  ADD KEY `average_scores_quiz_id_foreign` (`quiz_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`questionid`),
  ADD KEY `questions_quiz_id_index` (`quiz_id`),
  ADD KEY `questions_user_id_foreign` (`user_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`quizid`),
  ADD KEY `quizzes_user_id_foreign` (`user_id`);

--
-- Indexes for table `quiz_appears`
--
ALTER TABLE `quiz_appears`
  ADD PRIMARY KEY (`quizappearid`),
  ADD KEY `quiz_appears_user_id_foreign` (`user_id`),
  ADD KEY `quiz_appears_quiz_id_foreign` (`quiz_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_responses`
--
ALTER TABLE `user_responses`
  ADD PRIMARY KEY (`responseid`),
  ADD KEY `user_responses_user_id_foreign` (`user_id`),
  ADD KEY `user_responses_quiz_id_foreign` (`quiz_id`),
  ADD KEY `user_responses_question_id_foreign` (`question_id`),
  ADD KEY `user_responses_userdata_appear_foreign` (`userData_appear`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `average_scores`
--
ALTER TABLE `average_scores`
  MODIFY `avgid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `questionid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `quizid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `quiz_appears`
--
ALTER TABLE `quiz_appears`
  MODIFY `quizappearid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `user_responses`
--
ALTER TABLE `user_responses`
  MODIFY `responseid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `average_scores`
--
ALTER TABLE `average_scores`
  ADD CONSTRAINT `average_scores_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`quizid`) ON DELETE CASCADE,
  ADD CONSTRAINT `average_scores_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`quizid`),
  ADD CONSTRAINT `questions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_appears`
--
ALTER TABLE `quiz_appears`
  ADD CONSTRAINT `quiz_appears_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`quizid`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_appears_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_responses`
--
ALTER TABLE `user_responses`
  ADD CONSTRAINT `user_responses_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`questionid`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_responses_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`quizid`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_responses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_responses_userdata_appear_foreign` FOREIGN KEY (`userData_appear`) REFERENCES `quiz_appears` (`quizappearid`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

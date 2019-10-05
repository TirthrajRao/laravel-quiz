-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 05, 2019 at 03:58 PM
-- Server version: 5.7.27-0ubuntu0.18.04.1
-- PHP Version: 7.2.19-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel`
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
(1, 16, 81, '2.00', '2019-09-05 07:46:41', '2019-09-05 07:46:41', 1),
(2, 16, 82, '2.00', '2019-09-05 07:52:23', '2019-09-05 07:52:23', 1),
(3, 16, 83, '6.00', '2019-09-05 08:00:37', '2019-09-05 08:00:37', 1);

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
(10, '2019_05_24_123457_add__column_no_of_times_appeared', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 'asas', 'tf', NULL, NULL, NULL, NULL, '1', 82, 1, '2019-09-03 08:12:08', '2019-09-03 08:12:08', 300),
(2, 'sdsd', 'tf', NULL, NULL, NULL, NULL, '1', 81, 1, '2019-09-03 09:40:42', '2019-09-03 09:40:42', 300),
(3, 'sdsd', 'tf', NULL, NULL, NULL, NULL, '1', 81, 1, '2019-09-03 09:40:47', '2019-09-03 09:40:47', 300),
(4, 'asas', 'fib', NULL, NULL, NULL, NULL, 'asas', 82, 1, '2019-09-04 06:23:24', '2019-09-04 06:23:24', 300),
(5, 'asasa', 'tf', NULL, NULL, NULL, NULL, '1', 82, 16, '2019-09-05 07:50:01', '2019-09-05 07:50:01', 300),
(6, 'asasa', 'fib', NULL, NULL, NULL, NULL, 'asasas', 82, 16, '2019-09-05 07:50:29', '2019-09-05 07:50:29', 300),
(7, 'sdsds', 'fib', NULL, NULL, NULL, NULL, 'sdsd', 82, 16, '2019-09-05 07:50:37', '2019-09-05 07:50:37', 300),
(8, 'asas', 'tf', NULL, NULL, NULL, NULL, '1', 83, 1, '2019-09-05 07:53:04', '2019-09-05 07:53:04', 300),
(9, 'asas', 'tf', NULL, NULL, NULL, NULL, '1', 83, 1, '2019-09-05 07:53:11', '2019-09-05 07:53:11', 300),
(10, 'asas', 'tf', NULL, NULL, NULL, NULL, '1', 83, 1, '2019-09-05 07:53:15', '2019-09-05 07:53:15', 300),
(11, 'dfdfdfdf', 'tf', NULL, NULL, NULL, NULL, '1', 83, 1, '2019-09-05 07:53:20', '2019-09-05 07:53:20', 300),
(12, 'qwqw', 'tf', NULL, NULL, NULL, NULL, '1', 83, 1, '2019-09-05 07:53:25', '2019-09-05 07:53:25', 300),
(13, 'asas', 'tf', NULL, NULL, NULL, NULL, '1', 83, 1, '2019-09-05 07:54:48', '2019-09-05 07:54:48', 300);

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
  `total_questions` int(11) NOT NULL DEFAULT '0',
  `user_year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`quizid`, `permitted`, `title`, `no_of_questions`, `user_id`, `created_at`, `updated_at`, `total_questions`, `user_year`) VALUES
(14, 0, 'aaa', 2, 33, '2019-08-19 05:46:30', '2019-08-19 05:46:30', 0, 0),
(15, 0, 'sdsd', 3, 30, '2019-08-20 06:52:42', '2019-08-20 06:52:42', 0, 0),
(81, 0, '1,1', 2, 1, '2019-09-02 13:42:43', '2019-09-03 10:10:34', 2, 0),
(82, 1, '1,2', 2, 1, '2019-09-02 13:44:43', '2019-09-05 07:36:41', 5, 1),
(83, 1, '1,3', 5, 1, '2019-09-05 07:52:53', '2019-09-05 07:52:53', 6, 1),
(85, 0, '1,6', 2, 1, '2019-09-05 10:06:41', '2019-09-05 10:06:41', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_appears`
--

CREATE TABLE `quiz_appears` (
  `quizappearid` int(10) UNSIGNED NOT NULL,
  `marks_scored` decimal(5,2) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `quiz_id` int(10) UNSIGNED NOT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quiz_appears`
--

INSERT INTO `quiz_appears` (`quizappearid`, `marks_scored`, `user_id`, `quiz_id`, `user_name`, `created_at`, `updated_at`) VALUES
(1, '2.00', 16, 81, 'student', '2019-09-05 07:46:38', '2019-09-05 07:46:38'),
(2, '2.00', 16, 82, 'student', '2019-09-05 07:49:42', '2019-09-05 07:49:42'),
(3, '6.00', 16, 83, 'student', '2019-09-05 08:00:27', '2019-09-05 08:00:27');

-- --------------------------------------------------------

--
-- Table structure for table `suggestion`
--

CREATE TABLE `suggestion` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `suggestion` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suggestion`
--

INSERT INTO `suggestion` (`id`, `user_id`, `quiz_id`, `suggestion`, `created_at`, `updated_at`) VALUES
(1, 34, 81, 'qwqwqw', '2019-09-04 05:51:27', '2019-09-04 05:51:27'),
(2, 33, 81, 'Its need some change', '2019-09-04 05:52:47', '2019-09-04 05:52:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(4) NOT NULL COMMENT '0=student,1=teacher,2=admin',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shared_quiz_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enroll_no` int(11) DEFAULT NULL,
  `idcard_no` int(11) DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qualification` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_approved` tinyint(4) NOT NULL,
  `year` int(11) DEFAULT NULL,
  `batch` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `is_admin`, `email_verified_at`, `password`, `shared_quiz_id`, `enroll_no`, `idcard_no`, `designation`, `qualification`, `is_approved`, `year`, `batch`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'shraddha', 'shraddhagami.rao@gmail.com', 1, NULL, '$2y$10$ithuN95RrKCekVf5vcpOdujTQsQ5xDgkfUxYy5JumbjpH5j/iYP/G', NULL, NULL, 1212, 'asas', 'asas', 1, 0, '', NULL, '2019-08-08 10:58:22', '2019-08-17 09:47:16'),
(2, 'test', 'test@gmail.com', 2, NULL, '$2y$10$3zbrWXhaWxF8ej1Jyc8FjOcL73ON9uuLOwfYEoP/2KdwBM1Sk05Ni', NULL, NULL, NULL, NULL, NULL, 0, 0, '', NULL, '2019-08-08 11:10:28', '2019-08-14 09:37:45'),
(3, 'sd', 'sdsd@gmail.com', 0, NULL, '$2y$10$z/KySBCOTglJoT2A/fqZT.4cjt/Ic9h3QiKNTqVDCBUd4vasOWNoG', NULL, NULL, NULL, NULL, NULL, 0, 0, '', NULL, '2019-08-08 12:10:51', '2019-08-08 12:10:51'),
(4, 'test', 'testing@gmail.com', 0, NULL, '$2y$10$5eYanS5dUK/S8t0FSvD.bedqYmH2DbpNVuuzjf47px8378Qy4EkzG', '', NULL, NULL, NULL, NULL, 0, 0, '', NULL, '2019-08-08 13:27:57', '2019-08-14 09:45:13'),
(5, 'asas', 'asa@gmail.com', 0, NULL, '$2y$10$3MQkp3d1VljMoLucfVxe3ObWz4oywtNzw6IdIJV.6gGvj5Tl0hJwC', NULL, NULL, NULL, NULL, NULL, 0, 0, '', NULL, '2019-08-14 05:23:10', '2019-08-14 05:23:10'),
(16, 'student', 'student@gmail.com', 0, NULL, '$2y$10$3GMHb1oyNW/Zpn9PbpzLXuwyazZhR7NVSqir/KSsWA9w3Fm9ssBkG', NULL, 1212, NULL, NULL, NULL, 0, 1, '', NULL, '2019-08-14 13:27:54', '2019-08-14 13:27:54'),
(19, 'Teacher', 'teacher@gmail.com', 0, NULL, '$2y$10$6qvJS6fHFxeHQ/ka/ntvbuiIBXL2Rn7ydEHHIWpDdSSBKVNvonIYe', NULL, NULL, NULL, NULL, NULL, 0, 0, '', NULL, '2019-08-14 13:32:40', '2019-08-14 13:32:40'),
(20, 'sdssd', 'ffd@gmail.com', 0, NULL, '$2y$10$SAXaxzy0n/qNyoi.IbxHCeuSYNJat71vknGSpGbSp.uqq0vGjMeAC', NULL, 0, NULL, NULL, NULL, 0, 0, '', NULL, '2019-08-16 05:52:51', '2019-08-16 05:52:51'),
(23, 'sdsdssd', 'sdsdvbccc@gmail.com', 0, NULL, '$2y$10$lt02ieZs6G9wKCjNGfLqvuZpdFEIZG0foqlMGPUfMbuXieqc6XQAm', NULL, NULL, NULL, NULL, NULL, 0, 0, '', NULL, '2019-08-16 06:18:02', '2019-08-16 06:18:02'),
(24, 'sdsssxx', 'zaxx@gmail.com', 0, NULL, '$2y$10$.FhXoMtBUO3FZ6fOZzcmPOhNt9aoSc0NphCmzKt5VKtXC8dq9Hn/W', NULL, NULL, NULL, NULL, NULL, 0, 0, '', NULL, '2019-08-16 06:18:52', '2019-08-16 06:18:52'),
(26, 'tttb', 'ttbbb@gmail.com', 0, NULL, '$2y$10$Oz0dOU23dRkqe//1iNjVOeMAFMrTv.6bUxi2YBpQx10Am3q/ft3Wm', NULL, NULL, NULL, NULL, NULL, 0, 0, '', NULL, '2019-08-16 06:32:59', '2019-08-16 06:32:59'),
(30, 'finalTeacher', 'finalTeacher@gmail.com', 1, NULL, '$2y$10$/c0ik92VqzjCanmtZH/NNe.VDwlXkNGCzhu.pa7OcHOyG0H9e8nJW', '', NULL, 111, 'ghgh', 'ghgh', 1, 0, '', NULL, '2019-08-16 11:54:08', '2019-08-29 12:47:32'),
(31, 'om', 'om@gmail.com', 0, NULL, '$2y$10$VCTOjfiz6G35B1GHeo.TguzO.VMo1x9ADRQriO0e9uNSJGafDDINC', '', NULL, 9090, 'jkj', 'jkj', 1, 1, '', NULL, '2019-08-16 12:03:36', '2019-08-29 13:48:43'),
(32, 'asas', 'vbcdfd@gmail.com', 1, NULL, '$2y$10$EnWQz/kXWSm/wpdkU1RxmeZ7U.YV3Wk7g63swLaezYUNGzks0xXtS', '81', NULL, 11, 'hjhj', 'hjh', 1, 0, '', NULL, '2019-08-16 12:08:44', '2019-09-04 11:43:43'),
(33, 'jahnvi', 'jahnvi@gmail.com', 1, NULL, '$2y$10$mC5vi3h9Op9IatdilRYFFu7JY9R8pRNBg3WXTGHjUyCIpX7sfyhnm', '81', NULL, 1212, 'jkj', 'jkj', 1, 0, '', NULL, '2019-08-16 12:43:19', '2019-09-03 09:29:45'),
(34, 'rinki', 'rinki@gmail.com', 1, NULL, '$2y$10$QZammvXyPC5Bhm.jKBH1XebW7vu7TgOlZBP4HUbVz8t.Y.BPxGl16', '81,82', NULL, 1212, 'asas', 'asas', 1, 0, '', NULL, '2019-08-16 12:52:44', '2019-09-03 09:29:31'),
(35, 'sd', 'sd@gmail.com', 1, NULL, '$2y$10$Ng0ScYSvhyHhlx0W/RpHw.NBqzCzVaGiGpJ1NkXO2HGD2rO7G9LsG', '82', NULL, 787, 'hjh', 'hjh', 1, 0, '', NULL, '2019-08-16 13:02:09', '2019-09-04 12:50:13'),
(36, 'heer', 'heer@gmail.com', 1, NULL, '$2y$10$TETYSQo1p9Zejz6I7ysvxujnC3mQWYkjR.w9sfPEoBmajNcdZraDq', '', NULL, 545, 'ghgh', 'ghg', 1, 0, '', NULL, '2019-08-29 06:22:36', '2019-08-31 09:32:19'),
(37, 'tannu', 'tannu@gmail.com', 0, NULL, '$2y$10$7xX.BnP072fIttqD8poeWu0KRnnLGFSIgRO2rYsUeTBFGiiB2ONwu', NULL, 0, NULL, NULL, NULL, 0, 0, '', NULL, '2019-08-30 05:38:44', '2019-08-30 05:38:44'),
(38, 'vibha', 'vibha@gmail.com', 0, NULL, '$2y$10$EuzcJM.8IebpLMBvsd.pvOIvPF9YM8hTvZ3FL2IcpATjXMDpIWYCG', NULL, 88888, NULL, NULL, NULL, 0, 2, '2018-2019', NULL, '2019-08-30 07:28:30', '2019-08-30 07:28:30'),
(39, 'plplop', 'plplop@gmail.com', 0, NULL, '$2y$10$BIRD7KB59mK3d4JesiUihe.dMqiI0T9bH4Nr1d9ALIrhGVUe3tiai', NULL, 121, NULL, NULL, NULL, 0, 1, '2018-2019', NULL, '2019-08-31 13:38:13', '2019-08-31 13:38:13');

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
  `status` tinyint(4) NOT NULL,
  `attempt_no_of__que` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_responses`
--

INSERT INTO `user_responses` (`responseid`, `user_id`, `userData_appear`, `quiz_id`, `question_id`, `user_response`, `correct`, `time_taken`, `status`, `attempt_no_of__que`, `created_at`, `updated_at`) VALUES
(1, 16, 1, 81, 2, '1', 1, 0, 1, 2, '2019-09-05 07:46:38', '2019-09-05 07:46:38'),
(2, 16, 1, 81, 3, '1', 1, 0, 0, 2, '2019-09-05 07:46:41', '2019-09-05 07:46:41'),
(3, 16, 2, 82, 1, '1', 1, 0, 1, 5, '2019-09-05 07:49:43', '2019-09-05 07:49:43'),
(4, 16, 2, 82, 4, 'asa', 0, 0, 1, 2, '2019-09-05 07:52:16', '2019-09-05 07:52:16'),
(5, 16, 2, 82, 5, '1', 1, 0, 1, 3, '2019-09-05 07:52:19', '2019-09-05 07:52:19'),
(6, 16, 2, 82, 6, 'as', 0, 0, 1, 4, '2019-09-05 07:52:21', '2019-09-05 07:52:21'),
(7, 16, 2, 82, 7, 'as', 0, 0, 0, 5, '2019-09-05 07:52:23', '2019-09-05 07:52:23'),
(8, 16, 3, 83, 8, '1', 1, 0, 1, 6, '2019-09-05 08:00:27', '2019-09-05 08:00:27'),
(9, 16, 3, 83, 9, '1', 1, 0, 1, 2, '2019-09-05 08:00:29', '2019-09-05 08:00:29'),
(10, 16, 3, 83, 10, '1', 1, 0, 1, 3, '2019-09-05 08:00:31', '2019-09-05 08:00:31'),
(11, 16, 3, 83, 11, '1', 1, 0, 1, 4, '2019-09-05 08:00:33', '2019-09-05 08:00:33'),
(12, 16, 3, 83, 12, '1', 1, 0, 1, 5, '2019-09-05 08:00:35', '2019-09-05 08:00:35'),
(13, 16, 3, 83, 13, '1', 1, 0, 0, 6, '2019-09-05 08:00:37', '2019-09-05 08:00:37');

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
-- Indexes for table `suggestion`
--
ALTER TABLE `suggestion`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `avgid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `questionid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `quizid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
--
-- AUTO_INCREMENT for table `quiz_appears`
--
ALTER TABLE `quiz_appears`
  MODIFY `quizappearid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `suggestion`
--
ALTER TABLE `suggestion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT for table `user_responses`
--
ALTER TABLE `user_responses`
  MODIFY `responseid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
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

-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 17, 2019 at 12:37 PM
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
(8, 16, 99, '1.00', '2019-09-14 07:04:27', '2019-09-14 07:04:27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lession_plan`
--

CREATE TABLE `lession_plan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lession_no` int(11) DEFAULT NULL,
  `school_name` varchar(50) DEFAULT NULL,
  `standard` int(11) DEFAULT NULL,
  `subject` varchar(150) DEFAULT NULL,
  `date_lession` varchar(255) DEFAULT NULL,
  `topic` varchar(255) DEFAULT NULL,
  `period_no` int(11) DEFAULT NULL,
  `time` varchar(11) DEFAULT NULL,
  `time_to` varchar(11) DEFAULT NULL,
  `general_objectives` varchar(255) DEFAULT NULL,
  `approach_technique` varchar(255) DEFAULT NULL,
  `teaching_aids` varchar(255) DEFAULT NULL,
  `text_book` varchar(255) DEFAULT NULL,
  `refernce_books` varchar(255) DEFAULT NULL,
  `author_book` varchar(255) DEFAULT NULL,
  `author_ref_book` varchar(255) DEFAULT NULL,
  `pageno_textbook` int(11) DEFAULT NULL,
  `pageno_refbook` int(11) DEFAULT NULL,
  `steps` varchar(255) DEFAULT NULL,
  `specific_objectives` varchar(255) DEFAULT NULL,
  `teaching_points` varchar(255) DEFAULT NULL,
  `teacher_activity` varchar(255) DEFAULT NULL,
  `student_activity` varchar(255) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `reference_manual` varchar(255) NOT NULL,
  `evaluation` varchar(255) DEFAULT NULL,
  `diagram` varchar(255) DEFAULT NULL,
  `assignment` varchar(255) DEFAULT NULL,
  `observers_remark` varchar(255) DEFAULT NULL,
  `draft_page` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lession_plan`
--

INSERT INTO `lession_plan` (`id`, `user_id`, `lession_no`, `school_name`, `standard`, `subject`, `date_lession`, `topic`, `period_no`, `time`, `time_to`, `general_objectives`, `approach_technique`, `teaching_aids`, `text_book`, `refernce_books`, `author_book`, `author_ref_book`, `pageno_textbook`, `pageno_refbook`, `steps`, `specific_objectives`, `teaching_points`, `teacher_activity`, `student_activity`, `reference`, `reference_manual`, `evaluation`, `diagram`, `assignment`, `observers_remark`, `draft_page`, `created_at`, `updated_at`) VALUES
(1, 16, 1, 'sdsd', 6, 's.s', '11/09/2019', 'sdsd', 1, '00:00:45', '00:00:44', 'uniqueQuizAppearIduniqueQuizAppearIduniqueQuizAppearIduniqueQuizAppearIduniqueQuizAppearIduniqueQuizAppearIduniqueQuizAppearIduniqueQuizAppearIduniqueQuizAppearIduniqueQuizAppearIduniqueQuizAppearIduniqueQuizAppearIduniqueQuizAppearIduniqueQuizAppearId', 'df', 'df', 'df', 'df', 'df', 'wwwwwwwwwwwww', 3, 4, '1', 'sd', 'sdsd', NULL, 'sd', 'P072.doc,Project Documentation.doc,S21 (1).doc', '', 'sdsd', NULL, 'sdsdsd', NULL, 3, '2019-09-17 06:14:00', '2019-09-17 06:14:00'),
(4, 16, 2, 'asasas', 6, 'english', '11/09/2019', 'sdsd', 1, '00:00:02', '00:00:03', 'sd', 'sd', 'sd', 'sd', 'sd', 'sd', 'sd', 3, 4, '1', 'we', 'we', 'we', 'we', 'S21.doc', '', NULL, NULL, NULL, NULL, 3, '2019-09-11 13:30:26', '2019-09-11 13:30:26'),
(12, 16, 1212, 'asas', 6, 'english', '10/09/2019', 'df', 2, '00:00:33', '00:00:22', 'df', 'dfdf', 'sds', 'sdsd', 'sdsd', 'sd', 'sds', 5, 6, '2', 'xc', 'xcxc', 'dd', 'fdf', 'S21.doc,sdsds.txt,shraddha.pdf', '', 'df', NULL, 'sdsdsd', NULL, 3, '2019-09-12 12:57:01', '2019-09-12 12:57:01'),
(15, 16, 1, 'sds', 6, 'english', NULL, 'sdsd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'laravel (1).sql', '', NULL, NULL, NULL, NULL, 2, '2019-09-12 12:22:47', '2019-09-12 12:22:47'),
(16, 16, 1111, NULL, 6, 'english', NULL, 'dfdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S21.doc', '', NULL, NULL, NULL, NULL, 2, '2019-09-12 06:08:16', '2019-09-12 06:08:16'),
(18, 37, 1, NULL, 6, 'english', NULL, 'sds', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 2, '2019-09-12 06:16:02', '2019-09-12 06:16:02'),
(20, 4, 1, NULL, 6, 'english', NULL, 'sdsd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '2019-09-12 06:43:18', NULL),
(21, 16, 21, NULL, 6, 'english', NULL, 'htfgj', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '2019-09-12 06:55:56', NULL),
(22, 16, 2, NULL, 6, 'english', NULL, 'zxzx', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S21.doc,sdsds.txt', 'xdfdfdf', NULL, NULL, NULL, NULL, 2, '2019-09-12 11:03:05', '2019-09-12 11:03:05'),
(24, 16, 1, 'school', 6, 'english', '07/09/2019', 'asas', 1, '00:00:11', '00:00:02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S21.doc,Untitled 1.ods', '', NULL, NULL, NULL, NULL, 3, '2019-09-13 06:20:12', '2019-09-13 06:20:12'),
(25, 16, 2, NULL, 6, 'english', NULL, 'dfd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '2019-09-13 06:20:31', NULL),
(26, 16, 2, NULL, 6, 'english', NULL, 'sds', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 2, '2019-09-13 06:31:52', '2019-09-13 06:31:52'),
(27, 16, 1, NULL, 6, 'english', NULL, 'asas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '2019-09-13 07:00:41', NULL),
(28, 16, 5, NULL, 6, 'english', NULL, 'sd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '2019-09-13 07:40:00', '2019-09-13 07:40:00'),
(29, 16, 6, NULL, 6, 'english', NULL, 'asas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '2019-09-13 07:41:21', '2019-09-13 07:41:21'),
(30, 16, 2, 'sdsd', 7, 's.s', '12/09/2019', 'ewq', 3, NULL, NULL, 'DESGFCBCdunt. Morbi sollicitudin ultrices diam, imperdiet fringilla magna dignissim sit amet. Sed pretium augue at odio lobortis, sit amet pharetra justo pretium. Cras rhoncus a metus ac interdum. Phasellus sit amet ornare eros, faucibus interdum mauris. ', 'RERDHFCdunt. Morbi sollicitudin ultrices diam, imperdiet fringilla magna dignissim sit amet. Sed pretium augue at odio lobortis, sit amet pharetra justo pretium. Cras rhoncus a metus ac interdum. Phasellus sit amet ornare eros, fa', 'DWAESFdunt. Morbi sollicitudin ultrices diam, imperdiet fringilla magna dignissim sit amet. Sed pretium augue at odio lobortis, sit amet pharetra justo pretium. Cras rhoncus a metus ac interdum. Phasellus sit amet ornare eros, fau', 'dunt. Morbi sollicitudin ultrices diam, imperdiet', 'dunt. Morbi sollicitudin ultrices diam, imperdiet fringilla magna dignissim sit amet. Sed pretium augue at odio lobortis, sit amet pharetra justo pret', 'dunt. Morbi sollicitudin', 'dunt. Morbi sollicitudin ultrices diam, imperdiet fringilla magna dignissim sit amet. Sed pretium au', 0, 0, '3546534233333333333333333333333333333333333333333333333333333333333333333333333333333', 'dunt. Morbi sollicitudin ultrices diam, imperdiet fringilla magna dignissim sit amet. Sed pretium augue at odio lobortis, sit amet pharetra justo pretium. Cras rhoncus a metus ac interdum. Phasellus sit amet ornare eros, faucibus interdum mauris. Ut viver', 'dunt. Morbi sollicitudin ultrices diam, imperdiet fringilla magna dignissim sit amet. Sed pretium augue at odio lobortis, sit amet pharetra justo pretium. Cras rhoncus a metus ac interdum. Phasellus sit amet ornare eros, faucibus interdum mauris. Ut viver', 'dunt. Morbi sollicitudin ultrices diam, imperdiet fringilla magna dignissim sit amet. Sed pretium augue at odio lobortis, sit amet pharetra justo pretium. Cras rhoncus a metus ac interdum. Phasellus sit amet ornare eros, faucibus interdum mauris. Ut viver', 'dunt. Morbi sollicitudin ultrices diam, imperdiet fringilla magna dignissim sit amet. Sed pretium augue at odio lobortis, sit amet pharetra justo pretium. Cras rhoncus a metus ac interdum. Phasellus sit amet ornare eros, faucibus interdum mauris. Ut viver', 'AdminController.php,laravel (1).sql,S21.doc,search.php', '', 'dunt. Morbi sollicitudin ultrices diam, imperdiet fringilla magna dignissim sit amet. Sed pretium au', NULL, 'maxlength=\"800\" maxlength=\"800\"dunt. Morbi sollicitudin ultrices diam, imperdiet fringilla magna dignissim sit amet. Sed pretium augue at odio lobortis, sit amet pharetra justo pretium. Cras rhoncus a metus ac interdum. Phasellus sit amet ornare eros, fau', NULL, 3, '2019-09-17 07:02:29', '2019-09-17 07:02:29'),
(31, 16, 1, NULL, 6, 'english', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '2019-09-14 07:45:22', NULL),
(32, 16, 1, NULL, 6, 'english', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '2019-09-14 07:58:56', NULL),
(33, 16, 1, NULL, 6, 'english', NULL, 'sas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '2019-09-14 10:08:33', NULL),
(34, 16, 1, 'asas', 6, 'english', '14/09/2019', 'sdsd', 1, '2:00 AM', '3:00 AM', 'sd', 'sdsd', 'sdsd', 'sds', 'sdsd', 's', 'dsd', 1, 2, '1', 'a', 'sas', 'as', 'as', NULL, 'asas', 'asas', NULL, NULL, NULL, 2, '2019-09-14 10:19:21', '2019-09-14 10:19:21'),
(35, 16, 12, 'sdsd', 6, 'english', '14/09/2019', 'asas', 1, '00:00:12', '00:00:12', 'as', 'as', 'as', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 2, '2019-09-14 10:13:03', '2019-09-14 10:13:03'),
(36, 16, 5, NULL, 6, 'english', NULL, '5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'dunt. Morbi sollicitudin ultrices diam, imperdiet fringilla magna dignissim sit amet. Sed pretium augue at odio lobortis, sit amet pharetra justo pret', NULL, 'dunt. Morbi sollicitudin ultrices diam, imperdiet fringilla magna dignissim sit amet. Sed pretium au', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '', '<td rowspan=\"2\"><textarea rows=\"25\" cols=\"45\" name=\"teacher_activity\" maxlength=\"470\"></tex', NULL, 'dunt. Morbi sollicitudin ultrices diam, imperdiet fringilla magna dignissim sit amet. Sed pretium augue at odio lobortis, sit amet pharetra justo pretium. Cras rhoncus a metus ac interdum. Phasellus sit amet ornare eros, faucibus interdum mauris. Ut viver', NULL, 3, '2019-09-17 06:44:34', '2019-09-17 06:44:34');

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
(19, 'asas', 'tf', NULL, NULL, NULL, NULL, '1', 99, 30, '2019-09-14 06:16:42', '2019-09-14 06:16:42', 300),
(20, 'asas', 'fib', NULL, NULL, NULL, NULL, 'a', 99, 30, '2019-09-14 06:16:49', '2019-09-14 06:16:49', 300),
(51, 'asas', 'fib', NULL, NULL, NULL, NULL, 'a', 113, 1, '2019-09-17 06:11:57', '2019-09-17 06:11:57', 300),
(52, 'asas', 'fib', NULL, NULL, NULL, NULL, 'a', 113, 1, '2019-09-17 06:12:04', '2019-09-17 06:12:04', 300),
(53, 'asas', 'fib', NULL, NULL, NULL, NULL, 'a', 114, 1, '2019-09-17 06:16:18', '2019-09-17 06:16:18', 300),
(54, 'asas', 'fib', NULL, NULL, NULL, NULL, 'a', 114, 1, '2019-09-17 06:16:24', '2019-09-17 06:16:24', 300),
(55, 'sdsd', 'fib', NULL, NULL, NULL, NULL, 'a', 114, 1, '2019-09-17 06:17:21', '2019-09-17 06:17:21', 300),
(56, 'asasas', 'fib', NULL, NULL, NULL, NULL, 'a', 114, 1, '2019-09-17 06:17:30', '2019-09-17 06:17:30', 300);

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
(86, 0, '2,6', 2, 36, '2019-09-10 13:38:12', '2019-09-10 13:38:12', 0, 0),
(99, 1, '1,3', 2, 30, '2019-09-14 05:39:53', '2019-09-14 05:41:57', 2, 1),
(100, 0, '3,1', 2, 30, '2019-09-14 05:48:39', '2019-09-14 05:48:39', 0, 0),
(113, 1, '1,2', 2, 1, '2019-09-17 06:11:46', '2019-09-17 06:11:46', 2, 1),
(114, 0, '1,4', 4, 1, '2019-09-17 06:15:55', '2019-09-17 06:15:55', 4, 0);

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
(8, '1.00', 16, 99, 'shraddha patel', '2019-09-14 06:32:37', '2019-09-14 06:32:37');

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
(2, 33, 81, 'Its need some change', '2019-09-04 05:52:47', '2019-09-04 05:52:47'),
(3, 1, 99, 'Good......', '2019-09-14 06:20:46', '2019-09-14 06:20:46'),
(4, 1, 99, 'asasasas', '2019-09-14 06:22:23', '2019-09-14 06:22:23'),
(5, 1, 99, 'sdsdsd', '2019-09-14 06:23:53', '2019-09-14 06:23:53'),
(6, 1, 99, 'rterytytryrrttrtghgh', '2019-09-14 07:02:07', '2019-09-14 07:02:07'),
(7, 36, 101, 'yhtyrttrtytytyyyt', '2019-09-14 07:33:40', '2019-09-14 07:33:40');

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
  `batch` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `is_admin`, `email_verified_at`, `password`, `shared_quiz_id`, `enroll_no`, `idcard_no`, `designation`, `qualification`, `is_approved`, `year`, `batch`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'shraddha', 'shraddhagami.raoo@gmail.com', 1, NULL, '$2y$10$ithuN95RrKCekVf5vcpOdujTQsQ5xDgkfUxYy5JumbjpH5j/iYP/G', '100,99', NULL, 1212, 'asas', 'asas', 1, 0, '', NULL, '2019-08-08 10:58:22', '2019-09-14 06:19:01'),
(2, 'test', 'shraddhagami.rao@gmail.com', 2, NULL, '$2y$10$3zbrWXhaWxF8ej1Jyc8FjOcL73ON9uuLOwfYEoP/2KdwBM1Sk05Ni', NULL, NULL, NULL, NULL, NULL, 0, 0, '', NULL, '2019-08-08 11:10:28', '2019-08-14 09:37:45'),
(4, 'test', 'testing@gmail.com', 0, NULL, '$2y$10$5eYanS5dUK/S8t0FSvD.bedqYmH2DbpNVuuzjf47px8378Qy4EkzG', '', NULL, NULL, NULL, NULL, 0, 0, '', NULL, '2019-08-08 13:27:57', '2019-08-14 09:45:13'),
(5, 'asas', 'asa@gmail.com', 0, NULL, '$2y$10$3MQkp3d1VljMoLucfVxe3ObWz4oywtNzw6IdIJV.6gGvj5Tl0hJwC', NULL, NULL, NULL, NULL, NULL, 0, 0, '', NULL, '2019-08-14 05:23:10', '2019-08-14 05:23:10'),
(16, 'shraddha patel', 'student@gmail.com', 0, NULL, '$2y$10$3GMHb1oyNW/Zpn9PbpzLXuwyazZhR7NVSqir/KSsWA9w3Fm9ssBkG', NULL, 1212, NULL, NULL, NULL, 0, 1, '', NULL, '2019-08-14 13:27:54', '2019-08-14 13:27:54'),
(20, 'sdssd', 'ffd@gmail.com', 0, NULL, '$2y$10$SAXaxzy0n/qNyoi.IbxHCeuSYNJat71vknGSpGbSp.uqq0vGjMeAC', NULL, 0, NULL, NULL, NULL, 0, 0, '', NULL, '2019-08-16 05:52:51', '2019-08-16 05:52:51'),
(23, 'sdsdssd', 'sdsdvbccc@gmail.com', 0, NULL, '$2y$10$lt02ieZs6G9wKCjNGfLqvuZpdFEIZG0foqlMGPUfMbuXieqc6XQAm', NULL, NULL, NULL, NULL, NULL, 0, 0, '', NULL, '2019-08-16 06:18:02', '2019-08-16 06:18:02'),
(24, 'sdsssxx', 'zaxx@gmail.com', 0, NULL, '$2y$10$.FhXoMtBUO3FZ6fOZzcmPOhNt9aoSc0NphCmzKt5VKtXC8dq9Hn/W', NULL, NULL, NULL, NULL, NULL, 0, 0, '', NULL, '2019-08-16 06:18:52', '2019-08-16 06:18:52'),
(30, 'finalTeacher', 'finalTeacher@gmail.com', 1, NULL, '$2y$10$/c0ik92VqzjCanmtZH/NNe.VDwlXkNGCzhu.pa7OcHOyG0H9e8nJW', '98', NULL, 111, 'ghgh', 'ghgh', 1, 0, '', NULL, '2019-08-16 11:54:08', '2019-09-14 05:22:53'),
(31, 'om', 'om@gmail.com', 0, NULL, '$2y$10$VCTOjfiz6G35B1GHeo.TguzO.VMo1x9ADRQriO0e9uNSJGafDDINC', '', NULL, 9090, 'jkj', 'jkj', 1, 1, '', NULL, '2019-08-16 12:03:36', '2019-08-29 13:48:43'),
(32, 'asas', 'vbcdfd@gmail.com', 1, NULL, '$2y$10$EnWQz/kXWSm/wpdkU1RxmeZ7U.YV3Wk7g63swLaezYUNGzks0xXtS', '81', NULL, 11, 'hjhj', 'hjh', 1, 0, '', NULL, '2019-08-16 12:08:44', '2019-09-04 11:43:43'),
(33, 'jahnvi', 'jahnvi@gmail.com', 1, NULL, '$2y$10$mC5vi3h9Op9IatdilRYFFu7JY9R8pRNBg3WXTGHjUyCIpX7sfyhnm', '81,98', NULL, 1212, 'jkj', 'jkj', 1, 0, '', NULL, '2019-08-16 12:43:19', '2019-09-14 05:26:27'),
(34, 'rinki', 'rinki@gmail.com', 1, NULL, '$2y$10$QZammvXyPC5Bhm.jKBH1XebW7vu7TgOlZBP4HUbVz8t.Y.BPxGl16', '81,82', NULL, 1212, 'asas', 'asas', 1, 0, '', NULL, '2019-08-16 12:52:44', '2019-09-03 09:29:31'),
(35, 'sd', 'sd@gmail.com', 1, NULL, '$2y$10$Ng0ScYSvhyHhlx0W/RpHw.NBqzCzVaGiGpJ1NkXO2HGD2rO7G9LsG', '82', NULL, 787, 'hjh', 'hjh', 1, 0, '', NULL, '2019-08-16 13:02:09', '2019-09-04 12:50:13'),
(36, 'heer', 'heer@gmail.com', 1, NULL, '$2y$10$TETYSQo1p9Zejz6I7ysvxujnC3mQWYkjR.w9sfPEoBmajNcdZraDq', '101', NULL, 545, 'ghgh', 'ghg', 1, 0, '', NULL, '2019-08-29 06:22:36', '2019-09-14 07:33:15'),
(37, 'tannu', 'tannu@gmail.com', 0, NULL, '$2y$10$7xX.BnP072fIttqD8poeWu0KRnnLGFSIgRO2rYsUeTBFGiiB2ONwu', NULL, 0, NULL, NULL, NULL, 0, 0, '', NULL, '2019-08-30 05:38:44', '2019-08-30 05:38:44'),
(38, 'vibha', 'vibha@gmail.com', 0, NULL, '$2y$10$EuzcJM.8IebpLMBvsd.pvOIvPF9YM8hTvZ3FL2IcpATjXMDpIWYCG', NULL, 88888, NULL, NULL, NULL, 0, 2, '2018-2019', NULL, '2019-08-30 07:28:30', '2019-08-30 07:28:30'),
(41, 'shree', 'shree@gmail.com', 1, NULL, '$2y$10$sjrn10rpnTfVIqzRkaoQ0.msi61fMW1UjnuW9TstYWX7wKQT3rxc.', NULL, NULL, 676, 'hjhj', 'hjhj', 0, NULL, NULL, NULL, '2019-09-13 09:54:52', '2019-09-13 09:55:01'),
(42, 'sdsd', 'sdsdvcc@gmail.com', 1, NULL, '$2y$10$srFGm0Ju0ZB8ZCiCLYrRLOIlsMqS6FOYdxMQN1fiREWyQY5E/mEl6', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2019-09-13 10:06:23', '2019-09-13 10:06:23'),
(43, 'wewe', 'wewe@gmail.com', 1, NULL, '$2y$10$ddZUROgQSVAXOZmKv/tk..5UUqEkWYv8B0SjAe/OTqc3qC4wVCZ5O', NULL, NULL, 123, 'jk', 'j', 1, NULL, NULL, NULL, '2019-09-13 12:18:55', '2019-09-13 12:20:14'),
(45, 'tgfhfh', 'vanashree24@gmail.com', 0, NULL, '$2y$10$ZTnAF3DgGpdn7XaMCwV69ubJkBJ7JfA1RuHmnrl5B13jglKw1vOiu', NULL, 121, NULL, NULL, NULL, 0, 1, '2018-2019', NULL, '2019-09-14 07:00:18', '2019-09-14 07:00:18'),
(46, 'raghu', 'raghu@gmail.com', 0, NULL, '$2y$10$YAg6.8AiBWBcWi4EZzR72O69tFLRmjrW/tQGP7EMkdNKpfPLDkam2', NULL, 787, NULL, NULL, NULL, 0, 1, '77', NULL, '2019-09-14 08:14:31', '2019-09-14 08:14:31'),
(47, 'qq', 'qq@gmail.com', 0, NULL, '$2y$10$sqTKxYFWEL7.UndD.1Lmt.XkY9/lrlttaUvFkucwDwV57DigkNZkO', NULL, 12, NULL, NULL, NULL, 0, 1, '343', NULL, '2019-09-14 09:11:05', '2019-09-14 09:11:05');

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
(24, 16, 8, 99, 19, '1', 1, 0, 1, 2, '2019-09-14 06:32:37', '2019-09-14 06:32:37');

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
-- Indexes for table `lession_plan`
--
ALTER TABLE `lession_plan`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `avgid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `lession_plan`
--
ALTER TABLE `lession_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `questionid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `quizid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;
--
-- AUTO_INCREMENT for table `quiz_appears`
--
ALTER TABLE `quiz_appears`
  MODIFY `quizappearid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `suggestion`
--
ALTER TABLE `suggestion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT for table `user_responses`
--
ALTER TABLE `user_responses`
  MODIFY `responseid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
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

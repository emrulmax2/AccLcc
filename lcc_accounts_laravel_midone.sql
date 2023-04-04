-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 04, 2023 at 01:47 PM
-- Server version: 5.7.36
-- PHP Version: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lcc_accounts_laravel_midone`
--

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

DROP TABLE IF EXISTS `banks`;
CREATE TABLE IF NOT EXISTS `banks` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(199) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_image` varchar(199) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`id`, `bank_name`, `bank_image`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_at`) VALUES
(1, 'theme 777', 'storage_1666358563.png', '1', NULL, '2022-10-19 07:29:32', NULL, '2022-10-21 07:25:01', NULL),
(2, 'Storate 01874', 'storage_1666358577.png', '1', NULL, '2022-10-19 07:31:10', NULL, '2022-10-21 07:24:40', NULL),
(3, 'Storate 013298', 'storage_1666277734.jpg', '1', NULL, '2022-10-19 07:36:32', NULL, '2022-10-21 07:24:56', NULL),
(4, 'Storate 01 sdaf 89', 'storage_1666277765.jpg', '1', NULL, '2022-10-19 07:37:15', NULL, '2022-10-20 08:56:05', NULL),
(5, 'Buri Morse 6', 'storage_1666268559.png', '1', NULL, '2022-10-19 07:39:38', NULL, '2022-10-21 07:24:52', NULL),
(6, '2323', 'storage_1666339965.png', '1', NULL, '2022-10-19 07:40:54', NULL, '2022-10-21 07:24:43', NULL),
(7, 'theme fs4', 'storage_1666186889.png', '1', NULL, '2022-10-19 07:41:29', NULL, '2022-10-21 03:04:21', NULL),
(10, 'IBBL', 'storage_1666356438.jpg', '1', NULL, '2022-10-21 06:47:18', NULL, '2022-10-21 06:47:18', NULL),
(11, 'M', 'storage_1666356676.png', '1', NULL, '2022-10-21 06:51:16', NULL, '2022-10-21 06:51:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) DEFAULT NULL,
  `category_name` varchar(199) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trans_type` tinyint(4) DEFAULT NULL COMMENT '0=Income, 1=Expense',
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive',
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `category_name`, `trans_type`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 'Income', 0, '1', NULL, NULL, '2022-10-25 02:45:56', '2022-10-25 02:45:56', NULL),
(2, NULL, 'Income 2', 0, '1', NULL, NULL, '2022-10-25 02:46:21', '2022-10-25 02:46:21', NULL),
(3, 1, 'Income 3', 0, '1', NULL, NULL, '2022-10-25 03:02:54', '2022-10-25 03:02:54', NULL),
(4, 3, 'Income 4', 0, '1', NULL, NULL, '2022-10-25 03:03:03', '2022-10-25 03:03:03', NULL),
(5, 4, 'Income 5', 0, '1', NULL, NULL, '2022-10-25 04:09:49', '2022-10-26 04:14:45', NULL),
(6, 4, 'Income 6 Updated', 0, '1', NULL, NULL, '2022-10-25 09:11:56', '2022-10-26 05:14:52', NULL),
(7, NULL, 'Expense', 1, '1', NULL, NULL, '2022-10-26 02:00:55', '2022-10-26 02:00:55', NULL),
(8, 7, 'Expense 01', 1, '1', NULL, NULL, NULL, NULL, NULL),
(9, 8, 'Expense 02', 1, '1', NULL, NULL, '2022-10-26 08:28:59', NULL, NULL),
(10, 9, 'Expense 03 Updated', 1, '1', NULL, NULL, '2022-10-26 02:45:20', '2022-10-26 05:15:07', NULL),
(11, NULL, 'Salary', 1, '1', NULL, NULL, '2022-10-26 03:57:35', '2022-10-26 03:57:35', NULL),
(12, 4, 'Income 07', 0, '1', NULL, NULL, '2022-10-26 05:21:10', '2022-10-26 05:21:14', '2022-10-26 05:21:14');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `methods`
--

DROP TABLE IF EXISTS `methods`;
CREATE TABLE IF NOT EXISTS `methods` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `method_name` varchar(199) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `methods`
--

INSERT INTO `methods` (`id`, `method_name`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Banks', '1', NULL, NULL, '2022-10-24 03:11:28', '2022-10-24 05:36:39', NULL),
(2, 'Cash', '1', NULL, NULL, '2022-10-24 03:12:49', '2022-10-24 03:12:49', NULL),
(3, 'Cheque', '1', NULL, NULL, '2022-10-24 03:13:19', '2022-10-24 03:13:19', NULL),
(4, 'test', '1', NULL, NULL, '2022-10-24 03:14:19', '2022-10-24 05:57:38', NULL),
(5, 'test 2', '1', NULL, NULL, '2022-10-24 03:15:49', '2022-10-24 05:58:42', NULL),
(6, 'test 3', '1', NULL, NULL, '2022-10-24 03:22:44', '2022-10-24 06:03:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_10_17_104602_create_banks_table', 2),
(6, '2022_10_20_151144_add_softdelete_to_banks', 3),
(7, '2022_10_21_134602_create_methods_table', 4),
(8, '2022_10_24_141928_create_categories_table', 5),
(9, '2022_10_26_113256_create_transactions_table', 6),
(10, '2022_10_27_130342_create_transaction_logs_table', 7),
(11, '2022_10_31_090449_create_transaction_csv_datas_table', 8),
(12, '2022_11_01_134825_create_payment_requests_table', 9),
(13, '2022_11_01_153758_add_user_code_to_users', 10);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_requests`
--

DROP TABLE IF EXISTS `payment_requests`;
CREATE TABLE IF NOT EXISTS `payment_requests` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `request_date` date DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `upload` varchar(199) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `request_by` bigint(20) UNSIGNED NOT NULL,
  `payment_date` date DEFAULT NULL,
  `method_id` bigint(20) UNSIGNED NOT NULL,
  `bank_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '3' COMMENT '1=Paid, 2=Hold, 3=Unpaid',
  `approved_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaction_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_date` date NOT NULL,
  `cheque_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cheque_date` date DEFAULT NULL,
  `invoice_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `bank_id` bigint(20) UNSIGNED NOT NULL,
  `method_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_type` tinyint(4) DEFAULT NULL COMMENT '0=Inflow, 1=Outflow',
  `detail` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `transaction_amount` decimal(10,2) NOT NULL,
  `transaction_doc_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `transaction_code`, `transaction_date`, `cheque_no`, `cheque_date`, `invoice_no`, `invoice_date`, `category_id`, `bank_id`, `method_id`, `transaction_type`, `detail`, `description`, `transaction_amount`, `transaction_doc_name`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'TC00001', '2022-10-26', NULL, NULL, NULL, NULL, 3, 2, 1, 0, NULL, NULL, '1234.00', NULL, NULL, NULL, '2022-10-26 10:26:12', '2022-10-26 10:26:12', NULL),
(2, 'TC00002', '2022-10-26', 'CVF3453', '2022-10-13', '103982', '2022-10-12', 8, 10, 3, 1, 'Details u', 'Description U', '100.00', 'TRNS_1666875105.jpg', NULL, 1, '2022-10-26 10:26:31', '2022-10-27 06:51:45', NULL),
(3, 'TC00003', '2022-10-27', NULL, '2022-10-27', '103981', '2022-10-27', 3, 2, 2, 0, 'This si test details', 'This si test description', '1200.00', 'TRNS_1666864490.jpg', 1, NULL, '2022-10-27 03:54:50', '2022-10-27 03:54:50', NULL),
(4, 'TC00004', '2022-10-27', 'CVF3452', '2022-10-27', '103981', '2022-10-27', 8, 10, 3, 1, 'asdf asdf asdf asdf sadf sadf', 'asdf sadf sdaf sadf sadf sadf sadf sadf sadf', '234.00', 'TRNS_1666866834.png', 1, NULL, '2022-10-27 04:33:54', '2022-10-27 04:33:54', NULL),
(5, 'TC00005', '2022-10-27', NULL, '2022-10-27', NULL, NULL, 8, 2, 1, 1, '', '', '46.00', '', 1, NULL, '2022-10-27 04:34:43', '2022-10-27 04:34:43', NULL),
(6, 'TC00006', '2022-10-27', NULL, '2022-10-27', NULL, NULL, 1, 10, 1, 0, '', '', '30.00', '', 1, NULL, '2022-10-27 04:37:25', '2022-10-27 04:37:25', NULL),
(7, 'TC00007', '2022-10-27', 'CVF3452', '2022-10-05', '103981', NULL, 4, 10, 3, 0, 'Details', 'Description', '2000.00', 'TRNS_1666873672.png', 1, 1, '2022-10-27 06:27:52', '2022-10-27 09:08:50', NULL),
(8, 'TC00008', '2022-09-01', NULL, NULL, NULL, NULL, 8, 10, 2, 1, 'BG BUSINESS', '', '651.03', 'TRNS_1667307240.png', 1, NULL, '2022-11-01 06:54:00', '2022-11-01 06:54:00', NULL),
(9, 'TC00009', '2022-08-31', NULL, NULL, '103981', '2022-11-03', 3, 10, 1, 0, 'SLC-FEE LOAN FT', 'This is desc', '1500.00', 'TRNS_1667307375.png', 1, NULL, '2022-11-01 06:56:17', '2022-11-01 06:56:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_csv_datas`
--

DROP TABLE IF EXISTS `transaction_csv_datas`;
CREATE TABLE IF NOT EXISTS `transaction_csv_datas` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `file_name` varchar(199) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trans_date` date DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `amount` decimal(10,2) NOT NULL,
  `transaction_type` tinyint(4) DEFAULT NULL COMMENT '0=Inflow, 1=Outflow',
  `bank_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction_csv_datas`
--

INSERT INTO `transaction_csv_datas` (`id`, `file_name`, `trans_date`, `description`, `amount`, `transaction_type`, `bank_id`, `created_at`, `updated_at`) VALUES
(9, 'RT_20220902_61798643.csv', '2022-08-31', 'SLC-FEE LOAN FT', '1500.00', 0, 5, '2022-11-01 07:00:41', '2022-11-01 07:00:41'),
(8, 'RT_20220902_61798643.csv', '2022-09-01', 'BG BUSINESS', '651.03', 1, 5, '2022-11-01 07:00:41', '2022-11-01 07:00:41'),
(3, 'RT_20220902_61798642.csv', '2022-08-25', 'NEST', '41.48', 1, 10, '2022-10-31 07:38:42', '2022-10-31 07:38:42'),
(4, 'RT_20220902_61798642.csv', '2022-08-25', 'GOCARDLESS', '115.61', 1, 10, '2022-10-31 07:38:42', '2022-10-31 07:38:42'),
(5, 'RT_20220902_61798642.csv', '2022-08-24', 'SLC-FEE LOAN FT', '7500.00', 0, 10, '2022-10-31 07:38:42', '2022-10-31 07:38:42'),
(6, 'RT_20220902_61798642.csv', '2022-08-19', 'LONDON BOR NEWHAM', '1746.00', 1, 10, '2022-10-31 07:38:42', '2022-10-31 07:38:42'),
(7, 'RT_20220902_61798642.csv', '2022-08-17', 'SLC-FEE LOAN FT', '30000.00', 0, 10, '2022-10-31 07:38:42', '2022-10-31 07:38:42'),
(10, 'RT_20220902_61798643.csv', '2022-08-25', 'NEST', '41.48', 1, 5, '2022-11-01 07:00:41', '2022-11-01 07:00:41'),
(11, 'RT_20220902_61798643.csv', '2022-08-25', 'GOCARDLESS', '115.61', 1, 5, '2022-11-01 07:00:41', '2022-11-01 07:00:41'),
(12, 'RT_20220902_61798643.csv', '2022-08-24', 'SLC-FEE LOAN FT', '7500.00', 0, 5, '2022-11-01 07:00:41', '2022-11-01 07:00:41'),
(13, 'RT_20220902_61798643.csv', '2022-08-19', 'LONDON BOR NEWHAM', '1746.00', 1, 5, '2022-11-01 07:00:41', '2022-11-01 07:00:41'),
(14, 'RT_20220902_61798643.csv', '2022-08-17', 'SLC-FEE LOAN FT', '30000.00', 0, 5, '2022-11-01 07:00:41', '2022-11-01 07:00:41'),
(15, 'Transactions.csv', '2017-06-15', 'Fai = MBP ', '12.12', 0, 2, '2023-04-04 07:44:15', '2023-04-04 07:44:15'),
(16, 'Transactions.csv', '2017-06-15', 'PAYPAL *INTEGRATED =35314369001 ', '5.99', 0, 2, '2023-04-04 07:44:15', '2023-04-04 07:44:15');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_logs`
--

DROP TABLE IF EXISTS `transaction_logs`;
CREATE TABLE IF NOT EXISTS `transaction_logs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `old_amount` decimal(10,2) NOT NULL,
  `new_amount` decimal(10,2) NOT NULL,
  `log_date` date DEFAULT NULL,
  `log_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction_logs`
--

INSERT INTO `transaction_logs` (`id`, `transaction_id`, `user_id`, `old_amount`, `new_amount`, `log_date`, `log_type`, `created_at`, `updated_at`) VALUES
(1, 7, 1, '2500.00', '2000.00', '2022-10-27', 'Edit', '2022-10-27 09:08:50', '2022-10-27 09:08:50'),
(2, 8, 1, '0.00', '651.03', '2022-11-01', 'Add', '2022-11-01 06:54:00', '2022-11-01 06:54:00'),
(3, 9, 1, '0.00', '1500.00', '2022-11-01', 'Add', '2022-11-01 06:56:17', '2022-11-01 06:56:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_code` int(11) DEFAULT NULL,
  `active` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `photo`, `gender`, `user_code`, `active`, `deleted_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Left4code', 'midone@left4code.com', '2022-10-16 05:23:24', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'male', NULL, 1, NULL, 'g7rTPKOMz3TB4tJCiAispggbQRhbmnRGkF0qh2EnFX0cOZhOakM9CmZ6WbAq', NULL, NULL),
(2, 'Dion Quigley', 'dickens.leola@example.net', '2022-10-16 05:23:26', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'male', NULL, 1, NULL, 'I45ynXMjs8', '2022-10-16 05:23:26', '2022-10-16 05:23:26'),
(3, 'Victoria Smith', 'stroman.samson@example.net', '2022-10-16 05:23:26', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'male', NULL, 1, NULL, 'cCDHToYao6', '2022-10-16 05:23:26', '2022-10-16 05:23:26'),
(4, 'Dr. Yadira Treutel I', 'lgottlieb@example.com', '2022-10-16 05:23:26', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'female', NULL, 1, NULL, 'fm9LhcMGYu', '2022-10-16 05:23:26', '2022-10-16 05:23:26'),
(5, 'Mrs. Elfrieda Kerluke', 'fahey.leon@example.org', '2022-10-16 05:23:26', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'female', NULL, 1, NULL, '8hIVHJDQ56', '2022-10-16 05:23:26', '2022-10-16 05:23:26'),
(6, 'Marley Hilpert', 'aurore28@example.net', '2022-10-16 05:23:26', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'female', NULL, 1, NULL, 'NMBgdOZzCg', '2022-10-16 05:23:26', '2022-10-16 05:23:26'),
(7, 'Maritza Mraz', 'mills.raina@example.com', '2022-10-16 05:23:26', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'female', NULL, 1, NULL, 'VeEMVD5qUl', '2022-10-16 05:23:26', '2022-10-16 05:23:26'),
(8, 'Trevion Hagenes', 'charlie08@example.net', '2022-10-16 05:23:26', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'male', NULL, 1, NULL, 'AhBkp8258L', '2022-10-16 05:23:26', '2022-10-16 05:23:26'),
(9, 'Nikki Schamberger', 'conn.jacinto@example.com', '2022-10-16 05:23:26', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'female', NULL, 1, NULL, 'fzAbkuWbhD', '2022-10-16 05:23:26', '2022-10-16 05:23:26'),
(10, 'Idella Dickens', 'lstark@example.com', '2022-10-16 05:23:26', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'female', NULL, 1, NULL, 'zKuezHgQEM', '2022-10-16 05:23:26', '2022-10-16 05:23:26');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

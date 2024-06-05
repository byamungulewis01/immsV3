-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2023 at 11:13 AM
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
-- Database: `immsv3`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Permissions Management', NULL, '2023-04-10 18:03:52'),
(2, 'Branch Management', NULL, NULL),
(3, 'Roles Management', NULL, '2023-04-10 18:03:29'),
(4, 'Setting Management', NULL, NULL),
(5, 'Employees Management', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pob` bigint(20) NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('payee','impayee') NOT NULL DEFAULT 'impayee',
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pob_category` varchar(255) NOT NULL,
  `pob_type` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `is_new_customer` enum('yes','no') NOT NULL,
  `aprooved` tinyint(4) NOT NULL DEFAULT 0,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `pob`, `branch_id`, `status`, `name`, `phone`, `email`, `pob_category`, `pob_type`, `amount`, `year`, `attachment`, `is_new_customer`, `aprooved`, `customer_id`, `created_at`, `updated_at`) VALUES
(1, 6, 3, 'payee', 'Bethfage Choir', '0784466663', 'bethfagechoir@gmail.com', 'Eglise', 'Company', 18000, 2023, '1682147383.pdf', 'yes', 1, 1, '2023-04-22 05:09:43', '2023-04-23 19:06:52'),
(2, 5, 1, 'payee', 'MUnguyiko Rasta', '0783662777', 'munguyiko@gmail.com', 'Individual', 'Individual', 0, 2023, '1682148876.pdf', 'no', 1, 1, '2023-04-22 05:34:36', '2023-04-23 19:04:26'),
(3, 4, 4, 'payee', 'Emille Rba', '0784666377', 'emille@gmail.com', 'Individual', 'Individual', 12000, 2023, '1682149770.pdf', 'yes', 1, 2, '2023-04-22 05:49:30', '2023-04-24 05:32:31'),
(4, 2, 1, 'payee', 'Cadete Neighbou', '0783626262', 'lew@gmail.com', 'Banque', 'Company', 30000, 2023, '1682149862.pdf', 'yes', 1, 2, '2023-04-22 05:51:02', '2023-04-24 07:11:54'),
(5, 8, 1, 'payee', 'Nzambe Munene', '0783663622', 'nzambe@gmail.com', 'Individual', 'Individual', 0, 2023, '1682323608080440-vouchers (14).pdf', 'no', 0, 2, '2023-04-22 05:52:46', '2023-04-24 06:06:48'),
(6, 4, 1, 'payee', 'lkekke', '9377378288', 'ksdksdkl@fkn.com', 'Individual', 'Individual', 15000, 2023, '1682150017.pdf', 'yes', 3, 2, '2023-04-22 05:53:37', '2023-04-23 20:18:36');

-- --------------------------------------------------------

--
-- Table structure for table `boxes`
--

CREATE TABLE `boxes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pob` bigint(20) NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `size` enum('Pte','Gde') NOT NULL,
  `status` enum('payee','impayee') NOT NULL DEFAULT 'impayee',
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `pob_category` varchar(255) DEFAULT NULL,
  `pob_type` varchar(255) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `cotion` int(11) NOT NULL DEFAULT 0,
  `year` int(11) NOT NULL DEFAULT 2023,
  `available` tinyint(1) NOT NULL DEFAULT 0,
  `aprooved` tinyint(4) NOT NULL DEFAULT 0,
  `booked` tinyint(4) NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `boxes`
--

INSERT INTO `boxes` (`id`, `pob`, `branch_id`, `size`, `status`, `name`, `phone`, `email`, `date`, `pob_category`, `pob_type`, `amount`, `cotion`, `year`, `available`, `aprooved`, `booked`, `attachment`, `customer_id`, `created_at`, `updated_at`) VALUES
(10, 1, 2, 'Pte', 'payee', 'RUKARA Baetheremy', '+250788778503', NULL, '2022-01-31', 'Individual', 'Individual', 15000, 1, 2022, 0, 0, 0, NULL, 0, NULL, NULL),
(11, 2, 1, 'Pte', 'payee', 'Cadete Neighbou', '0783626262', 'lew@gmail.com', '2023-04-22', 'Banque', 'Company', 30000, 1, 2023, 0, 1, 1, '1682149862.pdf', 2, NULL, '2023-04-24 07:11:54'),
(12, 4, 4, 'Pte', 'payee', 'Emille Rba', '0784666377', 'emille@gmail.com', '2023-04-22', 'Individual', 'Individual', 12000, 0, 2023, 0, 1, 1, '1682149770.pdf', 2, NULL, '2023-04-24 05:32:31'),
(13, 5, 1, 'Pte', 'impayee', 'MUnguyiko Rasta', '0783662777', 'munguyiko@gmail.com', '2022-01-25', 'Individual', 'Individual', 7500, 1, 2022, 0, 1, 1, '1682148876.pdf', 1, NULL, '2023-04-23 19:04:26'),
(14, 6, 3, 'Pte', 'payee', 'Bethfage Choir', '0784466663', 'bethfagechoir@gmail.com', '2023-04-22', 'Eglise', 'Company', 18000, 1, 2023, 0, 1, 1, '1682147383.pdf', 1, NULL, '2023-04-23 19:06:52'),
(15, 7, 2, 'Pte', 'impayee', 'KAYITARE Celestin', '+250788301002', NULL, '2021-03-02', '', 'Individual', 7500, 1, 2022, 0, 0, 0, NULL, 0, NULL, NULL),
(16, 8, 2, 'Pte', 'payee', 'FLAIRWAY AVIATION LTD', '+250788309456', NULL, '2022-07-25', 'Company', 'Company', 30000, 1, 2022, 0, 0, 0, NULL, 0, NULL, NULL),
(17, 9, 2, 'Pte', 'payee', 'Ntwari Lebon', '0783666666', 'ntwari@gmail.com', '2023-04-18', 'Individual', 'Individual', 15000, 1, 2023, 0, 1, 0, '1681855934.pdf', 1, NULL, '2023-04-21 08:19:34'),
(18, 10, 2, 'Pte', 'payee', 'KUBWIMANA Bernadette(SOCOR)', '+250788305491', NULL, '0000-00-00', 'Company', 'Company', 30000, 1, 2019, 0, 0, 0, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'KIGALI', 'active', '2023-04-10 06:22:31', '2023-04-10 06:22:31'),
(2, 'MUSANZE', 'inactive', '2023-04-10 06:22:31', '2023-04-10 06:22:31'),
(3, 'RUBAVU', 'active', '2023-04-10 06:22:31', '2023-04-10 06:22:31'),
(4, 'KARONGI', 'inactive', '2023-04-10 06:22:31', '2023-04-10 06:22:31'),
(5, 'HUYE', 'active', '2023-04-10 06:22:31', '2023-04-10 06:22:31');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'BYAMUNGU Lewis', 'byamungulewis@gmail.com', NULL, '$2y$10$pxxcfKM.ha9Ud2aUdz6Nsud7QO8t/t/s7rQuWkxxUCWmDN7OjBnL2', NULL, '2023-04-10 13:23:25', '2023-04-10 13:23:25'),
(2, 'NDIKUMANA Eric', 'ndikumana@gmail.com', NULL, '$2y$10$C7piVo5mBzCE8Xx6BrbXvOMlA.3dwqU/qXKG8DoZsjJoBbQSetdDW', NULL, '2023-04-10 13:24:11', '2023-04-10 13:24:11');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2013_04_08_081140_create_branches_table', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2022_04_08_151459_create_activities_table', 1),
(7, '2023_04_05_070958_create_permission_tables', 1),
(8, '2023_04_10_000000_create_customers_table', 2),
(9, '2023_04_12_082640_create_boxes_table', 3),
(10, '2023_04_12_182640_create_boxes_table', 4),
(11, '2023_04_12_282640_create_boxes_table', 5),
(12, '2023_04_13_282640_create_boxes_table', 6),
(13, '2023_04_17_282640_create_boxes_table', 7),
(14, '2023_04_18_175628_create_virtual_boxes_table', 8),
(15, '2023_04_18_175726_create_pob_accounts_table', 8),
(16, '2023_04_18_275628_create_virtual_boxes_table', 9),
(17, '2023_04_27_282640_create_boxes_table', 9),
(18, '2023_04_18_201619_create_pob_backups_table', 10),
(19, '2023_04_20_092014_create_pob_pays_table', 11),
(20, '2023_04_22_064303_create_applications_table', 12),
(21, '2023_04_22_164303_create_applications_table', 13);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 1),
(5, 'App\\Models\\User', 6);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `activity_id` bigint(20) UNSIGNED NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `activity_id`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'create branch', 2, 'web', '2023-04-10 18:06:20', '2023-04-10 18:06:20'),
(2, 'read branch', 2, 'web', '2023-04-10 18:06:33', '2023-04-10 18:06:33'),
(3, 'update branch', 2, 'web', '2023-04-10 18:06:48', '2023-04-10 18:06:48'),
(4, 'delete branch', 2, 'web', '2023-04-10 18:07:01', '2023-04-10 18:07:01'),
(5, 'create employee', 5, 'web', '2023-04-10 18:07:15', '2023-04-10 18:07:15'),
(6, 'read employee', 5, 'web', '2023-04-10 18:07:29', '2023-04-10 18:07:29'),
(7, 'update employee', 5, 'web', '2023-04-10 18:07:46', '2023-04-10 18:07:46'),
(8, 'delete employee', 5, 'web', '2023-04-10 18:10:17', '2023-04-10 18:10:17'),
(9, 'read roles', 3, 'web', '2023-04-11 07:52:30', '2023-04-11 07:52:30'),
(10, 'create roles', 3, 'web', '2023-04-11 08:18:06', '2023-04-11 08:18:06'),
(11, 'update roles', 3, 'web', '2023-04-11 08:18:25', '2023-04-11 08:19:19'),
(12, 'delete roles', 3, 'web', '2023-04-11 08:18:56', '2023-04-11 08:18:56'),
(13, 'create permission', 1, 'web', '2023-04-11 08:20:22', '2023-04-11 08:20:22'),
(14, 'read permission', 1, 'web', '2023-04-11 08:20:42', '2023-04-11 08:20:42'),
(15, 'update permission', 1, 'web', '2023-04-11 08:21:24', '2023-04-11 08:21:42'),
(16, 'delete permission', 1, 'web', '2023-04-11 08:22:22', '2023-04-11 08:22:22'),
(17, 'read setting', 4, 'web', '2023-04-11 08:23:21', '2023-04-11 08:25:29'),
(18, 'create setting', 4, 'web', '2023-04-11 08:25:51', '2023-04-11 08:25:51'),
(19, 'update setting', 4, 'web', '2023-04-11 08:26:11', '2023-04-11 08:26:11'),
(20, 'delete setting', 4, 'web', '2023-04-11 08:26:41', '2023-04-11 08:26:41');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pob_backups`
--

CREATE TABLE `pob_backups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pob` bigint(20) NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `size` enum('Pte','Gde') NOT NULL,
  `status` enum('payee','impayee') NOT NULL DEFAULT 'impayee',
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `pob_category` varchar(255) DEFAULT NULL,
  `pob_type` varchar(255) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `cotion` int(11) NOT NULL DEFAULT 0,
  `year` int(11) NOT NULL DEFAULT 2023,
  `available` tinyint(1) NOT NULL DEFAULT 0,
  `attachment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pob_backups`
--

INSERT INTO `pob_backups` (`id`, `pob`, `branch_id`, `size`, `status`, `name`, `phone`, `email`, `date`, `pob_category`, `pob_type`, `amount`, `cotion`, `year`, `available`, `attachment`, `created_at`, `updated_at`) VALUES
(1, 2, 2, 'Pte', 'impayee', 'ADRA', ' ', NULL, '2021-12-14', 'Ese Privee', 'Company', 30000, 0, 2022, 1, NULL, '2023-04-18 19:41:13', '2023-04-18 19:41:13'),
(2, 6, 2, 'Pte', 'payee', 'MASHAKA Zenith et GATURO Hypax', '+250780840550', NULL, '2021-05-20', 'Individual', 'Individual', 15000, 0, 2021, 1, NULL, '2023-04-18 20:01:53', '2023-04-18 20:01:53'),
(3, 9, 2, 'Pte', 'payee', 'MRIYA LTD', '+250788306478', NULL, NULL, 'Ese Privee', 'Company', 30000, 0, 2019, 1, NULL, '2023-04-18 20:12:14', '2023-04-18 20:12:14'),
(4, 2, 2, 'Pte', 'impayee', 'BYAMUNGU Lewis', '0786363662', 'byamungu@gmail.com', '2023-04-18', 'Individual', 'Individual', 15000, 0, 2023, 0, NULL, '2023-04-20 03:41:18', '2023-04-20 03:41:18'),
(5, 2, 2, 'Pte', 'impayee', 'BYAMUNGU Lewis', '0786363662', 'byamungu@gmail.com', '2023-04-18', 'Individual', 'Individual', 15000, 0, 2023, 1, NULL, '2023-04-24 07:11:54', '2023-04-24 07:11:54');

-- --------------------------------------------------------

--
-- Table structure for table `pob_pays`
--

CREATE TABLE `pob_pays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `box_id` bigint(20) UNSIGNED NOT NULL,
  `amount` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `payment_model` varchar(255) NOT NULL,
  `payment_ref` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pob_pays`
--

INSERT INTO `pob_pays` (`id`, `box_id`, `amount`, `year`, `payment_type`, `payment_model`, `payment_ref`, `created_at`, `updated_at`) VALUES
(1, 14, 22500, 2021, 'rent', 'mobile_money', '#jii', '2023-04-20 13:35:31', '2023-04-20 13:35:31'),
(2, 12, 18750, 2023, 'rent', 'bank', 'LJJSS', '2023-04-20 13:37:09', '2023-04-20 13:37:09'),
(3, 14, 22500, 2022, 'rent', 'bank', 'LK7788', '2023-04-20 14:54:51', '2023-04-20 14:54:51');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Branch Manager', 'web', '2023-04-10 18:08:32', '2023-04-10 18:08:32'),
(2, 'Administrator', 'web', '2023-04-10 18:20:26', '2023-04-10 18:20:26'),
(3, 'Percel Users', 'web', '2023-04-10 18:28:45', '2023-04-10 18:29:07'),
(5, 'New Admin', 'web', '2023-04-16 16:41:59', '2023-04-16 16:41:59');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 3),
(2, 1),
(2, 3),
(3, 1),
(3, 3),
(4, 1),
(5, 1),
(5, 2),
(5, 3),
(6, 1),
(6, 2),
(6, 3),
(7, 1),
(7, 2),
(7, 3),
(8, 1),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(14, 5),
(15, 2),
(16, 2),
(17, 2),
(18, 2),
(19, 2),
(20, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `branch` bigint(20) UNSIGNED NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `status`, `branch`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'BYAMUNGU Lewis', 'byamungulewis@gmail.com', '0785436135', 'active', 1, NULL, '$2y$10$MkB9hivR3aJGj.SB3tx/m.TzwIOQ.IOP2PFGkTuO.gVtlWYGFjekC', NULL, '2023-04-10 06:22:31', '2023-04-10 11:37:23'),
(2, 'NTWARI Lebon', 'ntwarilebon09@gmail.com', '07221672722', 'active', 2, NULL, '$2y$10$X6Rd7N06.ku5KonlU3nyNebPFbSHnghxofXa0gXVUbU7v2kPOTdv2', NULL, '2023-04-10 06:22:31', '2023-04-11 13:43:32'),
(3, 'ISHIMWE Gloria', 'gloria@gmail.com', '0789818378', 'inactive', 3, NULL, '$2y$10$BMFO/SHHUDErR2BuiPR4SOWZZstkDZRy0oaWY4vKcE19OACAOPIBG', NULL, '2023-04-10 06:22:31', '2023-04-10 11:40:47'),
(4, 'NDIKUMANA Eric', 'ndikumanaeric001@gmail.com', '0782185745', 'inactive', 4, NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, '2023-04-10 06:22:31', '2023-04-10 06:22:31'),
(6, 'UMUTUZO Aime', 'aime@gmail.com', '0783355566', 'active', 5, NULL, '$2y$10$PR3YOYHiCs90hqWEfLapWOrjrPd.AUXpcUh6q1Z09Sqf8xhJsxYMe', NULL, '2023-04-12 05:41:42', '2023-04-16 16:43:05'),
(3007, 'UMWIZAWASE Fanny', 'umwizawase@gmail.com', '0782277733', 'active', 4, NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, '2023-04-15 09:58:53', '2023-04-15 09:58:53'),
(3008, 'AKIMANA Olivie', 'akimana@gmail.com', '0782662267', 'active', 2, NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, '2023-04-15 09:59:39', '2023-04-15 09:59:39'),
(3009, 'MUREKATETE Aisha', 'murekatete@gmail.com', '0783666277', 'active', 4, NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, '2023-04-15 10:00:36', '2023-04-15 10:00:36'),
(3010, 'NYIRAMASENGESHO Joselyne', 'nyiramasengesho@gmail.com', '0782266262', 'inactive', 4, NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, '2023-04-15 10:01:31', '2023-04-15 10:01:31'),
(3011, 'Jean MULISE', 'milise@gmail.com', '0783662663', 'active', 2, NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, '2023-04-15 10:02:18', '2023-04-15 10:02:18'),
(3012, 'DUSABE Rose', 'dusabe@gmail.com', '0782255666', 'active', 2, NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, '2023-04-15 10:03:06', '2023-04-15 10:03:06'),
(3013, 'NYIRAMATUNGO Honolyne', 'nyiramatungo@gmail.com', '0783342555', 'inactive', 4, NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, '2023-04-15 10:04:00', '2023-04-15 10:04:00'),
(3014, 'Israel', 'israel@gmail.com', '0766636333', 'active', 2, NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, '2023-04-22 05:44:22', '2023-04-22 05:44:22');

-- --------------------------------------------------------

--
-- Table structure for table `virtual_boxes`
--

CREATE TABLE `virtual_boxes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('payee','impayee') NOT NULL DEFAULT 'impayee',
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `pob_category` varchar(255) NOT NULL,
  `pob_type` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `cotion` tinyint(1) NOT NULL DEFAULT 0,
  `year` int(11) NOT NULL DEFAULT 2023,
  `available` tinyint(1) NOT NULL DEFAULT 0,
  `attachment` varchar(255) DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `virtual_boxes`
--

INSERT INTO `virtual_boxes` (`id`, `branch_id`, `status`, `name`, `phone`, `email`, `date`, `pob_category`, `pob_type`, `amount`, `cotion`, `year`, `available`, `attachment`, `customer_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'payee', 'BYAMUNGU Lewis', '0783556666', 'lewis@gmail.com', '2023-04-18', 'Individual', 'Individual', 10000, 0, 2023, 0, '1681856389.pdf', 1, '2023-04-18 20:19:49', '2023-04-18 20:19:49'),
(2, 1, 'payee', 'SEGIHANGA Frederic KAMANZI Yv', '0788456630', 'Frederic@gmail.com', '2023-04-22', 'Individual', 'Individual', 10000, 0, 2023, 0, '1682148257.pdf', 1, '2023-04-22 05:24:17', '2023-04-22 05:24:17'),
(3, 1, 'payee', 'Lewis bmg', '0783566622', 'lewis@gmail.com', '2023-04-22', 'Individual', 'Individual', 10000, 0, 2023, 0, '1682148384.pdf', 1, '2023-04-22 05:26:24', '2023-04-22 05:26:24'),
(4, 1, 'payee', 'NDIKUMANA Eric', '0786636366', 'ndikumana@gmail.com', '2023-04-22', 'Individual', 'Individual', 10000, 0, 2023, 0, '1682149165.pdf', 2, '2023-04-22 05:39:25', '2023-04-22 05:39:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `applications_branch_id_foreign` (`branch_id`),
  ADD KEY `applications_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `boxes`
--
ALTER TABLE `boxes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `boxes_branch_id_foreign` (`branch_id`),
  ADD KEY `boxes_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `branches_name_unique` (`name`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`),
  ADD KEY `permissions_activity_id_foreign` (`activity_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pob_backups`
--
ALTER TABLE `pob_backups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pob_backups_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `pob_pays`
--
ALTER TABLE `pob_pays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pob_pays_box_id_foreign` (`box_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD KEY `users_branch_foreign` (`branch`);

--
-- Indexes for table `virtual_boxes`
--
ALTER TABLE `virtual_boxes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `virtual_boxes_phone_unique` (`phone`),
  ADD KEY `virtual_boxes_branch_id_foreign` (`branch_id`),
  ADD KEY `virtual_boxes_customer_id_foreign` (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `boxes`
--
ALTER TABLE `boxes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pob_backups`
--
ALTER TABLE `pob_backups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pob_pays`
--
ALTER TABLE `pob_pays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3015;

--
-- AUTO_INCREMENT for table `virtual_boxes`
--
ALTER TABLE `virtual_boxes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `applications_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `boxes`
--
ALTER TABLE `boxes`
  ADD CONSTRAINT `boxes_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `boxes_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_activity_id_foreign` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pob_backups`
--
ALTER TABLE `pob_backups`
  ADD CONSTRAINT `pob_backups_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pob_pays`
--
ALTER TABLE `pob_pays`
  ADD CONSTRAINT `pob_pays_box_id_foreign` FOREIGN KEY (`box_id`) REFERENCES `boxes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_branch_foreign` FOREIGN KEY (`branch`) REFERENCES `branches` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `virtual_boxes`
--
ALTER TABLE `virtual_boxes`
  ADD CONSTRAINT `virtual_boxes_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `virtual_boxes_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

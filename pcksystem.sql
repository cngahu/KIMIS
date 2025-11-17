-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2024 at 01:30 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pcksystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `counties`
--

CREATE TABLE `counties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `counties`
--

INSERT INTO `counties` (`id`, `name`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Mombasa', 0, NULL, NULL),
(2, 'KWALE', 1, NULL, NULL),
(3, 'KILIFI', 1, NULL, NULL),
(4, 'TANA RIVER', 1, NULL, NULL),
(5, 'LAMU', 1, NULL, NULL),
(6, 'TAITA TAVETA', 1, NULL, NULL),
(7, 'GARISSA', 1, NULL, NULL),
(8, 'WAJIR', 1, NULL, NULL),
(9, 'MANDERA', 1, NULL, NULL),
(10, 'MARSABIT', 1, NULL, NULL),
(11, 'ISIOLO', 1, NULL, NULL),
(12, 'MERU', 1, NULL, NULL),
(13, 'THARAKA - NITHI', 1, NULL, NULL),
(14, 'EMBU', 1, NULL, NULL),
(15, 'KITUI', 1, NULL, NULL),
(16, 'MACHAKOS', 1, NULL, NULL),
(17, 'MAKUENI', 1, NULL, NULL),
(18, 'NYANDARUA', 1, NULL, NULL),
(19, 'NYERI', 1, NULL, NULL),
(20, 'KIRINYAGA', 1, NULL, NULL),
(21, 'MURANG\'A', 1, NULL, NULL),
(22, 'KIAMBU', 1, NULL, NULL),
(23, 'TURKANA', 1, NULL, NULL),
(24, 'WEST POKOT', 1, NULL, NULL),
(25, 'SAMBURU', 1, NULL, NULL),
(26, 'TRANS NZOIA', 1, NULL, NULL),
(27, 'UASIN GISHU', 1, NULL, NULL),
(28, 'ELGEYO/MARAKWET', 1, NULL, NULL),
(29, 'NANDI', 1, NULL, NULL),
(30, 'BARINGO', 1, NULL, NULL),
(31, 'LAIKIPIA', 1, NULL, NULL),
(32, 'NAKURU', 1, NULL, NULL),
(33, 'NAROK', 1, NULL, NULL),
(34, 'KAJIADO', 1, NULL, NULL),
(35, 'KERICHO', 1, NULL, NULL),
(36, 'BOMET', 1, NULL, NULL),
(37, 'KAKAMEGA', 1, NULL, NULL),
(38, 'VIHIGA', 1, NULL, NULL),
(39, 'BUNGOMA', 1, NULL, NULL),
(40, 'BUSIA', 1, NULL, NULL),
(41, 'SIAYA', 1, NULL, NULL),
(42, 'KISUMU', 1, NULL, NULL),
(43, 'HOMA BAY', 1, NULL, NULL),
(44, 'MIGORI', 1, NULL, NULL),
(45, 'KISII', 1, NULL, NULL),
(46, 'NYAMIRA', 1, NULL, NULL),
(47, 'NAIROBI CITY', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Kenya', NULL, NULL),
(2, 'Afghanistan', NULL, NULL),
(3, '?land (Finland)', NULL, NULL),
(4, 'Albania', NULL, NULL),
(5, 'Algeria', NULL, NULL),
(6, 'American Samoa (US)', NULL, NULL),
(7, 'Andorra', NULL, NULL),
(8, 'Angola', NULL, NULL),
(9, 'Anguilla (BOT)', NULL, NULL),
(10, 'Antigua and Barbuda', NULL, NULL),
(11, 'Argentina', NULL, NULL),
(12, 'Armenia', NULL, NULL),
(13, 'Artsakh', NULL, NULL),
(14, 'Aruba (Netherlands)', NULL, NULL),
(15, 'Australia', NULL, NULL),
(16, 'Austria', NULL, NULL),
(17, 'Azerbaijan', NULL, NULL),
(18, 'Bahamas', NULL, NULL),
(19, 'Bahrain', NULL, NULL),
(20, 'Bangladesh', NULL, NULL),
(21, 'Barbados', NULL, NULL),
(22, 'Belarus', NULL, NULL),
(23, 'Belgium', NULL, NULL),
(24, 'Belize', NULL, NULL),
(25, 'Benin', NULL, NULL),
(26, 'Bermuda (BOT)', NULL, NULL),
(27, 'Bhutan', NULL, NULL),
(28, 'Bolivia', NULL, NULL),
(29, 'Bonaire (Netherlands)', NULL, NULL),
(30, 'Bosnia and Herzegovina', NULL, NULL),
(31, 'Botswana', NULL, NULL),
(32, 'Brazil', NULL, NULL),
(33, 'British Virgin Islands (BOT)', NULL, NULL),
(34, 'Brunei', NULL, NULL),
(35, 'Bulgaria', NULL, NULL),
(36, 'Burkina Faso', NULL, NULL),
(37, 'Burundi', NULL, NULL),
(38, 'Cambodia', NULL, NULL),
(39, 'Cameroon', NULL, NULL),
(40, 'Canada', NULL, NULL),
(41, 'Cape Verde', NULL, NULL),
(42, 'Cayman Islands (BOT)', NULL, NULL),
(43, 'Central African Republic', NULL, NULL),
(44, 'Chad', NULL, NULL),
(45, 'Chile', NULL, NULL),
(46, 'China', NULL, NULL),
(47, 'Christmas Island (Australia)', NULL, NULL),
(48, 'Cocos (Keeling) Islands (Australia)', NULL, NULL),
(49, 'Colombia', NULL, NULL),
(50, 'Comoros', NULL, NULL),
(51, 'Congo', NULL, NULL),
(52, 'Cook Islands', NULL, NULL),
(53, 'Costa Rica', NULL, NULL),
(54, 'Croatia', NULL, NULL),
(55, 'Cuba', NULL, NULL),
(56, 'Cura?ao (Netherlands)', NULL, NULL),
(57, 'Cyprus', NULL, NULL),
(58, 'Czech Republic', NULL, NULL),
(59, 'Denmark', NULL, NULL),
(60, 'Djibouti', NULL, NULL),
(61, 'Dominica', NULL, NULL),
(62, 'Dominican Republic', NULL, NULL),
(63, 'DR Congo', NULL, NULL),
(64, 'East Timor', NULL, NULL),
(65, 'Ecuador', NULL, NULL),
(66, 'Egypt', NULL, NULL),
(67, 'El Salvador', NULL, NULL),
(68, 'Equatorial Guinea', NULL, NULL),
(69, 'Eritrea', NULL, NULL),
(70, 'Estonia', NULL, NULL),
(71, 'Eswatini', NULL, NULL),
(72, 'Ethiopia', NULL, NULL),
(73, 'Falkland Islands (BOT)', NULL, NULL),
(74, 'Faroe Islands (Denmark)', NULL, NULL),
(75, 'Fiji', NULL, NULL),
(76, 'Finland', NULL, NULL),
(77, 'France', NULL, NULL),
(78, 'French Guiana (France)', NULL, NULL),
(79, 'French Polynesia (France)', NULL, NULL),
(80, 'Gabon', NULL, NULL),
(81, 'Gambia', NULL, NULL),
(82, 'Georgia', NULL, NULL),
(83, 'Germany', NULL, NULL),
(84, 'Ghana', NULL, NULL),
(85, 'Gibraltar (BOT)', NULL, NULL),
(86, 'Greece', NULL, NULL),
(87, 'Greenland (Denmark)', NULL, NULL),
(88, 'Grenada', NULL, NULL),
(89, 'Guadeloupe (France)', NULL, NULL),
(90, 'Guam (US)', NULL, NULL),
(91, 'Guatemala', NULL, NULL),
(92, 'Guernsey (Crown Dependency)', NULL, NULL),
(93, 'Guinea', NULL, NULL),
(94, 'Guinea-Bissau', NULL, NULL),
(95, 'Guyana', NULL, NULL),
(96, 'Haiti', NULL, NULL),
(97, 'Honduras', NULL, NULL),
(98, 'Hong Kong', NULL, NULL),
(99, 'Hungary', NULL, NULL),
(100, 'Iceland', NULL, NULL),
(101, 'India', NULL, NULL),
(102, 'Indonesia', NULL, NULL),
(103, 'Iran', NULL, NULL),
(104, 'Iraq', NULL, NULL),
(105, 'Ireland', NULL, NULL),
(106, 'Isle of Man (Crown Dependency)', NULL, NULL),
(107, 'Israel', NULL, NULL),
(108, 'Italy', NULL, NULL),
(109, 'Ivory Coast', NULL, NULL),
(110, 'Jamaica', NULL, NULL),
(111, 'Japan', NULL, NULL),
(112, 'Jersey (Crown Dependency)', NULL, NULL),
(113, 'Jordan', NULL, NULL),
(114, 'Kazakhstan', NULL, NULL),
(115, 'Kenya', NULL, NULL),
(116, 'Kiribati', NULL, NULL),
(117, 'Kosovo', NULL, NULL),
(118, 'Kuwait', NULL, NULL),
(119, 'Kyrgyzstan', NULL, NULL),
(120, 'Laos', NULL, NULL),
(121, 'Latvia', NULL, NULL),
(122, 'Lebanon', NULL, NULL),
(123, 'Lesotho', NULL, NULL),
(124, 'Liberia', NULL, NULL),
(125, 'Libya', NULL, NULL),
(126, 'Liechtenstein', NULL, NULL),
(127, 'Lithuania', NULL, NULL),
(128, 'Luxembourg', NULL, NULL),
(129, 'Macau', NULL, NULL),
(130, 'Madagascar', NULL, NULL),
(131, 'Malawi', NULL, NULL),
(132, 'Malaysia', NULL, NULL),
(133, 'Maldives', NULL, NULL),
(134, 'Mali', NULL, NULL),
(135, 'Malta', NULL, NULL),
(136, 'Marshall Islands', NULL, NULL),
(137, 'Martinique (France)', NULL, NULL),
(138, 'Mauritania', NULL, NULL),
(139, 'Mauritius', NULL, NULL),
(140, 'Mayotte (France)', NULL, NULL),
(141, 'Mexico', NULL, NULL),
(142, 'Micronesia', NULL, NULL),
(143, 'Moldova', NULL, NULL),
(144, 'Monaco', NULL, NULL),
(145, 'Mongolia', NULL, NULL),
(146, 'Montenegro', NULL, NULL),
(147, 'Montserrat (BOT)', NULL, NULL),
(148, 'Morocco', NULL, NULL),
(149, 'Mozambique', NULL, NULL),
(150, 'Myanmar', NULL, NULL),
(151, 'Namibia', NULL, NULL),
(152, 'Nauru', NULL, NULL),
(153, 'Nepal', NULL, NULL),
(154, 'Netherlands', NULL, NULL),
(155, 'New Caledonia (France)', NULL, NULL),
(156, 'New Zealand', NULL, NULL),
(157, 'Nicaragua', NULL, NULL),
(158, 'Niger', NULL, NULL),
(159, 'Nigeria', NULL, NULL),
(160, 'Niue', NULL, NULL),
(161, 'Norfolk Island (Australia)', NULL, NULL),
(162, 'North Korea', NULL, NULL),
(163, 'North Macedonia', NULL, NULL),
(164, 'Northern Cyprus', NULL, NULL),
(165, 'Northern Mariana Islands (US)', NULL, NULL),
(166, 'Norway', NULL, NULL),
(167, 'Oman', NULL, NULL),
(168, 'Pakistan', NULL, NULL),
(169, 'Palau', NULL, NULL),
(170, 'Palestine', NULL, NULL),
(171, 'Panama', NULL, NULL),
(172, 'Papua New Guinea', NULL, NULL),
(173, 'Paraguay', NULL, NULL),
(174, 'Peru', NULL, NULL),
(175, 'Philippines', NULL, NULL),
(176, 'Pitcairn Islands (BOT)', NULL, NULL),
(177, 'Poland', NULL, NULL),
(178, 'Portugal', NULL, NULL),
(179, 'Puerto Rico (US)', NULL, NULL),
(180, 'Qatar', NULL, NULL),
(181, 'R?union (France)', NULL, NULL),
(182, 'Romania', NULL, NULL),
(183, 'Russia', NULL, NULL),
(184, 'Rwanda', NULL, NULL),
(185, 'Saba (Netherlands)', NULL, NULL),
(186, 'Saint Barth?lemy (France)', NULL, NULL),
(187, 'Saint Helena, Ascension and Tristan da Cunha (BOT)', NULL, NULL),
(188, 'Saint Kitts and Nevis', NULL, NULL),
(189, 'Saint Lucia', NULL, NULL),
(190, 'Saint Martin (France)', NULL, NULL),
(191, 'Saint Pierre and Miquelon (France)', NULL, NULL),
(192, 'Saint Vincent and the Grenadines', NULL, NULL),
(193, 'Samoa', NULL, NULL),
(194, 'San Marino', NULL, NULL),
(195, 'S?o Tom? and Pr?ncipe', NULL, NULL),
(196, 'Saudi Arabia', NULL, NULL),
(197, 'Senegal', NULL, NULL),
(198, 'Serbia', NULL, NULL),
(199, 'Seychelles', NULL, NULL),
(200, 'Sierra Leone', NULL, NULL),
(201, 'Singapore', NULL, NULL),
(202, 'Sint Eustatius (Netherlands)', NULL, NULL),
(203, 'Sint Maarten (Netherlands)', NULL, NULL),
(204, 'Slovakia', NULL, NULL),
(205, 'Slovenia', NULL, NULL),
(206, 'Solomon Islands', NULL, NULL),
(207, 'Somalia', NULL, NULL),
(208, 'South Africa', NULL, NULL),
(209, 'South Korea', NULL, NULL),
(210, 'South Sudan', NULL, NULL),
(211, 'Spain', NULL, NULL),
(212, 'Sri Lanka', NULL, NULL),
(213, 'Sudan', NULL, NULL),
(214, 'Suriname', NULL, NULL),
(215, 'Svalbard and Jan Mayen (Norway)', NULL, NULL),
(216, 'Sweden', NULL, NULL),
(217, 'Switzerland', NULL, NULL),
(218, 'Syria', NULL, NULL),
(219, 'Taiwan', NULL, NULL),
(220, 'Tajikistan', NULL, NULL),
(221, 'Tanzania', NULL, NULL),
(222, 'Thailand', NULL, NULL),
(223, 'Togo', NULL, NULL),
(224, 'Tokelau (NZ)', NULL, NULL),
(225, 'Tonga', NULL, NULL),
(226, 'Transnistria', NULL, NULL),
(227, 'Trinidad and Tobago', NULL, NULL),
(228, 'Tunisia', NULL, NULL),
(229, 'Turkey', NULL, NULL),
(230, 'Turkmenistan', NULL, NULL),
(231, 'Turks and Caicos Islands (BOT)', NULL, NULL),
(232, 'Tuvalu', NULL, NULL),
(233, 'U.S. Virgin Islands (US)', NULL, NULL),
(234, 'Uganda', NULL, NULL),
(235, 'Ukraine', NULL, NULL),
(236, 'United Arab Emirates', NULL, NULL),
(237, 'United Kingdom', NULL, NULL),
(238, 'United States', NULL, NULL),
(239, 'Uruguay', NULL, NULL),
(240, 'Uzbekistan', NULL, NULL),
(241, 'Vanuatu', NULL, NULL),
(242, 'Vatican City', NULL, NULL),
(243, 'Venezuela', NULL, NULL),
(244, 'Vietnam', NULL, NULL),
(245, 'Wallis and Futuna (France)', NULL, NULL),
(246, 'Western Sahara', NULL, NULL),
(247, 'Yemen', NULL, NULL),
(248, 'Zambia', NULL, NULL),
(249, 'Zimbabwe', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `educationqualifications`
--

CREATE TABLE `educationqualifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `userid` int(11) NOT NULL,
  `academiclevel` varchar(255) NOT NULL,
  `startDate` date NOT NULL,
  `exitDate` date NOT NULL,
  `institutionName` varchar(255) NOT NULL,
  `grade` varchar(255) DEFAULT NULL,
  `certificate` varchar(255) NOT NULL,
  `entryDate` date NOT NULL,
  `country` bigint(20) UNSIGNED NOT NULL,
  `institution_contact` varchar(255) DEFAULT NULL,
  `course_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `educationqualifications`
--

INSERT INTO `educationqualifications` (`id`, `created_at`, `updated_at`, `userid`, `academiclevel`, `startDate`, `exitDate`, `institutionName`, `grade`, `certificate`, `entryDate`, `country`, `institution_contact`, `course_name`) VALUES
(1, '2024-01-25 05:49:18', '2024-01-25 05:49:18', 16, 'Primary', '1982-09-16', '1996-09-26', 'Harris', 'Exercitation aut ut', 'upload/educationqual/EQ-1.pdf', '2024-01-25', 115, NULL, NULL),
(2, '2024-01-25 06:09:05', '2024-01-25 06:09:05', 16, 'Secondary', '2008-02-11', '2011-11-25', 'KAVAU', 'KCSE', 'upload/educationqual/EQ-2.pdf', '2024-01-25', 1, NULL, NULL),
(3, '2024-01-25 06:53:52', '2024-01-25 06:53:52', 16, 'Degree', '2024-01-02', '2024-01-16', 'JKUAT', NULL, 'upload/educationqual/EQ-3.pdf', '2024-01-25', 115, '07899090909', 'PHYSIO'),
(4, '2024-01-25 07:35:15', '2024-01-25 07:35:15', 18, 'Primary', '2024-01-01', '2024-01-01', 'gghgg', 'yyyy', 'upload/educationqual/EQ-4.pdf', '2024-01-25', 8, NULL, NULL),
(5, '2024-01-25 07:35:32', '2024-01-25 07:35:32', 18, 'Secondary', '2024-01-02', '2024-01-17', 'gfgffgv', 'fgfg', 'upload/educationqual/EQ-5.pdf', '2024-01-25', 16, NULL, NULL),
(6, '2024-01-25 07:36:04', '2024-01-25 07:36:04', 18, 'Degree', '2024-01-02', '2024-01-03', 'JKUAT', NULL, 'upload/educationqual/EQ-6.pdf', '2024-01-25', 115, '07899090909', 'PHYSIO'),
(7, '2024-01-25 08:39:46', '2024-01-25 08:39:46', 19, 'Primary', '2012-01-01', '2014-05-08', 'manahu pry schhol', 'KCPE', 'upload/educationqual/EQ-7.pdf', '2024-01-25', 1, NULL, NULL),
(8, '2024-01-25 08:40:30', '2024-01-25 08:40:30', 19, 'Secondary', '2015-12-28', '2018-02-06', 'CISA', 'KCSE', 'upload/educationqual/EQ-8.pdf', '2024-01-25', 1, NULL, NULL),
(9, '2024-01-25 08:41:36', '2024-01-25 08:41:36', 19, 'Diploma', '2014-01-08', '2017-01-01', 'JKUAT', NULL, 'upload/educationqual/EQ-9.pdf', '2024-01-25', 1, '07899090909', 'PHYSIOTHERAPY'),
(10, '2024-02-29 14:59:05', '2024-02-29 14:59:05', 20, 'Primary', '2018-01-01', '2020-05-12', 'KAMUNE', 'KCSE', 'upload/educationqual/EQ-10.pdf', '2024-02-29', 115, NULL, NULL),
(11, '2024-02-29 14:59:41', '2024-02-29 14:59:41', 20, 'Secondary', '2019-12-30', '2020-06-23', 'CISA', 'KCSE', 'upload/educationqual/EQ-11.pdf', '2024-02-29', 115, NULL, NULL),
(12, '2024-02-29 15:00:06', '2024-02-29 15:00:06', 20, 'Degree', '1980-04-27', '1977-12-25', 'Britanney Lamb', NULL, 'upload/educationqual/EQ-12.pdf', '2024-02-29', 180, '+1 (793) 691-5836', 'Quin Meyers');

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
-- Table structure for table `genders`
--

CREATE TABLE `genders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `genders`
--

INSERT INTO `genders` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Male', NULL, NULL),
(2, 'Female', NULL, NULL);

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_11_29_223607_create_permission_tables', 1),
(6, '2023_11_29_225204_add_group_name_to_permissions', 1),
(7, '2023_11_29_232949_create_modules_table', 1),
(8, '2023_12_04_194034_create_countries_table', 1),
(9, '2024_01_21_213403_add_password_reset_to_table', 1),
(10, '2024_01_22_114830_create_counties_table', 1),
(11, '2024_01_24_132621_create_genders_table', 1),
(12, '2024_01_24_132822_create_titles_table', 1),
(13, '2024_01_24_133001_add_newfields_to_table', 1),
(14, '2024_01_24_165357_add_level_to_table', 2),
(15, '2024_01_25_050048_add_nationalid_to_table', 3),
(16, '2024_01_25_050237_create_educationqualifications_table', 4),
(17, '2024_01_25_051851_add_national_id_to_table', 4),
(18, '2024_01_25_081003_add_columns_to_table', 5),
(19, '2024_01_25_083056_add_country_to_table', 6),
(20, '2024_01_25_092047_add_postsecondary_to_table', 7);

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
(1, 'App\\Models\\User', 14),
(2, 'App\\Models\\User', 16),
(2, 'App\\Models\\User', 17),
(2, 'App\\Models\\User', 18),
(2, 'App\\Models\\User', 19),
(2, 'App\\Models\\User', 20),
(2, 'App\\Models\\User', 21),
(2, 'App\\Models\\User', 22),
(2, 'App\\Models\\User', 23),
(2, 'App\\Models\\User', 24),
(2, 'App\\Models\\User', 25);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'roles and permissions', NULL, NULL),
(2, 'account', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('cwanguingahu@gmail.com', '$2y$12$YpGZMMSoZnllLjQX1lStselzl18HZIMWUS7tLIjfN.b/w2be/GCuC', '2024-01-24 12:29:14');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `group_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `group_name`) VALUES
(1, 'roles.menu', 'web', '2024-01-24 12:45:10', '2024-01-24 12:45:10', 'roles and permissions'),
(2, 'account.menu', 'web', '2024-01-24 14:04:16', '2024-01-24 14:04:16', 'account');

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
(1, 'superadmin', 'web', '2024-01-24 12:43:02', '2024-01-24 12:43:02'),
(2, 'applicant', 'web', '2024-01-24 13:12:30', '2024-01-24 13:12:30');

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
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `titles`
--

CREATE TABLE `titles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `titles`
--

INSERT INTO `titles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Dr', NULL, NULL),
(2, 'Mr', NULL, NULL),
(3, 'Ms', NULL, NULL),
(4, 'Mrs', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `surname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `othername` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `must_change_password` tinyint(1) NOT NULL DEFAULT 0,
  `photo` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `code` int(11) DEFAULT NULL,
  `physical_address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `userrole` enum('admin','vendor','user') NOT NULL DEFAULT 'user',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title_id` bigint(20) UNSIGNED DEFAULT NULL,
  `gender_id` bigint(20) UNSIGNED DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `nationality` bigint(20) UNSIGNED DEFAULT NULL,
  `county` bigint(20) UNSIGNED DEFAULT NULL,
  `next_of_kin` varchar(255) DEFAULT NULL,
  `next_of_kin_contact` varchar(255) DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT 1,
  `nationalid` varchar(255) DEFAULT NULL,
  `national_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `surname`, `firstname`, `othername`, `username`, `email`, `email_verified_at`, `password`, `must_change_password`, `photo`, `phone`, `address`, `code`, `physical_address`, `city`, `userrole`, `status`, `remember_token`, `created_at`, `updated_at`, `title_id`, `gender_id`, `country_id`, `dob`, `nationality`, `county`, `next_of_kin`, `next_of_kin_contact`, `level`, `nationalid`, `national_id`) VALUES
(7, 'Admin', '', '', 'Admin', 'admin@gmail.com', NULL, '$2y$12$ckn/ail8MvDFd11EbebbJuV.2aUxNpd52BbBp89VUvQ8EA1BMyPrm', 0, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', 'active', NULL, NULL, NULL, 1, 1, 1, NULL, 1, 1, NULL, NULL, 1, '', ''),
(8, 'Vendor', '', '', 'Vendor', 'vendor@gmail.com', NULL, '$2y$12$lmnJ3WJ5V.swlZ3iRiuvg.Zhsx0/q0IX/mVFqfQcYA2eFQCBDMsOO', 0, NULL, NULL, NULL, NULL, NULL, NULL, 'vendor', 'active', NULL, NULL, NULL, 1, 1, 1, NULL, 1, 1, NULL, NULL, 1, '', ''),
(9, 'User', '', '', 'User', 'user@gmail.com', NULL, '$2y$12$tp0TfAbttcyDDJKUrzpTduxKYrbWIkjwjjLyv/sYq.5rfy6fCwrBy', 0, NULL, NULL, NULL, NULL, NULL, NULL, 'user', 'active', NULL, NULL, NULL, 1, 1, 1, NULL, 1, 1, NULL, NULL, 1, '', ''),
(10, 'Wangui', 'canjetan', 'Ngahu', NULL, 'cwamguingahu@gmail.com', NULL, '$2y$12$Mg9sJcEfGE51vjDdz.zVwulMYzUo9mU4/8WjGM/jZZlW5nJnjHgLe', 0, NULL, NULL, NULL, NULL, NULL, NULL, 'user', 'active', NULL, '2024-01-24 11:55:50', '2024-01-24 11:55:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '', ''),
(11, 'Elmo', 'Kato', 'Kareem', NULL, 'dezuliz@mailinator.com', NULL, '$2y$12$ETe8e4PlgTw3RY4bu3dVJuF7QzfJgDOsuZkNx0gpte47.tZJKy1TO', 0, NULL, NULL, NULL, NULL, NULL, NULL, 'user', 'active', NULL, '2024-01-24 12:08:39', '2024-01-24 12:08:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '', ''),
(12, 'wa', 'canjetan', 'Ngahu', NULL, 'cwanguingahu@gmail.com', NULL, '$2y$12$Ae.XspD3RwRHt.PDU9gp2.YQwdge3JfAj0vH4e3pHByQLXdxjmSuq', 0, NULL, NULL, NULL, NULL, NULL, NULL, 'user', 'active', NULL, '2024-01-24 12:26:00', '2024-01-24 12:26:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '', ''),
(13, 'Byron', 'Chase', 'Dora', NULL, 'zeri@mailinator.com', NULL, '$2y$12$fhns30w4J4.0VMnuJE5LvuL6K.2toWbgHd3fgWAT3hp5iW7NWvjUm', 0, NULL, NULL, NULL, NULL, NULL, NULL, 'user', 'active', NULL, '2024-01-24 12:34:20', '2024-01-24 12:34:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '', ''),
(14, 'Janice', '', NULL, NULL, 'canji@pck.go.ke', '2024-03-02 12:27:02', '$2y$12$ckn/ail8MvDFd11EbebbJuV.2aUxNpd52BbBp89VUvQ8EA1BMyPrm', 1, NULL, '00', NULL, NULL, NULL, NULL, 'user', 'active', NULL, '2024-01-24 12:47:46', '2024-01-24 12:47:46', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '', ''),
(15, 'Hayden', 'Samantha', 'Evangeline', NULL, 'papacosi@gmail.com', NULL, '$2y$12$06cZVRw8o41Y5HLQIIOTpupiEIxu7nvXlLYGAFPb8doZ55fo3TkJG', 0, NULL, NULL, NULL, NULL, NULL, NULL, 'user', 'active', NULL, '2024-01-24 13:10:12', '2024-01-24 13:10:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '', ''),
(16, 'Daugherty', 'Felix', 'Yardley Todd', NULL, 'canjetanngahu@gmail.com', NULL, '$2y$12$WwDTK2n.lYTcK34HxWDt6.FvK9JgPV9MhEU6kWJnH2Xrug5B6oV5a', 0, '16202401250555user-8.jpg', '+1 (757) 346-1192', 'Voluptas dolore poss', NULL, 'Culpa asperiores rat', 'Necessitatibus vel c', 'user', 'active', NULL, '2024-01-24 13:19:40', '2024-01-25 06:53:52', 1, 2, 154, '2013-12-30', 64, 39, NULL, NULL, 5, '923', 'upload/national_id/161706151306.pdf'),
(17, 'Marcia', 'Giselle', 'Rowan', NULL, 'roru@mailinator.com', NULL, '$2y$12$hRvIQtbseyRJhvnfR4iTQukccxKFLOogMtPe0aMLSsMMJnHYN89s6', 0, NULL, NULL, NULL, NULL, NULL, NULL, 'user', 'active', NULL, '2024-01-24 13:50:05', '2024-01-24 13:50:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '', ''),
(18, 'Mwayra', 'steve', 'bvhhbv', NULL, 'steve@icta.go.ke', NULL, '$2y$12$NOuhBPIh8M3xgo1VdHz.3uZQn8xC9WCIQeXnqDp9jMz9v6WqXu1ou', 0, '18202401251034user-4.jpg', '0789898987', '9899-000900', NULL, 'kiambu', '00100', 'user', 'active', NULL, '2024-01-25 07:33:15', '2024-01-25 07:36:04', 1, 1, 1, '2024-01-09', 1, 14, 'tttrtr', '888888', 5, '90909090', 'upload/national_id/181706168091.pdf'),
(19, 'Wanjiku', 'Isaac', 'Dwight', NULL, 'dwight@gmail.com', NULL, '$2y$12$4dktVM0pG9qj8VX8kRdhBeDBUtyimRhY95IyhruddNCRZ5Pgf8E8O', 0, '19202401251137user-8.jpg', '0700909090', '1111-00100', NULL, 'Nairobi', 'Nairobi', 'user', 'active', NULL, '2024-01-25 08:32:51', '2024-01-25 08:41:36', 1, 1, 1, '2000-02-01', 1, 9, 'Georgia Travis', '0789876654', 5, '90909090', 'upload/national_id/191706171875.pdf'),
(20, 'wangui', 'symo', 'njagi', NULL, 'kamwanakapapa@gmail.com', NULL, '$2y$12$z4hLVsfg.5Pfn4HcNW.NZef5VylMwanQ8n0z2kHaf/kNq.C2/Mnvm', 0, '20202402291757user-8.jpg', '0700123456', 'P.O Box 9659-00300', NULL, 'NAIROBI', 'Nairobi', 'user', 'active', NULL, '2024-02-29 13:28:02', '2024-02-29 15:22:04', 2, 1, 115, '1997-12-31', 1, 47, 'Moses Bridges', '0700123456', 5, '11223344', 'upload/national_id/201709218674.pdf'),
(21, 'Ngahu', 'Carlos', 'Thuku', NULL, 'sales@losvinca.com', '2024-03-22 09:19:55', '$2y$12$AN8EFssCqdfFWQqzLF4PAecJZ7GOLP/jUk0srBKNt0m0X6BnhSzw.', 0, '212024030213142024-02-29 15_25_12-KNCHR Recruitment System.png', '+1 (946) 744-5172', 'Culpa qui ducimus a', NULL, 'Quas sit quae duis c', 'Accusamus laborum au', 'user', 'active', NULL, '2024-03-02 08:15:31', '2024-03-02 10:14:22', 3, 1, 140, '1988-06-02', 14, 13, 'Naida Walsh', 'Dolorum veritatis lo', 2, '368', 'upload/national_id/211709374462.pdf'),
(22, 'Perry', 'Avram', 'Ila', NULL, 'qyjypot@mailinator.com', NULL, '$2y$12$Pt2KyI3eIz/VxxWcOpw2GOs/gwa0xFVEqUGUZWBN.9T6mkLHeNBQe', 0, NULL, NULL, NULL, NULL, NULL, NULL, 'user', 'active', NULL, '2024-03-02 08:48:31', '2024-03-02 08:48:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL),
(23, 'Martena', 'Elmo', 'Scarlet', NULL, 'nezexicibu@mailinator.com', NULL, '$2y$12$FaeqHrQJv/eVxN97qX7yeOwYv1j4jx/pUa9haoGS6Fxg7XGlmihY2', 0, NULL, NULL, NULL, NULL, NULL, NULL, 'user', 'active', NULL, '2024-03-02 09:02:11', '2024-03-02 09:02:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL),
(24, 'CARLA', 'DEREK', 'SOPHIA', NULL, 'zodydyzyni@mailinator.com', '2024-03-13 11:40:05', '$2y$12$AN8EFssCqdfFWQqzLF4PAecJZ7GOLP/jUk0srBKNt0m0X6BnhSzw.', 0, '24202403021454user-10.jpg', '0790876654', '6500-00900', NULL, 'KIAMBU', 'Kiambu', 'user', 'active', NULL, '2024-03-02 09:08:19', '2024-03-02 11:54:13', 2, 1, 115, '2000-01-02', 1, 22, 'MOSES BRIDGES', '0765654543', 2, '20908765', 'upload/national_id/241709380453.pdf'),
(25, 'MIA', 'PASCALE', 'CHRISTEN', NULL, 'sabijefan@mailinator.com', '2024-03-02 12:20:15', '$2y$12$PWvqEO2/WfYdH.ILRzuR3uMTA1yCr9ru0rE8jtAhx427ZT/3wpv8i', 0, '25202403021523user-1.jpg', '+1 (515) 218-3138', 'SED VELIT VOLUPTATEM', NULL, 'LAUDANTIUM QUIS AUT', 'Numquam et eos temp', 'user', 'active', NULL, '2024-03-02 12:20:00', '2024-03-02 12:23:27', 4, 1, 211, '1993-10-18', 245, 22, 'NEHRU PRESTON', 'Cillum fugiat asper', 2, '321', 'upload/national_id/251709382207.pdf');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `counties`
--
ALTER TABLE `counties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `educationqualifications`
--
ALTER TABLE `educationqualifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `educationqualifications_country_foreign` (`country`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `genders`
--
ALTER TABLE `genders`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

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
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

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
-- Indexes for table `titles`
--
ALTER TABLE `titles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_title_id_foreign` (`title_id`),
  ADD KEY `users_gender_id_foreign` (`gender_id`),
  ADD KEY `users_country_id_foreign` (`country_id`),
  ADD KEY `users_nationality_foreign` (`nationality`),
  ADD KEY `users_county_foreign` (`county`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `counties`
--
ALTER TABLE `counties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=250;

--
-- AUTO_INCREMENT for table `educationqualifications`
--
ALTER TABLE `educationqualifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `genders`
--
ALTER TABLE `genders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `titles`
--
ALTER TABLE `titles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `educationqualifications`
--
ALTER TABLE `educationqualifications`
  ADD CONSTRAINT `educationqualifications_country_foreign` FOREIGN KEY (`country`) REFERENCES `countries` (`id`);

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
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `users_county_foreign` FOREIGN KEY (`county`) REFERENCES `counties` (`id`),
  ADD CONSTRAINT `users_gender_id_foreign` FOREIGN KEY (`gender_id`) REFERENCES `genders` (`id`),
  ADD CONSTRAINT `users_nationality_foreign` FOREIGN KEY (`nationality`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `users_title_id_foreign` FOREIGN KEY (`title_id`) REFERENCES `titles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

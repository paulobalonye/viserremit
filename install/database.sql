-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 10, 2024 at 08:55 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `83_viserremit_buyer`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `username`, `email_verified_at`, `image`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@site.com', 'admin', NULL, '665c024088a791717305920.png', '$2y$12$taDeLQa8NKvJHxoQCtH09.19g3iORpAQrLjmxOcOBVp5m7Cny9M3y', '5H4KozAJ80OW2R1yxdFYnfoEsxhNBBdhKGA2S5rN5o5twhz8OMf991zpV5Dq', NULL, '2024-07-09 01:28:09');

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `agent_id` int UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `click_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_password_resets`
--

CREATE TABLE `admin_password_resets` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `id` bigint UNSIGNED NOT NULL,
  `country_id` int UNSIGNED NOT NULL DEFAULT '0',
  `firstname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dial_code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_by` int UNSIGNED NOT NULL DEFAULT '0',
  `balance` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'contains full address',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0: banned, 1: active',
  `kyc_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kyc_rejection_reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kv` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: KYC Unverified, 2: KYC pending, 1: KYC verified',
  `ts` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: 2fa off, 1: 2fa on',
  `tv` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0: 2fa unverified, 1: 2fa verified',
  `tsc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ban_reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `agent_password_resets`
--

CREATE TABLE `agent_password_resets` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dial_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_sending` tinyint(1) NOT NULL DEFAULT '1',
  `is_receiving` tinyint(1) NOT NULL DEFAULT '1',
  `has_agent` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `country_delivery_method`
--

CREATE TABLE `country_delivery_method` (
  `id` bigint UNSIGNED NOT NULL,
  `country_id` int UNSIGNED NOT NULL DEFAULT '0',
  `delivery_method_id` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cron_jobs`
--

CREATE TABLE `cron_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cron_schedule_id` int NOT NULL DEFAULT '0',
  `next_run` datetime DEFAULT NULL,
  `last_run` datetime DEFAULT NULL,
  `is_running` tinyint(1) NOT NULL DEFAULT '1',
  `is_default` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cron_jobs`
--

INSERT INTO `cron_jobs` (`id`, `name`, `alias`, `action`, `url`, `cron_schedule_id`, `next_run`, `last_run`, `is_running`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'Conversion Rate', 'conversion_ratre', '[\"App\\\\Http\\\\Controllers\\\\CronController\", \"currencyConversionRate\"]', NULL, 1, '2024-06-11 07:41:26', '2024-06-11 07:41:25', 1, 1, '2023-10-03 05:34:20', '2024-06-11 01:41:25');

-- --------------------------------------------------------

--
-- Table structure for table `cron_job_logs`
--

CREATE TABLE `cron_job_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `cron_job_id` int UNSIGNED NOT NULL DEFAULT '0',
  `start_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `duration` int NOT NULL DEFAULT '0',
  `error` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cron_schedules`
--

CREATE TABLE `cron_schedules` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `interval` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cron_schedules`
--

INSERT INTO `cron_schedules` (`id`, `name`, `interval`, `status`, `created_at`, `updated_at`) VALUES
(1, '1 Seconds', 1, 1, '2023-10-03 05:33:13', '2023-10-05 07:36:54');

-- --------------------------------------------------------

--
-- Table structure for table `currency_conversion_rates`
--

CREATE TABLE `currency_conversion_rates` (
  `id` int NOT NULL,
  `from_country` int UNSIGNED NOT NULL DEFAULT '0',
  `to_country` int UNSIGNED NOT NULL DEFAULT '0',
  `rate` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_charges`
--

CREATE TABLE `delivery_charges` (
  `id` bigint NOT NULL,
  `country_delivery_method_id` int UNSIGNED NOT NULL DEFAULT '0',
  `fixed_charge` decimal(28,8) UNSIGNED NOT NULL DEFAULT '0.00000000',
  `percent_charge` decimal(5,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_methods`
--

CREATE TABLE `delivery_methods` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `agent_id` int UNSIGNED NOT NULL DEFAULT '0',
  `send_money_id` int NOT NULL DEFAULT '0',
  `method_code` int UNSIGNED NOT NULL DEFAULT '0',
  `amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `method_currency` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `charge` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `rate` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `final_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `btc_amount` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btc_wallet` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_try` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=>success, 2=>pending, 3=>cancel',
  `from_api` tinyint(1) NOT NULL DEFAULT '0',
  `admin_feedback` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `success_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `failed_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_cron` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `device_tokens`
--

CREATE TABLE `device_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `agent_id` int UNSIGNED NOT NULL DEFAULT '0',
  `is_app` tinyint(1) NOT NULL DEFAULT '0',
  `token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `extensions`
--

CREATE TABLE `extensions` (
  `id` bigint UNSIGNED NOT NULL,
  `act` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `script` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `shortcode` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'object',
  `support` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'help section',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>enable, 2=>disable',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `extensions`
--

INSERT INTO `extensions` (`id`, `act`, `name`, `description`, `image`, `script`, `shortcode`, `support`, `status`, `created_at`, `updated_at`) VALUES
(1, 'tawk-chat', 'Tawk.to', 'Key location is shown bellow', 'tawky_big.png', '<script>\r\n                        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();\r\n                        (function(){\r\n                        var s1=document.createElement(\"script\"),s0=document.getElementsByTagName(\"script\")[0];\r\n                        s1.async=true;\r\n                        s1.src=\"https://embed.tawk.to/{{app_key}}\";\r\n                        s1.charset=\"UTF-8\";\r\n                        s1.setAttribute(\"crossorigin\",\"*\");\r\n                        s0.parentNode.insertBefore(s1,s0);\r\n                        })();\r\n                    </script>', '{\"app_key\":{\"title\":\"App Key\",\"value\":\"--------------------------\"}}', 'twak.png', 0, '2019-10-18 23:16:05', '2023-10-19 06:39:11'),
(2, 'google-recaptcha2', 'Google Recaptcha 2', 'Key location is shown bellow', 'recaptcha3.png', '\n<script src=\"https://www.google.com/recaptcha/api.js\"></script>\n<div class=\"g-recaptcha\" data-sitekey=\"{{site_key}}\" data-callback=\"verifyCaptcha\"></div>\n<div id=\"g-recaptcha-error\"></div>', '{\"site_key\":{\"title\":\"Site Key\",\"value\":\"6LdPC88fAAAAADQlUf_DV6Hrvgm-pZuLJFSLDOWV\"},\"secret_key\":{\"title\":\"Secret Key\",\"value\":\"6LdPC88fAAAAAG5SVaRYDnV2NpCrptLg2XLYKRKB\"}}', 'recaptcha.png', 0, '2019-10-18 23:16:05', '2024-07-08 08:27:52'),
(3, 'custom-captcha', 'Custom Captcha', 'Just put any random string', 'customcaptcha.png', NULL, '{\"random_key\":{\"title\":\"Random String\",\"value\":\"SecureString\"}}', 'na', 0, '2019-10-18 23:16:05', '2024-06-27 00:16:01'),
(4, 'google-analytics', 'Google Analytics', 'Key location is shown bellow', 'google_analytics.png', '<script async src=\"https://www.googletagmanager.com/gtag/js?id={{measurement_id}}\"></script>\n                <script>\n                  window.dataLayer = window.dataLayer || [];\n                  function gtag(){dataLayer.push(arguments);}\n                  gtag(\"js\", new Date());\n                \n                  gtag(\"config\", \"{{measurement_id}}\");\n                </script>', '{\"measurement_id\":{\"title\":\"Measurement ID\",\"value\":\"------\"}}', 'ganalytics.png', 0, NULL, '2021-05-04 10:19:12'),
(5, 'fb-comment', 'Facebook Comment ', 'Key location is shown bellow', 'Facebook.png', '<div id=\"fb-root\"></div><script async defer crossorigin=\"anonymous\" src=\"https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v4.0&appId={{app_key}}&autoLogAppEvents=1\"></script>', '{\"app_key\":{\"title\":\"App Key\",\"value\":\"----\"}}', 'fb_com.png', 0, NULL, '2022-06-15 01:25:38');

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` bigint UNSIGNED NOT NULL,
  `act` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frontends`
--

CREATE TABLE `frontends` (
  `id` bigint UNSIGNED NOT NULL,
  `data_keys` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `seo_content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tempname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `frontends`
--

INSERT INTO `frontends` (`id`, `data_keys`, `data_values`, `seo_content`, `tempname`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'seo.data', '{\"seo_image\":\"1\",\"keywords\":[\"remittance\",\"remit\",\"remitto\",\"remesa\",\"money transfer\",\"transfer money\",\"send money\",\"payout money\",\"cash pickup\"],\"description\":\"ViserRemit is a remittance transfer system to transfer money abroad.\",\"social_title\":\"ViserRemit - Ultimiate Remittance Solution\",\"social_description\":\"ViserRemit is a remittance transfer system to transfer money abroad.\",\"image\":\"668bf72deb05b1720448813.png\"}', NULL, NULL, NULL, '2020-07-04 23:42:52', '2024-07-08 14:26:54'),
(2, 'cookie.data', '{\"short_desc\":\"We may use cookies or any other tracking technologies when you visit our website, including any other media form, mobile website, or mobile application related or connected to help customize the Site and improve your experience.\",\"description\":\"<div class=\\\"mb-5\\\" style=\\\"color: rgb(111, 111, 111); font-family: Nunito, sans-serif; margin-bottom: 3rem !important;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight: 600; line-height: 1.3; font-size: 24px; font-family: Exo, sans-serif; color: rgb(54, 54, 54);\\\">What information do we collect?<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right: 0px; margin-left: 0px; font-size: 18px !important;\\\">We gather data from you when you register on our site, submit a request, buy any services, react to an overview, or round out a structure. At the point when requesting any assistance or enrolling on our site, as suitable, you might be approached to enter your: name, email address, or telephone number. You may, nonetheless, visit our site anonymously.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color: rgb(111, 111, 111); font-family: Nunito, sans-serif; margin-bottom: 3rem !important;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight: 600; line-height: 1.3; font-size: 24px; font-family: Exo, sans-serif; color: rgb(54, 54, 54);\\\">How do we protect your information?<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right: 0px; margin-left: 0px; font-size: 18px !important;\\\">All provided delicate\\/credit data is sent through Stripe.<br>After an exchange, your private data (credit cards, social security numbers, financials, and so on) won\'t be put away on our workers.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color: rgb(111, 111, 111); font-family: Nunito, sans-serif; margin-bottom: 3rem !important;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight: 600; line-height: 1.3; font-size: 24px; font-family: Exo, sans-serif; color: rgb(54, 54, 54);\\\">Do we disclose any information to outside parties?<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right: 0px; margin-left: 0px; font-size: 18px !important;\\\">We don\'t sell, exchange, or in any case move to outside gatherings by and by recognizable data. This does exclude confided in outsiders who help us in working our site, leading our business, or adjusting you, since those gatherings consent to keep this data private. We may likewise deliver your data when we accept discharge is suitable to follow the law, implement our site strategies, or ensure our own or others\' rights, property, or wellbeing.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color: rgb(111, 111, 111); font-family: Nunito, sans-serif; margin-bottom: 3rem !important;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight: 600; line-height: 1.3; font-size: 24px; font-family: Exo, sans-serif; color: rgb(54, 54, 54);\\\">Children\'s Online Privacy Protection Act Compliance<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right: 0px; margin-left: 0px; font-size: 18px !important;\\\">We are consistent with the prerequisites of COPPA (Children\'s Online Privacy Protection Act), we don\'t gather any data from anybody under 13 years old. Our site, items, and administrations are completely coordinated to individuals who are in any event 13 years of age or more established.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color: rgb(111, 111, 111); font-family: Nunito, sans-serif; margin-bottom: 3rem !important;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight: 600; line-height: 1.3; font-size: 24px; font-family: Exo, sans-serif; color: rgb(54, 54, 54);\\\">Changes to our Privacy Policy<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right: 0px; margin-left: 0px; font-size: 18px !important;\\\">If we decide to change our privacy policy, we will post those changes on this page.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color: rgb(111, 111, 111); font-family: Nunito, sans-serif; margin-bottom: 3rem !important;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight: 600; line-height: 1.3; font-size: 24px; font-family: Exo, sans-serif; color: rgb(54, 54, 54);\\\">How long we retain your information?<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right: 0px; margin-left: 0px; font-size: 18px !important;\\\">At the point when you register for our site, we cycle and keep your information we have about you however long you don\'t erase the record or withdraw yourself (subject to laws and guidelines).<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color: rgb(111, 111, 111); font-family: Nunito, sans-serif; margin-bottom: 3rem !important;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight: 600; line-height: 1.3; font-size: 24px; font-family: Exo, sans-serif; color: rgb(54, 54, 54);\\\">What we don\\u2019t do with your data<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right: 0px; margin-left: 0px; font-size: 18px !important;\\\">We don\'t and will never share, unveil, sell, or in any case give your information to different organizations for the promoting of their items or administrations.<\\/p><\\/div>\",\"status\":1}', NULL, NULL, NULL, '2020-07-04 23:42:52', '2022-03-30 11:23:12'),
(3, 'maintenance.data', '{\"description\":\"<div class=\\\"\\\\\\\" mb-5\\\\\\\"\\\"=\\\"\\\" style=\\\"\\\\\\\" font-family:\\\"=\\\"\\\" nunito,=\\\"\\\" sans-serif;=\\\"\\\" margin-bottom:=\\\"\\\" 3rem=\\\"\\\" !important;\\\\\\\"=\\\"\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight: 600; line-height: 1.3; font-size: 24px; text-align: center; font-family: Exo, sans-serif;\\\"><font color=\\\"#ff0000\\\">THE SITE IS UNDER MAINTENANCE<\\/font><\\/h3><h3 class=\\\"mb-3\\\" style=\\\"text-align: center; font-weight: 600; line-height: 1.3; font-size: 24px; font-family: Exo, sans-serif; color: rgb(54, 54, 54);\\\"><p class=\\\"font-18\\\" style=\\\"margin-right: 0px; margin-left: 0px; color: rgb(111, 111, 111); font-family: Nunito, sans-serif; font-size: 18px !important;\\\">Our site is undergoing maintenance to provide you with an enhanced experience. We apologize for any inconvenience caused during this period. Rest assured, our team is working diligently to bring you a better platform. Thank you for your patience and understanding. We look forward to serving you better soon.<\\/p><\\/h3><\\/div>\",\"image\":\"666541b812e321717911992.png\"}', NULL, NULL, NULL, '2020-07-04 23:42:52', '2024-06-08 23:46:33'),
(4, 'seo.data', '{\"seo_image\":\"1\",\"keywords\":[\"admin\",\"blog\",\"aaaa\",\"ddd\",\"aaa\"],\"description\":\"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit\",\"social_title\":\"Viserlab Limited\",\"social_description\":\"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit ff\",\"image\":\"5fa397a629bee1604556710.jpg\"}', NULL, 'basic', NULL, '2020-07-04 17:42:52', '2021-01-03 01:43:02'),
(5, 'app.content', '{\"has_image\":\"1\",\"heading\":\"Use Apps on Mobile\",\"short_description\":\"Download our app for free to send money online in minutes to over 130 other countries. Track your payments and view your transfer history from anywhere.\",\"play_store_url\":\"https:\\/\\/play.google.com\\/store\\/apps\",\"app_store_url\":\"https:\\/\\/www.apple.com\\/app-store\\/\",\"image\":\"666542824926f1717912194.png\",\"play_store_icon\":\"666542826233d1717912194.png\",\"app_store_icon\":\"6665428262fa91717912194.png\"}', NULL, 'basic', NULL, '2020-10-27 18:51:20', '2024-06-08 23:49:54'),
(6, 'blog.content', '{\"heading\":\"Latest Blog Post\",\"description\":\"Donec sodales sagittis magna. Sed consequat leo eget bibendum sodales augue velit cursus nunc\"}', NULL, 'basic', NULL, '2020-10-27 18:51:34', '2022-06-07 10:49:55'),
(7, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Building Trust in Remittance: Strategies for Ensuring Security, Reliability, and Customer Satisfaction\",\"description\":\"<p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">To establish trust in remittance services, ensuring security, reliability, and customer satisfaction is paramount. One key strategy is implementing robust security measures, such as encryption protocols and multi-factor authentication, to safeguard sensitive financial information and transactions. Additionally, employing cutting-edge fraud detection technologies can help mitigate risks and instill confidence in customers.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Reliability is another crucial factor in building trust. This involves ensuring timely and accurate transfer of funds, minimizing downtime, and providing transparent communication regarding transaction status. Utilizing advanced tracking systems and real-time updates can enhance transparency and reliability, fostering trust between the remittance provider and its customers.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Moreover, prioritizing customer satisfaction is essential. This entails offering responsive customer support channels, such as live chat, email, and phone support, to address inquiries and resolve issues promptly. Implementing user-friendly interfaces and intuitive platforms can also enhance the overall customer experience, making the remittance process seamless and convenient.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Furthermore, establishing partnerships with reputable financial institutions and compliance with regulatory standards can further bolster trust in remittance services. By adhering to industry regulations and compliance requirements, remittance providers demonstrate their commitment to integrity and accountability, thereby enhancing trust among customers and stakeholders.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">In summary, building trust in remittance services requires a multifaceted approach that encompasses security, reliability, and customer satisfaction. By implementing robust security measures, ensuring reliability in fund transfers, prioritizing customer satisfaction, and complying with regulatory standards, remittance providers can establish trust and credibility in the eyes of their customers.<\\/span><\\/font><\\/p>\",\"image\":\"668cf8e4ecdaf1720514788.jpg\"}', NULL, 'basic', 'building-trust-in-remittance-strategies-for-ensuring-security-reliability-and-customer-satisfaction', '2020-10-27 18:57:19', '2024-07-09 02:46:29'),
(9, 'contact.content', '{\"has_image\":\"1\",\"title\":\"Leave a Message\",\"description\":\"If you have any queries about sending money or currency rates feel free to ask us.\",\"email\":\"support@mail.com\",\"address\":\"15205 North Kierland Blvd.100 Old City\",\"mobile\":\"0123 - 4567 -890\",\"latitude\":\"40.6708314\",\"longitude\":\"-73.9529734\",\"image\":\"668cf9e69389e1720515046.png\"}', NULL, 'basic', NULL, '2020-10-27 18:59:19', '2024-07-09 02:50:46'),
(10, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Future Trends in Remittances: What to Expect in the Next Decade\",\"description\":\"<p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><span style=\\\"font-size:18px;\\\">In the next decade, the landscape of remittances is expected to undergo significant transformations driven by technological advancements, regulatory changes, and evolving global economic conditions. One of the foremost trends will be the increasing adoption of digital and mobile payment platforms. As more people gain access to smartphones and internet connectivity, especially in developing countries, the use of mobile money services and digital wallets for sending and receiving remittances will become more prevalent. This shift will enhance convenience, reduce transaction costs, and improve the speed of remittance transfers.<\\/span><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><span style=\\\"font-size:18px;\\\">Blockchain technology and cryptocurrencies are also poised to play a crucial role in the future of remittances. These technologies can provide secure, transparent, and cost-effective alternatives to traditional remittance channels, potentially bypassing conventional banking systems and reducing the reliance on intermediaries. As regulatory frameworks around cryptocurrencies continue to evolve and mature, their integration into the remittance ecosystem is likely to expand.<\\/span><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><span style=\\\"font-size:18px;\\\">Artificial intelligence (AI) and big data analytics will further revolutionize the remittance industry. These technologies can optimize transaction processes, enhance security through fraud detection, and personalize customer experiences by predicting user behavior and preferences. The implementation of AI-driven chatbots and virtual assistants will also improve customer service by providing instant support and assistance to users.<\\/span><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><span style=\\\"font-size:18px;\\\">Another significant trend will be the growing involvement of fintech companies in the remittance market. These companies are often more agile and innovative than traditional financial institutions, offering competitive services that cater to the needs of migrant workers and their families. Partnerships between fintech firms and traditional banks or telecom companies will likely increase, creating hybrid models that leverage the strengths of each sector.<\\/span><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><span style=\\\"font-size:18px;\\\">On the regulatory front, governments and international organizations will continue to work towards harmonizing remittance regulations to foster greater transparency, security, and efficiency. Efforts to reduce the cost of remittances, in line with the United Nations\' Sustainable Development Goals, will also persist. This includes measures to eliminate hidden fees, improve exchange rate transparency, and enhance consumer protection.<\\/span><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><span style=\\\"font-size:18px;\\\">Economic factors such as migration patterns, employment trends, and geopolitical developments will also influence remittance flows. As migration continues to evolve, remittance corridors may shift, reflecting new patterns of labor movement and economic opportunities. Additionally, the economic stability of both sending and receiving countries will impact the volume and frequency of remittances.<\\/span><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><span style=\\\"font-size:18px;\\\">In conclusion, the next decade will see remittances becoming increasingly digital and decentralized, driven by technological innovations and regulatory advancements. The integration of AI, blockchain, and mobile technologies will streamline processes, reduce costs, and enhance user experiences. As fintech companies continue to disrupt the market, partnerships and collaborations will become more common, further transforming the remittance landscape. Amid these changes, ongoing efforts to improve regulatory frameworks and address economic challenges will shape the future of remittances, ensuring they remain a vital source of support for millions of families worldwide.<\\/span><\\/p>\",\"image\":\"668cf8d5162591720514773.jpg\"}', NULL, 'basic', 'future-trends-in-remittances-what-to-expect-in-the-next-decade', '2020-10-30 18:39:05', '2024-07-09 02:46:13'),
(31, 'social_icon.element', '{\"title\":\"Facebook\",\"icon\":\"<i class=\\\"lab la-facebook-f\\\"><\\/i>\",\"url\":\"https:\\/\\/www.facebook.com\\/\"}', NULL, 'basic', NULL, '2020-11-11 22:07:30', '2022-05-31 04:42:35'),
(36, 'service.content', '{\"has_image\":\"1\",\"heading\":\"We\'ve Our Agents Worldwide.\",\"description_one\":\"Maecenas tempus tellus eget condimentum rhoncus sequam semper libero sit amet adipiscing sem neque. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor econsequat vitae eleifend enim. Aliquam lorem ante dapibus in viverra quifeugiat a telluasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aliquam lorem ante dapibus in viverra quifeugiat a telluasellus viverra nulla ut metus varius laoreet. Quisque rutrum\",\"description_two\":\"Aenean imperdiet.Etiam ultricies nisi vel augue. Maecenas tempus tellus eget condimentum rhoncus sequam semper libero sit amet adipiscing sem neque. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor econsequat vitae eleifend enim. Aliquam lorem ante dapibus in viverra quifeugiat a telluasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet.Etiam ultricies nisi vel augue.\",\"button_link\":\"user\\/register\",\"button_text\":\"HOW TO TRANSFER\",\"image\":\"666547df0aa211717913567.png\"}', NULL, 'basic', NULL, '2021-03-05 19:27:34', '2024-06-09 00:12:47'),
(39, 'banner.content', '{\"has_image\":\"1\",\"heading\":\"Transfer Remittance at Low Cost\",\"description\":\"ViserRemit offers you to send money to your friends and family at a low price and in a simple way.\",\"button_text\":\"Get Registered\",\"button_link\":\"user\\/register\",\"youtube_link\":\"https:\\/\\/www.youtube.com\\/watch?v=WOb4cj7izpE\",\"image\":\"666542e91a8ee1717912297.png\"}', NULL, 'basic', NULL, '2021-05-02 00:09:30', '2024-06-08 23:51:38'),
(41, 'cookie.data', '{\"link\":\"#\",\"description\":\"<font color=\\\"#ffffff\\\" face=\\\"Exo, sans-serif\\\"><span style=\\\"font-size: 18px;\\\">We may use cookies or any other tracking technologies when you visit our website, including any other media form, mobile website, or mobile application related or connected to help customize the Site and improve your experience.<\\/span><\\/font><br>\",\"status\":1}', NULL, 'basic', NULL, '2020-07-04 17:42:52', '2021-06-06 03:43:37'),
(42, 'policy_pages.element', '{\"title\":\"Privacy Policy\",\"details\":\"<div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"margin-top:0px;margin-bottom:1rem;font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);margin-right:0px;margin-left:0px;\\\">What information do we collect?<\\/h3><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\"><\\/h3><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;font-size:16px;font-weight:400;margin-bottom:3rem;\\\"><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We gather data from you when you register on our site, submit a request, buy any services, react to an overview, or round out a structure. At the point when requesting any assistance or enrolling on our site, as suitable, you might be approached to enter your: name, email address, or telephone number. You may, nonetheless, visit our site anonymously.<\\/p><\\/div><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">How do we protect your information?<\\/h3><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\"><\\/h3><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;font-size:16px;font-weight:400;margin-bottom:3rem;\\\"><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">All provided delicate\\/credit data is sent through Stripe.<br \\/>After an exchange, your private data (credit cards, social security numbers, financials, and so on) won\'t be put away on our workers.<\\/p><\\/div><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Do we disclose any information to outside parties?<\\/h3><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\"><\\/h3><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;font-size:16px;font-weight:400;margin-bottom:3rem;\\\"><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We don\'t sell, exchange, or in any case move to outside gatherings by and by recognizable data. This does exclude confided in outsiders who help us in working our site, leading our business, or adjusting you, since those gatherings consent to keep this data private. We may likewise deliver your data when we accept discharge is suitable to follow the law, implement our site strategies, or ensure our own or others\' rights, property, or wellbeing.<\\/p><\\/div><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Children\'s Online Privacy Protection Act Compliance<\\/h3><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\"><\\/h3><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;font-size:16px;font-weight:400;margin-bottom:3rem;\\\"><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We are consistent with the prerequisites of COPPA (Children\'s Online Privacy Protection Act), we don\'t gather any data from anybody under 13 years old. Our site, items, and administrations are completely coordinated to individuals who are in any event 13 years of age or more established.<\\/p><\\/div><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Changes to our Privacy Policy<\\/h3><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\"><\\/h3><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;font-size:16px;font-weight:400;margin-bottom:3rem;\\\"><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">If we decide to change our privacy policy, we will post those changes on this page.<\\/p><\\/div><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">How long we retain your information?<\\/h3><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\"><\\/h3><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;font-size:16px;font-weight:400;margin-bottom:3rem;\\\"><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">At the point when you register for our site, we cycle and keep your information we have about you however long you don\'t erase the record or withdraw yourself (subject to laws and guidelines).<\\/p><\\/div><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">What we don\\u2019t do with your data<\\/h3><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\"><\\/h3><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;font-size:16px;font-weight:400;margin-bottom:3rem;\\\"><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We don\'t and will never share, unveil, sell, or in any case give your information to different organizations for the promoting of their items or administrations.<\\/p><\\/div><\\/div>\"}', NULL, 'basic', 'privacy-policy', '2021-06-09 02:50:42', '2024-06-09 00:22:36'),
(43, 'policy_pages.element', '{\"title\":\"Terms of Service\",\"details\":\"<div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><div class=\\\"mb-5\\\" style=\\\"margin-bottom:3rem;\\\"><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We claim all authority to dismiss, end, or handicap any help with or without cause per administrator discretion. This is a Complete independent facilitating, on the off chance that you misuse our ticket or Livechat or emotionally supportive network by submitting solicitations or protests we will impair your record. The solitary time you should reach us about the seaward facilitating is if there is an issue with the worker. We have not many substance limitations and everything is as per laws and guidelines. Try not to join on the off chance that you intend to do anything contrary to the guidelines, we do check these things and we will know, don\'t burn through our own and your time by joining on the off chance that you figure you will have the option to sneak by us and break the terms.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"margin-bottom:3rem;\\\"><ul class=\\\"font-18\\\" style=\\\"padding-left:15px;list-style-type:disc;font-size:18px;\\\"><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Configuration requests - If you have a fully managed dedicated server with us then we offer custom PHP\\/MySQL configurations, firewalls for dedicated IPs, DNS, and httpd configurations.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Software requests - Cpanel Extension Installation will be granted as long as it does not interfere with the security, stability, and performance of other users on the server.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Emergency Support - We do not provide emergency support \\/ Phone Support \\/ LiveChat Support. Support may take some hours sometimes.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Webmaster help - We do not offer any support for webmaster related issues and difficulty including coding, & installs, Error solving. if there is an issue where a library or configuration of the server then we can help you if it\'s possible from our end.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Backups - We keep backups but we are not responsible for data loss, you are fully responsible for all backups.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">We Don\'t support any child porn or such material.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">No spam-related sites or material, such as email lists, mass mail programs, and scripts, etc.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">No harassing material that may cause people to retaliate against you.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">No phishing pages.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">You may not run any exploitation script from the server. reason can be terminated immediately.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">If Anyone attempting to hack or exploit the server by using your script or hosting, we will terminate your account to keep safe other users.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Malicious Botnets are strictly forbidden.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Spam, mass mailing, or email marketing in any way are strictly forbidden here.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Malicious hacking materials, trojans, viruses, & malicious bots running or for download are forbidden.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Resource and cronjob abuse is forbidden and will result in suspension or termination.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Php\\/CGI proxies are strictly forbidden.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">CGI-IRC is strictly forbidden.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">No fake or disposal mailers, mass mailing, mail bombers, SMS bombers, etc.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">NO CREDIT OR REFUND will be granted for interruptions of service, due to User Agreement violations.<\\/li><\\/ul><\\/div><div class=\\\"mb-5\\\" style=\\\"margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Terms & Conditions for Users<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">Before getting to this site, you are consenting to be limited by these site Terms and Conditions of Use, every single appropriate law, and guidelines, and concur that you are answerable for consistency with any material neighborhood laws. If you disagree with any of these terms, you are restricted from utilizing or getting to this site.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Support<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">Whenever you have downloaded our item, you may get in touch with us for help through email and we will give a valiant effort to determine your issue. We will attempt to answer using the Email for more modest bug fixes, after which we will refresh the center bundle. Content help is offered to confirmed clients by Tickets as it were. Backing demands made by email and Livechat.<\\/p><p class=\\\"my-3 font-18 font-weight-bold\\\" style=\\\"margin-right:0px;margin-left:0px;font-weight:700;font-size:18px;\\\">On the off chance that your help requires extra adjustment of the System, at that point, you have two alternatives:<\\/p><ul class=\\\"font-18\\\" style=\\\"padding-left:15px;list-style-type:disc;font-size:18px;\\\"><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Hang tight for additional update discharge.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Or on the other hand, enlist a specialist (We offer customization for extra charges).<\\/li><\\/ul><\\/div><div class=\\\"mb-5\\\" style=\\\"margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Ownership<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">You may not guarantee scholarly or selective possession of any of our items, altered or unmodified. All items are property, we created them. Our items are given \\\"with no guarantees\\\" without guarantee of any sort, either communicated or suggested. On no occasion will our juridical individual be subject to any harms including, however not restricted to, immediate, roundabout, extraordinary, accidental, or significant harms or different misfortunes emerging out of the utilization of or powerlessness to utilize our items.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Warranty<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We don\'t offer any guarantee or assurance of these Services in any way. When our Services have been modified we can\'t ensure they will work with all outsider plugins, modules, or internet browsers. Program similarity ought to be tried against the show formats on the demo worker. If you don\'t mind guarantee that the programs you use will work with the component, as we can not ensure that our systems will work with all program mixes.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Unauthorized\\/Illegal Usage<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">You may not utilize our things for any illicit or unapproved reason or may you, in the utilization of the stage, disregard any laws in your locale (counting yet not restricted to copyright laws) just as the laws of your nation and International law. Specifically, it is disallowed to utilize the things on our foundation for pages that advance: brutality, illegal intimidation, hard sexual entertainment, bigotry, obscenity content or warez programming joins.<br \\/><br \\/>You can\'t imitate, copy, duplicate, sell, exchange or adventure any of our segment, utilization of the offered on our things, or admittance to the administration without the express composed consent by us or item proprietor.<br \\/><br \\/>Our Members are liable for all substance posted on the discussion and demo and movement that happens under your record.<br \\/><br \\/>We hold the chance of hindering your participation account quickly if we will think about a particularly not allowed conduct.<br \\/><br \\/>If you make a record on our site, you are liable for keeping up the security of your record, and you are completely answerable for all exercises that happen under the record and some other activities taken regarding the record. You should quickly inform us, of any unapproved employments of your record or some other penetrates of security.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Fiverr, Seoclerks Sellers Or Affiliates<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We do NOT ensure full SEO campaign conveyance within 24 hours. We make no assurance for conveyance time by any means. We give our best assessment to orders during the putting in of requests, anyway, these are gauges. We won\'t be considered liable for loss of assets, negative surveys or you being prohibited for late conveyance. If you are selling on a site that requires time touchy outcomes, utilize Our SEO Services at your own risk.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Payment\\/Refund Policy<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">No refund or cash back will be made. After a deposit has been finished, it is extremely unlikely to invert it. You should utilize your equilibrium on requests our administrations, Hosting, SEO campaign. You concur that once you complete a deposit, you won\'t document a debate or a chargeback against us in any way, shape, or form.<br \\/><br \\/>If you document a debate or chargeback against us after a deposit, we claim all authority to end every single future request, prohibit you from our site. False action, for example, utilizing unapproved or taken charge cards will prompt the end of your record. There are no special cases.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Free Balance \\/ Coupon Policy<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We offer numerous approaches to get FREE Balance, Coupons and Deposit offers yet we generally reserve the privilege to audit it and deduct it from your record offset with any explanation we may it is a sort of misuse. If we choose to deduct a few or all of free Balance from your record balance, and your record balance becomes negative, at that point the record will naturally be suspended. If your record is suspended because of a negative Balance you can request to make a custom payment to settle your equilibrium to actuate your record.<\\/p><\\/div><\\/div>\"}', NULL, 'basic', 'terms-of-service', '2021-06-09 02:51:18', '2024-06-09 00:22:25'),
(44, 'feature.element', '{\"title\":\"Cheap Rate\",\"description\":\"We offer you a lower cost to send money outside the country.\",\"icon\":\"<i class=\\\"las la-percent\\\"><\\/i>\"}', NULL, 'basic', NULL, '2022-02-26 03:13:26', '2022-06-11 07:37:58'),
(45, 'feature.element', '{\"title\":\"Safe and Secure\",\"description\":\"Sending remittances is safe and secure as recipients receive money from our agents.\",\"icon\":\"<i class=\\\"las la-shield-alt\\\"><\\/i>\"}', NULL, 'basic', NULL, '2022-02-26 03:13:44', '2022-06-09 10:53:38'),
(46, 'feature.element', '{\"title\":\"Fast Transfer\",\"description\":\"Transferring money through ViserRemit is just a matter of moments.\",\"icon\":\"<i class=\\\"las la-exchange-alt\\\"><\\/i>\"}', NULL, 'basic', NULL, '2022-02-26 03:13:59', '2022-06-11 07:38:09'),
(47, 'app.element', '{\"key_feature_item\":\"The best rates on the market\"}', NULL, 'basic', NULL, '2022-02-26 03:22:29', '2022-02-26 03:22:29'),
(50, 'how_to_receive.content', '{\"heading\":\"How to Receive Money\",\"description\":\"Donec sodales sagittis magna. Sed consequat leo eget bibendum sodales augue velit cursus nunc\"}', NULL, 'basic', NULL, '2022-02-26 03:44:36', '2022-06-11 09:20:38'),
(51, 'how_to_receive.element', '{\"title\":\"Find Agent\",\"description\":\"To receive the sent amount you need to go to our agent\'s location.\",\"icon\":\"<i class=\\\"la la-map-marker-alt\\\"><\\/i>\"}', NULL, 'basic', NULL, '2022-02-26 03:45:36', '2022-06-11 09:32:28'),
(52, 'how_to_receive.element', '{\"title\":\"Give Transaction No.\",\"description\":\"Give the transaction number of send-money to our agent.\",\"icon\":\"<i class=\\\"la la-credit-card\\\"><\\/i>\"}', NULL, 'basic', NULL, '2022-02-26 03:45:51', '2022-06-11 09:33:57'),
(53, 'how_to_receive.element', '{\"title\":\"Verify Yourself\",\"description\":\"To complete the payout you have to be verified via a verification code.\",\"icon\":\"<i class=\\\"la la-mobile-alt\\\"><\\/i>\"}', NULL, 'basic', NULL, '2022-02-26 03:46:14', '2022-06-11 09:35:16'),
(54, 'transfer.content', '{\"has_image\":\"1\",\"heading\":\"Transfer funds across the globe, without extra fees\",\"description\":\"Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor econsequat vitae eleifend enim. Aliquam lorem ante dapibus in viverra quifeugiat a telluasel. world class Money Transfer\",\"button_link\":\"user\\/register\",\"button_text\":\"Get started\",\"image\":\"666549d9e99b71717914073.png\"}', NULL, 'basic', NULL, '2022-02-26 04:15:46', '2024-06-09 00:21:14'),
(55, 'transfer.element', '{\"key_features\":\"100% Trusted\"}', NULL, 'basic', NULL, '2022-02-26 04:16:10', '2022-02-26 04:16:10'),
(56, 'transfer.element', '{\"key_features\":\"Fast and Easy Transfer\"}', NULL, 'basic', NULL, '2022-02-26 04:16:14', '2022-05-21 03:39:01'),
(57, 'transfer.element', '{\"key_features\":\"Life Support\"}', NULL, 'basic', NULL, '2022-02-26 04:16:22', '2022-02-26 04:16:22'),
(58, 'transfer.element', '{\"key_features\":\"Global Coverage\"}', NULL, 'basic', NULL, '2022-02-26 04:16:27', '2022-02-26 04:16:27'),
(59, 'transfer.element', '{\"key_features\":\"On time\"}', NULL, 'basic', NULL, '2022-02-26 04:16:36', '2022-02-26 04:16:36'),
(60, 'transfer.element', '{\"key_features\":\"No Hidden Charge\"}', NULL, 'basic', NULL, '2022-02-26 04:16:43', '2022-02-26 04:16:43'),
(61, 'choose_us.content', '{\"has_image\":\"1\",\"heading\":\"Why People Choose Us for Money Transfer\",\"image\":\"668cf9d6965321720515030.png\"}', NULL, 'basic', NULL, '2022-02-26 04:42:15', '2024-07-09 02:50:30'),
(62, 'choose_us.element', '{\"title\":\"Cheaper Than Your Bank\",\"description\":\"Convert data noise to intelligent insights for competitive differentiation.\",\"icon\":\"<i class=\\\"fas fa-landmark\\\"><\\/i>\"}', NULL, 'basic', NULL, '2022-02-26 04:42:36', '2022-02-26 04:42:36'),
(63, 'choose_us.element', '{\"title\":\"Always Supportive\",\"description\":\"Convert data noise to intelligent insights for competitive differentiation.\",\"icon\":\"<i class=\\\"fas fa-comments\\\"><\\/i>\"}', NULL, 'basic', NULL, '2022-02-26 04:42:58', '2022-02-26 04:43:35'),
(64, 'choose_us.element', '{\"title\":\"Trust is Important\",\"description\":\"Convert data noise to intelligent insights for competitive differentiation.\",\"icon\":\"<i class=\\\"fas fa-shield-alt\\\"><\\/i>\"}', NULL, 'basic', NULL, '2022-02-26 04:43:19', '2022-02-26 04:43:19'),
(65, 'testimonial.content', '{\"heading\":\"What Our Client Says\",\"description\":\"Donec sodales sagittis magna. Sed consequat leo eget bibendum sodales augue velit cursus nunc\"}', NULL, 'basic', NULL, '2022-02-26 04:53:31', '2022-06-11 04:47:29'),
(66, 'testimonial.element', '{\"has_image\":[\"1\"],\"name\":\"Muscan Roshid\",\"designation\":\"Customer, USA\",\"star_count\":\"5\",\"date\":\"25 December 2022 , 08:30 PM\",\"description\":\"I\'ve been using this remittance website to send money to my family back home in Egypt, and I\'ve been consistently impressed with the level of service. The rates are competitive, the transaction process is straightforward, and the funds are delivered securely and on time. As someone who frequently sends remittances, I highly recommend this platform to others in the expat community.\",\"image\":\"668cfa8c654c91720515212.jpg\"}', NULL, 'basic', NULL, '2022-02-26 04:55:45', '2024-07-09 02:53:32'),
(67, 'testimonial.element', '{\"has_image\":[\"1\"],\"name\":\"Emily Chan\",\"designation\":\"Customer, USA\",\"star_count\":\"5\",\"date\":\"25 December 2022 , 08:30 PM\",\"description\":\"I recently switched to this remittance platform after having a frustrating experience with another service, and I\'m so glad I did. The website is intuitive, the fees are transparent, and the transfers are processed promptly. What impressed me the most was the personalized customer support I received when I encountered a minor issue with my transaction. Keep up the great work!\",\"image\":\"668cfa85439391720515205.jpg\"}', NULL, 'basic', NULL, '2022-02-26 04:56:22', '2024-07-09 02:53:25'),
(68, 'testimonial.element', '{\"has_image\":[\"1\"],\"name\":\"Miguel Rodriguez\",\"designation\":\"Customer,  Mexico\",\"star_count\":\"5\",\"date\":\"25 December 2022 , 08:30 PM\",\"description\":\"Excelente servicio de remesas! He estado utilizando este sitio web para enviar dinero a mi familia en M\\u00e9xico, y hasta ahora todo ha sido perfecto. Los tipos de cambio son competitivos, las transferencias son r\\u00e1pidas y seguras, y el proceso es muy sencillo. \\u00a1Gracias por ayudarme a mantener a mi familia conectada!\",\"image\":\"668cfa7ed9e491720515198.jpg\"}', NULL, 'basic', NULL, '2022-02-26 04:57:03', '2024-07-09 02:53:18'),
(69, 'testimonial.element', '{\"has_image\":[\"1\"],\"name\":\"Sarah Johnson\",\"designation\":\"Customer, USA\",\"star_count\":\"5\",\"date\":\"25 December 2022 , 08:30 PM\",\"description\":\"I\'ve been using this remittance service for over a year now, and I couldn\'t be happier with the experience. The website is user-friendly, the fees are reasonable, and the transfer process is quick and reliable. Plus, their customer support team is always available to assist with any inquiries or issues. Highly recommended!\",\"image\":\"668cfa763d4691720515190.jpg\"}', NULL, 'basic', NULL, '2022-02-26 04:57:30', '2024-07-09 02:53:10'),
(70, 'video.content', '{\"has_image\":\"1\",\"heading\":\"Watch Us to Know More\",\"description\":\"Donec sodales sagittis magna. Sed consequat leo eget bibendum sodales augue velit cursus nunc\",\"youtube_link\":\"https:\\/\\/www.youtube.com\\/watch?v=WOb4cj7izpE\",\"image\":\"666549e9a83c71717914089.png\"}', NULL, 'basic', NULL, '2022-02-26 05:12:37', '2024-06-09 00:21:30'),
(71, 'counter.element', '{\"title\":\"Happy Customer\",\"digit\":\"3600\",\"icon\":\"<i class=\\\"fas fa-grin-beam\\\"><\\/i>\"}', NULL, 'basic', NULL, '2022-02-26 05:15:48', '2022-02-26 05:15:48'),
(72, 'counter.element', '{\"title\":\"Transfer Money\",\"digit\":\"4587\",\"icon\":\"<i class=\\\"fas fa-coins\\\"><\\/i>\"}', NULL, 'basic', NULL, '2022-02-26 05:16:06', '2022-02-26 05:16:06'),
(73, 'counter.element', '{\"title\":\"Service Area\",\"digit\":\"2200\",\"icon\":\"<i class=\\\"fas fa-globe\\\"><\\/i>\"}', NULL, 'basic', NULL, '2022-02-26 05:16:20', '2022-02-26 05:16:20'),
(74, 'how_work.content', '{\"heading\":\"How to Send Remittance\",\"description\":\"Donec sodales sagittis magna. Sed consequat leo eget bibendum sodales augue velit cursus nunc\"}', NULL, 'basic', NULL, '2022-02-26 05:22:30', '2022-06-11 09:43:37'),
(75, 'how_work.element', '{\"title\":\"Send Money Request\",\"description\":\"At first you need to submit the required information from send money page to issue a send money request.\",\"icon\":\"<i class=\\\"fas fa-exchange-alt\\\"><\\/i>\"}', NULL, 'basic', NULL, '2022-02-26 05:22:45', '2022-06-11 09:48:06'),
(76, 'how_work.element', '{\"title\":\"Complete Payment\",\"description\":\"After submitting te send money request you have to complete the payment process by a payment method.\",\"icon\":\"<i class=\\\"fas fa-receipt\\\"><\\/i>\"}', NULL, 'basic', NULL, '2022-02-26 05:22:53', '2022-06-11 09:49:45'),
(77, 'how_work.element', '{\"title\":\"Give Transaction No.\",\"description\":\"After completeing the payment process send the transaction number to your recipent.\",\"icon\":\"<i class=\\\"fas fa-wallet\\\"><\\/i>\"}', NULL, 'basic', NULL, '2022-02-26 05:23:01', '2022-06-11 09:52:08'),
(78, 'faq.content', '{\"has_image\":\"1\",\"heading\":\"What do you wish to know?\",\"image\":\"66654704ea9bd1717913348.png\"}', NULL, 'basic', NULL, '2022-02-26 05:27:39', '2024-06-09 00:09:09'),
(79, 'faq.element', '{\"question\":\"What is a multi-currency account and how does it work?\",\"answer\":\"Sed mollis, eros et ultrices tempus, mauris ipsum aliquam libero, non adipiscing dolor urna a orci. Praesent porttitor, nulla vitae posuere iaculis, arcu nisl dignissim dolor, a pretium mi sem ut ipsum. Cras varius. Vivamus in erat ut urna cursus vestibulum. Fusce a quam.\\r\\n\\r\\nPraesent metus tellus, elementum eu, semper a, adipiscing nec, purus. Nunc egestas, augue at pellentesque laoreet, felis eros vehicula leo, at malesuada velit leo quis pede. Phasellus magna. Nunc nec neque. In turpis.\"}', NULL, 'basic', NULL, '2022-02-26 05:28:09', '2022-05-09 05:43:35'),
(80, 'faq.element', '{\"question\":\"How to Set up your first transfer?\",\"answer\":\"Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Aenean viverra rhoncus pede. Proin magna. Nam pretium turpis et arcu. Fusce a quam.\\r\\n\\r\\nVivamus euismod mauris. Pellentesque dapibus hendrerit tortor. Fusce ac felis sit amet ligula pharetra condimentum. Vestibulum suscipit nulla quis orci. Sed fringilla mauris sit amet nibh.\"}', NULL, 'basic', NULL, '2022-02-26 05:28:31', '2022-05-09 05:43:51');
INSERT INTO `frontends` (`id`, `data_keys`, `data_values`, `seo_content`, `tempname`, `slug`, `created_at`, `updated_at`) VALUES
(83, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Exploring the Challenges Faced by the Remittance Industry\",\"description\":\"<p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">The remittance industry, which facilitates the transfer of money by foreign workers to individuals in their home countries, faces numerous challenges. One of the primary issues is the high cost of remittance services. These costs include fees charged by service providers and unfavorable exchange rates, which can significantly reduce the amount of money that reaches recipients. This financial burden is especially acute for migrants who are sending small amounts of money, as fees often constitute a larger percentage of these transfers.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Another significant challenge is regulatory compliance. The remittance industry is heavily regulated to prevent money laundering and financing of terrorism, requiring companies to implement stringent compliance measures. These regulations vary by country, making it difficult for remittance providers to navigate the legal landscape and comply with all relevant laws. This complexity increases operational costs and can delay transactions.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Access to financial services is also a critical issue. Many recipients of remittances live in rural or underserved areas where banking infrastructure is limited. This lack of access can force recipients to rely on informal channels, which are often less secure and more expensive. Additionally, the digital divide exacerbates this problem, as access to and familiarity with digital financial services are unevenly distributed.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Technological barriers present another set of challenges. While advancements in technology have the potential to streamline remittance processes, many companies struggle with the integration of new systems. Legacy systems can be incompatible with modern technologies, making it difficult to adopt innovations such as blockchain or mobile money solutions. This technological lag can hinder the efficiency and security of remittance services.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Market competition is fierce, with numerous players vying for a share of the remittance market. This competitive environment drives companies to constantly innovate and reduce costs, but it also puts pressure on profit margins. Smaller players, in particular, find it challenging to compete with large, established firms that have greater resources and broader networks.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Trust is a crucial factor in the remittance industry. Migrants and their families need assurance that their money will be transferred safely and promptly. Any breaches of security or instances of fraud can severely damage a company\'s reputation and erode customer trust. Ensuring the security of transactions and maintaining transparency is therefore essential but can be costly and complex.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Economic and political instability in sending and receiving countries can also impact the remittance industry. Fluctuating exchange rates, inflation, and political unrest can all affect the flow of remittances and the reliability of transfer services. Providers must be agile and responsive to these external factors to mitigate their impact on operations and customer satisfaction.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">In summary, the remittance industry is confronted with high operational costs, complex regulatory requirements, limited access to financial services, technological challenges, intense competition, the need to maintain trust and security, and external economic and political pressures. Addressing these challenges requires a multifaceted approach that includes innovation, regulatory advocacy, investment in technology, and a commitment to customer service and security.<\\/span><\\/font><\\/p>\",\"image\":\"668cf8c5a8c261720514757.jpeg\"}', NULL, 'basic', 'exploring-the-challenges-faced-by-the-remittance-industry', '2022-02-26 06:21:37', '2024-07-09 02:45:57'),
(84, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"How to Ensure Safe and Secure Remittance Transfers\",\"description\":\"<p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Ensuring safe and secure remittance transfers involves several key practices and considerations. First and foremost, it is essential to choose a reputable remittance service provider. Researching the provider\\u2019s background, checking user reviews, and verifying their registration with relevant financial authorities can help in assessing their reliability. It\'s also important to ensure that the provider follows robust security protocols, such as encryption and secure user authentication, to protect your personal and financial information.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">When setting up an account, use strong, unique passwords and enable two-factor authentication (2FA) for an added layer of security. This helps to protect your account from unauthorized access. Additionally, be vigilant about phishing scams and avoid clicking on suspicious links or providing personal information in response to unsolicited emails or messages.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Understanding the fees and exchange rates associated with remittance transfers is crucial. Transparent providers will clearly outline these costs, allowing you to compare different services and choose the most cost-effective option. Be wary of hidden fees or unfavorable exchange rates that can erode the value of your transfer.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Before initiating a transfer, double-check all recipient details, including their name, account number, and bank information, to avoid sending money to the wrong person. It\'s also wise to inform the recipient about the transfer and provide them with any necessary details to claim the funds.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Monitoring your transfer through the tracking options provided by the remittance service can help you stay updated on the status of your transaction. In case of any issues or delays, promptly contact the provider\\u2019s customer support for assistance.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Keeping records of your transactions, including receipts and confirmation emails, is essential for reference and in case of disputes. These records can also help in tracking your financial activities and ensuring that all transfers are accurately completed.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Lastly, being aware of the legal and regulatory requirements for remittance transfers in both the sending and receiving countries can prevent potential legal issues. This includes understanding any limits on the amount that can be transferred and ensuring compliance with anti-money laundering (AML) and counter-terrorism financing (CTF) regulations.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">By following these practices, you can ensure that your remittance transfers are conducted safely and securely, minimizing the risks associated with transferring money internationally.<\\/span><\\/font><\\/p>\",\"image\":\"668cf8b7e12a61720514743.jpg\"}', NULL, 'basic', 'how-to-ensure-safe-and-secure-remittance-transfers', '2022-02-26 06:21:54', '2024-07-09 02:45:44'),
(85, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"The Evolution of Remittance: From Traditional Methods to Digital Solutions\",\"description\":\"<p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><span style=\\\"font-size:18px;\\\">The evolution of remittance, the transfer of money from one place to another, has undergone a significant transformation from traditional methods to digital solutions. Historically, remittance was primarily conducted through physical channels, such as cash or checks, often involving intermediaries like banks or money transfer operators.<\\/span><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><span style=\\\"font-size:18px;\\\">In the traditional model, individuals would physically visit a bank or a money transfer agent to send money to their loved ones in another location. The process was often time-consuming, costly, and prone to inefficiencies, including long wait times and high transaction fees.<\\/span><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><span style=\\\"font-size:18px;\\\">However, with the advent of digital technology, the landscape of remittance has undergone a remarkable shift. Digital solutions have revolutionized the way money is transferred across borders, offering greater convenience, speed, and cost-effectiveness.<\\/span><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><span style=\\\"font-size:18px;\\\">One of the most significant advancements in remittance has been the rise of digital payment platforms and mobile money services. These platforms allow users to transfer money instantly using their smartphones or computers, eliminating the need for physical visits to banks or money transfer agents.<\\/span><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><span style=\\\"font-size:18px;\\\">Moreover, digital remittance solutions often offer competitive exchange rates and lower transaction fees compared to traditional methods. This has made remittance more affordable for migrants and individuals sending money to their home countries, particularly in developing regions where remittances play a crucial role in supporting families and driving economic growth.<\\/span><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><span style=\\\"font-size:18px;\\\">Furthermore, digital remittance solutions have improved accessibility, allowing individuals in remote or underserved areas to receive funds conveniently. Mobile money services, for example, have expanded financial inclusion by providing people with access to basic banking services through their mobile phones, even in areas with limited banking infrastructure.<\\/span><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><span style=\\\"font-size:18px;\\\">Another key feature of digital remittance is transparency and security. Blockchain technology, for instance, has been increasingly integrated into remittance platforms, providing enhanced security and transparency by recording transactions on a decentralized ledger.<\\/span><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><span style=\\\"font-size:18px;\\\">Overall, the evolution of remittance from traditional methods to digital solutions has brought about significant benefits for both senders and recipients. It has made the process more efficient, affordable, and accessible, facilitating greater financial inclusion and economic development globally.<\\/span><\\/p>\",\"image\":\"668cf8a58da4c1720514725.jpg\"}', NULL, 'basic', 'the-evolution-of-remittance-from-traditional-methods-to-digital-solutions', '2022-02-26 06:22:10', '2024-07-09 02:45:25'),
(86, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"The Social Impact of Remittances: Supporting Families and Communities\",\"description\":\"<p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Remittances, the funds sent by migrants to their home countries, have significant social impacts on both families and communities. They play a crucial role in improving the livelihoods of recipient families, providing financial support for basic needs such as food, housing, healthcare, and education. This financial flow often leads to an enhanced quality of life and reduced poverty levels, enabling families to access better services and opportunities that might otherwise be unattainable.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">On a broader scale, remittances contribute to the economic stability of communities. They can stimulate local economies by increasing consumption and demand for goods and services. This, in turn, can lead to job creation and higher income levels within the community. Additionally, the inflow of remittances can support local businesses and entrepreneurship, as recipients might invest in small enterprises or start new ventures, fostering economic development.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Remittances also have social implications beyond financial aspects. They often help to maintain social structures and cultural practices, as funds sent home can support traditional ceremonies, festivals, and community projects. This financial support can strengthen social ties and ensure the continuation of cultural heritage.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Moreover, remittances can empower individuals, particularly women, who are frequently the primary recipients. This financial independence can lead to increased decision-making power within households and communities, promoting gender equality and women\'s empowerment.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">However, the reliance on remittances can also present challenges. It can create dependency and discourage local economic development initiatives. In some cases, it may lead to social tensions, as those who receive remittances might be perceived differently by those who do not.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Overall, remittances have a profound social impact, fostering economic growth, enhancing quality of life, supporting cultural practices, and promoting social stability. They act as a vital financial lifeline for many families and communities, influencing various aspects of social and economic life in recipient countries.<\\/span><\\/font><\\/p>\",\"image\":\"668cf8989a33e1720514712.jpg\"}', NULL, 'basic', 'the-social-impact-of-remittances-supporting-families-and-communities', '2022-02-26 06:22:49', '2024-07-09 02:45:12'),
(87, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Understanding Remittance Fees: How to Get the Best Rates\",\"description\":\"<p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Remittance fees are charges applied by service providers when money is sent across borders. These fees can vary widely depending on several factors, including the provider, the destination country, the amount being sent, and the method of transfer. To understand how to get the best rates for remittance services, it\\u2019s important to consider a few key aspects.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Firstly, the type of service provider significantly impacts the cost. Banks, traditional money transfer services, online transfer services, and mobile money transfer apps all have different fee structures. Banks often charge higher fees and offer less competitive exchange rates, while online and mobile services usually provide more cost-effective solutions with lower fees and better exchange rates.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Exchange rates are another crucial factor. The rate at which currency is converted can vary greatly between providers. Some providers offer competitive rates with low or no margins added on top of the market rate, while others mark up the exchange rate to increase their profit. It\\u2019s essential to compare the exchange rates offered by different services to ensure you are getting the best deal.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">The method of payment and delivery also affects the cost. For example, funding a transfer with a bank account generally incurs lower fees than using a credit or debit card. Similarly, receiving money directly into a bank account or via a mobile wallet might be cheaper than cash pickups, which often come with higher charges.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Transfer speed is another consideration. Faster transfers, such as those completed within minutes or hours, usually come with higher fees compared to those that take a few days. The urgency of the transfer should be weighed against the cost to determine the best option for your needs.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Some remittance services also offer promotions or loyalty programs that can reduce fees. It\'s beneficial to keep an eye out for such offers, especially if you need to send money frequently. Additionally, some services may waive fees for first-time users or for transfers above a certain amount.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Comparing different providers is crucial to finding the best rates. Websites and apps that aggregate and compare remittance services can be valuable tools in this process. They provide a clear overview of the fees, exchange rates, and transfer times from various providers, helping you make an informed decision.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">In summary, getting the best rates for remittance services involves understanding the fee structures of different providers, comparing exchange rates, considering the payment and delivery methods, and taking advantage of promotions or loyalty programs. By thoroughly researching and comparing options, you can minimize costs and ensure more of your money reaches its intended destination.<\\/span><\\/font><\\/p>\",\"image\":\"668cf88c3a9981720514700.jpg\"}', NULL, 'basic', 'understanding-remittance-fees-how-to-get-the-best-rates', '2022-02-26 06:23:07', '2024-07-09 02:45:00'),
(88, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"How Digital Transformation is Revolutionizing the Remittance Industry\",\"description\":\"<p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Digital transformation is profoundly revolutionizing the remittance industry, fundamentally altering how money is transferred across borders. Traditionally, remittance services relied on physical agents and cash transactions, often resulting in high fees and long processing times. However, the advent of digital technologies has introduced significant changes, enhancing efficiency, accessibility, and transparency.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">One of the most notable impacts of digital transformation is the rise of online and mobile platforms for remittances. These platforms allow users to send money from their smartphones or computers, eliminating the need for physical visits to transfer agents. This shift not only simplifies the process but also dramatically reduces transaction times, often enabling near-instantaneous transfers. Furthermore, digital platforms often offer lower fees compared to traditional methods, making remittances more affordable for users.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Blockchain technology is another groundbreaking innovation in the remittance industry. By leveraging blockchain, companies can facilitate secure, transparent, and tamper-proof transactions. Blockchain-based remittances eliminate intermediaries, further reducing costs and enhancing the speed of transactions. Additionally, the transparency inherent in blockchain technology helps build trust among users, as they can track their transfers in real-time.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Artificial Intelligence (AI) and machine learning are also playing crucial roles in transforming remittances. These technologies enhance fraud detection and prevention, ensuring safer transactions. AI-powered chatbots and customer service platforms provide instant support and assistance to users, improving the overall customer experience.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Digital transformation is also expanding financial inclusion. Mobile money services, particularly in developing regions, are providing access to financial services for unbanked populations. By enabling people to receive and send money via mobile phones, these services are bridging the gap for those without access to traditional banking infrastructure. This inclusion fosters economic growth and empowers individuals by providing them with more financial autonomy.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Regulatory advancements are keeping pace with technological innovations, ensuring that digital remittance services comply with international standards. Enhanced regulatory frameworks support the secure and efficient operation of digital remittance platforms, protecting users and maintaining the integrity of financial systems.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Moreover, partnerships between fintech companies and traditional financial institutions are fostering innovation and integration in the remittance industry. These collaborations leverage the strengths of both sectors, combining technological agility with established financial networks to offer comprehensive and reliable remittance services.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Overall, digital transformation is making the remittance process faster, cheaper, more secure, and more accessible. As technology continues to evolve, the remittance industry is likely to witness further innovations, driving continuous improvements in how money is transferred globally. This evolution not only benefits individual users by providing more convenient and cost-effective services but also has broader economic implications, supporting financial inclusion and economic development on a global scale.<\\/span><\\/font><\\/p>\",\"image\":\"668cf8839ca2d1720514691.jpg\"}', NULL, 'basic', 'how-digital-transformation-is-revolutionizing-the-remittance-industry', '2022-02-26 06:23:29', '2024-07-09 02:44:51'),
(89, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"The Ultimate Guide to Sending Remittances: Best Practices and Tips\",\"description\":\"<p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Sending remittances, or transferring money to individuals in another country, is a common practice for many people, especially immigrants supporting their families back home. It\'s important to understand the best practices and tips to ensure the process is efficient, cost-effective, and secure.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Firstly, understanding the various methods available for sending remittances is crucial. You can send money through banks, online transfer services, mobile money transfer apps, or traditional money transfer services like Western Union and MoneyGram. Each method has its own fees, transfer times, and exchange rates, so comparing these factors is essential.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Choosing the right service provider can make a significant difference. Factors to consider include the fees charged for the transfer, the exchange rates offered, and the speed of the transaction. Some services may offer lower fees but have less favorable exchange rates, which can affect the total amount received by the recipient. It\'s also beneficial to check for any promotions or discounts that might be available.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Security is another key consideration. Ensure that the service you choose has strong security measures in place, such as encryption and fraud protection, to safeguard your money and personal information. Reading reviews and checking the reputation of the service provider can also provide peace of mind.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Understanding the regulatory environment of both the sending and receiving countries is important as well. Different countries have various laws and regulations regarding money transfers, which can affect the process. Be aware of any potential restrictions or requirements to avoid any issues during the transfer.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Timing your transfers can help you save money. Exchange rates fluctuate, so sending money when the rates are more favorable can increase the amount your recipient gets. Monitoring these rates and timing your remittances accordingly can be advantageous.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Communication with the recipient is crucial. Make sure they are aware of the transfer, the expected delivery time, and any identification or documentation they might need to collect the money. Clear communication helps avoid any misunderstandings or delays.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Keep track of your transactions. Maintaining records of your transfers, including the amounts sent, fees paid, and dates of transfers, can help you manage your finances better and provide necessary documentation if any issues arise.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Using loyalty programs or frequent sender programs can also be beneficial. Many remittance services offer rewards or discounts to regular customers, which can reduce the overall cost of sending money over time.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">Lastly, be mindful of the economic and political conditions in the recipient\'s country. Factors such as inflation, currency devaluation, and political instability can impact the value of the money sent and its effective use by the recipient.<\\/span><\\/font><\\/p><p class=\\\"fs--18px\\\" style=\\\"margin-right:0px;margin-left:0px;\\\"><font color=\\\"#666666\\\"><span style=\\\"font-size:18px;\\\">By carefully selecting a service, understanding the associated costs, ensuring security, and maintaining good communication, you can optimize your remittance process to be efficient, cost-effective, and secure, ultimately providing the maximum benefit to your recipient.<\\/span><\\/font><\\/p>\",\"image\":\"668cf874cd3cb1720514676.jpg\"}', NULL, 'basic', 'the-ultimate-guide-to-sending-remittances-best-practices-and-tips', '2022-02-26 06:23:51', '2024-07-09 02:44:37'),
(90, 'breadcrumb.content', '{\"has_image\":\"1\",\"image\":\"668cf9c22bc731720515010.png\"}', NULL, 'basic', NULL, '2022-02-26 06:47:05', '2024-07-09 02:50:10'),
(91, 'login.content', '{\"has_image\":\"1\",\"image\":\"6665477fb55781717913471.png\"}', NULL, 'basic', NULL, '2022-02-26 23:06:58', '2024-06-09 00:11:11'),
(92, 'register.content', '{\"has_image\":\"1\",\"image\":\"6665478915e5e1717913481.png\"}', NULL, 'basic', NULL, '2022-02-26 23:31:39', '2024-06-09 00:11:21'),
(93, 'policy_pages.element', '{\"title\":\"Refund Policy\",\"details\":\"<div class=\\\"content-block\\\" style=\\\"color:rgb(101,101,101);font-family:\'Open Sans\', sans-serif;\\\"><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We endeavor to make our clients happy with the item they\'ve bought from us. In case you\'re experiencing difficulty with excellent items or trust it is blemished, or potentially you\'re feeling baffled, at that point please present a pass to our Helpdesk to report your inadequate item and our team will help you at the earliest opportunity. For a harmed content, augmentation or layout, we will demand from you a connection and add a screen capture of the issue to be shipped off our help administration.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Refund Is Not Possible When:<\\/h3><ul class=\\\"font-18\\\" style=\\\"padding-left:15px;list-style-type:disc;font-size:18px;\\\"><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">The framework turns out great on your side yet includes don\'t match or you may have thought something different.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Your necessities are currently modified and you needn\'t bother with the Script anymore.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">You end up discovering some other Software which you believe is better.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">You don\'t need a site or administration right now.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Our highlights don\'t address your issues and prerequisites or aren\'t as extensive as you suspected.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">You don\'t have such an environment for your worker to run our framework.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">On the off chance that you as of now download our framework.<\\/li><\\/ul><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\"><span style=\\\"font-weight:bolder;\\\">No returns\\/refunds will be offered for digital products except if the product you\\u2019ve purchased is:<\\/span><\\/p><ul><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Completely non-functional \\/ not same as demo.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">If you\\u2019ve opened a support ticket but you didn\'t get any response in 48 hours (2 Business days).<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">The product description was fully misleading.<\\/li><\\/ul><p style=\\\"margin-right:0px;margin-left:0px;\\\"><\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\"><\\/p><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Please also note that:<\\/h3><ul class=\\\"font-18\\\" style=\\\"padding-left:15px;list-style-type:disc;font-size:18px;\\\"><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Refunds can take up to 45 days (depends on Bank and payment Methods) to reflect in your account.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">We normally charge 20% (4% gateway fee + 9% Dispute Fee + 7% Processing Fee) as Refund Processing fee.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">You can cancel your account at any time; no refunds for cancellation.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">You will be unable to download or use the item when you claim for refund.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">If you have been downloaded items then no refund allowed.<\\/li><\\/ul><\\/div><\\/div>\"}', NULL, 'basic', 'refund-policy', '2022-02-27 05:51:52', '2024-06-09 00:22:16'),
(95, 'brand.element', '{\"has_image\":\"1\",\"image\":\"668cf9266739d1720514854.png\"}', NULL, 'basic', NULL, '2022-02-27 06:04:37', '2024-07-09 02:47:34'),
(96, 'brand.element', '{\"has_image\":\"1\",\"image\":\"668cf9222cf421720514850.png\"}', NULL, 'basic', NULL, '2022-02-27 06:04:43', '2024-07-09 02:47:30'),
(97, 'brand.element', '{\"has_image\":\"1\",\"image\":\"668cf91ba8f591720514843.png\"}', NULL, 'basic', NULL, '2022-02-27 06:04:48', '2024-07-09 02:47:23'),
(98, 'brand.element', '{\"has_image\":\"1\",\"image\":\"668cf91694e8e1720514838.png\"}', NULL, 'basic', NULL, '2022-02-27 06:05:02', '2024-07-09 02:47:18'),
(99, 'brand.element', '{\"has_image\":\"1\",\"image\":\"668cf91235d931720514834.png\"}', NULL, 'basic', NULL, '2022-02-27 06:06:33', '2024-07-09 02:47:14'),
(100, 'brand.element', '{\"has_image\":\"1\",\"image\":\"668cf90dd63a61720514829.png\"}', NULL, 'basic', NULL, '2022-02-27 06:06:37', '2024-07-09 02:47:09'),
(102, 'app.element', '{\"key_feature_item\":\"200+ Payment gateway\"}', NULL, 'basic', NULL, '2022-05-09 04:57:37', '2022-05-26 10:16:55'),
(103, 'app.element', '{\"key_feature_item\":\"Easy Money Transfer\"}', NULL, 'basic', NULL, '2022-05-09 04:57:55', '2022-05-26 10:17:00'),
(105, 'faq.element', '{\"question\":\"In ut quam vitae odio Pellentesque dapib?\",\"answer\":\"<div>Aliquam erat volutpat. Praesent vestibulum dapibus nibh. Curabitur blandit mollis lacus.\\u00a0<span style=\\\"font-size:1rem;\\\">Sed aliquam ultrices mauris. Vivamus consectetuer hendrerit lacus. Aenean posuere, tortor sed cursus feugiat, nunc augue blandit nunc, eu sollicitudin urna dolor sagittis lacus.<\\/span><\\/div>\"}', NULL, 'basic', NULL, '2022-05-09 05:26:29', '2022-05-09 05:26:30'),
(106, 'faq.element', '{\"question\":\"Proin pretium leo ac pellentesque Sed cursus tur?\",\"answer\":\"<div>Integer ante arcu, accumsan a, consectetuer eget, posuere ut, mauris. Integer ante arcu, accumsan a, consectetuer eget, posuere ut, mauris. Nunc nonummy metus. Praesent metus tellus, elementum eu, semper a, adipiscing nec, purus.\\u00a0<span style=\\\"font-size:1rem;\\\">Cras non dolor. Fusce neque. Phasellus consectetuer vestibulum elit. Aenean posuere, tortor sed cursus feugiat, nunc augue blandit nunc, eu sollicitudin urna dolor sagittis lacus.<\\/span><\\/div>\"}', NULL, 'basic', NULL, '2022-05-09 05:26:57', '2022-05-09 05:26:57'),
(107, 'faq.element', '{\"question\":\"Lorem ipsum dolor sit amet Nulla consequat ma?\",\"answer\":\"<div>Nullam accumsan lorem in dui. Vivamus quis mi. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.\\u00a0<span style=\\\"font-size:1rem;\\\">Duis leo. Vivamus aliquet elit ac nisl. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.\\u00a0<\\/span><span><font color=\\\"#212529\\\">Sed hendrerit. Phasellus ullamcorper ipsum rutrum nunc. Praesent ut ligula non mi varius sagittis.<\\/font><\\/span><\\/div>\"}', NULL, 'basic', NULL, '2022-05-09 05:27:34', '2022-05-09 05:27:34'),
(108, 'counter.element', '{\"title\":\"Daily transection\",\"digit\":\"25\",\"icon\":\"<i class=\\\"las la-exchange-alt\\\"><\\/i>\"}', NULL, 'basic', NULL, '2022-05-12 05:27:39', '2022-05-12 05:27:39'),
(109, 'kyc_instruction.content', '{\"user_kyc_instructions\":\"KYC is a mandatory process for identifying and verifying the identity of the client when sending money using our remittance site. After providing some of the information requested by the administrator, one of our administrators will verify it and declare you as KYC verified.\",\"agent_kyc_instructions\":\"KYC is a mandatory process for identifying and verifying the identity of the client when payout, sending money, withdraw, deposit using our remittance site. After providing some of the information requested by the administrator, one of our administrators will verify it and declare you as KYC verified.\"}', NULL, 'basic', NULL, '2022-05-21 05:53:03', '2022-05-21 05:58:36'),
(110, 'user_kyc_instruction.content', '{\"instructions_before_submit\":\"KYC is a mandatory process for identifying and verifying the identity of the client when sending money using our remittance site. After providing some of the information requested by the administrator, one of our administrators will verify it and declare you as KYC verified.\",\"instructions_after_submit\":\"d\"}', NULL, 'basic', NULL, '2022-05-21 06:01:30', '2022-05-21 06:01:30'),
(111, 'kyc_instruction_user.content', '{\"verification_instruction\":\"Complete KYC to unlock the full potential of our platform! KYC helps us verify your identity and keep things secure. It is quick and easy just follow the on-screen instructions. Get started with KYC verification now!\",\"pending_instruction\":\"Your KYC verification is being reviewed. We might need some additional information. You will get an email update soon. In the meantime, explore our platform with limited features.\",\"reject_instruction\":\"We regret to inform you that the Know Your Customer (KYC) information provided has been reviewed and unfortunately, it has not met our verification standards.\"}', NULL, 'basic', NULL, '2022-05-21 06:04:15', '2024-06-09 00:10:55'),
(112, 'kyc_instruction_agent.content', '{\"verification_instruction\":\"Complete KYC to unlock the full potential of our platform! KYC helps us verify your identity and keep things secure. It is quick and easy just follow the on-screen instructions. Get started with KYC verification now!\",\"pending_instruction\":\"Your KYC verification is being reviewed. We might need some additional information. You will get an email update soon. In the meantime, explore our platform with limited features.\",\"reject_instruction\":\"We regret to inform you that the Know Your Customer (KYC) information provided has been reviewed and unfortunately, it has not met our verification standards.\"}', NULL, 'basic', NULL, '2022-05-21 06:04:24', '2024-06-09 00:10:35'),
(113, 'about.content', '{\"has_image\":\"1\",\"heading\":\"About Transfer funds across the globe\",\"description\":\"Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor econsequat vitae eleifend enim. Aliquam lorem ante dapibus in viverra quifeugiat a telluasel. world class Money Transfer\",\"image\":\"66654257b39841717912151.png\"}', NULL, 'basic', NULL, '2022-05-30 04:30:05', '2024-06-08 23:49:11'),
(114, 'about.element', '{\"feature_item\":\"Must have medical certificat\"}', NULL, 'basic', NULL, '2022-05-30 04:30:10', '2022-05-30 04:41:52'),
(115, 'about.element', '{\"feature_item\":\"Curabitur ulorper ultricies\"}', NULL, 'basic', NULL, '2022-05-30 04:30:13', '2022-05-30 04:43:24'),
(116, 'about.element', '{\"feature_item\":\"Fringilla mauris sit amet\"}', NULL, 'basic', NULL, '2022-05-30 04:30:16', '2022-05-30 04:42:14'),
(117, 'about.element', '{\"feature_item\":\"Aenean leo ligula porttitor\"}', NULL, 'basic', NULL, '2022-05-30 04:30:19', '2022-05-30 04:42:25'),
(118, 'about.element', '{\"feature_item\":\"Maecenas tempus tellus\"}', NULL, 'basic', NULL, '2022-05-30 04:30:23', '2022-05-30 04:42:34'),
(119, 'about.element', '{\"feature_item\":\"Must have medical\"}', NULL, 'basic', NULL, '2022-05-30 04:30:28', '2022-05-30 04:42:48'),
(120, 'social_icon.element', '{\"title\":\"Instagram\",\"icon\":\"<i class=\\\"lab la-instagram\\\"><\\/i>\",\"url\":\"https:\\/\\/www.instagram.com\\/\"}', NULL, 'basic', NULL, '2022-05-31 04:43:01', '2022-05-31 04:43:01'),
(121, 'social_icon.element', '{\"title\":\"Twitter\",\"icon\":\"<i class=\\\"lab la-twitter\\\"><\\/i>\",\"url\":\"https:\\/\\/www.twitter.com\\/\"}', NULL, 'basic', NULL, '2022-05-31 04:43:21', '2022-05-31 04:43:21'),
(122, 'social_icon.element', '{\"title\":\"Linked In\",\"icon\":\"<i class=\\\"lab la-linkedin-in\\\"><\\/i>\",\"url\":\"https:\\/\\/www.linkedin.com\\/\"}', NULL, 'basic', NULL, '2022-05-31 04:43:38', '2022-05-31 04:43:38'),
(123, 'feature.content', '{\"heading\":\"The Things We Offer You\"}', NULL, 'basic', NULL, '2022-06-09 10:45:58', '2022-06-11 09:17:53'),
(124, 'banned_section.content', '{\"has_image\":\"1\",\"heading\":\"You are banned\",\"image\":\"666542cca85ab1717912268.png\"}', NULL, 'basic', NULL, '2024-06-08 23:51:08', '2024-06-08 23:51:21'),
(125, 'register_disable.content', '{\"has_image\":\"1\",\"heading\":\"Registration Currently Disabled\",\"subheading\":\"Page you are looking for doesn\'t exit or an other error occurred or temporarily unavailable.\",\"button_name\":\"Go to Home\",\"button_url\":\"#\",\"image\":\"666547cb3b0fb1717913547.png\"}', NULL, 'basic', NULL, '2024-06-09 00:12:27', '2024-06-09 00:12:27');

-- --------------------------------------------------------

--
-- Table structure for table `gateways`
--

CREATE TABLE `gateways` (
  `id` bigint UNSIGNED NOT NULL,
  `form_id` int UNSIGNED NOT NULL DEFAULT '0',
  `code` int DEFAULT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NULL',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>enable, 2=>disable',
  `gateway_parameters` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `supported_currencies` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `crypto` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: fiat currency, 1: crypto currency',
  `extra` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gateways`
--

INSERT INTO `gateways` (`id`, `form_id`, `code`, `name`, `alias`, `image`, `status`, `gateway_parameters`, `supported_currencies`, `crypto`, `extra`, `description`, `created_at`, `updated_at`) VALUES
(1, 0, 101, 'Paypal', 'Paypal', '663a38d7b455d1715091671.png', 1, '{\"paypal_email\":{\"title\":\"PayPal Email\",\"global\":true,\"value\":\"--------------------\"}}', '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-06-04 00:12:30'),
(2, 0, 102, 'Perfect Money', 'PerfectMoney', '663a3920e30a31715091744.png', 1, '{\"passphrase\":{\"title\":\"ALTERNATE PASSPHRASE\",\"global\":true,\"value\":\"--------------------\"},\"wallet_id\":{\"title\":\"PM Wallet\",\"global\":false,\"value\":\"\"}}', '{\"USD\":\"$\",\"EUR\":\"\\u20ac\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-06-04 00:12:44'),
(3, 0, 103, 'Stripe Hosted', 'Stripe', '663a39861cb9d1715091846.png', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"-------\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"-------\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-07-09 00:47:50'),
(4, 0, 104, 'Skrill', 'Skrill', '663a39494c4a91715091785.png', 1, '{\"pay_to_email\":{\"title\":\"Skrill Email\",\"global\":true,\"value\":\"--------------------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"--------------------\"}}', '{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JOD\":\"JOD\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"KWD\":\"KWD\",\"MAD\":\"MAD\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"OMR\":\"OMR\",\"PLN\":\"PLN\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"SAR\":\"SAR\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TND\":\"TND\",\"TRY\":\"TRY\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\",\"COP\":\"COP\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-06-04 00:12:52'),
(5, 0, 105, 'PayTM', 'Paytm', '663a390f601191715091727.png', 1, '{\"MID\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"--------------------\"},\"merchant_key\":{\"title\":\"Merchant Key\",\"global\":true,\"value\":\"--------------------\"},\"WEBSITE\":{\"title\":\"Paytm Website\",\"global\":true,\"value\":\"--------------------\"},\"INDUSTRY_TYPE_ID\":{\"title\":\"Industry Type\",\"global\":true,\"value\":\"--------------------\"},\"CHANNEL_ID\":{\"title\":\"CHANNEL ID\",\"global\":true,\"value\":\"--------------------\"},\"transaction_url\":{\"title\":\"Transaction URL\",\"global\":true,\"value\":\"--------------------\"},\"transaction_status_url\":{\"title\":\"Transaction STATUS URL\",\"global\":true,\"value\":\"--------------------\"}}', '{\"AUD\":\"AUD\",\"ARS\":\"ARS\",\"BDT\":\"BDT\",\"BRL\":\"BRL\",\"BGN\":\"BGN\",\"CAD\":\"CAD\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"HRK\":\"HRK\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EGP\":\"EGP\",\"EUR\":\"EUR\",\"GEL\":\"GEL\",\"GHS\":\"GHS\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"KES\":\"KES\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"MAD\":\"MAD\",\"NPR\":\"NPR\",\"NZD\":\"NZD\",\"NGN\":\"NGN\",\"NOK\":\"NOK\",\"PKR\":\"PKR\",\"PEN\":\"PEN\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"ZAR\":\"ZAR\",\"KRW\":\"KRW\",\"LKR\":\"LKR\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"TRY\":\"TRY\",\"UGX\":\"UGX\",\"UAH\":\"UAH\",\"AED\":\"AED\",\"GBP\":\"GBP\",\"USD\":\"USD\",\"VND\":\"VND\",\"XOF\":\"XOF\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-06-04 00:12:41'),
(6, 0, 106, 'Payeer', 'Payeer', '663a38c9e2e931715091657.png', 1, '{\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"--------------------\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"--------------------\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"RUB\":\"RUB\"}', 0, '{\"status\":{\"title\": \"Status URL\",\"value\":\"ipn.Payeer\"}}', NULL, '2019-09-14 13:14:22', '2024-06-04 00:12:27'),
(7, 0, 107, 'PayStack', 'Paystack', '663a38fc814e91715091708.png', 1, '{\"public_key\":{\"title\":\"Public key\",\"global\":true,\"value\":\"--------------------\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"--------------------\"}}', '{\"USD\":\"USD\",\"NGN\":\"NGN\"}', 0, '{\"callback\":{\"title\": \"Callback URL\",\"value\":\"ipn.Paystack\"},\"webhook\":{\"title\": \"Webhook URL\",\"value\":\"ipn.Paystack\"}}\r\n', NULL, '2019-09-14 13:14:22', '2024-06-04 00:12:37'),
(8, 0, 109, 'Flutterwave', 'Flutterwave', '663a36c2c34d61715091138.png', 1, '{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"--------------------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"--------------------\"},\"encryption_key\":{\"title\":\"Encryption Key\",\"global\":true,\"value\":\"--------------------\"}}', '{\"BIF\":\"BIF\",\"CAD\":\"CAD\",\"CDF\":\"CDF\",\"CVE\":\"CVE\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"GHS\":\"GHS\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"KES\":\"KES\",\"LRD\":\"LRD\",\"MWK\":\"MWK\",\"MZN\":\"MZN\",\"NGN\":\"NGN\",\"RWF\":\"RWF\",\"SLL\":\"SLL\",\"STD\":\"STD\",\"TZS\":\"TZS\",\"UGX\":\"UGX\",\"USD\":\"USD\",\"XAF\":\"XAF\",\"XOF\":\"XOF\",\"ZMK\":\"ZMK\",\"ZMW\":\"ZMW\",\"ZWD\":\"ZWD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-06-04 00:12:05'),
(9, 0, 110, 'RazorPay', 'Razorpay', '663a393a527831715091770.png', 1, '{\"key_id\":{\"title\":\"Key Id\",\"global\":true,\"value\":\"--------------------\"},\"key_secret\":{\"title\":\"Key Secret \",\"global\":true,\"value\":\"--------------------\"}}', '{\"INR\":\"INR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-06-04 00:12:48'),
(10, 0, 111, 'Stripe Storefront', 'StripeJs', '663a3995417171715091861.png', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"--------------------\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"--------------------\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-06-04 00:13:00'),
(11, 0, 112, 'Instamojo', 'Instamojo', '663a384d54a111715091533.png', 1, '{\"api_key\":{\"title\":\"API KEY\",\"global\":true,\"value\":\"--------------------\"},\"auth_token\":{\"title\":\"Auth Token\",\"global\":true,\"value\":\"--------------------\"},\"salt\":{\"title\":\"Salt\",\"global\":true,\"value\":\"--------------------\"}}', '{\"INR\":\"INR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-06-04 00:12:09'),
(12, 0, 501, 'Blockchain', 'Blockchain', '663a35efd0c311715090927.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"--------------------\"},\"xpub_code\":{\"title\":\"XPUB CODE\",\"global\":true,\"value\":\"--------------------\"}}', '{\"BTC\":\"BTC\"}', 1, NULL, NULL, '2019-09-14 13:14:22', '2024-06-04 00:11:46'),
(13, 0, 503, 'CoinPayments', 'Coinpayments', '663a36a8d8e1d1715091112.png', 1, '{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"--------------------\"},\"private_key\":{\"title\":\"Private Key\",\"global\":true,\"value\":\"--------------------\"},\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"--------------------\"}}', '{\"BTC\":\"Bitcoin\",\"BTC.LN\":\"Bitcoin (Lightning Network)\",\"LTC\":\"Litecoin\",\"CPS\":\"CPS Coin\",\"VLX\":\"Velas\",\"APL\":\"Apollo\",\"AYA\":\"Aryacoin\",\"BAD\":\"Badcoin\",\"BCD\":\"Bitcoin Diamond\",\"BCH\":\"Bitcoin Cash\",\"BCN\":\"Bytecoin\",\"BEAM\":\"BEAM\",\"BITB\":\"Bean Cash\",\"BLK\":\"BlackCoin\",\"BSV\":\"Bitcoin SV\",\"BTAD\":\"Bitcoin Adult\",\"BTG\":\"Bitcoin Gold\",\"BTT\":\"BitTorrent\",\"CLOAK\":\"CloakCoin\",\"CLUB\":\"ClubCoin\",\"CRW\":\"Crown\",\"CRYP\":\"CrypticCoin\",\"CRYT\":\"CryTrExCoin\",\"CURE\":\"CureCoin\",\"DASH\":\"DASH\",\"DCR\":\"Decred\",\"DEV\":\"DeviantCoin\",\"DGB\":\"DigiByte\",\"DOGE\":\"Dogecoin\",\"EBST\":\"eBoost\",\"EOS\":\"EOS\",\"ETC\":\"Ether Classic\",\"ETH\":\"Ethereum\",\"ETN\":\"Electroneum\",\"EUNO\":\"EUNO\",\"EXP\":\"EXP\",\"Expanse\":\"Expanse\",\"FLASH\":\"FLASH\",\"GAME\":\"GameCredits\",\"GLC\":\"Goldcoin\",\"GRS\":\"Groestlcoin\",\"KMD\":\"Komodo\",\"LOKI\":\"LOKI\",\"LSK\":\"LSK\",\"MAID\":\"MaidSafeCoin\",\"MUE\":\"MonetaryUnit\",\"NAV\":\"NAV Coin\",\"NEO\":\"NEO\",\"NMC\":\"Namecoin\",\"NVST\":\"NVO Token\",\"NXT\":\"NXT\",\"OMNI\":\"OMNI\",\"PINK\":\"PinkCoin\",\"PIVX\":\"PIVX\",\"POT\":\"PotCoin\",\"PPC\":\"Peercoin\",\"PROC\":\"ProCurrency\",\"PURA\":\"PURA\",\"QTUM\":\"QTUM\",\"RES\":\"Resistance\",\"RVN\":\"Ravencoin\",\"RVR\":\"RevolutionVR\",\"SBD\":\"Steem Dollars\",\"SMART\":\"SmartCash\",\"SOXAX\":\"SOXAX\",\"STEEM\":\"STEEM\",\"STRAT\":\"STRAT\",\"SYS\":\"Syscoin\",\"TPAY\":\"TokenPay\",\"TRIGGERS\":\"Triggers\",\"TRX\":\" TRON\",\"UBQ\":\"Ubiq\",\"UNIT\":\"UniversalCurrency\",\"USDT\":\"Tether USD (Omni Layer)\",\"USDT.BEP20\":\"Tether USD (BSC Chain)\",\"USDT.ERC20\":\"Tether USD (ERC20)\",\"USDT.TRC20\":\"Tether USD (Tron/TRC20)\",\"VTC\":\"Vertcoin\",\"WAVES\":\"Waves\",\"XCP\":\"Counterparty\",\"XEM\":\"NEM\",\"XMR\":\"Monero\",\"XSN\":\"Stakenet\",\"XSR\":\"SucreCoin\",\"XVG\":\"VERGE\",\"XZC\":\"ZCoin\",\"ZEC\":\"ZCash\",\"ZEN\":\"Horizen\"}', 1, NULL, NULL, '2019-09-14 13:14:22', '2024-06-04 00:12:00'),
(14, 0, 504, 'CoinPayments Fiat', 'CoinpaymentsFiat', '663a36b7b841a1715091127.png', 1, '{\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"--------------------\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-06-04 00:12:03'),
(15, 0, 505, 'Coingate', 'Coingate', '663a368e753381715091086.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"--------------------\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-06-04 00:11:57'),
(16, 0, 506, 'Coinbase Commerce', 'CoinbaseCommerce', '663a367e46ae51715091070.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"--------------------\"},\"secret\":{\"title\":\"Webhook Shared Secret\",\"global\":true,\"value\":\"--------------------\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"JPY\":\"JPY\",\"GBP\":\"GBP\",\"AUD\":\"AUD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CNY\":\"CNY\",\"SEK\":\"SEK\",\"NZD\":\"NZD\",\"MXN\":\"MXN\",\"SGD\":\"SGD\",\"HKD\":\"HKD\",\"NOK\":\"NOK\",\"KRW\":\"KRW\",\"TRY\":\"TRY\",\"RUB\":\"RUB\",\"INR\":\"INR\",\"BRL\":\"BRL\",\"ZAR\":\"ZAR\",\"AED\":\"AED\",\"AFN\":\"AFN\",\"ALL\":\"ALL\",\"AMD\":\"AMD\",\"ANG\":\"ANG\",\"AOA\":\"AOA\",\"ARS\":\"ARS\",\"AWG\":\"AWG\",\"AZN\":\"AZN\",\"BAM\":\"BAM\",\"BBD\":\"BBD\",\"BDT\":\"BDT\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"BIF\":\"BIF\",\"BMD\":\"BMD\",\"BND\":\"BND\",\"BOB\":\"BOB\",\"BSD\":\"BSD\",\"BTN\":\"BTN\",\"BWP\":\"BWP\",\"BYN\":\"BYN\",\"BZD\":\"BZD\",\"CDF\":\"CDF\",\"CLF\":\"CLF\",\"CLP\":\"CLP\",\"COP\":\"COP\",\"CRC\":\"CRC\",\"CUC\":\"CUC\",\"CUP\":\"CUP\",\"CVE\":\"CVE\",\"CZK\":\"CZK\",\"DJF\":\"DJF\",\"DKK\":\"DKK\",\"DOP\":\"DOP\",\"DZD\":\"DZD\",\"EGP\":\"EGP\",\"ERN\":\"ERN\",\"ETB\":\"ETB\",\"FJD\":\"FJD\",\"FKP\":\"FKP\",\"GEL\":\"GEL\",\"GGP\":\"GGP\",\"GHS\":\"GHS\",\"GIP\":\"GIP\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"GTQ\":\"GTQ\",\"GYD\":\"GYD\",\"HNL\":\"HNL\",\"HRK\":\"HRK\",\"HTG\":\"HTG\",\"HUF\":\"HUF\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"IMP\":\"IMP\",\"IQD\":\"IQD\",\"IRR\":\"IRR\",\"ISK\":\"ISK\",\"JEP\":\"JEP\",\"JMD\":\"JMD\",\"JOD\":\"JOD\",\"KES\":\"KES\",\"KGS\":\"KGS\",\"KHR\":\"KHR\",\"KMF\":\"KMF\",\"KPW\":\"KPW\",\"KWD\":\"KWD\",\"KYD\":\"KYD\",\"KZT\":\"KZT\",\"LAK\":\"LAK\",\"LBP\":\"LBP\",\"LKR\":\"LKR\",\"LRD\":\"LRD\",\"LSL\":\"LSL\",\"LYD\":\"LYD\",\"MAD\":\"MAD\",\"MDL\":\"MDL\",\"MGA\":\"MGA\",\"MKD\":\"MKD\",\"MMK\":\"MMK\",\"MNT\":\"MNT\",\"MOP\":\"MOP\",\"MRO\":\"MRO\",\"MUR\":\"MUR\",\"MVR\":\"MVR\",\"MWK\":\"MWK\",\"MYR\":\"MYR\",\"MZN\":\"MZN\",\"NAD\":\"NAD\",\"NGN\":\"NGN\",\"NIO\":\"NIO\",\"NPR\":\"NPR\",\"OMR\":\"OMR\",\"PAB\":\"PAB\",\"PEN\":\"PEN\",\"PGK\":\"PGK\",\"PHP\":\"PHP\",\"PKR\":\"PKR\",\"PLN\":\"PLN\",\"PYG\":\"PYG\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"RWF\":\"RWF\",\"SAR\":\"SAR\",\"SBD\":\"SBD\",\"SCR\":\"SCR\",\"SDG\":\"SDG\",\"SHP\":\"SHP\",\"SLL\":\"SLL\",\"SOS\":\"SOS\",\"SRD\":\"SRD\",\"SSP\":\"SSP\",\"STD\":\"STD\",\"SVC\":\"SVC\",\"SYP\":\"SYP\",\"SZL\":\"SZL\",\"THB\":\"THB\",\"TJS\":\"TJS\",\"TMT\":\"TMT\",\"TND\":\"TND\",\"TOP\":\"TOP\",\"TTD\":\"TTD\",\"TWD\":\"TWD\",\"TZS\":\"TZS\",\"UAH\":\"UAH\",\"UGX\":\"UGX\",\"UYU\":\"UYU\",\"UZS\":\"UZS\",\"VEF\":\"VEF\",\"VND\":\"VND\",\"VUV\":\"VUV\",\"WST\":\"WST\",\"XAF\":\"XAF\",\"XAG\":\"XAG\",\"XAU\":\"XAU\",\"XCD\":\"XCD\",\"XDR\":\"XDR\",\"XOF\":\"XOF\",\"XPD\":\"XPD\",\"XPF\":\"XPF\",\"XPT\":\"XPT\",\"YER\":\"YER\",\"ZMW\":\"ZMW\",\"ZWL\":\"ZWL\"}\r\n\r\n', 0, '{\"endpoint\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.CoinbaseCommerce\"}}', NULL, '2019-09-14 13:14:22', '2024-06-04 00:11:52'),
(17, 0, 113, 'Paypal Express', 'PaypalSdk', '663a38ed101a61715091693.png', 1, '{\"clientId\":{\"title\":\"Paypal Client ID\",\"global\":true,\"value\":\"--------------------\"},\"clientSecret\":{\"title\":\"Client Secret\",\"global\":true,\"value\":\"--------------------\"}}', '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-06-04 00:12:34'),
(18, 0, 114, 'Stripe Checkout', 'StripeV3', '663a39afb519f1715091887.png', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"--------------------\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"--------------------\"},\"end_point\":{\"title\":\"End Point Secret\",\"global\":true,\"value\":\"--------------------\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, '{\"webhook\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.StripeV3\"}}', NULL, '2019-09-14 13:14:22', '2024-06-04 00:13:04'),
(19, 0, 115, 'Mollie', 'Mollie', '663a387ec69371715091582.png', 1, '{\"mollie_email\":{\"title\":\"Mollie Email \",\"global\":true,\"value\":\"--------------------\"},\"api_key\":{\"title\":\"API KEY\",\"global\":true,\"value\":\"--------------------\"}}', '{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-06-04 00:12:16'),
(20, 0, 116, 'Cashmaal', 'Cashmaal', '663a361b16bd11715090971.png', 1, '{\"web_id\":{\"title\":\"Web Id\",\"global\":true,\"value\":\"--------------------\"},\"ipn_key\":{\"title\":\"IPN Key\",\"global\":true,\"value\":\"--------------------\"}}', '{\"PKR\":\"PKR\",\"USD\":\"USD\"}', 0, '{\"webhook\":{\"title\": \"IPN URL\",\"value\":\"ipn.Cashmaal\"}}', NULL, NULL, '2024-06-04 00:11:49'),
(21, 0, 119, 'Mercado Pago', 'MercadoPago', '663a386c714a91715091564.png', 1, '{\"access_token\":{\"title\":\"Access Token\",\"global\":true,\"value\":\"--------------------\"}}', '{\"USD\":\"USD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"NOK\":\"NOK\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"AUD\":\"AUD\",\"NZD\":\"NZD\"}', 0, NULL, NULL, NULL, '2024-06-04 00:12:12'),
(22, 0, 122, 'BTCPay', 'BTCPay', '663a39b8e64b91715091896.png', 1, '{\"store_id\":{\"title\":\"Store Id\",\"global\":true,\"value\":\"-------\"},\"api_key\":{\"title\":\"Api Key\",\"global\":true,\"value\":\"------\"},\"server_name\":{\"title\":\"Server Name\",\"global\":true,\"value\":\"-------\"},\"secret_code\":{\"title\":\"Secret Code\",\"global\":true,\"value\":\"----------\"}}', '{\"BTC\":\"Bitcoin\",\"LTC\":\"Litecoin\"}', 1, '{\"webhook\":{\"title\": \"IPN URL\",\"value\":\"ipn.BTCPay\"}}', NULL, NULL, '2024-07-09 00:46:44'),
(23, 0, 123, 'Now payments hosted', 'NowPaymentsHosted', '663a3628733351715090984.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"--------------------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"--------------------\"}}', '{\"BTG\":\"BTG\",\"ETH\":\"ETH\",\"XMR\":\"XMR\",\"ZEC\":\"ZEC\",\"XVG\":\"XVG\",\"ADA\":\"ADA\",\"LTC\":\"LTC\",\"BCH\":\"BCH\",\"QTUM\":\"QTUM\",\"DASH\":\"DASH\",\"XLM\":\"XLM\",\"XRP\":\"XRP\",\"XEM\":\"XEM\",\"DGB\":\"DGB\",\"LSK\":\"LSK\",\"DOGE\":\"DOGE\",\"TRX\":\"TRX\",\"KMD\":\"KMD\",\"REP\":\"REP\",\"BAT\":\"BAT\",\"ARK\":\"ARK\",\"WAVES\":\"WAVES\",\"BNB\":\"BNB\",\"XZC\":\"XZC\",\"NANO\":\"NANO\",\"TUSD\":\"TUSD\",\"VET\":\"VET\",\"ZEN\":\"ZEN\",\"GRS\":\"GRS\",\"FUN\":\"FUN\",\"NEO\":\"NEO\",\"GAS\":\"GAS\",\"PAX\":\"PAX\",\"USDC\":\"USDC\",\"ONT\":\"ONT\",\"XTZ\":\"XTZ\",\"LINK\":\"LINK\",\"RVN\":\"RVN\",\"BNBMAINNET\":\"BNBMAINNET\",\"ZIL\":\"ZIL\",\"BCD\":\"BCD\",\"USDT\":\"USDT\",\"USDTERC20\":\"USDTERC20\",\"CRO\":\"CRO\",\"DAI\":\"DAI\",\"HT\":\"HT\",\"WABI\":\"WABI\",\"BUSD\":\"BUSD\",\"ALGO\":\"ALGO\",\"USDTTRC20\":\"USDTTRC20\",\"GT\":\"GT\",\"STPT\":\"STPT\",\"AVA\":\"AVA\",\"SXP\":\"SXP\",\"UNI\":\"UNI\",\"OKB\":\"OKB\",\"BTC\":\"BTC\"}', 1, '', NULL, NULL, '2024-06-04 00:12:23'),
(24, 0, 509, 'Now payments checkout', 'NowPaymentsCheckout', '663a38a59d2541715091621.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"--------------------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"--------------------\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\"}', 1, '', NULL, NULL, '2024-06-04 00:12:20'),
(25, 0, 510, 'Binance', 'Binance', '663a35db4fd621715090907.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"-------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"-------\"},\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"-------\"}}', '{\"BTC\":\"Bitcoin\",\"USD\":\"USD\",\"BNB\":\"BNB\"}', 1, '{\"cron\":{\"title\": \"Cron Job URL\",\"value\":\"ipn.Binance\"}}', NULL, NULL, '2024-07-09 00:46:52'),
(26, 0, 124, 'SslCommerz', 'SslCommerz', '663a397a70c571715091834.png', 1, '{\"store_id\":{\"title\":\"Store ID\",\"global\":true,\"value\":\"---------\"},\"store_password\":{\"title\":\"Store Password\",\"global\":true,\"value\":\"----------\"}}', '{\"BDT\":\"BDT\",\"USD\":\"USD\",\"EUR\":\"EUR\",\"SGD\":\"SGD\",\"INR\":\"INR\",\"MYR\":\"MYR\"}', 0, NULL, NULL, NULL, '2024-06-03 04:55:03'),
(27, 0, 125, 'Aamarpay', 'Aamarpay', '663a34d5d1dfc1715090645.png', 1, '{\"store_id\":{\"title\":\"Store ID\",\"global\":true,\"value\":\"---------\"},\"signature_key\":{\"title\":\"Signature Key\",\"global\":true,\"value\":\"----------\"}}', '{\"BDT\":\"BDT\"}', 0, NULL, NULL, NULL, '2024-06-04 00:11:41'),
(28, 0, 126, '2Checkout', 'TwoCheckout', '663a39b8e64b91715091896.png', 1, '{\"merchant_code\":{\"title\":\"Merchant Code\",\"global\":true,\"value\":\"-------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"-------\"}}', '{\"AFN\": \"AFN\",\"ALL\": \"ALL\",\"DZD\": \"DZD\",\"ARS\": \"ARS\",\"AUD\": \"AUD\",\"AZN\": \"AZN\",\"BSD\": \"BSD\",\"BDT\": \"BDT\",\"BBD\": \"BBD\",\"BZD\": \"BZD\",\"BMD\": \"BMD\",\"BOB\": \"BOB\",\"BWP\": \"BWP\",\"BRL\": \"BRL\",\"GBP\": \"GBP\",\"BND\": \"BND\",\"BGN\": \"BGN\",\"CAD\": \"CAD\",\"CLP\": \"CLP\",\"CNY\": \"CNY\",\"COP\": \"COP\",\"CRC\": \"CRC\",\"HRK\": \"HRK\",\"CZK\": \"CZK\",\"DKK\": \"DKK\",\"DOP\": \"DOP\",\"XCD\": \"XCD\",\"EGP\": \"EGP\",\"EUR\": \"EUR\",\"FJD\": \"FJD\",\"GTQ\": \"GTQ\",\"HKD\": \"HKD\",\"HNL\": \"HNL\",\"HUF\": \"HUF\",\"INR\": \"INR\",\"IDR\": \"IDR\",\"ILS\": \"ILS\",\"JMD\": \"JMD\",\"JPY\": \"JPY\",\"KZT\": \"KZT\",\"KES\": \"KES\",\"LAK\": \"LAK\",\"MMK\": \"MMK\",\"LBP\": \"LBP\",\"LRD\": \"LRD\",\"MOP\": \"MOP\",\"MYR\": \"MYR\",\"MVR\": \"MVR\",\"MRO\": \"MRO\",\"MUR\": \"MUR\",\"MXN\": \"MXN\",\"MAD\": \"MAD\",\"NPR\": \"NPR\",\"TWD\": \"TWD\",\"NZD\": \"NZD\",\"NIO\": \"NIO\",\"NOK\": \"NOK\",\"PKR\": \"PKR\",\"PGK\": \"PGK\",\"PEN\": \"PEN\",\"PHP\": \"PHP\",\"PLN\": \"PLN\",\"QAR\": \"QAR\",\"RON\": \"RON\",\"RUB\": \"RUB\",\"WST\": \"WST\",\"SAR\": \"SAR\",\"SCR\": \"SCR\",\"SGD\": \"SGD\",\"SBD\": \"SBD\",\"ZAR\": \"ZAR\",\"KRW\": \"KRW\",\"LKR\": \"LKR\",\"SEK\": \"SEK\",\"CHF\": \"CHF\",\"SYP\": \"SYP\",\"THB\": \"THB\",\"TOP\": \"TOP\",\"TTD\": \"TTD\",\"TRY\": \"TRY\",\"UAH\": \"UAH\",\"AED\": \"AED\",\"USD\": \"USD\",\"VUV\": \"VUV\",\"VND\": \"VND\",\"XOF\": \"XOF\",\"YER\": \"YER\"}', 0, '{\"approved_url\":{\"title\": \"Approved URL\",\"value\":\"ipn.TwoCheckout\"}}', NULL, NULL, '2024-07-09 00:47:58'),
(29, 0, 127, 'Checkout', 'Checkout', '663a3628733351715090984.png', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"------\"},\"public_key\":{\"title\":\"PUBLIC KEY\",\"global\":true,\"value\":\"------\"},\"processing_channel_id\":{\"title\":\"PROCESSING CHANNEL\",\"global\":true,\"value\":\"------\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"AUD\":\"AUD\",\"CAN\":\"CAN\",\"CHF\":\"CHF\",\"SGD\":\"SGD\",\"JPY\":\"JPY\",\"NZD\":\"NZD\"}', 0, NULL, NULL, NULL, '2024-05-07 08:09:44');

-- --------------------------------------------------------

--
-- Table structure for table `gateway_currencies`
--

CREATE TABLE `gateway_currencies` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `symbol` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method_code` int DEFAULT NULL,
  `gateway_alias` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `max_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `percent_charge` decimal(5,2) NOT NULL DEFAULT '0.00',
  `fixed_charge` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `rate` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `gateway_parameter` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `site_name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cur_text` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'currency text',
  `cur_sym` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'currency symbol',
  `email_from` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_from_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_template` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sms_template` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_from` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_template` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `base_color` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agent_fixed_commission` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `agent_percent_commission` decimal(5,2) NOT NULL DEFAULT '0.00',
  `referral_commission` decimal(5,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `commission_count` int UNSIGNED NOT NULL DEFAULT '0',
  `user_send_money_limit` decimal(28,8) UNSIGNED NOT NULL DEFAULT '0.00000000',
  `user_daily_send_money_limit` decimal(28,8) UNSIGNED NOT NULL DEFAULT '0.00000000',
  `user_monthly_send_money_limit` decimal(28,8) UNSIGNED NOT NULL DEFAULT '0.00000000',
  `agent_send_money_limit` decimal(28,8) UNSIGNED NOT NULL DEFAULT '0.00000000',
  `agent_daily_send_money_limit` decimal(28,8) UNSIGNED NOT NULL DEFAULT '0.00000000',
  `agent_monthly_send_money_limit` decimal(28,8) UNSIGNED NOT NULL DEFAULT '0.00000000',
  `resent_code_duration` int NOT NULL DEFAULT '0',
  `mail_config` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'email configuration',
  `sms_config` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `global_shortcodes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kv` tinyint(1) NOT NULL DEFAULT '0',
  `ev` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'email verification, 0 - dont check, 1 - check',
  `en` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'email notification, 0 - dont send, 1 - send',
  `sv` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'mobile verication, 0 - dont check, 1 - check',
  `sn` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'sms notification, 0 - dont send, 1 - send',
  `pn` tinyint(1) NOT NULL DEFAULT '1',
  `force_ssl` tinyint(1) NOT NULL DEFAULT '0',
  `maintenance_mode` tinyint(1) NOT NULL DEFAULT '0',
  `secure_password` tinyint(1) NOT NULL DEFAULT '0',
  `agree` tinyint(1) NOT NULL DEFAULT '0',
  `multi_language` tinyint(1) NOT NULL DEFAULT '1',
  `registration` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: Off	, 1: On',
  `active_template` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_customized` tinyint(1) NOT NULL DEFAULT '0',
  `paginate_number` int NOT NULL DEFAULT '0',
  `currency_format` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=>Both\r\n2=>Text Only\r\n3=>Symbol Only',
  `last_cron` datetime DEFAULT NULL,
  `available_version` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kyc_modules` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `referral_system` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `agent_module` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `agent_charges` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `firebase_config` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `push_notify` tinyint(1) NOT NULL DEFAULT '1',
  `conversion_rate_api` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `site_name`, `cur_text`, `cur_sym`, `email_from`, `email_from_name`, `email_template`, `sms_template`, `sms_from`, `push_title`, `push_template`, `base_color`, `agent_fixed_commission`, `agent_percent_commission`, `referral_commission`, `commission_count`, `user_send_money_limit`, `user_daily_send_money_limit`, `user_monthly_send_money_limit`, `agent_send_money_limit`, `agent_daily_send_money_limit`, `agent_monthly_send_money_limit`, `resent_code_duration`, `mail_config`, `sms_config`, `global_shortcodes`, `kv`, `ev`, `en`, `sv`, `sn`, `pn`, `force_ssl`, `maintenance_mode`, `secure_password`, `agree`, `multi_language`, `registration`, `active_template`, `system_customized`, `paginate_number`, `currency_format`, `last_cron`, `available_version`, `kyc_modules`, `referral_system`, `agent_module`, `agent_charges`, `firebase_config`, `push_notify`, `conversion_rate_api`, `created_at`, `updated_at`) VALUES
(1, 'ViserRemit', 'USD', '$', 'no-reply@viserlab.com', '{{site_name}}', '<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n  <!--[if !mso]><!-->\r\n  <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\r\n  <!--<![endif]-->\r\n  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n  <title></title>\r\n  <style type=\"text/css\">\r\n.ReadMsgBody { width: 100%; background-color: #ffffff; }\r\n.ExternalClass { width: 100%; background-color: #ffffff; }\r\n.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: 100%; }\r\nhtml { width: 100%; }\r\nbody { -webkit-text-size-adjust: none; -ms-text-size-adjust: none; margin: 0; padding: 0; }\r\ntable { border-spacing: 0; table-layout: fixed; margin: 0 auto;border-collapse: collapse; }\r\ntable table table { table-layout: auto; }\r\n.yshortcuts a { border-bottom: none !important; }\r\nimg:hover { opacity: 0.9 !important; }\r\na { color: #0087ff; text-decoration: none; }\r\n.textbutton a { font-family: \'open sans\', arial, sans-serif !important;}\r\n.btn-link a { color:#FFFFFF !important;}\r\n\r\n@media only screen and (max-width: 480px) {\r\nbody { width: auto !important; }\r\n*[class=\"table-inner\"] { width: 90% !important; text-align: center !important; }\r\n*[class=\"table-full\"] { width: 100% !important; text-align: center !important; }\r\n/* image */\r\nimg[class=\"img1\"] { width: 100% !important; height: auto !important; }\r\n}\r\n</style>\r\n\r\n\r\n\r\n  <table bgcolor=\"#414a51\" width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n    <tbody><tr>\r\n      <td height=\"50\"></td>\r\n    </tr>\r\n    <tr>\r\n      <td align=\"center\" style=\"text-align:center;vertical-align:top;font-size:0;\">\r\n        <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n          <tbody><tr>\r\n            <td align=\"center\" width=\"600\">\r\n              <!--header-->\r\n              <table class=\"table-inner\" width=\"95%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                <tbody><tr>\r\n                  <td bgcolor=\"#0087ff\" style=\"border-top-left-radius:6px; border-top-right-radius:6px;text-align:center;vertical-align:top;font-size:0;\" align=\"center\">\r\n                    <table width=\"90%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                      <tbody><tr>\r\n                        <td height=\"20\"></td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td align=\"center\" style=\"font-family: \'Open sans\', Arial, sans-serif; color:#FFFFFF; font-size:16px; font-weight: bold;\">This is a System Generated Email</td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td height=\"20\"></td>\r\n                      </tr>\r\n                    </tbody></table>\r\n                  </td>\r\n                </tr>\r\n              </tbody></table>\r\n              <!--end header-->\r\n              <table class=\"table-inner\" width=\"95%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n                <tbody><tr>\r\n                  <td bgcolor=\"#FFFFFF\" align=\"center\" style=\"text-align:center;vertical-align:top;font-size:0;\">\r\n                    <table align=\"center\" width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n                      <tbody><tr>\r\n                        <td height=\"35\"></td>\r\n                      </tr>\r\n                      <!--logo-->\r\n                      <tr>\r\n                        <td align=\"center\" style=\"vertical-align:top;font-size:0;\">\r\n                          <a href=\"#\">\r\n                            <img style=\"display:block; line-height:0px; font-size:0px; border:0px;\" src=\"https://i.ibb.co/rw2fTRM/logo-dark.png\" width=\"220\" alt=\"img\">\r\n                          </a>\r\n                        </td>\r\n                      </tr>\r\n                      <!--end logo-->\r\n                      <tr>\r\n                        <td height=\"40\"></td>\r\n                      </tr>\r\n                      <!--headline-->\r\n                      <tr>\r\n                        <td align=\"center\" style=\"font-family: \'Open Sans\', Arial, sans-serif; font-size: 22px;color:#414a51;font-weight: bold;\">Hello {{fullname}} ({{username}})</td>\r\n                      </tr>\r\n                      <!--end headline-->\r\n                      <tr>\r\n                        <td align=\"center\" style=\"text-align:center;vertical-align:top;font-size:0;\">\r\n                          <table width=\"40\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                            <tbody><tr>\r\n                              <td height=\"20\" style=\" border-bottom:3px solid #0087ff;\"></td>\r\n                            </tr>\r\n                          </tbody></table>\r\n                        </td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td height=\"20\"></td>\r\n                      </tr>\r\n                      <!--content-->\r\n                      <tr>\r\n                        <td align=\"left\" style=\"font-family: \'Open sans\', Arial, sans-serif; color:#7f8c8d; font-size:16px; line-height: 28px;\">{{message}}</td>\r\n                      </tr>\r\n                      <!--end content-->\r\n                      <tr>\r\n                        <td height=\"40\"></td>\r\n                      </tr>\r\n              \r\n                    </tbody></table>\r\n                  </td>\r\n                </tr>\r\n                <tr>\r\n                  <td height=\"45\" align=\"center\" bgcolor=\"#f4f4f4\" style=\"border-bottom-left-radius:6px;border-bottom-right-radius:6px;\">\r\n                    <table align=\"center\" width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n                      <tbody><tr>\r\n                        <td height=\"10\"></td>\r\n                      </tr>\r\n                      <!--preference-->\r\n                      <tr>\r\n                        <td class=\"preference-link\" align=\"center\" style=\"font-family: \'Open sans\', Arial, sans-serif; color:#95a5a6; font-size:14px;\">\r\n                          © 2024 <a href=\"#\">{{site_name}}</a>&nbsp;. All Rights Reserved. \r\n                        </td>\r\n                      </tr>\r\n                      <!--end preference-->\r\n                      <tr>\r\n                        <td height=\"10\"></td>\r\n                      </tr>\r\n                    </tbody></table>\r\n                  </td>\r\n                </tr>\r\n              </tbody></table>\r\n            </td>\r\n          </tr>\r\n        </tbody></table>\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td height=\"60\"></td>\r\n    </tr>\r\n  </tbody></table>', 'hi {{fullname}} ({{username}}), {{message}}', 'ViserAdmin', NULL, NULL, '4944ff', 0.00000000, 0.00, 0.00, 0, 0.00000000, 0.00000000, 0.00000000, 0.00000000, 0.00000000, 0.00000000, 120, '{\"name\":\"php\"}', '{\"name\":\"nexmo\",\"clickatell\":{\"api_key\":\"----------------\"},\"infobip\":{\"username\":\"------------8888888\",\"password\":\"-----------------\"},\"message_bird\":{\"api_key\":\"-------------------\"},\"nexmo\":{\"api_key\":\"----------------------\",\"api_secret\":\"----------------------\"},\"sms_broadcast\":{\"username\":\"----------------------\",\"password\":\"-----------------------------\"},\"twilio\":{\"account_sid\":\"-----------------------\",\"auth_token\":\"---------------------------\",\"from\":\"----------------------\"},\"text_magic\":{\"username\":\"-----------------------\",\"apiv2_key\":\"-------------------------------\"},\"custom\":{\"method\":\"get\",\"url\":\"https:\\/\\/hostname\\/demo-api-v1\",\"headers\":{\"name\":[\"api_key\"],\"value\":[\"test_api 555\"]},\"body\":{\"name\":[\"from_number\"],\"value\":[\"5657545757\"]}}}', '{\n    \"site_name\":\"Name of your site\",\n    \"site_currency\":\"Currency of your site\",\n    \"currency_symbol\":\"Symbol of currency\"\n}', 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 'basic', 0, 20, 1, '2024-06-11 07:41:25', '0', NULL, 0, 1, '{\"fixed_charge\":\"0\",\"percent_charge\":\"0\"}', '{\"apiKey\":\"-------------------------\",\"authDomain\":\"-------------------------\",\"projectId\":\"-------------------------\",\"storageBucket\":\"-------------------------\",\"messagingSenderId\":\"-------------------------\",\"appId\":\"-------------------------\",\"measurementId\":\"-------------------------\"}', 1, '{\"status\":\"on\",\"provider\":\"exchangerate\",\"exchangerate\":{\"api_key\":null},\"fixed_adjustment\":\"1\",\"percent_adjustment\":\"1\",\"auto_synchronization\":true}', NULL, '2024-07-09 02:57:15');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: not default language, 1: default language',
  `image` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `is_default`, `image`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', 1, '665da653154621717413459.png', '2020-07-06 03:47:55', '2024-06-03 05:17:39');

-- --------------------------------------------------------

--
-- Table structure for table `notification_logs`
--

CREATE TABLE `notification_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `agent_id` int UNSIGNED NOT NULL DEFAULT '0',
  `sender` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_from` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_to` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `notification_type` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_read` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_templates`
--

CREATE TABLE `notification_templates` (
  `id` bigint UNSIGNED NOT NULL,
  `act` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sms_body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `push_body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `shortcodes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `email_status` tinyint(1) NOT NULL DEFAULT '1',
  `email_sent_from_name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_sent_from_address` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_status` tinyint(1) NOT NULL DEFAULT '1',
  `sms_sent_from` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_templates`
--

INSERT INTO `notification_templates` (`id`, `act`, `name`, `subject`, `push_title`, `email_body`, `sms_body`, `push_body`, `shortcodes`, `email_status`, `email_sent_from_name`, `email_sent_from_address`, `sms_status`, `sms_sent_from`, `push_status`, `created_at`, `updated_at`) VALUES
(1, 'BAL_ADD', 'Balance - Added', 'Your Account has been Credited', NULL, '<div><div style=\"font-family: Montserrat, sans-serif;\">{{amount}} {{site_currency}} has been added to your account .</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><span style=\"color: rgb(33, 37, 41); font-family: Montserrat, sans-serif;\">Your Current Balance is :&nbsp;</span><font style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">{{post_balance}}&nbsp; {{site_currency}}&nbsp;</span></font><br></div><div><font style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></font></div><div>Admin note:&nbsp;<span style=\"color: rgb(33, 37, 41); font-size: 12px; font-weight: 600; white-space: nowrap; text-align: var(--bs-body-text-align);\">{{remark}}</span></div>', '{{amount}} {{site_currency}} credited in your account. Your Current Balance {{post_balance}} {{site_currency}} . Transaction: #{{trx}}. Admin note is \"{{remark}}\"', NULL, '{\"trx\":\"Transaction number for the action\",\"amount\":\"Amount inserted by the admin\",\"remark\":\"Remark inserted by the admin\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, NULL, NULL, 0, NULL, 0, '2021-11-03 12:00:00', '2022-04-03 02:18:28'),
(2, 'BAL_SUB', 'Balance - Subtracted', 'Your Account has been Debited', NULL, '<div style=\"font-family: Montserrat, sans-serif;\">{{amount}} {{site_currency}} has been subtracted from your account .</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><span style=\"color: rgb(33, 37, 41); font-family: Montserrat, sans-serif;\">Your Current Balance is :&nbsp;</span><font style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">{{post_balance}}&nbsp; {{site_currency}}</span></font><br><div><font style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></font></div><div>Admin Note: {{remark}}</div>', '{{amount}} {{site_currency}} debited from your account. Your Current Balance {{post_balance}} {{site_currency}} . Transaction: #{{trx}}. Admin Note is {{remark}}', NULL, '{\"trx\":\"Transaction number for the action\",\"amount\":\"Amount inserted by the admin\",\"remark\":\"Remark inserted by the admin\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, NULL, NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2022-04-03 02:24:11'),
(3, 'DEPOSIT_COMPLETE', 'Deposit - Automated - Successful', 'Deposit Completed Successfully', NULL, '<div>Your deposit of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>has been completed Successfully.<span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : {{amount}} {{site_currency}}</div><div>Charge:&nbsp;<font color=\"#000000\">{{charge}} {{site_currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div>Received : {{method_amount}} {{method_currency}}<br></div><div>Paid via :&nbsp; {{method_name}}</div><div><br></div><div>Transaction Number : {{trx}}</div><div><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}} {{site_currency}}</span></font></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div>', '{{amount}} {{site_currency}} Deposit successfully by {{method_name}}', NULL, '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, NULL, NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2022-04-03 02:25:43'),
(4, 'DEPOSIT_APPROVE', 'Deposit - Manual - Approved', 'Your Deposit is Approved', NULL, '<div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>is Approved .<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Received : {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}} {{site_currency}}</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div>', 'Admin Approve Your {{amount}} {{site_currency}} payment request by {{method_name}} transaction : {{trx}}', NULL, '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, NULL, NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2022-04-03 02:26:07'),
(5, 'DEPOSIT_REJECT', 'Deposit - Manual - Rejected', 'Your Deposit Request is Rejected', NULL, '<div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}} has been rejected</span>.<span style=\"font-weight: bolder;\"><br></span></div><div><br></div><div><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Received : {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge: {{charge}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number was : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">if you have any queries, feel free to contact us.<br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><br><br></div><span style=\"color: rgb(33, 37, 41); font-family: Montserrat, sans-serif;\">{{rejection_message}}</span><br>', 'Admin Rejected Your {{amount}} {{site_currency}} payment request by {{method_name}}\r\n\r\n{{rejection_message}}', NULL, '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"rejection_message\":\"Rejection message by the admin\"}', 1, NULL, NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2022-04-05 03:45:27'),
(6, 'DEPOSIT_REQUEST', 'Deposit - Manual - Requested', 'Deposit Request Submitted Successfully', NULL, '<div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : {{amount}} {{site_currency}}</div><div>Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div>Payable : {{method_amount}} {{method_currency}}<br></div><div>Pay via :&nbsp; {{method_name}}</div><div><br></div><div>Transaction Number : {{trx}}</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div>', '{{amount}} {{site_currency}} Deposit requested by {{method_name}}. Charge: {{charge}} . Trx: {{trx}}', NULL, '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\"}', 1, NULL, NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2022-04-03 02:29:19'),
(7, 'PASS_RESET_CODE', 'Password - Reset - Code', 'Password Reset', NULL, '<div style=\"font-family: Montserrat, sans-serif;\">We have received a request to reset the password for your account on&nbsp;<span style=\"font-weight: bolder;\">{{time}} .<br></span></div><div style=\"font-family: Montserrat, sans-serif;\">Requested From IP:&nbsp;<span style=\"font-weight: bolder;\">{{ip}}</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">{{browser}}</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">{{operating_system}}&nbsp;</span>.</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><div>Your account recovery code is:&nbsp;&nbsp;&nbsp;<font size=\"6\"><span style=\"font-weight: bolder;\">{{code}}</span></font></div><div><br></div></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><div><font size=\"4\" color=\"#CC0000\"><br></font></div>', 'Your account recovery code is: {{code}}', NULL, '{\"code\":\"Verification code for password reset\",\"ip\":\"IP address of the user\",\"browser\":\"Browser of the user\",\"operating_system\":\"Operating system of the user\",\"time\":\"Time of the request\"}', 1, NULL, NULL, 0, NULL, 0, '2021-11-03 12:00:00', '2022-03-20 20:47:05'),
(8, 'PASS_RESET_DONE', 'Password - Reset - Confirmation', 'You have reset your password', NULL, '<p style=\"font-family: Montserrat, sans-serif;\">You have successfully reset your password.</p><p style=\"font-family: Montserrat, sans-serif;\">You changed from&nbsp; IP:&nbsp;<span style=\"font-weight: bolder;\">{{ip}}</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">{{browser}}</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">{{operating_system}}&nbsp;</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">{{time}}</span></p><p style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></p><p style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><font color=\"#ff0000\">If you did not change that, please contact us as soon as possible.</font></span></p>', 'Your password has been changed successfully', NULL, '{\"ip\":\"IP address of the user\",\"browser\":\"Browser of the user\",\"operating_system\":\"Operating system of the user\",\"time\":\"Time of the request\"}', 1, NULL, NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2022-04-05 03:46:35'),
(9, 'ADMIN_SUPPORT_REPLY', 'Support - Reply', 'Reply Support Ticket', NULL, '<div><p><span data-mce-style=\"font-size: 11pt;\" style=\"font-size: 11pt;\"><span style=\"font-weight: bolder;\">A member from our support team has replied to the following ticket:</span></span></p><p><span style=\"font-weight: bolder;\"><span data-mce-style=\"font-size: 11pt;\" style=\"font-size: 11pt;\"><span style=\"font-weight: bolder;\"><br></span></span></span></p><p><span style=\"font-weight: bolder;\">[Ticket#{{ticket_id}}] {{ticket_subject}}<br><br>Click here to reply:&nbsp; {{link}}</span></p><p>----------------------------------------------</p><p>Here is the reply :<br></p><p>{{reply}}<br></p></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div>', 'Your Ticket#{{ticket_id}} :  {{ticket_subject}} has been replied.', NULL, '{\"ticket_id\":\"ID of the support ticket\",\"ticket_subject\":\"Subject  of the support ticket\",\"reply\":\"Reply made by the admin\",\"link\":\"URL to view the support ticket\"}', 1, NULL, NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2022-03-20 20:47:51'),
(10, 'EVER_CODE', 'Verification - Email', 'Please verify your email address', NULL, '<br><div><div style=\"font-family: Montserrat, sans-serif;\">Thanks For joining us.<br></div><div style=\"font-family: Montserrat, sans-serif;\">Please use the below code to verify your email address.<br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Your email verification code is:<font size=\"6\"><span style=\"font-weight: bolder;\">&nbsp;{{code}}</span></font></div></div>', '---', NULL, '{\"code\":\"Email verification code\"}', 1, NULL, NULL, 0, NULL, 0, '2021-11-03 12:00:00', '2022-04-03 02:32:07'),
(11, 'SVER_CODE', 'Verification - SMS', 'Verify Your Mobile Number', NULL, '---', 'Your phone verification code is: {{code}}', NULL, '{\"code\":\"SMS Verification Code\"}', 0, NULL, NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2022-03-20 19:24:37'),
(12, 'WITHDRAW_APPROVE', 'Withdraw - Approved', 'Withdraw Request has been Processed and your money is sent', NULL, '<div style=\"font-family: Montserrat, sans-serif;\">Your withdraw request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp; via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>has been Processed Successfully.<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your withdraw:<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">You will get: {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">-----</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\">Details of Processed Payment :</font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\"><span style=\"font-weight: bolder;\">{{admin_details}}</span></font></div>', 'Admin Approve Your {{amount}} {{site_currency}} withdraw request by {{method_name}}. Transaction {{trx}}', NULL, '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"admin_details\":\"Details provided by the admin\"}', 1, NULL, NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2022-03-20 20:50:16'),
(13, 'WITHDRAW_REJECT', 'Withdraw - Rejected', 'Withdraw Request has been Rejected and your money is refunded to your account', NULL, '<div style=\"font-family: Montserrat, sans-serif;\">Your withdraw request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp; via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>has been Rejected.<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your withdraw:<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">You should get: {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">----</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"3\"><br></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"3\">{{amount}}&nbsp;</font><span style=\"color: rgb(33, 37, 41); background-color: var(--bs-card-bg); font-size: 1rem; text-align: var(--bs-body-text-align);\">{{site_currency}}</span><span style=\"font-size: medium; color: var(--bs-card-color); background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align);\">&nbsp;has been&nbsp;</span><span style=\"font-size: medium; background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-weight: bolder;\">refunded&nbsp;</span><span style=\"font-size: medium; color: var(--bs-card-color); background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align);\">to your account and your current Balance is&nbsp;</span><span style=\"font-size: medium; background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-weight: bolder;\">{{post_balance}}</span><span style=\"font-size: medium; background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-weight: bolder;\">&nbsp;{{site_currency}}</span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">-----</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\">Details of Rejection :</font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\"><span style=\"font-weight: bolder;\">{{admin_details}}</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br><br><br><br><br></div><div></div><div></div>', 'Admin Rejected Your {{amount}} {{site_currency}} withdraw request. Your Main Balance {{post_balance}}  {{method_name}} , Transaction {{trx}}', NULL, '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after fter this action\",\"admin_details\":\"Rejection message by the admin\"}', 1, NULL, NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-07-08 07:06:31'),
(14, 'WITHDRAW_REQUEST', 'Withdraw - Requested', 'Withdraw Request Submitted Successfully', NULL, '<div style=\"font-family: Montserrat, sans-serif;\">Your withdraw request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp; via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>has been submitted Successfully.<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your withdraw:<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">You will get: {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}} {{site_currency}}</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br><br><br></div>', '{{amount}} {{site_currency}} withdraw requested by {{method_name}}. You will get {{method_amount}} {{method_currency}} Trx: {{trx}}', NULL, '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after fter this transaction\"}', 1, NULL, NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2022-03-21 04:39:03'),
(15, 'DEFAULT', 'Default Template', '{{subject}}', NULL, '{{message}}', '{{message}}', '{{message}}', '{\"subject\":\"Subject\",\"message\":\"Message\"}', 1, NULL, NULL, 1, NULL, 1, '2019-09-14 13:14:22', '2024-06-14 00:21:42'),
(16, 'KYC_APPROVE', 'KYC Approved', 'KYC has been approved', NULL, 'Congratulations! Your KYC data has been approved successfully.', NULL, NULL, '[]', 1, NULL, NULL, 1, NULL, 0, NULL, '2024-07-07 00:26:36'),
(17, 'KYC_REJECT', 'KYC Rejected', 'KYC has been rejected', NULL, '<br>', NULL, NULL, '{\"reason\":\"Rejection Reason\"}', 1, NULL, NULL, 1, NULL, 0, NULL, '2024-06-11 03:36:03'),
(18, 'SEND_MONEY_COMPLETE', 'Send- Money - Payment Confirmation', '[Payment Confirmation] Send Money Completed Successfully', NULL, '<div>This is a payment receipt for your send money from <i>{{sending_country}}</i> to <i>{{recipient__country}}</i>.</div>\r\n<div><br></div>\r\n<div>The payment has been completed Successfully</div>\r\n\r\n<div><br></div>\r\n\r\n<div>Sending Amount: {{sending_amount}} {{sending_currency}}</div>\r\n<div>Receiver Wil Get: {{recipient_amount}} {{recipient_currency}}</div>\r\n<div>Transaction Number: #{{trx}}</div>\r\n\r\n<div><br></div>\r\n<div>Note: This email will serve as an official receipt for this payment.</div>', '{{recipient_amount}} {{recipient_amount}} sent successfully to {{recipient__country}}.\r\nTransaction Number: #{{trx}}', NULL, '{\"trx\":\"Transaction number for the send money\",\"sending_country\":\"Country name of sender\",\"sending_amount\":\"Amount of sender\",\"sending_currency\":\"currency of the Sender country\",\"recipient__country\":\"Country name of receiver\",\"recipient_amount\":\"Amount will be recived\",\"recipient_currency\":\"Currency of the reciever country\"}', 1, NULL, NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2021-11-04 09:02:58'),
(19, 'SEND_MONEY_RECEIVED', 'Send - Money - Received', '[Payout Confirmation] The recipient has received the money you sent', NULL, '<div>This is a payment receipt for your send money to {{recipient_country}}.</div>\r\n<div><br></div>\r\n<div>The transaction has been completed Successfully.</div>\r\n\r\n<div><br></div>\r\n\r\n<div>Received Amount: {{recipient_amount}} {{recipient_currency}}</div><div>Trx: {{trx}}</div>\r\n\r\n<div><br></div>\r\n<div>Note: This email will serve as an official receipt for this payment.</div>', 'This is a payment receipt for your send money to {{recipient_country}}. {{recipient_amount}} {{recipient_currency}} payout successful for trx - {{trx}}.', NULL, '{\"recipient__country\":\"Country name of receiver\",\"recipient_amount\":\"Amount will be recived\",\"recipient_currency\":\"Currency of the reciever country\",\"trx\":\"Transaction id\"}', 1, NULL, NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2022-06-04 08:30:52'),
(20, 'SEND_MONEY_REFUND', 'Send- Money - Refund', 'Send Money Refunded', NULL, '<div>This is a payment receipt for your send money from <i>{{sending_country}}</i> to <font color=\"#212529\"><i>{{recipient_country}}</i></font>.</div>\r\n<div><br></div>\r\n<div>The payment has been refunded</div>\r\n\r\n<div><br></div>\r\n\r\n<div>Sending Amount: {{sending_amount}} {{sending_currency}}</div>\r\n<div>Receiver Wil Get: {{recipient_amount}} {{recipient_amount}}</div>\r\n<div>Transaction Number: #{{trx}}</div>\r\n<div><br></div>\r\n<div>Admin Message: {{message}}</div>\r\n<div><br></div>\r\n<div>Note: This email will serve as an official receipt for this payment.</div>', 'Send money for {{recipient_amount}} {{recipient_currency}}  to {{recipient_country}} is refunded due to {{message}}.\r\nTransaction Number: #{{trx}}', NULL, '{\"trx\":\"Transaction number for the send money\",\"sending_country\":\"Country name of sender\",\"sending_amount\":\"Amount of sender\",\"sending_currency\":\"currency of the Sender country\",\"recipient_country\":\"Country name of receiver\",\"recipient_amount\":\"Amount will be recived\",\"recipient_currency\":\"Currency of the reciever country\",\"message\":\"Admin message\"}', 1, NULL, NULL, 0, NULL, 0, '2021-11-03 12:00:00', '2024-07-08 06:56:03'),
(21, 'AGENT_ACCOUNT_CREATED', 'Agent - account - created', 'Agent account created successfully', NULL, '<div>Congratulations! Your account has been successfully created. Now you can use all the agent services we provide.</div><div><br></div><div>Use these credentials for your first login:</div><div><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">-&nbsp;</span><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">Username: {{username}}</span></div><div>- Password: {{password}}</div>\r\n<div><br></div><div>Please&nbsp;<a href=\"{{login_url}}\" title=\"Click this link\" target=\"_blank\">Click this link</a>&nbsp;to login and reset your password.</div><div><br></div><div>All the best.</div>', 'Congratulations! Your account has been successfully created. Now you can use all the agent services we provide. Use these credentials for your first login:\r\n- Username: {{username}}\r\n- Password: {{password}} \r\nPlease go {{login_url}} and reset your password. All the best.', NULL, '{\"username\": \"Username of created agent\",\"password\": \"Password of created agent\",\"login_link\": \"Agent login link\"}', 1, NULL, NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2022-06-04 05:07:43');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'template name',
  `secs` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `seo_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `slug`, `tempname`, `secs`, `seo_content`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'HOME', '/', 'templates.basic.', '[\"feature\",\"app\",\"service\",\"how_work\",\"transfer\",\"choose_us\",\"testimonial\",\"video\",\"counter\",\"how_to_receive\",\"faq\",\"blog\",\"brand\"]', NULL, 1, '2020-07-11 06:23:58', '2022-06-11 09:53:35'),
(4, 'Blog', 'blog', 'templates.basic.', NULL, NULL, 1, '2020-10-22 01:14:43', '2022-06-11 09:37:48'),
(5, 'Contact', 'contact', 'templates.basic.', '[\"faq\"]', NULL, 1, '2020-10-22 01:14:53', '2022-06-11 09:40:17'),
(19, 'About Us', 'about-us', 'templates.default.', '[\"about\",\"blog\",\"counter\"]', NULL, 0, '2022-04-23 10:32:21', '2022-04-23 10:32:21'),
(20, 'FAQ', 'faq', 'templates.default.', '[\"faq\",\"call_to_action\",\"blog\"]', NULL, 0, '2022-04-23 10:32:21', '2022-04-23 10:32:21'),
(22, 'About', 'about', 'templates.basic.', '[\"about\",\"how_to_receive\",\"blog\",\"brand\"]', NULL, 0, '2022-05-26 10:33:43', '2024-06-05 21:48:56');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recipients`
--

CREATE TABLE `recipients` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL DEFAULT '0',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sending_purposes`
--

CREATE TABLE `sending_purposes` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `send_money`
--

CREATE TABLE `send_money` (
  `id` int UNSIGNED NOT NULL,
  `mtcn_number` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_delivery_method_id` int UNSIGNED NOT NULL DEFAULT '0' COMMENT 'receiver country delivery method',
  `service_id` int UNSIGNED NOT NULL DEFAULT '0' COMMENT 'receiver country service',
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `agent_id` int UNSIGNED NOT NULL DEFAULT '0',
  `service_form_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'receiver country service form',
  `base_currency_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `base_currency_charge` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `sending_country_id` int UNSIGNED NOT NULL DEFAULT '0',
  `sending_currency` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sending_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `sending_charge` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `recipient_country_id` int UNSIGNED NOT NULL,
  `recipient_currency` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recipient_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `conversion_rate` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `base_currency_rate` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `sender` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `recipient` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `source_of_fund_id` int UNSIGNED NOT NULL DEFAULT '0',
  `sending_purpose_id` int UNSIGNED NOT NULL DEFAULT '0',
  `verification_code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verification_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payout_by` int UNSIGNED DEFAULT '0',
  `payment_status` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '0 = initiated; 1 = success; 2 = pending; 3 = rejected',
  `status` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '0 = initiated, 1 = completed, 2 = pending, 3 = refunded	',
  `admin_feedback` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `received_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint UNSIGNED NOT NULL,
  `country_delivery_method_id` int UNSIGNED NOT NULL DEFAULT '0',
  `form_id` int UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `source_of_funds`
--

CREATE TABLE `source_of_funds` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_attachments`
--

CREATE TABLE `support_attachments` (
  `id` bigint UNSIGNED NOT NULL,
  `support_message_id` int UNSIGNED NOT NULL DEFAULT '0',
  `attachment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_messages`
--

CREATE TABLE `support_messages` (
  `id` bigint UNSIGNED NOT NULL,
  `support_ticket_id` int UNSIGNED NOT NULL DEFAULT '0',
  `admin_id` int UNSIGNED NOT NULL DEFAULT '0',
  `message` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int DEFAULT '0',
  `agent_id` int UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ticket` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: Open, 1: Answered, 2: Replied, 3: Closed',
  `priority` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 = Low, 2 = medium, 3 = heigh',
  `last_reply` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `agent_id` int UNSIGNED NOT NULL DEFAULT '0',
  `amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `charge` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `post_balance` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `trx_type` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `update_logs`
--

CREATE TABLE `update_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `update_log` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `firstname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dial_code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_by` int UNSIGNED NOT NULL DEFAULT '0',
  `total_bonus_given` int UNSIGNED DEFAULT '0',
  `balance` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'contains full address',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0: banned, 1: active',
  `type` tinyint(1) DEFAULT '0',
  `business_profile_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kyc_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kyc_rejection_reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kv` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: KYC Unverified, 2: KYC pending, 1: KYC verified	',
  `ev` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: email unverified, 1: email verified',
  `sv` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: mobile unverified, 1: mobile verified',
  `profile_complete` tinyint(1) NOT NULL DEFAULT '0',
  `ver_code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'stores verification code',
  `ver_code_send_at` datetime DEFAULT NULL COMMENT 'verification send time',
  `ts` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: 2fa off, 1: 2fa on',
  `tv` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0: 2fa unverified, 1: 2fa verified',
  `tsc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ban_reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `per_send_money_limit` decimal(28,8) DEFAULT NULL,
  `daily_send_money_limit` decimal(28,8) DEFAULT NULL,
  `monthly_send_money_limit` decimal(28,8) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_logins`
--

CREATE TABLE `user_logins` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `agent_id` int UNSIGNED NOT NULL DEFAULT '0',
  `user_ip` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `os` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` bigint UNSIGNED NOT NULL,
  `method_id` int UNSIGNED NOT NULL DEFAULT '0',
  `agent_id` int UNSIGNED NOT NULL DEFAULT '0',
  `amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `currency` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `charge` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `trx` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `final_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `after_charge` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `withdraw_information` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=>success, 2=>pending, 3=>cancel,  ',
  `admin_feedback` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_methods`
--

CREATE TABLE `withdraw_methods` (
  `id` bigint UNSIGNED NOT NULL,
  `form_id` int UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_limit` decimal(28,8) DEFAULT '0.00000000',
  `max_limit` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `fixed_charge` decimal(28,8) DEFAULT '0.00000000',
  `rate` decimal(28,8) DEFAULT '0.00000000',
  `percent_charge` decimal(5,2) DEFAULT NULL,
  `currency` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`,`username`);

--
-- Indexes for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`,`email`);

--
-- Indexes for table `agent_password_resets`
--
ALTER TABLE `agent_password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country_delivery_method`
--
ALTER TABLE `country_delivery_method`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country_id` (`country_id`),
  ADD KEY `delivery_method_id` (`delivery_method_id`);

--
-- Indexes for table `cron_jobs`
--
ALTER TABLE `cron_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cron_job_logs`
--
ALTER TABLE `cron_job_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cron_schedules`
--
ALTER TABLE `cron_schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency_conversion_rates`
--
ALTER TABLE `currency_conversion_rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_charges`
--
ALTER TABLE `delivery_charges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_methods`
--
ALTER TABLE `delivery_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `device_tokens`
--
ALTER TABLE `device_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extensions`
--
ALTER TABLE `extensions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frontends`
--
ALTER TABLE `frontends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gateways`
--
ALTER TABLE `gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gateway_currencies`
--
ALTER TABLE `gateway_currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_logs`
--
ALTER TABLE `notification_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_templates`
--
ALTER TABLE `notification_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `recipients`
--
ALTER TABLE `recipients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sending_purposes`
--
ALTER TABLE `sending_purposes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `send_money`
--
ALTER TABLE `send_money`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sending_country_id` (`sending_country_id`),
  ADD KEY `recipient_country_id` (`recipient_country_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `source_of_funds`
--
ALTER TABLE `source_of_funds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_attachments`
--
ALTER TABLE `support_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_messages`
--
ALTER TABLE `support_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `update_logs`
--
ALTER TABLE `update_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`,`email`);

--
-- Indexes for table `user_logins`
--
ALTER TABLE `user_logins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraw_methods`
--
ALTER TABLE `withdraw_methods`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agent_password_resets`
--
ALTER TABLE `agent_password_resets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `country_delivery_method`
--
ALTER TABLE `country_delivery_method`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cron_jobs`
--
ALTER TABLE `cron_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cron_job_logs`
--
ALTER TABLE `cron_job_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cron_schedules`
--
ALTER TABLE `cron_schedules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `currency_conversion_rates`
--
ALTER TABLE `currency_conversion_rates`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_charges`
--
ALTER TABLE `delivery_charges`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_methods`
--
ALTER TABLE `delivery_methods`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `device_tokens`
--
ALTER TABLE `device_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `extensions`
--
ALTER TABLE `extensions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frontends`
--
ALTER TABLE `frontends`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `gateways`
--
ALTER TABLE `gateways`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `gateway_currencies`
--
ALTER TABLE `gateway_currencies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `notification_logs`
--
ALTER TABLE `notification_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_templates`
--
ALTER TABLE `notification_templates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recipients`
--
ALTER TABLE `recipients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sending_purposes`
--
ALTER TABLE `sending_purposes`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `send_money`
--
ALTER TABLE `send_money`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `source_of_funds`
--
ALTER TABLE `source_of_funds`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_attachments`
--
ALTER TABLE `support_attachments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_messages`
--
ALTER TABLE `support_messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `update_logs`
--
ALTER TABLE `update_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_logins`
--
ALTER TABLE `user_logins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdraw_methods`
--
ALTER TABLE `withdraw_methods`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


INSERT INTO `gateways` (`form_id`, `code`, `name`, `alias`, `image`, `status`, `gateway_parameters`, `supported_currencies`, `crypto`, `extra`, `description`, `created_at`, `updated_at`) VALUES
(0, 128, 'bKash', 'BKash', '67e1432683b5a1742816038.png', 1, '{\"username\":{\"title\":\"Username\",\"global\":true,\"value\":\"----------\"},\"password\":{\"title\":\"Password\",\"global\":true,\"value\":\"----------\"},\"app_key\":{\"title\":\"App Key\",\"global\":true,\"value\":\"----------\"},\"app_secret\":{\"title\":\"App Secret\",\"global\":true,\"value\":\"----------\"}}', '{\"BDT\":\"BDT\"}', 0, NULL, NULL, NULL, '2025-03-16 03:58:31');

ALTER TABLE `deposits` ADD `is_web` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'This will be 1 if the request is from NextJs application' AFTER `from_api`;

ALTER TABLE `deposits` CHANGE `admin_feedback` `admin_feedback` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

ALTER TABLE `general_settings` ADD `config_progress` TEXT NULL DEFAULT NULL AFTER `currency_format`;

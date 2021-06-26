-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 26, 2021 at 10:05 AM
-- Server version: 5.7.31
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clothes_factory`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank_checks`
--

DROP TABLE IF EXISTS `bank_checks`;
CREATE TABLE IF NOT EXISTS `bank_checks` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `bank_checkable_id` int(11) DEFAULT NULL,
  `bank_checkable_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_value` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `increase_value` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_owner` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payed_check` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `client_name`, `client_phone`, `created_at`, `updated_at`) VALUES
(1, 'محمد الرويني', '01092397823', '2020-09-03 15:30:09', '2020-09-03 15:30:09'),
(2, 'مصطفي بنون', '01149021507', '2020-09-03 15:30:50', '2020-09-03 15:30:50'),
(3, 'محمد ابراهيم دمنهور', '01069440944', '2020-09-03 15:31:09', '2020-09-03 15:31:09'),
(4, 'الشيخ ربيع', '01095126010', '2020-09-03 15:31:53', '2020-09-03 15:31:53'),
(5, 'رجب عامر', '01150655221', '2020-09-03 15:32:14', '2020-09-03 15:32:14'),
(6, 'شنوده', '01224955613', '2020-09-03 15:32:39', '2020-09-03 15:32:39'),
(7, 'محمد حمدي', '0102277152', '2020-09-03 15:33:31', '2020-09-03 15:33:31'),
(8, 'احمد الغنام', '01093191635', '2020-09-03 15:34:11', '2020-09-03 15:34:11'),
(9, 'محمود جمعه', '01151593611', '2020-09-03 15:35:20', '2020-09-03 15:35:20'),
(10, 'سنتر التوحيد', '01032776332', '2020-09-03 15:36:24', '2020-09-03 15:36:24'),
(11, 'السيد ابو السعود', '01157611568', '2020-09-03 15:38:08', '2020-09-03 15:38:08'),
(12, 'ماجد ناصر', '01069881716', '2020-09-03 15:39:26', '2020-09-03 15:39:26'),
(13, 'حمدي عاشور', '01112966755', '2020-09-03 15:40:27', '2020-09-03 15:40:27'),
(14, 'عمر أفندي محمد يونس', '01224955613', '2020-09-03 15:41:46', '2020-09-03 15:41:46'),
(15, 'ابو عيسي', '01100315777', '2020-09-03 15:42:53', '2020-09-03 15:42:53'),
(16, 'محمد حجازي', '01069440944', '2020-09-07 03:52:38', '2020-09-07 03:52:38'),
(17, 'م', '01224955613', '2020-09-07 14:31:35', '2020-09-07 14:31:35'),
(20, 'الحاج عيد', '01000532186', '2020-09-07 20:16:25', '2020-09-07 20:16:25'),
(19, 'الحاج نصر الجمال', '01000951564', '2020-09-07 15:29:17', '2020-09-07 15:29:17'),
(21, 'محمد الشولحي', '01113482405', '2020-10-11 17:51:55', '2020-10-11 17:51:55'),
(22, 'وليد عبده', '01069440944', '2020-10-17 04:43:22', '2020-10-17 04:43:22'),
(23, 'صبحي غازي', '01069440944', '2020-10-24 01:46:43', '2020-10-24 01:46:43'),
(24, 'احمد سعيد', '01069440944', '2020-11-07 04:12:16', '2020-11-07 04:12:16'),
(25, 'احمد جابر', '01069440944', '2021-03-05 16:42:31', '2021-03-05 16:42:31'),
(26, 'سلامه شومان', '01069440944', '2021-03-05 16:52:33', '2021-03-05 16:52:33'),
(27, 'محمود مسوده', '01069440944', '2021-03-05 16:56:58', '2021-03-05 16:56:58'),
(28, 'الشيخ علي', '01069440944', '2021-05-01 19:32:15', '2021-05-01 19:32:15'),
(29, 'احمد سعيد', '01069440944', '2021-05-01 20:40:12', '2021-05-01 20:40:12'),
(30, 'حجازي', '01069440944', '2021-05-01 21:09:51', '2021-05-01 21:09:51'),
(31, 'محمد الزهيري', '01069440944', '2021-05-01 22:38:07', '2021-05-01 22:38:07'),
(32, 'ابراهيم منوف', '01069440944', '2021-05-02 18:06:43', '2021-05-02 18:06:43'),
(33, 'السيد الصعيدي', '01069440944', '2021-05-02 19:59:51', '2021-05-02 19:59:51'),
(34, 'جنيدي', '01069440944', '2021-05-15 17:38:09', '2021-05-15 17:38:09');

-- --------------------------------------------------------

--
-- Table structure for table `client_payments`
--

DROP TABLE IF EXISTS `client_payments`;
CREATE TABLE IF NOT EXISTS `client_payments` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `client_payments_client_id_foreign` (`client_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cloth_styles`
--

DROP TABLE IF EXISTS `cloth_styles`;
CREATE TABLE IF NOT EXISTS `cloth_styles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_piecies` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_clothes_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `count_piecies` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_piecies` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `additional_taxs` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_price` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cloth_styles_order_clothes_id_foreign` (`order_clothes_id`),
  KEY `cloth_styles_supplier_id_foreign` (`supplier_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `debits`
--

DROP TABLE IF EXISTS `debits`;
CREATE TABLE IF NOT EXISTS `debits` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `debitable_id` int(11) DEFAULT NULL,
  `debitable_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit_value` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_payment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit_paid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `order_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expances`
--

DROP TABLE IF EXISTS `expances`;
CREATE TABLE IF NOT EXISTS `expances` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `expances_value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expances_description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `merchants`
--

DROP TABLE IF EXISTS `merchants`;
CREATE TABLE IF NOT EXISTS `merchants` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `merchant_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merchant_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `merchants`
--

INSERT INTO `merchants` (`id`, `merchant_name`, `merchant_phone`, `created_at`, `updated_at`) VALUES
(1, 'كمال عبدالله', '01069440944', '2020-09-07 04:36:51', '2020-09-07 04:36:51'),
(2, 'اسامه جرجس', '01069440944', '2020-09-07 04:37:06', '2020-09-07 04:37:06'),
(3, 'الدهشوري', '01069440944', '2020-09-07 04:37:19', '2020-09-07 04:37:19'),
(4, 'الجاسر', '01069440944', '2020-09-07 04:37:33', '2020-09-07 04:37:33');

-- --------------------------------------------------------

--
-- Table structure for table `merchant_payments`
--

DROP TABLE IF EXISTS `merchant_payments`;
CREATE TABLE IF NOT EXISTS `merchant_payments` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `merchant_id` int(11) DEFAULT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `merchant_payments_merchant_id_foreign` (`merchant_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(23, '2014_10_12_000000_create_users_table', 1),
(24, '2014_10_12_100000_create_password_resets_table', 1),
(25, '2019_08_19_000000_create_failed_jobs_table', 1),
(26, '2020_07_03_035452_create_merchants_table', 1),
(27, '2020_07_03_040604_create_order_clothes_table', 1),
(28, '2020_07_03_042316_create_categories_table', 1),
(29, '2020_07_03_044328_create_bank_checks_table', 1),
(30, '2020_07_07_053109_create_clients_table', 1),
(31, '2020_07_07_062104_create_cloth_styles_table', 1),
(32, '2020_07_12_031717_create_products_table', 1),
(33, '2020_07_14_053140_create_orders_table', 1),
(34, '2020_07_14_190114_create_partners_table', 1),
(35, '2020_07_17_000202_create_reactionists_table', 1),
(36, '2020_07_17_065737_create_withdraws_table', 1),
(37, '2020_08_12_132902_create_suppliers_table', 1),
(38, '2020_08_14_033046_create_debits_table', 1),
(39, '2020_08_16_031434_create_expances_table', 1),
(40, '2021_06_07_140129_create_merchant_payments_table', 1),
(41, '2021_06_10_101737_create_client_payments_table', 1),
(42, '2021_06_16_140811_create_supplier_payments_table', 1),
(43, '2021_06_19_153635_create_profits_table', 1),
(44, '2021_06_19_204153_create_settings_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `invoice_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `order_discount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_taxs` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_price` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_count` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `final_cost` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_follow` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_client_id_foreign` (`client_id`),
  KEY `orders_product_id_foreign` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_clothes`
--

DROP TABLE IF EXISTS `order_clothes`;
CREATE TABLE IF NOT EXISTS `order_clothes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `merchant_id` int(10) UNSIGNED NOT NULL,
  `invoice_no` int(11) DEFAULT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `order_size` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_size_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_price` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_discount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_one_piecies` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_finished` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_follow` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_clothes_merchant_id_foreign` (`merchant_id`),
  KEY `order_clothes_category_id_foreign` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

DROP TABLE IF EXISTS `partners`;
CREATE TABLE IF NOT EXISTS `partners` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `partner_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `partner_phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capital` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `partner_percent` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `partner_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `partner_ended_at` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_product` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cloth_styles_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `count_piecies` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_piecies` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `additional_taxs` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `full_price` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_cloth_styles_id_foreign` (`cloth_styles_id`),
  KEY `products_category_id_foreign` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profits`
--

DROP TABLE IF EXISTS `profits`;
CREATE TABLE IF NOT EXISTS `profits` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `partner_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `profits_partner_id_foreign` (`partner_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reactionists`
--

DROP TABLE IF EXISTS `reactionists`;
CREATE TABLE IF NOT EXISTS `reactionists` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `one_item_price` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'نقدى',
  `order_count` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profit_order` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `final_cost` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reactionists_order_id_foreign` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `setting` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting`, `value`, `created_at`, `updated_at`) VALUES
(1, 'Capital', '0', '2021-06-26 07:56:19', '2021-06-26 07:56:19'),
(2, 'Fiscal_Year', '2021-06-26 09:56:19', '2021-06-26 07:56:19', '2021-06-26 07:56:19');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_name`, `supplier_phone`, `created_at`, `updated_at`) VALUES
(1, 'محمد فايز', '01069440944', '2020-09-07 14:34:58', '2020-09-07 14:34:58');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_payments`
--

DROP TABLE IF EXISTS `supplier_payments`;
CREATE TABLE IF NOT EXISTS `supplier_payments` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) DEFAULT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `supplier_payments_supplier_id_foreign` (`supplier_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `id`) VALUES
('mohamedreda', 'develomohamed22@gmail.com', NULL, '$2y$10$OHQaGVKEI9LysUaOdwbcPeXWt00VcGY2HdCqI7.OC/rf06SZ0/YL2', NULL, NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `withdraws`
--

DROP TABLE IF EXISTS `withdraws`;
CREATE TABLE IF NOT EXISTS `withdraws` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `partner_id` int(11) NOT NULL DEFAULT '0',
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 => profits , 1 => Capital',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `withdraws_partner_id_foreign` (`partner_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 01, 2024 at 03:44 PM
-- Server version: 8.0.27
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gl_v2`
--

-- --------------------------------------------------------

--
-- Table structure for table `transaction_types`
--

DROP TABLE IF EXISTS `transaction_types`;
CREATE TABLE IF NOT EXISTS `transaction_types` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `deleted` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction_types`
--

INSERT INTO `transaction_types` (`id`, `uuid`, `name`, `currency`, `is_active`, `deleted`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, '45338eeb-5f67-43c6-bd68-1184ed683750', 'Standard Selling', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(2, '97e58729-057c-443a-bc61-0191ab1a7e20', 'Standard Selling USD', 'USD', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(3, '15424022-41b0-4afc-8632-209a4c84ced8', 'Distributor Selling', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(4, 'fa011741-dca5-4716-965e-be7ebfc6ea55', 'Unopreneur\'s Selling', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(5, 'b44c2f07-e4e0-4aef-811d-397fea79ce72', 'UBC\'s Selling', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(6, '15424022-41b0-4afc-8632-209a4c84ced8', 'Distributor Price', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(7, '6c0783bf-314b-4e61-965d-4bde48febd0e', 'UBC Price', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(8, '75194f91-9b28-4291-a047-1aa99bea62ad', 'UPC Price', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(9, 'fc02f0ac-af73-4b6c-8dd9-eca60fc47b85', 'UNOSHOP SRP PRICE', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(10, 'e17e731a-386a-4be0-a54c-b9c311732fae', 'SHOPEE DISTRIBUTOR PRICE', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(11, '2a5cdf1b-e59f-46d1-b3e3-8ef4685ffac5', 'LAZMALL DISTRIBUTOR PRICE', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(12, '601ff159-3829-43c3-8310-004d3ee05832', 'ESTORE SRP PRICE', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(13, '684d2007-e628-46eb-a507-56eafa24448b', 'ESTORE DISTRIBUTOR PRICE', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(14, 'd2bc648f-d647-4b02-9c0a-e200b05faf18', 'CREDIT CARD DISTRIBUTOR PRICE', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(15, '4e09afb6-994b-4de5-9fe1-f117c5367356', 'CREDIT CARD UPC PRICE', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(16, '560dab5e-3873-4eab-8dc7-5a82544663db', 'UNO BILIS SERBISYO DISTRIBUTOR PRICE', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(17, '0fdc60a2-c5eb-42a5-ba6c-e027b4bbe0ee', 'UNO BILIS SERBISYO UPC PRICE', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(18, '134de7f2-f814-4593-a68c-25f23b3be18b', 'ONELIFESTYLE DISTRIBUTOR PRICE', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(19, 'd4613e15-9f82-4778-8a6d-6eb1ff9166ea', 'ONELIFESTYLE UPC PRICE', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(20, '9dd646af-6c1e-494e-be7b-5eeaab4e2972', 'BUY 1 TAKE 1 PROMO', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(21, '55b7e802-e62f-42c3-83e1-b328c3c18575', 'PROMO FREE REGULAR PACKAGE', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(22, 'c6fff408-9a74-432c-be88-05ba039d28e9', 'PROMO FREE REGULAR RS', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(23, 'afb12a26-de1a-4173-bef9-5f9ffb21e66c', 'PROMO FREE NEW UPC', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(24, '5959d869-8d03-4fb5-b2cf-fb2e7bad99be', 'PROMO FREE NEW RS', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(25, 'f978cf7d-5fbf-4e51-8a67-362a0ebb6da8', 'PROMO FREE SIGN UBC PACKAGE', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(26, '4d1c67b7-68e7-419f-beea-d0a10abb330b', 'PROMO FREE SIGN UBC RS', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(27, '6dd5b1c0-4161-4ea5-bf67-49ec538caea5', 'DISTRIBUTOR PRICE USD', 'USD', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(28, '80202276-760e-4d15-9c2a-4667ab734f23', 'UPC PRICE USD', 'USD', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(29, 'a51a05e4-7af7-4997-afbc-4a002b87da17', 'SRP', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(30, 'e75adb84-1ff1-49fe-961e-ec374411e24a', 'SRP USD', 'USD', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(31, 'ecc5bd77-f381-4f5a-bf3f-686654e40b0e', 'PRODUCT PACK', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(32, 'cccd4e2e-0ff2-4ec7-aba6-ea36ee325b50', 'PRODUCT PACK ONLINE', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(33, '7e1faa43-0ba7-4fad-abd6-8446e8a116de', 'UNO BILIS SERBISYO PRODUCT PACK', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(34, '1ee43839-2cea-44c9-b35f-c152c14df16d', 'UBC PRODUCT PACK', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(35, 'e3fa7ebe-8e39-4abb-a3da-b8dc94ec1379', 'UNO PREMIER PLUS PRODUCT PACK USD', 'USD', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(36, 'e4661cc5-cb03-4d15-ba64-8a31917b6051', 'UNO PREMIER PLUS PRODUCT PACK USD (OTHER FLAGS)', 'USD', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(37, 'baa8747d-711c-4287-ac05-55795d2cba53', 'UNO PREMIER PLUS PRODUCT PACK PHP', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(38, '2d36ba5d-2a5b-43ba-8cd3-e1b6aeb13f61', 'UNO PREMIER PLUS PRODUCT PACK FOR HK', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(39, 'f68b5b89-0461-4154-ad0f-b02ac60a2ae1', 'UNO CAFE SRP', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(40, 'ccd8ffbc-b478-444f-b1b1-c94ef442ae37', 'UNO CAFE DISTRIBUTOR RS', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(41, '314652ff-20fb-4c72-b6d6-10f7eccb7805', 'UNO CAFE E-STORE', 'PHP', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(42, '4dcd30ae-993a-4478-b860-2a3cdee950c7', 'UNO CAFE SRP USD', 'USD', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL),
(43, '5f2ac006-af3a-47d2-b839-05aac841d060', 'UNO CAFE DISTRIBUTOR RS USD', 'USD', 1, 0, '2023-12-29 05:26:43', '2023-12-29 05:26:43', NULL, 'System', 'System', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

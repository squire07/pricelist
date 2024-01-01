-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 01, 2024 at 03:47 PM
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
-- Table structure for table `income_expense_accounts`
--

DROP TABLE IF EXISTS `income_expense_accounts`;
CREATE TABLE IF NOT EXISTS `income_expense_accounts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_type_id` int NOT NULL,
  `company_id` int DEFAULT NULL,
  `currency` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `income_account` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expense_account` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `income_expense_accounts`
--

INSERT INTO `income_expense_accounts` (`id`, `uuid`, `transaction_type_id`, `company_id`, `currency`, `income_account`, `expense_account`, `deleted`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, '7f906ea4-f55c-4fc7-b2bc-ad7672bea6c2', 1, 3, 'PHP', '4010101 - Sales - UBC Product Pack - UNO', '5010102 - COGS-UBC Product Pack - UNO', 0, '2023-12-05 04:29:45', '2023-12-05 04:29:45', NULL, 'Test User', 'Test User', NULL),
(2, 'aac52109-886b-44a2-b7f6-3271b1809797', 4, 2, 'PHP', '4010215 - Sales - UBS Preneur - PREMIER', '5010216 - COGS-UBS Preneur - PREMIER', 0, '2023-11-24 08:20:38', '2023-11-24 08:20:38', NULL, 'Roxanne Santiago', 'Roxanne Santiago', NULL),
(3, '7e77a8f6-95f4-424b-a373-d73479f6cd94', 4, 3, 'PHP', '4010215 - Sales - UBS Preneur - UNO', '5010216 - COGS-UBS Preneur - UNO', 0, '2023-11-24 08:21:33', '2023-11-24 08:21:33', NULL, 'Roxanne Santiago', 'Roxanne Santiago', NULL),
(4, '76f00bba-7d42-4942-813b-630173d72076', 3, 2, 'PHP', '4010277 - Sales - UNO Premier Repeat Sales PHP - PREMIER', '5010218 - COGS-UNO Premier Repeat Sales - PREMIER', 0, '2023-11-10 09:46:43', '2023-11-24 08:13:13', NULL, 'Test User', 'Test User', NULL),
(5, 'f5c80647-3477-463f-8022-5f62861310f9', 3, 2, 'USD', '4010278 - Sales - UNO Premier Repeat Sales USD - PREMIER', '5010218 - COGS-UNO Premier Repeat Sales - PREMIER', 0, '2023-11-10 09:47:13', '2023-11-24 08:02:38', NULL, 'Test User', 'Test User', NULL),
(6, 'a81d63c2-fcb0-45b2-a781-42e0c4cafe10', 3, 2, 'NGN', '4010281 - Sales - UNO Premier Repeat Sales NGN - PREMIER', '5010218 - COGS-UNO Premier Repeat Sales - PREMIER', 0, '2023-11-24 08:12:15', '2023-11-24 08:12:15', NULL, 'Roxanne Santiago', 'Roxanne Santiago', NULL),
(7, '33bbfec6-0852-4977-b773-3982beecce23', 3, 2, 'BHD', '4010279 - Sales - UNO Premier Repeat Sales BHD - PREMIER', '5010218 - COGS-UNO Premier Repeat Sales - PREMIER', 0, '2023-11-24 08:14:05', '2023-11-24 08:14:05', NULL, 'Roxanne Santiago', 'Roxanne Santiago', NULL),
(8, 'd6f67b24-de1e-48ee-b935-6d4a546f5bad', 3, 3, 'PHP', '4010241 - Sales - Distributors PHP - LOCAL', '5010205 - COGS-Distributors - UNO', 0, '2023-11-24 08:17:48', '2023-11-24 08:17:48', NULL, 'Roxanne Santiago', 'Roxanne Santiago', NULL),
(9, '754f51f6-bd3c-4963-9e9a-afb671708055', 7, 3, 'PHP', '4010212 - Sales - UBC Repeat Sales - UNO', '5010213 - COGS-UBC Repeat Sales - UNO', 0, '2023-11-29 06:03:32', '2023-11-29 06:03:32', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(10, '31e86547-de92-4127-b2db-90926bf9ef37', 8, 3, 'PHP', '4010315 - Sales - UPC RS PHP - LOCAL', '5010233 - COGS-UPC RS - UNO', 0, '2023-11-24 07:30:03', '2023-11-24 07:30:03', NULL, 'Test User', 'Test User', NULL),
(11, 'e7086102-4989-4e6b-a6c6-ca1c89679bb5', 8, 2, 'PHP', '4010315 - Sales - UPC RS PHP - PREMIER', '5010233 - COGS-UPC RS - PREMIER', 0, '2023-11-29 06:12:52', '2023-11-29 06:12:52', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(12, '115e44c6-1402-41fc-a8aa-8c967e0daf5e', 8, 2, 'USD', '4010316 - Sales - UPC RS USD - PREMIER', '5010233 - COGS-UPC RS - PREMIER', 0, '2023-11-29 06:14:26', '2023-11-29 06:14:26', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(13, 'b3573bca-4947-40be-82b5-f7e42c7d4ada', 8, 2, 'NGN', '4010319 - Sales - UPC RS NGN - PREMIER', '5010233 - COGS-UPC RS - PREMIER', 0, '2023-11-29 06:15:27', '2023-11-29 06:15:27', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(14, 'da3a8a56-2ba4-4cc2-8089-fd5cf323c594', 8, 2, 'BHD', '4010317 - Sales - UPC RS BHD - PREMIER', '5010233 - COGS-UPC RS - PREMIER', 0, '2023-11-29 06:17:53', '2023-11-29 06:17:53', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(15, '3d22fb0b-cca8-479b-995f-40ea74d03fe2', 9, 2, 'PHP', '4010303 - Sales - UNOSHOP PHP - PREMIER', '5010231 - COGS-UNOSHOPPH - PREMIER', 0, '2023-11-29 06:28:31', '2023-11-29 06:28:31', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(16, 'cbe8798d-d155-491e-816b-4c891dffdf40', 9, 3, 'PHP', '4010303 - Sales - UNOSHOP PHP - LOCAL', '5010231 - COGS-UNOSHOPPH - UNO', 0, '2023-11-29 06:30:44', '2023-11-29 06:30:44', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(17, '1cfe5ae4-6a26-4129-9b73-6a0962ba9176', 10, 2, 'PHP', '4010277 - Sales - Distributors PHP - PREMIER', '5010218 - COGS-Distributors - PREMIER', 0, '2023-11-30 05:53:22', '2023-12-21 07:15:20', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(18, '75fbc0ec-ff1b-4bb5-b415-102d06f2d9f0', 11, 2, 'PHP', '4010277 - Sales - Distributors PHP - PREMIER', '5010218 - COGS-Distributors - PREMIER', 0, '2023-11-30 05:56:27', '2023-12-21 07:15:38', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(19, '3c17e330-7cdd-495f-9955-8068c6397f2e', 12, 2, 'PHP', '4010251 - Sales - E Store PHP - PREMIER', '5010206 - COGS-E Store - PREMIER', 0, '2023-11-29 06:47:09', '2023-11-29 06:47:09', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(20, '74ea626f-cd43-4255-8d68-c52219e7a9a0', 12, 3, 'PHP', '4010251 - Sales - E Store PHP - LOCAL', '5010206 - COGS-E Store - UNO', 0, '2023-11-29 06:53:52', '2023-11-29 06:53:52', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(21, '8d417fe9-b544-4975-a0b2-cbee4d52c4c3', 13, 3, 'PHP', '4010251 - Sales - E Store PHP - LOCAL', '5010206 - COGS-E Store - UNO', 0, '2023-11-29 09:24:55', '2023-11-29 09:24:55', NULL, 'Test User', 'Test User', NULL),
(22, '512faa90-b058-4a4d-9a89-efea665ac3d7', 13, 2, 'PHP', '4010251 - Sales - E Store PHP - PREMIER', '5010206 - COGS-E Store - PREMIER', 0, '2023-11-29 09:38:37', '2023-11-29 09:38:37', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(23, '062bba61-c263-4930-8b92-d4f989e542af', 14, 3, 'PHP', '4010203 - Sales - Credit Card - UNO', '5010204 - COGS-Credit Card - UNO', 0, '2023-11-29 07:23:45', '2023-11-29 07:23:45', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(24, '8ffe5a1c-b89e-483d-af60-783279551c30', 14, 2, 'PHP', '4010203 - Sales - Credit Card - PREMIER', '5010204 - COGS-Credit Card - PREMIER', 0, '2023-11-29 07:25:36', '2023-11-29 07:25:36', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(25, '55ecdb3f-d681-4103-bd0b-9dc3d0dd72be', 15, 2, 'PHP', '4010203 - Sales - Credit Card - PREMIER', '5010204 - COGS-Credit Card - PREMIER', 0, '2023-11-29 09:41:05', '2023-11-29 09:41:05', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(26, 'b685b378-1e10-423d-b159-98f8b59cdae2', 15, 3, 'PHP', '4010203 - Sales - Credit Card - UNO', '5010204 - COGS-Credit Card - UNO', 0, '2023-11-29 09:42:03', '2023-11-29 09:42:03', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(27, '827cc3bb-9799-476b-be03-d456209c9464', 16, 3, 'PHP', '4010216 - Sales - UBS Repeat Sales - UNO', '5010217 - COGS-UBS Repeat Sales - UNO', 0, '2023-11-29 07:33:26', '2023-11-29 07:33:26', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(28, 'd9f2687b-51e9-438f-aa50-58ce6af3ef96', 16, 2, 'PHP', '4010216 - Sales - UBS Repeat Sales - PREMIER', '5010217 - COGS-UBS Repeat Sales - PREMIER', 0, '2023-11-29 07:36:50', '2023-11-29 07:36:50', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(29, '3acb94d2-792c-42fd-89d4-1b5e8f0ff0b8', 17, 3, 'PHP', '4010215 - Sales - UBS Preneur - UNO', '5010216 - COGS-UBS Preneur - UNO', 0, '2023-11-30 00:58:38', '2023-11-30 00:58:38', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(30, '6bc5e7d8-c2bf-4a1b-a765-18fd5684f370', 17, 2, 'PHP', '4010215 - Sales - UBS Preneur - PREMIER', '5010216 - COGS-UBS Preneur - PREMIER', 0, '2023-11-30 00:59:47', '2023-11-30 00:59:47', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(31, 'fc2acf17-d36b-4e84-ac4e-d30585e00c7c', 18, 2, 'PHP', '4010241 - Sales - Distributors PHP - PREMIER', '5010205 - COGS-Distributors - PREMIER', 0, '2023-11-30 05:58:15', '2023-11-30 05:58:15', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(32, '46501d1f-5cf1-478c-9c23-7826ed8e8880', 18, 3, 'PHP', '4010241 - Sales - Distributors PHP - LOCAL', '5010205 - COGS-Distributors - UNO', 0, '2023-11-30 06:00:08', '2023-11-30 06:00:08', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(33, '01ddd686-22f8-4203-984b-f40576e59115', 19, 3, 'PHP', '4010315 - Sales - UPC RS PHP - LOCAL', '5010233 - COGS-UPC RS - UNO', 0, '2023-11-30 06:02:40', '2023-11-30 06:02:40', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(34, '1951fb33-d310-4d5f-a907-883e7e27cb06', 19, 2, 'PHP', '4010315 - Sales - UPC RS PHP - PREMIER', '5010233 - COGS-UPC RS - PREMIER', 0, '2023-11-30 06:04:16', '2023-11-30 06:04:16', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(35, '2f18d0de-24d5-461d-95aa-cb40313b32c3', 20, 3, 'PHP', '4010291 - Sales - B1T1 PHP - LOCAL', '5010220 - COGS-B1T1 - UNO', 0, '2023-11-29 09:01:08', '2023-12-21 09:08:05', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(36, '1692651d-0e3c-4b4f-b3bf-65c070003388', 20, 2, 'PHP', '4010219 - Sales - B1T1 - PREMIER', '5010220 - COGS-B1T1 - PREMIER', 0, '2023-11-29 09:02:12', '2023-11-29 09:02:12', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(37, '74dffb51-2962-4419-8b4c-2ec6d3653ae3', 21, 3, 'PHP', '4010297 - Sales - Promo RS/PP Free PHP - LOCAL', '5010227 - COGS-Promo RS/PP Free - UNO', 0, '2023-11-29 09:46:10', '2023-11-29 09:46:10', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(38, '5058d9ca-84b9-49ad-ba11-03efac2a9393', 21, 2, 'PHP', '4010297 - Sales - Promo RS/PP Free PHP - PREMIER', '5010227 - COGS-Promo RS/PP Free - PREMIER', 0, '2023-11-29 09:47:45', '2023-11-29 09:47:45', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(39, '21e19599-be50-43bd-86d5-cc8530a627bf', 22, 2, 'PHP', '4010297 - Sales - Promo RS/PP Free PHP - PREMIER', '5010227 - COGS-Promo RS/PP Free - PREMIER', 0, '2023-11-29 09:49:24', '2023-11-29 09:49:24', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(40, '84f4684a-2e28-4c85-93cc-7fd9c5a2a624', 22, 3, 'PHP', '4010297 - Sales - Promo RS/PP Free PHP - LOCAL', '5010227 - COGS-Promo RS/PP Free - UNO', 0, '2023-11-29 09:51:20', '2023-11-29 09:51:20', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(41, '80e5c4cf-e5c4-40c3-af88-60afd520cd87', 23, 3, 'PHP', '4010229 - Sales - Promo UPC RS Free - UNO', '5010229 - COGS-Promo UPC RS Free - UNO', 0, '2023-11-29 09:55:57', '2023-11-29 09:55:57', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(42, '5d14c5b2-0ce9-49d8-9eba-572f814199be', 23, 2, 'PHP', '4010229 - Sales - Promo UPC RS Free - PREMIER', '5010229 - COGS-Promo UPC RS Free - PREMIER', 0, '2023-11-29 09:57:10', '2023-11-29 09:57:10', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(43, '2e74e0f5-55f6-49bc-9184-ce39744f232e', 24, 2, 'PHP', '4010229 - Sales - Promo UPC RS Free - PREMIER', '5010229 - COGS-Promo UPC RS Free - PREMIER', 0, '2023-11-29 10:02:17', '2023-11-29 10:02:17', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(44, '750d8848-866a-428a-aee4-37bf3627742c', 24, 3, 'PHP', '4010229 - Sales - Promo UPC RS Free - UNO', '5010229 - COGS-Promo UPC RS Free - UNO', 0, '2023-11-29 10:03:20', '2023-11-29 10:03:20', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(45, '1a2cbb70-c611-4e3c-9ad9-ae52cbc35921', 25, 3, 'PHP', '4010228 - Sales - Promo UBC RS/PP Free - UNO', '5010228 - COGS-Promo UBC RS/PP Free - UNO', 0, '2023-11-29 10:04:36', '2023-11-29 10:04:36', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(46, '79a99538-c98c-4657-8758-b9f042a97426', 25, 2, 'PHP', '4010228 - Sales - Promo UBC RS/PP Free - PREMIER', '5010228 - COGS-Promo UBC RS/PP Free - PREMIER', 0, '2023-11-29 10:06:46', '2023-11-29 10:06:46', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(47, '6225c58e-ab9c-4e8f-9733-c580029647cf', 26, 2, 'PHP', '4010228 - Sales - Promo UBC RS/PP Free - PREMIER', '5010228 - COGS-Promo UBC RS/PP Free - PREMIER', 0, '2023-11-29 10:08:07', '2023-11-29 10:08:07', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(48, 'b7bc5408-3149-4cbb-9529-a59033cfc531', 26, 3, 'PHP', '4010228 - Sales - Promo UBC RS/PP Free - UNO', '5010228 - COGS-Promo UBC RS/PP Free - UNO', 0, '2023-11-29 10:08:54', '2023-11-29 10:08:54', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(49, 'b54fafe4-ba40-49f9-808f-825a06b7316a', 27, 2, 'USD', '4010278 - Sales - UNO Premier Repeat Sales USD - PREMIER', '5010218 - COGS-UNO Premier Repeat Sales - PREMIER', 0, '2023-11-30 01:42:26', '2023-11-30 01:42:26', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(50, 'd3cc7c2c-1198-4711-903a-550ad9a50e1f', 28, 2, 'USD', '4010316 - Sales - UPC RS USD - PREMIER', '5010233 - COGS-UPC RS - PREMIER', 0, '2023-11-30 01:47:28', '2023-11-30 01:47:28', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(51, 'e7386645-9b40-45d0-9132-afc2f5acee39', 29, 3, 'PHP', '4010271 - Sales - SRP PHP - LOCAL', '5010208 - COGS-SRP - UNO', 0, '2023-12-05 03:57:36', '2023-12-21 07:29:39', NULL, 'Test User', 'Test User', NULL),
(52, 'cf170e39-7e60-4538-bf66-d5ce536eb83d', 29, 2, 'PHP', '4010271 - Sales - SRP PHP - PREMIER', '5010208 - COGS-SRP - PREMIER', 0, '2023-12-21 07:31:33', '2023-12-21 07:31:33', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(53, '6ce07431-7e32-425f-a95b-1632e4d36a9f', 30, 2, 'USD', '4010272 - Sales - SRP USD - PREMIER', '5010208 - COGS-SRP - PREMIER', 0, '2023-11-10 07:45:31', '2023-12-21 07:34:44', NULL, 'Test User', 'Test User', NULL),
(54, '6ce07431-7e32-425f-a95b-1632e4d36a9f', 31, 3, 'PHP', '4010100 - Sales - Product Pack - UNO', '5010101 - COGS-Product Pack - UNO', 0, '2023-11-10 07:45:56', '2023-12-21 08:34:50', NULL, 'Test User', 'Test User', NULL),
(55, '61eed138-1f1d-4676-8b7c-07fff4227f99', 32, 3, 'PHP', '4010151 - Sales - Product Pack Online PHP - LOCAL', '5010106 - COGS-Product Pack Online - UNO', 0, '2023-11-11 09:26:56', '2023-12-21 08:38:24', NULL, 'Test User', 'Test User', NULL),
(56, 'f449ffa9-0451-45ed-ad2b-26b2baafd72b', 33, 3, 'PHP', '4010102 - Sales - UNO Bilis Serbisyo - LOCAL', '5010103 - COGS-UNO Bilis Serbisyo - UNO', 0, '2023-11-29 09:27:52', '2023-12-21 08:41:34', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(57, '24f2747c-c526-498d-beef-4e80379cd7ce', 34, 3, 'PHP', '4010101 - Sales - UBC Product Pack - UNO', '5010102 - COGS-UBC Product Pack - UNO', 0, '2023-11-29 09:33:33', '2023-12-21 08:42:59', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(58, '619c1fb4-c2c3-4bed-975f-182e4ebf55e5', 35, 2, 'USD', '4010142 - Sales - UNO Premier Product Plus USD - PREMIER', '5010105 - COGS-UNO Premier Product Plus - PREMIER', 0, '2023-11-29 09:34:36', '2023-12-21 09:45:50', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(59, '32cb6bf4-426e-4496-a370-967bb1e0dc59', 36, 2, 'NGN', '4010145 - Sales - UNO Premier Product Plus NGN', '5010105 - COGS-UNO Premier Product Plus - PREMIER', 0, '2023-11-30 02:47:34', '2023-12-21 09:47:43', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(60, 'fa94ef1d-12d0-4283-9a8e-e33ffd894d14', 37, 2, 'PHP', '4010141 - Sales - UNO Premier Product Plus PHP - PREMIER', '5010105 - COGS-UNO Premier Product Plus - PREMIER', 0, '2023-11-30 03:05:27', '2023-12-21 09:49:55', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(61, 'b2faade6-de20-4f15-8e1a-22456cd7e350', 38, 2, 'PHP', '4010141 - Sales - UNO Premier Product Plus PHP - PREMIER', '5010105 - COGS-UNO Premier Product Plus - PREMIER', 0, '2023-11-30 03:07:10', '2023-11-30 03:07:10', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(62, 'a87c8b92-2b96-4849-a957-6c69aa884ba5', 39, 2, 'PHP', '4010271 - Sales - SRP PHP - PREMIER', '5010208 - COGS-SRP - PREMIER', 0, '2023-11-30 04:50:01', '2023-11-30 04:50:01', NULL, 'Test User', 'Test User', NULL),
(63, '847bebcb-9cef-49a1-855b-e1c62148ae5c', 40, 2, 'PHP', '4010241 - Sales - Distributors PHP - PREMIER', '5010205 - COGS-Distributors - PREMIER', 0, '2023-12-22 03:03:48', '2023-12-22 03:03:48', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL),
(64, 'cacd99f8-cc29-40bb-b6eb-6f508cd7dd0c', 41, 2, 'PHP', '4010251 - Sales - E Store PHP - PREMIER', '5010206 - COGS-E Store - PREMIER', 0, '2023-12-22 03:05:01', '2023-12-22 03:05:01', NULL, 'Maricel Vergara', 'Maricel Vergara', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

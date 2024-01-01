-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 01, 2024 at 03:41 PM
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
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` tinyint NOT NULL DEFAULT '0',
  `active` tinyint NOT NULL DEFAULT '1',
  `blocked` tinyint NOT NULL DEFAULT '0',
  `attempts` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uuid`, `name`, `username`, `email`, `email_verified_at`, `password`, `role_id`, `branch_id`, `company_id`, `remember_token`, `deleted`, `active`, `blocked`, `attempts`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'daea9d1e-8aca-4f97-aaf3-49a552b16929', 'Redemption West Local', 'redemption_westlocal', 'redemption_westlocal@glv2.com', NULL, '$2y$10$tLjQCrHPNKRmteS1Fd/pnOqwH.TEFmi54j80CSpRjC6Ce0frChJAq', '1', '44,1', '3', NULL, 0, 1, 0, 1, '2023-12-22 17:34:37', '2023-12-28 03:32:14', NULL, 'Test User', 'System', NULL),
(2, '6c9bd976-8416-4e63-be6f-a95ca1bac550', 'Redemption West Premier', 'redemption_westpremier', 'redemption_westpremier@glv2.com', NULL, '$2y$10$zF7GjtcGZ/tIj8H7AdUQd.UC5eUyXBlkEyIFdwzCfcv9UUbl.o6rC', '1', '7', '2', NULL, 0, 1, 0, 0, '2023-12-22 17:34:37', '2023-12-22 17:34:37', NULL, 'System', 'System', NULL),
(3, 'dbbbb15c-5f62-458e-a640-cc8c2fbde169', 'Redemption West', 'redemption_west', 'redemption_west@glv2.com', NULL, '$2y$10$/P9kVUV8bOJ47y7.DXSryuGMDliI0DNIhNjb.zQgLiX4rt6TKLL6y', '1', '1,7', '2,3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:37', '2023-12-22 17:34:37', NULL, 'System', 'System', NULL),
(4, '01e69a14-0c20-4bf8-8477-661c02cd0dc4', 'Redemption Calamba Local', 'redemption_calambalocal', 'redemption_calambalocal@glv2.com', NULL, '$2y$10$/evRTu4wgPrhIKpnPEVAMelmeOe7ljEYcOd9gOnzuTLwwdfrsGREK', '1', '3', '3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:37', '2023-12-22 17:34:37', NULL, 'System', 'System', NULL),
(5, '700a2277-9630-44cd-87c4-79d206bab8a1', 'Redemption Calamba Premier', 'redemption_calambapremier', 'redemption_calambapremier@glv2.com', NULL, '$2y$10$MmtEV/qNAwV3SH8iZifStOsGRIjAebNjWv56fTvosb2NW20b/upW6', '1', '9', '2', NULL, 0, 1, 0, 0, '2023-12-22 17:34:37', '2023-12-22 17:34:37', NULL, 'System', 'System', NULL),
(6, '6757dc15-c0f3-40c9-9ae0-1218ea37da24', 'Redemption Calamba', 'redemption_calamba', 'redemption_calamba@glv2.com', NULL, '$2y$10$eD6KfWP3d2pSCQf1H7f8wO3YFd.bwV9Dxaj0JdB9Pv87QD5RxLgsq', '1', '3,9', '2,3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:37', '2023-12-22 17:34:37', NULL, 'System', 'System', NULL),
(7, '24597381-baf8-44c5-ab83-f910064c7223', 'Cashier West Local', 'cashier_westlocal', 'cashier_westlocal@glv2.com', NULL, '$2y$10$tdBsCOa8HgD.SgAYxqnUi.87WgSxP8gs/EkXmDFGsz511vOwFSJ82', '2', '44,1', '3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:37', '2023-12-27 07:14:31', NULL, 'Test User', 'System', NULL),
(8, '276fb8b0-34c1-4a8a-851b-9f2dd6c105c4', 'Cashier West Premier', 'cashier_westpremier', 'cashier_westpremier@glv2.com', NULL, '$2y$10$7C9ownpNYyDMAT/.zj02luzU9ej3HTCphjeJAcrSdMrRw3d0aguze', '2', '7', '2', NULL, 0, 1, 0, 0, '2023-12-22 17:34:37', '2023-12-22 17:34:37', NULL, 'System', 'System', NULL),
(9, 'be68a3a9-40ba-483e-bf3c-66c87e2ad2a1', 'Cashier West', 'cashier_west', 'cashier_west@glv2.com', NULL, '$2y$10$X2blIZFmj7fdee.Kw/3d6.Cnb.BY5mZe51FN92nq4E00/NRZHLS9i', '2', '1,7', '2,3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:37', '2023-12-22 17:34:37', NULL, 'System', 'System', NULL),
(10, '47930846-821b-4b33-9bd1-037bc715de52', 'Cashier Calamba Local', 'cashier_calambalocal', 'cashier_calambalocal@glv2.com', NULL, '$2y$10$FJJjez0zkzrDqJhbAjDT1.19AzJ1TGc3pIL8I6I.wLZ7EPKH/Z4sG', '2', '3', '3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:37', '2023-12-22 17:34:37', NULL, 'System', 'System', NULL),
(11, '8af2e605-cc0d-4666-8d0a-3d3c57a562d5', 'Cashier Calamba Premier', 'cashier_calambapremier', 'cashier_calambapremier@glv2.com', NULL, '$2y$10$MywW3jzyqR4e0ot/dQKaeOkV6v8GF7ZcqQ9IpssgUr3SyAHVppGsK', '2', '9', '2', NULL, 0, 1, 0, 0, '2023-12-22 17:34:37', '2023-12-22 17:34:37', NULL, 'System', 'System', NULL),
(12, 'eab85f26-3380-41b1-a265-fef5b4571a20', 'Cashier Calamba', 'cashier_calamba', 'cashier_calamba@glv2.com', NULL, '$2y$10$WLcOLfuyRBWxN/.U3O.EE..0Ky11p6MN6YyQ/KL1dQR/C0iwcq03y', '2', '3,9', '2,3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:37', '2023-12-22 17:34:37', NULL, 'System', 'System', NULL),
(13, '9c3ac245-6ef3-43bb-85b5-7fdd079caf11', 'Head Redemption West Local', 'headredemption_westlocal', 'headredemption_westlocal@glv2.com', NULL, '$2y$10$dJfe46rG4tG3fDkqwv2NDu1C27NTEs7sCP8Yu79AJA3s8MAIQyr3q', '3', '1', '3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:37', '2023-12-22 17:34:37', NULL, 'System', 'System', NULL),
(14, 'ed3145d0-2461-451c-83c6-d17b5c95b019', 'Head Redemption West Premier', 'headredemption_westpremier', 'headredemption_westpremier@glv2.com', NULL, '$2y$10$1dy9nJw7i26mR3K7FvJPRuMIxM9pAYhRP9v7nNtsEj6LsACXYdDve', '3', '7', '2', NULL, 0, 1, 0, 0, '2023-12-22 17:34:37', '2023-12-22 17:34:37', NULL, 'System', 'System', NULL),
(15, '9433543c-bac2-4347-8676-24472400e6ac', 'Head Redemption West ', 'headredemption_west', 'headredemption_west@glv2.com', NULL, '$2y$10$pfnOCRZttk9bJaWNBzasZO3Be3oDYjOR9q97RLmstMTul9MXd4J5q', '3', '1,7', '2,3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:37', '2023-12-22 17:34:37', NULL, 'System', 'System', NULL),
(16, '173424fa-8082-42c5-9d3d-30b720658dbe', 'Head Redemption Calamba Local', 'headredemption_calambalocal', 'headredemption_calambalocal@glv2.com', NULL, '$2y$10$k0k4kAJldVPpD9BcPPde2OirqyWStsCIUg8t/0FZ/iZXLrZs5P7AW', '3', '3', '3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:38', '2023-12-22 17:34:38', NULL, 'System', 'System', NULL),
(17, '596c2e31-ae98-4404-8f7f-54a200475007', 'Head Redemption Calamba Premier', 'headredemption_calambapremier', 'headredemption_calambapremier@glv2.com', NULL, '$2y$10$1KFm7wJU1kAFBaJbDsmBx.BXPkCnPebA2HhEx1rA6s/R0r1e4WZ8e', '3', '9', '2', NULL, 0, 1, 0, 0, '2023-12-22 17:34:38', '2023-12-22 17:34:38', NULL, 'System', 'System', NULL),
(18, '45ada1ae-e8cc-491d-9a21-020e86e8c679', 'Head Redemption Calamba', 'headredemption_calamba', 'headredemption_calamba@glv2.com', NULL, '$2y$10$tlPGlYqIKpyMEjftyAsp.u5USjRlWgruofOigXz.GwDadczCWRzEG', '3', '3,9', '2,3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:38', '2023-12-22 17:34:38', NULL, 'System', 'System', NULL),
(19, 'f6d026f8-031a-415a-8eb2-18dad2b486c4', 'Head Cashier West Local', 'headcashier_westlocal', 'headcashier_westlocal@glv2.com', NULL, '$2y$10$DsV2slJJ33uBfwAFs6koheowQaqDb14lK/yZd/rc0kvQCaRm/Teuy', '4', '1', '3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:38', '2023-12-22 17:34:38', NULL, 'System', 'System', NULL),
(20, '39a6dd6c-af8c-484c-a4b0-612d14bc04de', 'Head Cashier West Premier', 'headcashier_westpremier', 'headcashier_westpremier@glv2.com', NULL, '$2y$10$oMq6vhITLz4BwWkqEBgmyexlBKZBM2WWI/Om5LsM2zrQquiBU68Xu', '4', '7', '2', NULL, 0, 1, 0, 0, '2023-12-22 17:34:38', '2023-12-22 17:34:38', NULL, 'System', 'System', NULL),
(21, '8ea1b325-93d6-4414-87ed-48dc70c75a15', 'Head Cashier West', 'headcashier_west', 'headcashier_west@glv2.com', NULL, '$2y$10$MKXSULP6/OLrE4GH7CviD.q8zAuE9i28Ow684K1oVCBHHO3H4Agwe', '4', '1,7', '2,3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:38', '2023-12-22 17:34:38', NULL, 'System', 'System', NULL),
(22, '91512a6f-a5ed-472d-972c-e4fc375c4027', 'Head Cashier Calamba Local', 'headcashier_calambalocal', 'headcashier_calambalocal@glv2.com', NULL, '$2y$10$aIAqadvB.kg.ngOGgeoJueRbFH5peqi.fgC6iZ6.Q8YPOo2VPAgNO', '4', '3', '3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:38', '2023-12-22 17:34:38', NULL, 'System', 'System', NULL),
(23, '4e753f75-1847-44b2-93ca-be5515eb1bb4', 'Head Cashier Calamba Premier', 'headcashier_calambapremier', 'headcashier_calambapremier@glv2.com', NULL, '$2y$10$yAJlgmJzPHlps0SHGvybd.Y6vmHCLyJjMKhkmG8XXUvtcm7Y3tNIi', '4', '9', '2', NULL, 0, 1, 0, 0, '2023-12-22 17:34:38', '2023-12-22 17:34:38', NULL, 'System', 'System', NULL),
(24, 'c5fced6d-6306-4615-8485-e4d4bea996f2', 'Head Cashier Calamba', 'headcashier_calamba', 'headcashier_calamba@glv2.com', NULL, '$2y$10$w8mJaIKXryYtPwuZ2HIiG.U63j2RFgV6t8Jyuu5Y1pAWTpXXNeAkW', '4', '3,9', '2,3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:38', '2023-12-22 17:34:38', NULL, 'System', 'System', NULL),
(25, '161297f7-7a11-4886-861b-849f2a13604e', 'Officer In Charge West Local', 'oic_westlocal', 'oic_westlocal@glv2.com', NULL, '$2y$10$NDHsi1hPs7329wDRk0x6yuPMVaFWpX1NB4eh29/GfgrpNmdKXuhcC', '5', '1', '3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:38', '2023-12-22 17:34:38', NULL, 'System', 'System', NULL),
(26, '86d60eeb-bf04-4d25-b96f-b6a8fe2dcd71', 'Officer In Charge West Premier', 'oic_westpremier', 'oic_westpremier@glv2.com', NULL, '$2y$10$jUM.Xs9IPXiaaGhbqNUp.OBAIIEHn1u9eH9bLu3CZfw6vBFmB9byi', '5', '7', '2', NULL, 0, 1, 0, 0, '2023-12-22 17:34:38', '2023-12-22 17:34:38', NULL, 'System', 'System', NULL),
(27, '30dd2699-3a53-4c19-8f28-28a020783579', 'Officer In Charge West', 'oic_west', 'oic_west@glv2.com', NULL, '$2y$10$rLCM0SO/15EZN8hEtbVZbe7MQ88Fn/F0gBZhsXgzZjjVOpvdiytmK', '5', '1,7', '2,3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:38', '2023-12-22 17:34:38', NULL, 'System', 'System', NULL),
(28, 'dab11a66-fe06-473b-8084-08f2ac46d8b4', 'Officer In Charge Calamba Local', 'oic_calambalocal', 'oic_calambalocal@glv2.com', NULL, '$2y$10$Rb5zJ4fnaKe3MYz3zHQNmud9XHJIxXQGd7lvXh8V/ezkckx1H46py', '5', '3', '3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:38', '2023-12-22 17:34:38', NULL, 'System', 'System', NULL),
(29, '619381f9-56d9-4d76-b3e7-ac58533393f3', 'Officer In Charge Calamba Premier', 'oic_calambapremier', 'oic_calambapremier@glv2.com', NULL, '$2y$10$QYDfdS56KWQK1sFZrrrhUOOyIXpnZIPy8fuLbcWOfWF0pHBBDN1/u', '5', '9', '2', NULL, 0, 1, 0, 0, '2023-12-22 17:34:38', '2023-12-22 17:34:38', NULL, 'System', 'System', NULL),
(30, '899676eb-4ff0-4fc2-a02c-520061cf2028', 'Officer In Charge Calamba', 'oic_calamba', 'oic_calamba@glv2.com', NULL, '$2y$10$B.WZ7xWVf0QxgSIEj/Cb0.7R5bX.4e.LmVSamJfNwsMMJafZQJElm', '5', '3,9', '2,3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:38', '2023-12-22 17:34:38', NULL, 'System', 'System', NULL),
(31, '4c78d051-1715-4cb9-9051-d18a623e1a71', 'Branch Manager West Local', 'branchmanager_westlocal', 'branchmanager_westlocal@glv2.com', NULL, '$2y$10$u.lOpxFxCKvkbrc5vhxTL.8AYQABI./JBCOon9mW6cvjMLSpB0uFO', '6', '1', '3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:38', '2023-12-22 17:34:38', NULL, 'System', 'System', NULL),
(32, '5822b8a9-2235-4c16-b197-847e7cb2dd2b', 'Branch Manager West Premier', 'branchmanager_westpremier', 'branchmanager_westpremier@glv2.com', NULL, '$2y$10$VtCPlurT7JiD2QzFQS.R1evRRiB/A8HpoFxbFk7EbpL6UyjUSiZAq', '6', '7', '2', NULL, 0, 1, 0, 0, '2023-12-22 17:34:39', '2023-12-22 17:34:39', NULL, 'System', 'System', NULL),
(33, 'cee2082e-7d47-4dd3-941e-cd6b3c2f683c', 'Branch Manager West', 'branchmanager_west', 'branchmanager_west@glv2.com', NULL, '$2y$10$mvqw4YHDdC9ceLc2m3zzeu4bfsfgCP2Vt0i3sKMbd136OGWqp0D/O', '6', '1,7', '2,3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:39', '2023-12-22 17:34:39', NULL, 'System', 'System', NULL),
(34, '54341c2e-e57d-4bba-bf4b-289b8fe56288', 'Branch Manager Calamba Local', 'branchmanager_calambalocal', 'branchmanager_calambalocal@glv2.com', NULL, '$2y$10$7cHZ5wBqDgaBSzqoOW3nTu/.oSCgk5o0PVLAs0AUbyTY7quZHZ99S', '6', '3', '3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:39', '2023-12-22 17:34:39', NULL, 'System', 'System', NULL),
(35, '4c9f746f-2f57-41c3-a78f-9ddb46ed2076', 'Branch Manager Calamba Premier', 'branchmanager_calambapremier', 'branchmanager_calambapremier@glv2.com', NULL, '$2y$10$fBO21SN9ILr1/JjhN1EGGONQWL/FScx.tQA81gZry4qcpqAM4tRUO', '6', '9', '2', NULL, 0, 1, 0, 0, '2023-12-22 17:34:39', '2023-12-22 17:34:39', NULL, 'System', 'System', NULL),
(36, 'aeced392-e82e-4616-8256-16e82707ebf9', 'Branch Manager Calamba', 'branchmanager_calamba', 'branchmanager_calamba@glv2.com', NULL, '$2y$10$QKP2d7biipZSXkpiwNy2vePKjrgDCt6.nSJEIQzOz.zdMVV7VQ.2.', '6', '3,9', '2,3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:39', '2023-12-22 17:34:39', NULL, 'System', 'System', NULL),
(37, '98bfd46e-0350-4e5a-9085-ec47cd20b5ac', 'Viewer', 'viewer', 'viewer@glv2.com', NULL, '$2y$10$CkJgPkBe2ts0A/ievRfUR.8HKGCayeLpsMjhrJS.4PPfVuP/KJIj.', '7', NULL, NULL, NULL, 0, 1, 0, 0, '2023-12-22 17:34:39', '2023-12-22 17:34:39', NULL, 'System', 'System', NULL),
(38, '747cbca0-6587-442c-a1be-471cce6c05da', 'Viewer Local', 'viewerlocal', 'viewerlocal@glv2.com', NULL, '$2y$10$Hy8rZqLkKUqq5H1Jl1.tQeYDxCm.n/JhFnPLNHxgncESNQYP7VPyC', '7', '1', '3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:39', '2023-12-22 17:34:39', NULL, 'System', 'System', NULL),
(39, '1cb797cb-daab-4671-a32f-5643025839d3', 'Viewer Premier', 'viewerpremier', 'viewerpremier@glv2.com', NULL, '$2y$10$PLd01edW6SC357BmN3uwvOZ9zPaOAw9ZV17Il62ivZbe1jMcmVcqO', '7', '7', '2', NULL, 0, 1, 0, 0, '2023-12-22 17:34:39', '2023-12-22 17:34:39', NULL, 'System', 'System', NULL),
(40, 'd1c9922c-3315-404d-8d6a-cb6e05902bf0', 'Accounting', 'accounting', 'accounting@glv2.com', NULL, '$2y$10$N.O0WByo4zDSoPhig4KEd.BpFup5IoAfHa4EBBz5H3zl4q4IEImCa', '8', NULL, NULL, NULL, 0, 1, 0, 0, '2023-12-22 17:34:39', '2023-12-22 17:34:39', NULL, 'System', 'System', NULL),
(41, 'e909b5d0-e6f8-464e-9926-0c792c51dcca', 'Treasury', 'treasury', 'treasury@glv2.com', NULL, '$2y$10$/ONe/iAIDz3F4qGQ/2lenOT5FGV/ZyCnKjHH7o1tTKlKWByaU4THW', '9', NULL, NULL, NULL, 0, 1, 0, 0, '2023-12-22 17:34:39', '2023-12-22 17:34:39', NULL, 'System', 'System', NULL),
(42, '784a9c90-6ecc-4f78-9f6f-8ffc9892f614', 'Manager Local', 'managerlocal', 'managerlocal@glv2.com', NULL, '$2y$10$VdD60PhWAvrsm6VbjY74Auhip7xA57LYfdNr5PJ8LCO7qR6DOkNPu', '10', '1', '3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:39', '2023-12-22 17:34:39', NULL, 'System', 'System', NULL),
(43, '54560cc0-f94a-45a3-845a-b5aefad958df', 'Manager Premier', 'managerpremier', 'managerpremier@glv2.com', NULL, '$2y$10$OM3gjicTUwydvu3gWVjlmeYUh0NqTpjj7TY7vm.3lAukg0u8l2u12', '10', '7', '2', NULL, 0, 1, 0, 0, '2023-12-22 17:34:39', '2023-12-22 17:34:39', NULL, 'System', 'System', NULL),
(44, 'fd6f17da-9957-46d3-a506-0e4ccab644d3', 'Manager Ecomm', 'managerecomm', 'managerecomm@glv2.com', NULL, '$2y$10$pC/RVkSOG8jCzfGaWjDv5.z0Q.fU6/dqhxaFwnMfh04JKwsT0bKbu', '10', NULL, NULL, NULL, 0, 1, 0, 0, '2023-12-22 17:34:39', '2023-12-22 17:34:39', NULL, 'System', 'System', NULL),
(45, 'c251f280-cba7-46ec-9106-038ccd77e044', 'Administrator', 'administrator', 'administrator@glv2.com', NULL, '$2y$10$Gz4o6.Kgdo7rdfcZmpyNQeCMZOYLrL2XUlVKpATkr/CPg32zAsiXW', '11', NULL, NULL, NULL, 0, 1, 0, 0, '2023-12-22 17:34:39', '2023-12-22 17:34:39', NULL, 'System', 'System', NULL),
(46, '8a57b257-0410-40d1-82ef-191d90e71bcb', 'Superadmin', 'superadmin', 'superadmin@glv2.com', NULL, '$2y$10$sGqL.Mj6iUcnfeLZjGITdOC06B7AYpc2KV0j/Dkog43Ae4fNF4pKq', '12', NULL, NULL, NULL, 0, 1, 0, 0, '2023-12-22 17:34:39', '2023-12-22 17:34:39', NULL, 'System', 'System', NULL),
(47, 'd281fba7-a3eb-479a-be65-b265c8b9c4bb', 'Aris Flores', 'aris', 'aris@glv2.com', NULL, '$2y$10$BqIilhzMkCL8D/GBjDLK2OhldNJ3oD4aGVYV9SoZF.5Y4mNod70Tq', '12', NULL, NULL, NULL, 0, 1, 0, 0, '2023-12-22 17:34:40', '2023-12-22 17:34:40', NULL, 'System', 'System', NULL),
(48, '37139c98-3995-473a-8227-a127dc653234', 'Test User', 'test', 'test@glv2.com', NULL, '$2y$10$Wk54/GDc4uR5swo5GqaCjOoaTXzClvDpWTo68IrLesqdEXhppkh3.', '12', NULL, NULL, NULL, 0, 1, 0, 0, '2023-12-22 17:34:40', '2023-12-30 13:16:51', NULL, 'System', 'System', NULL),
(49, '598fcdc4-1685-4bc8-a2a1-ce956dc7d77d', 'Jorelle Joie Aviso', 'javiso', 'javiso@glv2.com', NULL, '$2y$10$l846D.TPVUO87AEETtqTsuuXVWB2jIIn7g38GIGc73mu.5DUHRYH2', '6', '1', '3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:40', '2023-12-22 17:34:40', NULL, 'System', 'System', NULL),
(50, '62100bb2-54f6-49ea-a373-ccbda39301c1', 'Richard Selosa', 'rselosa', 'rselosa@glv2.com', NULL, '$2y$10$JFawJWMo/YPLtK3kWYviK.HcnnujgukDfDAY20JCtqzaVi8527qge', '3', '1', '3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:40', '2023-12-22 17:34:40', NULL, 'System', 'System', NULL),
(51, '953cca53-a8b1-4982-95ce-5730b34ed000', 'Efren Bacsa', 'ebacsa', 'ebacsa@glv2.com', NULL, '$2y$10$c77tCCEzHtIndvpMMVTt3uEsR3EHoWGCGPT5Roa1Yzq0/mkQUNVOi', '1', '1', '3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:40', '2023-12-22 17:34:40', NULL, 'System', 'System', NULL),
(52, '0054056a-4eea-40f8-9222-53f8b54214c3', 'Amadeo Virgil', 'avirgil', 'avirgil@glv2.com', NULL, '$2y$10$ilVRj13MplZ5qIVC98soTe7vDlwtYrUCHBSzFk8DaudDi5pVuezHm', '1', '1', '3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:40', '2023-12-22 17:34:40', NULL, 'System', 'System', NULL),
(53, '0642cd4e-e39d-4d17-899d-289f164e6b6d', 'Lou Angelic Peralta', 'lperalta', 'lperalta@glv2.com', NULL, '$2y$10$XnNMjZaYaCzWvLFUOQCGIeHsmzFFqIQaYq5AuHt2sy.TmC3GDSISu', '1', '1', '3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:40', '2023-12-22 17:34:40', NULL, 'System', 'System', NULL),
(54, 'b62736a5-174d-43a9-91da-a01ce57375e3', 'Jan Jacob Uy', 'juy', 'juy@glv2.com', NULL, '$2y$10$.T6Kei3Jsrs7Xt/Ns57rIe7zoSwu23APTox8Ep31EqHHwskZmbMvW', '1', '1', '3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:40', '2023-12-22 17:34:40', NULL, 'System', 'System', NULL),
(55, '99ea9432-8166-4e60-9452-352fef1e98bb', 'Lyn lyn Biboso', 'lbiboso', 'lbiboso@glv2.com', NULL, '$2y$10$Px6x20jocg4iQEIBJ71JkOZiW8ajWASWVNSFB6Ak2xEHmasipml4S', '2', '1', '3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:40', '2023-12-22 17:34:40', NULL, 'System', 'System', NULL),
(56, '663e4401-bcbe-442a-b8f8-1e9fef1077d2', 'Renna Tamo', 'rtamo', 'rtamo@glv2.com', NULL, '$2y$10$nB84m9y19EbhFpA4jALxKegxGK2PY21MCua6AiSCJBkODTj6TaUXy', '2', '1', '3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:40', '2023-12-28 04:19:25', NULL, 'System', 'System', NULL),
(57, '75176c4c-baa3-4150-a46b-a02f0955ac0e', 'Mckenly Joy Panaligan', 'mpanaligan', 'mpanaligan@glv2.com', NULL, '$2y$10$CpUcGbioj/pCK806S2D44e0LwWzGNBdUycJCsp7NDK6.RK2bLCeCW', '2', '1', '3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:40', '2023-12-22 17:34:40', NULL, 'System', 'System', NULL),
(58, '72245ba2-6823-4481-b9e0-b00945ada694', 'Marie Grace Relado', 'mrelado', 'mrelado@glv2.com', NULL, '$2y$10$e6Yb1E4kog5Kg1pfaHuFTO6m0EXSFw3dotmDe92Rxu5iZv5szTsMC', '2', '1', '3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:40', '2023-12-22 17:34:40', NULL, 'System', 'System', NULL),
(59, '73a2246c-2b95-4c3d-a5ce-356e4ac0d19a', 'Charish Catanus', 'ccatanus', 'ccatanus@glv2.com', NULL, '$2y$10$hZ.isPreoa7uPj94WWdXn.B7aMy3D30agU.tvDcBIztvw0TKVhITC', '6', '2,8', '2,3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:40', '2023-12-22 17:34:40', NULL, 'System', 'System', NULL),
(60, '305f0c05-7551-4fe7-9a64-c53649a23378', 'Jozel Ann Loreto', 'jloreto', 'jloreto@glv2.com', NULL, '$2y$10$SKouIMXrm/Pisk1g2ewG.u.E1hqxXNu5QPAPWAWTstMpz9XVjM/8O', '5', '2,8', '2,3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:40', '2023-12-27 02:21:00', NULL, 'Test User', 'System', NULL),
(61, 'bc896418-4637-4435-a9e0-e82ee2e13c3c', 'Maricarl Luna', 'mluna', 'mluna@glv2.com', NULL, '$2y$10$UPl8fIT0CGZ9uJHOnzx7g..hYBmh16VEHGmmzqPvIL/TKAqo5dPgC', '5', '4,10', '2,3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:40', '2023-12-27 03:12:52', NULL, 'Test User', 'System', NULL),
(62, 'c0425a43-7fcd-45e7-b79e-2d7d9d68cec9', 'Midz Mayormita', 'mmayormita', 'mmayormita@glv2.com', NULL, '$2y$10$0uQc6YK1fWDhjU6EIU.rm.Daorp3vlsy67OPBHhifcgS9Qi2Ps8Pm', '1', '4,10', '2,3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:40', '2023-12-22 17:34:40', NULL, 'System', 'System', NULL),
(63, '554b6a62-e8bc-41af-a519-c10f67276918', 'Primrose Alvaro', 'palvaro', 'palvaro@glv2.com', NULL, '$2y$10$FD2NmwKUNRrn/45oHBeyc.x2BPUJhgiIknk3xsKFvHiC5KaT425OS', '5', '5,11', '2,3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:41', '2023-12-27 03:55:00', NULL, 'Test User', 'System', NULL),
(64, '53b966ee-8c9a-4186-a355-2e823d1109a7', 'Joar Segapo', 'jsegapo', 'jsegapo@glv2.com', NULL, '$2y$10$cE.I8odzBqVZH9I9wqTbG.UNWE4Xii8Adh3x6PjmOzet7Ibs6iggW', '1', '5,11', '2,3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:41', '2023-12-22 17:34:41', NULL, 'System', 'System', NULL),
(65, '09a02861-d1d9-4e5a-b0b4-aee2e6615234', 'Joseyulo Embudo Jr', 'jembudo', 'jembudo@glv2.com', NULL, '$2y$10$eMWl6gB3hTAkmpH7mMR.HuBtZ.ki8ZaVQxi/H4iB6LoJ0eqiXGnoe', '6', '5,11', '2,3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:41', '2023-12-22 17:34:41', NULL, 'System', 'System', NULL),
(66, '7568c1d0-5801-4b67-a5ae-b865d8d9b581', 'Gerome Guina', 'gguina', 'gguina@glv2.com', NULL, '$2y$10$Wa6NK3FimEPA3g/bFLndQu4VMO.6u/ptXlXZb87gmj/HcuniBsHcK', '3', '3,9', '2,3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:41', '2023-12-27 03:57:06', NULL, 'Test User', 'System', NULL),
(67, 'e41a1ced-b4c2-4294-9df5-095ad0e90ecf', 'Kristia-Ann E. Pingkian', 'kpingkian', 'kpingkian@glv2.com', NULL, '$2y$10$9vnDEM8WjEiAjsxPH6xuXuj3E6j7Y5PP49TcHiKrztNliHuL8zzci', '6', '3,9', '2,3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:41', '2023-12-22 17:34:41', NULL, 'System', 'System', NULL),
(68, '9261b9f6-8fba-4471-a223-1fffb9ea329b', 'Greg Porras', 'gporras', 'gporras@glv2.com', NULL, '$2y$10$SvvnIvqSQuUYBzmGW5YD1.otvN4XXd3TBsHHTNz/q51oeByxtouxa', '6', '7', '2', NULL, 0, 1, 0, 0, '2023-12-22 17:34:41', '2023-12-22 17:34:41', NULL, 'System', 'System', NULL),
(69, 'b1805fd5-b11d-45fb-a9b5-56834fef11df', 'Jerjurie Delotindo', 'jdelotindo', 'jdelotindo@glv2.com', NULL, '$2y$10$byo3YaKeHa3/7EJ0GaI.AeIL5nh01SAcZJCK7VA0lgSsFRGALJmf2', '1', '12,6', '2,3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:41', '2023-12-27 03:01:01', NULL, 'Test User', 'System', NULL),
(70, '82d27ade-bbbe-444a-9785-a0d19440cd08', 'Ana Marie Jasmin', 'ajasmin', 'ajasmin@glv2.com', NULL, '$2y$10$0di51P9UDAPsikYHAOnPyOnrZP0lnmP00YQFMKp1XPGxf99axHtm2', '7', '12,6', '2,3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:41', '2023-12-27 02:59:27', NULL, 'Test User', 'System', NULL),
(71, 'd5e7658f-af89-4925-8849-78b8e8bb2d3c', 'Rachel Malan', 'rmalan', 'rmalan@glv2.com', NULL, '$2y$10$pRnAgxmXeXwwXmeSgxM7yuKmO6Qu67qMJv6bsz70j4sY76vFVgyJO', '7', '12,6', '2,3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:41', '2023-12-27 02:57:11', NULL, 'Test User', 'System', NULL),
(72, 'e7b2366c-3d80-4f36-aacb-b52758d098f4', 'Jeffrey Tayco', 'jtayco', 'jtayco@glv2.com', NULL, '$2y$10$I004qWrGsEIjmmCTrmIwUuNUZCo2v3Kb2GVMQLyIZ05Jm9CASNiv.', '10', NULL, '2,3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:41', '2023-12-28 01:30:18', NULL, 'Test User', 'System', NULL),
(73, '117154bb-c957-4fad-8c0d-a033d0de42ef', 'Shelley Mangila', 'smangila', 'smangila@glv2.com', NULL, '$2y$10$bXkZRRVEkVbQU6pVGgyOSeHVnMUrO75vFpyQoA7ogN2Djc/nvIqNG', '5', NULL, '2,3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:41', '2023-12-27 04:03:07', NULL, 'Test User', 'System', NULL),
(74, 'e7be796e-3eeb-431e-9eb7-d9835a312ccb', 'Jermie Sandrino', 'jsandrino', 'jsandrino@glv2.com', NULL, '$2y$10$3P9.5Hv8GIpNpwjM.15Jn.6wn4l5LvUpOZG9DA99BeXh0prPJ03B.', '5', '12,6', '2,3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:41', '2023-12-28 07:57:23', NULL, 'Test User', 'System', NULL),
(75, 'd6d8e13e-f376-41e0-b482-ffc4d3c6c14f', 'Rose Ann Remollo', 'rremollo', 'rremollo@glv2.com', NULL, '$2y$10$V8zrHMqVwmzccl.9IjnnnOaW7N9eXrrzF1HVIGrcPA984Bi1ja3.6', '5', NULL, '2,3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:41', '2023-12-22 17:34:41', NULL, 'System', 'System', NULL),
(76, 'a8dffbef-bedd-4a2a-825d-2ed236e986dc', 'Princess Asor', 'pasor', 'pasor@glv2.com', NULL, '$2y$10$1PBM3rpeEJLE4nzziLBo5.e/rAEjRS8K7NRif1I6Yht6uyUS/VVtW', '2', '12,6', '2,3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:41', '2023-12-27 03:10:17', NULL, 'Test User', 'System', NULL),
(77, '62215d6b-5110-4ec4-b271-5af8339e7cd8', 'Ella Mae Madrigal', 'emadrigal', 'emadrigal@glv2.com', NULL, '$2y$10$dJh2nhntncYJytJ/m0Iy5.TvB0ZqXbSv4p.i8YVIyswBynAY8V126', '2', '12,6', '2,3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:41', '2023-12-27 03:09:06', NULL, 'Test User', 'System', NULL),
(78, '88556406-60c4-492e-a546-c4c99b12f26d', 'Danilo Jr. Brillante', 'dbrillante', 'dbrillante@glv2.com', NULL, '$2y$10$ePq3U8MV2GxRTyFddbN6YOj9mo24AtZxzxgQPt2I5kMJdgwojIkpu', '1', '12,6', '2,3', NULL, 0, 1, 0, 0, '2023-12-22 17:34:41', '2023-12-27 03:03:09', NULL, 'Test User', 'System', NULL),
(79, '58776a7f-fb1b-400a-9dcb-a9f21dc7e8c2', 'Maricel Vergara', 'maricel', 'accounting.datacontroller@uno-corp.com', NULL, '$2y$10$FU17mdVRTMW7n/R8eJwdpecCbnC5yjPFR/2Bs1qM.O665W2UuFTT.', '8', '10,9,8,12,11,7,4,3,2,6,5,1', '2,3', NULL, 0, 1, 0, 0, '2023-12-27 00:54:39', '2023-12-27 00:54:39', NULL, 'Test User', NULL, NULL),
(80, '6628e419-32e2-48e8-bc34-b6b7edfa5e95', 'Jhessa Marie Morales', 'jmorales', 'jmorales@glv2.com', NULL, '$2y$10$CyZmPS6Bj9F/1/PtQ0/l0OK8vvNS4CPUz4DpRUW//PgT/5czNUX5.', '2', '7', '2', NULL, 0, 1, 0, 0, '2023-12-27 03:13:05', '2023-12-27 03:13:05', NULL, 'Test User', NULL, NULL),
(81, '2c31f99d-b571-41c3-ba1c-c8e36300f9d3', 'Jane Moya', 'jmoya', 'jmoya@glv2.com', NULL, '$2y$10$8PAcrCpf9FTqyFJ9/hP7P.dxCX1XqXL1sRiPPSBSWPOitpO56zSDO', '2', '7', '2', NULL, 0, 1, 0, 0, '2023-12-27 03:16:10', '2023-12-30 05:05:23', NULL, 'Test User', NULL, NULL),
(82, '98cbe98e-dda2-43bb-a67f-98a3c0c0690a', 'Jun Jun Alonzo', 'jalonzo', 'jalonz@glv2.com', NULL, '$2y$10$KVQSsvnb2/tR3QobYhh.ouzBALS4nwhqVJRdNfHcqclqF/gipin5u', '3', '7', '2', NULL, 0, 1, 0, 0, '2023-12-27 03:19:21', '2023-12-27 03:19:21', NULL, 'Test User', NULL, NULL),
(83, '0907d572-e087-4b90-90ad-e5d37077a74a', 'Roselle Magyawe', 'rmagyawe', 'roselle.magyawe@uno-corp.com', NULL, '$2y$10$EQmJJnC9.usyVlfGiPd22epLgOEQ7vvhu1Ja2D8T8k3Aqi.FuvFpe', '10', '10,9,8,11,7,4,3,2,5,1', '2,3', NULL, 0, 1, 0, 0, '2023-12-28 01:21:48', '2023-12-28 01:22:38', NULL, 'Test User', NULL, NULL),
(84, '43e2887f-372c-4f33-be85-cbfd84cae273', 'Cielo Fernandez', 'cielo', 'cielo.fernandez@uno-corp.com', NULL, '$2y$10$QOTS7Ys4vLXahMtGmA4HLO7Xb.DNBrkl5IuqfYeWWw4Fs8wfpbdPq', '13', '10,9,8,12,11,45,7,4,3,2,6,5,44,1', '2,3', NULL, 0, 1, 0, 0, '2023-12-28 02:54:44', '2023-12-28 02:54:44', NULL, 'Test User', NULL, NULL),
(85, 'b2e5d379-e275-4efb-bbd3-1a1f14c82aa6', 'Chen Test', 'chen_test', 'chen_test@glv2.com', NULL, '$2y$10$EL1BIqh/Qx74W3tdEIc/xu/yLmEP71/0AWMTImYoRZ3GAdJjw49LG', '2', '10,11,7,4,5,1', '2,3', NULL, 0, 1, 0, 0, '2023-12-28 03:14:31', '2023-12-29 06:33:35', NULL, 'Test User', NULL, NULL),
(86, 'cfa1c639-643c-4769-b6d9-75e785a2bdc0', 'Develyn Derder', 'dderder', 'dderder_cashier@glv2.com', NULL, '$2y$10$RaI6oxt3MliW9Dfxwdu0eu8Eo6nFwgRFgA1EdSY9DIcdPmFijA/YC', '2', '8,2', '2,3', NULL, 0, 1, 0, 0, '2023-12-28 07:29:30', '2023-12-28 07:29:30', NULL, 'Test User', NULL, NULL),
(87, 'ce52dae8-91c3-43da-ab40-d5819af735de', 'CHARISH CATANUS', 'ccatanus_cashier', 'ccatanus_cashier@glv2.com', NULL, '$2y$10$lAyj6Xt2uErT1ozjJtaU0.6gnZFfesdmb4WRAHMYIrmpSGo5sVm3m', '2', '8,2', '2,3', NULL, 0, 1, 0, 0, '2023-12-28 07:31:09', '2023-12-28 07:31:09', NULL, 'Test User', NULL, NULL),
(88, 'be852410-b4a2-4074-8873-2aebdaac4e1b', 'JOZEL ANN LORETO', 'jloreto_cashier', 'jloreto_cashier@glv2.com', NULL, '$2y$10$QSi6WYEkKApseBP6799AjuMW.0UyDQXxWN8HRYYlRF.HlO2m1kAdy', '2', '8,2', '2,3', NULL, 0, 1, 0, 0, '2023-12-28 07:33:09', '2023-12-28 07:33:09', NULL, 'Test User', NULL, NULL),
(89, 'a95d9a88-57ed-4602-b395-679efc3ce159', 'MARICARL LUNA', 'mluna_cashier', 'mluna_cashier@glv2.com', NULL, '$2y$10$U2U5QEEJ8DlZrr0T/.2X8.Qo5FAdzE2a837lVk8bNGDGpDEPS3b/a', '2', '10,4', '2,3', NULL, 0, 1, 0, 0, '2023-12-28 07:34:00', '2023-12-28 07:34:00', NULL, 'Test User', NULL, NULL),
(90, 'ffe7c9b5-fcb3-4b94-b256-4c4f75403efb', 'PRIMROSE ALVARO', 'palvaro_cashier', 'palvaro_cashier@glv2.com', NULL, '$2y$10$VgCNrXk1Nbp8XHyw65WfFuy2ykFQjlij7MgtZpxNgqe6soqISC6KC', '2', '11,5', '2,3', NULL, 0, 1, 0, 0, '2023-12-28 07:34:54', '2023-12-28 07:34:54', NULL, 'Test User', NULL, NULL),
(91, '1723e8ca-561e-48c3-8e38-be24fa646f9c', 'JOSEYULO EMBUDO JR', 'jembudo_cashier', 'jembudo_cashier@glv2.com', NULL, '$2y$10$5jyFFL8RYh1xBuTve8NWQO6B16hZJ6JsyTUbS1BwldznFYNQFFAnu', '2', '11,5', '2,3', NULL, 0, 1, 0, 0, '2023-12-28 07:38:13', '2023-12-28 07:38:13', NULL, 'Test User', NULL, NULL),
(92, '3e858236-34f8-4c1e-a132-4d8743f9e993', 'GEROME GUINA', 'gguina_cashier', 'gguina_cashier@glv2.com', NULL, '$2y$10$2GcFo6E3cR6HY5NlJnkI..6Xci91jYRYOfTWW3AmrBImTTLLbyO8m', '2', '9,3', '2,3', NULL, 0, 1, 0, 0, '2023-12-28 07:39:04', '2023-12-28 07:39:04', NULL, 'Test User', NULL, NULL),
(93, '42eccf53-d81d-4b10-a5a5-79aa227d6d02', 'Kristia-Ann E. Pingkian', 'kpingkian_cashier', 'kpingkian_cashier@glv2.com', NULL, '$2y$10$WLNRnyheKHPyXexbCQe/n.q1kHE5.B.M.jB/UJ5yxzsYtq8BW9hYi', '2', '9,3', '2,3', NULL, 0, 1, 0, 0, '2023-12-28 07:39:57', '2023-12-28 07:39:57', NULL, 'Test User', NULL, NULL),
(94, 'bdb25f8c-f8a4-43ed-a896-d4f0e06911cb', 'Clarabel Dominguez', 'cdominguez', 'cdominguez@glv2.com', NULL, '$2y$10$3aRXdmAHBKdxm.9MKzPs7..qdwO/HxNpaKV73h8UkeY9ySeDSyZGS', '5', '46', '2', NULL, 0, 1, 0, 0, '2023-12-28 22:12:31', '2023-12-31 04:43:57', NULL, 'Test User', NULL, NULL),
(95, 'cec1ddd1-79ab-43e6-a1e8-53410debf754', 'Clarabel Dominguez', 'cdominguez_cashier', 'cdominguez_cashier@glv2.com', NULL, '$2y$10$4eEzIjZCoG5VUoPEjUqtgu3OAy5iGq9k3hTmvy0n.xNzZoHcQ.MOe', '2', '46', '2', NULL, 0, 1, 0, 0, '2023-12-28 22:13:20', '2023-12-28 22:13:20', NULL, 'Test User', NULL, NULL),
(96, '1220687b-4e60-4028-a2b1-e6a59b45938e', 'Neil Harvey Gadores', 'ngadores', 'ngadores@glv2.com', NULL, '$2y$10$4.3qJ7hz2rGeScrLaTRYd.AJgQOlWqb17KXTlS29OeDwtO75nQtwu', '2', '46', '2', NULL, 0, 1, 0, 0, '2023-12-28 22:14:06', '2023-12-28 22:14:06', NULL, 'Test User', NULL, NULL),
(97, '70bd0d21-bd5c-4792-9cd5-93f4c955e643', 'Lester Manatas', 'lmanatas', 'lmanatas@glv2.com', NULL, '$2y$10$rbMQBcxD6CdV8HrCA/RODuzK4BVEywKLYa6/YZ.J9/zjChChiRquS', '2', '46', '2', NULL, 0, 1, 0, 0, '2023-12-28 22:14:36', '2023-12-28 22:14:36', NULL, 'Test User', NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

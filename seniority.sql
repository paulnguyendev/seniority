-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 01, 2023 lúc 11:04 AM
-- Phiên bản máy phục vụ: 10.4.25-MariaDB
-- Phiên bản PHP: 8.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `seniority`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `agents`
--

CREATE TABLE `agents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middle_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qrcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `_lft` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `_rgt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('licensed','non-licensed') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_suppend` enum('0','1') COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `email_verified_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `verify_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `license_level_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_root` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `agents`
--

INSERT INTO `agents` (`id`, `email`, `code`, `first_name`, `middle_name`, `last_name`, `mobile`, `username`, `status`, `password`, `token`, `thumbnail`, `qrcode`, `parent_id`, `_lft`, `_rgt`, `type`, `is_suppend`, `email_verified_at`, `deleted_at`, `verify_code`, `created_at`, `updated_at`, `license_level_id`, `is_root`) VALUES
(1, 'root.seniority@yahoo.com', 'SM999999', 'Root', 'Seniority', 'System', NULL, 'root', 'active', 'e10adc3949ba59abbe56e057f20f883e', '6d821f9d926afd05ba92ad2927a0de12', NULL, NULL, NULL, '1', '10', 'licensed', '0', NULL, NULL, NULL, '2023-02-22 00:52:15', '2023-02-23 01:11:49', NULL, '0'),
(7, 'anhnnd.hotro@gmail.com', 'SM856802', 'Nguyen Ngoc', 'Duy', 'Anh', '0932730394', 'anhnnd', 'active', 'e10adc3949ba59abbe56e057f20f883e', '65fc7eee7bbc6d231ae3cf0dc3750d4c', NULL, NULL, 1, '2', '9', 'licensed', '0', '2023-02-21 07:13:36', NULL, '636548', '2023-02-20 23:50:17', '2023-02-23 01:11:49', 2, '0'),
(10, 'anhnnd.hotro123@gmail.com', 'SM168530', 'Duy Anh', 'Nguyen', 'Ngoc', '0932732095', 'tinidev2', 'active', 'e5345451fee3d23e85ef891f9bacd2c3', '12ade91854773df7fa15f18968491498', 'default.png', NULL, 7, '3', '4', 'non-licensed', '0', NULL, NULL, NULL, '2023-02-22 23:45:51', '2023-02-23 01:11:49', 2, '0'),
(11, 'anhnnd.hotro70@gmail.com', 'SM388155', 'Nguyen', 'Duy', 'Anh', '0932730397', 'tinidev1', 'active', 'e10adc3949ba59abbe56e057f20f883e', '7c056e53ba627abde049a3f7174c342c', 'default.png', NULL, 7, '7', '8', 'licensed', '0', NULL, NULL, NULL, '2023-02-23 00:24:03', '2023-02-28 23:19:56', NULL, '0'),
(12, 'duyanh@obnlab.asia', 'SM522263', 'Nguyen', NULL, 'Paul', '0932730391', 'paulnguyen', 'pending', 'e10adc3949ba59abbe56e057f20f883e', '9d3b1387179e2fd3cab91426d398eda4', 'default.png', NULL, 7, '5', '6', 'licensed', '0', '2023-02-23 08:50:31', NULL, '332991', '2023-02-23 01:49:54', '2023-02-28 22:02:23', NULL, '0');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `condition_license_levels`
--

CREATE TABLE `condition_license_levels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `level_id` bigint(20) UNSIGNED DEFAULT NULL,
  `number_agent` int(11) DEFAULT 0,
  `direct_level_id` bigint(20) UNSIGNED DEFAULT NULL,
  `number_product` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `condition_license_levels`
--

INSERT INTO `condition_license_levels` (`id`, `level_id`, `number_agent`, `direct_level_id`, `number_product`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1, 3, NULL, NULL),
(2, 3, 1, 2, 5, NULL, NULL),
(3, 4, 1, 3, 7, NULL, NULL),
(4, 5, 1, 4, 0, NULL, NULL),
(5, 6, 1, 5, 0, NULL, NULL),
(6, 7, 1, 6, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `license_agents`
--

CREATE TABLE `license_agents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middle_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qrcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `_lft` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `_rgt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_suppend` enum('0','1') COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `email_verified_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `verify_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `license_agents`
--

INSERT INTO `license_agents` (`id`, `code`, `first_name`, `middle_name`, `last_name`, `mobile`, `email`, `username`, `status`, `password`, `token`, `thumbnail`, `qrcode`, `parent_id`, `_lft`, `_rgt`, `is_suppend`, `email_verified_at`, `deleted_at`, `verify_code`, `level_id`, `created_at`, `updated_at`) VALUES
(1, 'SM999999', 'Root', 'Seniority', 'System', NULL, 'root.seniority@yahoo.com', 'root', 'active', 'e10adc3949ba59abbe56e057f20f883e', '981f6e3e7d02f589d9cfda93cb9b9a73', NULL, NULL, NULL, '1', '2', '0', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `license_levels`
--

CREATE TABLE `license_levels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `personal_payout` int(11) DEFAULT NULL,
  `team_overrides` int(11) DEFAULT NULL,
  `conditions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`conditions`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_break` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `license_levels`
--

INSERT INTO `license_levels` (`id`, `name`, `personal_payout`, `team_overrides`, `conditions`, `created_at`, `updated_at`, `is_break`, `deleted_at`) VALUES
(1, 'Mortgage Ambassador', 50, 0, NULL, NULL, NULL, '0', NULL),
(2, 'Senior MA', 55, 9, NULL, NULL, NULL, '0', NULL),
(3, 'Elite MA', 60, 8, NULL, NULL, NULL, '0', NULL),
(4, 'Grand MA', 65, 7, NULL, NULL, NULL, '0', NULL),
(5, 'District Leader', 70, 4, NULL, NULL, NULL, '1', NULL),
(6, 'Regional Leader', 80, 5, NULL, NULL, NULL, '1', NULL),
(7, 'National Branch Leader', 90, 6, NULL, NULL, NULL, '1', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `caption` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumb` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `folder_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `folder` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `newtime` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '2023_01_27_061953_create_media_table', 2),
(3, '2023_02_20_132919_create_agents_table', 3),
(4, '2023_02_21_075017_create_staffs_table', 4),
(6, '2023_03_01_031345_create_license_levels_table', 6),
(9, '2023_03_01_031924_create_condition_license_levels_table', 7),
(10, '2023_03_01_033437_add_is_break_to_levels_table', 8),
(11, '2023_03_01_034232_create_products_table', 9),
(12, '2023_03_01_035048_add_level_id_to_agents_table', 10),
(14, '2023_03_01_035816_create_transactions_table', 11),
(15, '2023_03_01_042424_add_deleted_at_to_license_levels_table', 12),
(26, '2023_02_23_010144_add_is_root_to_agent_table', 13),
(27, '2023_03_01_091014_create_test_agent_table', 13);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middle_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `code`, `first_name`, `middle_name`, `last_name`, `email`, `phone`, `agent_id`, `status`, `created_at`, `updated_at`) VALUES
(1, '1251251251212', 'Duy Anh', 'Nguyen', 'Ngoc', 'anhnnd.hotro@gmail.com', '12521521512', 7, 'active', '2023-03-01 04:56:32', NULL),
(9, '1251251251212', 'Duy Anh', 'Nguyen', 'Ngoc', 'anhnnd.hotro@gmail.com', '12521521512', 7, 'active', '2023-03-01 04:56:32', NULL),
(10, '1251251251212', 'Duy Anh', 'Nguyen', 'Ngoc', 'anhnnd.hotro@gmail.com', '12521521512', 7, 'active', '2023-03-01 04:56:32', NULL),
(11, '1251251251212', 'Duy Anh', 'Nguyen', 'Ngoc', 'anhnnd.hotro@gmail.com', '12521521512', 7, 'active', '2023-03-01 04:56:32', NULL),
(12, '1251251251212', 'Duy Anh', 'Nguyen', 'Ngoc', 'anhnnd.hotro@gmail.com', '12521521512', 7, 'active', '2023-03-01 04:56:32', NULL),
(13, '1251251251212', 'Duy Anh', 'Nguyen', 'Ngoc', 'anhnnd.hotro@gmail.com', '12521521512', 7, 'active', '2023-03-01 04:56:32', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `staffs`
--

CREATE TABLE `staffs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middle_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qrcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `staffs`
--

INSERT INTO `staffs` (`id`, `first_name`, `middle_name`, `last_name`, `mobile`, `email`, `username`, `password`, `status`, `token`, `thumbnail`, `qrcode`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Super', '', 'Admin', NULL, 'super.admin@yahoo.com', 'superadmin', 'e10adc3949ba59abbe56e057f20f883e', 'active', '40d3709bfefa17c534428e6cbe27fd3f', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `total` int(11) DEFAULT 0,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'in',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agents_license_level_id_foreign` (`license_level_id`);

--
-- Chỉ mục cho bảng `condition_license_levels`
--
ALTER TABLE `condition_license_levels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `condition_license_levels_level_id_foreign` (`level_id`),
  ADD KEY `condition_license_levels_direct_level_id_foreign` (`direct_level_id`);

--
-- Chỉ mục cho bảng `license_agents`
--
ALTER TABLE `license_agents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `license_agents_level_id_foreign` (`level_id`);

--
-- Chỉ mục cho bảng `license_levels`
--
ALTER TABLE `license_levels`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_agent_id_foreign` (`agent_id`);

--
-- Chỉ mục cho bảng `staffs`
--
ALTER TABLE `staffs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_product_id_foreign` (`product_id`),
  ADD KEY `transactions_agent_id_foreign` (`agent_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `agents`
--
ALTER TABLE `agents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `condition_license_levels`
--
ALTER TABLE `condition_license_levels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `license_agents`
--
ALTER TABLE `license_agents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `license_levels`
--
ALTER TABLE `license_levels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `staffs`
--
ALTER TABLE `staffs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `agents`
--
ALTER TABLE `agents`
  ADD CONSTRAINT `agents_license_level_id_foreign` FOREIGN KEY (`license_level_id`) REFERENCES `license_levels` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `condition_license_levels`
--
ALTER TABLE `condition_license_levels`
  ADD CONSTRAINT `condition_license_levels_direct_level_id_foreign` FOREIGN KEY (`direct_level_id`) REFERENCES `license_levels` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `condition_license_levels_level_id_foreign` FOREIGN KEY (`level_id`) REFERENCES `license_levels` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `license_agents`
--
ALTER TABLE `license_agents`
  ADD CONSTRAINT `license_agents_level_id_foreign` FOREIGN KEY (`level_id`) REFERENCES `license_levels` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transactions_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

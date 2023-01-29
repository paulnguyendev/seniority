-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 29, 2023 lúc 05:04 PM
-- Phiên bản máy phục vụ: 10.4.27-MariaDB
-- Phiên bản PHP: 8.0.25

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
-- Cấu trúc bảng cho bảng `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `disk` varchar(255) DEFAULT NULL,
  `folder_id` varchar(255) DEFAULT NULL,
  `folder` varchar(255) DEFAULT NULL,
  `newtime` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `media`
--

INSERT INTO `media` (`id`, `type`, `title`, `caption`, `url`, `thumb`, `time`, `size`, `disk`, `folder_id`, `folder`, `newtime`, `created_at`, `updated_at`) VALUES
(1, 'jpg', 'dtujJ8EKX8.jpg', 'dtujJ8EKX8.jpg', 'dtujJ8EKX8.jpg', 'dtujJ8EKX8.jpg', '1674804541', 852172, 'public', '0', NULL, '2023-01-27 07:29:01', NULL, NULL),
(3, 'png', 'fkOq7ReE9Q.png', 'fkOq7ReE9Q.png', 'fkOq7ReE9Q.png', 'fkOq7ReE9Q.png', '1674806290', 156608, 'public', '0', NULL, '2023-01-27 07:58:10', NULL, NULL),
(4, 'jpg', 'maXNhLtMB2.jpg', 'maXNhLtMB2.jpg', 'maXNhLtMB2.jpg', 'maXNhLtMB2.jpg', '1674806314', 19548, 'public', '0', NULL, '2023-01-27 07:58:34', NULL, NULL),
(5, 'jpg', 'PZO4vtDth8.jpg', 'PZO4vtDth8.jpg', 'PZO4vtDth8.jpg', 'PZO4vtDth8.jpg', '1674830471', 19548, 'public', '0', NULL, '2023-01-27 14:41:11', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2023_01_23_081856_create_users_table', 1),
(2, '2023_01_27_040952_add_email_verified_at_users_table', 2),
(3, '2023_01_27_041235_add_is_suppend_at_users_table', 3),
(4, '2023_01_27_061953_create_media_table', 4),
(5, '2023_01_28_044637_add_deleted_at_user_table', 5),
(90, '2023_01_28_065549_create_mlm_types_table', 6),
(91, '2023_01_28_071751_add_slug_to_mlm_level_table', 6),
(92, '2023_01_28_080057_create_mlm_levels_table', 6),
(93, '2023_01_28_081644_create_mlm_settings_table', 6),
(94, '2023_01_29_064308_add_mlm_level_id_to_users_table', 7),
(95, '2023_01_29_113028_add_deleted_at_to_mlm_types_table', 8),
(96, '2023_01_29_141553_add_mlm_type_id_to_users_table', 9);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mlm_levels`
--

CREATE TABLE `mlm_levels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `short_name` varchar(255) DEFAULT NULL,
  `number_order` int(11) DEFAULT 0,
  `number_lead` int(11) DEFAULT 0,
  `number_child` int(11) DEFAULT 1,
  `child_id` int(11) DEFAULT NULL,
  `mlm_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `mlm_levels`
--

INSERT INTO `mlm_levels` (`id`, `name`, `short_name`, `number_order`, `number_lead`, `number_child`, `child_id`, `mlm_type_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Mortgage Ambassador', 'MA', 0, 0, 0, NULL, 1, NULL, '2023-01-28 21:05:07', NULL),
(2, 'Senior MA', 'SMA', 3, 0, 1, 1, 1, NULL, '2023-01-28 21:05:07', NULL),
(3, 'Elite MA', 'EMA', 5, 0, 1, 2, 1, NULL, '2023-01-28 21:05:07', NULL),
(4, 'Grand MA', 'GMA', 7, 0, 1, 3, 1, NULL, '2023-01-28 21:05:07', NULL),
(5, 'District Leader', 'RMB', 0, 0, 1, 4, 1, NULL, '2023-01-28 21:05:07', NULL),
(6, 'Regional Leader', 'EBM', 0, 0, 1, 5, 1, NULL, '2023-01-28 21:05:07', NULL),
(7, 'National Branch Leader ', 'NBL', 0, 0, 1, 6, 1, NULL, '2023-01-28 21:05:07', '2023-01-28 23:41:45'),
(8, 'Community Ambassador', 'CA', 0, 0, 0, NULL, 2, NULL, '2023-01-28 21:05:07', NULL),
(9, 'Senior CA ', 'SCA', 0, 3, 1, 8, 2, NULL, '2023-01-28 21:05:07', NULL),
(10, 'Elite CA ', 'ECA', 0, 5, 1, 9, 2, NULL, '2023-01-28 21:05:07', NULL),
(11, 'Grand CA ', 'GCA', 0, 7, 1, 10, 2, NULL, '2023-01-28 21:05:07', NULL),
(12, 'District Leader', 'RBM', 0, 0, 1, 11, 2, NULL, '2023-01-28 21:05:07', NULL),
(13, 'Regional Leader', 'EMB', 0, 0, 1, 12, 2, NULL, '2023-01-28 21:05:07', NULL),
(14, 'National Leader', 'NL', 0, 1, 1, 6, 2, NULL, '2023-01-28 21:05:07', '2023-01-29 05:31:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mlm_level_settings`
--

CREATE TABLE `mlm_level_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `key` varchar(255) DEFAULT NULL,
  `commission` int(11) DEFAULT 0,
  `commission_type` enum('percentage','number') DEFAULT 'percentage',
  `commission_group` varchar(255) DEFAULT 'direct',
  `mlm_level_id` bigint(20) UNSIGNED DEFAULT NULL,
  `mlm_indirect_level_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `mlm_level_settings`
--

INSERT INTO `mlm_level_settings` (`id`, `name`, `key`, `commission`, `commission_type`, `commission_group`, `mlm_level_id`, `mlm_indirect_level_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'test', NULL, 10, 'percentage', 'direct', 1, NULL, '2023-01-29 05:02:08', '2023-01-29 04:48:54', '2023-01-28 22:02:08'),
(2, 'test 2', NULL, 5, 'percentage', 'indirect', 1, 1, '2023-01-29 04:58:58', '2023-01-29 04:49:34', '2023-01-28 21:58:58'),
(3, 'test 3', NULL, 100, 'number', 'direct', 9, NULL, '2023-01-29 06:53:51', NULL, '2023-01-28 23:53:51'),
(6, 'Personal Payout', NULL, 50, 'percentage', 'direct', 1, 7, '2023-01-29 05:59:38', '2023-01-28 22:55:41', '2023-01-28 22:59:38'),
(7, '12', NULL, 21, 'percentage', 'direct', 1, 7, '2023-01-29 05:59:38', '2023-01-28 22:58:44', '2023-01-28 22:59:38'),
(8, '125', NULL, 215, 'percentage', 'direct', 1, 7, '2023-01-29 05:59:38', '2023-01-28 22:59:30', '2023-01-28 22:59:38'),
(9, 'Personal Payout', NULL, 50, 'percentage', 'direct', 1, 7, NULL, '2023-01-28 23:00:07', NULL),
(10, 'Personal Payout', NULL, 55, 'percentage', 'direct', 2, 7, NULL, '2023-01-28 23:00:33', NULL),
(11, 'Personal Payout', NULL, 60, 'percentage', 'direct', 3, 7, NULL, '2023-01-28 23:00:55', NULL),
(12, 'Personal Payout', NULL, 65, 'percentage', 'direct', 4, 7, NULL, '2023-01-28 23:01:26', NULL),
(13, 'Personal Payout', NULL, 70, 'percentage', 'direct', 5, 7, NULL, '2023-01-28 23:01:55', NULL),
(14, 'Personal Payout', NULL, 80, 'percentage', 'direct', 6, 7, NULL, '2023-01-28 23:02:15', NULL),
(15, 'Personal Payout', NULL, 90, 'percentage', 'direct', 7, NULL, NULL, '2023-01-28 23:40:00', '2023-01-28 23:40:00'),
(16, 'Mortgage Ambassador', NULL, 9, 'percentage', 'indirect', 2, 1, NULL, '2023-01-28 23:16:32', '2023-01-28 23:16:32'),
(17, 'MA', NULL, 9, 'percentage', 'direct', 2, 7, '2023-01-29 06:10:42', '2023-01-28 23:10:23', '2023-01-28 23:10:42'),
(18, 'Senior MA', NULL, 8, 'percentage', 'indirect', 3, 2, NULL, '2023-01-28 23:21:52', NULL),
(19, 'Elite MA', NULL, 7, 'percentage', 'indirect', 4, 3, NULL, '2023-01-28 23:22:41', NULL),
(20, 'Mortgage Ambassador', NULL, 4, 'percentage', 'indirect', 5, 1, NULL, '2023-01-28 23:23:14', NULL),
(21, 'Senior MA', NULL, 4, 'percentage', 'indirect', 5, 2, NULL, '2023-01-28 23:23:30', NULL),
(22, 'Elite MA', NULL, 4, 'percentage', 'indirect', 5, 3, NULL, '2023-01-28 23:23:51', NULL),
(23, 'Grand MA', NULL, 4, 'percentage', 'indirect', 5, 4, NULL, '2023-01-28 23:24:05', NULL),
(24, 'Personal Payout', NULL, 500, 'number', 'direct', 8, NULL, NULL, '2023-01-28 23:56:52', '2023-01-28 23:56:52'),
(25, 'Personal Payout', NULL, 600, 'number', 'direct', 9, NULL, NULL, '2023-01-28 23:57:06', '2023-01-28 23:57:06'),
(26, 'Personal Payout', NULL, 700, 'number', 'direct', 10, NULL, NULL, '2023-01-28 23:56:30', '2023-01-28 23:56:30'),
(27, 'Personal Payout', NULL, 800, 'number', 'direct', 11, NULL, NULL, '2023-01-28 23:57:49', NULL),
(28, 'Personal Payout', NULL, 900, 'number', 'direct', 12, NULL, NULL, '2023-01-28 23:58:05', NULL),
(29, 'Personal Payout', NULL, 1000, 'number', 'direct', 13, NULL, NULL, '2023-01-28 23:59:02', NULL),
(30, 'Personal Payout', NULL, 1250, 'number', 'direct', 14, NULL, NULL, '2023-01-29 06:40:44', '2023-01-29 06:40:44'),
(32, 'Mortgage Ambassador', NULL, 5, 'percentage', 'indirect', 6, 1, NULL, '2023-01-29 06:42:42', NULL),
(33, 'Senior MA', NULL, 5, 'percentage', 'indirect', 6, 2, NULL, '2023-01-29 06:42:55', NULL),
(34, 'Elite MA', NULL, 5, 'percentage', 'indirect', 6, 3, NULL, '2023-01-29 06:43:15', NULL),
(35, 'Grand MA', NULL, 5, 'percentage', 'indirect', 6, 4, NULL, '2023-01-29 06:43:32', NULL),
(36, 'District Leader', NULL, 5, 'percentage', 'indirect', 6, 5, NULL, '2023-01-29 06:43:47', NULL),
(37, 'Mortgage Ambassador', NULL, 6, 'percentage', 'indirect', 7, 1, NULL, '2023-01-29 06:44:38', NULL),
(38, 'Senior MA', NULL, 6, 'percentage', 'indirect', 7, 2, NULL, '2023-01-29 06:44:57', NULL),
(39, 'Elite MA', NULL, 6, 'percentage', 'indirect', 7, 3, NULL, '2023-01-29 06:45:11', NULL),
(40, 'Grand MA', NULL, 6, 'percentage', 'indirect', 7, 4, NULL, '2023-01-29 06:45:27', NULL),
(41, 'District Leader', NULL, 6, 'percentage', 'indirect', 7, 5, NULL, '2023-01-29 06:45:41', NULL),
(42, 'Regional Leader', NULL, 6, 'percentage', 'indirect', 7, 6, NULL, '2023-01-29 06:46:03', '2023-01-29 06:46:03');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mlm_types`
--

CREATE TABLE `mlm_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `mlm_types`
--

INSERT INTO `mlm_types` (`id`, `name`, `class`, `slug`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Licensed', 'badge-soft-primary', 'licensed', NULL, NULL, NULL),
(2, 'Non-Licensed', 'badge-soft-warning', 'non-licensed', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT 'user' COMMENT 'user: Thành viên, customer: Khách hàng, admin: Quản lý',
  `birthday` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `bank_info` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`bank_info`)),
  `qrcode` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`qrcode`)),
  `_lft` int(11) DEFAULT NULL,
  `_rgt` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `is_suppend` enum('0','1') DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `mlm_level_id` bigint(20) UNSIGNED DEFAULT NULL,
  `mlm_type_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `first_name`, `middle_name`, `last_name`, `phone`, `email`, `username`, `password`, `type`, `birthday`, `gender`, `thumbnail`, `address`, `token`, `code`, `parent_id`, `bank_info`, `qrcode`, `_lft`, `_rgt`, `status`, `created_at`, `updated_at`, `email_verified_at`, `is_suppend`, `deleted_at`, `mlm_level_id`, `mlm_type_id`) VALUES
(4, 'Admin', 'Seniority', 'System', '(215) 125-1251', 'anhnnd.hotro@gmail.com', 'tinidev', 'e10adc3949ba59abbe56e057f20f883e', 'admin', NULL, NULL, 'maXNhLtMB2.jpg', NULL, 'e10adc3949ba59abbe56e057f20f883e', NULL, NULL, NULL, NULL, NULL, NULL, 'active', '2023-01-27 01:07:16', '2023-01-28 07:27:15', NULL, '0', NULL, NULL, NULL),
(13, 'Root', 'Seniority', 'System', '(714) 478-5898', 'root.seniority@yahoo.com', 'root', 'fb9947e60e77d239b72b3f795f8bfd96', 'user', NULL, NULL, 'default.png', NULL, 'bd00ec9f6388cb341d9dfd71c4fa4b4e', 'SM600568', NULL, NULL, NULL, 1, 2, 'active', '2023-01-29 08:16:49', '2023-01-29 08:52:55', NULL, '0', NULL, 14, 2);

--
-- Chỉ mục cho các bảng đã đổ
--

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
-- Chỉ mục cho bảng `mlm_levels`
--
ALTER TABLE `mlm_levels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mlm_levels_mlm_type_id_foreign` (`mlm_type_id`);

--
-- Chỉ mục cho bảng `mlm_level_settings`
--
ALTER TABLE `mlm_level_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mlm_level_settings_mlm_level_id_foreign` (`mlm_level_id`),
  ADD KEY `mlm_level_settings_mlm_indirect_level_id_foreign` (`mlm_indirect_level_id`);

--
-- Chỉ mục cho bảng `mlm_types`
--
ALTER TABLE `mlm_types`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_mlm_level_id_foreign` (`mlm_level_id`),
  ADD KEY `users_mlm_type_id_foreign` (`mlm_type_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT cho bảng `mlm_levels`
--
ALTER TABLE `mlm_levels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `mlm_level_settings`
--
ALTER TABLE `mlm_level_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT cho bảng `mlm_types`
--
ALTER TABLE `mlm_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `mlm_levels`
--
ALTER TABLE `mlm_levels`
  ADD CONSTRAINT `mlm_levels_mlm_type_id_foreign` FOREIGN KEY (`mlm_type_id`) REFERENCES `mlm_types` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `mlm_level_settings`
--
ALTER TABLE `mlm_level_settings`
  ADD CONSTRAINT `mlm_level_settings_mlm_indirect_level_id_foreign` FOREIGN KEY (`mlm_indirect_level_id`) REFERENCES `mlm_levels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mlm_level_settings_mlm_level_id_foreign` FOREIGN KEY (`mlm_level_id`) REFERENCES `mlm_levels` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_mlm_level_id_foreign` FOREIGN KEY (`mlm_level_id`) REFERENCES `mlm_levels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_mlm_type_id_foreign` FOREIGN KEY (`mlm_type_id`) REFERENCES `mlm_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

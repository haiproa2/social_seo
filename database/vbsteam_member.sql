-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2017 at 05:18 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vbsteam_member`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2017_07_17_164112_addColumnUser', 2),
(4, '2017_07_17_164219_createOptionsTable', 2),
(5, '2017_07_21_233236_entrust_setup_tables', 3),
(6, '2017_07_24_214449_createDetailTable', 4),
(7, '2017_07_25_111830_createPageTable', 5),
(8, '2017_07_26_221242_createPostsTable', 6),
(12, '2017_08_01_111736_create_cronjobs_table', 8),
(11, '2017_07_27_232232_CreateCatePostTable', 7),
(13, '2017_08_12_122305_create_cronjob_results_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(69, 'd_role', 'Deletes Role', 'Xóa nhóm thành viên', '2017-07-23 09:11:14', '2017-07-23 09:11:14'),
(70, 'u_role', 'Update Role', 'Chỉnh sửa nhóm thành viên', '2017-07-23 09:11:14', '2017-07-23 09:11:14'),
(71, 'c_role', 'Create Role', 'Tạo mới nhóm thành viên', '2017-07-23 09:11:14', '2017-07-23 09:11:14'),
(72, 'v_role', 'View Role', 'Xem nhóm thành viên', '2017-07-23 09:11:14', '2017-07-23 09:11:14'),
(73, 'd_config', 'Deletes Config', 'Xóa thông tin công ty', '2017-07-24 15:54:52', '2017-07-24 15:54:52'),
(74, 'u_config', 'Update Config', 'Chỉnh sửa thông tin công ty', '2017-07-24 15:54:52', '2017-07-24 15:54:52'),
(75, 'c_config', 'Create Config', 'Tạo mới thông tin công ty', '2017-07-24 15:54:52', '2017-07-24 15:54:52'),
(76, 'v_config', 'View Config', 'Xem thông tin công ty', '2017-07-24 15:54:52', '2017-07-24 15:54:52'),
(64, 'v_user', 'View User', 'Xem thành viên', '2017-07-23 09:08:35', '2017-07-23 09:08:35'),
(63, 'c_user', 'Create User', 'Tạo mới thành viên', '2017-07-23 09:08:35', '2017-07-23 09:08:35'),
(62, 'u_user', 'Update User', 'Chỉnh sửa thành viên', '2017-07-23 09:08:35', '2017-07-23 09:08:35'),
(61, 'd_user', 'Deletes User', 'Xóa thành viên', '2017-07-23 09:08:35', '2017-07-23 09:08:35');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(62, 9),
(63, 9),
(71, 9),
(72, 9),
(76, 3);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(5, 'vip', '<span class="label label-success">VIP 1</span>', 'Nhóm tài khoản trả tiền, được quản lý bài viết, nội dung riêng .\r\n* Giá: 500k/năm\r\n- Tối đa 3 bài viết 1 ngày trên 1 domain.\r\n- Tối đa 5 liên kết trong 1 bài.\r\n- Tối đa 20 domain.', '2017-07-21 09:57:41', '2017-07-22 02:40:54'),
(6, 'special', '<span class="label label-warning">Special</span>', 'Nhóm tài khoản trả tiền, được quản lý bài viết, nội dung riêng. \r\n* Giá: 2tr/năm\r\n- Không giới hạn bài viết.\r\n- Khong giới hạn liên kết.\r\n- Có tài khoản trên tất cả các website.', '2017-07-22 02:36:27', '2017-07-22 02:42:13'),
(1, 'root', '<span class="label label-inverse">Root</span>', 'Nhóm tài khoản quan trọng, không thể xóa.', '2017-07-21 09:56:13', '2017-07-21 09:56:13'),
(2, 'admin', '<span class="label label-important">Administrator</span>', 'Nhóm tài khoản có toàn quyền trên hệ thống.', '2017-07-21 09:56:52', '2017-07-21 09:56:52'),
(3, 'author', '<span class="label label-info">Author</span>', 'Nhóm tài khoản có quyền quản lý dữ liệu trong hệ thống.', '2017-07-21 09:57:17', '2017-07-21 09:57:17'),
(4, 'member', '<span class="label">Member</span>', 'Nhóm tài khoản mới đăng ký, chưa có quyền gì trong trang quản trị.', '2017-07-21 09:57:34', '2017-07-21 09:57:34'),
(9, 'unlimited', '<span class="label label-important">Unlimited</span>', 'Tài khoản VIP, không giới hạn dung lượng, ko giới hạn domain', '2017-07-23 11:18:15', '2017-07-23 11:18:15');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(89, 1),
(90, 2),
(98, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sex` int(11) NOT NULL DEFAULT '0',
  `birthday` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `no` int(11) NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `slug`, `username`, `email`, `password`, `remember_token`, `name`, `telephone`, `photo`, `sex`, `birthday`, `content`, `no`, `created_by`, `updated_by`, `created_at`, `updated_at`, `active`) VALUES
(89, 'quanly-20170101-000001', 'quanly', 'minhhai.dw@gmail.com', '$2y$10$FXRHbD0esH7exMB9ea//DuGup.DI66qybyJ5oWNgoy9vnj02H.yea', 'FvL2oGK3Dxx2V1FzmH6NSZRI5tgaPMf6QF6I080krASDhcj28IeK2NhVqGDb', 'Quản lý', '0936242502', 'users/quanly-20172007234557.jpg', 1, '28 September, 1989', NULL, 1, 89, 89, '2017-06-30 17:00:01', '2017-07-21 15:15:33', 1),
(90, 'admin-20170101-000002', 'admin', 'admin@gmail.com', '$2y$10$GX43zliM.Fb7yBGUL3n2ouH039phfAmc2.TbvyAh.WqubH0XnVp1a', '32fRPYeh107x517m3doVNdp1slVGsQefPgXW5oqP9kYFuLSF12LyabJuEquw', 'Administrator', NULL, 'users/admin-20171308161248.jpg', 0, NULL, NULL, 1, 90, 89, '2017-06-30 17:00:02', '2017-08-13 09:12:48', 1),
(98, 'haiproa2-20170722-094937', 'haiproa2', 'haiproa2@gmail.com', '$2y$10$wT/MkXtD48olcZB/7UNLqe0vN8qDPj0Pz/6m8KvO3uI4Mt5oFHCiq', NULL, 'Trần Thị Mỹ Linh', '0936242503', 'users/haiproa2-20172207094937.jpg', 0, '28 September, 1989', '<p>Account Game</p>', 1, 89, 89, '2017-07-22 02:49:37', '2017-07-22 10:01:59', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

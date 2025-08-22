-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 22, 2025 at 05:36 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_warehouse`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_activation_attempts`
--

CREATE TABLE `auth_activation_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups`
--

CREATE TABLE `auth_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_permissions`
--

CREATE TABLE `auth_groups_permissions` (
  `group_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_users`
--

CREATE TABLE `auth_groups_users` (
  `group_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_logins`
--

CREATE TABLE `auth_logins` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auth_logins`
--

INSERT INTO `auth_logins` (`id`, `ip_address`, `email`, `user_id`, `date`, `success`) VALUES
(1, '::1', 'admin@gmail.com', NULL, '2025-08-21 07:32:31', 0),
(2, '::1', 'admin@gmail.com', NULL, '2025-08-21 07:33:17', 0),
(3, '::1', 'admin@gmail.com', NULL, '2025-08-21 07:33:24', 0),
(4, '::1', 'admin@gmail.com', NULL, '2025-08-21 08:45:13', 0),
(5, '::1', 'coba@gmail.com', NULL, '2025-08-21 08:55:45', 0),
(6, '::1', 'coba@gmail.com', NULL, '2025-08-21 10:05:10', 0),
(7, '::1', 'admin@gmail.com', NULL, '2025-08-21 10:05:34', 0),
(8, '::1', 'admin@example.com', NULL, '2025-08-21 10:06:17', 0),
(9, '::1', 'admin', NULL, '2025-08-21 10:06:52', 0),
(10, '::1', 'admin', NULL, '2025-08-21 10:07:30', 0),
(11, '::1', 'admin', NULL, '2025-08-21 10:07:39', 0),
(12, '::1', 'admin', NULL, '2025-08-21 10:09:48', 0),
(13, '::1', 'admin', NULL, '2025-08-21 10:09:56', 0),
(14, '::1', 'admin', NULL, '2025-08-21 10:10:25', 0),
(15, '::1', 'admin', NULL, '2025-08-21 10:10:35', 0),
(16, '::1', 'admin', NULL, '2025-08-21 10:14:00', 0),
(17, '::1', 'admin', NULL, '2025-08-21 10:14:21', 0),
(18, '::1', 'admin', NULL, '2025-08-21 10:14:32', 0),
(19, '::1', 'admin', NULL, '2025-08-21 10:14:41', 0),
(20, '::1', 'admin', NULL, '2025-08-21 10:18:26', 0),
(21, '::1', 'admin', NULL, '2025-08-21 10:18:43', 0),
(22, '::1', 'admin', NULL, '2025-08-21 11:15:52', 0),
(23, '::1', 'coba@gmail.com', 4, '2025-08-21 11:37:52', 1),
(24, '::1', 'coba@gmail.com', 4, '2025-08-21 11:38:53', 1),
(25, '::1', 'coba@gmail.com', 4, '2025-08-21 11:47:35', 1),
(26, '::1', 'coba@gmail.com', 4, '2025-08-21 12:06:32', 1),
(27, '::1', 'coba@gmail.com', 4, '2025-08-21 12:54:50', 1),
(28, '::1', 'coba@gmail.com', 4, '2025-08-21 13:13:23', 1),
(29, '::1', 'coba2@gmail.com', 6, '2025-08-21 16:13:04', 1),
(30, '::1', 'coba@gmail.com', 4, '2025-08-22 00:16:32', 1),
(31, '::1', 'coba@gmail.com', 4, '2025-08-22 01:48:32', 1);

-- --------------------------------------------------------

--
-- Table structure for table `auth_permissions`
--

CREATE TABLE `auth_permissions` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_reset_attempts`
--

CREATE TABLE `auth_reset_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_tokens`
--

CREATE TABLE `auth_tokens` (
  `id` int(11) UNSIGNED NOT NULL,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_users_permissions`
--

CREATE TABLE `auth_users_permissions` (
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(3, 'IT EQUIPMENTS'),
(4, 'OFFICE EQUIPMENTS'),
(5, 'SPARE PART'),
(6, 'KENDARAAN DAN ALAT BERAT');

-- --------------------------------------------------------

--
-- Table structure for table `incoming_items`
--

CREATE TABLE `incoming_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `purchase_id` int(11) UNSIGNED DEFAULT NULL,
  `product_id` int(10) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `quantity` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `incoming_items`
--

INSERT INTO `incoming_items` (`id`, `purchase_id`, `product_id`, `date`, `quantity`) VALUES
(13, 7, NULL, '2025-08-22 02:16:00', 10),
(14, 8, NULL, '2025-08-22 02:16:00', 10),
(15, 9, NULL, '2025-08-22 02:16:00', 10),
(16, 10, NULL, '2025-08-22 02:16:00', 10);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2025-08-21-031740', 'App\\Database\\Migrations\\CreateWarehouseTables', 'default', 'App', 1755746372, 1),
(2, '2025-08-21-223112', 'App\\Database\\Migrations\\CreateAuthTables', 'default', 'App', 1755746373, 1),
(5, '2025-08-21-173823', '\\CreatePurchasesTable', 'default', 'App', 1755798207, 2),
(6, '2025-08-21-173937', '\\CreatePurchaseItemsTable', 'default', 'App', 1755798207, 2);

-- --------------------------------------------------------

--
-- Table structure for table `outgoing_items`
--

CREATE TABLE `outgoing_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  `quantity` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `outgoing_items`
--

INSERT INTO `outgoing_items` (`id`, `product_id`, `date`, `quantity`) VALUES
(3, 14, '2025-08-22 09:19:00', 5);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(50) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `stock` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `code`, `unit`, `stock`) VALUES
(14, 3, 'Laptop Lenovo Thinkpad', 'IT-001', 'Unit', 10),
(15, 3, 'Printer HP LaserJet', 'IT-002', 'Unit', 10),
(16, 3, 'Router TP-Link', 'IT-003', 'Unit', 7),
(17, 4, 'Meja Kantor', 'OF-001', 'Unit', 25),
(18, 4, 'Kursi Ergonomis', 'OF-002', 'Unit', 25),
(19, 4, 'Lemari Arsip', 'OF-003', 'Unit', 17),
(20, 5, 'Ban Truk', 'SP-001', 'Pcs', 50),
(21, 5, 'Oli Mesin', 'SP-002', 'Liter', 105),
(22, 5, 'Aki 12V', 'SP-003', 'Unit', 20),
(23, 6, 'Excavator Komatsu', 'KA-001', 'Unit', 2),
(24, 6, 'Dump Truck Hino', 'KA-002', 'Unit', 8),
(25, 6, 'Forklift Toyota', 'KA-003', 'Unit', 9);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(11) UNSIGNED NOT NULL,
  `vendor_name` varchar(255) NOT NULL,
  `vendor_address` text DEFAULT NULL,
  `purchase_date` datetime NOT NULL,
  `buyer_name` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `vendor_name`, `vendor_address`, `purchase_date`, `buyer_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7, 'PT Teknologi Nusantara', 'Jl. Sudirman No. 45, Jakarta', '2025-08-01 10:30:00', 'Asrofi', '2025-08-22 09:05:08', '2025-08-22 02:15:43', NULL),
(8, 'CV Maju Bersama', 'Jl. Raya Merdeka No. 21, Palembang', '2025-08-05 14:15:00', 'Rizky', '2025-08-22 09:05:08', '2025-08-22 02:15:34', NULL),
(9, 'PT Sparepart Jaya', 'Jl. Industri No. 77, Bandung', '2025-08-10 09:45:00', 'Dewi', '2025-08-22 09:05:08', '2025-08-22 02:16:08', NULL),
(10, 'CV Alat Berat Sentosa', 'Jl. Gatot Subroto No. 99, Medan', '2025-08-15 11:20:00', 'Andi', '2025-08-22 09:05:08', '2025-08-22 02:16:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_items`
--

CREATE TABLE `purchase_items` (
  `id` int(11) UNSIGNED NOT NULL,
  `purchase_id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `quantity` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_items`
--

INSERT INTO `purchase_items` (`id`, `purchase_id`, `product_id`, `quantity`) VALUES
(23, 8, 17, 5),
(24, 8, 19, 5),
(25, 7, 14, 5),
(26, 7, 15, 5),
(27, 9, 21, 5),
(28, 9, 22, 5),
(29, 10, 24, 5),
(30, 10, 25, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `reset_hash` varchar(255) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `activate_hash` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `force_pass_reset` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password_hash`, `reset_hash`, `reset_at`, `reset_expires`, `activate_hash`, `status`, `status_message`, `active`, `force_pass_reset`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 'coba@gmail.com', 'coba', '$2y$10$hnaSpyTPPOyTCv7gv30E4uFI7wGWFZtM.UG55ywdZ58Ysz/szYp2q', NULL, NULL, NULL, 'df0b8222436760c59f46d85a0afcb30f', NULL, NULL, 1, 0, '2025-08-21 11:37:04', '2025-08-21 11:37:04', NULL),
(6, 'coba2@gmail.com', 'coba2', '$2y$10$gx85aVkrD8iPSUQxf9unu.dqO7A8fDoErcUT02CqXoOLQqXkmGkce', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-08-21 16:10:20', '2025-08-21 16:10:20', NULL),
(7, 'admin@gmail.com', 'admin', '$2y$10$tqsq/p4SkZh1FvaPWN9qhOEJAgLSBouAkTGiLyjDWY2H8wibslYjO', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-08-22 02:43:27', '2025-08-22 02:58:07', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_activation_attempts`
--
ALTER TABLE `auth_activation_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_groups`
--
ALTER TABLE `auth_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_groups_permissions`
--
ALTER TABLE `auth_groups_permissions`
  ADD KEY `auth_groups_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `group_id_permission_id` (`group_id`,`permission_id`);

--
-- Indexes for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD KEY `auth_groups_users_user_id_foreign` (`user_id`),
  ADD KEY `group_id_user_id` (`group_id`,`user_id`);

--
-- Indexes for table `auth_logins`
--
ALTER TABLE `auth_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `auth_permissions`
--
ALTER TABLE `auth_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_reset_attempts`
--
ALTER TABLE `auth_reset_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_tokens_user_id_foreign` (`user_id`),
  ADD KEY `selector` (`selector`);

--
-- Indexes for table `auth_users_permissions`
--
ALTER TABLE `auth_users_permissions`
  ADD KEY `auth_users_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `user_id_permission_id` (`user_id`,`permission_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incoming_items`
--
ALTER TABLE `incoming_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `outgoing_items`
--
ALTER TABLE `outgoing_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_items_purchase_id_foreign` (`purchase_id`),
  ADD KEY `purchase_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auth_activation_attempts`
--
ALTER TABLE `auth_activation_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_groups`
--
ALTER TABLE `auth_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_logins`
--
ALTER TABLE `auth_logins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `auth_permissions`
--
ALTER TABLE `auth_permissions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_reset_attempts`
--
ALTER TABLE `auth_reset_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `incoming_items`
--
ALTER TABLE `incoming_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `outgoing_items`
--
ALTER TABLE `outgoing_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `purchase_items`
--
ALTER TABLE `purchase_items`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_groups_permissions`
--
ALTER TABLE `auth_groups_permissions`
  ADD CONSTRAINT `auth_groups_permissions_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_groups_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD CONSTRAINT `auth_groups_users_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD CONSTRAINT `auth_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_users_permissions`
--
ALTER TABLE `auth_users_permissions`
  ADD CONSTRAINT `auth_users_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_users_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `outgoing_items`
--
ALTER TABLE `outgoing_items`
  ADD CONSTRAINT `outgoing_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD CONSTRAINT `purchase_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchase_items_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

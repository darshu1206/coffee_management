-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2025 at 11:01 AM
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
-- Database: `coffee_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('coffeeshop-cache-darshana@gmail.com|127.0.0.1', 'i:1;', 1754297460),
('coffeeshop-cache-darshana@gmail.com|127.0.0.1:timer', 'i:1754297460;', 1754297460),
('coffeeshop-cache-darshanagohil0@gmail.com|127.0.0.1', 'i:2;', 1754297465),
('coffeeshop-cache-darshanagohil0@gmail.com|127.0.0.1:timer', 'i:1754297465;', 1754297465);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `coffee_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `coffee_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(5, 3, 1, 1, 18.99, '2025-07-31 11:33:18', '2025-07-31 11:33:18'),
(6, 3, 3, 1, 16.75, '2025-07-31 11:33:26', '2025-07-31 11:33:26'),
(7, 3, 6, 1, 15.50, '2025-07-31 11:35:02', '2025-07-31 11:35:02'),
(8, 3, 5, 1, 21.00, '2025-07-31 11:35:15', '2025-07-31 11:35:15');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `image_url`, `created_at`, `updated_at`) VALUES
(1, 'Espresso', 'Strong, concentrated coffee', 'category_1.png', '2025-07-17 10:54:12', '2025-07-17 10:54:12'),
(2, 'Americano', 'Espresso with hot water', 'category_2.png', '2025-07-17 10:54:12', '2025-07-17 10:54:12'),
(3, 'Latte', 'Espresso with steamed milk', 'category_3.png', '2025-07-17 10:54:12', '2025-07-17 10:54:12'),
(4, 'Cappuccino', 'Espresso with steamed milk and foam', 'category_4.png', '2025-07-17 10:54:12', '2025-07-17 10:54:12'),
(5, 'Cold Brew', 'Coffee brewed with cold water', 'category_5.png', '2025-07-17 10:54:12', '2025-07-17 10:54:12'),
(6, 'Mocha', 'combines espresso, steamed milk, and chocolate', 'category_20250804_080402.png', '2025-08-04 02:34:02', '2025-08-04 02:34:02');

-- --------------------------------------------------------

--
-- Table structure for table `coffees`
--

CREATE TABLE `coffees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(8,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `roast_level` enum('light','medium','dark') NOT NULL DEFAULT 'medium',
  `origin` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coffees`
--

INSERT INTO `coffees` (`id`, `name`, `description`, `price`, `stock_quantity`, `category_id`, `supplier_id`, `roast_level`, `origin`, `image_url`, `created_at`, `updated_at`) VALUES
(1, 'Colombian Supremo', 'Premium Colombian coffee with rich flavor', 299.00, 50, 1, 1, 'medium', 'Colombia', 'coffee_1.jpg', '2025-07-17 10:54:12', '2025-08-03 10:48:03'),
(2, 'Ethiopian Yirgacheffe', 'Floral and citrusy Ethiopian coffee', 449.00, 30, 2, 2, 'light', 'Ethiopia', 'coffee_2.png', '2025-07-17 10:54:12', '2025-08-03 10:47:53'),
(3, 'Brazilian Santos', 'Smooth and balanced Brazilian coffee', 349.00, 75, 3, 3, 'medium', 'Brazil', 'coffee_3.JPG', '2025-07-17 10:54:12', '2025-08-03 10:47:44'),
(4, 'Colombian Decaf', 'Decaffeinated Colombian coffee', 419.00, 25, 1, 1, 'medium', 'Colombia', 'coffee_4.png', '2025-07-17 10:54:12', '2025-08-03 10:47:34'),
(5, 'Ethiopian Sidamo', 'Wine-like Ethiopian coffee', 419.00, 11, 4, 2, 'dark', 'Ethiopia', 'coffee_5.png', '2025-07-17 10:54:12', '2025-08-03 10:47:23'),
(6, 'Brazilian Cold Brew', 'Perfect for cold brewing', 599.00, 5, 5, 3, 'medium', 'Brazil', 'coffee_6.jpeg', '2025-07-17 10:54:12', '2025-08-03 10:47:14'),
(7, 'Mocha Coffee', 'A rich and indulgent blend of coffee and chocolate flavors, Mocha Coffee offers a smooth texture with a slightly sweet finish - perfect for those who enjoy a dessert-like coffee experience.', 249.00, 20, 6, 3, 'medium', 'Ethiopia', 'coffee_20250804_081945.png', '2025-08-04 02:49:45', '2025-08-04 02:49:45');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `loyalty_points` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `address`, `date_of_birth`, `loyalty_points`, `created_at`, `updated_at`) VALUES
(1, 'John Doe', 'john@example.com', '+1-555-123-4567', '123 Main St, City, State', '1985-05-15', 250, '2025-07-17 10:54:12', '2025-07-17 10:54:12'),
(2, 'Jane Smith', 'jane@example.com', '+1-555-987-6543', '456 Oak Ave, City, State', '1990-08-22', 180, '2025-07-17 10:54:12', '2025-07-17 10:54:12'),
(3, 'Bob Johnson', 'bob@example.com', '+1-555-456-7890', '789 Pine Rd, City, State', '1982-12-10', 320, '2025-07-17 10:54:12', '2025-07-17 10:54:12');

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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(10, '0001_01_01_000000_create_users_table', 1),
(11, '0001_01_01_000001_create_cache_table', 1),
(12, '0001_01_01_000002_create_jobs_table', 1),
(13, '2025_07_17_160225_create_categories_table', 1),
(14, '2025_07_17_160411_create_suppliers_table', 1),
(15, '2025_07_17_160451_create_customers_table', 1),
(16, '2025_07_17_160532_create_coffees_table', 1),
(17, '2025_07_17_160611_create_orders_table', 1),
(18, '2025_07_17_160645_create_order_items_table', 1),
(19, '2025_07_27_165536_create_carts_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','completed','cancelled') NOT NULL DEFAULT 'pending',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `delivery_address` text DEFAULT NULL,
  `payment_method` enum('cash','card','online') NOT NULL DEFAULT 'cash',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `total_amount`, `status`, `order_date`, `delivery_address`, `payment_method`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 947.00, 'completed', '2025-07-16 10:54:12', '123 Main St, City, State', 'card', 'Please deliver in the morning', '2025-07-17 10:54:12', '2025-07-17 10:54:12'),
(2, 2, 449.00, 'pending', '2025-07-17 07:54:12', '456 Oak Ave, City, State', 'online', NULL, '2025-07-17 10:54:12', '2025-08-03 10:05:14'),
(3, 3, 1616.00, 'pending', '2025-07-17 10:24:12', '789 Pine Rd, City, State', 'cash', 'Call before delivery', '2025-07-17 10:54:12', '2025-07-17 10:54:12'),
(4, 1, 1117.00, 'completed', '2025-07-12 10:54:12', '123 Main St, City, State', 'card', NULL, '2025-07-17 10:54:12', '2025-07-17 10:54:12'),
(5, 2, 299.00, 'completed', '2025-07-07 10:54:12', '456 Oak Ave, City, State', 'online', NULL, '2025-07-17 10:54:12', '2025-07-17 10:54:12');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `coffee_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `coffee_id`, `quantity`, `price`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 299.00, 598.00, '2025-07-17 10:54:12', '2025-07-17 10:54:12'),
(2, 1, 3, 1, 349.00, 349.00, '2025-07-17 10:54:12', '2025-07-17 10:54:12'),
(3, 2, 2, 1, 449.00, 449.00, '2025-07-17 10:54:12', '2025-07-17 10:54:12'),
(4, 3, 1, 1, 299.00, 299.00, '2025-07-17 10:54:12', '2025-07-17 10:54:12'),
(5, 3, 2, 2, 449.00, 898.00, '2025-07-17 10:54:12', '2025-07-17 10:54:12'),
(6, 3, 4, 1, 419.00, 419.00, '2025-07-17 10:54:12', '2025-07-17 10:54:12'),
(7, 4, 3, 2, 349.00, 698.00, '2025-07-17 10:54:12', '2025-07-17 10:54:12'),
(8, 4, 5, 1, 419.00, 419.00, '2025-07-17 10:54:12', '2025-07-17 10:54:12'),
(9, 5, 1, 1, 299.00, 299.00, '2025-07-17 10:54:12', '2025-07-17 10:54:12');

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
('darshanagohil0@gmail.com', '$2y$12$fhR1Dz/JRtm9UziHBr9V1ODLkPUKldnAWlxo4KMn4DGWoiifIyEJa', '2025-07-31 11:28:26');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('4TIxabjkpsQrJSCX71YcDQ7dxI5Hf1wo9OuTXcGx', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVXNJNWd0d3JOV2tJblJjdnVhVVFIU1Q2TG1hd0F0VDBKa3A1QURYVCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1754290372),
('Dmx9phCFjfNQSd5ay9wqbScSNa2RkPYO1CZVIvZG', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiWFhPNlJwY01mSGoyMURSbENJeEVndDZmZVhNS3FqNTk0bXdzamdWWiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjIxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO30=', 1754290322),
('rqkW8noX8QiOl0IDDP7TCxkH6jX6VLjXZpIO4r5M', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiM2F4MHRBellNaVJ5RVlIcDFSdERhcjdlbThFcmY5TW9XbDF6cE1sTCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMwOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvb3JkZXJzLzMiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO30=', 1754297725);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `country` varchar(255) NOT NULL,
  `rating` decimal(2,1) NOT NULL DEFAULT 0.0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `contact_person`, `email`, `phone`, `address`, `country`, `rating`, `created_at`, `updated_at`) VALUES
(1, 'Colombian Coffee Co.', 'Juan Rodriguez', 'juan@colombiancoffee.com', '+57-1-234-5678', '123 Coffee St, Bogotá', 'Colombia', 4.5, '2025-07-17 10:54:12', '2025-07-17 10:54:12'),
(2, 'Ethiopian Highlands', 'Abebe Kebede', 'abebe@ethiopianhighlands.com', '+251-11-123-4567', '456 Bean Ave, Addis Ababa', 'Ethiopia', 4.8, '2025-07-17 10:54:12', '2025-07-17 10:54:12'),
(3, 'Brazilian Beans Ltd', 'Maria Santos', 'maria@brazilianbeans.com', '+55-11-9876-5432', '789 Santos Port, São Paulo', 'Brazil', 4.3, '2025-07-17 10:54:12', '2025-07-17 10:54:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Rutvik', 'rutvikkachela@gmail.com', NULL, '$2y$12$E0/eQLa.FjrFRTHv.xWkSutnnSc4qN1EXdCRgHYvlg3N3CW9u92dG', NULL, '2025-07-17 10:55:34', '2025-08-03 12:01:52'),
(3, 'Anirudh', 'anirudhkachela@gmail.com', NULL, '$2y$12$FTaQNH.fnYbEzN.ZLaDUw.EF9E4IyhF4Rc1nS4D9lO4m6XglNG26y', 'saOHd6yABNK5zhIzexzniW6XPLwpvoDEZal8aNUf5cfVyIyyRm6mAAx18QeS', '2025-07-31 11:26:11', '2025-07-31 11:26:11'),
(4, 'Admin User', 'admin@coffeeshop.com', NULL, '$2y$12$zH7wPQkKJBekZ2ObWzNN7uA1OPBTef54fw7unPEKUg9a/j28xRv4C', NULL, '2025-08-03 03:22:26', '2025-08-04 00:27:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `carts_user_id_coffee_id_unique` (`user_id`,`coffee_id`),
  ADD KEY `carts_coffee_id_foreign` (`coffee_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coffees`
--
ALTER TABLE `coffees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coffees_category_id_foreign` (`category_id`),
  ADD KEY `coffees_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_coffee_id_foreign` (`coffee_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `suppliers_email_unique` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `coffees`
--
ALTER TABLE `coffees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_coffee_id_foreign` FOREIGN KEY (`coffee_id`) REFERENCES `coffees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `coffees`
--
ALTER TABLE `coffees`
  ADD CONSTRAINT `coffees_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coffees_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_coffee_id_foreign` FOREIGN KEY (`coffee_id`) REFERENCES `coffees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

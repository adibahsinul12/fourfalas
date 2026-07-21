-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 21, 2026 at 12:46 PM
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
-- Database: `fourfalas`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` tinyint(4) NOT NULL,
  `username` char(20) NOT NULL,
  `password_hash` char(60) NOT NULL,
  `role` enum('Admin','Kasir','Owner') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password_hash`, `role`) VALUES
(1, 'admin', '$2y$10$znWq9pe0Q3chEokxrI1BIuUwgCGr1mjDO1HR7EjmwXgy0Un4XKiYi', 'Admin'),
(2, 'owner', '$2y$10$M8JJwCr0Q6WVp8d85R7qA.lJG4rHbLuBtQlUuGQxeUuf3g8Hd5sG2', 'Owner'),
(3, 'rizsa', '$2y$10$qoun5FElTSlQjK53C2HXX.Mz.V1SkBT1R8YPq7O9WIeC5t3S3Mvja', 'Kasir');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` tinyint(4) NOT NULL,
  `parent_type` enum('Makanan','Minuman') NOT NULL,
  `category_name` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_type`, `category_name`) VALUES
(1, 'Makanan', 'Snack'),
(2, 'Minuman', 'Teh'),
(3, 'Makanan', 'Ayam & Seafood'),
(4, 'Makanan', 'Aneka Mie'),
(5, 'Makanan', 'Dessert / Es Krim'),
(6, 'Makanan', 'Aneka Nasi'),
(7, 'Makanan', 'Western Food'),
(8, 'Makanan', 'Paket Menu'),
(9, 'Makanan', 'Sup & Berkuah'),
(10, 'Minuman', 'Minuman Segar'),
(11, 'Minuman', 'Signature Drink'),
(12, 'Minuman', 'Frappe Series'),
(13, 'Minuman', 'Minuman Tradisional');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `bidang` enum('Waiters','Barista','Asisten Koki','Koki') NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('Aktif','Nonaktif') NOT NULL DEFAULT 'Aktif',
  `tanggal_masuk` date NOT NULL,
  `gaji` decimal(12,2) DEFAULT 0.00,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id`, `nama`, `bidang`, `no_hp`, `email`, `alamat`, `foto`, `status`, `tanggal_masuk`, `gaji`, `created_at`, `updated_at`) VALUES
(1, 'Budi Santoso', 'Barista', '081234567890', NULL, NULL, NULL, 'Aktif', '2024-01-15', 2500000.00, '2026-07-01 21:10:38', '2026-07-01 21:10:38'),
(2, 'Siti Aminah', 'Waiters', '081234567891', NULL, NULL, NULL, 'Aktif', '2024-02-01', 2200000.00, '2026-07-01 21:10:38', '2026-07-01 21:10:38'),
(3, 'Andi Wijaya', 'Koki', '081234567892', NULL, NULL, NULL, 'Aktif', '2023-11-10', 3000000.00, '2026-07-01 21:10:38', '2026-07-01 21:10:38'),
(4, 'Dewi Lestari', 'Asisten Koki', '081234567893', NULL, NULL, NULL, 'Aktif', '2024-03-05', 2400000.00, '2026-07-01 21:10:38', '2026-07-01 21:10:38');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(150) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `poin` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `tanggal_gabung` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `nama`, `no_hp`, `email`, `poin`, `tanggal_gabung`, `updated_at`) VALUES
(1, 'Budi Santoso', '0813-2211-4455', 'budisantoso@gmail.com', 45, '2026-06-20 14:30:00', NULL),
(2, 'Siti Rahma', '0857-9988-1122', NULL, 300, '2026-05-15 09:15:00', NULL),
(3, 'Andi Pratama', '0821-6677-3344', 'andi.pratama@yahoo.com', 0, '2026-06-29 16:45:00', NULL),
(4, 'Dewi Lestari', '0878-1122-9900', 'dewi.lestari@gmail.com', 75, '2026-04-02 11:20:00', NULL),
(5, 'Rizky Ramadhan', '0895-4433-7788', NULL, 10, '2026-06-30 08:05:00', NULL),
(6, 'Cinta', '08987652421', 'cinta@gmail.com', 0, '2026-07-02 02:23:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` smallint(6) NOT NULL,
  `category_id` tinyint(4) NOT NULL,
  `menu_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` tinytext DEFAULT NULL,
  `is_recommended` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `requested_by` smallint(6) DEFAULT NULL,
  `approved_by` smallint(6) DEFAULT NULL,
  `rejected_reason` varchar(255) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `category_id`, `menu_name`, `description`, `image_path`, `is_recommended`, `is_active`, `status`, `requested_by`, `approved_by`, `rejected_reason`, `approved_at`) VALUES
(1, 2, 'Jasmine Tea (Manis)', NULL, 'default_menus.jpg', 1, 1, 'approved', NULL, NULL, NULL, '2026-07-05 23:21:41'),
(2, 8, 'Paket Menu Bersama (2 Orang)', NULL, 'default_menus.jpg', 0, 1, 'approved', NULL, NULL, NULL, '2026-07-05 23:21:52'),
(3, 2, 'Blueberry Tea Blended', NULL, 'default_menus.jpg', 0, 1, 'approved', NULL, NULL, NULL, '2026-07-05 23:34:50'),
(5, 2, 'Lemon Tea', NULL, 'default_menus.jpg', 1, 1, 'approved', NULL, NULL, NULL, '2026-07-05 23:36:11'),
(6, 2, 'Milk Tea', NULL, 'default_menus.jpg', 0, 1, 'approved', NULL, NULL, NULL, '2026-07-06 09:26:32');

-- --------------------------------------------------------

--
-- Table structure for table `menu_variants`
--

CREATE TABLE `menu_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` int(11) NOT NULL,
  `variant_name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL DEFAULT 0,
  `stock` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_variants`
--

INSERT INTO `menu_variants` (`id`, `menu_id`, `variant_name`, `price`, `stock`, `created_at`, `updated_at`) VALUES
(9, 2, '-', 120000, 10, '2026-07-02 19:22:52', '2026-07-02 19:22:52'),
(10, 3, 'Es', 13000, 20, '2026-07-02 19:43:01', '2026-07-02 19:43:01'),
(13, 5, 'Es', 10000, 20, '2026-07-05 23:35:53', '2026-07-05 23:35:53'),
(14, 5, 'Panas', 10000, 20, '2026-07-05 23:35:53', '2026-07-05 23:35:53'),
(15, 6, 'Es', 10000, 20, '2026-07-06 09:25:30', '2026-07-06 09:25:30'),
(16, 6, 'Panas', 10000, 20, '2026-07-06 09:25:30', '2026-07-06 09:25:30'),
(21, 1, 'Es', 6000, 20, '2026-07-06 10:56:31', '2026-07-06 10:56:31'),
(22, 1, 'Panas', 7000, 20, '2026-07-06 10:56:31', '2026-07-06 10:56:31');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_number` char(10) NOT NULL,
  `table_id` tinyint(4) NOT NULL,
  `customer_name` tinytext NOT NULL,
  `customer_phone` char(15) DEFAULT NULL,
  `member_id` int(10) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `order_status` enum('Menunggu','Diproses','Siap Diantar','Selesai','Dibatalkan') DEFAULT 'Menunggu',
  `payment_method` enum('Tunai','QRIS','Transfer Bank') DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `tax_amount` decimal(10,2) DEFAULT NULL,
  `total_payment` decimal(10,2) DEFAULT NULL,
  `amount_paid` decimal(10,2) DEFAULT NULL,
  `amount_change` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `table_id`, `customer_name`, `customer_phone`, `member_id`, `notes`, `order_status`, `payment_method`, `subtotal`, `tax_amount`, `total_payment`, `amount_paid`, `amount_change`, `created_at`) VALUES
(1, 'OR7FDF0DB9', 1, 'k', NULL, NULL, '', 'Selesai', 'QRIS', 6000.00, NULL, 6000.00, 6000.00, 0.00, '2026-07-02 11:14:06'),
(2, 'OR27FE2CE1', 1, 'Nara', NULL, NULL, '', 'Selesai', 'QRIS', 10000.00, NULL, 10000.00, 10000.00, 0.00, '2026-07-06 02:27:11'),
(3, 'OR6FAA8FD6', 1, 'Adib Ahsinul Fata', NULL, NULL, '', 'Selesai', 'Transfer Bank', 6000.00, NULL, 6000.00, 6000.00, 0.00, '2026-07-06 03:54:34');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `menu_id` smallint(6) NOT NULL,
  `variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` tinyint(4) NOT NULL,
  `price_at_order` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `menu_id`, `variant_id`, `quantity`, `price_at_order`, `subtotal`) VALUES
(1, 1, 1, NULL, 1, 6000.00, 6000.00),
(2, 2, 6, 15, 1, 10000.00, 10000.00),
(3, 3, 1, NULL, 1, 6000.00, 6000.00);

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` tinyint(4) NOT NULL,
  `banner_path` tinytext NOT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `id_pesanan` int(11) DEFAULT NULL,
  `nama_pelanggan` varchar(100) DEFAULT NULL,
  `rating` tinyint(4) NOT NULL CHECK (`rating` between 1 and 5),
  `komentar` text DEFAULT NULL,
  `tanggal` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`id`, `id_pesanan`, `nama_pelanggan`, `rating`, `komentar`, `tanggal`) VALUES
(1, 1, 'Budi Santoso', 5, 'Makanannya enak banget, pelayanan cepat!', '2026-06-28 14:30:00'),
(2, 2, 'Siti Aminah', 4, 'Kopinya mantap, tempat nyaman.', '2026-06-29 10:15:00'),
(3, 3, 'Andi Wijaya', 3, 'Lumayan, tapi agak lama nunggunya.', '2026-06-30 19:00:00'),
(4, 4, 'Dewi Lestari', 5, NULL, '2026-07-01 08:45:00'),
(5, 5, 'Rian Pratama', 2, 'Rasanya kurang sesuai ekspektasi.', '2026-07-01 20:20:00');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` tinyint(4) NOT NULL,
  `cafe_name` tinytext NOT NULL,
  `logo_path` tinytext DEFAULT NULL,
  `operating_hours_open` time NOT NULL,
  `operating_hours_close` time NOT NULL,
  `service_tax_percent` decimal(4,2) DEFAULT 10.00,
  `contact_info` tinytext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `cafe_name`, `logo_path`, `operating_hours_open`, `operating_hours_close`, `service_tax_percent`, `contact_info`) VALUES
(1, 'FourFalas Cafe & Resto', 'uploads/logo/1782931885_48d59c254a967ed90365.jpeg', '09:00:00', '22:00:00', NULL, 'Jl. Pendidikan No. 04, Sambas, Kalimantan Barat.');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `id` tinyint(4) NOT NULL,
  `table_number` tinyint(4) NOT NULL,
  `capacity` tinyint(4) NOT NULL,
  `type` enum('Reguler','VIP','Lesehan') NOT NULL,
  `status` enum('Tersedia','Terisi') DEFAULT 'Tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`id`, `table_number`, `capacity`, `type`, `status`) VALUES
(1, 1, 4, 'Reguler', 'Tersedia'),
(3, 4, 4, 'Reguler', 'Tersedia'),
(6, 2, 4, 'Reguler', 'Tersedia'),
(10, 3, 4, 'Reguler', 'Tersedia'),
(12, 5, 4, 'Reguler', 'Tersedia'),
(13, 6, 4, 'Reguler', 'Tersedia'),
(14, 7, 4, 'Reguler', 'Tersedia'),
(15, 8, 4, 'Reguler', 'Tersedia'),
(16, 9, 4, 'Reguler', 'Tersedia'),
(17, 10, 4, 'Reguler', 'Tersedia'),
(18, 11, 4, 'Reguler', 'Tersedia'),
(19, 12, 4, 'Reguler', 'Tersedia'),
(20, 13, 4, 'Reguler', 'Tersedia'),
(21, 14, 4, 'Reguler', 'Tersedia'),
(22, 15, 4, 'Reguler', 'Tersedia'),
(23, 16, 4, 'Reguler', 'Tersedia'),
(24, 17, 4, 'Reguler', 'Tersedia'),
(25, 18, 4, 'Reguler', 'Tersedia'),
(26, 19, 4, 'Reguler', 'Tersedia'),
(27, 20, 4, 'Reguler', 'Tersedia'),
(28, 21, 4, 'Reguler', 'Tersedia'),
(29, 22, 4, 'Reguler', 'Tersedia'),
(30, 23, 4, 'Reguler', 'Tersedia'),
(31, 24, 4, 'Reguler', 'Tersedia'),
(32, 25, 4, 'Reguler', 'Tersedia'),
(33, 26, 4, 'Reguler', 'Tersedia'),
(34, 27, 4, 'Reguler', 'Tersedia'),
(35, 28, 4, 'Reguler', 'Tersedia'),
(36, 29, 4, 'Reguler', 'Tersedia'),
(37, 30, 4, 'Reguler', 'Tersedia'),
(38, 31, 4, 'Reguler', 'Tersedia'),
(39, 32, 4, 'Reguler', 'Tersedia'),
(40, 33, 4, 'Reguler', 'Tersedia'),
(41, 34, 4, 'Reguler', 'Tersedia'),
(42, 35, 4, 'Reguler', 'Tersedia'),
(43, 36, 4, 'Reguler', 'Tersedia'),
(44, 37, 4, 'Reguler', 'Tersedia');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_no_hp` (`no_hp`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `menu_variants`
--
ALTER TABLE `menu_variants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD KEY `table_id` (`table_id`),
  ADD KEY `fk_orders_member` (`member_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `menu_id` (`menu_id`),
  ADD KEY `fk_order_items_variants` (`variant_id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `table_number` (`table_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `menu_variants`
--
ALTER TABLE `menu_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_member` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_items_variants` FOREIGN KEY (`variant_id`) REFERENCES `menu_variants` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

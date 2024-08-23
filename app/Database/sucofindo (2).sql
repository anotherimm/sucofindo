-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2024 at 07:56 AM
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
-- Database: `sucofindo`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `kacab`
--

CREATE TABLE `kacab` (
  `id` int(11) NOT NULL,
  `nama_kacab` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kacab`
--

INSERT INTO `kacab` (`id`, `nama_kacab`) VALUES
(1, 'WAHYU');

-- --------------------------------------------------------

--
-- Table structure for table `kepala_bidang`
--

CREATE TABLE `kepala_bidang` (
  `id` int(11) NOT NULL,
  `nama_bidang` varchar(255) NOT NULL,
  `nama_kepala` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kepala_bidang`
--

INSERT INTO `kepala_bidang` (`id`, `nama_bidang`, `nama_kepala`) VALUES
(1, 'DUKBIS', 'apa'),
(2, 'BIU', 'Imam'),
(3, 'BIP', 'Mas BIP'),
(4, 'BIT', 'Mas BIT'),
(5, 'PDO', 'Mas PDO'),
(6, 'KDS', 'Mas KDS'),
(7, 'SRK', 'Mas SRK'),
(8, 'MNGT', 'Mas MNGT');

-- --------------------------------------------------------

--
-- Table structure for table `kontrak`
--

CREATE TABLE `kontrak` (
  `id` int(11) NOT NULL,
  `tambahdata_id` int(11) NOT NULL,
  `nomor_kontrak` varchar(50) NOT NULL,
  `tanggal_kontrak` date NOT NULL,
  `vendor_pemenang` varchar(255) NOT NULL,
  `harga_kontrak` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `spph`
--

CREATE TABLE `spph` (
  `id` int(11) NOT NULL,
  `tambahdata_id` int(11) NOT NULL,
  `nomor_spph` varchar(50) NOT NULL,
  `tanggal_spph` date NOT NULL,
  `nama_vendor1` varchar(255) DEFAULT NULL,
  `nama_vendor2` varchar(255) DEFAULT NULL,
  `nama_vendor3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `status_log`
--

CREATE TABLE `status_log` (
  `id` int(11) NOT NULL,
  `tambahdata_id` int(11) NOT NULL,
  `status_type` enum('tor','budgeting','ppbj','pesan','selesai') NOT NULL,
  `status` enum('pending','syarat_tidak_terpenuhi','diterima') NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suratpesanan`
--

CREATE TABLE `suratpesanan` (
  `id` int(11) NOT NULL,
  `tambahdata_id` int(11) NOT NULL,
  `nomor_pesanan` varchar(50) NOT NULL,
  `tanggal_pesanan` date NOT NULL,
  `harga_pesanan` decimal(15,2) NOT NULL,
  `nama_vendor` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tambahbudget`
--

CREATE TABLE `tambahbudget` (
  `id` int(11) NOT NULL,
  `tambahdata_id` int(11) NOT NULL,
  `tanggal_masuk_budget` date NOT NULL,
  `tanggal_diterima_setelah_budgeting` date NOT NULL,
  `penerima_dokumen_budget` varchar(255) NOT NULL,
  `session_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tambahdata`
--

CREATE TABLE `tambahdata` (
  `id` int(11) NOT NULL,
  `nama_dokumen` varchar(255) NOT NULL,
  `jenis_dokumen` varchar(255) NOT NULL,
  `nama_bidang` varchar(255) NOT NULL,
  `KABID` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status_tor` enum('pending','syarat_tidak_terpenuhi','diterima') DEFAULT 'pending',
  `status_budgeting` enum('pending','syarat_tidak_terpenuhi','diterima') DEFAULT 'pending',
  `status_ppbj` enum('pending','syarat_tidak_terpenuhi','diterima') DEFAULT 'pending',
  `status_pesan` enum('pending','syarat_tidak_terpenuhi','diterima') DEFAULT 'pending',
  `status_selesai` enum('pending','syarat_tidak_terpenuhi','diterima') DEFAULT 'pending',
  `status_umk` enum('pending','syarat_tidak_terpenuhi','diterima') DEFAULT 'pending',
  `status_surat_pesanan` enum('pending','syarat_tidak_terpenuhi','diterima') DEFAULT 'pending',
  `status_spph` enum('pending','syarat_tidak_terpenuhi','diterima') DEFAULT 'pending',
  `status_kontrak` enum('pending','syarat_tidak_terpenuhi','diterima') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tambahppbj`
--

CREATE TABLE `tambahppbj` (
  `id` int(11) NOT NULL,
  `nomor_ppbj` varchar(50) NOT NULL,
  `tanggal_ppbj` date NOT NULL,
  `nilai_ppbj` decimal(15,2) NOT NULL,
  `tanggal_pelimpahan` date NOT NULL,
  `penerima_dokumenppbj` varchar(255) NOT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `tambahdata_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tambahtor`
--

CREATE TABLE `tambahtor` (
  `id` int(11) NOT NULL,
  `tambahdata_id` int(11) NOT NULL,
  `tanggal_dikirim` date NOT NULL,
  `tanggal_diterima` date NOT NULL,
  `penerima_dokumen` varchar(255) NOT NULL,
  `session_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `role`, `created_at`, `updated_at`, `reset_token`, `reset_expires`) VALUES
(1, 'admin@example.com', 'admin', 'sci123', 'admin', '2024-07-25 04:17:22', '2024-07-25 04:17:22', NULL, NULL),
(8, 'imbaay106@gmail.com', 'imam', '$2y$10$RLO72uGFeFpl0PM.itByH.In3SUd3ZrxvbTVt//EK8HdX8CLHS4cW', 'user', '2024-07-31 02:00:09', '2024-08-01 03:43:02', '1c71dc475e59a1f0ab4c634127a3a248d4685e276a2a27f41cf1b8b0807375bcf21efb369868be6fca38ae6cd204949a18fc', '2024-08-01 04:43:02'),
(9, 'imambayhaqi114@gmail.com', 'pegawai', '$2y$10$RA9JAw6lTRBwd2d6okcyN.WvJQWIFVTFcXKK3EOgfWyzwzBexGhO.', 'user', '2024-08-01 03:57:26', '2024-08-01 04:47:40', '63ba257579e34b97a8c905b6fff71006f9a2e459dde15e8aacfb2120750cb2f6ab9c7b475acac8bfbf41b8a243381ca291ba', '2024-08-01 05:47:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_logins`
--
ALTER TABLE `auth_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `kacab`
--
ALTER TABLE `kacab`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kepala_bidang`
--
ALTER TABLE `kepala_bidang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kontrak`
--
ALTER TABLE `kontrak`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tambahdata_id` (`tambahdata_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spph`
--
ALTER TABLE `spph`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tambahdata_id` (`tambahdata_id`);

--
-- Indexes for table `status_log`
--
ALTER TABLE `status_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tambahdata_id` (`tambahdata_id`);

--
-- Indexes for table `suratpesanan`
--
ALTER TABLE `suratpesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tambahdata_id` (`tambahdata_id`);

--
-- Indexes for table `tambahbudget`
--
ALTER TABLE `tambahbudget`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tambahdata_id` (`tambahdata_id`);

--
-- Indexes for table `tambahdata`
--
ALTER TABLE `tambahdata`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tambahppbj`
--
ALTER TABLE `tambahppbj`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tambahdata_id` (`tambahdata_id`);

--
-- Indexes for table `tambahtor`
--
ALTER TABLE `tambahtor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tambahdata_id` (`tambahdata_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auth_logins`
--
ALTER TABLE `auth_logins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kacab`
--
ALTER TABLE `kacab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kepala_bidang`
--
ALTER TABLE `kepala_bidang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kontrak`
--
ALTER TABLE `kontrak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spph`
--
ALTER TABLE `spph`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status_log`
--
ALTER TABLE `status_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suratpesanan`
--
ALTER TABLE `suratpesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tambahbudget`
--
ALTER TABLE `tambahbudget`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tambahdata`
--
ALTER TABLE `tambahdata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tambahppbj`
--
ALTER TABLE `tambahppbj`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tambahtor`
--
ALTER TABLE `tambahtor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kontrak`
--
ALTER TABLE `kontrak`
  ADD CONSTRAINT `kontrak_ibfk_1` FOREIGN KEY (`tambahdata_id`) REFERENCES `tambahdata` (`id`);

--
-- Constraints for table `spph`
--
ALTER TABLE `spph`
  ADD CONSTRAINT `spph_ibfk_1` FOREIGN KEY (`tambahdata_id`) REFERENCES `tambahdata` (`id`);

--
-- Constraints for table `status_log`
--
ALTER TABLE `status_log`
  ADD CONSTRAINT `status_log_ibfk_1` FOREIGN KEY (`tambahdata_id`) REFERENCES `tambahdata` (`id`);

--
-- Constraints for table `suratpesanan`
--
ALTER TABLE `suratpesanan`
  ADD CONSTRAINT `surat_pesanan_ibfk_1` FOREIGN KEY (`tambahdata_id`) REFERENCES `tambahdata` (`id`);

--
-- Constraints for table `tambahbudget`
--
ALTER TABLE `tambahbudget`
  ADD CONSTRAINT `tambahbudget_ibfk_1` FOREIGN KEY (`tambahdata_id`) REFERENCES `tambahdata` (`id`);

--
-- Constraints for table `tambahdata`
--
ALTER TABLE `tambahdata`
  ADD CONSTRAINT `tambahdata_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tambahppbj`
--
ALTER TABLE `tambahppbj`
  ADD CONSTRAINT `tambahppbj_ibfk_1` FOREIGN KEY (`tambahdata_id`) REFERENCES `tambahdata` (`id`);

--
-- Constraints for table `tambahtor`
--
ALTER TABLE `tambahtor`
  ADD CONSTRAINT `tambahtor_ibfk_1` FOREIGN KEY (`tambahdata_id`) REFERENCES `tambahdata` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

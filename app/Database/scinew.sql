-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2024 at 06:37 AM
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
(1, 'HADY SUPRAPTO');

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
(1, 'DUKBIS', 'WAHYUDI'),
(2, 'BIU', 'J. HARI WIBOWO'),
(3, 'BIP', '	WAHYU PRABOWO'),
(4, 'BIT', 'FADHIL'),
(5, 'PDO', 'EDI LAKSONO RIADI'),
(6, 'KDS', 'PURWANTO ANDI MEYANTO'),
(7, 'SRK', 'BADIYONO'),
(8, 'MNGT', '	HADY SUPRAPTO');

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

--
-- Dumping data for table `tambahbudget`
--

INSERT INTO `tambahbudget` (`id`, `tambahdata_id`, `tanggal_masuk_budget`, `tanggal_diterima_setelah_budgeting`, `penerima_dokumen_budget`, `session_id`) VALUES
(33, 25, '2024-08-07', '2024-08-07', 'a', NULL);

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
  `status_kontrak` enum('pending','syarat_tidak_terpenuhi','diterima') DEFAULT 'pending',
  `jumlah` int(11) DEFAULT NULL,
  `harga_satuan` decimal(10,2) DEFAULT NULL,
  `total_harga` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tambahdata`
--

INSERT INTO `tambahdata` (`id`, `nama_dokumen`, `jenis_dokumen`, `nama_bidang`, `KABID`, `tanggal`, `user_id`, `status_tor`, `status_budgeting`, `status_ppbj`, `status_pesan`, `status_selesai`, `status_umk`, `status_surat_pesanan`, `status_spph`, `status_kontrak`, `jumlah`, `harga_satuan`, `total_harga`) VALUES
(24, 'dokumen tes', '', '', '', '0000-00-00', 10, 'pending', 'pending', 'pending', 'pending', 'pending', 'pending', 'pending', 'pending', 'pending', 2, 100.00, 200.00),
(25, 'dokumennya edi', 'FORM KALIBRASI', 'BIU', '	WAHYU PRABOWO', '2024-08-07', 10, 'pending', 'pending', 'pending', 'pending', 'pending', 'pending', 'pending', 'pending', 'pending', 1, 200.00, 200.00);

-- --------------------------------------------------------

--
-- Table structure for table `tambahpenerima`
--

CREATE TABLE `tambahpenerima` (
  `id` int(11) NOT NULL,
  `nama_penerima` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tambahpenerima`
--

INSERT INTO `tambahpenerima` (`id`, `nama_penerima`, `role`) VALUES
(1, 'edi', 'Penerima TOR'),
(7, 'a', 'Penerima Budgeting'),
(8, 'wicoro', 'Penerima PPBJ'),
(9, 'tes', 'Penerima TOR'),
(10, 'b', 'Penerima Budgeting');

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

--
-- Dumping data for table `tambahppbj`
--

INSERT INTO `tambahppbj` (`id`, `nomor_ppbj`, `tanggal_ppbj`, `nilai_ppbj`, `tanggal_pelimpahan`, `penerima_dokumenppbj`, `session_id`, `tambahdata_id`) VALUES
(8, '123abc', '2024-08-07', 345000.00, '2024-08-08', 'wicoro', NULL, 25);

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

--
-- Dumping data for table `tambahtor`
--

INSERT INTO `tambahtor` (`id`, `tambahdata_id`, `tanggal_dikirim`, `tanggal_diterima`, `penerima_dokumen`, `session_id`) VALUES
(23, 25, '2024-08-07', '2024-08-09', 'edi', '');

-- --------------------------------------------------------

--
-- Table structure for table `umk`
--

CREATE TABLE `umk` (
  `id` int(11) NOT NULL,
  `tambahdata_id` int(11) NOT NULL,
  `tanggal_umk` date NOT NULL,
  `harga_umk` decimal(15,2) NOT NULL,
  `vendor_umk` varchar(255) NOT NULL
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
(10, 'ediwicoro26@gmail.com', 'edi', 'edi123', 'user', '2024-08-06 02:53:16', '2024-08-06 02:53:16', NULL, NULL);

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
-- Indexes for table `tambahpenerima`
--
ALTER TABLE `tambahpenerima`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `umk`
--
ALTER TABLE `umk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `umk_ibfk_1` (`tambahdata_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tambahdata`
--
ALTER TABLE `tambahdata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tambahpenerima`
--
ALTER TABLE `tambahpenerima`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tambahppbj`
--
ALTER TABLE `tambahppbj`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tambahtor`
--
ALTER TABLE `tambahtor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `umk`
--
ALTER TABLE `umk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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

--
-- Constraints for table `umk`
--
ALTER TABLE `umk`
  ADD CONSTRAINT `umk_ibfk_1` FOREIGN KEY (`tambahdata_id`) REFERENCES `tambahdata` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

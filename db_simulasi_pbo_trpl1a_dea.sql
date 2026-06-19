-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 19, 2026 at 02:35 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_simulasi_pbo_trpl1a_dea`
--

-- --------------------------------------------------------

--
-- Table structure for table `tabel_pendaftaran`
--

CREATE TABLE `tabel_pendaftaran` (
  `id_pendaftaran` int NOT NULL,
  `nama_calon` varchar(150) NOT NULL,
  `asal_sekolah` varchar(150) NOT NULL,
  `nilai_ujian` decimal(5,2) NOT NULL,
  `biaya_pendaftaran_dasar` decimal(10,2) NOT NULL,
  `jalur_pendaftaran` enum('Reguler','Prestasi','Kedinasan') NOT NULL,
  `pilihan_prodi` varchar(100) DEFAULT NULL,
  `lokasi_kampus` varchar(100) DEFAULT NULL,
  `jenis_prestasi` varchar(100) DEFAULT NULL,
  `tingkat_prestasi` varchar(100) DEFAULT NULL,
  `sk_ikatan_dinas` varchar(100) DEFAULT NULL,
  `instansi_sponsor` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tabel_pendaftaran`
--

INSERT INTO `tabel_pendaftaran` (`id_pendaftaran`, `nama_calon`, `asal_sekolah`, `nilai_ujian`, `biaya_pendaftaran_dasar`, `jalur_pendaftaran`, `pilihan_prodi`, `lokasi_kampus`, `jenis_prestasi`, `tingkat_prestasi`, `sk_ikatan_dinas`, `instansi_sponsor`) VALUES
(1, 'Andi Saputra', 'SMAN 1 Cilacap', '80.50', '200000.00', 'Reguler', 'Teknik Rekayasa Perangkat Lunak', 'Kampus Pusat', NULL, NULL, NULL, NULL),
(2, 'Budi Santoso', 'SMKN 1 Purwokerto', '75.00', '200000.00', 'Reguler', 'Teknik Mesin', 'Kampus Pusat', NULL, NULL, NULL, NULL),
(3, 'Citra Kirana', 'SMAN 2 Semarang', '82.00', '200000.00', 'Reguler', 'Akuntansi', 'Kampus Cabang', NULL, NULL, NULL, NULL),
(4, 'Dodi Setiawan', 'SMAN 3 Yogyakarta', '78.50', '200000.00', 'Reguler', 'Manajemen Bisnis', 'Kampus Pusat', NULL, NULL, NULL, NULL),
(5, 'Eka Safitri', 'SMKN 2 Surakarta', '85.00', '200000.00', 'Reguler', 'Desain Komunikasi Visual', 'Kampus Cabang', NULL, NULL, NULL, NULL),
(6, 'Fajar Ramadhan', 'SMAN 1 Magelang', '77.00', '200000.00', 'Reguler', 'Teknik Sipil', 'Kampus Pusat', NULL, NULL, NULL, NULL),
(7, 'Gita Gutawa', 'SMAN 1 Kebumen', '88.50', '200000.00', 'Reguler', 'Sistem Informasi', 'Kampus Pusat', NULL, NULL, NULL, NULL),
(8, 'Hadi Prasetyo', 'SMAN 1 Banyumas', '92.00', '150000.00', 'Prestasi', NULL, NULL, 'Olimpiade Matematika', 'Nasional', NULL, NULL),
(9, 'Indah Permata', 'SMAN 4 Semarang', '95.50', '150000.00', 'Prestasi', NULL, NULL, 'Lomba Debat Bahasa Inggris', 'Provinsi', NULL, NULL),
(10, 'Joko Anwar', 'SMAN 1 Surakarta', '89.00', '150000.00', 'Prestasi', NULL, NULL, 'Pencak Silat', 'Nasional', NULL, NULL),
(11, 'Kiki Amalia', 'SMAN 2 Tegal', '91.50', '150000.00', 'Prestasi', NULL, NULL, 'Olimpiade Komputer', 'Kabupaten', NULL, NULL),
(12, 'Lestari Ayu', 'SMAN 1 Salatiga', '94.00', '150000.00', 'Prestasi', NULL, NULL, 'Cipta Puisi', 'Nasional', NULL, NULL),
(13, 'Muhammad Ridwan', 'SMKN 1 Cilacap', '90.00', '150000.00', 'Prestasi', NULL, NULL, 'LKS Web Design', 'Provinsi', NULL, NULL),
(14, 'Nadia Saphira', 'SMAN 3 Pekalongan', '96.00', '150000.00', 'Prestasi', NULL, NULL, 'Olimpiade Biologi', 'Internasional', NULL, NULL),
(15, 'Okan Kornelius', 'SMAN 1 Purbalingga', '86.00', '0.00', 'Kedinasan', NULL, NULL, NULL, NULL, 'SK-KED-001', 'Kementerian Keuangan'),
(16, 'Putri Tanjung', 'SMAN 1 Brebes', '87.50', '0.00', 'Kedinasan', NULL, NULL, NULL, NULL, 'SK-KED-002', 'Kementerian Dalam Negeri'),
(17, 'Qori Sandi', 'SMAN 1 Wonosobo', '84.00', '0.00', 'Kedinasan', NULL, NULL, NULL, NULL, 'SK-KED-003', 'Badan Pusat Statistik'),
(18, 'Rafi Ahmad', 'SMAN 2 Pemalang', '88.00', '0.00', 'Kedinasan', NULL, NULL, NULL, NULL, 'SK-KED-004', 'Kementerian Perhubungan'),
(19, 'Sinta Nuriyah', 'SMAN 1 Banjarnegara', '85.50', '0.00', 'Kedinasan', NULL, NULL, NULL, NULL, 'SK-KED-005', 'Badan Siber dan Sandi Negara'),
(20, 'Tegar Septian', 'SMAN 1 Kendal', '83.50', '0.00', 'Kedinasan', NULL, NULL, NULL, NULL, 'SK-KED-006', 'Kementerian Hukum dan HAM');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tabel_pendaftaran`
--
ALTER TABLE `tabel_pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tabel_pendaftaran`
--
ALTER TABLE `tabel_pendaftaran`
  MODIFY `id_pendaftaran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

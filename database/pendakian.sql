-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2024 at 03:48 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pendakian`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `idAdmin` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `no_tlp` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`idAdmin`, `username`, `no_tlp`, `email`, `password`) VALUES
(1, 'admin', '08580987234', 'someone@email.com', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` int(11) NOT NULL,
  `idKetua` int(11) DEFAULT NULL,
  `idKewarganegaraan` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `jenisKelamin` tinyint(1) NOT NULL,
  `no_tlp` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `idKetua`, `idKewarganegaraan`, `nama`, `jenisKelamin`, `no_tlp`) VALUES
(6, 6, 1, 'Dayat', 0, '0876543219'),
(7, 7, 1, 'dayat 2', 0, '0876543219'),
(8, 8, 1, 'ilyas', 0, '0876543219');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `noPesanan` int(11) NOT NULL,
  `idKetua` int(11) DEFAULT NULL,
  `idJadwal` int(11) NOT NULL,
  `tgl_pendakian` date DEFAULT NULL,
  `jumlah_anggota` int(11) DEFAULT NULL,
  `total_pembayaran` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`noPesanan`, `idKetua`, `idJadwal`, `tgl_pendakian`, `jumlah_anggota`, `total_pembayaran`) VALUES
(12, 6, 21, '2024-12-16', 2, 20000.00),
(13, 7, 21, '2024-12-16', 2, 20000.00),
(14, 8, 22, '2024-12-17', 2, 20000.00);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `idJadwal` int(11) NOT NULL,
  `namaGunung` varchar(255) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `kuota` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`idJadwal`, `namaGunung`, `tanggal`, `kuota`) VALUES
(1, 'Buthak', '2024-12-10', 100),
(2, 'Buthak', '2024-12-11', 100),
(3, 'Buthak', '2024-12-12', 100),
(4, 'Buthak', '2024-12-13', 100),
(5, 'Buthak', '2024-12-14', 100),
(6, 'Buthak', '2024-12-15', 100),
(7, 'Buthak', '2024-12-16', 100),
(8, 'Buthak', '2024-12-17', 100),
(9, 'Buthak', '2024-12-18', 100),
(10, 'Buthak', '2024-12-19', 100),
(11, 'Buthak', '2024-12-20', 100),
(12, 'Buthak', '2024-12-21', 100),
(13, 'Buthak', '2024-12-22', 100),
(14, 'Buthak', '2024-12-23', 100),
(15, 'Panderman', '2024-12-10', 100),
(16, 'Panderman', '2024-12-11', 100),
(17, 'Panderman', '2024-12-12', 100),
(18, 'Panderman', '2024-12-13', 100),
(19, 'Panderman', '2024-12-14', 100),
(20, 'Panderman', '2024-12-15', 100),
(21, 'Panderman', '2024-12-16', 100),
(22, 'Panderman', '2024-12-17', 100),
(23, 'Panderman', '2024-12-18', 100),
(24, 'Panderman', '2024-12-19', 100),
(25, 'Panderman', '2024-12-20', 100),
(26, 'Panderman', '2024-12-21', 100),
(27, 'Panderman', '2024-12-22', 100),
(28, 'Panderman', '2024-12-23', 100);

-- --------------------------------------------------------

--
-- Table structure for table `ketua_pendakian`
--

CREATE TABLE `ketua_pendakian` (
  `idKetua` int(11) NOT NULL,
  `idKewarganegaraan` int(11) NOT NULL,
  `noIdentitas` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `jenisKelamin` tinyint(1) NOT NULL,
  `Alamat` text NOT NULL,
  `no_tlp` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `nama_kontak_darurat` varchar(1024) DEFAULT NULL,
  `kontak_darurat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ketua_pendakian`
--

INSERT INTO `ketua_pendakian` (`idKetua`, `idKewarganegaraan`, `noIdentitas`, `nama`, `jenisKelamin`, `Alamat`, `no_tlp`, `email`, `nama_kontak_darurat`, `kontak_darurat`) VALUES
(6, 1, '367890715781', 'Fahmi', 0, 'jl. kauman', '0817964289', 'danugaming@gmail.com', 'Banu', '0816281217890'),
(7, 1, '3567801765432', 'Fajar', 0, 'jl. belakang mesjid', '0817964289', 'Fajar@gmail.com', 'Banu', '0816281217890'),
(8, 1, '367890715781', 'Danu Arta', 0, 'jl. besel', '08767678997', 'danugaming@gmail.com', 'Banu', '0816281217890');

-- --------------------------------------------------------

--
-- Table structure for table `kewarganegaraan`
--

CREATE TABLE `kewarganegaraan` (
  `idKewarganegaraan` int(11) NOT NULL,
  `jenis` varchar(3) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kewarganegaraan`
--

INSERT INTO `kewarganegaraan` (`idKewarganegaraan`, `jenis`, `harga`) VALUES
(1, 'WNI', 10000),
(2, 'WNA', 100000);

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `kodePembayaran` int(11) NOT NULL,
  `idAdmin` int(11) DEFAULT NULL,
  `noPesanan` int(11) DEFAULT NULL,
  `tgl_pembayaran` datetime DEFAULT NULL,
  `status_pembayaran` tinyint(1) DEFAULT NULL,
  `metode_pembayaran` tinyint(1) DEFAULT NULL,
  `buktiPembayaran` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`kodePembayaran`, `idAdmin`, `noPesanan`, `tgl_pembayaran`, `status_pembayaran`, `metode_pembayaran`, `buktiPembayaran`) VALUES
(1, NULL, 12, '2024-12-16 00:00:00', NULL, 0, 'uploads/1.png'),
(2, NULL, 12, '2024-12-16 00:00:00', NULL, 0, 'uploads/1.png'),
(3, NULL, 12, '2024-12-16 00:00:00', NULL, 0, 'uploads/1.png'),
(4, NULL, 12, '2024-12-16 00:00:00', NULL, 0, 'uploads/1.png'),
(5, NULL, 12, '2024-12-16 00:00:00', NULL, 0, 'uploads/1.png'),
(6, NULL, 12, '2024-12-16 00:00:00', NULL, 0, 'uploads/1.png'),
(7, NULL, 12, '2024-12-16 00:00:00', NULL, 0, 'uploads/1.png'),
(8, NULL, 12, '2024-12-16 00:00:00', NULL, 0, 'uploads/1.png'),
(9, NULL, 12, '2024-12-16 00:00:00', NULL, 0, 'uploads/1.png'),
(10, NULL, 12, '2024-12-16 00:00:00', NULL, 0, 'uploads/1.png'),
(11, NULL, 12, '2024-12-16 00:00:00', NULL, 0, 'uploads/1.png'),
(12, NULL, 12, '2024-12-16 00:00:00', NULL, 0, 'uploads/1.png'),
(13, NULL, 12, '2024-12-16 00:00:00', NULL, 0, 'uploads/1.png'),
(14, NULL, 12, '2024-12-16 00:00:00', NULL, 0, 'uploads/1.png'),
(15, NULL, 12, '2024-12-16 00:00:00', NULL, 0, 'uploads/1.png'),
(16, NULL, 12, '2024-12-16 00:00:00', NULL, 0, 'uploads/1.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`idAdmin`);

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`),
  ADD KEY `idKetua` (`idKetua`),
  ADD KEY `idKewarganegaraan` (`idKewarganegaraan`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`noPesanan`),
  ADD KEY `idKetua` (`idKetua`),
  ADD KEY `idJadwal` (`idJadwal`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`idJadwal`);

--
-- Indexes for table `ketua_pendakian`
--
ALTER TABLE `ketua_pendakian`
  ADD PRIMARY KEY (`idKetua`),
  ADD KEY `idKewarganegaraan` (`idKewarganegaraan`);

--
-- Indexes for table `kewarganegaraan`
--
ALTER TABLE `kewarganegaraan`
  ADD PRIMARY KEY (`idKewarganegaraan`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`kodePembayaran`),
  ADD KEY `idAdmin` (`idAdmin`),
  ADD KEY `noPesanan` (`noPesanan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `idAdmin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id_anggota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `noPesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `idJadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `ketua_pendakian`
--
ALTER TABLE `ketua_pendakian`
  MODIFY `idKetua` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kewarganegaraan`
--
ALTER TABLE `kewarganegaraan`
  MODIFY `idKewarganegaraan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `kodePembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anggota`
--
ALTER TABLE `anggota`
  ADD CONSTRAINT `anggota_ibfk_1` FOREIGN KEY (`idKetua`) REFERENCES `ketua_pendakian` (`idKetua`),
  ADD CONSTRAINT `anggota_ibfk_2` FOREIGN KEY (`idKewarganegaraan`) REFERENCES `kewarganegaraan` (`idKewarganegaraan`);

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`idKetua`) REFERENCES `ketua_pendakian` (`idKetua`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`idJadwal`) REFERENCES `jadwal` (`idJadwal`);

--
-- Constraints for table `ketua_pendakian`
--
ALTER TABLE `ketua_pendakian`
  ADD CONSTRAINT `ketua_pendakian_ibfk_1` FOREIGN KEY (`idKewarganegaraan`) REFERENCES `kewarganegaraan` (`idKewarganegaraan`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`idAdmin`) REFERENCES `admin` (`idAdmin`),
  ADD CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`noPesanan`) REFERENCES `booking` (`noPesanan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

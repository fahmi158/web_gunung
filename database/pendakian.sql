-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Des 2024 pada 16.03
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.0.25

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
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `idAdmin` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `no_tlp` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` int(11) NOT NULL,
  `idKetua` int(11) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `no_tip` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `booking`
--

CREATE TABLE `booking` (
  `noPesanan` int(11) NOT NULL,
  `idKetua` int(11) DEFAULT NULL,
  `idJadwal` int(11) NOT NULL,
  `tgl_pendakian` date DEFAULT NULL,
  `jumlah_anggota` int(11) DEFAULT NULL,
  `total_pembayaran` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal`
--

CREATE TABLE `jadwal` (
  `idJadwal` int(11) NOT NULL,
  `namaGunung` varchar(255) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `kuota` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jadwal`
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
-- Struktur dari tabel `ketua_pendakian`
--

CREATE TABLE `ketua_pendakian` (
  `idKetua` int(11) NOT NULL,
  `nik` int(11) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `no_tip` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `nama_kontak_darurat` varchar(1024) DEFAULT NULL,
  `kontak_darurat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kewarganegaraan`
--

CREATE TABLE `kewarganegaraan` (
  `id` int(11) NOT NULL,
  `jenis` varchar(3) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kewarganegaraan`
--

INSERT INTO `kewarganegaraan` (`id`, `jenis`, `harga`) VALUES
(1, 'WNI', 20000),
(2, 'WNA', 200000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `kodePembayaran` int(11) NOT NULL,
  `idAdmin` int(11) DEFAULT NULL,
  `noPesanan` int(11) DEFAULT NULL,
  `tgl_pembayaran` datetime DEFAULT NULL,
  `status_pembayaran` tinyint(1) DEFAULT NULL,
  `metode_pembayaran` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`idAdmin`);

--
-- Indeks untuk tabel `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`),
  ADD KEY `idKetua` (`idKetua`);

--
-- Indeks untuk tabel `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`noPesanan`),
  ADD KEY `idKetua` (`idKetua`),
  ADD KEY `idJadwal` (`idJadwal`);

--
-- Indeks untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`idJadwal`);

--
-- Indeks untuk tabel `ketua_pendakian`
--
ALTER TABLE `ketua_pendakian`
  ADD PRIMARY KEY (`idKetua`);

--
-- Indeks untuk tabel `kewarganegaraan`
--
ALTER TABLE `kewarganegaraan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`kodePembayaran`),
  ADD KEY `idAdmin` (`idAdmin`),
  ADD KEY `noPesanan` (`noPesanan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `idAdmin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id_anggota` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `booking`
--
ALTER TABLE `booking`
  MODIFY `noPesanan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `idJadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `ketua_pendakian`
--
ALTER TABLE `ketua_pendakian`
  MODIFY `idKetua` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kewarganegaraan`
--
ALTER TABLE `kewarganegaraan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `kodePembayaran` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `anggota`
--
ALTER TABLE `anggota`
  ADD CONSTRAINT `anggota_ibfk_1` FOREIGN KEY (`idKetua`) REFERENCES `ketua_pendakian` (`idKetua`);

--
-- Ketidakleluasaan untuk tabel `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`idKetua`) REFERENCES `ketua_pendakian` (`idKetua`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`idJadwal`) REFERENCES `jadwal` (`idJadwal`);

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`idAdmin`) REFERENCES `admin` (`idAdmin`),
  ADD CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`noPesanan`) REFERENCES `booking` (`noPesanan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2024 at 06:57 AM
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
-- Database: `pawangkesehatan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `password`, `username`, `email`) VALUES
(1, '123', 'bintang', 'qwe@gmail.com'),
(8, '$2y$10$eTkYi6Q7ZUq4NNvyWQGzmuwJR7oczyYa77oipMvA7dSb20Uy.Zgw6', '123', '123@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `apotek`
--

CREATE TABLE `apotek` (
  `id_apotek` int(2) NOT NULL,
  `nama_apotek` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `artikel`
--

CREATE TABLE `artikel` (
  `id_artikel` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `judulartikel` varchar(50) NOT NULL,
  `penulisartikel` varchar(30) NOT NULL,
  `isiartikel` varchar(1000) NOT NULL,
  `tanggal` date NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `img_path` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artikel`
--

INSERT INTO `artikel` (`id_artikel`, `id_admin`, `judulartikel`, `penulisartikel`, `isiartikel`, `tanggal`, `kategori`, `img_path`, `slug`) VALUES
(5, 1, 'Apakah Benar Terdapat Senioritas di RSU?', 'Haruno Nakamoto', 'Apakah Terdapat Senioritas di Rumah Sakit Umum (RSU)?\r\n\r\nDi banyak lingkungan kerja, senioritas sering kali menjadi topik yang dibicarakan. Begitu juga di rumah sakit umum (RSU), di mana struktur organisasi dan hierarki penting dalam memastikan kelancaran pelayanan kesehatan. Namun, apakah senioritas di rumah sakit memiliki peran yang signifikan? Mari kita bahas lebih lanjut tentang hal ini.\r\n\r\nApa Itu Senioritas?\r\nSenioritas mengacu pada tingkat pengalaman atau waktu kerja seseorang dalam suatu organisasi yang biasanya memengaruhi tingkat kewenangan, tanggung jawab, dan pengaruh dalam pengambilan keputusan. Di banyak sektor, senioritas bisa menjadi faktor yang menentukan dalam promosi, pemberian tugas, atau keputusan lainnya.\r\n\r\nSenioritas di RSU: Peran dan Pengaruhnya\r\nDi RSU, senioritas memang memiliki peran yang cukup penting, terutama dalam pengaturan struktur organisasi, pengelolaan tim medis, dan kualitas pelayanan. Berikut adalah beberapa aspek di mana senioritas mungkin berper', '2024-12-04', 'Berita', 'img/istockphoto-1567297364-1024x1024.jpg', NULL),
(19, 8, '123', '123', '123', '0000-00-00', '123', '123-908d6d.png', '123-908d6d'),
(20, 8, 'eqw', 'eqw', 'eqw', '0123-03-12', '123', 'uploads/eqw-2ba5bc.png', 'eqw-2ba5bc'),
(21, 8, '123', '12', '3123', '0233-02-11', '123', 'uploads/123-62547c.jpg', '123-62547c');

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `id_obat` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `id_dokter` int(2) NOT NULL,
  `password` varchar(10) NOT NULL,
  `username` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id` int(11) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keranjang`
--

INSERT INTO `keranjang` (`id`, `session_id`, `produk_id`, `id_pengguna`, `jumlah`) VALUES
(27, 'ocqedl6229qfq5jcq8el4on5m4', 2, 10, 2),
(28, 'ocqedl6229qfq5jcq8el4on5m4', 1, 10, 2);

-- --------------------------------------------------------

--
-- Table structure for table `konsultasi`
--

CREATE TABLE `konsultasi` (
  `id_konsultasi` int(2) NOT NULL,
  `id_pengguna` int(2) NOT NULL,
  `id_dokter` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kurir`
--

CREATE TABLE `kurir` (
  `id_kurir` int(2) NOT NULL,
  `nama_kurir` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kwitansi`
--

CREATE TABLE `kwitansi` (
  `id_kwitansi` int(2) NOT NULL,
  `id_pengguna` int(2) NOT NULL,
  `id_kurir` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `msg_id` int(11) NOT NULL,
  `incoming_msg_id` int(255) NOT NULL,
  `outgoing_msg_id` int(255) NOT NULL,
  `msg` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nomor_darurat`
--

CREATE TABLE `nomor_darurat` (
  `id_nomordarurat` int(2) NOT NULL,
  `nama_rs` varchar(25) NOT NULL,
  `nomor_rs` varchar(15) NOT NULL,
  `img_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nomor_darurat`
--

INSERT INTO `nomor_darurat` (`id_nomordarurat`, `nama_rs`, `nomor_rs`, `img_path`) VALUES
(6, '123', '123', '1734924860_Gambar WhatsApp 2024-12-22 pukul 17.10.04_c0e95e85.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id_obat` int(2) NOT NULL,
  `nama_obat` varchar(25) NOT NULL,
  `jenis_obat` varchar(100) NOT NULL,
  `stok` int(11) NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `deskripsi` text NOT NULL,
  `tanggal_ditambahkan` date NOT NULL,
  `img_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id_obat`, `nama_obat`, `jenis_obat`, `stok`, `harga`, `deskripsi`, `tanggal_ditambahkan`, `img_path`) VALUES
(1, '123', '123', 1231, 12312, '3', '3333-11-11', '1734923043_icons8-pill-50.png'),
(2, '123', '123', 123, 123, '123', '0123-03-12', '1734929994_icons8-hospital-sign-50.png');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `img_path` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `password`, `username`, `nama_lengkap`, `img_path`, `status`) VALUES
(13, '$2y$10$pMGPWKTj3iDxBRA8887qH.aHsFyrnnXvRbDbBMyEplkOnGTDOwxCa', 'Rizqi2', 'Rizqi Anugrah2', 'uploads/13_1734761418.jpg', 'Active now'),
(14, '$2y$10$QQL3yWf3rhPXVv2mTUS.Q.L2Yjk/vDIxjlOK7Xf.aQg4VIABk.Qa6', 'bintang', 'Anugrah', 'uploads/14_1734925041.jpg', 'Active now');

-- --------------------------------------------------------

--
-- Table structure for table `pesan`
--

CREATE TABLE `pesan` (
  `id_pesan` int(2) NOT NULL,
  `jumlah` int(3) NOT NULL,
  `id_kwitansi` int(2) NOT NULL,
  `id_sedia` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `no_pesanan` varchar(20) NOT NULL,
  `id_pengguna` varchar(50) NOT NULL,
  `tanggal_pesanan` datetime DEFAULT current_timestamp(),
  `total_pembayaran` decimal(10,2) NOT NULL,
  `status` enum('pending','diproses','dikirim','selesai') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `img-path` varchar(255) NOT NULL,
  `nama_produk` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga` decimal(15,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `img-path`, `nama_produk`, `deskripsi`, `harga`) VALUES
(1, 'Xenical.jpg', 'Xenical 120 mg 21 Kapsul', 'per strip', 378.000),
(2, 'Sistenol.jpg', 'Sistenol 10 Kaplet', 'per botol', 41.000),
(3, 'Farsifen.jpg', 'Farsifen Plus 10 Tablet', 'Per Strip', 13.633);

-- --------------------------------------------------------

--
-- Table structure for table `sedia`
--

CREATE TABLE `sedia` (
  `id_sedia` int(2) NOT NULL,
  `stok` int(3) NOT NULL,
  `id_obat` int(2) NOT NULL,
  `id_apotek` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tombol_darurat`
--

CREATE TABLE `tombol_darurat` (
  `id_tomboldarurat` int(2) NOT NULL,
  `id_pengguna` int(2) NOT NULL,
  `id_nomordarurat` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `apotek`
--
ALTER TABLE `apotek`
  ADD PRIMARY KEY (`id_apotek`);

--
-- Indexes for table `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id_artikel`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_admin_artikel` (`id_admin`);

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_obat` (`id_obat`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id_dokter`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `keranjang_ibfk_2` (`produk_id`);

--
-- Indexes for table `konsultasi`
--
ALTER TABLE `konsultasi`
  ADD PRIMARY KEY (`id_konsultasi`),
  ADD KEY `id_pengguna` (`id_pengguna`),
  ADD KEY `id_dokter` (`id_dokter`);

--
-- Indexes for table `kurir`
--
ALTER TABLE `kurir`
  ADD PRIMARY KEY (`id_kurir`);

--
-- Indexes for table `kwitansi`
--
ALTER TABLE `kwitansi`
  ADD PRIMARY KEY (`id_kwitansi`),
  ADD KEY `id_pengguna` (`id_pengguna`),
  ADD KEY `id_kurir` (`id_kurir`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `nomor_darurat`
--
ALTER TABLE `nomor_darurat`
  ADD PRIMARY KEY (`id_nomordarurat`);

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id_obat`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indexes for table `pesan`
--
ALTER TABLE `pesan`
  ADD PRIMARY KEY (`id_pesan`),
  ADD KEY `id_kwitansi` (`id_kwitansi`),
  ADD KEY `id_sedia` (`id_sedia`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD UNIQUE KEY `no_pesanan` (`no_pesanan`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `sedia`
--
ALTER TABLE `sedia`
  ADD PRIMARY KEY (`id_sedia`),
  ADD KEY `id_obat` (`id_obat`),
  ADD KEY `id_apotek` (`id_apotek`);

--
-- Indexes for table `tombol_darurat`
--
ALTER TABLE `tombol_darurat`
  ADD PRIMARY KEY (`id_tomboldarurat`),
  ADD KEY `id_pengguna` (`id_pengguna`),
  ADD KEY `id_nomordarurat` (`id_nomordarurat`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `apotek`
--
ALTER TABLE `apotek`
  MODIFY `id_apotek` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id_artikel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id_dokter` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `konsultasi`
--
ALTER TABLE `konsultasi`
  MODIFY `id_konsultasi` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kurir`
--
ALTER TABLE `kurir`
  MODIFY `id_kurir` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kwitansi`
--
ALTER TABLE `kwitansi`
  MODIFY `id_kwitansi` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nomor_darurat`
--
ALTER TABLE `nomor_darurat`
  MODIFY `id_nomordarurat` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `id_obat` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pesan`
--
ALTER TABLE `pesan`
  MODIFY `id_pesan` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sedia`
--
ALTER TABLE `sedia`
  MODIFY `id_sedia` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tombol_darurat`
--
ALTER TABLE `tombol_darurat`
  MODIFY `id_tomboldarurat` int(2) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `artikel`
--
ALTER TABLE `artikel`
  ADD CONSTRAINT `fk_admin_artikel` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE;

--
-- Constraints for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`),
  ADD CONSTRAINT `detail_pesanan_ibfk_2` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id_obat`),
  ADD CONSTRAINT `detail_pesanan_ibfk_3` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`);

--
-- Constraints for table `dokter`
--
ALTER TABLE `dokter`
  ADD CONSTRAINT `dokter_ibfk_1` FOREIGN KEY (`id_dokter`) REFERENCES `konsultasi` (`id_dokter`);

--
-- Constraints for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id_produk`);

--
-- Constraints for table `kwitansi`
--
ALTER TABLE `kwitansi`
  ADD CONSTRAINT `kwitansi_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`),
  ADD CONSTRAINT `kwitansi_ibfk_2` FOREIGN KEY (`id_kurir`) REFERENCES `kurir` (`id_kurir`);

--
-- Constraints for table `pesan`
--
ALTER TABLE `pesan`
  ADD CONSTRAINT `pesan_ibfk_1` FOREIGN KEY (`id_kwitansi`) REFERENCES `kwitansi` (`id_kwitansi`),
  ADD CONSTRAINT `pesan_ibfk_2` FOREIGN KEY (`id_sedia`) REFERENCES `sedia` (`id_sedia`);

--
-- Constraints for table `sedia`
--
ALTER TABLE `sedia`
  ADD CONSTRAINT `sedia_ibfk_1` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id_obat`),
  ADD CONSTRAINT `sedia_ibfk_2` FOREIGN KEY (`id_apotek`) REFERENCES `apotek` (`id_apotek`);

--
-- Constraints for table `tombol_darurat`
--
ALTER TABLE `tombol_darurat`
  ADD CONSTRAINT `tombol_darurat_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2023 at 05:54 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tukarsaja`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `foto` longblob NOT NULL,
  `nama_file` varchar(100) NOT NULL,
  `harga` double(18,2) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `deskripsi` varchar(1000) NOT NULL,
  `kondisi` enum('Baru','Jarang Dipakai','Sering Dipakai') NOT NULL,
  `username` varchar(50) NOT NULL,
  `metode` varchar(50) NOT NULL,
  `wishlist` tinyint(1) NOT NULL DEFAULT 0,
  `ketersediaan` tinyint(1) NOT NULL DEFAULT 1,
  `tanggal_upload` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `nama`, `foto`, `nama_file`, `harga`, `id_kategori`, `deskripsi`, `kondisi`, `username`, `metode`, `wishlist`, `ketersediaan`, `tanggal_upload`) VALUES
(9, 'Dress Pink Brukat', '', 'bridey-dresses-for-rent_pink-and-rose-gold_1.jpg', 190000.00, 6, 'bagus bro beli', 'Jarang Dipakai', 'gracia', 'Kirim lewat ekspedisi', 0, 0, '2023-06-13'),
(10, 'novel angkasa', '', 'novel.jpg', 50000.00, 2, 'masih baru sealed ori', 'Baru', 'balqis', 'Ambil di tempat', 0, 0, '2023-06-14'),
(11, 'jam', '', '75e9e9cf-ff30-4528-95bf-c475afb66196.jpg', 20000.00, 3, 'udah sering dipake tp masih bguss', 'Sering Dipakai', 'balqis', 'Kirim lewat ekspedisi', 0, 1, '2023-06-14'),
(12, 'Topi Sulap', '', 'istockphoto-172253818-612x612.jpg', 30000.00, 1, 'rusak dikit sih ini tapi keren bisa sulap', 'Sering Dipakai', 'gracia', 'Kirim lewat ekspedisi', 0, 1, '2023-06-15'),
(13, 'Sepatu roda', '', 'download (1).jpeg', 80000.00, 5, 'Sepatu roda yang sudah tidak muat namun jarang dipakai', 'Jarang Dipakai', 'pelangi', 'Ambil di tempat', 0, 1, '2023-06-15'),
(14, 'Tas hermes Preloved', '', 'download (2).jpeg', 1500000.00, 1, 'Harga beli 10 juta\r\ndijual karena sudah ketinggalan zaman dan bosan', 'Sering Dipakai', 'pelangi', 'Ambil di tempat', 0, 1, '2023-06-15'),
(15, 'Novel Cantik itu Luka', '', 'novel 2.jpeg.jpg', 100000.00, 2, 'buku dari salah satu dari novel dengan penjualan paling laris. Novel ini adalah karya penilis bernama Eka Kurniawan. Novel ini merupakan karya pertamanya dan rilis pertama kali pada tahun 2002 dan berhasil mendapatkan posisi di Khatulistiwa Literary Award tahun 2003. Selain masuk ke dalam daftar Kha', 'Jarang Dipakai', 'isabel', 'Kirim lewat ekspedisi', 0, 1, '2023-06-15'),
(16, 'Celana Rumah', '', 'Kaleidoscope-Stone-Linen-Trousers~20S542FRSP.webp', 50000.00, 6, 'jksjlakjdkldalk', 'Baru', 'isabel', 'Kirim lewat ekspedisi', 0, 1, '2023-06-15');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama`) VALUES
(1, 'Aksesoris'),
(2, 'Buku & Alat Tulis'),
(3, 'Gadget & Elektronik'),
(4, 'Mainan'),
(5, 'Olahraga'),
(6, 'Pakaian');

-- --------------------------------------------------------

--
-- Table structure for table `kesepakatan`
--

CREATE TABLE `kesepakatan` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL DEFAULT current_timestamp(),
  `id_penawaran` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kesepakatan`
--

INSERT INTO `kesepakatan` (`id`, `tanggal`, `id_penawaran`) VALUES
(1, '2023-06-15', 8);

-- --------------------------------------------------------

--
-- Table structure for table `penawaran`
--

CREATE TABLE `penawaran` (
  `id` int(11) NOT NULL,
  `id_barang1` int(11) NOT NULL,
  `id_barang2` int(11) NOT NULL,
  `tambah_harga` double(18,2) NOT NULL DEFAULT 0.00,
  `tanggal` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penawaran`
--

INSERT INTO `penawaran` (`id`, `id_barang1`, `id_barang2`, `tambah_harga`, `tanggal`) VALUES
(1, 10, 9, 0.00, '2023-06-14'),
(3, 11, 9, 0.00, '2023-06-15'),
(7, 9, 13, 100000.00, '2023-06-15'),
(8, 12, 15, 50000.00, '2023-06-15');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `username` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `no_tlp` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`username`, `nama`, `alamat`, `no_tlp`, `email`, `password`) VALUES
('balqis', 'Amalia Balqis', 'Bekasi', '084521875388', 'balqis@tukarsaja.id', 'b4lq1s'),
('fania', 'Khaliza Fania', 'Kosan Balqis', '08212234581', 'khaliza@tukarsaja.id', 'nia123'),
('gracia', 'Gracia Hotmauli', 'Meruyung, Depok', '081948596723', 'gracia@tukarsaja.id', 'gr4ci4'),
('isabel', 'Isabel Rose', 'Radio Dalam', '081242847195', 'isabel@tukarsaja.id', 'is4b3l'),
('pelangi', 'Pelangi Dwi Mawarni', 'Sawangan depok', '081212121343', 'pelangidwi@tukarsaja.id', 'pelangicantik');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kesepakatan`
--
ALTER TABLE `kesepakatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_penawaran` (`id_penawaran`);

--
-- Indexes for table `penawaran`
--
ALTER TABLE `penawaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_barang1` (`id_barang1`),
  ADD KEY `id_barang2` (`id_barang2`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kesepakatan`
--
ALTER TABLE `kesepakatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `penawaran`
--
ALTER TABLE `penawaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`username`) REFERENCES `pengguna` (`username`),
  ADD CONSTRAINT `barang_ibfk_2` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id`);

--
-- Constraints for table `kesepakatan`
--
ALTER TABLE `kesepakatan`
  ADD CONSTRAINT `kesepakatan_ibfk_1` FOREIGN KEY (`id_penawaran`) REFERENCES `penawaran` (`id`);

--
-- Constraints for table `penawaran`
--
ALTER TABLE `penawaran`
  ADD CONSTRAINT `penawaran_ibfk_1` FOREIGN KEY (`id_barang1`) REFERENCES `barang` (`id`),
  ADD CONSTRAINT `penawaran_ibfk_2` FOREIGN KEY (`id_barang2`) REFERENCES `barang` (`id`);

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`),
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`username`) REFERENCES `pengguna` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

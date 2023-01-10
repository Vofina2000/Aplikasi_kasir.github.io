-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 27, 2022 at 08:23 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `belajar_php`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_barang`
--

CREATE TABLE `tbl_barang` (
  `kode_barang` varchar(10) NOT NULL,
  `nama_barang` varchar(30) NOT NULL,
  `stok` int(10) NOT NULL,
  `harga_barang` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_barang`
--

INSERT INTO `tbl_barang` (`kode_barang`, `nama_barang`, `stok`, `harga_barang`) VALUES
('J01', 'Jepit Kecil', 47, 2000),
('J02', 'Jepit Menegah', 7, 3000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pemasukan`
--

CREATE TABLE `tbl_pemasukan` (
  `kode_pemasukan` varchar(10) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `tanggal_masuk` datetime NOT NULL,
  `jumlah_masuk` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_pemasukan`
--

INSERT INTO `tbl_pemasukan` (`kode_pemasukan`, `kode_barang`, `tanggal_masuk`, `jumlah_masuk`) VALUES
('1000000000', 'J01', '2022-12-31 00:00:00', 10000),
('coba', 'J01', '2022-12-31 00:00:00', 100),
('J04', 'J01', '2022-01-16 00:00:00', 12);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengeluaran`
--

CREATE TABLE `tbl_pengeluaran` (
  `kode_pengeluaran` varchar(10) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `tanggal_keluar` datetime NOT NULL,
  `jumlah_keluar` int(10) NOT NULL,
  `harga_barang` int(20) NOT NULL,
  `uang_dibayar` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_pengeluaran`
--

INSERT INTO `tbl_pengeluaran` (`kode_pengeluaran`, `kode_barang`, `tanggal_keluar`, `jumlah_keluar`, `harga_barang`, `uang_dibayar`) VALUES
('1', 'J01', '2022-01-19 00:00:00', 3, 2000, 100000),
('coba lagi', 'J01', '2022-12-31 00:00:00', 5, 2000, 10000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_barang`
--
ALTER TABLE `tbl_barang`
  ADD PRIMARY KEY (`kode_barang`);

--
-- Indexes for table `tbl_pemasukan`
--
ALTER TABLE `tbl_pemasukan`
  ADD PRIMARY KEY (`kode_pemasukan`),
  ADD KEY `kode_barang` (`kode_barang`);

--
-- Indexes for table `tbl_pengeluaran`
--
ALTER TABLE `tbl_pengeluaran`
  ADD PRIMARY KEY (`kode_pengeluaran`),
  ADD KEY `kode_barang` (`kode_barang`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_pemasukan`
--
ALTER TABLE `tbl_pemasukan`
  ADD CONSTRAINT `tbl_pemasukan_ibfk_1` FOREIGN KEY (`kode_barang`) REFERENCES `tbl_barang` (`kode_barang`);

--
-- Constraints for table `tbl_pengeluaran`
--
ALTER TABLE `tbl_pengeluaran`
  ADD CONSTRAINT `tbl_pengeluaran_ibfk_1` FOREIGN KEY (`kode_barang`) REFERENCES `tbl_barang` (`kode_barang`),
  ADD CONSTRAINT `tbl_pengeluaran_ibfk_2` FOREIGN KEY (`kode_barang`) REFERENCES `tbl_barang` (`kode_barang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

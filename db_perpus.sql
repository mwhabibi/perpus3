-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 20, 2024 at 05:55 PM
-- Server version: 8.0.37-0ubuntu0.22.04.3
-- PHP Version: 8.1.2-1ubuntu2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_perpus`
--

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id` int NOT NULL,
  `judul` varchar(60) COLLATE utf8mb4_general_ci NOT NULL,
  `kategori` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `qty` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id`, `judul`, `kategori`, `qty`) VALUES
(1, 'SUKRI MENCARI PASANGAN', 'Biografi', 3),
(2, 'Atomic Habits', 'Non-Fiksi', 16),
(17, 'halo bandung', 'Non-Fiksi', 21),
(18, 'I dont give a FUCK', 'Non-Fiksi', 2),
(19, 'Buku Gajelas', 'Fiksi', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pengunjung`
--

CREATE TABLE `pengunjung` (
  `idPengunjung` int NOT NULL,
  `nama` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengunjung`
--

INSERT INTO `pengunjung` (`idPengunjung`, `nama`) VALUES
(1, 'Dimas Adi Saputra'),
(2, 'Ari Rugi'),
(3, 'Akira'),
(4, 'Bastian Nugraha');

-- --------------------------------------------------------

--
-- Table structure for table `pinjam`
--

CREATE TABLE `pinjam` (
  `idPinjam` int NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idBuku` int NOT NULL,
  `idPengunjung` int NOT NULL,
  `diPinjam` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pinjam`
--

INSERT INTO `pinjam` (`idPinjam`, `tanggal`, `idBuku`, `idPengunjung`, `diPinjam`) VALUES
(11, '2024-07-17 22:18:51', 2, 1, 0),
(12, '2024-07-17 22:34:08', 2, 1, 0),
(13, '2024-07-17 22:35:27', 2, 1, 0),
(14, '2024-07-17 22:52:01', 2, 1, 0),
(15, '2024-07-17 23:03:29', 17, 1, 0),
(16, '2024-07-17 23:20:31', 1, 1, 0),
(17, '2024-07-17 23:20:51', 18, 1, 0),
(18, '2024-07-20 17:37:22', 2, 3, 1),
(19, '2024-07-20 17:38:25', 18, 1, 0),
(20, '2024-07-20 17:50:18', 18, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengunjung`
--
ALTER TABLE `pengunjung`
  ADD PRIMARY KEY (`idPengunjung`);

--
-- Indexes for table `pinjam`
--
ALTER TABLE `pinjam`
  ADD PRIMARY KEY (`idPinjam`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `pengunjung`
--
ALTER TABLE `pengunjung`
  MODIFY `idPengunjung` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pinjam`
--
ALTER TABLE `pinjam`
  MODIFY `idPinjam` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

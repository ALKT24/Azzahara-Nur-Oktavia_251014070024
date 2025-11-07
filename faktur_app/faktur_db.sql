-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for faktur_app
CREATE DATABASE IF NOT EXISTS `faktur_app` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `faktur_app`;

-- Dumping structure for table faktur_app.customer
CREATE TABLE IF NOT EXISTS `customer` (
  `id_customer` int NOT NULL AUTO_INCREMENT,
  `nama_customer` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `perusahaan_cust` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id_customer`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table faktur_app.customer: ~0 rows (approximately)
DELETE FROM `customer`;
INSERT INTO `customer` (`id_customer`, `nama_customer`, `perusahaan_cust`, `alamat`) VALUES
	(2, 'Zahra', 'PT MOZAIK BINTANG PERSADA', 'JL. LEMPUYANG 1 NO 45'),
	(3, 'Aurel', 'PT MOZAIK BINTANG PERSADA', 'JL INPRES 18'),
	(4, 'Juki', 'PT NUSA MAJU BERSAMA', 'JL CENGKEH 2'),
	(5, 'Judi', 'PT INTEK MEDIA SISTEM', 'JL JAHE 4'),
	(6, 'NULI', 'PT NUSANTARA', 'JL INPRES');

-- Dumping structure for table faktur_app.faktur
CREATE TABLE IF NOT EXISTS `faktur` (
  `no_faktur` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_faktur` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `metode_bayar` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ppn` decimal(10,2) DEFAULT NULL,
  `dp` decimal(12,2) DEFAULT NULL,
  `grand_total` decimal(14,2) DEFAULT NULL,
  `user_create` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_customer` int DEFAULT NULL,
  `id_perusahaan` int DEFAULT NULL,
  PRIMARY KEY (`no_faktur`),
  KEY `id_customer` (`id_customer`),
  KEY `id_perusahaan` (`id_perusahaan`),
  CONSTRAINT `faktur_ibfk_1` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id_customer`) ON DELETE SET NULL,
  CONSTRAINT `faktur_ibfk_2` FOREIGN KEY (`id_perusahaan`) REFERENCES `perusahaan` (`id_perusahaan`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table faktur_app.faktur: ~0 rows (approximately)
DELETE FROM `faktur`;
INSERT INTO `faktur` (`no_faktur`, `tgl_faktur`, `due_date`, `metode_bayar`, `ppn`, `dp`, `grand_total`, `user_create`, `id_customer`, `id_perusahaan`) VALUES
	('F20251106053539', '2025-11-06', '2025-11-10', 'Cash', 671000.00, 3050000.00, 6771000.00, NULL, 2, 1),
	('F20251106061235', '2025-11-06', '2025-11-08', 'Transfer', 1144000.00, 5200000.00, 11544000.00, NULL, 3, 1),
	('F20251106061346', '2025-11-06', '2025-11-08', 'Cash', 671000.00, 3050000.00, 6771000.00, NULL, 5, 7),
	('F20251106085219', '2025-11-06', '2025-11-08', 'Cash', 5500000.00, 25000000.00, 55500000.00, NULL, 6, 8);

-- Dumping structure for table faktur_app.faktur_detail
CREATE TABLE IF NOT EXISTS `faktur_detail` (
  `id_detail` int NOT NULL AUTO_INCREMENT,
  `no_faktur` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `id_produk` int NOT NULL,
  `qty` int NOT NULL,
  `harga` decimal(15,2) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  PRIMARY KEY (`id_detail`),
  KEY `id_produk` (`id_produk`),
  CONSTRAINT `faktur_detail_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table faktur_app.faktur_detail: ~0 rows (approximately)
DELETE FROM `faktur_detail`;
INSERT INTO `faktur_detail` (`id_detail`, `no_faktur`, `id_produk`, `qty`, `harga`, `subtotal`) VALUES
	(2, 'F20251106053539', 1, 1, 6100000.00, 6100000.00),
	(4, 'F20251106061235', 9, 2, 5200000.00, 10400000.00),
	(5, 'F20251106061346', 1, 1, 6100000.00, 6100000.00),
	(6, 'F20251106085219', 10, 2, 25000000.00, 50000000.00);

-- Dumping structure for table faktur_app.faktur_items
CREATE TABLE IF NOT EXISTS `faktur_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `no_faktur` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_produk` int DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `price` decimal(14,2) DEFAULT NULL,
  `sub_total` decimal(14,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `no_faktur` (`no_faktur`),
  KEY `id_produk` (`id_produk`),
  CONSTRAINT `faktur_items_ibfk_1` FOREIGN KEY (`no_faktur`) REFERENCES `faktur` (`no_faktur`) ON DELETE CASCADE,
  CONSTRAINT `faktur_items_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table faktur_app.faktur_items: ~0 rows (approximately)
DELETE FROM `faktur_items`;

-- Dumping structure for table faktur_app.perusahaan
CREATE TABLE IF NOT EXISTS `perusahaan` (
  `id_perusahaan` int NOT NULL AUTO_INCREMENT,
  `nama_perusahaan` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_general_ci,
  `no_telp` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fax` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_perusahaan`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table faktur_app.perusahaan: ~0 rows (approximately)
DELETE FROM `perusahaan`;
INSERT INTO `perusahaan` (`id_perusahaan`, `nama_perusahaan`, `alamat`, `no_telp`, `fax`) VALUES
	(1, 'PT MOZAIK BINTANG PERSADA', 'JL. PALEM GANDA ASRI BLOK A3 NOMOR 3', '085780556164', '0214536789'),
	(6, 'PT NUSA MAJU BERSAMA', 'JL IMAM BONJOL NOMOR 4', '085496351275', '021457896345'),
	(7, 'PT INTEK MEDIA SISTEM', 'JL SUDIMARA TIMUR JAKARTA', '08914536786', '021457896315'),
	(8, 'PT NUSANTARA', 'JL', '2486256', '124632569');

-- Dumping structure for table faktur_app.produk
CREATE TABLE IF NOT EXISTS `produk` (
  `id_produk` int NOT NULL AUTO_INCREMENT,
  `nama_produk` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `price` decimal(14,2) DEFAULT NULL,
  `jenis` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `stock` int DEFAULT '0',
  PRIMARY KEY (`id_produk`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table faktur_app.produk: ~0 rows (approximately)
DELETE FROM `produk`;
INSERT INTO `produk` (`id_produk`, `nama_produk`, `price`, `jenis`, `stock`) VALUES
	(1, 'Samsung Galaxy A56', 6100000.00, 'Smartphone', 25),
	(8, 'Samsung Galaxy S25', 14000000.00, 'Smartphone', 15),
	(9, 'Samsung Galaxy A36', 5200000.00, 'Smartphone', 12),
	(10, 'SAMSUNG S24', 25000000.00, 'Smartphone', 12);

-- Dumping structure for table faktur_app.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_general_ci DEFAULT 'admin',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table faktur_app.users: ~0 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `username`, `password_hash`, `role`) VALUES
	(2, 'admin', '$2y$10$eNEkvDdpDFMdU3lpNBhTN.2OIzoY/bqkCYQcw/Oe8Kog7Rl71Idlu', 'admin');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

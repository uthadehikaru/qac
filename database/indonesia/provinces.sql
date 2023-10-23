-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.5.5-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table qac_db.provinces
-- CREATE TABLE IF NOT EXISTS `provinces` (
--   `id` char(2) COLLATE utf8_unicode_ci NOT NULL,
--   `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
--   PRIMARY KEY (`id`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table qac_db.provinces: ~34 rows (approximately)
/*!40000 ALTER TABLE `provinces` DISABLE KEYS */;
INSERT INTO `provinces` (`id`, `name`) VALUES
	('11', 'ACEH'),
	('12', 'SUMATERA UTARA'),
	('13', 'SUMATERA BARAT'),
	('14', 'RIAU'),
	('15', 'JAMBI'),
	('16', 'SUMATERA SELATAN'),
	('17', 'BENGKULU'),
	('18', 'LAMPUNG'),
	('19', 'KEPULAUAN BANGKA BELITUNG'),
	('21', 'KEPULAUAN RIAU'),
	('31', 'DKI JAKARTA'),
	('32', 'JAWA BARAT'),
	('33', 'JAWA TENGAH'),
	('34', 'DI YOGYAKARTA'),
	('35', 'JAWA TIMUR'),
	('36', 'BANTEN'),
	('51', 'BALI'),
	('52', 'NUSA TENGGARA BARAT'),
	('53', 'NUSA TENGGARA TIMUR'),
	('61', 'KALIMANTAN BARAT'),
	('62', 'KALIMANTAN TENGAH'),
	('63', 'KALIMANTAN SELATAN'),
	('64', 'KALIMANTAN TIMUR'),
	('65', 'KALIMANTAN UTARA'),
	('71', 'SULAWESI UTARA'),
	('72', 'SULAWESI TENGAH'),
	('73', 'SULAWESI SELATAN'),
	('74', 'SULAWESI TENGGARA'),
	('75', 'GORONTALO'),
	('76', 'SULAWESI BARAT'),
	('81', 'MALUKU'),
	('82', 'MALUKU UTARA'),
	('91', 'PAPUA BARAT'),
	('94', 'PAPUA');
/*!40000 ALTER TABLE `provinces` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

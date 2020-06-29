-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 29, 2020 at 06:32 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lmt_map`
--

-- --------------------------------------------------------

--
-- Table structure for table `layer`
--

DROP TABLE IF EXISTS `layer`;
CREATE TABLE IF NOT EXISTS `layer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `path` tinytext NOT NULL,
  `style` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `layer_path_uindex` (`path`) USING HASH
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `layer`
--

INSERT INTO `layer` (`id`, `name`, `path`, `style`) VALUES
(19, 'PLS1.kml', 'C:/wamp64/www/lmt-maps/src/data/PLS1.kml', 'hello'),
(20, 'PLS2.kml', 'C:/wamp64/www/lmt-maps/src/data/PLS2.kml', 'hello'),
(21, 'Torņi LMT plānoti pieslēgt.kml', 'C:/wamp64/www/lmt-maps/src/data/Torņi LMT plānoti pieslēgt.kml', 'hello'),
(22, 'Maģistrālā optika.kml', 'C:/wamp64/www/lmt-maps/src/data/Maģistrālā optika.kml', 'hello');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

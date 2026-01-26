-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 26-01-2026 a las 01:40:22
-- Versión del servidor: 8.4.7
-- Versión de PHP: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cafe_hogar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `contacts`
--

INSERT INTO `contacts` (`id`, `full_name`, `email`, `phone`, `subject`, `message`, `created_at`) VALUES
(1, 'Juan David', 'judalo777@gmail.com', '12345678910', 'Añadir al menu otro cafe', '132435435', '2026-01-23 01:12:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `table_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_zone` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `table_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capacity` int DEFAULT NULL,
  `customer_name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reserve_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `comments` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`),
  KEY `idx_date` (`reserve_date`),
  KEY `idx_table` (`table_code`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `reservations`
--

INSERT INTO `reservations` (`id`, `table_code`, `table_zone`, `table_type`, `capacity`, `customer_name`, `email`, `phone`, `reserve_date`, `start_time`, `end_time`, `comments`, `created_at`, `status`) VALUES
(1, 'M7', NULL, NULL, NULL, 'Juan David', 'Prueba@gmail.com', '', '2026-01-21', '12:00:00', '13:00:00', 'sadfsafsaf', '2026-01-23 00:21:22', 'ACTIVE'),
(2, 'M8', NULL, NULL, NULL, 'Juan David', 'Prueba@gmail.com', '', '2026-01-25', '12:00:00', '15:00:00', '654635416', '2026-01-23 00:23:58', 'ACTIVE'),
(3, 'M7', NULL, NULL, NULL, 'Juan David', 'Prueba@gmail.com', '', '2026-01-29', '12:00:00', '19:00:00', '', '2026-01-23 22:33:38', 'ACTIVE'),
(4, 'M10', NULL, NULL, NULL, 'Juan David', 'Prueba@gmail.com', '', '2026-01-29', '12:00:00', '19:00:00', '', '2026-01-23 22:34:26', 'ACTIVE');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

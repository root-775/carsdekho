-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 21, 2026 at 05:59 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `carsdekho`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password_hash`, `created_at`) VALUES
(1, 'admin@gmail.com', '$2y$10$nGgMNtpOAqNu1iCOArF9qulgfnfIuX48qeKY3u3IbdSjy2L7dlsmK', '2026-01-21 11:16:37');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
CREATE TABLE IF NOT EXISTS `banners` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(150) DEFAULT NULL,
  `subtitle` varchar(200) DEFAULT NULL,
  `button_text` varchar(50) DEFAULT NULL,
  `button_link` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `subtitle`, `button_text`, `button_link`, `image_path`, `sort_order`, `is_active`, `created_at`) VALUES
(1, 'Find Your Dream Car', 'Best deals on new cars', 'Explore Now', 'https://carsdekho.com/cars', 'uploads/banners/banner_20260121_175541_38b2561b6b03.jpg', 1, 1, '2026-01-21 17:51:04'),
(2, 'Latest Car Launches', 'Check out newly launched cars', 'View Cars', 'https://carsdekho.com/latest', 'uploads/banners/banner_20260121_175548_3c54737424f4.jpg', 2, 1, '2026-01-21 17:51:04'),
(3, 'Electric Cars Sale', 'Go green with electric vehicles', 'Discover EVs', 'https://carsdekho.com/electric', 'uploads/banners/banner_20260121_175558_ea6a98a0ca2b.jpg', 3, 1, '2026-01-21 17:51:04'),
(4, 'Luxury Cars Collection', 'Premium cars at best prices', 'View Luxury', 'https://carsdekho.com/luxury', 'https://picsum.photos/1280/400?random=1', 4, 0, '2026-01-21 17:51:04'),
(5, 'Used Cars in Your City', 'Certified used cars available', 'Browse Used Cars', 'https://carsdekho.com/used', 'https://picsum.photos/1280/400?random=2', 5, 0, '2026-01-21 17:51:04'),
(6, 'SUV Special Offers', 'Top SUVs with exciting offers', 'Explore SUVs', 'https://carsdekho.com/suv', 'https://picsum.photos/1280/400?random=3', 6, 0, '2026-01-21 17:51:04'),
(7, 'Budget Cars Under 10L', 'Affordable cars for everyone', 'View Budget Cars', 'https://carsdekho.com/budget', 'https://picsum.photos/1280/400?random=4', 7, 0, '2026-01-21 17:51:04'),
(8, 'Car Insurance Plans', 'Get the best insurance deals', 'Get Insurance', 'https://carsdekho.com/insurance', 'https://picsum.photos/1280/400?random=5', 8, 0, '2026-01-21 17:51:04');

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

DROP TABLE IF EXISTS `cars`;
CREATE TABLE IF NOT EXISTS `cars` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(120) DEFAULT NULL,
  `brand` varchar(80) DEFAULT NULL,
  `price_from` decimal(10,2) DEFAULT NULL,
  `price_to` decimal(10,2) DEFAULT NULL,
  `fuel_type` varchar(30) DEFAULT NULL,
  `transmission` varchar(30) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `is_most_searched` tinyint(1) DEFAULT '0',
  `is_latest` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `name`, `brand`, `price_from`, `price_to`, `fuel_type`, `transmission`, `image_path`, `is_most_searched`, `is_latest`, `created_at`) VALUES
(27, 'City', 'Honda', 1199000.00, 1599000.00, 'Petrol', 'Manual', 'uploads/cars/car_20260121_174137_f4c40a8e6834.webp', 0, 0, '2026-01-21 17:30:13'),
(22, 'Venue', 'Hyundai', 799000.00, 1399000.00, 'Petrol', 'Manual', 'uploads/cars/car_20260121_173859_9d4d30c672b5.jpg', 0, 0, '2026-01-21 17:30:13'),
(23, 'Verna', 'Hyundai', 1099000.00, 1799000.00, 'Petrol', 'Automatic', 'uploads/cars/car_20260121_173923_60aba9e120f4.webp', 1, 0, '2026-01-21 17:30:13'),
(24, 'Nexon', 'Tata', 799000.00, 1499000.00, 'Electric', 'Automatic', 'uploads/cars/car_20260121_173948_3a2d5c3726e7.webp', 1, 1, '2026-01-21 17:30:13'),
(25, 'Punch', 'Tata', 599000.00, 999000.00, 'Petrol', 'Manual', 'uploads/cars/car_20260121_174037_479cd57f7970.jpg', 0, 0, '2026-01-21 17:30:13'),
(26, 'Harrier', 'Tata', 1599000.00, 2499000.00, 'Diesel', 'Manual', 'uploads/cars/car_20260121_174104_32cab188c95c.webp', 0, 1, '2026-01-21 17:30:13'),
(21, 'Creta', 'Hyundai', 1099000.00, 1999000.00, 'Diesel', 'Automatic', 'uploads/cars/car_20260121_173823_ebf4edbdb1b4.webp', 1, 1, '2026-01-21 17:30:13'),
(18, 'Swift', 'Maruti Suzuki', 599000.00, 849000.00, 'Petrol', 'Manual', 'uploads/cars/car_20260121_173550_a3e9f230c740.jpg', 1, 0, '2026-01-21 17:30:13'),
(19, 'Baleno', 'Maruti Suzuki', 699000.00, 999000.00, 'Petrol', 'Automatic', 'uploads/cars/car_20260121_173649_5d098c12eb3b.jpg', 1, 0, '2026-01-21 17:30:13'),
(20, 'Brezza', 'Maruti Suzuki', 849000.00, 1399000.00, 'Petrol', 'Manual', 'uploads/cars/car_20260121_173732_2a9d50da0afe.webp', 0, 1, '2026-01-21 17:30:13'),
(28, 'Amaze', 'Honda', 699000.00, 999000.00, 'Petrol', 'Automatic', 'uploads/cars/car_20260121_174228_4ee934fa21c3.webp', 0, 0, '2026-01-21 17:30:13'),
(29, 'XUV700', 'Mahindra', 1399000.00, 2699000.00, 'Diesel', 'Automatic', 'uploads/cars/car_20260121_174254_8e159f35c3c8.jpg', 1, 1, '2026-01-21 17:30:13'),
(30, 'Thar', 'Mahindra', 1099000.00, 1699000.00, 'Petrol', 'Manual', 'uploads/cars/car_20260121_174319_aaa3af6f531a.webp', 1, 1, '2026-01-21 17:30:13'),
(31, 'Scorpio N', 'Mahindra', 1399000.00, 2499000.00, 'Diesel', 'Manual', 'uploads/cars/car_20260121_174351_ca972924342e.webp', 1, 0, '2026-01-21 17:30:13'),
(32, 'Seltos', 'Kia', 1099000.00, 2099000.00, 'Petrol', 'Automatic', 'uploads/cars/car_20260121_174425_878a80223625.jpg', 1, 1, '2026-01-21 17:30:13'),
(33, 'Sonet', 'Kia', 799000.00, 1499000.00, 'Diesel', 'Manual', 'uploads/cars/car_20260121_174636_45366cc7c8a8.webp', 0, 0, '2026-01-21 17:30:13'),
(34, 'Innova Crysta', 'Toyota', 1999000.00, 2999000.00, 'Diesel', 'Manual', 'uploads/cars/car_20260121_174659_d5ca786886ae.webp', 0, 0, '2026-01-21 17:30:13'),
(35, 'Fortuner', 'Toyota', 3299000.00, 5099000.00, 'Diesel', 'Automatic', 'uploads/cars/car_20260121_174526_c24a76b02310.jpg', 1, 1, '2026-01-21 17:30:13'),
(36, 'Kushaq', 'Skoda', 1199000.00, 1999000.00, 'Petrol', 'Manual', 'uploads/cars/car_20260121_174549_7e532dd037f7.webp', 0, 0, '2026-01-21 17:30:13'),
(37, 'Slavia', 'Skoda', 1099000.00, 1899000.00, 'Petrol', 'Automatic', 'uploads/cars/car_20260121_174610_533cb0c34970.jpg', 0, 1, '2026-01-21 17:30:13');

-- --------------------------------------------------------

--
-- Table structure for table `footer_settings`
--

DROP TABLE IF EXISTS `footer_settings`;
CREATE TABLE IF NOT EXISTS `footer_settings` (
  `id` int NOT NULL DEFAULT '1',
  `about_text` text,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `footer_settings`
--

INSERT INTO `footer_settings` (`id`, `about_text`, `address`, `phone`, `email`, `facebook`, `instagram`, `youtube`, `updated_at`) VALUES
(1, 'CarsDekho.com is India\'s leading car search venture that helps users buy cars that are right for them. Its website and app carry rich automotive content such as expert reviews, detailed specs and prices, comparisons as well as videos and pictures of all car brands and models available in India. The company has tie-ups with many auto manufacturers, more than 4000 car dealers and numerous financial institutions to facilitate the purchase of vehicles.', 'Impedit repudiandae', '+1 (288) 683-9825', 'qovimokaqa@mailinator.com', 'https://www.qetalami.co', 'https://www.vyrojuz.me', 'https://www.pan.biz', '2026-01-21 17:58:36');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

DROP TABLE IF EXISTS `site_settings`;
CREATE TABLE IF NOT EXISTS `site_settings` (
  `id` int NOT NULL DEFAULT '1',
  `site_name` varchar(100) DEFAULT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `header_phone` varchar(30) DEFAULT NULL,
  `header_email` varchar(100) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `site_name`, `logo_path`, `header_phone`, `header_email`, `updated_at`) VALUES
(1, 'Cole Fitzpatrick', 'uploads/site-settings/logo_20260121_171735_26c61fc477d6.jpg', '+1 (842) 429-9304', 'munapov@mailinator.com', '2026-01-21 17:17:44');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

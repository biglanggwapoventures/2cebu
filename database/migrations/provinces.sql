-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 23, 2018 at 01:17 AM
-- Server version: 5.7.18
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `cebuattractioncapstone`
--

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`id`, `name`, `region`, `created_at`, `updated_at`) VALUES
(1, 'Bantayan', 'north', NULL, NULL),
(2, 'Bogo City', 'north', NULL, NULL),
(3, 'Borbon', 'north', NULL, NULL),
(4, 'Carmen', 'north', NULL, NULL),
(5, 'Cordova', 'north', NULL, NULL),
(6, 'Daanbantayan', 'north', NULL, NULL),
(7, 'Dalaguete', 'north', NULL, NULL),
(8, 'Danao City', 'north', NULL, NULL),
(9, 'Medellin', 'north', NULL, NULL),
(10, 'Poro', 'north', NULL, NULL),
(11, 'San Francisco', 'north', NULL, NULL),
(12, 'San Remegio', 'north', NULL, NULL),
(13, 'Santa Fe', 'north', NULL, NULL),
(14, 'Sogod', 'north', NULL, NULL),
(15, 'Alcantara', 'south', NULL, NULL),
(16, 'Alcoy', 'south', NULL, NULL),
(17, 'Alegria', 'south', NULL, NULL),
(18, 'Aloguinsan', 'south', NULL, NULL),
(19, 'Argao', 'south', NULL, NULL),
(20, 'Asturias', 'south', NULL, NULL),
(21, 'Balamban', 'south', NULL, NULL),
(22, 'Barili', 'south', NULL, NULL),
(23, 'Boljoon', 'south', NULL, NULL),
(24, 'Carcar City', 'south', NULL, NULL),
(25, 'Ginatilan', 'south', NULL, NULL),
(26, 'Moalboal', 'south', NULL, NULL),
(27, 'Oslob', 'south', NULL, NULL),
(28, 'Pinamungahan', 'south', NULL, NULL),
(29, 'Ronda', 'south', NULL, NULL),
(30, 'Samboan', 'south', NULL, NULL),
(31, 'San Fernando', 'south', NULL, NULL),
(32, 'Santander', 'south', NULL, NULL),
(33, 'Talisay City', 'south', NULL, NULL),
(34, 'Toledo City', 'south', NULL, NULL),
(35, 'Mandaue City', NULL, NULL, NULL),
(36, 'Lapulapu City', NULL, NULL, NULL),
(37, 'Cebu City', NULL, NULL, NULL);
COMMIT;

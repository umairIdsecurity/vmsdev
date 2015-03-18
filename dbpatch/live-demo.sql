-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 17, 2015 at 06:59 AM
-- Server version: 5.5.42-cll
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wwwident_cvms_demo`
--

-- --------------------------------------------------------
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `company`;
DROP TABLE IF EXISTS `photo`;
DROP TABLE IF EXISTS `roles`;
DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS `user_status`;
DROP TABLE IF EXISTS `user_type`;
DROP TABLE IF EXISTS `user_workstation`;
DROP TABLE IF EXISTS `workstation`;
DROP TABLE IF EXISTS `license_details`;

DROP TABLE IF EXISTS `card_generated`;
DROP TABLE IF EXISTS `card_type`;
DROP TABLE IF EXISTS `visit_reason`;
DROP TABLE IF EXISTS `visit_status`;
DROP TABLE IF EXISTS `visitor`;
DROP TABLE IF EXISTS `visitor_status`;
DROP TABLE IF EXISTS `visitor_type`;
DROP TABLE IF EXISTS `visitor_visit_reason`;
DROP TABLE IF EXISTS `card_status`;
DROP TABLE IF EXISTS `visit`;
DROP TABLE IF EXISTS `patient`;
DROP TABLE IF EXISTS `vehicle`;
DROP TABLE IF EXISTS `company_laf_preferences`;
SET FOREIGN_KEY_CHECKS = 1;
--
-- Table structure for table `card_generated`
--

CREATE TABLE IF NOT EXISTS `card_generated` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `card_code` varchar(9) NOT NULL,
  `date_printed` varchar(10) DEFAULT NULL,
  `date_expiration` varchar(10) DEFAULT NULL,
  `date_cancelled` varchar(50) DEFAULT NULL,
  `date_returned` varchar(50) DEFAULT NULL,
  `card_image_generated_filename` bigint(20) DEFAULT NULL,
  `visitor_id` bigint(20) DEFAULT NULL,
  `card_status` bigint(20) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `tenant` bigint(20) DEFAULT NULL,
  `tenant_agent` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `card_image_generated_filename` (`card_image_generated_filename`),
  KEY `created_by` (`created_by`),
  KEY `tenant` (`tenant`),
  KEY `tenant_agent` (`tenant_agent`),
  KEY `card_status` (`card_status`),
  KEY `visitor_id` (`visitor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=140 ;

--
-- Dumping data for table `card_generated`
--

INSERT INTO `card_generated` (`id`, `card_code`, `date_printed`, `date_expiration`, `date_cancelled`, `date_returned`, `card_image_generated_filename`, `visitor_id`, `card_status`, `created_by`, `tenant`, `tenant_agent`) VALUES
(1, 'SYD000001', '11-03-2015', '24-03-2015', '12-03-2015', NULL, 11, 2, 1, 19, 19, NULL),
(2, 'SYD000003', '11-03-2015', '31-03-2015', '12-03-2015', NULL, 14, 4, 1, 19, 19, 21),
(3, 'SYD000002', '12-03-2015', '27-03-2015', '12-03-2015', NULL, 15, 3, 1, 19, 19, NULL),
(4, 'SYD000003', '12-03-2015', '31-03-2015', '12-03-2015', NULL, 16, 4, 1, 16, 19, 21),
(5, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 17, 4, 3, 16, 19, 21),
(6, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 18, 4, 3, 16, 19, 21),
(7, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 19, 4, 3, 16, 19, 21),
(8, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 20, 4, 3, 16, 19, 21),
(9, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 21, 4, 3, 16, 19, 21),
(10, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 22, 4, 3, 16, 19, 21),
(11, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 23, 4, 3, 16, 19, 21),
(12, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 23, 4, 3, 16, 19, 21),
(13, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 25, 4, 3, 16, 19, 21),
(14, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 25, 4, 3, 16, 19, 21),
(15, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 27, 4, 3, 16, 19, 21),
(16, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 28, 4, 3, 16, 19, 21),
(17, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 29, 4, 3, 16, 19, 21),
(18, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 30, 4, 3, 16, 19, 21),
(19, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 31, 4, 3, 16, 19, 21),
(20, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 32, 4, 3, 16, 19, 21),
(21, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 32, 4, 3, 16, 19, 21),
(22, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 34, 4, 3, 16, 19, 21),
(23, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 35, 4, 3, 16, 19, 21),
(24, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 36, 4, 3, 16, 19, 21),
(25, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 37, 4, 3, 16, 19, 21),
(26, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 38, 4, 3, 16, 19, 21),
(27, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 39, 4, 3, 16, 19, 21),
(28, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 40, 4, 3, 16, 19, 21),
(29, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 41, 4, 3, 16, 19, 21),
(30, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 42, 4, 3, 16, 19, 21),
(31, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 43, 4, 3, 16, 19, 21),
(32, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 44, 4, 3, 16, 19, 21),
(33, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 45, 4, 3, 16, 19, 21),
(34, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 46, 4, 3, 16, 19, 21),
(35, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 47, 4, 3, 16, 19, 21),
(36, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 48, 4, 3, 16, 19, 21),
(37, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 49, 4, 3, 16, 19, 21),
(38, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 50, 4, 3, 16, 19, 21),
(39, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 51, 4, 3, 16, 19, 21),
(40, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 52, 4, 3, 16, 19, 21),
(41, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 53, 4, 3, 16, 19, 21),
(42, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 54, 4, 3, 16, 19, 21),
(43, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 55, 4, 3, 16, 19, 21),
(44, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 56, 4, 3, 16, 19, 21),
(45, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 57, 4, 3, 16, 19, 21),
(46, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 58, 4, 3, 16, 19, 21),
(47, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 59, 4, 3, 16, 19, 21),
(48, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 60, 4, 3, 16, 19, 21),
(49, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 61, 4, 3, 16, 19, 21),
(50, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 62, 4, 3, 16, 19, 21),
(51, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 63, 4, 3, 16, 19, 21),
(52, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 63, 4, 3, 16, 19, 21),
(53, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 65, 4, 3, 16, 19, 21),
(54, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 66, 4, 3, 16, 19, 21),
(55, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 67, 4, 3, 16, 19, 21),
(56, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 68, 4, 3, 16, 19, 21),
(57, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 69, 4, 3, 16, 19, 21),
(58, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 70, 4, 3, 16, 19, 21),
(59, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 71, 4, 3, 16, 19, 21),
(60, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 72, 4, 3, 16, 19, 21),
(61, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 73, 4, 3, 16, 19, 21),
(62, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 74, 4, 3, 16, 19, 21),
(63, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 75, 4, 3, 16, 19, 21),
(64, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 76, 4, 3, 16, 19, 21),
(65, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 77, 4, 3, 16, 19, 21),
(66, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 78, 4, 3, 16, 19, 21),
(67, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 78, 4, 3, 16, 19, 21),
(68, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 80, 4, 3, 16, 19, 21),
(69, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 80, 4, 3, 16, 19, 21),
(70, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 82, 4, 3, 16, 19, 21),
(71, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 83, 4, 3, 16, 19, 21),
(72, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 84, 4, 3, 16, 19, 21),
(73, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 85, 4, 3, 16, 19, 21),
(74, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 86, 4, 3, 16, 19, 21),
(75, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 87, 4, 3, 16, 19, 21),
(76, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 88, 4, 3, 16, 19, 21),
(77, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 89, 4, 3, 16, 19, 21),
(78, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 90, 4, 3, 16, 19, 21),
(79, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 91, 4, 3, 16, 19, 21),
(80, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 92, 4, 3, 16, 19, 21),
(81, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 93, 4, 3, 16, 19, 21),
(82, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 94, 4, 3, 16, 19, 21),
(83, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 95, 4, 3, 16, 19, 21),
(84, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 96, 4, 3, 16, 19, 21),
(85, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 97, 4, 3, 16, 19, 21),
(86, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 98, 4, 3, 16, 19, 21),
(87, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 99, 4, 3, 16, 19, 21),
(88, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 100, 4, 3, 16, 19, 21),
(89, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 101, 4, 3, 16, 19, 21),
(90, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 103, 4, 3, 16, 19, 21),
(91, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 104, 4, 3, 16, 19, 21),
(92, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 105, 4, 3, 16, 19, 21),
(93, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 106, 4, 3, 16, 19, 21),
(94, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 107, 4, 3, 16, 19, 21),
(95, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 108, 4, 3, 16, 19, 21),
(96, 'SYD000003', '12-03-2015', '31-03-2015', '12-03-2015', NULL, 109, 4, 1, 16, 19, 21),
(97, 'SYD000003', '12-03-2015', '31-03-2015', '12-03-2015', NULL, 110, 4, 1, 16, 19, 21),
(98, 'SYD000003', '12-03-2015', '31-03-2015', '12-03-2015', NULL, 111, 4, 1, 16, 19, 21),
(99, 'SYD000002', '12-03-2015', '27-03-2015', '12-03-2015', NULL, 112, 3, 1, 16, 19, NULL),
(100, 'SYD000002', '12-03-2015', '27-03-2015', '12-03-2015', NULL, 113, 3, 1, 16, 19, NULL),
(101, 'SYD000001', '12-03-2015', '24-03-2015', '12-03-2015', NULL, 114, 2, 1, 16, 19, NULL),
(102, 'SYD000001', '12-03-2015', '24-03-2015', NULL, NULL, 115, 2, 3, 16, 19, NULL),
(103, 'SYD000003', '12-03-2015', '31-03-2015', '12-03-2015', NULL, 116, 4, 1, 16, 19, 21),
(104, 'SYD000003', '12-03-2015', '31-03-2015', '12-03-2015', NULL, 117, 4, 1, 16, 19, 21),
(105, 'ENS000004', '12-03-2015', '12-03-2015', '12-03-2015', NULL, 120, 5, 1, 24, 24, NULL),
(106, 'ENS000004', '12-03-2015', '12-03-2015', '12-03-2015', NULL, 122, 5, 1, 24, 24, NULL),
(107, 'SYD000003', '12-03-2015', '31-03-2015', '12-03-2015', NULL, 123, 4, 1, 16, 19, 21),
(108, 'SYD000003', '12-03-2015', '31-03-2015', '12-03-2015', NULL, 124, 4, 1, 16, 19, 21),
(109, 'SYD000003', '12-03-2015', '31-03-2015', '12-03-2015', NULL, 125, 4, 1, 16, 19, 21),
(110, 'SYD000003', '12-03-2015', '31-03-2015', '12-03-2015', NULL, 126, 4, 1, 16, 19, 21),
(111, 'SYD000003', '12-03-2015', '31-03-2015', '12-03-2015', NULL, 127, 4, 1, 16, 19, 21),
(112, 'SYD000003', '12-03-2015', '31-03-2015', '12-03-2015', NULL, 128, 4, 1, 16, 19, 21),
(113, 'SYD000003', '12-03-2015', '31-03-2015', '12-03-2015', NULL, 129, 4, 1, 16, 19, 21),
(114, 'SYD000003', '12-03-2015', '31-03-2015', '12-03-2015', NULL, 130, 4, 1, 16, 19, 21),
(115, 'SYD000003', '12-03-2015', '31-03-2015', '12-03-2015', NULL, 131, 4, 1, 16, 19, 21),
(116, 'SYD000003', '12-03-2015', '31-03-2015', '12-03-2015', NULL, 132, 4, 1, 16, 19, 21),
(117, 'SYD000003', '12-03-2015', '31-03-2015', '12-03-2015', NULL, 133, 4, 1, 16, 19, 21),
(118, 'SYD000003', '12-03-2015', '31-03-2015', '12-03-2015', NULL, 134, 4, 1, 16, 19, 21),
(119, 'SYD000003', '12-03-2015', '31-03-2015', '12-03-2015', NULL, 135, 4, 1, 16, 19, 21),
(120, 'SYD000003', '12-03-2015', '31-03-2015', '12-03-2015', NULL, 136, 4, 1, 16, 19, 21),
(121, 'SYD000003', '12-03-2015', '31-03-2015', '12-03-2015', NULL, 137, 4, 1, 16, 19, 21),
(122, 'SYD000003', '12-03-2015', '31-03-2015', '12-03-2015', NULL, 137, 4, 1, 16, 19, 21),
(123, 'SYD000003', '12-03-2015', '31-03-2015', '12-03-2015', NULL, 139, 4, 1, 16, 19, 21),
(124, 'SYD000003', '12-03-2015', '31-03-2015', '12-03-2015', NULL, 140, 4, 1, 16, 19, 21),
(125, 'ENS000004', '12-03-2015', '12-03-2015', '12-03-2015', NULL, 141, 5, 1, 24, 24, NULL),
(126, 'ENS000004', '12-03-2015', '12-03-2015', '12-03-2015', NULL, 143, 5, 1, 16, 24, NULL),
(127, 'ENS000004', '12-03-2015', '12-03-2015', NULL, '12-03-2015', 144, 5, 2, 16, 24, NULL),
(128, 'KER000005', '12-03-2015', '14-03-2015', NULL, '12-03-2015', 146, 6, 2, 26, 26, NULL),
(129, 'KER000007', '12-03-2015', '14-03-2015', '12-03-2015', NULL, 149, 8, 1, 26, 26, NULL),
(130, 'KER000007', '12-03-2015', '14-03-2015', '12-03-2015', NULL, 152, 8, 1, 16, 26, NULL),
(131, 'KER000007', '12-03-2015', '14-03-2015', '12-03-2015', NULL, 153, 8, 1, 16, 26, NULL),
(132, 'SYD000003', '12-03-2015', '31-03-2015', '12-03-2015', NULL, 154, 4, 1, 16, 19, 21),
(133, 'SYD000003', '12-03-2015', '31-03-2015', NULL, NULL, 155, 4, 3, 16, 19, 21),
(134, 'KER000007', '12-03-2015', '14-03-2015', '12-03-2015', NULL, 157, 8, 1, 26, 26, NULL),
(135, 'SYD000002', '12-03-2015', '27-03-2015', NULL, NULL, 158, 3, 3, 16, 19, NULL),
(136, 'KER000007', '12-03-2015', '14-03-2015', '12-03-2015', NULL, 162, 8, 1, 16, 26, NULL),
(137, 'KER000007', '12-03-2015', '14-03-2015', NULL, NULL, 163, 8, 3, 16, 26, NULL),
(138, 'PER000010', '14-03-2015', '14-03-2015', NULL, '16-03-2015', 169, 12, 2, 34, 34, NULL),
(139, 'PER000018', '17-03-2015', '19-03-2015', NULL, NULL, 176, 19, 3, 34, 34, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `card_status`
--

CREATE TABLE IF NOT EXISTS `card_status` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `card_status`
--

INSERT INTO `card_status` (`id`, `name`, `created_by`) VALUES
(1, 'Cancelled', NULL),
(2, 'Returned', NULL),
(3, 'Active', NULL),
(4, 'Not Returned', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `card_type`
--

CREATE TABLE IF NOT EXISTS `card_type` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `max_day_validity` int(10) DEFAULT NULL,
  `max_time_validity` varchar(50) DEFAULT NULL,
  `max_entry_count_validity` int(10) DEFAULT NULL,
  `card_icon_type` text,
  `card_background_image_path` text,
  `created_by` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `card_type`
--

INSERT INTO `card_type` (`id`, `name`, `max_day_validity`, `max_time_validity`, `max_entry_count_validity`, `card_icon_type`, `card_background_image_path`, `created_by`) VALUES
(1, 'Same Day Visitor', 1, NULL, NULL, 'images/same_day_vic.png', 'images/cardprint-new.png', NULL),
(2, 'Multiday Visitor', NULL, NULL, NULL, 'images/multi_day_vic.png', 'images/cardprint-new.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(3) NOT NULL,
  `name` varchar(150) NOT NULL,
  `trading_name` varchar(150) DEFAULT NULL,
  `logo` bigint(20) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `billing_address` varchar(150) DEFAULT NULL,
  `email_address` varchar(50) DEFAULT NULL,
  `office_number` int(30) DEFAULT NULL,
  `mobile_number` int(50) DEFAULT NULL,
  `website` varchar(50) DEFAULT NULL,
  `company_laf_preferences` bigint(20) DEFAULT NULL,
  `created_by_user` bigint(20) DEFAULT NULL,
  `created_by_visitor` bigint(20) DEFAULT NULL,
  `tenant` bigint(20) DEFAULT NULL,
  `tenant_agent` bigint(20) DEFAULT NULL,
  `is_deleted` int(12) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `created_by_visitor` (`created_by_visitor`),
  KEY `created_by_user` (`created_by_user`),
  KEY `tenant_agent` (`tenant_agent`),
  KEY `tenant` (`tenant`),
  KEY `company_laf_preferences` (`company_laf_preferences`),
  KEY `logo` (`logo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `code`, `name`, `trading_name`, `logo`, `contact`, `billing_address`, `email_address`, `office_number`, `mobile_number`, `website`, `company_laf_preferences`, `created_by_user`, `created_by_visitor`, `tenant`, `tenant_agent`, `is_deleted`) VALUES
(1, 'IDS', 'Identity Security', 'Identity Security', 2, 'Julie Stewart Rose', 'PO BOX 710 Port Melbourne VIC 3207', 'julie.stewart@idsecurity.com.au', 396453450, 2147483647, 'http://idsecurity.com.au', 2, NULL, NULL, 16, 16, 0),
(3, 'IDS', 'Identity Security', 'Identity Security', 4, '', '', '', NULL, NULL, '', 3, NULL, NULL, 17, NULL, 1),
(4, 'SYD', 'Sydney Airport', 'Sydney Airport', 6, 'Kyile White', '', '', NULL, NULL, '', 4, NULL, NULL, 19, NULL, 0),
(5, 'QNT', 'Qantas', '', 7, 'Qantas', '', '', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, 0),
(6, 'QNT', 'Qantas', '', 8, '', '', '', NULL, NULL, '', NULL, NULL, NULL, 19, 21, 0),
(7, 'IDS', 'Identity Security', '', 10, 'Julie Stewart', '', '', NULL, NULL, '', NULL, NULL, NULL, 19, NULL, 0),
(8, 'ENS', 'Ensign Laboratories', 'Ensign Laboratories', 121, 'Josh Thornborrow', '', '', NULL, NULL, 'http://www.ensignlab.com.au/', 5, NULL, NULL, 24, NULL, 0),
(9, 'IDS', 'Identity Security', 'Identity Security', 119, '', '', '', NULL, NULL, '', NULL, NULL, NULL, 24, NULL, 0),
(10, 'KER', 'Kerry', 'Kerry', 156, 'Rudy Choong', '', '', NULL, NULL, '', 6, NULL, NULL, 26, NULL, 0),
(11, 'IDS', 'Identity Security', '', NULL, '', '', '', NULL, NULL, '', NULL, NULL, NULL, 26, NULL, 0),
(12, 'PLN', 'Parliaments of NSW', 'Parliament of NSW', 151, '', '', '', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, 0),
(13, 'CLH', 'Chris O''Brien Lifehouse', 'Chris O''Brien Lifehouse', 164, '', '', '', NULL, NULL, '', NULL, NULL, NULL, 32, NULL, 0),
(14, 'SYU', 'The University of Sydney', '', 165, '', '', '', NULL, NULL, 'http://sydney.edu.au/', NULL, NULL, NULL, 33, NULL, 0),
(15, 'PER', 'Perth Airport', 'Per', 168, '', '', '', NULL, NULL, '', 7, NULL, NULL, 34, NULL, 0),
(16, 'QAN', 'Qantas', '', NULL, '', '', '', NULL, NULL, '', NULL, NULL, NULL, 34, 40, 0),
(17, 'VIR', 'Virgin', '', NULL, '', '', '', NULL, NULL, '', NULL, NULL, NULL, 34, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `company_laf_preferences`
--

CREATE TABLE IF NOT EXISTS `company_laf_preferences` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `action_forward_bg_color` varchar(7) DEFAULT NULL,
  `action_forward_bg_color2` varchar(7) DEFAULT NULL,
  `action_forward_font_color` varchar(7) DEFAULT NULL,
  `action_forward_hover_color` varchar(7) DEFAULT NULL,
  `action_forward_hover_color2` varchar(7) DEFAULT NULL,
  `action_forward_hover_font_color` varchar(7) DEFAULT NULL,
  `complete_bg_color` varchar(7) DEFAULT NULL,
  `complete_bg_color2` varchar(7) DEFAULT NULL,
  `complete_hover_color` varchar(7) DEFAULT NULL,
  `complete_hover_color2` varchar(7) DEFAULT NULL,
  `complete_font_color` varchar(7) DEFAULT NULL,
  `complete_hover_font_color` varchar(7) DEFAULT NULL,
  `neutral_bg_color` varchar(7) DEFAULT NULL,
  `neutral_bg_color2` varchar(7) DEFAULT NULL,
  `neutral_hover_color` varchar(7) DEFAULT NULL,
  `neutral_hover_color2` varchar(7) DEFAULT NULL,
  `neutral_font_color` varchar(7) DEFAULT NULL,
  `neutral_hover_font_color` varchar(7) DEFAULT NULL,
  `nav_bg_color` varchar(7) DEFAULT NULL,
  `nav_hover_color` varchar(7) DEFAULT NULL,
  `nav_font_color` varchar(7) DEFAULT NULL,
  `nav_hover_font_color` varchar(7) DEFAULT NULL,
  `sidemenu_bg_color` varchar(7) DEFAULT NULL,
  `sidemenu_hover_color` varchar(7) DEFAULT NULL,
  `sidemenu_font_color` varchar(7) DEFAULT NULL,
  `sidemenu_hover_font_color` varchar(7) DEFAULT NULL,
  `css_file_path` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `company_laf_preferences`
--

INSERT INTO `company_laf_preferences` (`id`, `action_forward_bg_color`, `action_forward_bg_color2`, `action_forward_font_color`, `action_forward_hover_color`, `action_forward_hover_color2`, `action_forward_hover_font_color`, `complete_bg_color`, `complete_bg_color2`, `complete_hover_color`, `complete_hover_color2`, `complete_font_color`, `complete_hover_font_color`, `neutral_bg_color`, `neutral_bg_color2`, `neutral_hover_color`, `neutral_hover_color2`, `neutral_font_color`, `neutral_hover_font_color`, `nav_bg_color`, `nav_hover_color`, `nav_font_color`, `nav_hover_font_color`, `sidemenu_bg_color`, `sidemenu_hover_color`, `sidemenu_font_color`, `sidemenu_hover_font_color`, `css_file_path`) VALUES
(2, '#9ED92F', '#9ED92F', '#ffffff', '#9ED92F', '#9ED92F', '#ffffff', '#0d0d0c', '#a1999a', '#998e8e', '#b0a9a9', '#ffffff', '#ffffff', '#33bcdb', '#33bcdb', '#33bcdb', '#33bcdb', '#ffffff', '#ffffff', '#E7E7E7', '#30c5d9', '#637280', '#ffffff', '#E7E7E7', '#E7E7E7', '#1670c4', '#157cdb', '/company_css/IDS-1424944653.css'),
(3, '#c6f76b', '#9ED92F', '#ffffff', '#c6f76b', '#9ED92F', '#ffffff', '#e67171', '#d42222', '#e67171', '#d42222', '#ffffff', '#ffffff', '#5fdaf5', '#33bcdb', '#33bcdb', '#33bcdb', '#ffffff', '#ffffff', '#E7E7E7', '#30a3d9', '#637280', '#ffffff', '#E7E7E7', '#E7E7E7', '#637280', '#637280', '/company_css/IDS-1426105493.css'),
(4, '#c6f76b', '#9ED92F', '#ffffff', '#c6f76b', '#9ED92F', '#ffffff', '#393d78', '#a5a5b5', '#5a5d61', '#657378', '#ffffff', '#ffffff', '#5fdaf5', '#33bcdb', '#33bcdb', '#33bcdb', '#ffffff', '#ffffff', '#E7E7E7', '#46aceb', '#637280', '#ffffff', '#E7E7E7', '#E7E7E7', '#637280', '#637280', '/company_css/SYD-1426119453.css'),
(5, '#6bf7e4', '#30ced9', '#ffffff', '#5acbd1', '#7b7999', '#ffffff', '#ad1a1a', '#c71c4f', '#948484', '#9e6d6d', '#ffffff', '#ffffff', '#5fdaf5', '#33bcdb', '#33bcdb', '#33bcdb', '#ffffff', '#6287b3', '#E7E7E7', '#3c538c', '#637280', '#ffffff', '#E7E7E7', '#E7E7E7', '#637280', '#637280', '/company_css/ENS-1426135889.css'),
(6, '#6c9c13', '#7ab015', '#ffffff', '#688a28', '#6f8f34', '#ffffff', '#edbb57', '#e6996a', '#e3831c', '#e39f16', '#ffffff', '#ffffff', '#5fdaf5', '#33bcdb', '#33bcdb', '#33bcdb', '#ffffff', '#ffffff', '#E7E7E7', '#1d406b', '#637280', '#ffffff', '#E7E7E7', '#E7E7E7', '#637280', '#637280', '/company_css/KER-1426165018.css'),
(7, '#c6f76b', '#9ED92F', '#ffffff', '#c6f76b', '#9ED92F', '#ffffff', '#3f33a6', '#3d438c', '#4d528a', '#5b60b3', '#ffffff', '#ffffff', '#5fdaf5', '#33bcdb', '#33bcdb', '#33bcdb', '#ffffff', '#ffffff', '#E7E7E7', '#3960b0', '#637280', '#ffffff', '#E7E7E7', '#E7E7E7', '#e07a1b', '#e87015', '/company_css/PER-1426326111.css');

-- --------------------------------------------------------

--
-- Table structure for table `license_details`
--

CREATE TABLE IF NOT EXISTS `license_details` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `license_details`
--

INSERT INTO `license_details` (`id`, `description`) VALUES
(1, 'This is a sample license detail.');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE IF NOT EXISTS `patient` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

-- --------------------------------------------------------

--
-- Table structure for table `photo`
--

CREATE TABLE IF NOT EXISTS `photo` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `filename` text,
  `unique_filename` text,
  `relative_path` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=177 ;

--
-- Dumping data for table `photo`
--

INSERT INTO `photo` (`id`, `filename`, `unique_filename`, `relative_path`) VALUES
(1, 'personal.png', '29200577-1411087522.jpg', 'uploads/company_logo/29200577-1411087522.jpg'),
(2, 'ids-logo2.jpg', '1411087524.jpg', 'uploads/company_logo/1411087524.jpg'),
(3, '228581_4162904777_6339_n.jpg', '4e5607a6-1426104762.jpg', 'uploads/visitor/4e5607a6-1426104762.jpg'),
(4, 'Logo_Email 180px.jpg', '4e5607a6-1426104930.jpg', 'uploads/company_logo/4e5607a6-1426104930.jpg'),
(5, 'P1000231.jpg', 'c7260c48-1426105270.jpg', 'uploads/visitor/c7260c48-1426105270.jpg'),
(6, 'Logo Sydney Airport.jpg', '4e5607a6-1426111282.jpg', 'uploads/company_logo/4e5607a6-1426111282.jpg'),
(7, 'index.png', '4e5607a6-1426112518.jpg', 'uploads/company_logo/4e5607a6-1426112518.jpg'),
(8, 'index.png', '4e5607a6-1426112636.jpg', 'uploads/company_logo/4e5607a6-1426112636.jpg'),
(9, 'P1000231.jpg', '634e086f-1426115657.jpg', 'uploads/visitor/634e086f-1426115657.jpg'),
(10, 'Logo_Email 180px.jpg', '634e086f-1426115706.jpg', 'uploads/company_logo/634e086f-1426115706.jpg'),
(11, 'cardc7260c48-1426115883.png', 'cardc7260c48-1426115883.png', 'uploads/card_generated/cardc7260c48-1426115883.png'),
(12, 'Screenshot 2015-03-05 10.02.22.png', '4cda076e-1426116792.jpg', 'uploads/visitor/4cda076e-1426116792.jpg'),
(13, 'ids-logo-lock-1.png', '3c90068a-1426117084.jpg', 'uploads/visitor/3c90068a-1426117084.jpg'),
(14, 'card88d80a16-1426117257.png', 'card88d80a16-1426117257.png', 'uploads/card_generated/card88d80a16-1426117257.png'),
(15, 'card3f6c06b3-1426119242.png', 'card3f6c06b3-1426119242.png', 'uploads/card_generated/card3f6c06b3-1426119242.png'),
(16, 'card88d80a16-1426125073.png', 'card88d80a16-1426125073.png', 'uploads/card_generated/card88d80a16-1426125073.png'),
(17, 'card88d80a16-1426125413.png', 'card88d80a16-1426125413.png', 'uploads/card_generated/card88d80a16-1426125413.png'),
(18, 'card88d80a16-1426125418.png', 'card88d80a16-1426125418.png', 'uploads/card_generated/card88d80a16-1426125418.png'),
(19, 'card88d80a16-1426125567.png', 'card88d80a16-1426125567.png', 'uploads/card_generated/card88d80a16-1426125567.png'),
(20, 'card88d80a16-1426125568.png', 'card88d80a16-1426125568.png', 'uploads/card_generated/card88d80a16-1426125568.png'),
(21, 'card88d80a16-1426125590.png', 'card88d80a16-1426125590.png', 'uploads/card_generated/card88d80a16-1426125590.png'),
(22, 'card88d80a16-1426125591.png', 'card88d80a16-1426125591.png', 'uploads/card_generated/card88d80a16-1426125591.png'),
(23, 'card88d80a16-1426125620.png', 'card88d80a16-1426125620.png', 'uploads/card_generated/card88d80a16-1426125620.png'),
(24, 'card88d80a16-1426125620.png', 'card88d80a16-1426125620.png', 'uploads/card_generated/card88d80a16-1426125620.png'),
(25, 'card88d80a16-1426125653.png', 'card88d80a16-1426125653.png', 'uploads/card_generated/card88d80a16-1426125653.png'),
(26, 'card88d80a16-1426125653.png', 'card88d80a16-1426125653.png', 'uploads/card_generated/card88d80a16-1426125653.png'),
(27, 'card88d80a16-1426125673.png', 'card88d80a16-1426125673.png', 'uploads/card_generated/card88d80a16-1426125673.png'),
(28, 'card88d80a16-1426125675.png', 'card88d80a16-1426125675.png', 'uploads/card_generated/card88d80a16-1426125675.png'),
(29, 'card88d80a16-1426125735.png', 'card88d80a16-1426125735.png', 'uploads/card_generated/card88d80a16-1426125735.png'),
(30, 'card88d80a16-1426125790.png', 'card88d80a16-1426125790.png', 'uploads/card_generated/card88d80a16-1426125790.png'),
(31, 'card88d80a16-1426125812.png', 'card88d80a16-1426125812.png', 'uploads/card_generated/card88d80a16-1426125812.png'),
(32, 'card88d80a16-1426125849.png', 'card88d80a16-1426125849.png', 'uploads/card_generated/card88d80a16-1426125849.png'),
(33, 'card88d80a16-1426125849.png', 'card88d80a16-1426125849.png', 'uploads/card_generated/card88d80a16-1426125849.png'),
(34, 'card88d80a16-1426125905.png', 'card88d80a16-1426125905.png', 'uploads/card_generated/card88d80a16-1426125905.png'),
(35, 'card88d80a16-1426125951.png', 'card88d80a16-1426125951.png', 'uploads/card_generated/card88d80a16-1426125951.png'),
(36, 'card88d80a16-1426125960.png', 'card88d80a16-1426125960.png', 'uploads/card_generated/card88d80a16-1426125960.png'),
(37, 'card88d80a16-1426125990.png', 'card88d80a16-1426125990.png', 'uploads/card_generated/card88d80a16-1426125990.png'),
(38, 'card88d80a16-1426126024.png', 'card88d80a16-1426126024.png', 'uploads/card_generated/card88d80a16-1426126024.png'),
(39, 'card88d80a16-1426126211.png', 'card88d80a16-1426126211.png', 'uploads/card_generated/card88d80a16-1426126211.png'),
(40, 'card88d80a16-1426126212.png', 'card88d80a16-1426126212.png', 'uploads/card_generated/card88d80a16-1426126212.png'),
(41, 'card88d80a16-1426126262.png', 'card88d80a16-1426126262.png', 'uploads/card_generated/card88d80a16-1426126262.png'),
(42, 'card88d80a16-1426126297.png', 'card88d80a16-1426126297.png', 'uploads/card_generated/card88d80a16-1426126297.png'),
(43, 'card88d80a16-1426126346.png', 'card88d80a16-1426126346.png', 'uploads/card_generated/card88d80a16-1426126346.png'),
(44, 'card88d80a16-1426126353.png', 'card88d80a16-1426126353.png', 'uploads/card_generated/card88d80a16-1426126353.png'),
(45, 'card88d80a16-1426126551.png', 'card88d80a16-1426126551.png', 'uploads/card_generated/card88d80a16-1426126551.png'),
(46, 'card88d80a16-1426126575.png', 'card88d80a16-1426126575.png', 'uploads/card_generated/card88d80a16-1426126575.png'),
(47, 'card88d80a16-1426126616.png', 'card88d80a16-1426126616.png', 'uploads/card_generated/card88d80a16-1426126616.png'),
(48, 'card88d80a16-1426126653.png', 'card88d80a16-1426126653.png', 'uploads/card_generated/card88d80a16-1426126653.png'),
(49, 'card88d80a16-1426126655.png', 'card88d80a16-1426126655.png', 'uploads/card_generated/card88d80a16-1426126655.png'),
(50, 'card88d80a16-1426126725.png', 'card88d80a16-1426126725.png', 'uploads/card_generated/card88d80a16-1426126725.png'),
(51, 'card88d80a16-1426126727.png', 'card88d80a16-1426126727.png', 'uploads/card_generated/card88d80a16-1426126727.png'),
(52, 'card88d80a16-1426126737.png', 'card88d80a16-1426126737.png', 'uploads/card_generated/card88d80a16-1426126737.png'),
(53, 'card88d80a16-1426126801.png', 'card88d80a16-1426126801.png', 'uploads/card_generated/card88d80a16-1426126801.png'),
(54, 'card88d80a16-1426126836.png', 'card88d80a16-1426126836.png', 'uploads/card_generated/card88d80a16-1426126836.png'),
(55, 'card88d80a16-1426126857.png', 'card88d80a16-1426126857.png', 'uploads/card_generated/card88d80a16-1426126857.png'),
(56, 'card88d80a16-1426126880.png', 'card88d80a16-1426126880.png', 'uploads/card_generated/card88d80a16-1426126880.png'),
(57, 'card88d80a16-1426126918.png', 'card88d80a16-1426126918.png', 'uploads/card_generated/card88d80a16-1426126918.png'),
(58, 'card88d80a16-1426126919.png', 'card88d80a16-1426126919.png', 'uploads/card_generated/card88d80a16-1426126919.png'),
(59, 'card88d80a16-1426126951.png', 'card88d80a16-1426126951.png', 'uploads/card_generated/card88d80a16-1426126951.png'),
(60, 'card88d80a16-1426126952.png', 'card88d80a16-1426126952.png', 'uploads/card_generated/card88d80a16-1426126952.png'),
(61, 'card88d80a16-1426126966.png', 'card88d80a16-1426126966.png', 'uploads/card_generated/card88d80a16-1426126966.png'),
(62, 'card88d80a16-1426126967.png', 'card88d80a16-1426126967.png', 'uploads/card_generated/card88d80a16-1426126967.png'),
(63, 'card88d80a16-1426127026.png', 'card88d80a16-1426127026.png', 'uploads/card_generated/card88d80a16-1426127026.png'),
(64, 'card88d80a16-1426127026.png', 'card88d80a16-1426127026.png', 'uploads/card_generated/card88d80a16-1426127026.png'),
(65, 'card88d80a16-1426127040.png', 'card88d80a16-1426127040.png', 'uploads/card_generated/card88d80a16-1426127040.png'),
(66, 'card88d80a16-1426127303.png', 'card88d80a16-1426127303.png', 'uploads/card_generated/card88d80a16-1426127303.png'),
(67, 'card88d80a16-1426127325.png', 'card88d80a16-1426127325.png', 'uploads/card_generated/card88d80a16-1426127325.png'),
(68, 'card88d80a16-1426127380.png', 'card88d80a16-1426127380.png', 'uploads/card_generated/card88d80a16-1426127380.png'),
(69, 'card88d80a16-1426127381.png', 'card88d80a16-1426127381.png', 'uploads/card_generated/card88d80a16-1426127381.png'),
(70, 'card88d80a16-1426127439.png', 'card88d80a16-1426127439.png', 'uploads/card_generated/card88d80a16-1426127439.png'),
(71, 'card88d80a16-1426127466.png', 'card88d80a16-1426127466.png', 'uploads/card_generated/card88d80a16-1426127466.png'),
(72, 'card88d80a16-1426127478.png', 'card88d80a16-1426127478.png', 'uploads/card_generated/card88d80a16-1426127478.png'),
(73, 'card88d80a16-1426127491.png', 'card88d80a16-1426127491.png', 'uploads/card_generated/card88d80a16-1426127491.png'),
(74, 'card88d80a16-1426127492.png', 'card88d80a16-1426127492.png', 'uploads/card_generated/card88d80a16-1426127492.png'),
(75, 'card88d80a16-1426127502.png', 'card88d80a16-1426127502.png', 'uploads/card_generated/card88d80a16-1426127502.png'),
(76, 'card88d80a16-1426127523.png', 'card88d80a16-1426127523.png', 'uploads/card_generated/card88d80a16-1426127523.png'),
(77, 'card88d80a16-1426127602.png', 'card88d80a16-1426127602.png', 'uploads/card_generated/card88d80a16-1426127602.png'),
(78, 'card88d80a16-1426127619.png', 'card88d80a16-1426127619.png', 'uploads/card_generated/card88d80a16-1426127619.png'),
(79, 'card88d80a16-1426127619.png', 'card88d80a16-1426127619.png', 'uploads/card_generated/card88d80a16-1426127619.png'),
(80, 'card88d80a16-1426127767.png', 'card88d80a16-1426127767.png', 'uploads/card_generated/card88d80a16-1426127767.png'),
(81, 'card88d80a16-1426127767.png', 'card88d80a16-1426127767.png', 'uploads/card_generated/card88d80a16-1426127767.png'),
(82, 'card88d80a16-1426127777.png', 'card88d80a16-1426127777.png', 'uploads/card_generated/card88d80a16-1426127777.png'),
(83, 'card88d80a16-1426127833.png', 'card88d80a16-1426127833.png', 'uploads/card_generated/card88d80a16-1426127833.png'),
(84, 'card88d80a16-1426127834.png', 'card88d80a16-1426127834.png', 'uploads/card_generated/card88d80a16-1426127834.png'),
(85, 'card88d80a16-1426127851.png', 'card88d80a16-1426127851.png', 'uploads/card_generated/card88d80a16-1426127851.png'),
(86, 'card88d80a16-1426128022.png', 'card88d80a16-1426128022.png', 'uploads/card_generated/card88d80a16-1426128022.png'),
(87, 'card88d80a16-1426128023.png', 'card88d80a16-1426128023.png', 'uploads/card_generated/card88d80a16-1426128023.png'),
(88, 'card88d80a16-1426128074.png', 'card88d80a16-1426128074.png', 'uploads/card_generated/card88d80a16-1426128074.png'),
(89, 'card88d80a16-1426128075.png', 'card88d80a16-1426128075.png', 'uploads/card_generated/card88d80a16-1426128075.png'),
(90, 'card88d80a16-1426128101.png', 'card88d80a16-1426128101.png', 'uploads/card_generated/card88d80a16-1426128101.png'),
(91, 'card88d80a16-1426128131.png', 'card88d80a16-1426128131.png', 'uploads/card_generated/card88d80a16-1426128131.png'),
(92, 'card88d80a16-1426128132.png', 'card88d80a16-1426128132.png', 'uploads/card_generated/card88d80a16-1426128132.png'),
(93, 'card88d80a16-1426128165.png', 'card88d80a16-1426128165.png', 'uploads/card_generated/card88d80a16-1426128165.png'),
(94, 'card88d80a16-1426128166.png', 'card88d80a16-1426128166.png', 'uploads/card_generated/card88d80a16-1426128166.png'),
(95, 'card88d80a16-1426128187.png', 'card88d80a16-1426128187.png', 'uploads/card_generated/card88d80a16-1426128187.png'),
(96, 'card88d80a16-1426128383.png', 'card88d80a16-1426128383.png', 'uploads/card_generated/card88d80a16-1426128383.png'),
(97, 'card88d80a16-1426128410.png', 'card88d80a16-1426128410.png', 'uploads/card_generated/card88d80a16-1426128410.png'),
(98, 'card88d80a16-1426128411.png', 'card88d80a16-1426128411.png', 'uploads/card_generated/card88d80a16-1426128411.png'),
(99, 'card88d80a16-1426128569.png', 'card88d80a16-1426128569.png', 'uploads/card_generated/card88d80a16-1426128569.png'),
(100, 'card88d80a16-1426128650.png', 'card88d80a16-1426128650.png', 'uploads/card_generated/card88d80a16-1426128650.png'),
(101, 'card88d80a16-1426128688.png', 'card88d80a16-1426128688.png', 'uploads/card_generated/card88d80a16-1426128688.png'),
(102, 'ensignlogo.jpg', '4e5607a6-1426128747.jpg', 'uploads/company_logo/4e5607a6-1426128747.jpg'),
(103, 'card88d80a16-1426128762.png', 'card88d80a16-1426128762.png', 'uploads/card_generated/card88d80a16-1426128762.png'),
(104, 'card88d80a16-1426128763.png', 'card88d80a16-1426128763.png', 'uploads/card_generated/card88d80a16-1426128763.png'),
(105, 'card88d80a16-1426128910.png', 'card88d80a16-1426128910.png', 'uploads/card_generated/card88d80a16-1426128910.png'),
(106, 'card88d80a16-1426128913.png', 'card88d80a16-1426128913.png', 'uploads/card_generated/card88d80a16-1426128913.png'),
(107, 'card88d80a16-1426128920.png', 'card88d80a16-1426128920.png', 'uploads/card_generated/card88d80a16-1426128920.png'),
(108, 'card88d80a16-1426128965.png', 'card88d80a16-1426128965.png', 'uploads/card_generated/card88d80a16-1426128965.png'),
(109, 'card88d80a16-1426128966.png', 'card88d80a16-1426128966.png', 'uploads/card_generated/card88d80a16-1426128966.png'),
(110, 'card88d80a16-1426129110.png', 'card88d80a16-1426129110.png', 'uploads/card_generated/card88d80a16-1426129110.png'),
(111, 'card88d80a16-1426129111.png', 'card88d80a16-1426129111.png', 'uploads/card_generated/card88d80a16-1426129111.png'),
(112, 'card3f6c06b3-1426129123.png', 'card3f6c06b3-1426129123.png', 'uploads/card_generated/card3f6c06b3-1426129123.png'),
(113, 'card3f6c06b3-1426129124.png', 'card3f6c06b3-1426129124.png', 'uploads/card_generated/card3f6c06b3-1426129124.png'),
(114, 'cardc7260c48-1426129137.png', 'cardc7260c48-1426129137.png', 'uploads/card_generated/cardc7260c48-1426129137.png'),
(115, 'cardc7260c48-1426129138.png', 'cardc7260c48-1426129138.png', 'uploads/card_generated/cardc7260c48-1426129138.png'),
(116, 'card88d80a16-1426130546.png', 'card88d80a16-1426130546.png', 'uploads/card_generated/card88d80a16-1426130546.png'),
(117, 'card88d80a16-1426130547.png', 'card88d80a16-1426130547.png', 'uploads/card_generated/card88d80a16-1426130547.png'),
(118, 'bond.jpg', 'visitor0c460311-1426130980.png', 'uploads/visitor/visitor0c460311-1426130980.png'),
(119, 'ids-logo-lock-1.png', 'e2a70d0d-1426131056.jpg', 'uploads/company_logo/e2a70d0d-1426131056.jpg'),
(120, 'card9de20ad8-1426131303.png', 'card9de20ad8-1426131303.png', 'uploads/card_generated/card9de20ad8-1426131303.png'),
(121, 'aVXI8JcbaPS-0Z4JKuLYNnCoqBnMSIutruIc7wKrbsE.png', 'e2a70d0d-1426131412.jpg', 'uploads/company_logo/e2a70d0d-1426131412.jpg'),
(122, 'card9de20ad8-1426131509.png', 'card9de20ad8-1426131509.png', 'uploads/card_generated/card9de20ad8-1426131509.png'),
(123, 'card88d80a16-1426131547.png', 'card88d80a16-1426131547.png', 'uploads/card_generated/card88d80a16-1426131547.png'),
(124, 'card88d80a16-1426131579.png', 'card88d80a16-1426131579.png', 'uploads/card_generated/card88d80a16-1426131579.png'),
(125, 'card88d80a16-1426131581.png', 'card88d80a16-1426131581.png', 'uploads/card_generated/card88d80a16-1426131581.png'),
(126, 'card88d80a16-1426131602.png', 'card88d80a16-1426131602.png', 'uploads/card_generated/card88d80a16-1426131602.png'),
(127, 'card88d80a16-1426131603.png', 'card88d80a16-1426131603.png', 'uploads/card_generated/card88d80a16-1426131603.png'),
(128, 'card88d80a16-1426131741.png', 'card88d80a16-1426131741.png', 'uploads/card_generated/card88d80a16-1426131741.png'),
(129, 'card88d80a16-1426131773.png', 'card88d80a16-1426131773.png', 'uploads/card_generated/card88d80a16-1426131773.png'),
(130, 'card88d80a16-1426131776.png', 'card88d80a16-1426131776.png', 'uploads/card_generated/card88d80a16-1426131776.png'),
(131, 'card88d80a16-1426132074.png', 'card88d80a16-1426132074.png', 'uploads/card_generated/card88d80a16-1426132074.png'),
(132, 'card88d80a16-1426132077.png', 'card88d80a16-1426132077.png', 'uploads/card_generated/card88d80a16-1426132077.png'),
(133, 'card88d80a16-1426132249.png', 'card88d80a16-1426132249.png', 'uploads/card_generated/card88d80a16-1426132249.png'),
(134, 'card88d80a16-1426132250.png', 'card88d80a16-1426132250.png', 'uploads/card_generated/card88d80a16-1426132250.png'),
(135, 'card88d80a16-1426132296.png', 'card88d80a16-1426132296.png', 'uploads/card_generated/card88d80a16-1426132296.png'),
(136, 'card88d80a16-1426132297.png', 'card88d80a16-1426132297.png', 'uploads/card_generated/card88d80a16-1426132297.png'),
(137, 'card88d80a16-1426132337.png', 'card88d80a16-1426132337.png', 'uploads/card_generated/card88d80a16-1426132337.png'),
(138, 'card88d80a16-1426132337.png', 'card88d80a16-1426132337.png', 'uploads/card_generated/card88d80a16-1426132337.png'),
(139, 'card88d80a16-1426132392.png', 'card88d80a16-1426132392.png', 'uploads/card_generated/card88d80a16-1426132392.png'),
(140, 'card88d80a16-1426132393.png', 'card88d80a16-1426132393.png', 'uploads/card_generated/card88d80a16-1426132393.png'),
(141, 'card9de20ad8-1426132484.png', 'card9de20ad8-1426132484.png', 'uploads/card_generated/card9de20ad8-1426132484.png'),
(142, 'logo_lrge.png', '4e5607a6-1426133091.jpg', 'uploads/company_logo/4e5607a6-1426133091.jpg'),
(143, 'card9de20ad8-1426133520.png', 'card9de20ad8-1426133520.png', 'uploads/card_generated/card9de20ad8-1426133520.png'),
(144, 'card9de20ad8-1426133522.png', 'card9de20ad8-1426133522.png', 'uploads/card_generated/card9de20ad8-1426133522.png'),
(145, 'Keely.jpg', '5bdf084b-1426133868.jpg', 'uploads/visitor/5bdf084b-1426133868.jpg'),
(146, 'card595c07f5-1426133958.png', 'card595c07f5-1426133958.png', 'uploads/card_generated/card595c07f5-1426133958.png'),
(147, 'Sheila.jpg', '4d6f07a4-1426134449.jpg', 'uploads/visitor/4d6f07a4-1426134449.jpg'),
(148, 'bond.jpg', 'visitor0c460311-1426134584.png', 'uploads/visitor/visitor0c460311-1426134584.png'),
(149, 'card9de20ad8-1426134729.png', 'card9de20ad8-1426134729.png', 'uploads/card_generated/card9de20ad8-1426134729.png'),
(150, 'bond.jpg', '83a909d1-1426136001.jpg', 'uploads/visitor/83a909d1-1426136001.jpg'),
(151, 'NSWlogoMob.png', '4e5607a6-1426139164.jpg', 'uploads/company_logo/4e5607a6-1426139164.jpg'),
(152, 'card9de20ad8-1426139660.png', 'card9de20ad8-1426139660.png', 'uploads/card_generated/card9de20ad8-1426139660.png'),
(153, 'card9de20ad8-1426139663.png', 'card9de20ad8-1426139663.png', 'uploads/card_generated/card9de20ad8-1426139663.png'),
(154, 'card88d80a16-1426139698.png', 'card88d80a16-1426139698.png', 'uploads/card_generated/card88d80a16-1426139698.png'),
(155, 'card88d80a16-1426139704.png', 'card88d80a16-1426139704.png', 'uploads/card_generated/card88d80a16-1426139704.png'),
(156, 'logo_lrge.png', '5bdf084b-1426140207.jpg', 'uploads/company_logo/5bdf084b-1426140207.jpg'),
(157, 'card9de20ad8-1426140245.png', 'card9de20ad8-1426140245.png', 'uploads/card_generated/card9de20ad8-1426140245.png'),
(158, 'card3f6c06b3-1426141394.png', 'card3f6c06b3-1426141394.png', 'uploads/card_generated/card3f6c06b3-1426141394.png'),
(159, 'lifehouselogo.png', '4e5607a6-1426152070.jpg', 'uploads/company_logo/4e5607a6-1426152070.jpg'),
(160, 'lifehouselogo.png', '4e5607a6-1426152102.jpg', 'uploads/company_logo/4e5607a6-1426152102.jpg'),
(161, 'Keely.jpg', '5bdf084b-1426165071.jpg', 'uploads/visitor/5bdf084b-1426165071.jpg'),
(162, 'card9de20ad8-1426176295.png', 'card9de20ad8-1426176295.png', 'uploads/card_generated/card9de20ad8-1426176295.png'),
(163, 'card9de20ad8-1426176297.png', 'card9de20ad8-1426176297.png', 'uploads/card_generated/card9de20ad8-1426176297.png'),
(164, 'lifehouselogo.png', '4e5607a6-1426210740.jpg', 'uploads/company_logo/4e5607a6-1426210740.jpg'),
(165, 'index.jpg', '4e5607a6-1426211249.jpg', 'uploads/company_logo/4e5607a6-1426211249.jpg'),
(166, 'Rene.jpg', '57f807e3-1426319879.jpg', 'uploads/visitor/57f807e3-1426319879.jpg'),
(167, 'Perth Airport Logo (Portrait - Colour with Black Font).jpg', '4e5607a6-1426321343.jpg', 'uploads/company_logo/4e5607a6-1426321343.jpg'),
(168, 'Perth Airport Logo (Landscape - Colour with Black Font)(1).jpg', '7ef409bf-1426322945.jpg', 'uploads/company_logo/7ef409bf-1426322945.jpg'),
(169, 'card74850939-1426326930.png', 'card74850939-1426326930.png', 'uploads/card_generated/card74850939-1426326930.png'),
(170, 'aerplane.jpg', '7ef409bf-1426326940.jpg', 'uploads/visitor/7ef409bf-1426326940.jpg'),
(171, 'images.jpg', '7ef409bf-1426333973.jpg', 'uploads/visitor/7ef409bf-1426333973.jpg'),
(172, 'images.jpg', '7ef409bf-1426402872.jpg', 'uploads/visitor/7ef409bf-1426402872.jpg'),
(173, 'images.jpg', '7ef409bf-1426411414.jpg', 'uploads/visitor/7ef409bf-1426411414.jpg'),
(174, 'images.jpg', '3ae3066e-1426479162.jpg', 'uploads/visitor/3ae3066e-1426479162.jpg'),
(175, 'PA_Logo Vertical White.png', '7ef409bf-1426564991.jpg', 'uploads/visitor/7ef409bf-1426564991.jpg'),
(176, 'card2928056d-1426567353.png', 'card2928056d-1426567353.png', 'uploads/card_generated/card2928056d-1426567353.png');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_by`) VALUES
(1, 'Administrator', NULL),
(5, 'Super Administrator', NULL),
(6, 'Agent Administrator', NULL),
(7, 'Agent Operator', NULL),
(8, 'Operator', NULL),
(9, 'Staff Member/Intranet', NULL),
(10, 'Visitor/Kiosk', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `company` bigint(20) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `staff_id` varchar(50) DEFAULT NULL,
  `notes` text,
  `password` varchar(150) DEFAULT NULL,
  `role` bigint(20) NOT NULL,
  `user_type` bigint(20) NOT NULL,
  `user_status` bigint(20) DEFAULT '1',
  `created_by` bigint(20) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `tenant` bigint(20) DEFAULT NULL,
  `tenant_agent` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role` (`role`),
  KEY `user_type` (`user_type`),
  KEY `user_status` (`user_status`),
  KEY `company` (`company`),
  KEY `created_by` (`created_by`),
  KEY `tenant` (`tenant`),
  KEY `tenant_agent` (`tenant_agent`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `contact_number`, `date_of_birth`, `company`, `department`, `position`, `staff_id`, `notes`, `password`, `role`, `user_type`, `user_status`, `created_by`, `is_deleted`, `tenant`, `tenant_agent`) VALUES
(16, 'SuperAdmin', 'IDS', 'superadmin@test.com', '9998798', '1993-01-01', 1, '', '', '', '', '$2a$13$wv.A6T0CCHXczYv/tlJP6./6qUvDdOy.g8KX.FqSos1Mf6MA7Xl66', 5, 1, 1, 16, 0, 16, 16),
(17, 'Julie', 'Stewart', 'julie.stewart@idsecurity.com.au', '0423121888', '2015-03-12', 3, '', '', '', '', '$2a$13$f2eB1EBP3ClpfqdfiAZwA.dottUM9ye/fUVjDSNabvqE.ZW.bw9I6', 1, 1, 1, 16, 1, 17, NULL),
(18, 'Julie', 'Stewart', 'julie.stewart@idsecurity.com.au', '0423121888', '2015-03-12', 3, '', '', '', '', '$2a$13$ehahXyNH5r0I/oju2vD2ueJF9bX34RHYSb4yiWceDGDw9XW8Tv4Za', 1, 1, 1, 16, 0, 17, NULL),
(19, 'Kyile', 'White', 'kyile.white@syd.com.au', '02 9667 6025 ', '2015-03-12', 4, '', '', '', '', '$2a$13$y8Rwl6LuKv5R.dyI/UKsLucD.ZW7woGaB3kdPttCKKHsXCuj2Hcem', 1, 1, 1, 16, 0, 19, NULL),
(20, 'Airport', 'operator', 'operator@syd.com.au', '02 9667 6025 ', '2015-03-12', 4, '', '', '', '', '$2a$13$ZcM1BOI3avLynbfruHwHzuLpIVUvdfuHsT6EPVe0NlPangpii.xta', 8, 1, 1, 16, 0, 19, NULL),
(21, 'Qantas', 'Airways', 'Qantas@syd.com.au', '02 9667 6025 ', '2015-03-12', 6, '', '', '', '', '$2a$13$O/jQznLV6zlbboSIIS83jOFzUAOMSQ3q6.oihbjnFZ0oI/Xhvz9Oi', 6, 1, 1, 16, 0, 19, 21),
(22, 'James', 'Bond', 'james.bond@syd.com.au', '02 666666666', '1970-01-01', 4, '', NULL, '', NULL, '$2a$13$r.a1MLXdBhXQOqc5MevTb.O4uG1AtudZ1P2t/JQbu8z12CiIWwlDC', 9, 1, 1, 20, 0, 19, NULL),
(23, 'James', 'Pacemaker', 'james@qantas.com.au', '1212121212', '1970-01-01', 4, '', NULL, '', NULL, '$2a$13$Comz47o/ghtpU9QGoTieduIfWOu.Bo.0SOmE73PEK7iip4UvB/lvW', 9, 1, 1, 21, 0, 19, 21),
(24, 'Josh', 'Thornborrow', 'josh.thornborrow@ensignlab.com.au', '+61 3 9550 1500', '2015-03-12', 8, '', '', '', '', '$2a$13$sgmpWO7hdaNlsxM4vQ6zR.bRkdQdcmQCGUGPWDhrmneF6f9LBHsAu', 1, 1, 1, 16, 0, 24, NULL),
(25, 'Reception', 'Superstar', 'reception@ensignlab.com.au', '03 95501584', '2015-03-12', 8, '', '', '', '', '$2a$13$e1XWeQgUN.VnUxqjUrPTHe2GXBA9G.Uo.GQWE.bKrAhRUWbBj7Wye', 1, 1, 1, 24, 0, 24, NULL),
(26, 'Rudy', 'Choong', 'Rudy.choong@kerry.com', '+65 6715 3452', '2015-03-12', 10, '', '', '', '', '$2a$13$MbVviWD.OsGwE4dnoe.TI.pM3s2/3liW8RVfVfWo3tZoKmEM.9jfS', 1, 1, 1, 16, 0, 26, NULL),
(27, 'Reception', 'Kerry', 'reception@kerry.com', '5555555', '2015-03-12', 10, '', '', '', '', '$2a$13$EvvvRot9zu2pf8/mzUIVmeOMWRld.Vf.u9EE4XUfoZkHGZOWpY/sG', 8, 1, 1, 26, 1, 26, NULL),
(28, 'Reception', 'Kerry', 'reception@kerry.com', '5555555', '2015-03-12', 10, '', '', '', '', '$2a$13$fS3T52P.qpKye13HHSqucOAy6f.0.JLz5nFGGSnDEdJbF3Y1YYe3O', 8, 1, 1, 26, 1, 26, NULL),
(29, 'Ensign', 'Operator', 'operator@ensignlab.com.au', '03 95501584', '2015-03-12', 8, '', '', '', '', '$2a$13$/E52BrOIDjF57H0KxF4AY.JsADOok8IUai2InnRzk3bbtvYZ61orW', 8, 1, 1, 24, 0, 24, NULL),
(30, 'Staff', 'member', 'staff@ensign.com', '0423121888', '1970-01-01', 8, '', NULL, '', NULL, '$2a$13$9nsp7gK79JBfa4F7GkHW8uhBvryfWOjynXCGgWefuEwacE3zeqzzG', 9, 1, 1, 24, 0, 24, NULL),
(31, 'Kerry', '2', 'operator2@kerry.com', '12121212', '2015-03-12', 10, '', '', '', '', '$2a$13$CA1cFTEjqyaGrQuQ3B07O.f7eiUy6ttVaHJSJLbeQgoV3506RiJty', 8, 1, 1, 26, 0, 26, NULL),
(32, 'Chris', 'O''Brien', 'Admin@lh.org.au', '0285140880', '2015-03-13', 13, '', '', '', '', '$2a$13$W8vN9j5CJtqBPes6HMNy1.JUSAkGwf/akCEPYtmrA/K4KdzEDCSsC', 1, 1, 1, 16, 0, 32, NULL),
(33, 'Admin', 'Sydney Uni', 'admin@syd.edu.au', '042323232323', '2015-03-13', 14, '', '', '', '', '$2a$13$9nn7iMP0NWGK5kjcv2nGFuY4JbjzHKsugWp9WAEJ0q.uijGnq/Utq', 1, 1, 1, 16, 0, 33, NULL),
(34, 'Issuing', 'Administrator', 'Admin@perthairport.com.au', '12121212', '2015-03-14', 15, '', '', '', '', '$2a$13$QZnyOPJn7j.uw2yBmYcsy.N3CFf/1g7OwP5sV0tFzaNzhGn/3klna', 1, 1, 1, 16, 0, 34, NULL),
(35, 'Julie', 'Stewart', 'julie.stewart@rose.com.au', '1212121212', '1970-01-01', 15, '', NULL, '', NULL, '$2a$13$x5IP3IO21KvPys0vH.FwqekkLPgZsIdB80i353P5bGmJU3e3ssapi', 9, 1, 1, 34, 0, 34, NULL),
(36, 'Julie', 'Stewart', 'julie.agentadministrator@ids.com.au', '1212121212', '1970-01-01', 15, '', NULL, '', NULL, '$2a$13$DSrdgGz3qcz2X1kg/1smgu3sp3Yr5ls42IkgPAuTqXO8EQ9UiGNge', 9, 1, 1, 34, 0, 34, NULL),
(37, 'Adrian', 'P', 'Adrian.P@perth.com.au', '1212121212', '1970-01-01', 15, '', NULL, '', NULL, '$2a$13$ukbwJ1oFC7.5ggVJla4R/.cFgt22t4q4FL8s3sqQ1Xg2Eko6ErwXa', 9, 1, 1, 34, 0, 34, NULL),
(38, 'John', 'Rose', 'john.horner@ids.com.au', '1212121212', '1970-01-01', 15, '', NULL, '', NULL, '$2a$13$m9RUhOs9QrjazGqfX8Bgh.du5.pWBZ7ZVIYLLZSyd/PnU/OCjQXm6', 9, 1, 1, 34, 0, 34, NULL),
(39, 'John', 'Rose', 'john.horner@ids.com.au', '1212121212', '1970-01-01', 15, '', NULL, '', NULL, '$2a$13$hEPO/EeYUbKdlsZBw7vMxup46zjlTwVAQ/ez6xqptZYn7ZphZuN3e', 9, 1, 1, 34, 0, 34, NULL),
(40, 'Agent', 'Administrator', 'agent@papl.com.au', '12121212', '2015-03-16', 16, '', '', '', '', '$2a$13$bZVU0dQ3eSf7b4Z4bHHkkeqsTQ/.qUoLBgaL8mIz2/KvcfFAsS/uC', 6, 1, 1, 34, 0, 34, 40),
(41, 'operator', 'qantas', 'james@qantas.com.au', '1212122', '2015-03-16', 16, '', '', '', '', '$2a$13$uFkBuMOTNmyilp81Z01eFeY9YA1XIRy1uMZZTCTYcD3IV4XfvNqL.', 7, 1, 1, 40, 0, 34, 40);

-- --------------------------------------------------------

--
-- Table structure for table `user_status`
--

CREATE TABLE IF NOT EXISTS `user_status` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user_status`
--

INSERT INTO `user_status` (`id`, `name`, `created_by`) VALUES
(1, 'Open', NULL),
(2, 'Access Denied', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE IF NOT EXISTS `user_type` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id`, `name`, `created_by`) VALUES
(1, 'Internal', NULL),
(2, 'External', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_workstation`
--

CREATE TABLE IF NOT EXISTS `user_workstation` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) NOT NULL,
  `workstation` bigint(20) NOT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `workstation` (`workstation`),
  KEY `created_by` (`created_by`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `user_workstation`
--

INSERT INTO `user_workstation` (`id`, `user`, `workstation`, `created_by`, `is_primary`) VALUES
(4, 20, 13, 16, 1),
(5, 27, 17, 26, 1),
(6, 28, 17, 26, 1),
(8, 29, 15, 24, 1),
(9, 29, 16, 24, 0),
(10, 31, 17, 26, 1),
(11, 41, 22, 40, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE IF NOT EXISTS `vehicle` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `vehicle_registration_plate_number` varchar(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `visit`
--

CREATE TABLE IF NOT EXISTS `visit` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `visitor` bigint(20) DEFAULT NULL,
  `card_type` bigint(20) DEFAULT NULL,
  `card` bigint(20) DEFAULT NULL,
  `visitor_type` bigint(20) DEFAULT NULL,
  `reason` bigint(20) DEFAULT NULL,
  `visitor_status` bigint(20) DEFAULT '1',
  `host` bigint(20) DEFAULT NULL,
  `patient` bigint(20) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `date_in` varchar(10) DEFAULT NULL,
  `time_in` time DEFAULT NULL,
  `date_out` varchar(10) DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `date_check_in` varchar(10) DEFAULT NULL,
  `time_check_in` time DEFAULT NULL,
  `date_check_out` varchar(10) DEFAULT NULL,
  `time_check_out` time DEFAULT NULL,
  `visit_status` bigint(20) DEFAULT NULL,
  `workstation` bigint(20) DEFAULT NULL,
  `tenant` bigint(20) DEFAULT NULL,
  `tenant_agent` bigint(20) DEFAULT NULL,
  `is_deleted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `card` (`card`),
  KEY `reason` (`reason`),
  KEY `visitor_type` (`visitor_type`),
  KEY `visitor_status` (`visitor_status`),
  KEY `host` (`host`),
  KEY `patient` (`patient`),
  KEY `created_by` (`created_by`),
  KEY `tenant` (`tenant`),
  KEY `tenant_agent` (`tenant_agent`),
  KEY `card_type` (`card_type`),
  KEY `visit_status` (`visit_status`),
  KEY `workstation` (`workstation`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `visit`
--

INSERT INTO `visit` (`id`, `visitor`, `card_type`, `card`, `visitor_type`, `reason`, `visitor_status`, `host`, `patient`, `created_by`, `date_in`, `time_in`, `date_out`, `time_out`, `date_check_in`, `time_check_in`, `date_check_out`, `time_check_out`, `visit_status`, `workstation`, `tenant`, `tenant_agent`, `is_deleted`) VALUES
(1, 2, 2, 102, 2, 1, 1, 19, NULL, 19, NULL, NULL, '24-03-2015', '00:00:00', '12-03-2015', '10:17:44', NULL, '00:00:00', 1, 13, 19, NULL, 0),
(2, 3, 2, 135, 2, 1, 1, 22, NULL, 19, '13-03-2015', '10:01:00', '27-03-2015', '00:00:00', '12-03-2015', '11:13:54', NULL, '00:00:00', 1, 13, 19, NULL, 0),
(3, 4, 2, 133, 2, 1, 1, 23, NULL, 21, NULL, NULL, '31-03-2015', '00:00:00', '12-03-2015', '10:40:06', NULL, '00:00:00', 1, 14, 19, 21, 0),
(4, 5, 1, 127, 2, 1, 1, 24, NULL, 29, NULL, NULL, '13-03-2015', '00:00:00', '12-03-2015', '14:34:59', '12-03-2015', '16:33:57', 3, 15, 24, NULL, 0),
(5, 6, 2, 128, 2, 1, 1, 26, NULL, 16, NULL, NULL, '14-03-2015', '00:00:00', '12-03-2015', '15:19:15', '13-03-2015', '09:15:12', 3, 17, 26, NULL, 0),
(6, 7, 2, NULL, 2, 1, 1, 26, NULL, 26, '20-03-2015', '15:58:00', '31-03-2015', '00:00:00', NULL, NULL, NULL, '00:00:00', 2, 17, 26, NULL, 0),
(7, 8, 2, 137, 2, 1, 1, 26, NULL, 26, NULL, NULL, '14-03-2015', '00:00:00', '12-03-2015', '15:32:04', NULL, '00:00:00', 1, 17, 26, NULL, 0),
(8, 11, 2, NULL, 2, 1, 1, 22, NULL, 22, '15-03-2015', '19:31:00', '16-03-2015', '00:00:00', NULL, NULL, NULL, '00:00:00', 2, 13, 19, NULL, 0),
(10, 12, 1, 138, 2, 2, 1, 36, NULL, 34, NULL, NULL, '15-03-2015', '00:00:00', '14-03-2015', '20:54:39', '16-03-2015', '15:20:37', 3, 20, 34, NULL, 0),
(11, 13, 2, NULL, 2, 1, 1, 37, NULL, 34, NULL, NULL, '16-03-2015', '00:00:00', '14-03-2015', '22:53:53', '14-03-2015', '22:54:52', 3, 19, 34, NULL, 0),
(12, 13, 2, NULL, 2, 1, 1, 37, NULL, 34, NULL, NULL, '16-03-2015', '00:00:00', '14-03-2015', '23:54:29', '15-03-2015', '20:14:38', 3, 19, 34, NULL, 0),
(13, 14, 1, NULL, 2, 1, 1, 37, NULL, 34, NULL, NULL, '16-03-2015', '00:00:00', '15-03-2015', '17:54:45', '15-03-2015', '17:58:23', 3, 19, 34, NULL, 0),
(14, 15, 2, NULL, 2, 1, 1, 37, NULL, 34, NULL, NULL, NULL, '00:00:00', NULL, NULL, NULL, '00:00:00', 5, 20, 34, NULL, 0),
(15, 13, 2, NULL, 2, 1, 1, 37, NULL, 34, NULL, NULL, NULL, '00:00:00', NULL, NULL, NULL, '00:00:00', 5, 20, 34, NULL, 0),
(16, 18, 2, NULL, 2, 1, 1, 38, NULL, 34, NULL, NULL, NULL, '00:00:00', NULL, NULL, NULL, '00:00:00', 5, 19, 34, NULL, 0),
(17, 16, 2, NULL, 2, 1, 1, 39, NULL, 34, NULL, NULL, NULL, '00:00:00', NULL, NULL, NULL, '00:00:00', 5, 19, 34, NULL, 0),
(18, 19, 2, 139, 2, 2, 1, 38, NULL, 34, NULL, NULL, '19-03-2015', '00:00:00', '17-03-2015', '15:05:23', NULL, '00:00:00', 1, 19, 34, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `visitor`
--

CREATE TABLE IF NOT EXISTS `visitor` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `company` bigint(20) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `staff_id` varchar(50) DEFAULT NULL,
  `notes` text,
  `password` varchar(150) DEFAULT NULL,
  `role` bigint(20) NOT NULL DEFAULT '10',
  `visitor_type` bigint(20) DEFAULT NULL,
  `visitor_status` bigint(20) DEFAULT '1',
  `vehicle` bigint(20) DEFAULT NULL,
  `photo` bigint(20) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `tenant` bigint(20) DEFAULT NULL,
  `tenant_agent` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role` (`role`),
  KEY `company` (`company`),
  KEY `created_by` (`created_by`),
  KEY `tenant` (`tenant`),
  KEY `tenant_agent` (`tenant_agent`),
  KEY `visitor_type` (`visitor_type`),
  KEY `visitor_status` (`visitor_status`),
  KEY `photo` (`photo`),
  KEY `vehicle` (`vehicle`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `visitor`
--

INSERT INTO `visitor` (`id`, `first_name`, `last_name`, `email`, `contact_number`, `date_of_birth`, `company`, `department`, `position`, `staff_id`, `notes`, `password`, `role`, `visitor_type`, `visitor_status`, `vehicle`, `photo`, `created_by`, `is_deleted`, `tenant`, `tenant_agent`) VALUES
(2, 'Julie', 'Stewart', 'julie.stewart@idsecurity.com.au', '0423121888', '1970-01-01', 7, NULL, 'Director', NULL, NULL, '$2a$13$yQVdycWNkBUZJARmRh81lOhFLj.7ddtPUVkPJuvgNY/lumCwOvqTa', 10, NULL, 1, NULL, 9, 19, 0, 19, NULL),
(3, 'Jack', 'Rose', 'Jack@qantas.com.au', '0408888888', '1970-01-01', 6, NULL, '', NULL, NULL, '$2a$13$w69y7AIdqZdMtYiHSsEU6.lXCi9vsww/WdEcQT8j6CxG/uHtDCKei', 10, NULL, 1, NULL, 12, 20, 0, 19, NULL),
(4, 'Key', 'Hole', 'key.hole@idsecurity.com.au', '0444000444', '1970-01-01', 4, NULL, '', NULL, NULL, '$2a$13$M0.TYewE/yyfJthpPD.l5u8rFUdfoue2wsfh8E0F2zgJqgk2yasee', 10, NULL, 1, NULL, 13, 21, 0, 19, 21),
(5, 'James', 'Bond', 'james.bond@idsecurity.com.au', '0408888888', '1970-01-01', 9, NULL, '', NULL, NULL, '$2a$13$5mIJX2JJzecB7AH8hWLTkeVz2ZkeYbUmt5UhzhepCil38O4KdoTNy', 10, NULL, 1, NULL, 118, 24, 0, 24, NULL),
(6, 'Kelly', 'Kerry', 'kelly.kerr@ids.com.au', '0444000444', '1970-01-01', 11, NULL, '', NULL, NULL, '$2a$13$TKFRdhX/U.L3tE7WLrSRH.btsuB1n2nsEOyp1UY9.zBbiBx.b3rVC', 10, NULL, 1, NULL, 145, 26, 0, 26, NULL),
(7, 'Jane', 'Pattison', 'jane@ids.com.au', '0408888888', '1970-01-01', 11, NULL, '', NULL, NULL, '$2a$13$xq.WnxTZqw9kQ4R93j/0xOsFoYarIz.KXQqISxPZePOdn6CQo/i/.', 10, NULL, 1, NULL, 147, 27, 0, 26, NULL),
(8, 'James', 'Bond', 'james.bond@idsecurity.com.au', '0408888888', '1970-01-01', 11, NULL, '', NULL, NULL, '$2a$13$YKiT8TP3HDp1vHRxqUauV.RhbBebavWWyfZ6S95E3a8kFHnYV48fe', 10, NULL, 1, NULL, 148, 27, 0, 26, NULL),
(9, 'Renee', 'Z', 'renee.z@gmail.com', '12121212', '1970-01-01', 4, NULL, '', NULL, NULL, '$2a$13$KZNk9qidOCvXGalrNNKrV.VjgooYgExh.XAM8JCu1B9dYWGA.oLwq', 10, NULL, 3, NULL, NULL, 16, 0, 19, 21),
(10, 'Renee', 'Z', 'renee.z@gmail.com', '12121212', '1970-01-01', 4, NULL, '', NULL, NULL, '$2a$13$BtSKYmqe21dmgHATN3499.NgWEJi8nPDQ9ZjO6TAR/D23NRPZjASi', 10, NULL, 3, NULL, NULL, 16, 0, 19, 21),
(11, 'Julie', 'Stewart', 'julie.stewart2@idsecurity.com.au', '12121212', '1970-01-01', 6, NULL, '', NULL, NULL, '$2a$13$18R3ShOH3N1vlybXDkHNqOjEOaJUbjtUG475vThgsnzWdTKNHf0Vq', 10, NULL, 1, NULL, 166, 22, 0, 19, NULL),
(12, 'Jo', 'Pearson', 'jo.pearson@qantas.com.au', '21212121212', '1970-01-01', 16, NULL, '', NULL, NULL, '$2a$13$09H8dbHH91Nap2XMvxmpfOvfadDSWs3iYLUv24F.kv6ss/UMIv5RW', 10, NULL, 1, NULL, 170, 34, 0, 34, NULL),
(13, 'Geoff', 'Stewart', 'geoff.Stewart@idsecurity.com.au', '121212122', '1970-01-01', 16, NULL, '', NULL, NULL, '$2a$13$QBjJqJcq1MmWCwsgQ9G3DOFn62H0BSLbhRJww5GPjZtAoebuHVcB2', 10, NULL, 1, NULL, 171, 34, 0, 34, NULL),
(14, 'Same', 'Day', 'Virgin@vurgin.com', '0408888888', '1970-01-01', 17, NULL, '', NULL, NULL, '$2a$13$mm5./V.ZNYBAvmV70xScN.z2qY4nWgLflTlGn0SWdvYhKdxmYAcn.', 10, NULL, 1, NULL, NULL, 34, 0, 34, NULL),
(15, '24 ', 'Bleed', 'demo@demo.com', '121212122', '1970-01-01', 16, NULL, '', NULL, NULL, '$2a$13$H2voUAhtqRs6TFfFlzMzu.Uw6ThWEz1E3qKsHiW.pXSz.1Q71vnq6', 10, NULL, 1, NULL, 172, 34, 0, 34, NULL),
(16, 'Preregister', 'VIC ', 'pre@VIC.com.au', '121212122', '1970-01-01', 16, NULL, '', NULL, NULL, '$2a$13$TdHhSMvUFo1N7jS4A/B8MO0bp6E8DkNGjUZXuTkOpZi7XKCdmmUIu', 10, NULL, 1, NULL, 173, 34, 0, 34, NULL),
(17, 'Preregister', 'VIC ', 'pre@VIC.com.au', '121212122', '1970-01-01', 16, NULL, '', NULL, NULL, '$2a$13$vUCXIRG42fDVi7eD5MY4Xu3tsg/oajzmfbFNtc6ITa9iI3oLVM1Pm', 10, NULL, 1, NULL, 173, 34, 0, 34, NULL),
(18, 'Preregister', 'VIC ', 'pre@VIC.com.au', '121212122', '1970-01-01', 16, NULL, '', NULL, NULL, '$2a$13$mqtw/uSgi3lVkaFBeMEArOheYhO1jzA9S4dAeJbgj6CQskiaPGrqm', 10, NULL, 1, NULL, 173, 34, 0, 34, NULL),
(19, 'Papl Logo', 'Logo', 'papal@logo.com', '0408888888', '1970-01-01', 16, NULL, '', NULL, NULL, '$2a$13$T6KBqSpKglaaHDPe81LGUOjj0HyR650OSO2tUeAusg6FqVIt0Zft2', 10, NULL, 1, NULL, 175, 34, 0, 34, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `visitor_status`
--

CREATE TABLE IF NOT EXISTS `visitor_status` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `visitor_status`
--

INSERT INTO `visitor_status` (`id`, `name`) VALUES
(1, 'Open'),
(2, 'Access Denied'),
(3, 'Save');

-- --------------------------------------------------------

--
-- Table structure for table `visitor_type`
--

CREATE TABLE IF NOT EXISTS `visitor_type` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `tenant` bigint(20) DEFAULT NULL,
  `tenant_agent` bigint(20) DEFAULT NULL,
  `is_deleted` int(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `visitor_type`
--

INSERT INTO `visitor_type` (`id`, `name`, `created_by`, `tenant`, `tenant_agent`, `is_deleted`) VALUES
(1, 'Patient Visitor', 16, NULL, NULL, 0),
(2, 'Corporate Visitor', 16, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `visit_reason`
--

CREATE TABLE IF NOT EXISTS `visit_reason` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `reason` text,
  `created_by` bigint(20) DEFAULT NULL,
  `tenant` bigint(20) DEFAULT NULL,
  `tenant_agent` bigint(20) DEFAULT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `tenant` (`tenant`),
  KEY `tenant_agent` (`tenant_agent`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `visit_reason`
--

INSERT INTO `visit_reason` (`id`, `reason`, `created_by`, `tenant`, `tenant_agent`, `is_deleted`) VALUES
(1, 'Testing Software', 16, NULL, NULL, 0),
(2, 'ASICs', 34, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `visit_status`
--

CREATE TABLE IF NOT EXISTS `visit_status` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `visit_status`
--

INSERT INTO `visit_status` (`id`, `name`, `created_by`) VALUES
(1, 'Active', NULL),
(2, 'Pre-registered', NULL),
(3, 'Closed', NULL),
(4, 'Expired', NULL),
(5, 'Save', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `workstation`
--

CREATE TABLE IF NOT EXISTS `workstation` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `contact_name` varchar(50) DEFAULT NULL,
  `contact_number` int(50) DEFAULT NULL,
  `contact_email_address` varchar(50) DEFAULT NULL,
  `number_of_operators` int(2) DEFAULT NULL,
  `assign_kiosk` tinyint(1) DEFAULT '0',
  `password` varchar(50) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `tenant` bigint(20) DEFAULT NULL,
  `tenant_agent` bigint(20) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `workstation`
--

INSERT INTO `workstation` (`id`, `name`, `location`, `contact_name`, `contact_number`, `contact_email_address`, `number_of_operators`, `assign_kiosk`, `password`, `created_by`, `tenant`, `tenant_agent`, `is_deleted`) VALUES
(8, 'Workstation1', 'PAL', 'Test Person', 123456, 'workstation1@test.com', NULL, 0, NULL, 16, 17, 18, 1),
(11, 'Reception', '', '', NULL, '', NULL, 0, '$2a$13$1D3gqduvl2aUtKi4zaKlwebblX5JZHnBFXuDEXjQRFl', 17, 17, NULL, 0),
(12, 'Workstation 1', '', '', NULL, '', NULL, 0, '$2a$13$HzVKa.ZrOe274mZ3/FawGOk7JG/QloWXWJFYosOS9ne', 17, 17, NULL, 0),
(13, 'Sydney Airport Office Reception', '', '', NULL, '', NULL, 0, '$2a$13$V2zYs76vA5hxmpR2q41AGO7Rr2Zq0WYugLArh5uLCBj', 16, 19, NULL, 0),
(14, 'Qantas Reception', '', '', NULL, '', NULL, 0, '$2a$13$7sfYh2RLVNzM65HzrTpYwewWiubUP/DPvEp4TdZIPlc', 19, 19, 21, 0),
(15, 'Ensign Reception', '', '', NULL, '', NULL, 0, '$2a$13$N3xGVUibfMuujva7jlshq.zDYiU/YmYMlxI0q7Lz20s', 16, 24, NULL, 0),
(16, 'Ensign Engineering', '', '', NULL, '', NULL, 0, '$2a$13$Ws7gXv1Iu5FI5Pp4P2LeseGVRJhtRjfpDso6QHpLhK8', 16, 24, NULL, 0),
(17, 'Reception', '', '', NULL, '', NULL, 0, '$2a$13$N/NW6dBaOpBmWS9bax2gPub.Jd4gC1vLZbYGbi5apIa', 26, 26, NULL, 0),
(18, 'Lifehouse Reception', '', '', NULL, '', NULL, 0, '$2a$13$YxxxQ5L0ink1PYnIGO8SL.ixNg9QoK23SqwfLRWUM2a', 16, 32, NULL, 0),
(19, 'Gate 4', '', '', NULL, '', NULL, 0, '$2a$13$Br0PVATNnZFX23MUAeyCUejTiJQ6JPPh2DfPlY4JQ9c', 16, 34, NULL, 0),
(20, 'ASIC Office', '', '', NULL, '', NULL, 0, '$2a$13$zf9YCnQm7fyJ4OXYHA6NB.VrMAnBJgAzDqORFcIr/Xk', 16, 34, NULL, 0),
(21, 'Gate 1', '', '', NULL, '', NULL, 0, '$2a$13$n.FP3YDC38zgIihQN.9ahuWG3h0EfNNJdCoBD5j8bRa', 16, 34, NULL, 0),
(22, 'Qantas Reception', '', '', NULL, '', NULL, 0, '$2a$13$Dcw2aWKlHJ90qwUNUZ/sAe7bMECMqv/kL9M21UDBjly', 40, 34, 40, 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `card_generated`
--
ALTER TABLE `card_generated`
  ADD CONSTRAINT `card_generated_ibfk_5` FOREIGN KEY (`visitor_id`) REFERENCES `visitor` (`id`),
  ADD CONSTRAINT `card_generated_ibfk_6` FOREIGN KEY (`card_status`) REFERENCES `card_status` (`id`),
  ADD CONSTRAINT `card_generated_ibfk_1` FOREIGN KEY (`card_image_generated_filename`) REFERENCES `photo` (`id`),
  ADD CONSTRAINT `card_generated_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `card_generated_ibfk_3` FOREIGN KEY (`tenant`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `card_generated_ibfk_4` FOREIGN KEY (`tenant_agent`) REFERENCES `user` (`id`);

--
-- Constraints for table `card_status`
--
ALTER TABLE `card_status`
  ADD CONSTRAINT `card_status_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`);

--
-- Constraints for table `card_type`
--
ALTER TABLE `card_type`
  ADD CONSTRAINT `card_type_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`);

--
-- Constraints for table `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `company_ibfk_1` FOREIGN KEY (`created_by_user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `company_ibfk_2` FOREIGN KEY (`tenant_agent`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `company_ibfk_3` FOREIGN KEY (`tenant`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `company_ibfk_4` FOREIGN KEY (`company_laf_preferences`) REFERENCES `company_laf_preferences` (`id`),
  ADD CONSTRAINT `company_ibfk_5` FOREIGN KEY (`logo`) REFERENCES `photo` (`id`);

--
-- Constraints for table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`user_type`) REFERENCES `user_type` (`id`),
  ADD CONSTRAINT `user_ibfk_3` FOREIGN KEY (`user_status`) REFERENCES `user_status` (`id`),
  ADD CONSTRAINT `user_ibfk_4` FOREIGN KEY (`company`) REFERENCES `company` (`id`),
  ADD CONSTRAINT `user_ibfk_5` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `user_ibfk_6` FOREIGN KEY (`tenant`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `user_ibfk_7` FOREIGN KEY (`tenant_agent`) REFERENCES `user` (`id`);

--
-- Constraints for table `user_status`
--
ALTER TABLE `user_status`
  ADD CONSTRAINT `user_status_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`);

--
-- Constraints for table `user_type`
--
ALTER TABLE `user_type`
  ADD CONSTRAINT `user_type_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`);

--
-- Constraints for table `user_workstation`
--
ALTER TABLE `user_workstation`
  ADD CONSTRAINT `user_workstation_ibfk_1` FOREIGN KEY (`workstation`) REFERENCES `workstation` (`id`),
  ADD CONSTRAINT `user_workstation_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `user_workstation_ibfk_3` FOREIGN KEY (`user`) REFERENCES `user` (`id`);

--
-- Constraints for table `visit`
--
ALTER TABLE `visit`
  ADD CONSTRAINT `visit_ibfk_13` FOREIGN KEY (`workstation`) REFERENCES `workstation` (`id`),
  ADD CONSTRAINT `visit_ibfk_11` FOREIGN KEY (`card_type`) REFERENCES `card_type` (`id`),
  ADD CONSTRAINT `visit_ibfk_12` FOREIGN KEY (`visit_status`) REFERENCES `visit_status` (`id`),
  ADD CONSTRAINT `visit_ibfk_1` FOREIGN KEY (`card`) REFERENCES `card_generated` (`id`),
  ADD CONSTRAINT `visit_ibfk_10` FOREIGN KEY (`tenant_agent`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `visit_ibfk_3` FOREIGN KEY (`reason`) REFERENCES `visit_reason` (`id`),
  ADD CONSTRAINT `visit_ibfk_4` FOREIGN KEY (`visitor_type`) REFERENCES `visitor_type` (`id`),
  ADD CONSTRAINT `visit_ibfk_5` FOREIGN KEY (`visitor_status`) REFERENCES `visitor_status` (`id`),
  ADD CONSTRAINT `visit_ibfk_6` FOREIGN KEY (`host`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `visit_ibfk_7` FOREIGN KEY (`patient`) REFERENCES `patient` (`id`),
  ADD CONSTRAINT `visit_ibfk_8` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `visit_ibfk_9` FOREIGN KEY (`tenant`) REFERENCES `user` (`id`);

--
-- Constraints for table `visitor`
--
ALTER TABLE `visitor`
  ADD CONSTRAINT `visitor_ibfk_1` FOREIGN KEY (`visitor_type`) REFERENCES `visitor_type` (`id`),
  ADD CONSTRAINT `visitor_ibfk_2` FOREIGN KEY (`visitor_status`) REFERENCES `visitor_status` (`id`),
  ADD CONSTRAINT `visitor_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `visitor_ibfk_4` FOREIGN KEY (`tenant`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `visitor_ibfk_5` FOREIGN KEY (`tenant_agent`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `visitor_ibfk_6` FOREIGN KEY (`role`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `visitor_ibfk_7` FOREIGN KEY (`company`) REFERENCES `company` (`id`),
  ADD CONSTRAINT `visitor_ibfk_9` FOREIGN KEY (`photo`) REFERENCES `photo` (`id`),
  ADD CONSTRAINT `visitor_ibfk_8` FOREIGN KEY (`vehicle`) REFERENCES `vehicle` (`id`);

--
-- Constraints for table `visitor_type`
--
ALTER TABLE `visitor_type`
  ADD CONSTRAINT `visitor_type_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`);

--
-- Constraints for table `visit_reason`
--
ALTER TABLE `visit_reason`
  ADD CONSTRAINT `visit_reason_ibfk_3` FOREIGN KEY (`tenant_agent`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `visit_reason_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `visit_reason_ibfk_2` FOREIGN KEY (`tenant`) REFERENCES `user` (`id`);

--
-- Constraints for table `visit_status`
--
ALTER TABLE `visit_status`
  ADD CONSTRAINT `visit_status_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`);

--
-- Constraints for table `workstation`
--
ALTER TABLE `workstation`
  ADD CONSTRAINT `workstation_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 17, 2014 at 07:44 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `vms`
--

-- --------------------------------------------------------

ALTER TABLE `company` DROP FOREIGN KEY company_ibfk_1;
ALTER TABLE `company` DROP FOREIGN KEY company_ibfk_2;
ALTER TABLE `company` DROP FOREIGN KEY company_ibfk_3;
ALTER TABLE `company` DROP FOREIGN KEY company_ibfk_4;

ALTER TABLE `roles` DROP FOREIGN KEY roles_ibfk_1;

ALTER TABLE `user` DROP FOREIGN KEY user_ibfk_1;
ALTER TABLE `user` DROP FOREIGN KEY user_ibfk_2;
ALTER TABLE `user` DROP FOREIGN KEY user_ibfk_3;
ALTER TABLE `user` DROP FOREIGN KEY user_ibfk_4;
ALTER TABLE `user` DROP FOREIGN KEY user_ibfk_5;
ALTER TABLE `user` DROP FOREIGN KEY user_ibfk_6;
ALTER TABLE `user` DROP FOREIGN KEY user_ibfk_7;

ALTER TABLE `user_status` DROP FOREIGN KEY user_status_ibfk_1;
ALTER TABLE `user_type` DROP FOREIGN KEY user_type_ibfk_1;

ALTER TABLE `user_workstation` DROP FOREIGN KEY user_workstation_ibfk_1;
ALTER TABLE `user_workstation` DROP FOREIGN KEY user_workstation_ibfk_2;
ALTER TABLE `user_workstation` DROP FOREIGN KEY user_workstation_ibfk_3;

ALTER TABLE `workstation` DROP FOREIGN KEY workstation_ibfk_1;

DROP TABLE IF EXISTS `company`;
DROP TABLE IF EXISTS `photo`;
DROP TABLE IF EXISTS `roles`;
DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS `user_status`;
DROP TABLE IF EXISTS `user_type`;
DROP TABLE IF EXISTS `user_workstation`;
DROP TABLE IF EXISTS `workstation`;
DROP TABLE IF EXISTS `license_details`;
--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `trading_name` varchar(150) DEFAULT NULL,
  `logo` bigint(20) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `billing_address` varchar(150) DEFAULT NULL,
  `email_address` varchar(50) DEFAULT NULL,
  `office_number` int(30) DEFAULT NULL,
  `mobile_number` int(50) DEFAULT NULL,
  `website` varchar(50) DEFAULT NULL,
  `created_by_user` int(10) DEFAULT NULL,
  `created_by_visitor` int(10) DEFAULT NULL,
  `tenant` int(10) DEFAULT NULL,
  `tenant_agent` int(10) DEFAULT NULL,
  `is_deleted` int(120) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `created_by_visitor` (`created_by_visitor`),
  KEY `created_by_user` (`created_by_user`),
  KEY `tenant_agent` (`tenant_agent`),
  KEY `tenant` (`tenant`),
  KEY `logo` (`logo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `photo`
--

INSERT INTO `photo` (`id`, `filename`, `unique_filename`, `relative_path`) VALUES
(1, 'personal.png', '29200577-1411087522.jpg', 'uploads/company_logo/29200577-1411087522.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `created_by` int(10) DEFAULT NULL,
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
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `company` int(10) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `staff_id` varchar(50) DEFAULT NULL,
  `notes` text,
  `password` varchar(150) DEFAULT NULL,
  `role` int(2) NOT NULL,
  `user_type` int(2) NOT NULL,
  `user_status` int(2) DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `tenant` int(10) DEFAULT NULL,
  `tenant_agent` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role` (`role`),
  KEY `user_type` (`user_type`),
  KEY `user_status` (`user_status`),
  KEY `company` (`company`),
  KEY `created_by` (`created_by`),
  KEY `tenant` (`tenant`),
  KEY `tenant_agent` (`tenant_agent`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `contact_number`, `date_of_birth`, `company`, `department`, `position`, `staff_id`, `notes`, `password`, `role`, `user_type`, `user_status`, `created_by`, `is_deleted`, `tenant`, `tenant_agent`) VALUES
(16, 'IDS', 'Test', 'superadmin@test.com', '9998798', '1993-01-01', NULL, '', '', '', '', '$2a$13$wv.A6T0CCHXczYv/tlJP6./6qUvDdOy.g8KX.FqSos1Mf6MA7Xl66', 5, 1, 1, 16, 0, 16, 16);

-- --------------------------------------------------------

--
-- Table structure for table `user_status`
--

CREATE TABLE IF NOT EXISTS `user_status` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `created_by` int(10) DEFAULT NULL,
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
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `created_by` int(10) DEFAULT NULL,
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
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user` int(10) NOT NULL,
  `workstation` int(10) NOT NULL,
  `created_by` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `workstation` (`workstation`),
  KEY `created_by` (`created_by`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `workstation`
--

CREATE TABLE IF NOT EXISTS `workstation` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `contact_name` varchar(50) DEFAULT NULL,
  `contact_number` int(50) DEFAULT NULL,
  `contact_email_address` varchar(50) DEFAULT NULL,
  `number_of_operators` int(2) DEFAULT NULL,
  `assign_kiosk` tinyint(1) DEFAULT '0',
  `password` varchar(50) DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL,
  `tenant` bigint(20) DEFAULT NULL,
  `tenant_agent` bigint(20) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `workstation`
--

INSERT INTO `workstation` (`id`, `name`, `location`, `contact_name`, `contact_number`, `contact_email_address`, `number_of_operators`, `assign_kiosk`, `password`, `created_by`, `tenant`, `tenant_agent`) VALUES
(8, 'Workstation', 'PAL', 'Test Person', 123456, 'workstation1@test.com', NULL, 0, NULL, 16, 17, 18),
(9, 'Workstation1', 'PAL', 'Test Person', 123456, 'workstation1@test.com', NULL, 0, NULL, 16, 17, 23);

CREATE TABLE IF NOT EXISTS `license_details`( 
    `id` BIGINT NOT NULL AUTO_INCREMENT, 
    `description` TEXT,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1; 

INSERT INTO `license_details` (`id`, `description`) VALUES
(1, 'This is a sample license detail.');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `company_ibfk_1` FOREIGN KEY (`created_by_user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `company_ibfk_2` FOREIGN KEY (`tenant_agent`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `company_ibfk_3` FOREIGN KEY (`tenant`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `company_ibfk_4` FOREIGN KEY (`logo`) REFERENCES `photo` (`id`);

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
-- Constraints for table `workstation`
--
ALTER TABLE `workstation`
  ADD CONSTRAINT `workstation_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

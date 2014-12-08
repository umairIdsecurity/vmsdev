-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 13, 2014 at 02:19 AM
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
SET FOREIGN_KEY_CHECKS = 1;
--
-- Table structure for table `card_generated`
--

CREATE TABLE IF NOT EXISTS `card_generated` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `card_status` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

--
-- Dumping data for table `user_status`
--

INSERT INTO `card_status` (`id`, `name`, `created_by`) VALUES
(1, 'Cancelled', NULL),
(2, 'Returned', NULL),
(3, 'Active', NULL);


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

INSERT INTO `card_type` (`id`, `name`,`max_day_validity` ,`max_time_validity`, `max_entry_count_validity`, `card_icon_type`, `card_background_image_path`, `created_by`) VALUES
(1, 'Same Day Visitor', '1', NULL,NULL ,'images/same_day_vic.png', 'images/cardprint-new.png', NULL),
(2, 'Multiday Visitor', NULL,NULL, NULL, 'images/multi_day_vic.png', 'images/cardprint-new.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `trading_name` varchar(150) DEFAULT NULL,
  `logo` bigint(20) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `billing_address` varchar(150) DEFAULT NULL,
  `email_address` varchar(50) DEFAULT NULL,
  `office_number` int(30) DEFAULT NULL,
  `mobile_number` int(50) DEFAULT NULL,
  `website` varchar(50) DEFAULT NULL,
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
  KEY `logo` (`logo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `trading_name`, `logo`, `contact`, `billing_address`, `email_address`, `office_number`, `mobile_number`, `website`, `created_by_user`, `created_by_visitor`, `tenant`, `tenant_agent`, `is_deleted`) VALUES
(1, 'Test Company 1', 'Test Company 1', 1, 'Test Person', '123 street', 'testcompany@test.com', 12345, 12345, 'http://testcompany.com', NULL, NULL, 17, 18, 0),
(2, 'Test Company 2', 'Test Company 2', 1, 'Test Person', '123 street', 'testcompany2@test.com', 12345, 12345, 'http://testcompany2.com', NULL, NULL, NULL, NULL, 0);

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


--
-- Table structure for table `patient`
--

CREATE TABLE IF NOT EXISTS `patient` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


INSERT INTO `patient` (`id`, `name`) VALUES
(1, 'Patient Name 1'),
(2, 'Patient Name 2'),
(3, 'Patient Name 3');
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `contact_number`, `date_of_birth`, `company`, `department`, `position`, `staff_id`, `notes`, `password`, `role`, `user_type`, `user_status`, `created_by`, `is_deleted`, `tenant`, `tenant_agent`) VALUES
(16, 'IDS', 'Test', 'superadmin@test.com', '9998798', '1993-01-01', NULL, '', '', '', '', '$2a$13$wv.A6T0CCHXczYv/tlJP6./6qUvDdOy.g8KX.FqSos1Mf6MA7Xl66', 5, 1, 1, 16, 0, 16, 16),
(17, 'Test', 'admin', 'admin@test.com', '123456', '2014-09-14', 1, 'Test Department', 'Test Position', '123456', 'Test Notes', '$2a$13$6qNEkuI21Coug38E485YweOeVqPpe4tgpb8v9Eb.z.1Skierdhpie', 1, 1, 1, 16, 0, 17, NULL),
(18, 'Test', 'agentadmin', 'agentadmin@test.com', '123456', '2014-09-14', 1, 'Test Department', 'Test Position', '123456', 'Test Notes', '$2a$13$Jnj1TVTdBZD3GOitBD7HGea4OOr6YZi63vSWQPFiJchipiDJorTqm', 6, 1, 1, 16, 0, 17, 18),
(19, 'Test', 'operator', 'operator@test.com', '123456', '2014-09-14', 1, 'Test Department', 'Test Position', '123456', 'Test Notes', '$2a$13$b1b.63axWWCFUjhIFjGLSutoYkNU6DBgRzxUJvv6QJxfdKoOz89We', 8, 1, 1, 16, 0, 17, NULL),
(20, 'Test', 'agentoperator', 'agentoperator@test.com', '123456', '2014-09-14', 1, 'Test Department', 'Test Position', '123456', 'Test Notes', '$2a$13$VCQIjGBIohdn8xa30FGFj.OJkeFdZH7gVybPn9muggcD9B8CqfOgy', 7, 1, 1, 16, 0, 17, 18),
(21, 'Test', 'staffmember', 'staffmember@test.com', '123456', '2014-09-14', 1, 'Test Department', 'Test Position', '123456', 'Test Notes', '$2a$13$w1Kro.V4SJPkFBu5HChiEeHwRDBSccKKqWW1qPZbEqDZEZc/V9sna', 9, 1, 1, 16, 0, 17, 18),
(22, 'Test', 'admin2', 'admin2@test.com', '123456', '2014-09-14', 1, 'Test Department', 'Test Position', '123456', 'Test Notes', '$2a$13$5X3fP8TUNc/0sVUi9fwlkOqboosSxQxbpiR0GAi83GUedz9hLyTfC', 1, 1, 1, 16, 0, 17, NULL),
(23, 'Test', 'host1', 'testHost1@test.com', '123456', '2014-09-14', 1, 'Test Department', 'Test Position', '123456', 'Test Notes', '$2a$13$5X3fP8TUNc/0sVUi9fwlkOqboosSxQxbpiR0GAi83GUedz9hLyTfC', 9, 1, 1, 16, 0, 17, 18);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user_workstation`
--

INSERT INTO `user_workstation` (`id`, `user`, `workstation`, `created_by`, `is_primary`) VALUES
(1, 19, 8, 16, 1),
(2, 20, 8, 16, 1),
(3, 19, 10, 16, 1);

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
  `date_in` varchar(10) NULL,
  `time_in` time DEFAULT NULL,
  `date_out` varchar(10) NULL,
  `time_out` time DEFAULT NULL,
  `date_check_in` varchar(10) NULL,
  `time_check_in` time DEFAULT NULL,
  `date_check_out` varchar(10) NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


INSERT INTO `visit` (`id`, `visitor`, `card_type`, `card`, `visitor_type`, `reason`, `visitor_status`, `host`, `patient`, `created_by`, `date_in`, `time_in`, `date_out`, `time_out`, `date_check_in`, `time_check_in`, `date_check_out`, `time_check_out`, `visit_status`, `tenant`, `tenant_agent`, `is_deleted`,`workstation`) VALUES
(1, 2, 1, NULL, 1, 1, 1, NULL, 1, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 17, 18, 0,8),
(2, 2, 1, NULL, 1, 2, 1, NULL, 2, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 17, 18, 0,8),
(3, 2, 1, NULL, 1, 2, 1, NULL, 2, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 17, 18, 0,8),
(4, 3, 1, NULL, 1, 1, 1, NULL, 3, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 17, 18, 0,8),
(5, 3, 1, NULL, 1, 1, 1, NULL, 3, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 17, 18, 0,8),
(6, 4, 1, NULL, 2, 1, 1, 23, NULL, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 17, 18, 0,8),
(7, 2, 2, NULL, 2, 1, 1, 21, NULL, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 17, 18, 0,8);

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
  KEY `visitor_status` (`visitor_status`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;


INSERT INTO `visitor` (`id`, `first_name`, `last_name`, `email`, `contact_number`, `date_of_birth`, `company`, `department`, `position`, `staff_id`, `notes`, `password`, `role`, `visitor_type`, `visitor_status`, `created_by`, `is_deleted`, `tenant`, `tenant_agent`) VALUES
(2, 'Test', 'Visitor1', 'testVisitor1@test.com', '1234567', '1970-01-01', 1, NULL, 'Position', NULL, NULL, NULL, 10, 1, 1, 16, 0, 17, 18),
(3, 'Test', 'Visitor3', 'testVisitor3@test.com', '1234567', '1970-01-01', NULL, NULL, 'Position', NULL, NULL, NULL, 10, 1, 1, 16, 0, 17, 18),
(4, 'Test', 'Visitor4', 'testVisitor4@test.com', '1234567', '1970-01-01', 1, NULL, 'Position', NULL, NULL, NULL, 10, 2, 1, 16, 0, 17, 18);

-- --------------------------------------------------------

--
-- Table structure for table `visitor_status`
--

CREATE TABLE IF NOT EXISTS `visitor_status` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `visitor_status`
--

INSERT INTO `visitor_status` (`id`, `name`) VALUES
(1, 'Open'),
(2, 'Access Denied');

-- --------------------------------------------------------

--
-- Table structure for table `visitor_type`
--

CREATE TABLE IF NOT EXISTS `visitor_type` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `visitor_type`
--

INSERT INTO `visitor_type` (`id`, `name`, `created_by`) VALUES
(1, 'Patient Visitor', NULL),
(2, 'Corporate Visitor', NULL);

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
  `is_deleted` tinyint(2) DEFAULT  '0' NOT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `tenant` (`tenant`),
  KEY `tenant_agent` (`tenant_agent`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

INSERT INTO `visit_reason` (`id`, `reason`, `created_by`, `tenant`, `tenant_agent`, `is_deleted`) VALUES
(1, 'Reason 1', 16, NULL, NULL, 0),
(2, 'Reason 2', 16, NULL, NULL, 0);
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `visit_status`
--

INSERT INTO `visit_status` (`id`, `name`, `created_by`) VALUES
(1, 'Active', NULL),
(2, 'Pre-registered', NULL),
(3, 'Closed', NULL),
(4, 'Expired', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `workstation`
--

INSERT INTO `workstation` (`id`, `name`, `location`, `contact_name`, `contact_number`, `contact_email_address`, `number_of_operators`, `assign_kiosk`, `password`, `created_by`, `tenant`, `tenant_agent`, `is_deleted`) VALUES
(8, 'Workstation', 'PAL', 'Test Person', 123456, 'workstation1@test.com', NULL, 0, NULL, 16, 17, 18, 0),
(9, 'Workstation1', 'PAL', 'Test Person', 123456, 'workstation1@test.com', NULL, 0, NULL, 16, 17, 20, 0),
(10, 'Workstation2', 'PAL', 'Test Person', 123456, 'workstation1@test.com', NULL, 0, NULL, 16, 17, NULL, 0);



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
  ADD CONSTRAINT `visitor_ibfk_7` FOREIGN KEY (`company`) REFERENCES `company` (`id`);

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

ALTER TABLE `card_status`
  ADD CONSTRAINT `card_status_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`);

--
-- Constraints for table `workstation`
--
ALTER TABLE `workstation`
  ADD CONSTRAINT `workstation_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

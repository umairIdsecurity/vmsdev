-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 11, 2015 at 02:19 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `card_generated`
--

INSERT INTO `card_generated` (`id`, `card_code`, `date_printed`, `date_expiration`, `date_cancelled`, `date_returned`, `card_image_generated_filename`, `visitor_id`, `card_status`, `created_by`, `tenant`, `tenant_agent`) VALUES
(1, 'NAI000001', '09-03-2015', '09-03-2015', NULL, NULL, 16, 2, 3, 18, 18, NULL),
(2, 'NAI000001', '09-03-2015', '09-03-2015', NULL, '11-03-2015', 17, 2, 2, 18, 18, NULL),
(3, 'KLO000006', '11-03-2015', '11-03-2015', NULL, NULL, 22, 5, 3, 24, 19, 24),
(4, 'KLO000006', '11-03-2015', '11-03-2015', NULL, NULL, 22, 5, 3, 24, 19, 24),
(5, 'KLO000007', '11-03-2015', '11-03-2015', NULL, NULL, 25, 6, 3, 19, 19, NULL),
(6, 'KLO000007', '11-03-2015', '11-03-2015', NULL, NULL, 26, 6, 3, 19, 19, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `code`, `name`, `trading_name`, `logo`, `contact`, `billing_address`, `email_address`, `office_number`, `mobile_number`, `website`, `company_laf_preferences`, `created_by_user`, `created_by_visitor`, `tenant`, `tenant_agent`, `is_deleted`) VALUES
(1, 'IDS', 'Identity Security', 'Identity Security', 2, 'Test Person', '123 street', 'idescurity@test.com', 12345, 12345, 'http://idsecurity.com.au', NULL, NULL, NULL, 16, 16, 0),
(3, 'SAI', 'Stableapps', 'Stableapps', 3, '', '', '', NULL, NULL, '', NULL, NULL, NULL, 17, NULL, 1),
(4, 'NAI', 'NAIA', 'Ninoy Aquino International Airport', 4, '', '', '', NULL, NULL, 'http://www.miaa.gov.ph/', 2, NULL, NULL, 18, NULL, 0),
(5, 'CRK', 'Clark International Airport', 'Clark International Airport', 5, '', '', '', NULL, NULL, 'http://www.clarkairport.com/', 3, NULL, NULL, 26, NULL, 0),
(6, 'KLO', 'Kalibo International Airport', 'Kalibo International Airport', 6, '', '', '', NULL, NULL, '', NULL, NULL, NULL, 19, NULL, 0),
(7, 'PAL', 'Philippine Airlines', 'Philippine Airlines', 7, '', '', '', NULL, NULL, '', 1, NULL, NULL, 18, 21, 0),
(8, 'CEB', 'Cebu Pacific', 'Cebu Pacific Air', 8, '', '', '', NULL, NULL, '', NULL, NULL, NULL, 18, 23, 0),
(9, 'JAL', 'Japan Airlines', 'Japan Airlines', 9, '', '', '', NULL, NULL, '', NULL, NULL, NULL, 19, 24, 0),
(10, 'KAL', 'Korean Air', 'Korean Air', 10, '', '', '', NULL, NULL, '', NULL, NULL, NULL, 26, 27, 0),
(11, 'PAL', 'Philippine Airlines-KALIBO', 'Philippine Airlines-KALIBO', 12, '', 'Kalibo', '', NULL, NULL, '', NULL, NULL, NULL, 19, 28, 0),
(12, 'VCO', 'Visitor Company', 'Visitor Company', 13, '', '', '', NULL, NULL, '', NULL, NULL, NULL, 18, NULL, 0),
(13, 'GOO', 'Google', 'Google', 14, '', '', '', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, 0),
(14, 'YHO', 'Yahoo', 'Yahoo', 18, '', '', '', NULL, NULL, '', NULL, NULL, NULL, 26, 27, 0),
(15, 'SAM', 'Samsung', 'Samsung', 21, '', '', '', NULL, NULL, '', NULL, NULL, NULL, 19, 24, 0),
(16, 'YHO', 'Yahoo', 'Yahoo', 24, '', '', '', NULL, NULL, '', NULL, NULL, NULL, 19, NULL, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `company_laf_preferences`
--

INSERT INTO `company_laf_preferences` (`id`, `action_forward_bg_color`, `action_forward_bg_color2`, `action_forward_font_color`, `action_forward_hover_color`, `action_forward_hover_color2`, `action_forward_hover_font_color`, `complete_bg_color`, `complete_bg_color2`, `complete_hover_color`, `complete_hover_color2`, `complete_font_color`, `complete_hover_font_color`, `neutral_bg_color`, `neutral_bg_color2`, `neutral_hover_color`, `neutral_hover_color2`, `neutral_font_color`, `neutral_hover_font_color`, `nav_bg_color`, `nav_hover_color`, `nav_font_color`, `nav_hover_font_color`, `sidemenu_bg_color`, `sidemenu_hover_color`, `sidemenu_font_color`, `sidemenu_hover_font_color`, `css_file_path`) VALUES
(1, '#6b7df7', '#c3d1aa', '#ffffff', '#9395b5', '#9487c9', '#ffffff', '#e67171', '#d42222', '#e67171', '#d42222', '#ffffff', '#ffffff', '#5fdaf5', '#33bcdb', '#33bcdb', '#33bcdb', '#ffffff', '#ffffff', '#E7E7E7', '#cb30d9', '#637280', '#ffffff', '#E7E7E7', '#E7E7E7', '#637280', '#637280', '/company_css/PAL-1426051998.css'),
(2, '#c6f76b', '#9ED92F', '#ffffff', '#c6f76b', '#9ED92F', '#ffffff', '#e67171', '#d42222', '#e67171', '#d42222', '#ffffff', '#ffffff', '#5fdaf5', '#33bcdb', '#33bcdb', '#33bcdb', '#ffffff', '#ffffff', '#E7E7E7', '#2b4fba', '#637280', '#ffffff', '#E7E7E7', '#E7E7E7', '#637280', '#637280', '/company_css/NAI-1426052053.css'),
(3, '#c6f76b', '#9ED92F', '#ffffff', '#c6f76b', '#9ED92F', '#ffffff', '#e67171', '#d42222', '#e67171', '#d42222', '#ffffff', '#ffffff', '#5fdaf5', '#33bcdb', '#33bcdb', '#33bcdb', '#ffffff', '#ffffff', '#E7E7E7', '#d97330', '#637280', '#ffffff', '#E7E7E7', '#E7E7E7', '#637280', '#637280', '/company_css/CRK-1426053301.css');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `photo`
--

INSERT INTO `photo` (`id`, `filename`, `unique_filename`, `relative_path`) VALUES
(1, 'personal.png', '29200577-1411087522.jpg', 'uploads/company_logo/29200577-1411087522.jpg'),
(2, 'ids-logo2.jpg', '1411087524.jpg', 'uploads/company_logo/1411087524.jpg'),
(3, 'Logo_bite_2.png', '4e5607a6-1425798711.jpg', 'uploads/company_logo/4e5607a6-1425798711.jpg'),
(4, 'NAIA.png', '4e5607a6-1425799334.jpg', 'uploads/company_logo/4e5607a6-1425799334.jpg'),
(5, 'Clark_Airport_Logo.png', '4e5607a6-1425799450.jpg', 'uploads/company_logo/4e5607a6-1425799450.jpg'),
(6, 'kalibo_Airport.png', '4e5607a6-1425801358.jpg', 'uploads/company_logo/4e5607a6-1425801358.jpg'),
(7, 'pal.png', '4e5607a6-1425801808.jpg', 'uploads/company_logo/4e5607a6-1425801808.jpg'),
(8, 'cebupacific.png', '4e5607a6-1425801984.jpg', 'uploads/company_logo/4e5607a6-1425801984.jpg'),
(9, 'jal.png', '4e5607a6-1425802221.jpg', 'uploads/company_logo/4e5607a6-1425802221.jpg'),
(10, 'KAL.png', '4e5607a6-1425804326.jpg', 'uploads/company_logo/4e5607a6-1425804326.jpg'),
(11, 'pal.png', '4e5607a6-1425820977.jpg', 'uploads/company_logo/4e5607a6-1425820977.jpg'),
(12, 'pal.png', '4e5607a6-1425827107.jpg', 'uploads/company_logo/4e5607a6-1425827107.jpg'),
(13, 'visitor_company_logo.png', '4e5607a6-1425827975.jpg', 'uploads/company_logo/4e5607a6-1425827975.jpg'),
(14, 'google.jpg', '4e5607a6-1425889321.jpg', 'uploads/company_logo/4e5607a6-1425889321.jpg'),
(15, 'tuxedo.png', '2c2d0581-1425892162.jpg', 'uploads/visitor/2c2d0581-1425892162.jpg'),
(16, 'card367b0637-1425892196.png', 'card367b0637-1425892196.png', 'uploads/card_generated/card367b0637-1425892196.png'),
(17, 'card367b0637-1425892197.png', 'card367b0637-1425892197.png', 'uploads/card_generated/card367b0637-1425892197.png'),
(18, 'yahoo.jpg', '4e5607a6-1426054208.jpg', 'uploads/company_logo/4e5607a6-1426054208.jpg'),
(19, 'IMG_1176.JPG', '4e5607a6-1426054300.jpg', 'uploads/visitor/4e5607a6-1426054300.jpg'),
(20, 'golden-retriever-0007.jpg', '495f072e-1426055548.jpg', 'uploads/visitor/495f072e-1426055548.jpg'),
(21, 'Samsung.png', '495f072e-1426055643.jpg', 'uploads/company_logo/495f072e-1426055643.jpg'),
(22, 'card54be07ed-1426055717.png', 'card54be07ed-1426055717.png', 'uploads/card_generated/card54be07ed-1426055717.png'),
(23, 'card54be07ed-1426055717.png', 'card54be07ed-1426055717.png', 'uploads/card_generated/card54be07ed-1426055717.png'),
(24, 'yahoo.jpg', '26e0052e-1426055847.jpg', 'uploads/company_logo/26e0052e-1426055847.jpg'),
(25, 'card5db80855-1426056044.png', 'card5db80855-1426056044.png', 'uploads/card_generated/card5db80855-1426056044.png'),
(26, 'card5db80855-1426056045.png', 'card5db80855-1426056045.png', 'uploads/card_generated/card5db80855-1426056045.png'),
(27, 'yahoo.jpg', '4e5607a6-1426068484.jpg', 'uploads/visitor/4e5607a6-1426068484.jpg'),
(28, 'yahoo.jpg', '4e5607a6-1426068499.jpg', 'uploads/visitor/4e5607a6-1426068499.jpg');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `contact_number`, `date_of_birth`, `company`, `department`, `position`, `staff_id`, `notes`, `password`, `role`, `user_type`, `user_status`, `created_by`, `is_deleted`, `tenant`, `tenant_agent`) VALUES
(16, 'IDS', 'Test', 'superadmin@test.com', '9998798', '1993-01-01', 1, '', '', '', '', '$2a$13$wv.A6T0CCHXczYv/tlJP6./6qUvDdOy.g8KX.FqSos1Mf6MA7Xl66', 5, 1, 1, 16, 0, 16, 16),
(17, 'Admin1', 'Stableapps', 'admin1@sai.com', '123456', '2015-03-08', 3, '', '', '', '', '$2a$13$jFC48AFC3sXaFn/T3NQOAe/up8las.9ajcdyTS9vo2uvuN5eC9eom', 1, 1, 1, 16, 1, 17, NULL),
(18, 'Admin1', 'NAIA', 'admin1@naia.com', '1242124', '2015-03-08', 4, '', '', '', '', '$2a$13$H5cj5CcApJC3G/Pyqmg04eB3UFPExid77NRvlqKb8rKRJsjw.Jn7G', 1, 1, 1, 16, 0, 18, NULL),
(19, 'Admin1', 'Kalibo', 'admin1@klo.com', '12255', '2015-03-08', 6, '', '', '', '', '$2a$13$sQspbOdfFByrzbY2zMzD3O4By.VWX32vHpFvOXXdPXeBinhXKb.fe', 1, 1, 1, 16, 0, 19, NULL),
(20, 'Admin2', 'NAIA', 'admin2@naia.com', '163326', '2015-03-08', 4, '', '', '', '', '$2a$13$tk7KVuVRK8cidYzIONdqUO/s49.3657bqt6WSrivprg0LhXOk/gnO', 1, 1, 1, 16, 0, 18, NULL),
(21, 'AgentAdmin1', 'PAL', 'agentadmin1@pal.com', '573437', '2015-03-08', 7, '', '', '', '', '$2a$13$N0FiVaOjzPWkIGdheeBUiOw.YRCZRKISDOTlakhDUV2ZbwrpB81iq', 6, 1, 1, 16, 0, 18, 21),
(22, 'AgentAdmin2', 'PAL', 'agentadmin2@pal.com', '5848888', '2015-03-08', 7, '', '', '', '', '$2a$13$7kVUYK6zF1S6bgYzOgLrweHZg47l3Kr8Vds7ITIdS07jeZM6cDBHy', 6, 1, 1, 16, 0, 18, 21),
(23, 'AgentAdmin1', 'Cebu', 'agentadmin1@ceb.com', '435255', '2015-03-08', 8, '', '', '', '', '$2a$13$LJZZ.CNekPOdaVIzPYdU1eCuO4ib5NSWYGv3Y1nMviIWNkHHA/xQa', 6, 1, 1, 16, 0, 18, 23),
(24, 'AgentAdmin1', 'JAL', 'agentadmin1@jal.com', '5325151', '2015-03-08', 9, '', '', '', '', '$2a$13$JM1C8KnAUCtOL47LF.EObOsTMi5BVXbNdobjpq40gE.i1lzsujpH6', 6, 1, 1, 16, 0, 19, 24),
(25, 'Operator1', 'NAIA', 'operator1@naia.com', '983552', '2015-03-08', 4, '', '', '', '', '$2a$13$bb9HS3XMLtRQTLG9axa0M.3QPMdXPujqHExKMhxOwLl2fyxZixtQO', 8, 1, 1, 16, 0, 18, NULL),
(26, 'Admin1', 'Clark', 'admin@clark.com', '1842424', '2015-03-08', 5, '', '', '', '', '$2a$13$H40xkISGPuziQhp5779vxuZaZ653Xymk7/JPPYhRh5OCnsocAbKWO', 1, 1, 1, 16, 0, 26, NULL),
(27, 'AgentAdmin1', 'KAL', 'agentadmin1@kal.com', '7855225', '2015-03-08', 10, '', '', '', '', '$2a$13$P7o0/mLjpPG.RYZ2GHR30.udIbdsf7o0KGPRoDTzzhQUD7iio8sFm', 6, 1, 1, 16, 0, 26, 27),
(28, 'Operator1', 'Clark', 'operator1@clark.com', '34636463', '2015-03-08', 5, '', '', '', '', '$2a$13$FntnAMfxGMsLVSpHNsAnlO5VikwxANCcHcQXp4BVcnSCC1gXEHlou', 8, 1, 1, 16, 0, 26, NULL),
(29, 'AgentOperator1', 'KAL', 'agentoperator1@kal.com', '43636336', '2015-03-08', 10, '', '', '', '', '$2a$13$qP0sboL1wRKm4GKrjJupTOsE7cyYzBfrtSQBeAd5Z/lomo2kJzpdW', 7, 1, 1, 16, 0, 26, 27),
(30, 'Staff1', 'NAIA', 'staff1@naia.com', '352526', '2015-03-08', 4, '', '', '', '', '$2a$13$fmjftvPGWRACIIhgIBy/6uSsXquqBYFivFDpa9GIppMZf7k/T6S5C', 9, 1, 1, 16, 0, 18, NULL),
(31, 'Staff1', 'Clark', 'staff1@clark.com', '3637777', '2015-03-08', 5, '', '', '', '', '$2a$13$uMdper8qobO5xBe3feXo4.B8YpN63Fr7WtF12xTGPa.0ljMBFXJqe', 9, 1, 1, 16, 0, 26, NULL),
(32, 'Staff1', 'Kalibo', 'staff1@kalibo.com', '3465436', '2015-03-08', 6, '', '', '', '', '$2a$13$IpXlHNsH.xmwA1EwDOWDh.L1Fh/HUlHuMhqV0XEG/HwLnu9up3FWO', 9, 1, 1, 16, 0, 19, NULL),
(33, 'Staff2', 'Kalibo', 'staff2@kalibo.com', '5647677', '2015-03-08', 6, '', '', '', '', '$2a$13$1utHlCq.ssB3HLgy/e3lFuzZ66rGRy8xsYsSlH/p9H7ZJ8E1TgWwS', 9, 1, 1, 16, 0, 19, NULL),
(34, 'Staff1', 'PAL', 'staff1@pal.com', '1234522', '2015-03-08', 7, '', '', '', '', '$2a$13$jY1VfCHSAqaW2pH9q4rN0ufHuNdM2DkH3XfBoHisb9C2AQXVex9ti', 9, 1, 1, 16, 0, 18, 21),
(35, 'Staff1', 'Cebu', 'staff1@ceb.com', '857396', '2015-03-08', 8, '', '', '', '', '$2a$13$YJeSXtJjXJIjyRLzZHc6huIy3tYLOH8i6jpoyVtNnnm69qKzWSej.', 9, 1, 1, 16, 1, 18, 23),
(36, 'Staff1', 'KAL', 'staff1@kal.com', '86863', '2015-03-08', 10, '', '', '', '', '$2a$13$EzsFEVswn83Z9AZSJomt4enYQyRIHMMTmxHoCc4gMaQoS6ZGB5x/G', 9, 1, 1, 16, 0, 26, 27),
(37, 'Staff1', 'JAL', 'staff1@jal.com', '77482842', '2015-03-08', 9, '', '', '', '', '$2a$13$ccmJg7BLv10SkE9Yh5HmzOBvhjY1bflBm20jKE3gy6wF3roLOb0Hm', 9, 1, 1, 16, 0, 19, 24),
(38, 'AgentOperator1', 'PAL', 'agentoperator1@pal.com', '644774', '2015-03-08', 7, '', '', '', '', '$2a$13$kBJgcViRX4unpLt5DQtcc.uZ.Wg2MiupcbGZSY8d5sM.K2rv.tdb.', 7, 1, 1, 16, 0, 18, 21),
(39, 'AgentOperator1', 'Cebu', 'agentoperator1@ceb.com', '74843', '2015-03-08', 8, '', '', '', '', '$2a$13$dgBuU2dit9Xc/4wl3dWqouu3YZXeEgLPNB7.EEOHf0EgWbMt6hqKm', 7, 1, 1, 16, 0, 18, 23),
(40, 'AgentOperator1', 'JAL', 'agentoperator1@jal.com', '47777', '2015-03-08', 9, '', '', '', '', '$2a$13$qOn8RJNenp/d.JDhwa0gFu1zWIiAaf6Fhn9LpchiNkzdKAa1Li8cS', 7, 1, 1, 16, 0, 19, 24),
(41, 'Operator2', 'NAIA', 'operator2@naia.com', '879022', '2015-03-08', 4, '', '', '', '', '$2a$13$dvPsldIEPwtpRO.oYfavHeNYmCvlK7aUB0SFufKc2zQCnluP0fcJu', 8, 1, 1, 16, 0, 18, NULL),
(42, 'Operator1', 'Kalibo', 'operator1@kalibo.com', '999399', '2015-03-08', 6, '', '', '', '', '$2a$13$zEgur4weiI.CdEmApcIQb.9.o3z5NLcmteANPL1DDcLj7/bkSg7pi', 8, 1, 1, 16, 0, 19, NULL),
(43, 'AgentAdmin2', 'KAL', 'agentadmin2@kal.com', '89472', '2015-03-08', 10, '', '', '', '', '$2a$13$LWby6GPoFsUEJUomv5OGzORacPQ7fchxXtwrKIgu6MgYHFdZv/4Qi', 6, 1, 1, 26, 0, 26, 27),
(44, 'Admin2', 'Clark', 'admin2@clark.com', '56282', '2015-03-08', 5, '', '', '', '', '$2a$13$Pg0xMKS8EPujFPZOtN/k8OurVzxyjHDuA//0AKXKhppdckHT76as2', 1, 1, 1, 26, 0, 26, NULL),
(45, 'AgentAdmin2', 'Cebu', 'agentadmin2@ceb.com', '947722', '2015-03-08', 8, '', '', '', '', '$2a$13$La2kfepBwmaan/c8j5NRFub41zrVyHbjgmXiQM.8r3hzRNOVcKlSK', 6, 1, 1, 23, 0, 18, 23),
(46, 'Admin2', 'Kalibo', 'admin2@kalibo.com', '966262', '2015-03-08', 6, '', '', '', '', '$2a$13$PKXLBAzDP/PkcVdU/mwxHuJsTFaXWOZ8pmUQJpWlxZVRPcdPKCvFa', 1, 1, 1, 16, 0, 19, NULL),
(47, 'AgentAdmin1', 'PAL-Kalibo', 'agentadmin1klo@pal.com', '64647', '2015-03-08', 11, '', '', '', '', '$2a$13$YaOGFU1lmwKqwHmNzffim.fDTszSM9dtzXi9Eq2rZbfsPt8wUd0rm', 6, 1, 1, 16, 0, 19, 47),
(48, 'AgentAdmin2', 'PAL-Kalibo', 'agentadmin2klo@pal.com', '63666', '2015-03-09', 11, '', '', '', '', '$2a$13$B6hsEeOveV/IBdCHcinatuaEDr7/wMGiZB3hwZZeoZbT6MYvL3gYK', 6, 1, 1, 16, 0, 19, 28),
(49, 'Staff1ReAdded', 'Cebu', 'staff1@ceb.com', '626262', '2015-03-11', 8, '', '', '', '', '$2a$13$p2DsSj2m4TYC937e0JwcHO2xcG5CXg96zTp7miUXArl54TgKdeJiG', 9, 1, 1, 16, 0, 18, 23);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `user_workstation`
--

INSERT INTO `user_workstation` (`id`, `user`, `workstation`, `created_by`, `is_primary`) VALUES
(5, 28, 15, 16, 1),
(6, 29, 16, 16, 1),
(8, 39, 11, 16, 1),
(10, 41, 18, 16, 1),
(11, 42, 14, 16, 1),
(12, 25, 18, 16, 0),
(19, 40, 12, 16, 0),
(23, 38, 8, 21, 0),
(24, 38, 13, 21, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `visit`
--

INSERT INTO `visit` (`id`, `visitor`, `card_type`, `card`, `visitor_type`, `reason`, `visitor_status`, `host`, `patient`, `created_by`, `date_in`, `time_in`, `date_out`, `time_out`, `date_check_in`, `time_check_in`, `date_check_out`, `time_check_out`, `visit_status`, `workstation`, `tenant`, `tenant_agent`, `is_deleted`) VALUES
(1, 2, 1, 2, 2, 1, 1, 30, NULL, 16, NULL, NULL, '10-03-2015', '00:00:00', '09-03-2015', '17:09:48', '11-03-2015', '14:06:08', 3, 18, 18, NULL, 0),
(2, 3, 1, NULL, 2, 1, 1, 35, NULL, 23, NULL, NULL, '12-03-2015', '00:00:00', '11-03-2015', '13:36:34', NULL, '00:00:00', 1, 11, 18, 23, 0),
(3, 2, 2, 2, 2, 1, 1, 30, NULL, 16, '13-03-2015', '14:01:00', '', '00:00:00', '', '00:00:00', '', '00:00:00', 2, 18, 18, NULL, 0),
(4, 4, 2, NULL, 2, 1, 1, 36, NULL, 16, NULL, NULL, NULL, '00:00:00', NULL, NULL, NULL, '00:00:00', 5, 16, 26, 27, 0),
(5, 2, 1, NULL, 2, 1, 1, 30, NULL, 30, NULL, NULL, '12-03-2015', '00:00:00', '11-03-2015', '15:21:07', NULL, '00:00:00', 1, 18, 18, NULL, 0),
(6, 5, 1, 4, 2, 1, 1, 37, NULL, 24, NULL, NULL, '12-03-2015', '00:00:00', '11-03-2015', '14:35:08', NULL, '00:00:00', 1, 12, 19, 24, 0),
(7, 6, 1, 6, 2, 1, 1, 42, NULL, 19, NULL, NULL, '12-03-2015', '00:00:00', '11-03-2015', '14:40:36', NULL, '00:00:00', 1, 14, 19, NULL, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `visitor`
--

INSERT INTO `visitor` (`id`, `first_name`, `last_name`, `email`, `contact_number`, `date_of_birth`, `company`, `department`, `position`, `staff_id`, `notes`, `password`, `role`, `visitor_type`, `visitor_status`, `vehicle`, `photo`, `created_by`, `is_deleted`, `tenant`, `tenant_agent`) VALUES
(2, 'Visitor1-NAIA', 'VCO', 'visitor1@vco.com', '83742', '1970-01-01', 12, NULL, '', NULL, NULL, '$2a$13$/tFx6ghFOfMzszQI2xOMHuPe1KNB3TNFf2YrSMlcGt67iuwNRA1FC', 10, NULL, 3, NULL, 15, 18, 0, 18, NULL),
(3, 'Visitor2-NAIACeb', 'Google', 'visitor2@goo.com', '64777', '1970-01-01', 8, NULL, '', NULL, NULL, '$2a$13$4tC9yBO6ZaS01oZOWk/QE.nnKXmiDcdWOISbTgSdhYm0jDq3Ew4Jy', 10, NULL, 3, NULL, NULL, 16, 0, 18, 23),
(4, 'Visitor3-CRK-KAL', 'Yahoo', 'vistor3@yahoo.com', '32542566', '1970-01-01', 14, NULL, '', NULL, NULL, '$2a$13$uBZTbnQd.me3xErG2S1dnuH3w4qxED/P.s0llQwoq8hjB0yAD5W/.', 10, NULL, 1, NULL, 19, 16, 0, 26, 27),
(5, 'Visitor1-KLO-JAL', 'Samsung', 'visitor1@samsung.com', '182834', '1970-01-01', 15, NULL, '', NULL, NULL, '$2a$13$0Z9YoA3i0RjWI8aDZ7ndXO6D22oP22SJR2pNTwD8DKUqlEcLE.5jO', 10, NULL, 3, NULL, 20, 24, 0, 19, 24),
(6, 'Visitor1-KLO', 'Yahoo', 'visitor1klo@yahoo.com', '35525', '1970-01-01', 16, NULL, '', NULL, NULL, '$2a$13$GsG7ngquk5QNi16TDukoRuCy3wiQTh.ZC6yyJg6j6vh5h33FDFEI6', 10, NULL, 1, NULL, NULL, 19, 0, 19, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `visit_reason`
--

INSERT INTO `visit_reason` (`id`, `reason`, `created_by`, `tenant`, `tenant_agent`, `is_deleted`) VALUES
(1, 'Inspection', 18, NULL, NULL, 0);

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
(8, 'PAL Workstation 1', 'PAL Gate 1 NAIA', 'Test Person', 123456, 'workstation1@test.com', NULL, 0, NULL, 16, 18, 21, 0),
(11, 'CEB Workstation 1', 'CEB Gate 1 - NAIA', 'Operator CEB', 532525, '', NULL, 0, '$2a$13$PXAOJIFAFrN/B8is93dNyuzxkDH6PiUzeRidP/x8zWo', 16, 18, 23, 0),
(12, 'JAL Workstation 1', 'JAL Gate 1 - KLO', '', NULL, '', NULL, 0, '$2a$13$MgiKPFOeuT0XMuvKU4x4LOZOLM1tBGmQkVwgdaNqSJz', 16, 19, 24, 0),
(13, 'PAL Workstation 2', 'PAL Gate 2 - NAIA', '', NULL, '', NULL, 0, '$2a$13$bAZtcdegsDzhvh897J7rduvLBSF5JyWk8MvS.g8NrmN', 16, 18, 21, 0),
(14, 'Kalibo Workstation 1', 'Gate 1 - KLO', '', NULL, '', NULL, 0, '$2a$13$w7a8Pd2cLj8cumGlcNQaSO497PgMjSkQVdVC79LkPxk', 16, 19, NULL, 0),
(15, 'Clark Workstation 1', 'Clark Gate 1', '', NULL, '', NULL, 0, '$2a$13$.zpTL8VyFRR72NH15HKoz.d9G3faeKE2foPz2LKsJZ8', 16, 26, NULL, 0),
(16, 'KAL Workstation 1', 'KAL Gate 1 - Clark', '', NULL, '', NULL, 0, '$2a$13$tkVvcIsW0RWGY2oxC...7uS7ST2foOovqy/sLTTjYiw', 16, 26, 27, 0),
(17, 'NAIA Workstation 1', 'Gate 1 - NAIA', '', NULL, '', NULL, 0, '$2a$13$ifVC1mza1zOhc/ADp.xAVemQVRAtUT2ccQbfmuoybN/', 16, 18, NULL, 1),
(18, 'NAIA Workstation 1', 'NAIA Gate 1', '', NULL, '', NULL, 0, '$2a$13$g7N3NULZdsafowcfBYRT5eXNgYd/K/uta6AZgLN17QG', 16, 18, NULL, 0),
(19, 'NAIA Workstation 2', 'NAIA Gate 2', '', NULL, '', NULL, 0, '$2a$13$RrcIV7mOEbnahHIA3MAru./qOwnRfbXPeZzZ0XGOfRo', 16, 18, NULL, 1),
(20, 'PAL Workstation 3', 'PAL Gate 3 - NAIA', '', NULL, '', NULL, 0, '$2a$13$yjuaZGuUpZDTR4iYSo1dy.V0W0jraFMLLz23VX6lIbD', 21, 18, 21, 1),
(21, 'PAL Workstation 4', 'PAL Gate 4 - NAIA', '', NULL, '', NULL, 0, '$2a$13$Ryak/IaaPvbLt3jfAwFsQO17pcfztwCc4Zpvh98m0.B', 18, 18, 21, 1),
(22, 'Clark Workstation 3', 'Clark Gate 3', '', NULL, '', NULL, 0, '$2a$13$0XkB15QecAhNGeAqDiVwzOu0sx2onrgm51eAj8m055h', 16, 26, NULL, 1);

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

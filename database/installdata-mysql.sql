-- phpMyAdmin SQL Dump
-- version 4.0.10.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 12, 2015 at 12:57 PM
-- Server version: 5.5.42
-- PHP Version: 5.4.38

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `vmsstage`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_tokens`
--

DROP TABLE IF EXISTS `access_tokens`;
CREATE TABLE IF NOT EXISTS `access_tokens` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `USER_ID` int(11) NOT NULL,
  `ACCESS_TOKEN` varchar(255) NOT NULL,
  `EXPIRY` datetime DEFAULT NULL,
  `CLIENT_ID` int(11) NOT NULL,
  `CREATED` datetime NOT NULL,
  `MODIFIED` datetime NOT NULL,
  `USER_TYPE` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `audit_trail`
--

DROP TABLE IF EXISTS `audit_trail`;
CREATE TABLE IF NOT EXISTS `audit_trail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) DEFAULT NULL,
  `old_value` varchar(255) DEFAULT NULL,
  `new_value` varchar(255) DEFAULT NULL,
  `action` varchar(20) DEFAULT NULL,
  `model` varchar(45) DEFAULT NULL,
  `model_id` bigint(20) DEFAULT NULL,
  `field` varchar(45) DEFAULT NULL,
  `creation_date` datetime NOT NULL,
  `user_id` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



-- --------------------------------------------------------

--
-- Table structure for table `cardstatus_convert`
--

DROP TABLE IF EXISTS `cardstatus_convert`;
CREATE TABLE IF NOT EXISTS `cardstatus_convert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visitor_id` bigint(20) NOT NULL,
  `convert_time` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `card_generated`
--

DROP TABLE IF EXISTS `card_generated`;
CREATE TABLE IF NOT EXISTS `card_generated` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `card_number` varchar(10) DEFAULT NULL,
  `date_printed` date DEFAULT NULL,
  `date_expiration` date DEFAULT NULL,
  `date_cancelled` date DEFAULT NULL,
  `date_returned` date DEFAULT NULL,
  `card_image_generated_filename` bigint(20) DEFAULT NULL,
  `visitor_id` bigint(20) DEFAULT NULL,
  `card_status` bigint(20) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `tenant` bigint(20) DEFAULT NULL,
  `tenant_agent` bigint(20) DEFAULT NULL,
  `print_count` bigint(20) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `card_image_generated_filename` (`card_image_generated_filename`),
  KEY `created_by` (`created_by`),
  KEY `tenant` (`tenant`),
  KEY `tenant_agent` (`tenant_agent`),
  KEY `card_status` (`card_status`),
  KEY `visitor_id` (`visitor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


--
-- Table structure for table `card_status`
--

DROP TABLE IF EXISTS `card_status`;
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

DROP TABLE IF EXISTS `card_type`;
CREATE TABLE IF NOT EXISTS `card_type` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `max_day_validity` int(10) DEFAULT NULL,
  `max_time_validity` varchar(50) DEFAULT NULL,
  `max_entry_count_validity` int(10) DEFAULT NULL,
  `card_icon_type` text,
  `card_background_image_path` text,
  `created_by` bigint(20) DEFAULT NULL,
  `module` bigint(20) DEFAULT NULL,
  `back_text` text,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `card_type_module` (`module`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `card_type`
--

INSERT INTO `card_type` (`id`, `name`, `max_day_validity`, `max_time_validity`, `max_entry_count_validity`, `card_icon_type`, `card_background_image_path`, `created_by`, `module`, `back_text`) VALUES
(1, 'Same Day Visitor', 1, NULL, NULL, 'images/same_day_vic.png', 'images/corporate/same-day.png', NULL, 1, NULL),
(2, 'Multiday Visitor', NULL, NULL, NULL, 'images/multi_day_vic.png', 'images/corporate/multi-day.png', NULL, 1, NULL),
(3, 'Manual', NULL, NULL, NULL, NULL, 'images/corporate/manual.png', NULL, 1, NULL),
(4, 'Contractor', NULL, NULL, NULL, NULL, 'images/corporate/contractor.png', NULL, 1, NULL),
(5, 'Same Day', NULL, NULL, NULL, NULL, 'images/vic/same_day.png', NULL, 2, NULL),
(6, '24 Hour', NULL, NULL, NULL, NULL, 'images/vic/24_hour.png', NULL, 2, NULL),
(7, 'Extended', NULL, NULL, NULL, NULL, 'images/vic/extended.png', NULL, 2, NULL),
(8, 'Multi Day', NULL, NULL, NULL, NULL, 'images/vic/multi_day.png', NULL, 2, NULL),
(9, 'Manual', NULL, NULL, NULL, NULL, 'images/vic/manual.png', NULL, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
CREATE TABLE IF NOT EXISTS `company` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(3) NOT NULL,
  `name` varchar(150) NOT NULL,
  `trading_name` varchar(150) DEFAULT NULL,
  `logo` bigint(20) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `billing_address` varchar(150) DEFAULT NULL,
  `email_address` varchar(50) DEFAULT NULL,
  `office_number` varchar(20) DEFAULT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `website` varchar(50) DEFAULT NULL,
  `company_laf_preferences` bigint(20) DEFAULT NULL,
  `created_by_user` bigint(20) DEFAULT NULL,
  `created_by_visitor` bigint(20) DEFAULT NULL,
  `tenant` bigint(20) DEFAULT NULL,
  `tenant_agent` bigint(20) DEFAULT NULL,
  `is_deleted` int(12) DEFAULT '0',
  `card_count` bigint(20) DEFAULT NULL,
  `company_type` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by_visitor` (`created_by_visitor`),
  KEY `created_by_user` (`created_by_user`),
  KEY `tenant_agent` (`tenant_agent`),
  KEY `tenant` (`tenant`),
  KEY `company_laf_preferences` (`company_laf_preferences`),
  KEY `logo` (`logo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `code`, `name`, `trading_name`, `logo`, `contact`, `billing_address`, `email_address`, `office_number`, `mobile_number`, `website`, `company_laf_preferences`, `created_by_user`, `created_by_visitor`, `tenant`, `tenant_agent`, `is_deleted`, `card_count`, `company_type`) VALUES
(1, 'IDS', 'Identity Security', 'Identity Security', 1, '2147483647', 'PO BOX 710 Port Melbourne VIC 3207', 'admin@idsecurity.com.au', '2147483647', '2147483647', 'http://idsecurity.com.au', 1, NULL, NULL, 1, 1, 0, NULL, NULL);


-- --------------------------------------------------------

--
-- Table structure for table `company_laf_preferences`
--

DROP TABLE IF EXISTS `company_laf_preferences`;
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `company_laf_preferences`
--

INSERT INTO `company_laf_preferences` (`id`, `action_forward_bg_color`, `action_forward_bg_color2`, `action_forward_font_color`, `action_forward_hover_color`, `action_forward_hover_color2`, `action_forward_hover_font_color`, `complete_bg_color`, `complete_bg_color2`, `complete_hover_color`, `complete_hover_color2`, `complete_font_color`, `complete_hover_font_color`, `neutral_bg_color`, `neutral_bg_color2`, `neutral_hover_color`, `neutral_hover_color2`, `neutral_font_color`, `neutral_hover_font_color`, `nav_bg_color`, `nav_hover_color`, `nav_font_color`, `nav_hover_font_color`, `sidemenu_bg_color`, `sidemenu_hover_color`, `sidemenu_font_color`, `sidemenu_hover_font_color`, `css_file_path`) VALUES
(1, '#9ED92F', '#9ED92F', '#ffffff', '#9ED92F', '#9ED92F', '#ffffff', '#0d0d0c', '#a1999a', '#998e8e', '#b0a9a9', '#ffffff', '#ffffff', '#33bcdb', '#33bcdb', '#33bcdb', '#33bcdb', '#ffffff', '#ffffff', '#E7E7E7', '#30c5d9', '#637280', '#ffffff', '#E7E7E7', '#E7E7E7', '#1670c4', '#157cdb', '/company_css/IDS-1424944653.css');

-- --------------------------------------------------------

--
-- Table structure for table `company_type`
--

DROP TABLE IF EXISTS `company_type`;
CREATE TABLE IF NOT EXISTS `company_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `company_type`
--

INSERT INTO `company_type` (`id`, `name`, `created_by`) VALUES
(1, 'Tenant', NULL),
(2, 'Tenant Agent', NULL),
(3, 'Visitor', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contact_person`
--

DROP TABLE IF EXISTS `contact_person`;
CREATE TABLE IF NOT EXISTS `contact_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_person_name` varchar(50) NOT NULL,
  `contact_person_email` varchar(50) NOT NULL,
  `contact_person_message` varchar(100) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` bigint(20) DEFAULT NULL,
  `tenant` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
CREATE TABLE IF NOT EXISTS `country` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `code` char(2) NOT NULL DEFAULT '',
  `name` varchar(45) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=251 ;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `code`, `name`) VALUES
(1, 'AD', 'Andorra'),
(2, 'AE', 'United Arab Emirates'),
(3, 'AF', 'Afghanistan'),
(4, 'AG', 'Antigua and Barbuda'),
(5, 'AI', 'Anguilla'),
(6, 'AL', 'Albania'),
(7, 'AM', 'Armenia'),
(8, 'AO', 'Angola'),
(9, 'AQ', 'Antarctica'),
(10, 'AR', 'Argentina'),
(11, 'AS', 'American Samoa'),
(12, 'AT', 'Austria'),
(13, 'AU', 'Australia'),
(14, 'AW', 'Aruba'),
(15, 'AX', 'Åland'),
(16, 'AZ', 'Azerbaijan'),
(17, 'BA', 'Bosnia and Herzegovina'),
(18, 'BB', 'Barbados'),
(19, 'BD', 'Bangladesh'),
(20, 'BE', 'Belgium'),
(21, 'BF', 'Burkina Faso'),
(22, 'BG', 'Bulgaria'),
(23, 'BH', 'Bahrain'),
(24, 'BI', 'Burundi'),
(25, 'BJ', 'Benin'),
(26, 'BL', 'Saint Barthélemy'),
(27, 'BM', 'Bermuda'),
(28, 'BN', 'Brunei'),
(29, 'BO', 'Bolivia'),
(30, 'BQ', 'Bonaire'),
(31, 'BR', 'Brazil'),
(32, 'BS', 'Bahamas'),
(33, 'BT', 'Bhutan'),
(34, 'BV', 'Bouvet Island'),
(35, 'BW', 'Botswana'),
(36, 'BY', 'Belarus'),
(37, 'BZ', 'Belize'),
(38, 'CA', 'Canada'),
(39, 'CC', 'Cocos [Keeling] Islands'),
(40, 'CD', 'Democratic Republic of the Congo'),
(41, 'CF', 'Central African Republic'),
(42, 'CG', 'Republic of the Congo'),
(43, 'CH', 'Switzerland'),
(44, 'CI', 'Ivory Coast'),
(45, 'CK', 'Cook Islands'),
(46, 'CL', 'Chile'),
(47, 'CM', 'Cameroon'),
(48, 'CN', 'China'),
(49, 'CO', 'Colombia'),
(50, 'CR', 'Costa Rica'),
(51, 'CU', 'Cuba'),
(52, 'CV', 'Cape Verde'),
(53, 'CW', 'Curacao'),
(54, 'CX', 'Christmas Island'),
(55, 'CY', 'Cyprus'),
(56, 'CZ', 'Czech Republic'),
(57, 'DE', 'Germany'),
(58, 'DJ', 'Djibouti'),
(59, 'DK', 'Denmark'),
(60, 'DM', 'Dominica'),
(61, 'DO', 'Dominican Republic'),
(62, 'DZ', 'Algeria'),
(63, 'EC', 'Ecuador'),
(64, 'EE', 'Estonia'),
(65, 'EG', 'Egypt'),
(66, 'EH', 'Western Sahara'),
(67, 'ER', 'Eritrea'),
(68, 'ES', 'Spain'),
(69, 'ET', 'Ethiopia'),
(70, 'FI', 'Finland'),
(71, 'FJ', 'Fiji'),
(72, 'FK', 'Falkland Islands'),
(73, 'FM', 'Micronesia'),
(74, 'FO', 'Faroe Islands'),
(75, 'FR', 'France'),
(76, 'GA', 'Gabon'),
(77, 'GB', 'United Kingdom'),
(78, 'GD', 'Grenada'),
(79, 'GE', 'Georgia'),
(80, 'GF', 'French Guiana'),
(81, 'GG', 'Guernsey'),
(82, 'GH', 'Ghana'),
(83, 'GI', 'Gibraltar'),
(84, 'GL', 'Greenland'),
(85, 'GM', 'Gambia'),
(86, 'GN', 'Guinea'),
(87, 'GP', 'Guadeloupe'),
(88, 'GQ', 'Equatorial Guinea'),
(89, 'GR', 'Greece'),
(90, 'GS', 'South Georgia and the South Sandwich Islands'),
(91, 'GT', 'Guatemala'),
(92, 'GU', 'Guam'),
(93, 'GW', 'Guinea-Bissau'),
(94, 'GY', 'Guyana'),
(95, 'HK', 'Hong Kong'),
(96, 'HM', 'Heard Island and McDonald Islands'),
(97, 'HN', 'Honduras'),
(98, 'HR', 'Croatia'),
(99, 'HT', 'Haiti'),
(100, 'HU', 'Hungary'),
(101, 'ID', 'Indonesia'),
(102, 'IE', 'Ireland'),
(103, 'IL', 'Israel'),
(104, 'IM', 'Isle of Man'),
(105, 'IN', 'India'),
(106, 'IO', 'British Indian Ocean Territory'),
(107, 'IQ', 'Iraq'),
(108, 'IR', 'Iran'),
(109, 'IS', 'Iceland'),
(110, 'IT', 'Italy'),
(111, 'JE', 'Jersey'),
(112, 'JM', 'Jamaica'),
(113, 'JO', 'Jordan'),
(114, 'JP', 'Japan'),
(115, 'KE', 'Kenya'),
(116, 'KG', 'Kyrgyzstan'),
(117, 'KH', 'Cambodia'),
(118, 'KI', 'Kiribati'),
(119, 'KM', 'Comoros'),
(120, 'KN', 'Saint Kitts and Nevis'),
(121, 'KP', 'North Korea'),
(122, 'KR', 'South Korea'),
(123, 'KW', 'Kuwait'),
(124, 'KY', 'Cayman Islands'),
(125, 'KZ', 'Kazakhstan'),
(126, 'LA', 'Laos'),
(127, 'LB', 'Lebanon'),
(128, 'LC', 'Saint Lucia'),
(129, 'LI', 'Liechtenstein'),
(130, 'LK', 'Sri Lanka'),
(131, 'LR', 'Liberia'),
(132, 'LS', 'Lesotho'),
(133, 'LT', 'Lithuania'),
(134, 'LU', 'Luxembourg'),
(135, 'LV', 'Latvia'),
(136, 'LY', 'Libya'),
(137, 'MA', 'Morocco'),
(138, 'MC', 'Monaco'),
(139, 'MD', 'Moldova'),
(140, 'ME', 'Montenegro'),
(141, 'MF', 'Saint Martin'),
(142, 'MG', 'Madagascar'),
(143, 'MH', 'Marshall Islands'),
(144, 'MK', 'Macedonia'),
(145, 'ML', 'Mali'),
(146, 'MM', 'Myanmar [Burma]'),
(147, 'MN', 'Mongolia'),
(148, 'MO', 'Macao'),
(149, 'MP', 'Northern Mariana Islands'),
(150, 'MQ', 'Martinique'),
(151, 'MR', 'Mauritania'),
(152, 'MS', 'Montserrat'),
(153, 'MT', 'Malta'),
(154, 'MU', 'Mauritius'),
(155, 'MV', 'Maldives'),
(156, 'MW', 'Malawi'),
(157, 'MX', 'Mexico'),
(158, 'MY', 'Malaysia'),
(159, 'MZ', 'Mozambique'),
(160, 'NA', 'Namibia'),
(161, 'NC', 'New Caledonia'),
(162, 'NE', 'Niger'),
(163, 'NF', 'Norfolk Island'),
(164, 'NG', 'Nigeria'),
(165, 'NI', 'Nicaragua'),
(166, 'NL', 'Netherlands'),
(167, 'NO', 'Norway'),
(168, 'NP', 'Nepal'),
(169, 'NR', 'Nauru'),
(170, 'NU', 'Niue'),
(171, 'NZ', 'New Zealand'),
(172, 'OM', 'Oman'),
(173, 'PA', 'Panama'),
(174, 'PE', 'Peru'),
(175, 'PF', 'French Polynesia'),
(176, 'PG', 'Papua New Guinea'),
(177, 'PH', 'Philippines'),
(178, 'PK', 'Pakistan'),
(179, 'PL', 'Poland'),
(180, 'PM', 'Saint Pierre and Miquelon'),
(181, 'PN', 'Pitcairn Islands'),
(182, 'PR', 'Puerto Rico'),
(183, 'PS', 'Palestine'),
(184, 'PT', 'Portugal'),
(185, 'PW', 'Palau'),
(186, 'PY', 'Paraguay'),
(187, 'QA', 'Qatar'),
(188, 'RE', 'Réunion'),
(189, 'RO', 'Romania'),
(190, 'RS', 'Serbia'),
(191, 'RU', 'Russia'),
(192, 'RW', 'Rwanda'),
(193, 'SA', 'Saudi Arabia'),
(194, 'SB', 'Solomon Islands'),
(195, 'SC', 'Seychelles'),
(196, 'SD', 'Sudan'),
(197, 'SE', 'Sweden'),
(198, 'SG', 'Singapore'),
(199, 'SH', 'Saint Helena'),
(200, 'SI', 'Slovenia'),
(201, 'SJ', 'Svalbard and Jan Mayen'),
(202, 'SK', 'Slovakia'),
(203, 'SL', 'Sierra Leone'),
(204, 'SM', 'San Marino'),
(205, 'SN', 'Senegal'),
(206, 'SO', 'Somalia'),
(207, 'SR', 'Suriname'),
(208, 'SS', 'South Sudan'),
(209, 'ST', 'São Tomé and Príncipe'),
(210, 'SV', 'El Salvador'),
(211, 'SX', 'Sint Maarten'),
(212, 'SY', 'Syria'),
(213, 'SZ', 'Swaziland'),
(214, 'TC', 'Turks and Caicos Islands'),
(215, 'TD', 'Chad'),
(216, 'TF', 'French Southern Territories'),
(217, 'TG', 'Togo'),
(218, 'TH', 'Thailand'),
(219, 'TJ', 'Tajikistan'),
(220, 'TK', 'Tokelau'),
(221, 'TL', 'East Timor'),
(222, 'TM', 'Turkmenistan'),
(223, 'TN', 'Tunisia'),
(224, 'TO', 'Tonga'),
(225, 'TR', 'Turkey'),
(226, 'TT', 'Trinidad and Tobago'),
(227, 'TV', 'Tuvalu'),
(228, 'TW', 'Taiwan'),
(229, 'TZ', 'Tanzania'),
(230, 'UA', 'Ukraine'),
(231, 'UG', 'Uganda'),
(232, 'UM', 'U.S. Minor Outlying Islands'),
(233, 'US', 'United States'),
(234, 'UY', 'Uruguay'),
(235, 'UZ', 'Uzbekistan'),
(236, 'VA', 'Vatican City'),
(237, 'VC', 'Saint Vincent and the Grenadines'),
(238, 'VE', 'Venezuela'),
(239, 'VG', 'British Virgin Islands'),
(240, 'VI', 'U.S. Virgin Islands'),
(241, 'VN', 'Vietnam'),
(242, 'VU', 'Vanuatu'),
(243, 'WF', 'Wallis and Futuna'),
(244, 'WS', 'Samoa'),
(245, 'XK', 'Kosovo'),
(246, 'YE', 'Yemen'),
(247, 'YT', 'Mayotte'),
(248, 'ZA', 'South Africa'),
(249, 'ZM', 'Zambia'),
(250, 'ZW', 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `cvms_kiosk`
--

DROP TABLE IF EXISTS `cvms_kiosk`;
CREATE TABLE IF NOT EXISTS `cvms_kiosk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `workstation` int(11) NOT NULL,
  `module` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tenant` int(11) NOT NULL,
  `tenant_agent` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `helpdesk`
--

DROP TABLE IF EXISTS `helpdesk`;
CREATE TABLE IF NOT EXISTS `helpdesk` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `helpdesk_group_id` bigint(20) NOT NULL,
  `order_by` int(6) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `is_deleted` int(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `helpdesk_helpdesk_group` (`helpdesk_group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `helpdesk`
--

INSERT INTO `helpdesk` (`id`, `question`, `answer`, `helpdesk_group_id`, `order_by`, `created_by`, `is_deleted`) VALUES
(1, 'How do I update my profile?', 'Select the person silhouette in the icon group at the top right of the screen. You can change all your details except those in greyed-out fields.', 2, NULL, 47, 0),
(2, 'How do I add a visitor profile?', 'You can add a Visitor Profile through the Add Visitor Profile option in the Main Menu in the Dashboard or in the second step of Logging a Visit if the Visitor is not already in the system.\r\n\r\n\r\n', 2, NULL, 47, 0),
(3, 'Why can''t I see all of a visitor''s information?', 'There are several reasons that a visitor’s information remains hidden: a visit has not yet been activated or your user role doesn’t have access to that information.\r\n', 2, NULL, 47, 0),
(4, 'What''s a Same Day VIC?', 'The same day VIC limits a visit to today’s date until 12 a.m. (midnight). It counts as one visit.', 1, NULL, 47, 0),
(5, 'What''s a MultiDay Vic?', 'A MultiDay VIC, also known as an EVIC, lasts for more than one day up to a maximum of 28 days. A photo is required for this type of VIC.', 1, NULL, 47, 0),
(6, 'Where are the AVMS reports?', 'Click on the Administration tab and then select the AVMS Reports option from the Administration menu. It''s a pull-down menu from which you chose the report that you need.', 3, NULL, 47, 0),
(7, 'What user types are there?', 'The user types in the AVMS system are: Issuing Body Administrator; Airport Operator; and Agent Operator. The ones you can add depend on the user role that you have.', 3, NULL, 47, 0);

-- --------------------------------------------------------

--
-- Table structure for table `helpdesk_group`
--

DROP TABLE IF EXISTS `helpdesk_group`;
CREATE TABLE IF NOT EXISTS `helpdesk_group` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `order_by` int(6) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `is_deleted` bigint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `helpdesk_group`
--

INSERT INTO `helpdesk_group` (`id`, `name`, `order_by`, `created_by`, `is_deleted`) VALUES
(1, 'VIC Issuing', NULL, 47, 0),
(2, 'All Modules', NULL, 47, 0),
(3, 'AVMS Administration', NULL, 47, 0);

-- --------------------------------------------------------

--
-- Table structure for table `import_hosts`
--

DROP TABLE IF EXISTS `import_hosts`;
CREATE TABLE IF NOT EXISTS `import_hosts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `department` varchar(50) NOT NULL,
  `staff_id` varchar(50) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `company` varchar(50) NOT NULL,
  `imported_by` int(11) DEFAULT NULL,
  `date_imported` date DEFAULT NULL,
  `password` varchar(50) NOT NULL,
  `role` int(11) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `import_visitor`
--

DROP TABLE IF EXISTS `import_visitor`;
CREATE TABLE IF NOT EXISTS `import_visitor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `card_code` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `check_in_date` date DEFAULT NULL,
  `check_out_date` date DEFAULT NULL,
  `imported_by` int(11) DEFAULT NULL,
  `import_date` date DEFAULT NULL,
  `check_in_time` time DEFAULT NULL,
  `check_out_time` time DEFAULT NULL,
  `position` varchar(30) DEFAULT NULL,
  `date_printed` date DEFAULT NULL,
  `date_expiration` date DEFAULT NULL,
  `vehicle` varchar(50) DEFAULT NULL,
  `contact_number` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `license_details`
--

DROP TABLE IF EXISTS `license_details`;
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
-- Table structure for table `module`
--

DROP TABLE IF EXISTS `module`;
CREATE TABLE IF NOT EXISTS `module` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `about` varchar(255) DEFAULT NULL,
  `created_by` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`id`, `name`, `about`, `created_by`) VALUES
(1, 'Corporate', NULL, NULL),
(2, 'VIC Issuing', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

DROP TABLE IF EXISTS `notification`;
CREATE TABLE IF NOT EXISTS `notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(250) NOT NULL,
  `message` text NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `notification_type` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;


--
-- Table structure for table `password_change_request`
--

DROP TABLE IF EXISTS `password_change_request`;
CREATE TABLE IF NOT EXISTS `password_change_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `hash` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_used` enum('YES','NO') NOT NULL DEFAULT 'NO',
  PRIMARY KEY (`id`),
  UNIQUE KEY `hash` (`hash`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Table structure for table `patient`
--

DROP TABLE IF EXISTS `patient`;
CREATE TABLE IF NOT EXISTS `patient` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `photo`
--

DROP TABLE IF EXISTS `photo`;
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
(1, 'ids-logo2.jpg', '1411087524.jpg', 'uploads/company_logo/1411087524.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reasons`
--

DROP TABLE IF EXISTS `reasons`;
CREATE TABLE IF NOT EXISTS `reasons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reason_name` varchar(50) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` bigint(20) DEFAULT NULL,
  `tenant` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Table structure for table `reset_history`
--

DROP TABLE IF EXISTS `reset_history`;
CREATE TABLE IF NOT EXISTS `reset_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visitor_id` bigint(20) NOT NULL,
  `reset_time` datetime NOT NULL,
  `reason` varchar(250) NOT NULL,
  `lodgement_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `reset_history`
--

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_by`) VALUES
(5, 'Super Administrator', NULL),
(1, 'Administrator', NULL),
(6, 'Agent Administrator', NULL),
(7, 'Agent Operator', NULL),
(8, 'Operator', NULL),
(9, 'Staff Member/Intranet', NULL),
(10, 'Visitor/Kiosk', NULL),
(11, 'Issuing Body Administrator', NULL),
(12, 'Airport Operator', NULL),
(13, 'Agent Airport Administrator', NULL),
(14, 'Agent Airport Operator', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_migration`
--

DROP TABLE IF EXISTS `tbl_migration`;
CREATE TABLE IF NOT EXISTS `tbl_migration` (
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_migration`
--

INSERT INTO `tbl_migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1433768766),
('m150406_151520_issue_081', 1433768767),
('m150406_151521_issue_137', 1433768767),
('m150406_151542_password_change_request', 1433768767),
('m150423_072538_visitor_card_status', 1433768767),
('m150424_181334_issue_171_addUserPhoto', 1433768767),
('m150425_081700_issue_170_addPhoTotoUser', 1433768768),
('m150430_170515_workstation_card_type', 1433768768),
('m150501_222214_update_card_type', 1433768768),
('m150504_111134_InsertUserRoles', 1433768768),
('m150504_111234_AddAsicNoToUsers', 1433768768),
('m150504_111245_AddAsicExpiryToUsers', 1433768768),
('m150505_054444_update_card_type', 1433768768),
('m150506_205300_tenant_and_tenant_contact', 1433768768),
('m150507_070457_helpdesktable', 1433768768),
('m150507_091726_issue_175', 1433768768),
('m150507_174354_update_card_type', 1433768768),
('m150512_100257_issue_191_visit_contractor_type_add_fields', 1433768768),
('m150512_111015_issue_303_Duplicate_Host_Profiles_in_Manage_Users', 1433768768),
('m150514_093710_YiiSession', 1433768768),
('m150514_205600_issue_176_visitor_asic_profile', 1433768768),
('m150515_055942_add_default_value_to_visitor_type_table', 1433768768),
('m150518_090825_import_visitor', 1433768768),
('m150519_020527_access_tokens', 1433768768),
('m150519_101512_add_extra_fields_import_visitor', 1433768768),
('m150520_014044_add_column_visit_count_to_visitor', 1433768768),
('m150520_091128_create_import_host', 1433768768),
('m150521_103325_create_user_notification_relational_table', 1433768768),
('m150525_032952_add_table_visit_count_history', 1433768768),
('m150527_053447_create_notification_table', 1433768768),
('m150527_074013_visitor_add_postcode_column', 1433768768),
('m150528_082058_add_table_contacts', 1433768768),
('m150601_044057_drop_table_contacts', 1433768768),
('m150601_200412_audit_trail', 1433768768),
('m150602_151520_add_column_card_type', 1433768769),
('m150603_110554_add_column_card_option', 1433768769),
('m150604_033456_add_police_report_number_column', 1433768769),
('m150604_083620_alter_compnay_contactnno', 1433768769),
('m150611_114540_visitor_add_date_created_column', 1434062249),
('m150617_022554_add_column_lodgement_date_to_reset_history', 1434522356),
('m150617_075020_creat_reasons_table', 1434591504),
('m150618_091852_visit_table_remove_host_foreign_key_add_comment', 1434674039),
('m150619_073834_add_inductions_three_columns_in_user_table', 1434758230),
('m150621_111500_change_date_columns_to_date_data_type', 1434928147),
('m150624_020527_kiosk', 1435192586),
('m150624_065952_add_timezone_id_in_workstation_table', 1435327638),
('m150624_083025_create_table_log_convert_visitor_card_type', 1435192586),
('m150625_064659_create_timezone_table', 1435327638),
('m150625_105353_create_table_company_type', 1435327638),
('m150626_022554_add_column_access_token', 1435192586),
('m150626_023020_add_timezone_id_in_user_table', 1435327638),
('m150626_030856_change_visitor_contact_state_type', 1435327638),
('m150626_060107_change_columns_to_date_and_time', 1435327638),
('m150701_085132_add_column_asic_escort_visit', 1435820051),
('m150701_085157_add_column_escort_flag_visitor', 1435820051),
('m150706_040820_visitor_card_status_expired_record', 1436275778),
('m150706_065150_create_contact_person_table', 1436225302),
('m150706_092432_add_two_columns_in_reasons_table', 1436225302),
('m150706_093256_add_two_columns_in_contact_person_table', 1436225302),
('m150707_094839_add_is_under_18_to_visitor', 1436275778),
('m150707_104743_add_coloumn_visitor', 1436275778),
('m150710_095702_add_module_allowed_field_in_user', 1436573317);

-- --------------------------------------------------------

--
-- Table structure for table `tenant`
--

DROP TABLE IF EXISTS `tenant`;
CREATE TABLE IF NOT EXISTS `tenant` (
  `id` bigint(20) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tenant`
--

INSERT INTO `tenant` (`id`, `created_by`, `is_deleted`) VALUES
(1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tenant_contact`
--

DROP TABLE IF EXISTS `tenant_contact`;
CREATE TABLE IF NOT EXISTS `tenant_contact` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tenant` bigint(20) NOT NULL,
  `user` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tenant_contact_tenant1_idx` (`tenant`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `timezone`
--

DROP TABLE IF EXISTS `timezone`;
CREATE TABLE IF NOT EXISTS `timezone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timezone_name` varchar(250) NOT NULL,
  `timezone_value` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=141 ;

--
-- Dumping data for table `timezone`
--

INSERT INTO `timezone` (`id`, `timezone_name`, `timezone_value`) VALUES
(1, '(GMT-11:00) Midway Island ', 'Pacific/Midway'),
(2, '(GMT-11:00) Samoa ', 'Pacific/Samoa'),
(3, '(GMT-10:00) Hawaii ', 'Pacific/Honolulu'),
(4, '(GMT-09:00) Alaska ', 'America/Anchorage'),
(5, '(GMT-08:00) Pacific Time (US &amp; Canada) ', 'America/Los_Angeles'),
(6, '(GMT-08:00) Tijuana ', 'America/Tijuana'),
(7, '(GMT-07:00) Chihuahua ', 'America/Chihuahua'),
(8, '(GMT-07:00) La Paz ', 'America/Chihuahua'),
(9, '(GMT-07:00) Mazatlan ', 'America/Mazatlan'),
(10, '(GMT-07:00) Mountain Time (US &amp; Canada) ', 'America/Denver'),
(11, '(GMT-06:00) Central America ', 'America/Managua'),
(12, '(GMT-06:00) Central Time (US &amp; Canada) ', 'America/Chicago'),
(13, '(GMT-06:00) Guadalajara ', 'America/Mexico_City'),
(14, '(GMT-06:00) Mexico City ', 'America/Mexico_City'),
(15, '(GMT-06:00) Monterrey ', 'America/Monterrey'),
(16, '(GMT-05:00) Bogota ', 'America/Bogota'),
(17, '(GMT-05:00) Eastern Time (US &amp; Canada) ', 'America/New_York'),
(18, '(GMT-05:00) Lima ', 'America/Lima'),
(19, '(GMT-05:00) Quito ', 'America/Bogota'),
(20, '(GMT-04:00) Atlantic Time (Canada) ', 'Canada/Atlantic'),
(21, '(GMT-04:30) Caracas ', 'America/Caracas'),
(22, '(GMT-04:00) La Paz ', 'America/La_Paz'),
(23, '(GMT-04:00) Santiago ', 'America/Santiago'),
(24, '(GMT-03:30) Newfoundland ', 'America/St_Johns'),
(25, '(GMT-03:00) Brasilia ', 'America/Sao_Paulo'),
(26, '(GMT-03:00) Buenos Aires ', 'America/Argentina/Buenos_Aires'),
(27, '(GMT-03:00) Georgetown ', 'America/Argentina/Buenos_Aires'),
(28, '(GMT-03:00) Greenland ', 'America/Godthab'),
(29, '(GMT-02:00) Mid-Atlantic ', 'America/Noronha'),
(30, '(GMT-01:00) Azores ', 'Atlantic/Azores'),
(31, '(GMT-01:00) Cape Verde Is. ', 'Atlantic/Cape_Verde'),
(32, '(GMT+00:00) Casablanca ', 'Africa/Casablanca'),
(33, '(GMT+00:00) Edinburgh ', 'Europe/London'),
(34, '(GMT+00:00) Dublin ', 'Europe/Dublin'),
(35, '(GMT+00:00) Lisbon ', 'Europe/Lisbon'),
(36, '(GMT+00:00) London ', 'Europe/London'),
(37, '(GMT+00:00) Monrovia ', 'Africa/Monrovia'),
(38, '(GMT+00:00) UTC ', 'UTC'),
(39, '(GMT+01:00) Amsterdam ', 'Europe/Amsterdam'),
(40, '(GMT+01:00) Belgrade ', 'Europe/Belgrade'),
(41, '(GMT+01:00) Berlin ', 'Europe/Berlin'),
(42, '(GMT+01:00) Bern ', 'Europe/Berlin'),
(43, '(GMT+01:00) Bratislava ', 'Europe/Bratislava'),
(44, '(GMT+01:00) Brussels ', 'Europe/Brussels'),
(45, '(GMT+01:00) Budapest ', 'Europe/Budapest'),
(46, '(GMT+01:00) Copenhagen ', 'Europe/Copenhagen'),
(47, '(GMT+01:00) Ljubljana ', 'Europe/Ljubljana'),
(48, '(GMT+01:00) Madrid ', 'Europe/Madrid'),
(49, '(GMT+01:00) Paris ', 'Europe/Paris'),
(50, '(GMT+01:00) Prague ', 'Europe/Prague'),
(51, '(GMT+01:00) Rome ', 'Europe/Rome'),
(52, '(GMT+01:00) Sarajevo ', 'Europe/Sarajevo'),
(53, '(GMT+01:00) Skopje ', 'Europe/Skopje'),
(54, '(GMT+01:00) Stockholm ', 'Europe/Stockholm'),
(55, '(GMT+01:00) Vienna ', 'Europe/Vienna'),
(56, '(GMT+01:00) Warsaw ', 'Europe/Warsaw'),
(57, '(GMT+01:00) West Central Africa ', 'Africa/Lagos'),
(58, '(GMT+01:00) Zagreb ', 'Europe/Zagreb'),
(59, '(GMT+02:00) Athens ', 'Europe/Athens'),
(60, '(GMT+02:00) Bucharest ', 'Europe/Bucharest'),
(61, '(GMT+02:00) Cairo ', 'Africa/Cairo'),
(62, '(GMT+02:00) Harare ', 'Africa/Harare'),
(63, '(GMT+02:00) Helsinki ', 'Europe/Helsinki'),
(64, '(GMT+02:00) Istanbul ', 'Europe/Istanbul'),
(65, '(GMT+02:00) Jerusalem ', 'Asia/Jerusalem'),
(66, '(GMT+02:00) Kyiv ', 'Europe/Helsinki'),
(67, '(GMT+02:00) Pretoria ', 'Africa/Johannesburg'),
(68, '(GMT+02:00) Riga ', 'Europe/Riga'),
(69, '(GMT+02:00) Sofia ', 'Europe/Sofia'),
(70, '(GMT+02:00) Tallinn ', 'Europe/Tallinn'),
(71, '(GMT+02:00) Vilnius ', 'Europe/Vilnius'),
(72, '(GMT+03:00) Baghdad ', 'Asia/Baghdad'),
(73, '(GMT+03:00) Kuwait ', 'Asia/Kuwait'),
(74, '(GMT+03:00) Minsk ', 'Europe/Minsk'),
(75, '(GMT+03:00) Nairobi ', 'Africa/Nairobi'),
(76, '(GMT+03:00) Riyadh ', 'Asia/Riyadh'),
(77, '(GMT+03:00) Volgograd ', 'Europe/Volgograd'),
(78, '(GMT+03:30) Tehran ', 'Asia/Tehran'),
(79, '(GMT+04:00) Abu Dhabi ', 'Asia/Muscat'),
(80, '(GMT+04:00) Baku ', 'Asia/Baku'),
(81, '(GMT+04:00) Moscow ', 'Europe/Moscow'),
(82, '(GMT+04:00) Muscat ', 'Asia/Muscat'),
(83, '(GMT+04:00) St. Petersburg ', 'Europe/Moscow'),
(84, '(GMT+04:00) Tbilisi ', 'Asia/Tbilisi'),
(85, '(GMT+04:00) Yerevan ', 'Asia/Yerevan'),
(86, '(GMT+04:30) Kabul ', 'Asia/Kabul'),
(87, '(GMT+05:00) Islamabad ', 'Asia/Karachi'),
(88, '(GMT+05:00) Karachi ', 'Asia/Karachi'),
(89, '(GMT+05:00) Tashkent ', 'Asia/Tashkent'),
(90, '(GMT+05:30) Chennai ', 'Asia/Calcutta'),
(91, '(GMT+05:30) Kolkata ', 'Asia/Kolkata'),
(92, '(GMT+05:30) Mumbai ', 'Asia/Calcutta'),
(93, '(GMT+05:30) New Delhi ', 'Asia/Calcutta'),
(94, '(GMT+05:30) Sri Jayawardenepura ', 'Asia/Calcutta'),
(95, '(GMT+05:45) Kathmandu ', 'Asia/Katmandu'),
(96, '(GMT+06:00) Almaty ', 'Asia/Almaty'),
(97, '(GMT+06:00) Astana ', 'Asia/Dhaka'),
(98, '(GMT+06:00) Dhaka ', 'Asia/Dhaka'),
(99, '(GMT+06:00) Ekaterinburg ', 'Asia/Yekaterinburg'),
(100, '(GMT+06:30) Rangoon ', 'Asia/Rangoon'),
(101, '(GMT+07:00) Bangkok ', 'Asia/Bangkok'),
(102, '(GMT+07:00) Hanoi ', 'Asia/Bangkok'),
(103, '(GMT+07:00) Jakarta ', 'Asia/Jakarta'),
(104, '(GMT+07:00) Novosibirsk ', 'Asia/Novosibirsk'),
(105, '(GMT+08:00) Beijing ', 'Asia/Hong_Kong'),
(106, '(GMT+08:00) Chongqing ', 'Asia/Chongqing'),
(107, '(GMT+08:00) Hong Kong ', 'Asia/Hong_Kong'),
(108, '(GMT+08:00) Krasnoyarsk ', 'Asia/Krasnoyarsk'),
(109, '(GMT+08:00) Kuala Lumpur ', 'Asia/Kuala_Lumpur'),
(110, '(GMT+08:00) Perth ', 'Australia/Perth'),
(111, '(GMT+08:00) Singapore ', 'Asia/Singapore'),
(112, '(GMT+08:00) Taipei ', 'Asia/Taipei'),
(113, '(GMT+08:00) Ulaan Bataar ', 'Asia/Ulan_Bator'),
(114, '(GMT+08:00) Urumqi ', 'Asia/Urumqi'),
(115, '(GMT+09:00) Irkutsk ', 'Asia/Irkutsk'),
(116, '(GMT+09:00) Osaka ', 'Asia/Tokyo'),
(117, '(GMT+09:00) Sapporo ', 'Asia/Tokyo'),
(118, '(GMT+09:00) Seoul ', 'Asia/Seoul'),
(119, '(GMT+09:00) Tokyo ', 'Asia/Tokyo'),
(120, '(GMT+09:30) Adelaide ', 'Australia/Adelaide'),
(121, '(GMT+09:30) Darwin ', 'Australia/Darwin'),
(122, '(GMT+10:00) Brisbane ', 'Australia/Brisbane'),
(123, '(GMT+10:00) Canberra ', 'Australia/Canberra'),
(124, '(GMT+10:00) Guam ', 'Pacific/Guam'),
(125, '(GMT+10:00) Hobart ', 'Australia/Hobart'),
(126, '(GMT+10:00) Melbourne ', 'Australia/Melbourne'),
(127, '(GMT+10:00) Port Moresby ', 'Pacific/Port_Moresby'),
(128, '(GMT+10:00) Sydney ', 'Australia/Sydney'),
(129, '(GMT+10:00) Yakutsk ', 'Asia/Yakutsk'),
(130, '(GMT+11:00) Vladivostok ', 'Asia/Vladivostok'),
(131, '(GMT+12:00) Auckland ', 'Pacific/Auckland'),
(132, '(GMT+12:00) Fiji ', 'Pacific/Fiji'),
(133, '(GMT+12:00) International Date Line West ', 'Pacific/Kwajalein'),
(134, '(GMT+12:00) Kamchatka ', 'Asia/Kamchatka'),
(135, '(GMT+12:00) Magadan ', 'Asia/Magadan'),
(136, '(GMT+12:00) Marshall Is. ', 'Pacific/Fiji'),
(137, '(GMT+12:00) New Caledonia ', 'Asia/Magadan'),
(138, '(GMT+12:00) Solomon Is. ', 'Asia/Magadan'),
(139, '(GMT+12:00) Wellington ', 'Pacific/Auckland'),
(140, '(GMT+13:00) Nuku\\alofa ', 'Pacific/Tongatapu');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
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
  `photo` bigint(20) NOT NULL,
  `asic_no` int(11) DEFAULT NULL,
  `asic_expiry` date DEFAULT NULL,
  `is_required_induction` tinyint(1) DEFAULT NULL,
  `is_completed_induction` tinyint(1) DEFAULT NULL,
  `induction_expiry` date DEFAULT NULL,
  `timezone_id` bigint(20) NOT NULL,
  `allowed_module` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role` (`role`),
  KEY `user_type` (`user_type`),
  KEY `user_status` (`user_status`),
  KEY `company` (`company`),
  KEY `created_by` (`created_by`),
  KEY `tenant` (`tenant`),
  KEY `tenant_agent` (`tenant_agent`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=96 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `contact_number`, `date_of_birth`, `company`, `department`, `position`, `staff_id`, `notes`, `password`, `role`, `user_type`, `user_status`, `created_by`, `is_deleted`, `tenant`, `tenant_agent`, `photo`, `asic_no`, `asic_expiry`, `is_required_induction`, `is_completed_induction`, `induction_expiry`, `timezone_id`, `allowed_module`) VALUES
(1, 'SuperAdmin', 'IDS', 'superadmin@test.com', '9998798', '1993-01-01', 1, '', '', '', '', '$2a$13$wv.A6T0CCHXczYv/tlJP6./6qUvDdOy.g8KX.FqSos1Mf6MA7Xl66', 5, 1, 1, 1, 0, 1, 1, 0, NULL, NULL, NULL, NULL, NULL,110, NULL);


-- --------------------------------------------------------

--
-- Table structure for table `user_notification`
--

DROP TABLE IF EXISTS `user_notification`;
CREATE TABLE IF NOT EXISTS `user_notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `notification_id` int(11) DEFAULT NULL,
  `has_read` int(11) DEFAULT NULL,
  `date_read` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--
-- Table structure for table `user_status`
--

DROP TABLE IF EXISTS `user_status`;
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

DROP TABLE IF EXISTS `user_type`;
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

DROP TABLE IF EXISTS `user_workstation`;
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


--
-- Table structure for table `vehicle`
--

DROP TABLE IF EXISTS `vehicle`;
CREATE TABLE IF NOT EXISTS `vehicle` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `vehicle_registration_plate_number` varchar(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `visit`
--

DROP TABLE IF EXISTS `visit`;
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
  `date_in` date DEFAULT NULL,
  `time_in` time DEFAULT NULL,
  `date_out` date DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `date_check_in` date DEFAULT NULL,
  `time_check_in` time DEFAULT NULL,
  `date_check_out` date DEFAULT NULL,
  `time_check_out` time DEFAULT NULL,
  `visit_status` bigint(20) DEFAULT NULL,
  `workstation` bigint(20) DEFAULT NULL,
  `tenant` bigint(20) DEFAULT NULL,
  `tenant_agent` bigint(20) DEFAULT NULL,
  `is_deleted` tinyint(4) DEFAULT '0',
  `finish_date` date DEFAULT NULL,
  `finish_time` time DEFAULT NULL,
  `card_returned_date` date DEFAULT NULL,
  `reset_id` int(11) DEFAULT NULL,
  `negate_reason` varchar(250) DEFAULT NULL,
  `card_option` varchar(25) DEFAULT 'Returned',
  `card_lost_declaration_file` text,
  `police_report_number` varchar(50) DEFAULT '',
  `asic_escort` bigint(20) DEFAULT NULL,
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


--
-- Table structure for table `visitor`
--

DROP TABLE IF EXISTS `visitor`;
CREATE TABLE IF NOT EXISTS `visitor` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
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
  `key_string` text,
  `role` bigint(20) NOT NULL DEFAULT '10',
  `visitor_type` bigint(20) DEFAULT NULL,
  `visitor_status` bigint(20) DEFAULT '1',
  `vehicle` bigint(20) DEFAULT NULL,
  `photo` bigint(20) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `tenant` bigint(20) DEFAULT NULL,
  `tenant_agent` bigint(20) DEFAULT NULL,
  `visitor_card_status` bigint(20) DEFAULT NULL,
  `visitor_workstation` bigint(20) DEFAULT NULL,
  `profile_type` enum('VIC','ASIC','CORPORATE') NOT NULL DEFAULT 'CORPORATE',
  `identification_type` enum('PASSPORT','DRIVERS_LICENSE','PROOF_OF_AGE') DEFAULT NULL,
  `identification_country_issued` int(5) DEFAULT NULL,
  `identification_document_no` varchar(50) DEFAULT NULL,
  `identification_document_expiry` date DEFAULT NULL,
  `identification_alternate_document_name1` varchar(50) DEFAULT NULL,
  `identification_alternate_document_no1` varchar(50) DEFAULT NULL,
  `identification_alternate_document_expiry1` date DEFAULT NULL,
  `identification_alternate_document_name2` varchar(50) DEFAULT NULL,
  `identification_alternate_document_no2` varchar(50) DEFAULT NULL,
  `identification_alternate_document_expiry2` date DEFAULT NULL,
  `contact_unit` varchar(50) DEFAULT NULL,
  `contact_street_no` varchar(50) DEFAULT NULL,
  `contact_street_name` varchar(50) DEFAULT NULL,
  `contact_street_type` enum('ALLY','APP','ARC','AVE','BLVD','BROW','BYPA','CWAY','CCT','CIRC','CL','CPSE','CNR','CT','CRES','CRS','DR','END','EESP','FLAT','FWAY','FRNT','GDNS','GLD','GLEN','GRN','GR','HTS','HWY','LANE','LINK','LOOP','MALL','MEWS','PCKT','PDE','PARK','PKWY','PL','PROM','RES','RDGE','RISE','RD','ROW','SQ','ST','STRP','TARN','TCE','FARETFRE','TRAC','TWAY','VIEW','VSTA','WALK','WWAY','WAY','YARD') DEFAULT NULL,
  `contact_suburb` varchar(50) DEFAULT NULL,
  `contact_state` varchar(50) DEFAULT NULL,
  `contact_country` int(5) DEFAULT NULL,
  `asic_no` varchar(50) DEFAULT NULL,
  `asic_expiry` date DEFAULT NULL,
  `verifiable_signature` int(11) DEFAULT '0',
  `contact_postcode` varchar(10) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `escort_flag` tinyint(1) DEFAULT NULL,
  `is_under_18` tinyint(4) DEFAULT '0',
  `under_18_detail` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role` (`role`),
  KEY `company` (`company`),
  KEY `created_by` (`created_by`),
  KEY `tenant` (`tenant`),
  KEY `tenant_agent` (`tenant_agent`),
  KEY `visitor_type` (`visitor_type`),
  KEY `visitor_status` (`visitor_status`),
  KEY `photo` (`photo`),
  KEY `vehicle` (`vehicle`),
  KEY `visitor_card_status` (`visitor_card_status`),
  KEY `visitor_workstation` (`visitor_workstation`),
  KEY `identification_country_fk` (`identification_country_issued`),
  KEY `contact_country_fk` (`contact_country`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


--
-- Table structure for table `visitor_card_status`
--

DROP TABLE IF EXISTS `visitor_card_status`;
CREATE TABLE IF NOT EXISTS `visitor_card_status` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `profile_type` enum('VIC','ASIC','CORPORATE') NOT NULL DEFAULT 'CORPORATE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `visitor_card_status`
--

INSERT INTO `visitor_card_status` (`id`, `name`, `profile_type`) VALUES
(1, 'Saved', 'VIC'),
(2, 'VIC Holder', 'VIC'),
(3, 'ASIC Pending', 'VIC'),
(4, 'ASIC Issued', 'VIC'),
(5, 'ASIC Denied', 'VIC'),
(6, 'ASIC Issued', 'ASIC'),
(7, 'ASIC Applicant', 'ASIC'),
(8, 'ASIC Expired', 'ASIC');

-- --------------------------------------------------------

--
-- Table structure for table `visitor_status`
--

DROP TABLE IF EXISTS `visitor_status`;
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

DROP TABLE IF EXISTS `visitor_type`;
CREATE TABLE IF NOT EXISTS `visitor_type` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `tenant` bigint(20) DEFAULT NULL,
  `tenant_agent` bigint(20) DEFAULT NULL,
  `is_deleted` int(1) DEFAULT '0',
  `is_default_value` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


--
-- Table structure for table `visit_reason`
--

DROP TABLE IF EXISTS `visit_reason`;
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


--
-- Table structure for table `visit_status`
--

DROP TABLE IF EXISTS `visit_status`;
CREATE TABLE IF NOT EXISTS `visit_status` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `visit_status`
--

INSERT INTO `visit_status` (`id`, `name`, `created_by`) VALUES
(1, 'Active', NULL),
(2, 'Pre-registered', NULL),
(3, 'Closed', NULL),
(4, 'Expired', NULL),
(5, 'Save', NULL),
(6, 'Negate', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `workstation`
--

DROP TABLE IF EXISTS `workstation`;
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
  `timezone_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


--
-- Table structure for table `workstation_card_type`
--

DROP TABLE IF EXISTS `workstation_card_type`;
CREATE TABLE IF NOT EXISTS `workstation_card_type` (
  `workstation` bigint(20) NOT NULL,
  `card_type` bigint(20) NOT NULL,
  `user` bigint(20) NOT NULL,
  PRIMARY KEY (`workstation`,`card_type`),
  KEY `workstation_card_type_card_type` (`card_type`),
  KEY `workstation_card_user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Table structure for table `YiiSession`
--

DROP TABLE IF EXISTS `YiiSession`;
CREATE TABLE IF NOT EXISTS `YiiSession` (
  `id` varchar(255) DEFAULT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `card_generated`
--
ALTER TABLE `card_generated`
  ADD CONSTRAINT `card_generated_ibfk_1` FOREIGN KEY (`card_image_generated_filename`) REFERENCES `photo` (`id`),
  ADD CONSTRAINT `card_generated_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `card_generated_ibfk_5` FOREIGN KEY (`visitor_id`) REFERENCES `visitor` (`id`),
  ADD CONSTRAINT `card_generated_ibfk_6` FOREIGN KEY (`card_status`) REFERENCES `card_status` (`id`);

--
-- Constraints for table `card_status`
--
ALTER TABLE `card_status`
  ADD CONSTRAINT `card_status_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`);

--
-- Constraints for table `card_type`
--
ALTER TABLE `card_type`
  ADD CONSTRAINT `card_type_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `card_type_module` FOREIGN KEY (`module`) REFERENCES `module` (`id`);

--
-- Constraints for table `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `company_ibfk_1` FOREIGN KEY (`created_by_user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `company_ibfk_2` FOREIGN KEY (`tenant_agent`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `company_ibfk_4` FOREIGN KEY (`company_laf_preferences`) REFERENCES `company_laf_preferences` (`id`),
  ADD CONSTRAINT `company_ibfk_5` FOREIGN KEY (`logo`) REFERENCES `photo` (`id`);

--
-- Constraints for table `helpdesk`
--
ALTER TABLE `helpdesk`
  ADD CONSTRAINT `helpdesk_helpdesk_group` FOREIGN KEY (`helpdesk_group_id`) REFERENCES `helpdesk_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `password_change_request`
--
ALTER TABLE `password_change_request`
  ADD CONSTRAINT `user_password_change_request_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`);

--
-- Constraints for table `tenant`
--
ALTER TABLE `tenant`
  ADD CONSTRAINT `fk_tenant_company1` FOREIGN KEY (`id`) REFERENCES `vms`.`company` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tenant_contact`
--
ALTER TABLE `tenant_contact`
  ADD CONSTRAINT `fk_tenant_contact_tenant1` FOREIGN KEY (`tenant`) REFERENCES `vms`.`tenant` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`user_type`) REFERENCES `user_type` (`id`),
  ADD CONSTRAINT `user_ibfk_3` FOREIGN KEY (`user_status`) REFERENCES `user_status` (`id`),
  ADD CONSTRAINT `user_ibfk_4` FOREIGN KEY (`company`) REFERENCES `company` (`id`),
  ADD CONSTRAINT `user_ibfk_5` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
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
  ADD CONSTRAINT `visit_ibfk_1` FOREIGN KEY (`card`) REFERENCES `card_generated` (`id`),
  ADD CONSTRAINT `visit_ibfk_10` FOREIGN KEY (`tenant_agent`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `visit_ibfk_11` FOREIGN KEY (`card_type`) REFERENCES `card_type` (`id`),
  ADD CONSTRAINT `visit_ibfk_12` FOREIGN KEY (`visit_status`) REFERENCES `visit_status` (`id`),
  ADD CONSTRAINT `visit_ibfk_13` FOREIGN KEY (`workstation`) REFERENCES `workstation` (`id`),
  ADD CONSTRAINT `visit_ibfk_3` FOREIGN KEY (`reason`) REFERENCES `visit_reason` (`id`),
  ADD CONSTRAINT `visit_ibfk_4` FOREIGN KEY (`visitor_type`) REFERENCES `visitor_type` (`id`),
  ADD CONSTRAINT `visit_ibfk_5` FOREIGN KEY (`visitor_status`) REFERENCES `visitor_status` (`id`),
  ADD CONSTRAINT `visit_ibfk_7` FOREIGN KEY (`patient`) REFERENCES `patient` (`id`),
  ADD CONSTRAINT `visit_ibfk_8` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`);

--
-- Constraints for table `visitor`
--
ALTER TABLE `visitor`
  ADD CONSTRAINT `contact_country_fk` FOREIGN KEY (`contact_country`) REFERENCES `country` (`id`),
  ADD CONSTRAINT `identification_country_fk` FOREIGN KEY (`identification_country_issued`) REFERENCES `country` (`id`),
  ADD CONSTRAINT `visitor_card_status_fk` FOREIGN KEY (`visitor_card_status`) REFERENCES `visitor_card_status` (`id`),
  ADD CONSTRAINT `visitor_ibfk_1` FOREIGN KEY (`visitor_type`) REFERENCES `visitor_type` (`id`),
  ADD CONSTRAINT `visitor_ibfk_2` FOREIGN KEY (`visitor_status`) REFERENCES `visitor_status` (`id`),
  ADD CONSTRAINT `visitor_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `visitor_ibfk_5` FOREIGN KEY (`tenant_agent`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `visitor_ibfk_6` FOREIGN KEY (`role`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `visitor_ibfk_7` FOREIGN KEY (`company`) REFERENCES `company` (`id`),
  ADD CONSTRAINT `visitor_ibfk_8` FOREIGN KEY (`vehicle`) REFERENCES `vehicle` (`id`),
  ADD CONSTRAINT `visitor_ibfk_9` FOREIGN KEY (`photo`) REFERENCES `photo` (`id`),
  ADD CONSTRAINT `visitor_workstation_fk` FOREIGN KEY (`visitor_workstation`) REFERENCES `workstation` (`id`);

--
-- Constraints for table `visitor_type`
--
ALTER TABLE `visitor_type`
  ADD CONSTRAINT `visitor_type_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`);

--
-- Constraints for table `visit_reason`
--
ALTER TABLE `visit_reason`
  ADD CONSTRAINT `visit_reason_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `visit_reason_ibfk_3` FOREIGN KEY (`tenant_agent`) REFERENCES `user` (`id`);

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

--
-- Constraints for table `workstation_card_type`
--
ALTER TABLE `workstation_card_type`
  ADD CONSTRAINT `workstation_card_type_card_type` FOREIGN KEY (`card_type`) REFERENCES `card_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `workstation_card_type_workstation` FOREIGN KEY (`workstation`) REFERENCES `workstation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `workstation_card_user` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

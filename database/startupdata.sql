SET FOREIGN_KEY_CHECKS = 0;



--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `code`, `name`, `trading_name`, `logo`, `contact`, `billing_address`, `email_address`, `office_number`, `mobile_number`, `website`, `company_laf_preferences`, `created_by_user`, `created_by_visitor`, `tenant`, `tenant_agent`, `is_deleted`) VALUES
(1, 'IDS', 'Identity Security', 'Identity Security', 1, 'Julie Stewart Rose', 'PO BOX 710 Port Melbourne VIC 3207', 'julie.stewart@idsecurity.com.au', 396453450, 2147483647, 'http://idsecurity.com.au', 1, NULL, NULL, 1, 1, 0);


-- --------------------------------------------------------

INSERT INTO `company_laf_preferences` (`id`, `action_forward_bg_color`, `action_forward_bg_color2`, `action_forward_font_color`, `action_forward_hover_color`, `action_forward_hover_color2`, `action_forward_hover_font_color`, `complete_bg_color`, `complete_bg_color2`, `complete_hover_color`, `complete_hover_color2`, `complete_font_color`, `complete_hover_font_color`, `neutral_bg_color`, `neutral_bg_color2`, `neutral_hover_color`, `neutral_hover_color2`, `neutral_font_color`, `neutral_hover_font_color`, `nav_bg_color`, `nav_hover_color`, `nav_font_color`, `nav_hover_font_color`, `sidemenu_bg_color`, `sidemenu_hover_color`, `sidemenu_font_color`, `sidemenu_hover_font_color`, `css_file_path`)
VALUES (1, '#9ED92F', '#9ED92F', '#ffffff', '#9ED92F', '#9ED92F', '#ffffff', '#0d0d0c', '#a1999a', '#998e8e', '#b0a9a9', '#ffffff', '#ffffff', '#33bcdb', '#33bcdb', '#33bcdb', '#33bcdb', '#ffffff', '#ffffff', '#E7E7E7', '#30c5d9', '#637280', '#ffffff', '#E7E7E7', '#E7E7E7', '#1670c4', '#157cdb', '/company_css/IDS-1424944653.css');


--
-- Dumping data for table `photo`
--

INSERT INTO `photo` (`id`, `filename`, `unique_filename`, `relative_path`)
VALUES (1, 'ids-logo2.jpg', '1411087524.jpg', 'uploads/company_logo/1411087524.jpg');


--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `contact_number`, `date_of_birth`, `company`, `department`, `position`, `staff_id`, `notes`, `password`, `role`, `user_type`, `user_status`, `created_by`, `is_deleted`, `tenant`, `tenant_agent`) VALUES
(1, 'SuperAdmin', 'IDS', 'superadmin@test.com', '9998798', '1993-01-01', 1, '', '', '', '', '$2a$13$wv.A6T0CCHXczYv/tlJP6./6qUvDdOy.g8KX.FqSos1Mf6MA7Xl66', 5, 1, 1, 16, 0, 1, 1);


--
-- Set all passwords to 12345
--

UPDATE `user` set `password` = '$2a$13$wv.A6T0CCHXczYv/tlJP6./6qUvDdOy.g8KX.FqSos1Mf6MA7Xl66';


SET FOREIGN_KEY_CHECKS = 1;
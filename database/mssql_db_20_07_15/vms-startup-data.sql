SET IDENTITY_INSERT [dbo].[module] ON

GO
INSERT [dbo].[module] ([id], [name], [about], [created_by]) VALUES (1, N'Corporate', NULL, NULL)
GO
INSERT [dbo].[module] ([id], [name], [about], [created_by]) VALUES (2, N'VIC Issuing', NULL, NULL)
GO
SET IDENTITY_INSERT [dbo].[module] OFF
GO
SET IDENTITY_INSERT [dbo].[card_type] ON

GO
INSERT [dbo].[card_type] ([id], [name], [max_day_validity], [max_time_validity], [max_entry_count_validity], [card_icon_type], [card_background_image_path], [created_by], [module], [back_text]) VALUES (1, N'Same Day', 1, NULL, NULL, N'images/same_day_vic.png', N'images/corporate/same-day.png', NULL, 1, N'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cur')
GO
INSERT [dbo].[card_type] ([id], [name], [max_day_validity], [max_time_validity], [max_entry_count_validity], [card_icon_type], [card_background_image_path], [created_by], [module], [back_text]) VALUES (2, N'Multi Day', NULL, NULL, NULL, N'images/multi_day_vic.png', N'images/corporate/multi-day.png', NULL, 1, N'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cur')
GO
INSERT [dbo].[card_type] ([id], [name], [max_day_validity], [max_time_validity], [max_entry_count_validity], [card_icon_type], [card_background_image_path], [created_by], [module], [back_text]) VALUES (3, N'Manual', NULL, NULL, NULL, NULL, N'images/corporate/manual.png', NULL, 1, N'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cur')
GO
INSERT [dbo].[card_type] ([id], [name], [max_day_validity], [max_time_validity], [max_entry_count_validity], [card_icon_type], [card_background_image_path], [created_by], [module], [back_text]) VALUES (4, N'Contractor', NULL, NULL, NULL, NULL, N'images/corporate/contractor.png', NULL, 1, N'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cur')
GO
INSERT [dbo].[card_type] ([id], [name], [max_day_validity], [max_time_validity], [max_entry_count_validity], [card_icon_type], [card_background_image_path], [created_by], [module], [back_text]) VALUES (5, N'Same Day', NULL, NULL, NULL, NULL, N'images/vic/same_day.png', NULL, 2, N'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cur')
GO
INSERT [dbo].[card_type] ([id], [name], [max_day_validity], [max_time_validity], [max_entry_count_validity], [card_icon_type], [card_background_image_path], [created_by], [module], [back_text]) VALUES (6, N'24 Hour', NULL, NULL, NULL, NULL, N'images/vic/24_hour.png', NULL, 2, N'Psilocybe semilanceata is a fungus whose mushrooms, known as liberty caps, are also called magic mushrooms for their psychedelic properties. They are the most common of the psilocybin mushrooms, and among the most potent. They have a distinctive conical or bell-shaped cap, up to 2.5 cm (1.0 in) wide, with a small nipple-like protrusion on the top. Yellow to brown in color and fading to a lighter c')
GO
INSERT [dbo].[card_type] ([id], [name], [max_day_validity], [max_time_validity], [max_entry_count_validity], [card_icon_type], [card_background_image_path], [created_by], [module], [back_text]) VALUES (7, N'Extended', NULL, NULL, NULL, NULL, N'images/vic/extended.png', NULL, 2, N'Psilocybe semilanceata is a fungus whose mushrooms, known as liberty caps, are also called magic mushrooms for their psychedelic properties. They are the most common of the psilocybin mushrooms, and among the most potent. They have a distinctive conical or bell-shaped cap, up to 2.5 cm (1.0 in) wide, with a small nipple-like protrusion on the top. Yellow to brown in color and fading to a lighter c')
GO
INSERT [dbo].[card_type] ([id], [name], [max_day_validity], [max_time_validity], [max_entry_count_validity], [card_icon_type], [card_background_image_path], [created_by], [module], [back_text]) VALUES (8, N'Multi Day', NULL, NULL, NULL, NULL, N'images/vic/multi_day.png', NULL, 2, N'Psilocybe semilanceata is a fungus whose mushrooms, known as liberty caps, are also called magic mushrooms for their psychedelic properties. They are the most common of the psilocybin mushrooms, and among the most potent. They have a distinctive conical or bell-shaped cap, up to 2.5 cm (1.0 in) wide, with a small nipple-like protrusion on the top. Yellow to brown in color and fading to a lighter c')
GO
INSERT [dbo].[card_type] ([id], [name], [max_day_validity], [max_time_validity], [max_entry_count_validity], [card_icon_type], [card_background_image_path], [created_by], [module], [back_text]) VALUES (9, N'Manual', NULL, NULL, NULL, NULL, N'images/vic/manual.png', NULL, 2, NULL)
GO
SET IDENTITY_INSERT [dbo].[card_type] OFF
GO
SET IDENTITY_INSERT [dbo].[card_status] ON

GO
INSERT [dbo].[card_status] ([id], [name], [created_by]) VALUES (1, N'Cancelled', NULL)
GO
INSERT [dbo].[card_status] ([id], [name], [created_by]) VALUES (2, N'Returned', NULL)
GO
INSERT [dbo].[card_status] ([id], [name], [created_by]) VALUES (3, N'Active', NULL)
GO
INSERT [dbo].[card_status] ([id], [name], [created_by]) VALUES (4, N'Not Returned', NULL)
GO
SET IDENTITY_INSERT [dbo].[card_status] OFF
GO
SET IDENTITY_INSERT [dbo].[company_type] ON

GO
INSERT [dbo].[company_type] ([id], [name], [created_by]) VALUES (1, N'Tenant', NULL)
GO
INSERT [dbo].[company_type] ([id], [name], [created_by]) VALUES (2, N'Tenant Agent', NULL)
GO
INSERT [dbo].[company_type] ([id], [name], [created_by]) VALUES (3, N'Visitor', NULL)
GO
SET IDENTITY_INSERT [dbo].[company_type] OFF
GO
SET IDENTITY_INSERT [dbo].[country] ON

GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (1, N'AD', N'Andorra')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (2, N'AE', N'United Arab Emirates')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (3, N'AF', N'Afghanistan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (4, N'AG', N'Antigua and Barbuda')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (5, N'AI', N'Anguilla')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (6, N'AL', N'Albania')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (7, N'AM', N'Armenia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (8, N'AO', N'Angola')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (9, N'AQ', N'Antarctica')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (10, N'AR', N'Argentina')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (11, N'AS', N'American Samoa')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (12, N'AT', N'Austria')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (13, N'AU', N'Australia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (14, N'AW', N'Aruba')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (15, N'AX', N'Åland')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (16, N'AZ', N'Azerbaijan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (17, N'BA', N'Bosnia and Herzegovina')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (18, N'BB', N'Barbados')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (19, N'BD', N'Bangladesh')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (20, N'BE', N'Belgium')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (21, N'BF', N'Burkina Faso')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (22, N'BG', N'Bulgaria')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (23, N'BH', N'Bahrain')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (24, N'BI', N'Burundi')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (25, N'BJ', N'Benin')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (26, N'BL', N'Saint Barthélemy')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (27, N'BM', N'Bermuda')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (28, N'BN', N'Brunei')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (29, N'BO', N'Bolivia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (30, N'BQ', N'Bonaire')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (31, N'BR', N'Brazil')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (32, N'BS', N'Bahamas')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (33, N'BT', N'Bhutan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (34, N'BV', N'Bouvet Island')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (35, N'BW', N'Botswana')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (36, N'BY', N'Belarus')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (37, N'BZ', N'Belize')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (38, N'CA', N'Canada')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (39, N'CC', N'Cocos [Keeling] Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (40, N'CD', N'Democratic Republic of the Congo')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (41, N'CF', N'Central African Republic')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (42, N'CG', N'Republic of the Congo')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (43, N'CH', N'Switzerland')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (44, N'CI', N'Ivory Coast')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (45, N'CK', N'Cook Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (46, N'CL', N'Chile')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (47, N'CM', N'Cameroon')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (48, N'CN', N'China')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (49, N'CO', N'Colombia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (50, N'CR', N'Costa Rica')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (51, N'CU', N'Cuba')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (52, N'CV', N'Cape Verde')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (53, N'CW', N'Curacao')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (54, N'CX', N'Christmas Island')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (55, N'CY', N'Cyprus')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (56, N'CZ', N'Czech Republic')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (57, N'DE', N'Germany')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (58, N'DJ', N'Djibouti')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (59, N'DK', N'Denmark')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (60, N'DM', N'Dominica')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (61, N'DO', N'Dominican Republic')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (62, N'DZ', N'Algeria')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (63, N'EC', N'Ecuador')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (64, N'EE', N'Estonia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (65, N'EG', N'Egypt')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (66, N'EH', N'Western Sahara')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (67, N'ER', N'Eritrea')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (68, N'ES', N'Spain')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (69, N'ET', N'Ethiopia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (70, N'FI', N'Finland')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (71, N'FJ', N'Fiji')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (72, N'FK', N'Falkland Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (73, N'FM', N'Micronesia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (74, N'FO', N'Faroe Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (75, N'FR', N'France')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (76, N'GA', N'Gabon')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (77, N'GB', N'United Kingdom')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (78, N'GD', N'Grenada')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (79, N'GE', N'Georgia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (80, N'GF', N'French Guiana')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (81, N'GG', N'Guernsey')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (82, N'GH', N'Ghana')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (83, N'GI', N'Gibraltar')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (84, N'GL', N'Greenland')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (85, N'GM', N'Gambia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (86, N'GN', N'Guinea')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (87, N'GP', N'Guadeloupe')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (88, N'GQ', N'Equatorial Guinea')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (89, N'GR', N'Greece')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (90, N'GS', N'South Georgia and the South Sandwich Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (91, N'GT', N'Guatemala')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (92, N'GU', N'Guam')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (93, N'GW', N'Guinea-Bissau')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (94, N'GY', N'Guyana')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (95, N'HK', N'Hong Kong')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (96, N'HM', N'Heard Island and McDonald Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (97, N'HN', N'Honduras')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (98, N'HR', N'Croatia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (99, N'HT', N'Haiti')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (100, N'HU', N'Hungary')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (101, N'ID', N'Indonesia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (102, N'IE', N'Ireland')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (103, N'IL', N'Israel')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (104, N'IM', N'Isle of Man')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (105, N'IN', N'India')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (106, N'IO', N'British Indian Ocean Territory')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (107, N'IQ', N'Iraq')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (108, N'IR', N'Iran')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (109, N'IS', N'Iceland')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (110, N'IT', N'Italy')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (111, N'JE', N'Jersey')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (112, N'JM', N'Jamaica')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (113, N'JO', N'Jordan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (114, N'JP', N'Japan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (115, N'KE', N'Kenya')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (116, N'KG', N'Kyrgyzstan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (117, N'KH', N'Cambodia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (118, N'KI', N'Kiribati')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (119, N'KM', N'Comoros')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (120, N'KN', N'Saint Kitts and Nevis')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (121, N'KP', N'North Korea')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (122, N'KR', N'South Korea')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (123, N'KW', N'Kuwait')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (124, N'KY', N'Cayman Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (125, N'KZ', N'Kazakhstan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (126, N'LA', N'Laos')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (127, N'LB', N'Lebanon')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (128, N'LC', N'Saint Lucia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (129, N'LI', N'Liechtenstein')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (130, N'LK', N'Sri Lanka')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (131, N'LR', N'Liberia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (132, N'LS', N'Lesotho')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (133, N'LT', N'Lithuania')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (134, N'LU', N'Luxembourg')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (135, N'LV', N'Latvia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (136, N'LY', N'Libya')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (137, N'MA', N'Morocco')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (138, N'MC', N'Monaco')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (139, N'MD', N'Moldova')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (140, N'ME', N'Montenegro')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (141, N'MF', N'Saint Martin')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (142, N'MG', N'Madagascar')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (143, N'MH', N'Marshall Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (144, N'MK', N'Macedonia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (145, N'ML', N'Mali')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (146, N'MM', N'Myanmar [Burma]')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (147, N'MN', N'Mongolia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (148, N'MO', N'Macao')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (149, N'MP', N'Northern Mariana Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (150, N'MQ', N'Martinique')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (151, N'MR', N'Mauritania')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (152, N'MS', N'Montserrat')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (153, N'MT', N'Malta')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (154, N'MU', N'Mauritius')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (155, N'MV', N'Maldives')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (156, N'MW', N'Malawi')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (157, N'MX', N'Mexico')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (158, N'MY', N'Malaysia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (159, N'MZ', N'Mozambique')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (160, N'NA', N'Namibia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (161, N'NC', N'New Caledonia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (162, N'NE', N'Niger')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (163, N'NF', N'Norfolk Island')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (164, N'NG', N'Nigeria')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (165, N'NI', N'Nicaragua')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (166, N'NL', N'Netherlands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (167, N'NO', N'Norway')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (168, N'NP', N'Nepal')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (169, N'NR', N'Nauru')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (170, N'NU', N'Niue')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (171, N'NZ', N'New Zealand')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (172, N'OM', N'Oman')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (173, N'PA', N'Panama')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (174, N'PE', N'Peru')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (175, N'PF', N'French Polynesia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (176, N'PG', N'Papua New Guinea')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (177, N'PH', N'Philippines')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (178, N'PK', N'Pakistan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (179, N'PL', N'Poland')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (180, N'PM', N'Saint Pierre and Miquelon')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (181, N'PN', N'Pitcairn Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (182, N'PR', N'Puerto Rico')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (183, N'PS', N'Palestine')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (184, N'PT', N'Portugal')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (185, N'PW', N'Palau')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (186, N'PY', N'Paraguay')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (187, N'QA', N'Qatar')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (188, N'RE', N'Réunion')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (189, N'RO', N'Romania')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (190, N'RS', N'Serbia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (191, N'RU', N'Russia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (192, N'RW', N'Rwanda')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (193, N'SA', N'Saudi Arabia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (194, N'SB', N'Solomon Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (195, N'SC', N'Seychelles')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (196, N'SD', N'Sudan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (197, N'SE', N'Sweden')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (198, N'SG', N'Singapore')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (199, N'SH', N'Saint Helena')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (200, N'SI', N'Slovenia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (201, N'SJ', N'Svalbard and Jan Mayen')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (202, N'SK', N'Slovakia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (203, N'SL', N'Sierra Leone')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (204, N'SM', N'San Marino')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (205, N'SN', N'Senegal')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (206, N'SO', N'Somalia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (207, N'SR', N'Suriname')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (208, N'SS', N'South Sudan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (209, N'ST', N'São Tomé and Príncipe')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (210, N'SV', N'El Salvador')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (211, N'SX', N'Sint Maarten')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (212, N'SY', N'Syria')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (213, N'SZ', N'Swaziland')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (214, N'TC', N'Turks and Caicos Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (215, N'TD', N'Chad')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (216, N'TF', N'French Southern Territories')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (217, N'TG', N'Togo')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (218, N'TH', N'Thailand')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (219, N'TJ', N'Tajikistan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (220, N'TK', N'Tokelau')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (221, N'TL', N'East Timor')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (222, N'TM', N'Turkmenistan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (223, N'TN', N'Tunisia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (224, N'TO', N'Tonga')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (225, N'TR', N'Turkey')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (226, N'TT', N'Trinidad and Tobago')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (227, N'TV', N'Tuvalu')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (228, N'TW', N'Taiwan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (229, N'TZ', N'Tanzania')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (230, N'UA', N'Ukraine')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (231, N'UG', N'Uganda')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (232, N'UM', N'U.S. Minor Outlying Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (233, N'US', N'United States')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (234, N'UY', N'Uruguay')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (235, N'UZ', N'Uzbekistan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (236, N'VA', N'Vatican City')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (237, N'VC', N'Saint Vincent and the Grenadines')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (238, N'VE', N'Venezuela')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (239, N'VG', N'British Virgin Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (240, N'VI', N'U.S. Virgin Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (241, N'VN', N'Vietnam')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (242, N'VU', N'Vanuatu')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (243, N'WF', N'Wallis and Futuna')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (244, N'WS', N'Samoa')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (245, N'XK', N'Kosovo')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (246, N'YE', N'Yemen')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (247, N'YT', N'Mayotte')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (248, N'ZA', N'South Africa')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (249, N'ZM', N'Zambia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (250, N'ZW', N'Zimbabwe')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (251, N'AD', N'Andorra')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (252, N'AE', N'United Arab Emirates')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (253, N'AF', N'Afghanistan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (254, N'AG', N'Antigua and Barbuda')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (255, N'AI', N'Anguilla')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (256, N'AL', N'Albania')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (257, N'AM', N'Armenia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (258, N'AO', N'Angola')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (259, N'AQ', N'Antarctica')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (260, N'AR', N'Argentina')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (261, N'AS', N'American Samoa')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (262, N'AT', N'Austria')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (263, N'AU', N'Australia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (264, N'AW', N'Aruba')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (265, N'AX', N'Åland')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (266, N'AZ', N'Azerbaijan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (267, N'BA', N'Bosnia and Herzegovina')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (268, N'BB', N'Barbados')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (269, N'BD', N'Bangladesh')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (270, N'BE', N'Belgium')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (271, N'BF', N'Burkina Faso')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (272, N'BG', N'Bulgaria')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (273, N'BH', N'Bahrain')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (274, N'BI', N'Burundi')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (275, N'BJ', N'Benin')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (276, N'BL', N'Saint Barthélemy')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (277, N'BM', N'Bermuda')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (278, N'BN', N'Brunei')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (279, N'BO', N'Bolivia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (280, N'BQ', N'Bonaire')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (281, N'BR', N'Brazil')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (282, N'BS', N'Bahamas')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (283, N'BT', N'Bhutan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (284, N'BV', N'Bouvet Island')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (285, N'BW', N'Botswana')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (286, N'BY', N'Belarus')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (287, N'BZ', N'Belize')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (288, N'CA', N'Canada')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (289, N'CC', N'Cocos [Keeling] Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (290, N'CD', N'Democratic Republic of the Congo')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (291, N'CF', N'Central African Republic')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (292, N'CG', N'Republic of the Congo')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (293, N'CH', N'Switzerland')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (294, N'CI', N'Ivory Coast')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (295, N'CK', N'Cook Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (296, N'CL', N'Chile')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (297, N'CM', N'Cameroon')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (298, N'CN', N'China')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (299, N'CO', N'Colombia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (300, N'CR', N'Costa Rica')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (301, N'CU', N'Cuba')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (302, N'CV', N'Cape Verde')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (303, N'CW', N'Curacao')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (304, N'CX', N'Christmas Island')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (305, N'CY', N'Cyprus')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (306, N'CZ', N'Czech Republic')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (307, N'DE', N'Germany')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (308, N'DJ', N'Djibouti')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (309, N'DK', N'Denmark')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (310, N'DM', N'Dominica')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (311, N'DO', N'Dominican Republic')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (312, N'DZ', N'Algeria')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (313, N'EC', N'Ecuador')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (314, N'EE', N'Estonia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (315, N'EG', N'Egypt')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (316, N'EH', N'Western Sahara')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (317, N'ER', N'Eritrea')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (318, N'ES', N'Spain')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (319, N'ET', N'Ethiopia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (320, N'FI', N'Finland')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (321, N'FJ', N'Fiji')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (322, N'FK', N'Falkland Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (323, N'FM', N'Micronesia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (324, N'FO', N'Faroe Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (325, N'FR', N'France')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (326, N'GA', N'Gabon')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (327, N'GB', N'United Kingdom')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (328, N'GD', N'Grenada')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (329, N'GE', N'Georgia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (330, N'GF', N'French Guiana')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (331, N'GG', N'Guernsey')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (332, N'GH', N'Ghana')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (333, N'GI', N'Gibraltar')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (334, N'GL', N'Greenland')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (335, N'GM', N'Gambia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (336, N'GN', N'Guinea')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (337, N'GP', N'Guadeloupe')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (338, N'GQ', N'Equatorial Guinea')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (339, N'GR', N'Greece')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (340, N'GS', N'South Georgia and the South Sandwich Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (341, N'GT', N'Guatemala')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (342, N'GU', N'Guam')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (343, N'GW', N'Guinea-Bissau')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (344, N'GY', N'Guyana')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (345, N'HK', N'Hong Kong')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (346, N'HM', N'Heard Island and McDonald Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (347, N'HN', N'Honduras')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (348, N'HR', N'Croatia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (349, N'HT', N'Haiti')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (350, N'HU', N'Hungary')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (351, N'ID', N'Indonesia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (352, N'IE', N'Ireland')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (353, N'IL', N'Israel')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (354, N'IM', N'Isle of Man')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (355, N'IN', N'India')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (356, N'IO', N'British Indian Ocean Territory')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (357, N'IQ', N'Iraq')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (358, N'IR', N'Iran')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (359, N'IS', N'Iceland')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (360, N'IT', N'Italy')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (361, N'JE', N'Jersey')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (362, N'JM', N'Jamaica')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (363, N'JO', N'Jordan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (364, N'JP', N'Japan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (365, N'KE', N'Kenya')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (366, N'KG', N'Kyrgyzstan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (367, N'KH', N'Cambodia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (368, N'KI', N'Kiribati')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (369, N'KM', N'Comoros')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (370, N'KN', N'Saint Kitts and Nevis')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (371, N'KP', N'North Korea')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (372, N'KR', N'South Korea')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (373, N'KW', N'Kuwait')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (374, N'KY', N'Cayman Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (375, N'KZ', N'Kazakhstan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (376, N'LA', N'Laos')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (377, N'LB', N'Lebanon')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (378, N'LC', N'Saint Lucia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (379, N'LI', N'Liechtenstein')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (380, N'LK', N'Sri Lanka')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (381, N'LR', N'Liberia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (382, N'LS', N'Lesotho')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (383, N'LT', N'Lithuania')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (384, N'LU', N'Luxembourg')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (385, N'LV', N'Latvia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (386, N'LY', N'Libya')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (387, N'MA', N'Morocco')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (388, N'MC', N'Monaco')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (389, N'MD', N'Moldova')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (390, N'ME', N'Montenegro')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (391, N'MF', N'Saint Martin')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (392, N'MG', N'Madagascar')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (393, N'MH', N'Marshall Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (394, N'MK', N'Macedonia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (395, N'ML', N'Mali')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (396, N'MM', N'Myanmar [Burma]')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (397, N'MN', N'Mongolia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (398, N'MO', N'Macao')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (399, N'MP', N'Northern Mariana Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (400, N'MQ', N'Martinique')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (401, N'MR', N'Mauritania')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (402, N'MS', N'Montserrat')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (403, N'MT', N'Malta')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (404, N'MU', N'Mauritius')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (405, N'MV', N'Maldives')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (406, N'MW', N'Malawi')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (407, N'MX', N'Mexico')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (408, N'MY', N'Malaysia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (409, N'MZ', N'Mozambique')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (410, N'NA', N'Namibia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (411, N'NC', N'New Caledonia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (412, N'NE', N'Niger')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (413, N'NF', N'Norfolk Island')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (414, N'NG', N'Nigeria')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (415, N'NI', N'Nicaragua')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (416, N'NL', N'Netherlands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (417, N'NO', N'Norway')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (418, N'NP', N'Nepal')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (419, N'NR', N'Nauru')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (420, N'NU', N'Niue')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (421, N'NZ', N'New Zealand')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (422, N'OM', N'Oman')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (423, N'PA', N'Panama')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (424, N'PE', N'Peru')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (425, N'PF', N'French Polynesia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (426, N'PG', N'Papua New Guinea')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (427, N'PH', N'Philippines')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (428, N'PK', N'Pakistan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (429, N'PL', N'Poland')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (430, N'PM', N'Saint Pierre and Miquelon')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (431, N'PN', N'Pitcairn Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (432, N'PR', N'Puerto Rico')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (433, N'PS', N'Palestine')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (434, N'PT', N'Portugal')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (435, N'PW', N'Palau')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (436, N'PY', N'Paraguay')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (437, N'QA', N'Qatar')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (438, N'RE', N'Réunion')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (439, N'RO', N'Romania')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (440, N'RS', N'Serbia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (441, N'RU', N'Russia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (442, N'RW', N'Rwanda')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (443, N'SA', N'Saudi Arabia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (444, N'SB', N'Solomon Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (445, N'SC', N'Seychelles')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (446, N'SD', N'Sudan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (447, N'SE', N'Sweden')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (448, N'SG', N'Singapore')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (449, N'SH', N'Saint Helena')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (450, N'SI', N'Slovenia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (451, N'SJ', N'Svalbard and Jan Mayen')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (452, N'SK', N'Slovakia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (453, N'SL', N'Sierra Leone')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (454, N'SM', N'San Marino')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (455, N'SN', N'Senegal')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (456, N'SO', N'Somalia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (457, N'SR', N'Suriname')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (458, N'SS', N'South Sudan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (459, N'ST', N'São Tomé and Príncipe')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (460, N'SV', N'El Salvador')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (461, N'SX', N'Sint Maarten')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (462, N'SY', N'Syria')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (463, N'SZ', N'Swaziland')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (464, N'TC', N'Turks and Caicos Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (465, N'TD', N'Chad')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (466, N'TF', N'French Southern Territories')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (467, N'TG', N'Togo')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (468, N'TH', N'Thailand')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (469, N'TJ', N'Tajikistan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (470, N'TK', N'Tokelau')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (471, N'TL', N'East Timor')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (472, N'TM', N'Turkmenistan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (473, N'TN', N'Tunisia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (474, N'TO', N'Tonga')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (475, N'TR', N'Turkey')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (476, N'TT', N'Trinidad and Tobago')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (477, N'TV', N'Tuvalu')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (478, N'TW', N'Taiwan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (479, N'TZ', N'Tanzania')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (480, N'UA', N'Ukraine')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (481, N'UG', N'Uganda')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (482, N'UM', N'U.S. Minor Outlying Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (483, N'US', N'United States')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (484, N'UY', N'Uruguay')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (485, N'UZ', N'Uzbekistan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (486, N'VA', N'Vatican City')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (487, N'VC', N'Saint Vincent and the Grenadines')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (488, N'VE', N'Venezuela')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (489, N'VG', N'British Virgin Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (490, N'VI', N'U.S. Virgin Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (491, N'VN', N'Vietnam')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (492, N'VU', N'Vanuatu')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (493, N'WF', N'Wallis and Futuna')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (494, N'WS', N'Samoa')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (495, N'XK', N'Kosovo')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (496, N'YE', N'Yemen')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (497, N'YT', N'Mayotte')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (498, N'ZA', N'South Africa')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (499, N'ZM', N'Zambia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (500, N'ZW', N'Zimbabwe')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (501, N'AD', N'Andorra')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (502, N'AE', N'United Arab Emirates')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (503, N'AF', N'Afghanistan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (504, N'AG', N'Antigua and Barbuda')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (505, N'AI', N'Anguilla')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (506, N'AL', N'Albania')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (507, N'AM', N'Armenia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (508, N'AO', N'Angola')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (509, N'AQ', N'Antarctica')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (510, N'AR', N'Argentina')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (511, N'AS', N'American Samoa')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (512, N'AT', N'Austria')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (513, N'AU', N'Australia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (514, N'AW', N'Aruba')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (515, N'AX', N'Åland')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (516, N'AZ', N'Azerbaijan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (517, N'BA', N'Bosnia and Herzegovina')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (518, N'BB', N'Barbados')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (519, N'BD', N'Bangladesh')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (520, N'BE', N'Belgium')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (521, N'BF', N'Burkina Faso')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (522, N'BG', N'Bulgaria')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (523, N'BH', N'Bahrain')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (524, N'BI', N'Burundi')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (525, N'BJ', N'Benin')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (526, N'BL', N'Saint Barthélemy')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (527, N'BM', N'Bermuda')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (528, N'BN', N'Brunei')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (529, N'BO', N'Bolivia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (530, N'BQ', N'Bonaire')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (531, N'BR', N'Brazil')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (532, N'BS', N'Bahamas')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (533, N'BT', N'Bhutan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (534, N'BV', N'Bouvet Island')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (535, N'BW', N'Botswana')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (536, N'BY', N'Belarus')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (537, N'BZ', N'Belize')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (538, N'CA', N'Canada')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (539, N'CC', N'Cocos [Keeling] Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (540, N'CD', N'Democratic Republic of the Congo')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (541, N'CF', N'Central African Republic')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (542, N'CG', N'Republic of the Congo')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (543, N'CH', N'Switzerland')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (544, N'CI', N'Ivory Coast')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (545, N'CK', N'Cook Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (546, N'CL', N'Chile')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (547, N'CM', N'Cameroon')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (548, N'CN', N'China')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (549, N'CO', N'Colombia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (550, N'CR', N'Costa Rica')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (551, N'CU', N'Cuba')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (552, N'CV', N'Cape Verde')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (553, N'CW', N'Curacao')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (554, N'CX', N'Christmas Island')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (555, N'CY', N'Cyprus')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (556, N'CZ', N'Czech Republic')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (557, N'DE', N'Germany')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (558, N'DJ', N'Djibouti')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (559, N'DK', N'Denmark')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (560, N'DM', N'Dominica')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (561, N'DO', N'Dominican Republic')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (562, N'DZ', N'Algeria')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (563, N'EC', N'Ecuador')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (564, N'EE', N'Estonia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (565, N'EG', N'Egypt')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (566, N'EH', N'Western Sahara')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (567, N'ER', N'Eritrea')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (568, N'ES', N'Spain')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (569, N'ET', N'Ethiopia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (570, N'FI', N'Finland')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (571, N'FJ', N'Fiji')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (572, N'FK', N'Falkland Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (573, N'FM', N'Micronesia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (574, N'FO', N'Faroe Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (575, N'FR', N'France')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (576, N'GA', N'Gabon')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (577, N'GB', N'United Kingdom')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (578, N'GD', N'Grenada')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (579, N'GE', N'Georgia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (580, N'GF', N'French Guiana')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (581, N'GG', N'Guernsey')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (582, N'GH', N'Ghana')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (583, N'GI', N'Gibraltar')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (584, N'GL', N'Greenland')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (585, N'GM', N'Gambia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (586, N'GN', N'Guinea')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (587, N'GP', N'Guadeloupe')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (588, N'GQ', N'Equatorial Guinea')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (589, N'GR', N'Greece')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (590, N'GS', N'South Georgia and the South Sandwich Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (591, N'GT', N'Guatemala')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (592, N'GU', N'Guam')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (593, N'GW', N'Guinea-Bissau')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (594, N'GY', N'Guyana')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (595, N'HK', N'Hong Kong')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (596, N'HM', N'Heard Island and McDonald Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (597, N'HN', N'Honduras')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (598, N'HR', N'Croatia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (599, N'HT', N'Haiti')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (600, N'HU', N'Hungary')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (601, N'ID', N'Indonesia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (602, N'IE', N'Ireland')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (603, N'IL', N'Israel')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (604, N'IM', N'Isle of Man')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (605, N'IN', N'India')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (606, N'IO', N'British Indian Ocean Territory')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (607, N'IQ', N'Iraq')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (608, N'IR', N'Iran')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (609, N'IS', N'Iceland')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (610, N'IT', N'Italy')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (611, N'JE', N'Jersey')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (612, N'JM', N'Jamaica')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (613, N'JO', N'Jordan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (614, N'JP', N'Japan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (615, N'KE', N'Kenya')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (616, N'KG', N'Kyrgyzstan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (617, N'KH', N'Cambodia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (618, N'KI', N'Kiribati')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (619, N'KM', N'Comoros')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (620, N'KN', N'Saint Kitts and Nevis')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (621, N'KP', N'North Korea')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (622, N'KR', N'South Korea')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (623, N'KW', N'Kuwait')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (624, N'KY', N'Cayman Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (625, N'KZ', N'Kazakhstan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (626, N'LA', N'Laos')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (627, N'LB', N'Lebanon')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (628, N'LC', N'Saint Lucia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (629, N'LI', N'Liechtenstein')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (630, N'LK', N'Sri Lanka')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (631, N'LR', N'Liberia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (632, N'LS', N'Lesotho')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (633, N'LT', N'Lithuania')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (634, N'LU', N'Luxembourg')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (635, N'LV', N'Latvia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (636, N'LY', N'Libya')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (637, N'MA', N'Morocco')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (638, N'MC', N'Monaco')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (639, N'MD', N'Moldova')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (640, N'ME', N'Montenegro')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (641, N'MF', N'Saint Martin')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (642, N'MG', N'Madagascar')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (643, N'MH', N'Marshall Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (644, N'MK', N'Macedonia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (645, N'ML', N'Mali')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (646, N'MM', N'Myanmar [Burma]')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (647, N'MN', N'Mongolia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (648, N'MO', N'Macao')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (649, N'MP', N'Northern Mariana Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (650, N'MQ', N'Martinique')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (651, N'MR', N'Mauritania')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (652, N'MS', N'Montserrat')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (653, N'MT', N'Malta')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (654, N'MU', N'Mauritius')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (655, N'MV', N'Maldives')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (656, N'MW', N'Malawi')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (657, N'MX', N'Mexico')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (658, N'MY', N'Malaysia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (659, N'MZ', N'Mozambique')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (660, N'NA', N'Namibia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (661, N'NC', N'New Caledonia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (662, N'NE', N'Niger')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (663, N'NF', N'Norfolk Island')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (664, N'NG', N'Nigeria')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (665, N'NI', N'Nicaragua')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (666, N'NL', N'Netherlands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (667, N'NO', N'Norway')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (668, N'NP', N'Nepal')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (669, N'NR', N'Nauru')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (670, N'NU', N'Niue')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (671, N'NZ', N'New Zealand')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (672, N'OM', N'Oman')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (673, N'PA', N'Panama')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (674, N'PE', N'Peru')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (675, N'PF', N'French Polynesia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (676, N'PG', N'Papua New Guinea')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (677, N'PH', N'Philippines')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (678, N'PK', N'Pakistan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (679, N'PL', N'Poland')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (680, N'PM', N'Saint Pierre and Miquelon')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (681, N'PN', N'Pitcairn Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (682, N'PR', N'Puerto Rico')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (683, N'PS', N'Palestine')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (684, N'PT', N'Portugal')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (685, N'PW', N'Palau')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (686, N'PY', N'Paraguay')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (687, N'QA', N'Qatar')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (688, N'RE', N'Réunion')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (689, N'RO', N'Romania')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (690, N'RS', N'Serbia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (691, N'RU', N'Russia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (692, N'RW', N'Rwanda')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (693, N'SA', N'Saudi Arabia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (694, N'SB', N'Solomon Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (695, N'SC', N'Seychelles')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (696, N'SD', N'Sudan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (697, N'SE', N'Sweden')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (698, N'SG', N'Singapore')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (699, N'SH', N'Saint Helena')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (700, N'SI', N'Slovenia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (701, N'SJ', N'Svalbard and Jan Mayen')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (702, N'SK', N'Slovakia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (703, N'SL', N'Sierra Leone')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (704, N'SM', N'San Marino')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (705, N'SN', N'Senegal')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (706, N'SO', N'Somalia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (707, N'SR', N'Suriname')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (708, N'SS', N'South Sudan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (709, N'ST', N'São Tomé and Príncipe')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (710, N'SV', N'El Salvador')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (711, N'SX', N'Sint Maarten')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (712, N'SY', N'Syria')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (713, N'SZ', N'Swaziland')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (714, N'TC', N'Turks and Caicos Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (715, N'TD', N'Chad')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (716, N'TF', N'French Southern Territories')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (717, N'TG', N'Togo')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (718, N'TH', N'Thailand')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (719, N'TJ', N'Tajikistan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (720, N'TK', N'Tokelau')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (721, N'TL', N'East Timor')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (722, N'TM', N'Turkmenistan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (723, N'TN', N'Tunisia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (724, N'TO', N'Tonga')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (725, N'TR', N'Turkey')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (726, N'TT', N'Trinidad and Tobago')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (727, N'TV', N'Tuvalu')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (728, N'TW', N'Taiwan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (729, N'TZ', N'Tanzania')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (730, N'UA', N'Ukraine')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (731, N'UG', N'Uganda')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (732, N'UM', N'U.S. Minor Outlying Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (733, N'US', N'United States')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (734, N'UY', N'Uruguay')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (735, N'UZ', N'Uzbekistan')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (736, N'VA', N'Vatican City')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (737, N'VC', N'Saint Vincent and the Grenadines')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (738, N'VE', N'Venezuela')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (739, N'VG', N'British Virgin Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (740, N'VI', N'U.S. Virgin Islands')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (741, N'VN', N'Vietnam')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (742, N'VU', N'Vanuatu')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (743, N'WF', N'Wallis and Futuna')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (744, N'WS', N'Samoa')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (745, N'XK', N'Kosovo')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (746, N'YE', N'Yemen')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (747, N'YT', N'Mayotte')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (748, N'ZA', N'South Africa')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (749, N'ZM', N'Zambia')
GO
INSERT [dbo].[country] ([id], [code], [name]) VALUES (750, N'ZW', N'Zimbabwe')
GO
SET IDENTITY_INSERT [dbo].[country] OFF
GO
SET IDENTITY_INSERT [dbo].[roles] ON

GO
INSERT [dbo].[roles] ([id], [name], [created_by]) VALUES (1, N'Administrator', NULL)
GO
INSERT [dbo].[roles] ([id], [name], [created_by]) VALUES (5, N'Super Administrator', NULL)
GO
INSERT [dbo].[roles] ([id], [name], [created_by]) VALUES (6, N'Agent Administrator', NULL)
GO
INSERT [dbo].[roles] ([id], [name], [created_by]) VALUES (7, N'Agent Operator', NULL)
GO
INSERT [dbo].[roles] ([id], [name], [created_by]) VALUES (8, N'Operator', NULL)
GO
INSERT [dbo].[roles] ([id], [name], [created_by]) VALUES (9, N'Staff Member/Intranet', NULL)
GO
INSERT [dbo].[roles] ([id], [name], [created_by]) VALUES (10, N'Visitor/Kiosk', NULL)
GO
INSERT [dbo].[roles] ([id], [name], [created_by]) VALUES (11, N'Issuing Body Administrator', NULL)
GO
INSERT [dbo].[roles] ([id], [name], [created_by]) VALUES (12, N'Airport Operator', NULL)
GO
INSERT [dbo].[roles] ([id], [name], [created_by]) VALUES (13, N'Agent Airport Administrator', NULL)
GO
INSERT [dbo].[roles] ([id], [name], [created_by]) VALUES (14, N'Agent Airport Operator', NULL)
GO
SET IDENTITY_INSERT [dbo].[roles] OFF
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm000000_000000_base', 1431740661)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150406_151520_issue_081', 1431740662)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150406_151521_issue_137', 1431740663)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150406_151542_password_change_request', 1431740663)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150423_072538_visitor_card_status', 1431740663)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150424_181334_issue_171_addUserPhoto', 1431740663)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150425_081700_issue_170_addPhoTotoUser', 1431740663)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150430_170515_workstation_card_type', 1431740663)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150501_222214_update_card_type', 1431740663)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150504_111134_InsertUserRoles', 1431740663)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150504_111234_AddAsicNoToUsers', 1431740663)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150504_111245_AddAsicExpiryToUsers', 1431740663)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150505_054444_update_card_type', 1431740663)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150506_205300_tenant_and_tenant_contact', 1431740663)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150507_070457_helpdesktable', 1431740663)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150507_091726_issue_175', 1431740664)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150507_174354_update_card_type', 1431740664)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150512_100257_issue_191_visit_contractor_type_add_fields', 1431740664)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150512_111015_issue_303_Duplicate_Host_Profiles_in_Manage_Users', 1431740664)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150514_093710_YiiSession', 1431740664)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150514_205600_issue_176_visitor_asic_profile', 1431740664)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150515_055942_add_default_value_to_visitor_type_table', 1431740664)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150518_090825_import_visitor', 1431956068)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150519_020527_access_tokens', 1432063167)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150519_101512_add_extra_fields_import_visitor', 1432038265)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150520_014044_add_column_visit_count_to_visitor', 1432108457)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150520_091128_create_import_host', 1432123764)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150521_103247_create_notifications', 1432216603)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150521_103325_create_user_notification_relational_table', 1432216603)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150525_032952_add_table_visit_count_history', 1432696762)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150527_053447_create_notification_table', 1432706667)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150527_074013_visitor_add_postcode_column', 1432714468)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150528_082058_add_table_contacts', 1432812876)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150601_044057_drop_table_contacts', 1433142669)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150601_200412_audit_trail', 1433190572)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150602_151520_add_column_card_type', 1433200172)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150603_110554_add_column_card_option', 1433331465)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150604_033456_add_police_report_number_column', 1433411669)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150604_083620_alter_compnay_contactnno', 1433442276)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150604_083620_alter_tenant_add_is_deleted', 1433442276)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150611_114540_visitor_add_date_created_column', 1434028199)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150617_022554_add_column_lodgement_date_to_reset_history', 1434512395)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150617_075020_creat_reasons_table', 1434536993)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150618_091852_visit_table_remove_host_foreign_key_add_comment', 1434623990)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150619_073834_add_inductions_three_columns_in_user_table', 1434704995)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150621_111500_change_date_columns_to_date_data_type', 1434867896)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150624_020527_kiosk', 1435171186)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150624_065952_add_timezone_id_in_workstation_table', 1435309795)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150624_083025_create_table_log_convert_visitor_card_type', 1435142084)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150625_064659_create_timezone_table', 1435309795)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150625_105353_create_table_company_type', 1435316680)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150626_022554_add_column_access_token', 1435171186)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150626_023020_add_timezone_id_in_user_table', 1435309795)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150626_030856_change_visitor_contact_state_type', 1435292402)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150626_060107_change_columns_to_date_and_time', 1435309795)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150701_085132_add_column_asic_escort_visit', 1436592241)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150701_085157_add_column_escort_flag_visitor', 1436592241)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150706_040820_visitor_card_status_expired_record', 1436594098)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150706_065150_create_contact_person_table', 1436595452)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150706_092432_add_two_columns_in_reasons_table', 1436595453)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150706_093256_add_two_columns_in_contact_person_table', 1436595453)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150707_094839_add_is_under_18_to_visitor', 1436595453)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150707_104743_add_coloumn_visitor', 1436628202)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150710_095702_add_module_allowed_field_in_user', 1436628202)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150713_042302_add_db_image_in_photo_table', 1437357471)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150715_081616_change_mobile_number_datatype_in_company_table', 1437358977)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150717_043941_fix1_create_table_files_folders', 1437359748)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150720_095822_create_table_system', 1438867943)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150725_120100_add_module_to_visitor_type', 1438867944)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150725_122222_add_visitor_type_cards_table', 1438867944)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150725_233300_add_visitor_type_card_is_deleted', 1438867944)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150726_121800_add_module_to_visit_reason', 1438867944)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150728_073500_add_id_to_visitor_type_card_type', 1438867944)
GO
INSERT [dbo].[tbl_migration] ([version], [apply_time]) VALUES (N'm150804_065337_create_visitor_password_change_request', 1438869220)
GO
SET IDENTITY_INSERT [dbo].[timezone] ON

GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (1, N'(GMT-11:00) Midway Island ', N'Pacific/Midway')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (2, N'(GMT-11:00) Samoa ', N'Pacific/Samoa')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (3, N'(GMT-10:00) Hawaii ', N'Pacific/Honolulu')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (4, N'(GMT-09:00) Alaska ', N'America/Anchorage')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (5, N'(GMT-08:00) Pacific Time (US &amp; Canada) ', N'America/Los_Angeles')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (6, N'(GMT-08:00) Tijuana ', N'America/Tijuana')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (7, N'(GMT-07:00) Chihuahua ', N'America/Chihuahua')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (8, N'(GMT-07:00) La Paz ', N'America/Chihuahua')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (9, N'(GMT-07:00) Mazatlan ', N'America/Mazatlan')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (10, N'(GMT-07:00) Mountain Time (US &amp; Canada) ', N'America/Denver')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (11, N'(GMT-06:00) Central America ', N'America/Managua')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (12, N'(GMT-06:00) Central Time (US &amp; Canada) ', N'America/Chicago')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (13, N'(GMT-06:00) Guadalajara ', N'America/Mexico_City')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (14, N'(GMT-06:00) Mexico City ', N'America/Mexico_City')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (15, N'(GMT-06:00) Monterrey ', N'America/Monterrey')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (16, N'(GMT-05:00) Bogota ', N'America/Bogota')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (17, N'(GMT-05:00) Eastern Time (US &amp; Canada) ', N'America/New_York')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (18, N'(GMT-05:00) Lima ', N'America/Lima')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (19, N'(GMT-05:00) Quito ', N'America/Bogota')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (20, N'(GMT-04:00) Atlantic Time (Canada) ', N'Canada/Atlantic')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (21, N'(GMT-04:30) Caracas ', N'America/Caracas')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (22, N'(GMT-04:00) La Paz ', N'America/La_Paz')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (23, N'(GMT-04:00) Santiago ', N'America/Santiago')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (24, N'(GMT-03:30) Newfoundland ', N'America/St_Johns')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (25, N'(GMT-03:00) Brasilia ', N'America/Sao_Paulo')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (26, N'(GMT-03:00) Buenos Aires ', N'America/Argentina/Buenos_Aires')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (27, N'(GMT-03:00) Georgetown ', N'America/Argentina/Buenos_Aires')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (28, N'(GMT-03:00) Greenland ', N'America/Godthab')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (29, N'(GMT-02:00) Mid-Atlantic ', N'America/Noronha')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (30, N'(GMT-01:00) Azores ', N'Atlantic/Azores')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (31, N'(GMT-01:00) Cape Verde Is. ', N'Atlantic/Cape_Verde')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (32, N'(GMT+00:00) Casablanca ', N'Africa/Casablanca')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (33, N'(GMT+00:00) Edinburgh ', N'Europe/London')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (34, N'(GMT+00:00) Dublin ', N'Europe/Dublin')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (35, N'(GMT+00:00) Lisbon ', N'Europe/Lisbon')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (36, N'(GMT+00:00) London ', N'Europe/London')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (37, N'(GMT+00:00) Monrovia ', N'Africa/Monrovia')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (38, N'(GMT+00:00) UTC ', N'UTC')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (39, N'(GMT+01:00) Amsterdam ', N'Europe/Amsterdam')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (40, N'(GMT+01:00) Belgrade ', N'Europe/Belgrade')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (41, N'(GMT+01:00) Berlin ', N'Europe/Berlin')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (42, N'(GMT+01:00) Bern ', N'Europe/Berlin')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (43, N'(GMT+01:00) Bratislava ', N'Europe/Bratislava')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (44, N'(GMT+01:00) Brussels ', N'Europe/Brussels')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (45, N'(GMT+01:00) Budapest ', N'Europe/Budapest')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (46, N'(GMT+01:00) Copenhagen ', N'Europe/Copenhagen')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (47, N'(GMT+01:00) Ljubljana ', N'Europe/Ljubljana')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (48, N'(GMT+01:00) Madrid ', N'Europe/Madrid')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (49, N'(GMT+01:00) Paris ', N'Europe/Paris')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (50, N'(GMT+01:00) Prague ', N'Europe/Prague')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (51, N'(GMT+01:00) Rome ', N'Europe/Rome')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (52, N'(GMT+01:00) Sarajevo ', N'Europe/Sarajevo')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (53, N'(GMT+01:00) Skopje ', N'Europe/Skopje')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (54, N'(GMT+01:00) Stockholm ', N'Europe/Stockholm')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (55, N'(GMT+01:00) Vienna ', N'Europe/Vienna')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (56, N'(GMT+01:00) Warsaw ', N'Europe/Warsaw')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (57, N'(GMT+01:00) West Central Africa ', N'Africa/Lagos')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (58, N'(GMT+01:00) Zagreb ', N'Europe/Zagreb')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (59, N'(GMT+02:00) Athens ', N'Europe/Athens')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (60, N'(GMT+02:00) Bucharest ', N'Europe/Bucharest')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (61, N'(GMT+02:00) Cairo ', N'Africa/Cairo')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (62, N'(GMT+02:00) Harare ', N'Africa/Harare')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (63, N'(GMT+02:00) Helsinki ', N'Europe/Helsinki')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (64, N'(GMT+02:00) Istanbul ', N'Europe/Istanbul')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (65, N'(GMT+02:00) Jerusalem ', N'Asia/Jerusalem')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (66, N'(GMT+02:00) Kyiv ', N'Europe/Helsinki')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (67, N'(GMT+02:00) Pretoria ', N'Africa/Johannesburg')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (68, N'(GMT+02:00) Riga ', N'Europe/Riga')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (69, N'(GMT+02:00) Sofia ', N'Europe/Sofia')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (70, N'(GMT+02:00) Tallinn ', N'Europe/Tallinn')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (71, N'(GMT+02:00) Vilnius ', N'Europe/Vilnius')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (72, N'(GMT+03:00) Baghdad ', N'Asia/Baghdad')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (73, N'(GMT+03:00) Kuwait ', N'Asia/Kuwait')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (74, N'(GMT+03:00) Minsk ', N'Europe/Minsk')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (75, N'(GMT+03:00) Nairobi ', N'Africa/Nairobi')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (76, N'(GMT+03:00) Riyadh ', N'Asia/Riyadh')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (77, N'(GMT+03:00) Volgograd ', N'Europe/Volgograd')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (78, N'(GMT+03:30) Tehran ', N'Asia/Tehran')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (79, N'(GMT+04:00) Abu Dhabi ', N'Asia/Muscat')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (80, N'(GMT+04:00) Baku ', N'Asia/Baku')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (81, N'(GMT+04:00) Moscow ', N'Europe/Moscow')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (82, N'(GMT+04:00) Muscat ', N'Asia/Muscat')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (83, N'(GMT+04:00) St. Petersburg ', N'Europe/Moscow')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (84, N'(GMT+04:00) Tbilisi ', N'Asia/Tbilisi')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (85, N'(GMT+04:00) Yerevan ', N'Asia/Yerevan')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (86, N'(GMT+04:30) Kabul ', N'Asia/Kabul')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (87, N'(GMT+05:00) Islamabad ', N'Asia/Karachi')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (88, N'(GMT+05:00) Karachi ', N'Asia/Karachi')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (89, N'(GMT+05:00) Tashkent ', N'Asia/Tashkent')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (90, N'(GMT+05:30) Chennai ', N'Asia/Calcutta')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (91, N'(GMT+05:30) Kolkata ', N'Asia/Kolkata')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (92, N'(GMT+05:30) Mumbai ', N'Asia/Calcutta')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (93, N'(GMT+05:30) New Delhi ', N'Asia/Calcutta')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (94, N'(GMT+05:30) Sri Jayawardenepura ', N'Asia/Calcutta')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (95, N'(GMT+05:45) Kathmandu ', N'Asia/Katmandu')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (96, N'(GMT+06:00) Almaty ', N'Asia/Almaty')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (97, N'(GMT+06:00) Astana ', N'Asia/Dhaka')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (98, N'(GMT+06:00) Dhaka ', N'Asia/Dhaka')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (99, N'(GMT+06:00) Ekaterinburg ', N'Asia/Yekaterinburg')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (100, N'(GMT+06:30) Rangoon ', N'Asia/Rangoon')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (101, N'(GMT+07:00) Bangkok ', N'Asia/Bangkok')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (102, N'(GMT+07:00) Hanoi ', N'Asia/Bangkok')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (103, N'(GMT+07:00) Jakarta ', N'Asia/Jakarta')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (104, N'(GMT+07:00) Novosibirsk ', N'Asia/Novosibirsk')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (105, N'(GMT+08:00) Beijing ', N'Asia/Hong_Kong')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (106, N'(GMT+08:00) Chongqing ', N'Asia/Chongqing')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (107, N'(GMT+08:00) Hong Kong ', N'Asia/Hong_Kong')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (108, N'(GMT+08:00) Krasnoyarsk ', N'Asia/Krasnoyarsk')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (109, N'(GMT+08:00) Kuala Lumpur ', N'Asia/Kuala_Lumpur')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (110, N'(GMT+08:00) Perth ', N'Australia/Perth')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (111, N'(GMT+08:00) Singapore ', N'Asia/Singapore')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (112, N'(GMT+08:00) Taipei ', N'Asia/Taipei')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (113, N'(GMT+08:00) Ulaan Bataar ', N'Asia/Ulan_Bator')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (114, N'(GMT+08:00) Urumqi ', N'Asia/Urumqi')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (115, N'(GMT+09:00) Irkutsk ', N'Asia/Irkutsk')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (116, N'(GMT+09:00) Osaka ', N'Asia/Tokyo')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (117, N'(GMT+09:00) Sapporo ', N'Asia/Tokyo')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (118, N'(GMT+09:00) Seoul ', N'Asia/Seoul')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (119, N'(GMT+09:00) Tokyo ', N'Asia/Tokyo')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (120, N'(GMT+09:30) Adelaide ', N'Australia/Adelaide')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (121, N'(GMT+09:30) Darwin ', N'Australia/Darwin')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (122, N'(GMT+10:00) Brisbane ', N'Australia/Brisbane')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (123, N'(GMT+10:00) Canberra ', N'Australia/Canberra')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (124, N'(GMT+10:00) Guam ', N'Pacific/Guam')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (125, N'(GMT+10:00) Hobart ', N'Australia/Hobart')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (126, N'(GMT+10:00) Melbourne ', N'Australia/Melbourne')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (127, N'(GMT+10:00) Port Moresby ', N'Pacific/Port_Moresby')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (128, N'(GMT+10:00) Sydney ', N'Australia/Sydney')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (129, N'(GMT+10:00) Yakutsk ', N'Asia/Yakutsk')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (130, N'(GMT+11:00) Vladivostok ', N'Asia/Vladivostok')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (131, N'(GMT+12:00) Auckland ', N'Pacific/Auckland')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (132, N'(GMT+12:00) Fiji ', N'Pacific/Fiji')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (133, N'(GMT+12:00) International Date Line West ', N'Pacific/Kwajalein')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (134, N'(GMT+12:00) Kamchatka ', N'Asia/Kamchatka')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (135, N'(GMT+12:00) Magadan ', N'Asia/Magadan')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (136, N'(GMT+12:00) Marshall Is. ', N'Pacific/Fiji')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (137, N'(GMT+12:00) New Caledonia ', N'Asia/Magadan')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (138, N'(GMT+12:00) Solomon Is. ', N'Asia/Magadan')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (139, N'(GMT+12:00) Wellington ', N'Pacific/Auckland')
GO
INSERT [dbo].[timezone] ([id], [timezone_name], [timezone_value]) VALUES (140, N'(GMT+13:00) Nuku\alofa ', N'Pacific/Tongatapu')
GO
SET IDENTITY_INSERT [dbo].[timezone] OFF
GO
SET IDENTITY_INSERT [dbo].[user_status] ON

GO
INSERT [dbo].[user_status] ([id], [name], [created_by]) VALUES (1, N'Open', NULL)
GO
INSERT [dbo].[user_status] ([id], [name], [created_by]) VALUES (2, N'Access Denied', NULL)
GO
SET IDENTITY_INSERT [dbo].[user_status] OFF
GO
SET IDENTITY_INSERT [dbo].[user_type] ON

GO
INSERT [dbo].[user_type] ([id], [name], [created_by]) VALUES (1, N'Internal', NULL)
GO
INSERT [dbo].[user_type] ([id], [name], [created_by]) VALUES (2, N'External', NULL)
GO
SET IDENTITY_INSERT [dbo].[user_type] OFF
GO
SET IDENTITY_INSERT [dbo].[visit_status] ON

GO
INSERT [dbo].[visit_status] ([id], [name], [created_by]) VALUES (1, N'Active', NULL)
GO
INSERT [dbo].[visit_status] ([id], [name], [created_by]) VALUES (2, N'Pre-registered', NULL)
GO
INSERT [dbo].[visit_status] ([id], [name], [created_by]) VALUES (3, N'Closed', NULL)
GO
INSERT [dbo].[visit_status] ([id], [name], [created_by]) VALUES (4, N'Expired', NULL)
GO
INSERT [dbo].[visit_status] ([id], [name], [created_by]) VALUES (5, N'Save', NULL)
GO
INSERT [dbo].[visit_status] ([id], [name], [created_by]) VALUES (6, N'Negate', NULL)
GO
SET IDENTITY_INSERT [dbo].[visit_status] OFF
GO
SET IDENTITY_INSERT [dbo].[visitor_card_status] ON

GO
INSERT [dbo].[visitor_card_status] ([id], [name], [profile_type]) VALUES (1, N'Saved', N'VIC')
GO
INSERT [dbo].[visitor_card_status] ([id], [name], [profile_type]) VALUES (2, N'VIC Holder', N'VIC')
GO
INSERT [dbo].[visitor_card_status] ([id], [name], [profile_type]) VALUES (3, N'ASIC Pending', N'VIC')
GO
INSERT [dbo].[visitor_card_status] ([id], [name], [profile_type]) VALUES (4, N'ASIC Issued', N'VIC')
GO
INSERT [dbo].[visitor_card_status] ([id], [name], [profile_type]) VALUES (5, N'ASIC Denied', N'VIC')
GO
INSERT [dbo].[visitor_card_status] ([id], [name], [profile_type]) VALUES (6, N'ASIC Issued', N'ASIC')
GO
INSERT [dbo].[visitor_card_status] ([id], [name], [profile_type]) VALUES (7, N'ASIC Applicant', N'ASIC')
GO
INSERT [dbo].[visitor_card_status] ([id], [name], [profile_type]) VALUES (8, N'ASIC Expired', N'ASIC')
GO
SET IDENTITY_INSERT [dbo].[visitor_card_status] OFF
GO
SET IDENTITY_INSERT [dbo].[visitor_status] ON

GO
INSERT [dbo].[visitor_status] ([id], [name]) VALUES (1, N'Open')
GO
INSERT [dbo].[visitor_status] ([id], [name]) VALUES (2, N'Access Denied')
GO
INSERT [dbo].[visitor_status] ([id], [name]) VALUES (3, N'Save')
GO
SET IDENTITY_INSERT [dbo].[visitor_status] OFF
GO


SET IDENTITY_INSERT [dbo].[company] ON

INSERT INTO company (id, code, name, trading_name, logo, contact, billing_address, email_address, office_number, mobile_number, website, company_laf_preferences, created_by_user, created_by_visitor, tenant, tenant_agent, is_deleted)
VALUES (1, 'IDS', 'Identity Security', 'Identity Security', null, 'Julie Stewart Rose', 'PO BOX 710 Port Melbourne VIC 3207', 'julie.stewart@idsecurity.com.au', 396453450, 2147483647, 'http://idsecurity.com.au', NULL, NULL, NULL, 1, NULL, 0);

SET IDENTITY_INSERT [dbo].[company] OFF
GO 

SET IDENTITY_INSERT [dbo].[photo] ON
INSERT INTO photo (id, filename, unique_filename, relative_path)
VALUES (1, 'ids-logo2.jpg', '1411087524.jpg', 'uploads/company_logo/1411087524.jpg');
SET IDENTITY_INSERT [dbo].[photo] OFF
GO

SET IDENTITY_INSERT [dbo].[user] ON
INSERT INTO [user] (id, first_name, last_name, email, contact_number, date_of_birth, company, department, position, staff_id, notes, password, role, user_type, user_status, created_by, is_deleted, tenant, tenant_agent,photo,timezone_id)
VALUES (1, 'SuperAdmin', 'IDS', 'superadmin@test.com', '9998798', '1993-01-01', 1, '', '', '', '', '$2a$13$wv.A6T0CCHXczYv/tlJP6./6qUvDdOy.g8KX.FqSos1Mf6MA7Xl66', 5, 1, 1, 1, 0, 1, NULL,1,110);
SET IDENTITY_INSERT [dbo].[user] OFF
GO

SET IDENTITY_INSERT [dbo].[license_details] ON
INSERT INTO license_details (id, description) 
VALUES (1, 'This is a sample license detail.');
SET IDENTITY_INSERT [dbo].[license_details] OFF
GO

INSERT INTO tenant (id,created_by,is_deleted) VALUES (1,1,0);
GO

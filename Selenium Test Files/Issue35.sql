INSERT INTO `vms`.`photo` (`id`, `filename`, `unique_filename`, `relative_path`) 
VALUES ('3', 'card5d9c084f-1418017816.png', 'card5d9c084f-1418017816.png', 
'uploads/card_generated/card5d9c084f-1418017816.png'); 

INSERT INTO `vms`.`photo` (`id`, `filename`, `unique_filename`, `relative_path`) 
VALUES ('4', 'card5d9c084f-1418020193.png', 'card5d9c084f-1418020193.png', 
'uploads/card_generated/card5d9c084f-1418020193.png'); 

INSERT INTO `vms`.`card_generated` (`id`, `date_printed`, 
`date_expiration`, `date_cancelled`, `date_returned`, `card_image_generated_filename`, 
`visitor_id`, `card_status`, `created_by`, `tenant`, `tenant_agent`) VALUES ('2', '08-12-2014', 
'08-12-2014', NULL, NULL, '3', 
'2', '3', '16', '17', '18'); 

INSERT INTO `vms`.`card_generated` (`id`, `date_printed`, 
`date_expiration`, `date_cancelled`, `date_returned`, `card_image_generated_filename`, 
`visitor_id`, `card_status`, `created_by`, `tenant`, `tenant_agent`) VALUES ('3', '08-12-2014', 
'07-12-2014', NULL, NULL, '4', 
'2', '3', '16', '17', '18'); 

INSERT INTO `vms`.`visit` (`id`, `visitor`, `card_type`, `card`, `visitor_type`, 
`reason`, `visitor_status`, `host`, `patient`, `created_by`, `date_in`, `time_in`, 
`date_out`, `time_out`, `date_check_in`, `time_check_in`, `date_check_out`, 
`time_check_out`, `visit_status`, `workstation`, `tenant`, `tenant_agent`, `is_deleted`) 
VALUES (NULL, '2', '1', '2', '1', '1', '1', NULL, '1', '16', '07-08-2014', 
'13:49:00', '07-12-2014', NULL, '07-12-2014', '13:49:44', '07-12-2014', NULL, 
'1', '8', '17', '18', '0');


UPDATE `vms`.`visit` SET `date_in` = '07-08-2014',`time_in` = '13:49:00',`card`='3',
`date_out` = '07-12-2014',`date_check_in` = '07-12-2014',`time_check_in` = '13:49:44',`visit_status` = '1'
WHERE `id`='7'; 


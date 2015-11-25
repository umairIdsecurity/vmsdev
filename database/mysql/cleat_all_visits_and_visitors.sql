SET FOREIGN_KEY_CHECKS=0;
DELETE FROM card_generated;
DELETE FROM visit;
DELETE FROM visitor_password_change_request;
DELETE FROM `user` WHERE  role = 10;
DELETE FROM company WHERE company_type = 3;
DELETE FROM reset_history;
DELETE FROM visitor;
SET FOREIGN_KEY_CHECKS=1;
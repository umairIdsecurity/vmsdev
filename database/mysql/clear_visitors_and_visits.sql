SET FOREIGN_KEY_CHECKS=0;
DELETE FROM card_generated WHERE tenant = 1339;
DELETE FROM visit WHERE tenant = 1339 ;
DELETE FROM visitor_password_change_request WHERE EXISTS (SELECT * FROM visitor where visitor.id = visitor_password_change_request.visitor_id and visitor.tenant = 1339);
DELETE FROM `user` WHERE  tenant = 1339 AND role = 10;
DELETE FROM company WHERE tenant = 1339 AND company_type = 3;
DELETE FROM reset_history WHERE EXISTS (SELECT * FROM visitor where reset_history.visitor_id = visitor.id and visitor.tenant = 1339);
DELETE FROM visitor WHERE tenant = 1339;
SET FOREIGN_KEY_CHECKS=1;

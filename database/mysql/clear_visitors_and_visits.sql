SET FOREIGN_KEY_CHECKS=0;
DELETE FROM card_generated WHERE tenant = 232;
DELETE FROM visit WHERE tenant = 232 ;
DELETE FROM visitor_password_change_request WHERE EXISTS (SELECT * FROM visitor where visitor.id = visitor_password_change_request.visitor_id and visitor.tenant = 232);
DELETE FROM `user` WHERE  tenant = 232 AND role = 10;
DELETE FROM company WHERE tenant = 232 AND company_type = 3;
DELETE FROM reset_history WHERE EXISTS (SELECT * FROM visitor where reset_history.visitor_id = visitor.id and visitor.tenant = 232);
DELETE FROM visitor WHERE tenant = 232;
DELETE FROM `user` WHERE tenant = 232 and level = 2
SET FOREIGN_KEY_CHECKS=1;

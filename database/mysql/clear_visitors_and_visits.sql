SET FOREIGN_KEY_CHECKS=0;
SELECT @tenant = id FROM company WHERE company_type = 1 AND code = 'KGI';
DELETE FROM card_generated WHERE tenant = @tenant;
DELETE FROM visit WHERE tenant = @tenant ;
DELETE FROM visitor_password_change_request WHERE EXISTS (SELECT * FROM visitor where visitor.id = visitor_password_change_request.visitor_id and visitor.tenant = @tenant);
DELETE FROM `user` WHERE  tenant = @tenant AND role = 10;
DELETE FROM company WHERE tenant = @tenant AND company_type = 3;
DELETE FROM reset_history WHERE EXISTS (SELECT * FROM visitor where reset_history.visitor_id = visitor.id and visitor.tenant = @tenant);
DELETE FROM visitor WHERE tenant = @tenant;
SET FOREIGN_KEY_CHECKS=1;

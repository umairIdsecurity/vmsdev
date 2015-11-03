ALTER TABLE visit NOCHECK CONSTRAINT ALL;
ALTER TABLE visitor_password_change_request NOCHECK CONSTRAINT ALL;
ALTER TABLE [user] NOCHECK CONSTRAINT ALL;
ALTER TABLE company NOCHECK CONSTRAINT ALL;
ALTER TABLE reset_history NOCHECK CONSTRAINT ALL;
ALTER TABLE visitor NOCHECK CONSTRAINT ALL;
ALTER TABLE card_generated NOCHECK CONSTRAINT ALL;


DELETE FROM card_generated WHERE tenant = 232;
DELETE FROM visit WHERE tenant = 232 ;
DELETE FROM visitor_password_change_request
      WHERE EXISTS (SELECT * FROM visitor
                    WHERE visitor.id = visitor_password_change_request.visitor_id
                    AND visitor.tenant = 232);

DELETE FROM [user] WHERE  tenant = 232 AND role = 10;
DELETE FROM company WHERE tenant = 232 AND company_type = 3;
DELETE FROM reset_history WHERE EXISTS (SELECT * FROM visitor where reset_history.visitor_id = visitor.id and visitor.tenant = 232);
DELETE FROM visitor WHERE tenant = 232;

ALTER TABLE card_generated WITH CHECK CHECK CONSTRAINT ALL;
ALTER TABLE visit WITH CHECK CHECK CONSTRAINT ALL;
ALTER TABLE visitor_password_change_request WITH CHECK CHECK CONSTRAINT ALL;
ALTER TABLE [user] WITH CHECK CHECK CONSTRAINT ALL;
ALTER TABLE company WITH CHECK CHECK CONSTRAINT ALL;
ALTER TABLE reset_history WITH CHECK CHECK CONSTRAINT ALL;
ALTER TABLE visitor WITH CHECK CHECK CONSTRAINT ALL;


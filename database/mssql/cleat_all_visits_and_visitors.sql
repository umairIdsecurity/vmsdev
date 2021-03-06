ALTER TABLE visit NOCHECK CONSTRAINT ALL;
ALTER TABLE visitor_password_change_request NOCHECK CONSTRAINT ALL;
ALTER TABLE [user] NOCHECK CONSTRAINT ALL;
ALTER TABLE company NOCHECK CONSTRAINT ALL;
ALTER TABLE reset_history NOCHECK CONSTRAINT ALL;
ALTER TABLE visitor NOCHECK CONSTRAINT ALL;
ALTER TABLE card_generated NOCHECK CONSTRAINT ALL;


DELETE FROM card_generated;
DELETE FROM visit;
DELETE FROM visitor_password_change_request;
DELETE FROM [user] WHERE role = 10;
DELETE FROM company WHERE company_type = 3;
DELETE FROM reset_history;
DELETE FROM visitor;

ALTER TABLE card_generated WITH CHECK CHECK CONSTRAINT ALL;
ALTER TABLE visit WITH CHECK CHECK CONSTRAINT ALL;
ALTER TABLE visitor_password_change_request WITH CHECK CHECK CONSTRAINT ALL;
ALTER TABLE [user] WITH CHECK CHECK CONSTRAINT ALL;
ALTER TABLE company WITH CHECK CHECK CONSTRAINT ALL;
ALTER TABLE reset_history WITH CHECK CHECK CONSTRAINT ALL;
ALTER TABLE visitor WITH CHECK CHECK CONSTRAINT ALL;
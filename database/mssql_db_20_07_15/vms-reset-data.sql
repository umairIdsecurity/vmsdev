
-- Disable constraints for all tables:
EXEC sp_msforeachtable 'ALTER TABLE ? NOCHECK CONSTRAINT All'
GO
EXEC sp_MSForEachTable 'ALTER TABLE ? DISABLE TRIGGER ALL'
GO

declare @cursor cursor
set @cursor = cursor static for
  SELECT TABLE_NAME FROM information_schema.tables
	WHERE TABLE_CATALOG = 'vmsstage'
	AND TABLE_NAME NOT IN (
		'card_status','card_type''company_type','help_desk','helpdesk_group'
		,'license_details','module','roles','user_status','user_type',
		'visit_reason','visit_status','visitor_status','tbl_migration')

declare @tbl varchar(80)
declare @stmt nvarchar(200)
open @cursor
while 1=1 begin
  fetch next from @cursor into @tbl
  if @@fetch_status <> 0 break
  SELECT @stmt = 'DELETE FROM [' + @tbl + ']'
  EXEC sp_executesql @stmt
end
-- not strictly necessary w/ cursor variables since the will go out of scope like a normal var
close @cursor
deallocate @cursor



-- reset identity columns
EXEC sp_MSforeachtable "DBCC CHECKIDENT ( '?', RESEED, 0)"


INSERT INTO company (id, code, name, trading_name, logo, contact, billing_address, email_address, office_number, mobile_number, website, company_laf_preferences, created_by_user, created_by_visitor, tenant, tenant_agent, is_deleted) VALUES
(1, 'IDS', 'Identity Security', 'Identity Security', 1, 'Julie Stewart Rose', 'PO BOX 710 Port Melbourne VIC 3207', 'julie.stewart@idsecurity.com.au', 396453450, 2147483647, 'http://idsecurity.com.au', 1, NULL, NULL, 1, NULL, 0);


INSERT INTO [user] (id, first_name, last_name, email, contact_number, date_of_birth, company, department, position, staff_id, notes, password, role, user_type, user_status, created_by, is_deleted, tenant, tenant_agent) VALUES
(1, 'SuperAdmin', 'IDS', 'superadmin@test.com', '9998798', '1993-01-01', 1, '', '', '', '', '$2a$13$wv.A6T0CCHXczYv/tlJP6./6qUvDdOy.g8KX.FqSos1Mf6MA7Xl66', 5, 1, 1, 1, 0, 1, NULL);

INSERT INTO tenant (id,created_by,is_deleted) VALUES (1,1,0);


--
-- Set all passwords to 12345
--

UPDATE [user] set password = '$2a$13$wv.A6T0CCHXczYv/tlJP6./6qUvDdOy.g8KX.FqSos1Mf6MA7Xl66';


-- Re-enable constraints for all tables:
EXEC sp_msforeachtable 'ALTER TABLE ? WITH CHECK CHECK CONSTRAINT ALL'
GO
EXEC sp_MSForEachTable 'ALTER TABLE ? ENABLE TRIGGER ALL'
GO


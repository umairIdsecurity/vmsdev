IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'yiisession', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'yiisession'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'workstation_card_type', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'workstation_card_type'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'workstation', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'workstation'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'visitor_type', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'visitor_type'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'visitor_status', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'visitor_status'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'visitor_card_status', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'visitor_card_status'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'visitor', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'visitor'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'visit_status', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'visit_status'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'visit_reason', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'visit_reason'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'visit', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'visit'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'vehicle', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'vehicle'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'user_workstation', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'user_workstation'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'user_type', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'user_type'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'user_status', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'user_status'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'user_notification', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'user_notification'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'user', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'user'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'timezone', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'timezone'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'tenant_contact', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'tenant_contact'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'tenant', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'tenant'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'tbl_migration', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'tbl_migration'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'roles', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'roles'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'reset_history', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'reset_history'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'reasons', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'reasons'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'photo', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'photo'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'patient', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'patient'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'password_change_request', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'password_change_request'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'notification', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'notification'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'module', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'module'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'license_details', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'license_details'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'import_visitor', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'import_visitor'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'import_hosts', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'import_hosts'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'helpdesk_group', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'helpdesk_group'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'helpdesk', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'helpdesk'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'cvms_kiosk', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'cvms_kiosk'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'country', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'country'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'company_type', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'company_type'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'company_laf_preferences', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'company_laf_preferences'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'company', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'company'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'cardstatus_convert', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'cardstatus_convert'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'card_type', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'card_type'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'card_status', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'card_status'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'card_generated', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'card_generated'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'audit_trail', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'audit_trail'

GO
IF  EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'access_tokens', NULL,NULL))
EXEC sys.sp_dropextendedproperty @name=N'MS_SSMA_SOURCE' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'access_tokens'

GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[workstation_card_type$workstation_card_type_workstation]') AND parent_object_id = OBJECT_ID(N'[dbo].[workstation_card_type]'))
ALTER TABLE [dbo].[workstation_card_type] DROP CONSTRAINT [workstation_card_type$workstation_card_type_workstation]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[workstation_card_type$workstation_card_type_card_type]') AND parent_object_id = OBJECT_ID(N'[dbo].[workstation_card_type]'))
ALTER TABLE [dbo].[workstation_card_type] DROP CONSTRAINT [workstation_card_type$workstation_card_type_card_type]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[workstation$workstation_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[workstation]'))
ALTER TABLE [dbo].[workstation] DROP CONSTRAINT [workstation$workstation_ibfk_1]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor_type_card_type_visitor_type_fk]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor_type_card_type]'))
ALTER TABLE [dbo].[visitor_type_card_type] DROP CONSTRAINT [visitor_type_card_type_visitor_type_fk]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor_type_card_type_tenant_fk]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor_type_card_type]'))
ALTER TABLE [dbo].[visitor_type_card_type] DROP CONSTRAINT [visitor_type_card_type_tenant_fk]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor_type_card_type_card_type_fk]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor_type_card_type]'))
ALTER TABLE [dbo].[visitor_type_card_type] DROP CONSTRAINT [visitor_type_card_type_card_type_fk]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor_type$visitor_type_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor_type]'))
ALTER TABLE [dbo].[visitor_type] DROP CONSTRAINT [visitor_type$visitor_type_ibfk_1]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor_password_change_request_visitor_id]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor_password_change_request]'))
ALTER TABLE [dbo].[visitor_password_change_request] DROP CONSTRAINT [visitor_password_change_request_visitor_id]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$visitor_workstation_fk]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [visitor$visitor_workstation_fk]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$visitor_ibfk_9]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [visitor$visitor_ibfk_9]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$visitor_ibfk_8]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [visitor$visitor_ibfk_8]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$visitor_ibfk_7]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [visitor$visitor_ibfk_7]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$visitor_ibfk_6]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [visitor$visitor_ibfk_6]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$visitor_ibfk_5]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [visitor$visitor_ibfk_5]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$visitor_ibfk_3]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [visitor$visitor_ibfk_3]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$visitor_ibfk_2]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [visitor$visitor_ibfk_2]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$visitor_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [visitor$visitor_ibfk_1]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$visitor_card_status_fk]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [visitor$visitor_card_status_fk]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$identification_country_fk]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [visitor$identification_country_fk]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$contact_country_fk]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [visitor$contact_country_fk]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit_status$visit_status_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit_status]'))
ALTER TABLE [dbo].[visit_status] DROP CONSTRAINT [visit_status$visit_status_ibfk_1]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit_reason$visit_reason_ibfk_3]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit_reason]'))
ALTER TABLE [dbo].[visit_reason] DROP CONSTRAINT [visit_reason$visit_reason_ibfk_3]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit_reason$visit_reason_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit_reason]'))
ALTER TABLE [dbo].[visit_reason] DROP CONSTRAINT [visit_reason$visit_reason_ibfk_1]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit$visit_ibfk_8]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit]'))
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [visit$visit_ibfk_8]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit$visit_ibfk_7]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit]'))
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [visit$visit_ibfk_7]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit$visit_ibfk_5]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit]'))
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [visit$visit_ibfk_5]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit$visit_ibfk_4]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit]'))
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [visit$visit_ibfk_4]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit$visit_ibfk_3]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit]'))
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [visit$visit_ibfk_3]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit$visit_ibfk_13]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit]'))
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [visit$visit_ibfk_13]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit$visit_ibfk_12]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit]'))
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [visit$visit_ibfk_12]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit$visit_ibfk_11]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit]'))
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [visit$visit_ibfk_11]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit$visit_ibfk_10]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit]'))
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [visit$visit_ibfk_10]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit$visit_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit]'))
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [visit$visit_ibfk_1]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[user_workstation$user_workstation_ibfk_2]') AND parent_object_id = OBJECT_ID(N'[dbo].[user_workstation]'))
ALTER TABLE [dbo].[user_workstation] DROP CONSTRAINT [user_workstation$user_workstation_ibfk_2]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[user_workstation$user_workstation_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[user_workstation]'))
ALTER TABLE [dbo].[user_workstation] DROP CONSTRAINT [user_workstation$user_workstation_ibfk_1]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[user_type$user_type_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[user_type]'))
ALTER TABLE [dbo].[user_type] DROP CONSTRAINT [user_type$user_type_ibfk_1]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[user_status$user_status_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[user_status]'))
ALTER TABLE [dbo].[user_status] DROP CONSTRAINT [user_status$user_status_ibfk_1]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[user$user_ibfk_7]') AND parent_object_id = OBJECT_ID(N'[dbo].[user]'))
ALTER TABLE [dbo].[user] DROP CONSTRAINT [user$user_ibfk_7]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[user$user_ibfk_5]') AND parent_object_id = OBJECT_ID(N'[dbo].[user]'))
ALTER TABLE [dbo].[user] DROP CONSTRAINT [user$user_ibfk_5]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[user$user_ibfk_4]') AND parent_object_id = OBJECT_ID(N'[dbo].[user]'))
ALTER TABLE [dbo].[user] DROP CONSTRAINT [user$user_ibfk_4]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[user$user_ibfk_3]') AND parent_object_id = OBJECT_ID(N'[dbo].[user]'))
ALTER TABLE [dbo].[user] DROP CONSTRAINT [user$user_ibfk_3]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[user$user_ibfk_2]') AND parent_object_id = OBJECT_ID(N'[dbo].[user]'))
ALTER TABLE [dbo].[user] DROP CONSTRAINT [user$user_ibfk_2]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[user$user_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[user]'))
ALTER TABLE [dbo].[user] DROP CONSTRAINT [user$user_ibfk_1]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[tenant_contact$fk_tenant_contact_tenant1]') AND parent_object_id = OBJECT_ID(N'[dbo].[tenant_contact]'))
ALTER TABLE [dbo].[tenant_contact] DROP CONSTRAINT [tenant_contact$fk_tenant_contact_tenant1]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[tenant$fk_tenant_company1]') AND parent_object_id = OBJECT_ID(N'[dbo].[tenant]'))
ALTER TABLE [dbo].[tenant] DROP CONSTRAINT [tenant$fk_tenant_company1]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[roles$roles_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[roles]'))
ALTER TABLE [dbo].[roles] DROP CONSTRAINT [roles$roles_ibfk_1]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[password_change_request$user_password_change_request_user_id]') AND parent_object_id = OBJECT_ID(N'[dbo].[password_change_request]'))
ALTER TABLE [dbo].[password_change_request] DROP CONSTRAINT [password_change_request$user_password_change_request_user_id]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[helpdesk$helpdesk_helpdesk_group]') AND parent_object_id = OBJECT_ID(N'[dbo].[helpdesk]'))
ALTER TABLE [dbo].[helpdesk] DROP CONSTRAINT [helpdesk$helpdesk_helpdesk_group]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[folders_user_fk]') AND parent_object_id = OBJECT_ID(N'[dbo].[folders]'))
ALTER TABLE [dbo].[folders] DROP CONSTRAINT [folders_user_fk]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[files_user_fk]') AND parent_object_id = OBJECT_ID(N'[dbo].[files]'))
ALTER TABLE [dbo].[files] DROP CONSTRAINT [files_user_fk]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[files_folders_fk]') AND parent_object_id = OBJECT_ID(N'[dbo].[files]'))
ALTER TABLE [dbo].[files] DROP CONSTRAINT [files_folders_fk]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[company$company_ibfk_5]') AND parent_object_id = OBJECT_ID(N'[dbo].[company]'))
ALTER TABLE [dbo].[company] DROP CONSTRAINT [company$company_ibfk_5]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[company$company_ibfk_4]') AND parent_object_id = OBJECT_ID(N'[dbo].[company]'))
ALTER TABLE [dbo].[company] DROP CONSTRAINT [company$company_ibfk_4]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[company$company_ibfk_2]') AND parent_object_id = OBJECT_ID(N'[dbo].[company]'))
ALTER TABLE [dbo].[company] DROP CONSTRAINT [company$company_ibfk_2]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[company$company_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[company]'))
ALTER TABLE [dbo].[company] DROP CONSTRAINT [company$company_ibfk_1]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[card_type$card_type_module]') AND parent_object_id = OBJECT_ID(N'[dbo].[card_type]'))
ALTER TABLE [dbo].[card_type] DROP CONSTRAINT [card_type$card_type_module]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[card_type$card_type_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[card_type]'))
ALTER TABLE [dbo].[card_type] DROP CONSTRAINT [card_type$card_type_ibfk_1]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[card_status$card_status_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[card_status]'))
ALTER TABLE [dbo].[card_status] DROP CONSTRAINT [card_status$card_status_ibfk_1]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[card_generated$card_generated_ibfk_6]') AND parent_object_id = OBJECT_ID(N'[dbo].[card_generated]'))
ALTER TABLE [dbo].[card_generated] DROP CONSTRAINT [card_generated$card_generated_ibfk_6]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[card_generated$card_generated_ibfk_5]') AND parent_object_id = OBJECT_ID(N'[dbo].[card_generated]'))
ALTER TABLE [dbo].[card_generated] DROP CONSTRAINT [card_generated$card_generated_ibfk_5]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[card_generated$card_generated_ibfk_3]') AND parent_object_id = OBJECT_ID(N'[dbo].[card_generated]'))
ALTER TABLE [dbo].[card_generated] DROP CONSTRAINT [card_generated$card_generated_ibfk_3]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[card_generated$card_generated_ibfk_2]') AND parent_object_id = OBJECT_ID(N'[dbo].[card_generated]'))
ALTER TABLE [dbo].[card_generated] DROP CONSTRAINT [card_generated$card_generated_ibfk_2]
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[card_generated$card_generated_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[card_generated]'))
ALTER TABLE [dbo].[card_generated] DROP CONSTRAINT [card_generated$card_generated_ibfk_1]
GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__yiisessio__expir__17C286CF]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[yiisession] DROP CONSTRAINT [DF__yiisessio__expir__17C286CF]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__yiisession__id__16CE6296]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[yiisession] DROP CONSTRAINT [DF__yiisession__id__16CE6296]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__workstati__is_de__13F1F5EB]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[workstation] DROP CONSTRAINT [DF__workstati__is_de__13F1F5EB]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__workstati__tenan__12FDD1B2]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[workstation] DROP CONSTRAINT [DF__workstati__tenan__12FDD1B2]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__workstati__tenan__1209AD79]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[workstation] DROP CONSTRAINT [DF__workstati__tenan__1209AD79]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__workstati__creat__11158940]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[workstation] DROP CONSTRAINT [DF__workstati__creat__11158940]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__workstati__passw__10216507]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[workstation] DROP CONSTRAINT [DF__workstati__passw__10216507]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__workstati__assig__0F2D40CE]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[workstation] DROP CONSTRAINT [DF__workstati__assig__0F2D40CE]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__workstati__numbe__0E391C95]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[workstation] DROP CONSTRAINT [DF__workstati__numbe__0E391C95]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__workstati__conta__0D44F85C]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[workstation] DROP CONSTRAINT [DF__workstati__conta__0D44F85C]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__workstati__conta__0C50D423]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[workstation] DROP CONSTRAINT [DF__workstati__conta__0C50D423]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__workstati__conta__0B5CAFEA]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[workstation] DROP CONSTRAINT [DF__workstati__conta__0B5CAFEA]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__workstati__locat__0A688BB1]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[workstation] DROP CONSTRAINT [DF__workstati__locat__0A688BB1]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor_t__is_de__04459E07]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor_type_card_type] DROP CONSTRAINT [DF__visitor_t__is_de__04459E07]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor_t__is_de__0880433F]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor_type] DROP CONSTRAINT [DF__visitor_t__is_de__0880433F]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor_t__is_de__078C1F06]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor_type] DROP CONSTRAINT [DF__visitor_t__is_de__078C1F06]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor_t__tenan__0697FACD]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor_type] DROP CONSTRAINT [DF__visitor_t__tenan__0697FACD]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor_t__tenan__05A3D694]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor_type] DROP CONSTRAINT [DF__visitor_t__tenan__05A3D694]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor_t__creat__04AFB25B]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor_type] DROP CONSTRAINT [DF__visitor_t__creat__04AFB25B]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor_ty__name__03BB8E22]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor_type] DROP CONSTRAINT [DF__visitor_ty__name__03BB8E22]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor_st__name__01D345B0]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor_status] DROP CONSTRAINT [DF__visitor_st__name__01D345B0]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor_c__profi__7FEAFD3E]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor_card_status] DROP CONSTRAINT [DF__visitor_c__profi__7FEAFD3E]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__is_unde__5B438874]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__is_unde__5B438874]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__date_cr__7E02B4CC]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__date_cr__7E02B4CC]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__contact__7D0E9093]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__contact__7D0E9093]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__verifia__7C1A6C5A]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__verifia__7C1A6C5A]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__asic_ex__7B264821]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__asic_ex__7B264821]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__asic_no__7A3223E8]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__asic_no__7A3223E8]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__contact__793DFFAF]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__contact__793DFFAF]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__contact__7849DB76]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__contact__7849DB76]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__contact__7755B73D]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__contact__7755B73D]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__contact__76619304]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__contact__76619304]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__contact__756D6ECB]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__contact__756D6ECB]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__contact__74794A92]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__contact__74794A92]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__contact__73852659]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__contact__73852659]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__identif__72910220]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__identif__72910220]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__identif__719CDDE7]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__identif__719CDDE7]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__identif__70A8B9AE]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__identif__70A8B9AE]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__identif__6FB49575]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__identif__6FB49575]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__identif__6EC0713C]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__identif__6EC0713C]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__identif__6DCC4D03]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__identif__6DCC4D03]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__identif__6CD828CA]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__identif__6CD828CA]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__identif__6BE40491]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__identif__6BE40491]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__identif__6AEFE058]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__identif__6AEFE058]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__identif__69FBBC1F]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__identif__69FBBC1F]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__profile__690797E6]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__profile__690797E6]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__visitor__681373AD]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__visitor__681373AD]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__visitor__671F4F74]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__visitor__671F4F74]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__tenant___662B2B3B]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__tenant___662B2B3B]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__tenant__65370702]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__tenant__65370702]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__is_dele__6442E2C9]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__is_dele__6442E2C9]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__created__634EBE90]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__created__634EBE90]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__photo__625A9A57]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__photo__625A9A57]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__vehicle__6166761E]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__vehicle__6166761E]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__visitor__607251E5]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__visitor__607251E5]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__visitor__5F7E2DAC]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__visitor__5F7E2DAC]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__role__5E8A0973]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__role__5E8A0973]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__passwor__5D95E53A]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__passwor__5D95E53A]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__staff_i__5CA1C101]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__staff_i__5CA1C101]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__positio__5BAD9CC8]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__positio__5BAD9CC8]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__departm__5AB9788F]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__departm__5AB9788F]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__company__59C55456]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__company__59C55456]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__date_of__58D1301D]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__date_of__58D1301D]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__middle___57DD0BE4]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] DROP CONSTRAINT [DF__visitor__middle___57DD0BE4]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit_sta__creat__55F4C372]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit_status] DROP CONSTRAINT [DF__visit_sta__creat__55F4C372]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit_stat__name__55009F39]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit_status] DROP CONSTRAINT [DF__visit_stat__name__55009F39]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit_rea__is_de__531856C7]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit_reason] DROP CONSTRAINT [DF__visit_rea__is_de__531856C7]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit_rea__tenan__5224328E]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit_reason] DROP CONSTRAINT [DF__visit_rea__tenan__5224328E]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit_rea__tenan__51300E55]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit_reason] DROP CONSTRAINT [DF__visit_rea__tenan__51300E55]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit_rea__creat__503BEA1C]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit_reason] DROP CONSTRAINT [DF__visit_rea__creat__503BEA1C]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__police_re__4E53A1AA]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [DF__visit__police_re__4E53A1AA]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__card_opti__4D5F7D71]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [DF__visit__card_opti__4D5F7D71]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__negate_re__4C6B5938]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [DF__visit__negate_re__4C6B5938]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__reset_id__4B7734FF]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [DF__visit__reset_id__4B7734FF]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__card_retu__4A8310C6]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [DF__visit__card_retu__4A8310C6]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__finish_ti__498EEC8D]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [DF__visit__finish_ti__498EEC8D]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__finish_da__489AC854]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [DF__visit__finish_da__489AC854]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__is_delete__47A6A41B]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [DF__visit__is_delete__47A6A41B]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__tenant_ag__46B27FE2]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [DF__visit__tenant_ag__46B27FE2]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__tenant__45BE5BA9]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [DF__visit__tenant__45BE5BA9]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__workstati__44CA3770]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [DF__visit__workstati__44CA3770]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__visit_sta__43D61337]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [DF__visit__visit_sta__43D61337]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__time_chec__42E1EEFE]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [DF__visit__time_chec__42E1EEFE]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__date_chec__41EDCAC5]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [DF__visit__date_chec__41EDCAC5]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__time_chec__40F9A68C]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [DF__visit__time_chec__40F9A68C]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__date_chec__40058253]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [DF__visit__date_chec__40058253]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__time_out__3F115E1A]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [DF__visit__time_out__3F115E1A]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__date_out__3E1D39E1]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [DF__visit__date_out__3E1D39E1]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__time_in__3D2915A8]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [DF__visit__time_in__3D2915A8]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__date_in__3C34F16F]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [DF__visit__date_in__3C34F16F]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__created_b__3B40CD36]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [DF__visit__created_b__3B40CD36]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__patient__3A4CA8FD]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [DF__visit__patient__3A4CA8FD]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__host__395884C4]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [DF__visit__host__395884C4]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__visitor_s__3864608B]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [DF__visit__visitor_s__3864608B]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__reason__37703C52]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [DF__visit__reason__37703C52]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__visitor_t__367C1819]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [DF__visit__visitor_t__367C1819]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__card__3587F3E0]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [DF__visit__card__3587F3E0]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__card_type__3493CFA7]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [DF__visit__card_type__3493CFA7]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__visitor__339FAB6E]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] DROP CONSTRAINT [DF__visit__visitor__339FAB6E]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user_work__is_pr__30C33EC3]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user_workstation] DROP CONSTRAINT [DF__user_work__is_pr__30C33EC3]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user_work__creat__2FCF1A8A]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user_workstation] DROP CONSTRAINT [DF__user_work__creat__2FCF1A8A]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user_type__creat__2DE6D218]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user_type] DROP CONSTRAINT [DF__user_type__creat__2DE6D218]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user_stat__creat__2BFE89A6]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user_status] DROP CONSTRAINT [DF__user_stat__creat__2BFE89A6]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user_noti__date___2A164134]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user_notification] DROP CONSTRAINT [DF__user_noti__date___2A164134]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user_noti__has_r__29221CFB]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user_notification] DROP CONSTRAINT [DF__user_noti__has_r__29221CFB]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user_noti__notif__282DF8C2]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user_notification] DROP CONSTRAINT [DF__user_noti__notif__282DF8C2]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user_noti__user___2739D489]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user_notification] DROP CONSTRAINT [DF__user_noti__user___2739D489]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user__induction___25518C17]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user] DROP CONSTRAINT [DF__user__induction___25518C17]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user__is_complet__245D67DE]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user] DROP CONSTRAINT [DF__user__is_complet__245D67DE]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user__is_require__236943A5]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user] DROP CONSTRAINT [DF__user__is_require__236943A5]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user__asic_expir__22751F6C]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user] DROP CONSTRAINT [DF__user__asic_expir__22751F6C]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user__asic_no__2180FB33]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user] DROP CONSTRAINT [DF__user__asic_no__2180FB33]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user__tenant_age__208CD6FA]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user] DROP CONSTRAINT [DF__user__tenant_age__208CD6FA]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user__tenant__1F98B2C1]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user] DROP CONSTRAINT [DF__user__tenant__1F98B2C1]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user__is_deleted__1EA48E88]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user] DROP CONSTRAINT [DF__user__is_deleted__1EA48E88]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user__created_by__1DB06A4F]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user] DROP CONSTRAINT [DF__user__created_by__1DB06A4F]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user__user_statu__1CBC4616]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user] DROP CONSTRAINT [DF__user__user_statu__1CBC4616]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user__password__1BC821DD]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user] DROP CONSTRAINT [DF__user__password__1BC821DD]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user__staff_id__1AD3FDA4]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user] DROP CONSTRAINT [DF__user__staff_id__1AD3FDA4]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user__position__19DFD96B]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user] DROP CONSTRAINT [DF__user__position__19DFD96B]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user__department__18EBB532]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user] DROP CONSTRAINT [DF__user__department__18EBB532]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user__company__17F790F9]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user] DROP CONSTRAINT [DF__user__company__17F790F9]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user__date_of_bi__17036CC0]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user] DROP CONSTRAINT [DF__user__date_of_bi__17036CC0]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__tenant__is_delet__1332DBDC]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[tenant] DROP CONSTRAINT [DF__tenant__is_delet__1332DBDC]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__tbl_migra__apply__114A936A]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[tbl_migration] DROP CONSTRAINT [DF__tbl_migra__apply__114A936A]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__roles__created_b__0F624AF8]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[roles] DROP CONSTRAINT [DF__roles__created_b__0F624AF8]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__reset_his__lodge__0D7A0286]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[reset_history] DROP CONSTRAINT [DF__reset_his__lodge__0D7A0286]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__reasons__date_cr__0B91BA14]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[reasons] DROP CONSTRAINT [DF__reasons__date_cr__0B91BA14]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__patient__name__08B54D69]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[patient] DROP CONSTRAINT [DF__patient__name__08B54D69]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__password___is_us__06CD04F7]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[password_change_request] DROP CONSTRAINT [DF__password___is_us__06CD04F7]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__password___creat__05D8E0BE]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[password_change_request] DROP CONSTRAINT [DF__password___creat__05D8E0BE]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__password_c__hash__04E4BC85]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[password_change_request] DROP CONSTRAINT [DF__password_c__hash__04E4BC85]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__password___user___03F0984C]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[password_change_request] DROP CONSTRAINT [DF__password___user___03F0984C]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__notificat__notif__02084FDA]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[notification] DROP CONSTRAINT [DF__notificat__notif__02084FDA]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__notificat__role___01142BA1]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[notification] DROP CONSTRAINT [DF__notificat__role___01142BA1]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__notificat__date___00200768]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[notification] DROP CONSTRAINT [DF__notificat__date___00200768]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__notificat__creat__7F2BE32F]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[notification] DROP CONSTRAINT [DF__notificat__creat__7F2BE32F]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__module__created___7D439ABD]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[module] DROP CONSTRAINT [DF__module__created___7D439ABD]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__module__about__7C4F7684]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[module] DROP CONSTRAINT [DF__module__about__7C4F7684]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_vi__conta__797309D9]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_visitor] DROP CONSTRAINT [DF__import_vi__conta__797309D9]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_vi__vehic__787EE5A0]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_visitor] DROP CONSTRAINT [DF__import_vi__vehic__787EE5A0]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_vi__date___778AC167]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_visitor] DROP CONSTRAINT [DF__import_vi__date___778AC167]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_vi__date___76969D2E]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_visitor] DROP CONSTRAINT [DF__import_vi__date___76969D2E]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_vi__posit__75A278F5]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_visitor] DROP CONSTRAINT [DF__import_vi__posit__75A278F5]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_vi__check__74AE54BC]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_visitor] DROP CONSTRAINT [DF__import_vi__check__74AE54BC]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_vi__check__73BA3083]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_visitor] DROP CONSTRAINT [DF__import_vi__check__73BA3083]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_vi__impor__72C60C4A]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_visitor] DROP CONSTRAINT [DF__import_vi__impor__72C60C4A]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_vi__impor__71D1E811]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_visitor] DROP CONSTRAINT [DF__import_vi__impor__71D1E811]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_vi__check__70DDC3D8]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_visitor] DROP CONSTRAINT [DF__import_vi__check__70DDC3D8]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_vi__check__6FE99F9F]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_visitor] DROP CONSTRAINT [DF__import_vi__check__6FE99F9F]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_vi__card___6EF57B66]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_visitor] DROP CONSTRAINT [DF__import_vi__card___6EF57B66]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_ho__date___6D0D32F4]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_hosts] DROP CONSTRAINT [DF__import_ho__date___6D0D32F4]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_ho__posit__6C190EBB]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_hosts] DROP CONSTRAINT [DF__import_ho__posit__6C190EBB]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_hos__role__6B24EA82]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_hosts] DROP CONSTRAINT [DF__import_hos__role__6B24EA82]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_ho__date___6A30C649]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_hosts] DROP CONSTRAINT [DF__import_ho__date___6A30C649]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_ho__impor__693CA210]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_hosts] DROP CONSTRAINT [DF__import_ho__impor__693CA210]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__helpdesk___is_de__6754599E]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[helpdesk_group] DROP CONSTRAINT [DF__helpdesk___is_de__6754599E]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__helpdesk___creat__66603565]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[helpdesk_group] DROP CONSTRAINT [DF__helpdesk___creat__66603565]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__helpdesk___order__656C112C]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[helpdesk_group] DROP CONSTRAINT [DF__helpdesk___order__656C112C]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__helpdesk__is_del__6383C8BA]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[helpdesk] DROP CONSTRAINT [DF__helpdesk__is_del__6383C8BA]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__helpdesk__create__628FA481]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[helpdesk] DROP CONSTRAINT [DF__helpdesk__create__628FA481]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__helpdesk__order___619B8048]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[helpdesk] DROP CONSTRAINT [DF__helpdesk__order___619B8048]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__country__name__5EBF139D]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[country] DROP CONSTRAINT [DF__country__name__5EBF139D]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__country__code__5DCAEF64]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[country] DROP CONSTRAINT [DF__country__code__5DCAEF64]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__contact_p__date___5A4F643B]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[contact_person] DROP CONSTRAINT [DF__contact_p__date___5A4F643B]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_t__creat__5BE2A6F2]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_type] DROP CONSTRAINT [DF__company_t__creat__5BE2A6F2]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__css_f__59FA5E80]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] DROP CONSTRAINT [DF__company_l__css_f__59FA5E80]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__sidem__59063A47]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] DROP CONSTRAINT [DF__company_l__sidem__59063A47]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__sidem__5812160E]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] DROP CONSTRAINT [DF__company_l__sidem__5812160E]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__sidem__571DF1D5]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] DROP CONSTRAINT [DF__company_l__sidem__571DF1D5]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__sidem__5629CD9C]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] DROP CONSTRAINT [DF__company_l__sidem__5629CD9C]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__nav_h__5535A963]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] DROP CONSTRAINT [DF__company_l__nav_h__5535A963]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__nav_f__5441852A]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] DROP CONSTRAINT [DF__company_l__nav_f__5441852A]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__nav_h__534D60F1]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] DROP CONSTRAINT [DF__company_l__nav_h__534D60F1]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__nav_b__52593CB8]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] DROP CONSTRAINT [DF__company_l__nav_b__52593CB8]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__neutr__5165187F]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] DROP CONSTRAINT [DF__company_l__neutr__5165187F]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__neutr__5070F446]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] DROP CONSTRAINT [DF__company_l__neutr__5070F446]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__neutr__4F7CD00D]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] DROP CONSTRAINT [DF__company_l__neutr__4F7CD00D]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__neutr__4E88ABD4]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] DROP CONSTRAINT [DF__company_l__neutr__4E88ABD4]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__neutr__4D94879B]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] DROP CONSTRAINT [DF__company_l__neutr__4D94879B]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__neutr__4CA06362]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] DROP CONSTRAINT [DF__company_l__neutr__4CA06362]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__compl__4BAC3F29]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] DROP CONSTRAINT [DF__company_l__compl__4BAC3F29]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__compl__4AB81AF0]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] DROP CONSTRAINT [DF__company_l__compl__4AB81AF0]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__compl__49C3F6B7]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] DROP CONSTRAINT [DF__company_l__compl__49C3F6B7]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__compl__48CFD27E]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] DROP CONSTRAINT [DF__company_l__compl__48CFD27E]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__compl__47DBAE45]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] DROP CONSTRAINT [DF__company_l__compl__47DBAE45]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__compl__46E78A0C]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] DROP CONSTRAINT [DF__company_l__compl__46E78A0C]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__actio__45F365D3]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] DROP CONSTRAINT [DF__company_l__actio__45F365D3]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__actio__44FF419A]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] DROP CONSTRAINT [DF__company_l__actio__44FF419A]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__actio__440B1D61]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] DROP CONSTRAINT [DF__company_l__actio__440B1D61]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__actio__4316F928]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] DROP CONSTRAINT [DF__company_l__actio__4316F928]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__actio__4222D4EF]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] DROP CONSTRAINT [DF__company_l__actio__4222D4EF]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__actio__412EB0B6]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] DROP CONSTRAINT [DF__company_l__actio__412EB0B6]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company__company__3F466844]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company] DROP CONSTRAINT [DF__company__company__3F466844]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company__card_co__3E52440B]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company] DROP CONSTRAINT [DF__company__card_co__3E52440B]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company__is_dele__3D5E1FD2]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company] DROP CONSTRAINT [DF__company__is_dele__3D5E1FD2]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company__tenant___3C69FB99]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company] DROP CONSTRAINT [DF__company__tenant___3C69FB99]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company__tenant__3B75D760]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company] DROP CONSTRAINT [DF__company__tenant__3B75D760]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company__created__3A81B327]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company] DROP CONSTRAINT [DF__company__created__3A81B327]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company__created__398D8EEE]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company] DROP CONSTRAINT [DF__company__created__398D8EEE]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company__company__38996AB5]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company] DROP CONSTRAINT [DF__company__company__38996AB5]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company__website__37A5467C]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company] DROP CONSTRAINT [DF__company__website__37A5467C]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company__office___35BCFE0A]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company] DROP CONSTRAINT [DF__company__office___35BCFE0A]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company__email_a__34C8D9D1]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company] DROP CONSTRAINT [DF__company__email_a__34C8D9D1]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company__billing__33D4B598]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company] DROP CONSTRAINT [DF__company__billing__33D4B598]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company__contact__32E0915F]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company] DROP CONSTRAINT [DF__company__contact__32E0915F]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company__logo__31EC6D26]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company] DROP CONSTRAINT [DF__company__logo__31EC6D26]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company__trading__30F848ED]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company] DROP CONSTRAINT [DF__company__trading__30F848ED]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_type__modul__2E1BDC42]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_type] DROP CONSTRAINT [DF__card_type__modul__2E1BDC42]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_type__creat__2D27B809]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_type] DROP CONSTRAINT [DF__card_type__creat__2D27B809]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_type__max_e__2C3393D0]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_type] DROP CONSTRAINT [DF__card_type__max_e__2C3393D0]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_type__max_t__2B3F6F97]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_type] DROP CONSTRAINT [DF__card_type__max_t__2B3F6F97]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_type__max_d__2A4B4B5E]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_type] DROP CONSTRAINT [DF__card_type__max_d__2A4B4B5E]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_type__name__29572725]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_type] DROP CONSTRAINT [DF__card_type__name__29572725]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_stat__creat__276EDEB3]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_status] DROP CONSTRAINT [DF__card_stat__creat__276EDEB3]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_gene__print__25869641]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_generated] DROP CONSTRAINT [DF__card_gene__print__25869641]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_gene__tenan__24927208]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_generated] DROP CONSTRAINT [DF__card_gene__tenan__24927208]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_gene__tenan__239E4DCF]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_generated] DROP CONSTRAINT [DF__card_gene__tenan__239E4DCF]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_gene__creat__22AA2996]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_generated] DROP CONSTRAINT [DF__card_gene__creat__22AA2996]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_gene__card___21B6055D]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_generated] DROP CONSTRAINT [DF__card_gene__card___21B6055D]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_gene__visit__20C1E124]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_generated] DROP CONSTRAINT [DF__card_gene__visit__20C1E124]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_gene__card___1FCDBCEB]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_generated] DROP CONSTRAINT [DF__card_gene__card___1FCDBCEB]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_gene__date___1ED998B2]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_generated] DROP CONSTRAINT [DF__card_gene__date___1ED998B2]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_gene__date___1DE57479]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_generated] DROP CONSTRAINT [DF__card_gene__date___1DE57479]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_gene__date___1CF15040]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_generated] DROP CONSTRAINT [DF__card_gene__date___1CF15040]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_gene__date___1BFD2C07]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_generated] DROP CONSTRAINT [DF__card_gene__date___1BFD2C07]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_gene__card___1B0907CE]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_generated] DROP CONSTRAINT [DF__card_gene__card___1B0907CE]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__audit_tra__user___1920BF5C]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[audit_trail] DROP CONSTRAINT [DF__audit_tra__user___1920BF5C]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__audit_tra__field__182C9B23]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[audit_trail] DROP CONSTRAINT [DF__audit_tra__field__182C9B23]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__audit_tra__model__173876EA]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[audit_trail] DROP CONSTRAINT [DF__audit_tra__model__173876EA]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__audit_tra__model__164452B1]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[audit_trail] DROP CONSTRAINT [DF__audit_tra__model__164452B1]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__audit_tra__actio__15502E78]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[audit_trail] DROP CONSTRAINT [DF__audit_tra__actio__15502E78]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__audit_tra__new_v__145C0A3F]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[audit_trail] DROP CONSTRAINT [DF__audit_tra__new_v__145C0A3F]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__audit_tra__old_v__1367E606]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[audit_trail] DROP CONSTRAINT [DF__audit_tra__old_v__1367E606]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__audit_tra__descr__1273C1CD]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[audit_trail] DROP CONSTRAINT [DF__audit_tra__descr__1273C1CD]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__access_to__USER___108B795B]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[access_tokens] DROP CONSTRAINT [DF__access_to__USER___108B795B]
END

GO
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__access_to__EXPIR__0F975522]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[access_tokens] DROP CONSTRAINT [DF__access_to__EXPIR__0F975522]
END

GO
/****** Object:  Index [workstation_card_user]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[workstation_card_type]') AND name = N'workstation_card_user')
DROP INDEX [workstation_card_user] ON [dbo].[workstation_card_type]
GO
/****** Object:  Index [workstation_card_type_card_type]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[workstation_card_type]') AND name = N'workstation_card_type_card_type')
DROP INDEX [workstation_card_type_card_type] ON [dbo].[workstation_card_type]
GO
/****** Object:  Index [created_by]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[workstation]') AND name = N'created_by')
DROP INDEX [created_by] ON [dbo].[workstation]
GO
/****** Object:  Index [created_by]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visitor_type]') AND name = N'created_by')
DROP INDEX [created_by] ON [dbo].[visitor_type]
GO
/****** Object:  Index [visitor_workstation]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visitor]') AND name = N'visitor_workstation')
DROP INDEX [visitor_workstation] ON [dbo].[visitor]
GO
/****** Object:  Index [visitor_type]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visitor]') AND name = N'visitor_type')
DROP INDEX [visitor_type] ON [dbo].[visitor]
GO
/****** Object:  Index [visitor_status]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visitor]') AND name = N'visitor_status')
DROP INDEX [visitor_status] ON [dbo].[visitor]
GO
/****** Object:  Index [visitor_card_status]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visitor]') AND name = N'visitor_card_status')
DROP INDEX [visitor_card_status] ON [dbo].[visitor]
GO
/****** Object:  Index [vehicle]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visitor]') AND name = N'vehicle')
DROP INDEX [vehicle] ON [dbo].[visitor]
GO
/****** Object:  Index [tenant_agent]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visitor]') AND name = N'tenant_agent')
DROP INDEX [tenant_agent] ON [dbo].[visitor]
GO
/****** Object:  Index [tenant]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visitor]') AND name = N'tenant')
DROP INDEX [tenant] ON [dbo].[visitor]
GO
/****** Object:  Index [role]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visitor]') AND name = N'role')
DROP INDEX [role] ON [dbo].[visitor]
GO
/****** Object:  Index [photo]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visitor]') AND name = N'photo')
DROP INDEX [photo] ON [dbo].[visitor]
GO
/****** Object:  Index [identification_country_fk]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visitor]') AND name = N'identification_country_fk')
DROP INDEX [identification_country_fk] ON [dbo].[visitor]
GO
/****** Object:  Index [created_by]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visitor]') AND name = N'created_by')
DROP INDEX [created_by] ON [dbo].[visitor]
GO
/****** Object:  Index [contact_country_fk]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visitor]') AND name = N'contact_country_fk')
DROP INDEX [contact_country_fk] ON [dbo].[visitor]
GO
/****** Object:  Index [company]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visitor]') AND name = N'company')
DROP INDEX [company] ON [dbo].[visitor]
GO
/****** Object:  Index [created_by]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visit_status]') AND name = N'created_by')
DROP INDEX [created_by] ON [dbo].[visit_status]
GO
/****** Object:  Index [tenant_agent]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visit_reason]') AND name = N'tenant_agent')
DROP INDEX [tenant_agent] ON [dbo].[visit_reason]
GO
/****** Object:  Index [tenant]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visit_reason]') AND name = N'tenant')
DROP INDEX [tenant] ON [dbo].[visit_reason]
GO
/****** Object:  Index [created_by]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visit_reason]') AND name = N'created_by')
DROP INDEX [created_by] ON [dbo].[visit_reason]
GO
/****** Object:  Index [workstation]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visit]') AND name = N'workstation')
DROP INDEX [workstation] ON [dbo].[visit]
GO
/****** Object:  Index [visitor_type]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visit]') AND name = N'visitor_type')
DROP INDEX [visitor_type] ON [dbo].[visit]
GO
/****** Object:  Index [visitor_status]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visit]') AND name = N'visitor_status')
DROP INDEX [visitor_status] ON [dbo].[visit]
GO
/****** Object:  Index [visit_status]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visit]') AND name = N'visit_status')
DROP INDEX [visit_status] ON [dbo].[visit]
GO
/****** Object:  Index [tenant_agent]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visit]') AND name = N'tenant_agent')
DROP INDEX [tenant_agent] ON [dbo].[visit]
GO
/****** Object:  Index [tenant]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visit]') AND name = N'tenant')
DROP INDEX [tenant] ON [dbo].[visit]
GO
/****** Object:  Index [reason]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visit]') AND name = N'reason')
DROP INDEX [reason] ON [dbo].[visit]
GO
/****** Object:  Index [patient]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visit]') AND name = N'patient')
DROP INDEX [patient] ON [dbo].[visit]
GO
/****** Object:  Index [host]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visit]') AND name = N'host')
DROP INDEX [host] ON [dbo].[visit]
GO
/****** Object:  Index [created_by]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visit]') AND name = N'created_by')
DROP INDEX [created_by] ON [dbo].[visit]
GO
/****** Object:  Index [card_type]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visit]') AND name = N'card_type')
DROP INDEX [card_type] ON [dbo].[visit]
GO
/****** Object:  Index [card]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visit]') AND name = N'card')
DROP INDEX [card] ON [dbo].[visit]
GO
/****** Object:  Index [workstation]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[user_workstation]') AND name = N'workstation')
DROP INDEX [workstation] ON [dbo].[user_workstation]
GO
/****** Object:  Index [user]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[user_workstation]') AND name = N'user')
DROP INDEX [user] ON [dbo].[user_workstation]
GO
/****** Object:  Index [created_by]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[user_workstation]') AND name = N'created_by')
DROP INDEX [created_by] ON [dbo].[user_workstation]
GO
/****** Object:  Index [created_by]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[user_type]') AND name = N'created_by')
DROP INDEX [created_by] ON [dbo].[user_type]
GO
/****** Object:  Index [created_by]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[user_status]') AND name = N'created_by')
DROP INDEX [created_by] ON [dbo].[user_status]
GO
/****** Object:  Index [user_type]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[user]') AND name = N'user_type')
DROP INDEX [user_type] ON [dbo].[user]
GO
/****** Object:  Index [user_status]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[user]') AND name = N'user_status')
DROP INDEX [user_status] ON [dbo].[user]
GO
/****** Object:  Index [tenant_agent]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[user]') AND name = N'tenant_agent')
DROP INDEX [tenant_agent] ON [dbo].[user]
GO
/****** Object:  Index [tenant]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[user]') AND name = N'tenant')
DROP INDEX [tenant] ON [dbo].[user]
GO
/****** Object:  Index [role]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[user]') AND name = N'role')
DROP INDEX [role] ON [dbo].[user]
GO
/****** Object:  Index [created_by]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[user]') AND name = N'created_by')
DROP INDEX [created_by] ON [dbo].[user]
GO
/****** Object:  Index [company]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[user]') AND name = N'company')
DROP INDEX [company] ON [dbo].[user]
GO
/****** Object:  Index [fk_tenant_contact_tenant1_idx]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[tenant_contact]') AND name = N'fk_tenant_contact_tenant1_idx')
DROP INDEX [fk_tenant_contact_tenant1_idx] ON [dbo].[tenant_contact]
GO
/****** Object:  Index [created_by]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[roles]') AND name = N'created_by')
DROP INDEX [created_by] ON [dbo].[roles]
GO
/****** Object:  Index [user_id]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[password_change_request]') AND name = N'user_id')
DROP INDEX [user_id] ON [dbo].[password_change_request]
GO
/****** Object:  Index [helpdesk_helpdesk_group]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[helpdesk]') AND name = N'helpdesk_helpdesk_group')
DROP INDEX [helpdesk_helpdesk_group] ON [dbo].[helpdesk]
GO
/****** Object:  Index [tenant_agent]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[company]') AND name = N'tenant_agent')
DROP INDEX [tenant_agent] ON [dbo].[company]
GO
/****** Object:  Index [tenant]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[company]') AND name = N'tenant')
DROP INDEX [tenant] ON [dbo].[company]
GO
/****** Object:  Index [logo]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[company]') AND name = N'logo')
DROP INDEX [logo] ON [dbo].[company]
GO
/****** Object:  Index [created_by_visitor]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[company]') AND name = N'created_by_visitor')
DROP INDEX [created_by_visitor] ON [dbo].[company]
GO
/****** Object:  Index [created_by_user]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[company]') AND name = N'created_by_user')
DROP INDEX [created_by_user] ON [dbo].[company]
GO
/****** Object:  Index [company_laf_preferences]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[company]') AND name = N'company_laf_preferences')
DROP INDEX [company_laf_preferences] ON [dbo].[company]
GO
/****** Object:  Index [created_by]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[card_type]') AND name = N'created_by')
DROP INDEX [created_by] ON [dbo].[card_type]
GO
/****** Object:  Index [card_type_module]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[card_type]') AND name = N'card_type_module')
DROP INDEX [card_type_module] ON [dbo].[card_type]
GO
/****** Object:  Index [created_by]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[card_status]') AND name = N'created_by')
DROP INDEX [created_by] ON [dbo].[card_status]
GO
/****** Object:  Index [visitor_id]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[card_generated]') AND name = N'visitor_id')
DROP INDEX [visitor_id] ON [dbo].[card_generated]
GO
/****** Object:  Index [tenant_agent]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[card_generated]') AND name = N'tenant_agent')
DROP INDEX [tenant_agent] ON [dbo].[card_generated]
GO
/****** Object:  Index [tenant]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[card_generated]') AND name = N'tenant')
DROP INDEX [tenant] ON [dbo].[card_generated]
GO
/****** Object:  Index [created_by]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[card_generated]') AND name = N'created_by')
DROP INDEX [created_by] ON [dbo].[card_generated]
GO
/****** Object:  Index [card_status]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[card_generated]') AND name = N'card_status')
DROP INDEX [card_status] ON [dbo].[card_generated]
GO
/****** Object:  Index [card_image_generated_filename]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[card_generated]') AND name = N'card_image_generated_filename')
DROP INDEX [card_image_generated_filename] ON [dbo].[card_generated]
GO
/****** Object:  Table [dbo].[yiisession]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[yiisession]') AND type in (N'U'))
DROP TABLE [dbo].[yiisession]
GO
/****** Object:  Table [dbo].[workstation_card_type]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[workstation_card_type]') AND type in (N'U'))
DROP TABLE [dbo].[workstation_card_type]
GO
/****** Object:  Table [dbo].[workstation]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[workstation]') AND type in (N'U'))
DROP TABLE [dbo].[workstation]
GO
/****** Object:  Table [dbo].[visitor_type_card_type]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[visitor_type_card_type]') AND type in (N'U'))
DROP TABLE [dbo].[visitor_type_card_type]
GO
/****** Object:  Table [dbo].[visitor_type]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[visitor_type]') AND type in (N'U'))
DROP TABLE [dbo].[visitor_type]
GO
/****** Object:  Table [dbo].[visitor_status]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[visitor_status]') AND type in (N'U'))
DROP TABLE [dbo].[visitor_status]
GO
/****** Object:  Table [dbo].[visitor_password_change_request]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[visitor_password_change_request]') AND type in (N'U'))
DROP TABLE [dbo].[visitor_password_change_request]
GO
/****** Object:  Table [dbo].[visitor_card_status]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[visitor_card_status]') AND type in (N'U'))
DROP TABLE [dbo].[visitor_card_status]
GO
/****** Object:  Table [dbo].[visitor]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[visitor]') AND type in (N'U'))
DROP TABLE [dbo].[visitor]
GO
/****** Object:  Table [dbo].[visit_status]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[visit_status]') AND type in (N'U'))
DROP TABLE [dbo].[visit_status]
GO
/****** Object:  Table [dbo].[visit_reason]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[visit_reason]') AND type in (N'U'))
DROP TABLE [dbo].[visit_reason]
GO
/****** Object:  Table [dbo].[visit]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[visit]') AND type in (N'U'))
DROP TABLE [dbo].[visit]
GO
/****** Object:  Table [dbo].[vehicle]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[vehicle]') AND type in (N'U'))
DROP TABLE [dbo].[vehicle]
GO
/****** Object:  Table [dbo].[user_workstation]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[user_workstation]') AND type in (N'U'))
DROP TABLE [dbo].[user_workstation]
GO
/****** Object:  Table [dbo].[user_type]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[user_type]') AND type in (N'U'))
DROP TABLE [dbo].[user_type]
GO
/****** Object:  Table [dbo].[user_status]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[user_status]') AND type in (N'U'))
DROP TABLE [dbo].[user_status]
GO
/****** Object:  Table [dbo].[user_notification]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[user_notification]') AND type in (N'U'))
DROP TABLE [dbo].[user_notification]
GO
/****** Object:  Table [dbo].[user]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[user]') AND type in (N'U'))
DROP TABLE [dbo].[user]
GO
/****** Object:  Table [dbo].[timezone]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[timezone]') AND type in (N'U'))
DROP TABLE [dbo].[timezone]
GO
/****** Object:  Table [dbo].[tenant_contact]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[tenant_contact]') AND type in (N'U'))
DROP TABLE [dbo].[tenant_contact]
GO
/****** Object:  Table [dbo].[tenant]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[tenant]') AND type in (N'U'))
DROP TABLE [dbo].[tenant]
GO
/****** Object:  Table [dbo].[tbl_migration]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[tbl_migration]') AND type in (N'U'))
DROP TABLE [dbo].[tbl_migration]
GO
/****** Object:  Table [dbo].[system]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[system]') AND type in (N'U'))
DROP TABLE [dbo].[system]
GO
/****** Object:  Table [dbo].[roles]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[roles]') AND type in (N'U'))
DROP TABLE [dbo].[roles]
GO
/****** Object:  Table [dbo].[reset_history]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[reset_history]') AND type in (N'U'))
DROP TABLE [dbo].[reset_history]
GO
/****** Object:  Table [dbo].[reasons]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[reasons]') AND type in (N'U'))
DROP TABLE [dbo].[reasons]
GO
/****** Object:  Table [dbo].[photo]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[photo]') AND type in (N'U'))
DROP TABLE [dbo].[photo]
GO
/****** Object:  Table [dbo].[patient]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[patient]') AND type in (N'U'))
DROP TABLE [dbo].[patient]
GO
/****** Object:  Table [dbo].[password_change_request]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[password_change_request]') AND type in (N'U'))
DROP TABLE [dbo].[password_change_request]
GO
/****** Object:  Table [dbo].[notification]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[notification]') AND type in (N'U'))
DROP TABLE [dbo].[notification]
GO
/****** Object:  Table [dbo].[module]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[module]') AND type in (N'U'))
DROP TABLE [dbo].[module]
GO
/****** Object:  Table [dbo].[license_details]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[license_details]') AND type in (N'U'))
DROP TABLE [dbo].[license_details]
GO
/****** Object:  Table [dbo].[import_visitor]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[import_visitor]') AND type in (N'U'))
DROP TABLE [dbo].[import_visitor]
GO
/****** Object:  Table [dbo].[import_hosts]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[import_hosts]') AND type in (N'U'))
DROP TABLE [dbo].[import_hosts]
GO
/****** Object:  Table [dbo].[helpdesk_group]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[helpdesk_group]') AND type in (N'U'))
DROP TABLE [dbo].[helpdesk_group]
GO
/****** Object:  Table [dbo].[helpdesk]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[helpdesk]') AND type in (N'U'))
DROP TABLE [dbo].[helpdesk]
GO
/****** Object:  Table [dbo].[folders]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[folders]') AND type in (N'U'))
DROP TABLE [dbo].[folders]
GO
/****** Object:  Table [dbo].[files]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[files]') AND type in (N'U'))
DROP TABLE [dbo].[files]
GO
/****** Object:  Table [dbo].[cvms_kiosk]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[cvms_kiosk]') AND type in (N'U'))
DROP TABLE [dbo].[cvms_kiosk]
GO
/****** Object:  Table [dbo].[country]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[country]') AND type in (N'U'))
DROP TABLE [dbo].[country]
GO
/****** Object:  Table [dbo].[contact_person]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[contact_person]') AND type in (N'U'))
DROP TABLE [dbo].[contact_person]
GO
/****** Object:  Table [dbo].[company_type]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[company_type]') AND type in (N'U'))
DROP TABLE [dbo].[company_type]
GO
/****** Object:  Table [dbo].[company_laf_preferences]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[company_laf_preferences]') AND type in (N'U'))
DROP TABLE [dbo].[company_laf_preferences]
GO
/****** Object:  Table [dbo].[company]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[company]') AND type in (N'U'))
DROP TABLE [dbo].[company]
GO
/****** Object:  Table [dbo].[cardstatus_convert]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[cardstatus_convert]') AND type in (N'U'))
DROP TABLE [dbo].[cardstatus_convert]
GO
/****** Object:  Table [dbo].[card_type]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[card_type]') AND type in (N'U'))
DROP TABLE [dbo].[card_type]
GO
/****** Object:  Table [dbo].[card_status]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[card_status]') AND type in (N'U'))
DROP TABLE [dbo].[card_status]
GO
/****** Object:  Table [dbo].[card_generated]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[card_generated]') AND type in (N'U'))
DROP TABLE [dbo].[card_generated]
GO
/****** Object:  Table [dbo].[audit_trail]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[audit_trail]') AND type in (N'U'))
DROP TABLE [dbo].[audit_trail]
GO
/****** Object:  Table [dbo].[access_tokens]    Script Date: 8/8/2015 5:31:01 AM ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[access_tokens]') AND type in (N'U'))
DROP TABLE [dbo].[access_tokens]
GO
/****** Object:  Table [dbo].[access_tokens]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[access_tokens]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[access_tokens](
	[ID] [int] IDENTITY(11,1) NOT NULL,
	[USER_ID] [int] NOT NULL,
	[ACCESS_TOKEN] [nvarchar](255) NOT NULL,
	[EXPIRY] [datetime2](0) NULL,
	[CLIENT_ID] [int] NOT NULL,
	[CREATED] [datetime2](0) NOT NULL,
	[MODIFIED] [datetime2](0) NOT NULL,
	[USER_TYPE] [int] NULL,
 CONSTRAINT [PK_access_tokens_ID] PRIMARY KEY CLUSTERED
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
/****** Object:  Table [dbo].[audit_trail]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[audit_trail]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[audit_trail](
	[id] [bigint] IDENTITY(1145588,1) NOT NULL,
	[description] [nvarchar](255) NULL,
	[old_value] [nvarchar](255) NULL,
	[new_value] [nvarchar](255) NULL,
	[action] [nvarchar](20) NULL,
	[model] [nvarchar](45) NULL,
	[model_id] [bigint] NULL,
	[field] [nvarchar](45) NULL,
	[creation_date] [datetime2](0) NOT NULL,
	[user_id] [nvarchar](45) NULL,
 CONSTRAINT [PK_audit_trail_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
/****** Object:  Table [dbo].[card_generated]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[card_generated]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[card_generated](
	[id] [bigint] IDENTITY(2829,1) NOT NULL,
	[card_number] [varchar](10) NULL,
	[date_printed] [date] NULL,
	[date_expiration] [date] NULL,
	[date_cancelled] [date] NULL,
	[date_returned] [date] NULL,
	[card_image_generated_filename] [bigint] NULL,
	[visitor_id] [bigint] NULL,
	[card_status] [bigint] NULL,
	[created_by] [bigint] NULL,
	[tenant] [bigint] NULL,
	[tenant_agent] [bigint] NULL,
	[print_count] [bigint] NULL,
 CONSTRAINT [PK_card_generated_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[card_status]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[card_status]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[card_status](
	[id] [bigint] IDENTITY(5,1) NOT NULL,
	[name] [varchar](50) NOT NULL,
	[created_by] [bigint] NULL,
 CONSTRAINT [PK_card_status_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[card_type]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[card_type]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[card_type](
	[id] [bigint] IDENTITY(10,1) NOT NULL,
	[name] [varchar](50) NULL,
	[max_day_validity] [int] NULL,
	[max_time_validity] [varchar](50) NULL,
	[max_entry_count_validity] [int] NULL,
	[card_icon_type] [varchar](max) NULL,
	[card_background_image_path] [varchar](max) NULL,
	[created_by] [bigint] NULL,
	[module] [bigint] NULL,
	[back_text] [varchar](max) NULL,
 CONSTRAINT [PK_card_type_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[cardstatus_convert]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[cardstatus_convert]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[cardstatus_convert](
	[id] [int] IDENTITY(3,1) NOT NULL,
	[visitor_id] [bigint] NOT NULL,
	[convert_time] [date] NOT NULL,
 CONSTRAINT [PK_cardstatus_convert_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
/****** Object:  Table [dbo].[company]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[company]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[company](
	[id] [bigint] IDENTITY(126,1) NOT NULL,
	[code] [nvarchar](3) NOT NULL,
	[name] [nvarchar](150) NOT NULL,
	[trading_name] [nvarchar](150) NULL,
	[logo] [bigint] NULL,
	[contact] [nvarchar](100) NULL,
	[billing_address] [nvarchar](150) NULL,
	[email_address] [nvarchar](50) NULL,
	[office_number] [varchar](20) NULL,
	[mobile_number] [varchar](50) NULL,
	[website] [nvarchar](50) NULL,
	[company_laf_preferences] [bigint] NULL,
	[created_by_user] [bigint] NULL,
	[created_by_visitor] [bigint] NULL,
	[tenant] [bigint] NULL,
	[tenant_agent] [bigint] NULL,
	[is_deleted] [int] NULL,
	[card_count] [bigint] NULL,
	[company_type] [bigint] NULL,
 CONSTRAINT [PK_company_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[company_laf_preferences]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[company_laf_preferences]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[company_laf_preferences](
	[id] [bigint] IDENTITY(9,1) NOT NULL,
	[action_forward_bg_color] [varchar](7) NULL,
	[action_forward_bg_color2] [varchar](7) NULL,
	[action_forward_font_color] [varchar](7) NULL,
	[action_forward_hover_color] [varchar](7) NULL,
	[action_forward_hover_color2] [varchar](7) NULL,
	[action_forward_hover_font_color] [varchar](7) NULL,
	[complete_bg_color] [varchar](7) NULL,
	[complete_bg_color2] [varchar](7) NULL,
	[complete_hover_color] [varchar](7) NULL,
	[complete_hover_color2] [varchar](7) NULL,
	[complete_font_color] [varchar](7) NULL,
	[complete_hover_font_color] [varchar](7) NULL,
	[neutral_bg_color] [varchar](7) NULL,
	[neutral_bg_color2] [varchar](7) NULL,
	[neutral_hover_color] [varchar](7) NULL,
	[neutral_hover_color2] [varchar](7) NULL,
	[neutral_font_color] [varchar](7) NULL,
	[neutral_hover_font_color] [varchar](7) NULL,
	[nav_bg_color] [varchar](7) NULL,
	[nav_hover_color] [varchar](7) NULL,
	[nav_font_color] [varchar](7) NULL,
	[nav_hover_font_color] [varchar](7) NULL,
	[sidemenu_bg_color] [varchar](7) NULL,
	[sidemenu_hover_color] [varchar](7) NULL,
	[sidemenu_font_color] [varchar](7) NULL,
	[sidemenu_hover_font_color] [varchar](7) NULL,
	[css_file_path] [varchar](50) NULL,
 CONSTRAINT [PK_company_laf_preferences_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[company_type]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[company_type]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[company_type](
	[id] [int] IDENTITY(4,1) NOT NULL,
	[name] [nvarchar](50) NOT NULL,
	[created_by] [bigint] NULL,
 CONSTRAINT [PK_company_type_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
/****** Object:  Table [dbo].[contact_person]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[contact_person]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[contact_person](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[contact_person_name] [varchar](50) NOT NULL,
	[contact_person_email] [varchar](50) NOT NULL,
	[contact_person_message] [varchar](100) NULL,
	[date_created] [datetime] NULL,
	[created_by] [bigint] NULL,
	[tenant] [bigint] NULL,
 CONSTRAINT [PK__contact___3213E83F1F9DB570] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[country]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[country]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[country](
	[id] [int] IDENTITY(751,1) NOT NULL,
	[code] [nchar](2) NOT NULL,
	[name] [nvarchar](45) NOT NULL,
 CONSTRAINT [PK_country_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
/****** Object:  Table [dbo].[cvms_kiosk]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[cvms_kiosk]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[cvms_kiosk](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[workstation] [int] NOT NULL,
	[module] [nvarchar](255) NOT NULL,
	[username] [nvarchar](255) NOT NULL,
	[password] [nvarchar](255) NOT NULL,
	[tenant] [int] NOT NULL,
	[tenant_agent] [int] NOT NULL,
	[created_by] [int] NOT NULL,
	[is_deleted] [smallint] NOT NULL,
	[enabled] [smallint] NOT NULL,
 CONSTRAINT [PK_cvms_kiosk_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
/****** Object:  Table [dbo].[files]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[files]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[files](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[folder_id] [int] NULL,
	[user_id] [bigint] NULL,
	[file] [varchar](255) NOT NULL,
	[uploaded] [datetime] NULL,
	[size] [float] NULL,
	[ext] [varchar](20) NULL,
	[uploader] [bigint] NULL,
	[name] [varchar](255) NULL,
 CONSTRAINT [PK__files__3213E83FCCA79A3F] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[folders]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[folders]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[folders](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[parent_id] [int] NULL,
	[user_id] [bigint] NULL,
	[default] [tinyint] NULL,
	[name] [varchar](255) NOT NULL,
	[date_created] [datetime] NULL,
 CONSTRAINT [PK__folders__3213E83F9C4880CE] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[helpdesk]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[helpdesk]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[helpdesk](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[question] [nvarchar](255) NOT NULL,
	[answer] [nvarchar](max) NOT NULL,
	[helpdesk_group_id] [bigint] NOT NULL,
	[order_by] [int] NULL,
	[created_by] [bigint] NULL,
	[is_deleted] [int] NULL,
 CONSTRAINT [PK_helpdesk_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
END
GO
/****** Object:  Table [dbo].[helpdesk_group]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[helpdesk_group]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[helpdesk_group](
	[id] [bigint] IDENTITY(2,1) NOT NULL,
	[name] [nvarchar](255) NOT NULL,
	[order_by] [int] NULL,
	[created_by] [bigint] NULL,
	[is_deleted] [bigint] NULL,
 CONSTRAINT [PK_helpdesk_group_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
/****** Object:  Table [dbo].[import_hosts]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[import_hosts]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[import_hosts](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[first_name] [nvarchar](50) NOT NULL,
	[last_name] [nvarchar](50) NOT NULL,
	[email] [nvarchar](255) NOT NULL,
	[department] [nvarchar](50) NOT NULL,
	[staff_id] [nvarchar](50) NOT NULL,
	[contact_number] [nvarchar](50) NOT NULL,
	[company] [nvarchar](50) NOT NULL,
	[imported_by] [int] NULL,
	[date_imported] [date] NULL,
	[password] [nvarchar](50) NOT NULL,
	[role] [int] NULL,
	[position] [nvarchar](50) NULL,
	[date_of_birth] [date] NULL,
 CONSTRAINT [PK_import_hosts_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
/****** Object:  Table [dbo].[import_visitor]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[import_visitor]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[import_visitor](
	[id] [int] IDENTITY(93,1) NOT NULL,
	[card_code] [nvarchar](255) NULL,
	[first_name] [nvarchar](255) NOT NULL,
	[last_name] [nvarchar](255) NOT NULL,
	[email] [nvarchar](255) NOT NULL,
	[company] [nvarchar](255) NOT NULL,
	[check_in_date] [date] NULL,
	[check_out_date] [date] NULL,
	[imported_by] [int] NULL,
	[import_date] [date] NULL,
	[check_in_time] [time](7) NULL,
	[check_out_time] [time](7) NULL,
	[position] [nvarchar](30) NULL,
	[date_printed] [date] NULL,
	[date_expiration] [date] NULL,
	[vehicle] [nvarchar](50) NULL,
	[contact_number] [nvarchar](40) NULL,
 CONSTRAINT [PK_import_visitor_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
/****** Object:  Table [dbo].[license_details]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[license_details]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[license_details](
	[id] [bigint] IDENTITY(2,1) NOT NULL,
	[description] [varchar](max) NULL,
 CONSTRAINT [PK_license_details_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[module]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[module]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[module](
	[id] [bigint] IDENTITY(3,1) NOT NULL,
	[name] [nvarchar](255) NOT NULL,
	[about] [nvarchar](255) NULL,
	[created_by] [datetime2](0) NULL,
 CONSTRAINT [PK_module_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
/****** Object:  Table [dbo].[notification]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[notification]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[notification](
	[id] [int] IDENTITY(15,1) NOT NULL,
	[subject] [nvarchar](250) NOT NULL,
	[message] [nvarchar](max) NOT NULL,
	[created_by] [int] NULL,
	[date_created] [date] NULL,
	[role_id] [int] NULL,
	[notification_type] [nvarchar](100) NULL,
 CONSTRAINT [PK_notification_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
END
GO
/****** Object:  Table [dbo].[password_change_request]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[password_change_request]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[password_change_request](
	[id] [int] IDENTITY(32,1) NOT NULL,
	[user_id] [bigint] NOT NULL,
	[hash] [nvarchar](255) NOT NULL,
	[created_at] [datetime2](0) NOT NULL,
	[is_used] [nvarchar](3) NOT NULL,
 CONSTRAINT [PK_password_change_request_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [password_change_request$hash] UNIQUE NONCLUSTERED
(
	[hash] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
/****** Object:  Table [dbo].[patient]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[patient]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[patient](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[name] [varchar](100) NULL,
 CONSTRAINT [PK_patient_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[photo]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[photo]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[photo](
	[id] [bigint] IDENTITY(913,1) NOT NULL,
	[filename] [varchar](max) NULL,
	[unique_filename] [varchar](max) NULL,
	[relative_path] [varchar](max) NULL,
	[db_image] [varbinary](max) NULL,
 CONSTRAINT [PK_photo_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[reasons]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[reasons]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[reasons](
	[id] [int] IDENTITY(2,1) NOT NULL,
	[reason_name] [nvarchar](50) NOT NULL,
	[date_created] [datetime] NOT NULL,
	[created_by] [bigint] NULL,
	[tenant] [bigint] NULL,
 CONSTRAINT [PK_reasons_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
/****** Object:  Table [dbo].[reset_history]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[reset_history]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[reset_history](
	[id] [int] IDENTITY(12,1) NOT NULL,
	[visitor_id] [bigint] NOT NULL,
	[reset_time] [datetime2](0) NOT NULL,
	[reason] [nvarchar](250) NOT NULL,
	[lodgement_date] [date] NULL,
 CONSTRAINT [PK_reset_history_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
/****** Object:  Table [dbo].[roles]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[roles]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[roles](
	[id] [bigint] IDENTITY(15,1) NOT NULL,
	[name] [varchar](50) NOT NULL,
	[created_by] [bigint] NULL,
 CONSTRAINT [PK_roles_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[system]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[system]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[system](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[key_name] [varchar](25) NULL,
	[key_value] [text] NULL,
 CONSTRAINT [PK__system__3213E83F9346DA5B] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[tbl_migration]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[tbl_migration]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[tbl_migration](
	[version] [nvarchar](255) NOT NULL,
	[apply_time] [int] NULL,
 CONSTRAINT [PK_tbl_migration_version] PRIMARY KEY CLUSTERED
(
	[version] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
/****** Object:  Table [dbo].[tenant]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[tenant]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[tenant](
	[id] [bigint] NOT NULL,
	[created_by] [bigint] NOT NULL,
	[is_deleted] [smallint] NULL,
 CONSTRAINT [PK_tenant_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
/****** Object:  Table [dbo].[tenant_contact]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[tenant_contact]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[tenant_contact](
	[id] [bigint] IDENTITY(13,1) NOT NULL,
	[tenant] [bigint] NOT NULL,
	[user] [bigint] NOT NULL,
 CONSTRAINT [PK_tenant_contact_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
/****** Object:  Table [dbo].[timezone]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[timezone]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[timezone](
	[id] [int] IDENTITY(141,1) NOT NULL,
	[timezone_name] [nvarchar](250) NOT NULL,
	[timezone_value] [nvarchar](250) NOT NULL,
 CONSTRAINT [PK_timezone_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
/****** Object:  Table [dbo].[user]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[user]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[user](
	[id] [bigint] IDENTITY(1445,1) NOT NULL,
	[first_name] [varchar](50) NOT NULL,
	[last_name] [varchar](50) NOT NULL,
	[email] [varchar](50) NOT NULL,
	[contact_number] [varchar](20) NOT NULL,
	[date_of_birth] [date] NULL,
	[company] [bigint] NULL,
	[department] [varchar](50) NULL,
	[position] [varchar](50) NULL,
	[staff_id] [varchar](50) NULL,
	[notes] [varchar](max) NULL,
	[password] [varchar](150) NULL,
	[role] [bigint] NOT NULL,
	[user_type] [bigint] NOT NULL,
	[user_status] [bigint] NULL,
	[created_by] [bigint] NULL,
	[is_deleted] [smallint] NOT NULL,
	[tenant] [bigint] NULL,
	[tenant_agent] [bigint] NULL,
	[photo] [bigint] NOT NULL,
	[asic_no] [int] NULL,
	[asic_expiry] [date] NULL,
	[is_required_induction] [smallint] NULL,
	[is_completed_induction] [smallint] NULL,
	[induction_expiry] [date] NULL,
	[timezone_id] [bigint] NOT NULL,
	[allowed_module] [int] NULL,
 CONSTRAINT [PK_user_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[user_notification]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[user_notification]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[user_notification](
	[id] [int] IDENTITY(14662,1) NOT NULL,
	[user_id] [int] NULL,
	[notification_id] [int] NULL,
	[has_read] [int] NULL,
	[date_read] [date] NULL,
 CONSTRAINT [PK_user_notification_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
/****** Object:  Table [dbo].[user_status]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[user_status]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[user_status](
	[id] [bigint] IDENTITY(3,1) NOT NULL,
	[name] [varchar](50) NOT NULL,
	[created_by] [bigint] NULL,
 CONSTRAINT [PK_user_status_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[user_type]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[user_type]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[user_type](
	[id] [bigint] IDENTITY(3,1) NOT NULL,
	[name] [varchar](50) NOT NULL,
	[created_by] [bigint] NULL,
 CONSTRAINT [PK_user_type_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[user_workstation]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[user_workstation]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[user_workstation](
	[id] [bigint] IDENTITY(65,1) NOT NULL,
	[user] [bigint] NOT NULL,
	[workstation] [bigint] NOT NULL,
	[created_by] [bigint] NULL,
	[is_primary] [smallint] NOT NULL,
 CONSTRAINT [PK_user_workstation_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
/****** Object:  Table [dbo].[vehicle]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[vehicle]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[vehicle](
	[id] [bigint] IDENTITY(60,1) NOT NULL,
	[vehicle_registration_plate_number] [varchar](6) NOT NULL,
 CONSTRAINT [PK_vehicle_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[visit]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[visit]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[visit](
	[id] [bigint] IDENTITY(24598,1) NOT NULL,
	[visitor] [bigint] NULL,
	[card_type] [bigint] NULL,
	[card] [bigint] NULL,
	[visitor_type] [bigint] NULL,
	[reason] [bigint] NULL,
	[visitor_status] [bigint] NULL,
	[host] [bigint] NULL,
	[patient] [bigint] NULL,
	[created_by] [bigint] NULL,
	[date_in] [date] NULL,
	[time_in] [time](7) NULL,
	[date_out] [date] NULL,
	[time_out] [time](7) NULL,
	[date_check_in] [date] NULL,
	[time_check_in] [time](7) NULL,
	[date_check_out] [date] NULL,
	[time_check_out] [time](7) NULL,
	[visit_status] [bigint] NULL,
	[workstation] [bigint] NULL,
	[tenant] [bigint] NULL,
	[tenant_agent] [bigint] NULL,
	[is_deleted] [smallint] NULL,
	[finish_date] [date] NULL,
	[finish_time] [time](7) NULL,
	[card_returned_date] [date] NULL,
	[reset_id] [int] NULL,
	[negate_reason] [varchar](250) NULL,
	[card_option] [varchar](25) NULL,
	[card_lost_declaration_file] [varchar](max) NULL,
	[police_report_number] [varchar](50) NULL,
	[asic_escort] [bigint] NULL,
 CONSTRAINT [PK_visit_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[visit_reason]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[visit_reason]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[visit_reason](
	[id] [bigint] IDENTITY(6,1) NOT NULL,
	[reason] [varchar](max) NULL,
	[created_by] [bigint] NULL,
	[tenant] [bigint] NULL,
	[tenant_agent] [bigint] NULL,
	[is_deleted] [smallint] NOT NULL,
	[module] [varchar](4) NULL,
 CONSTRAINT [PK_visit_reason_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[visit_status]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[visit_status]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[visit_status](
	[id] [bigint] IDENTITY(7,1) NOT NULL,
	[name] [varchar](25) NULL,
	[created_by] [bigint] NULL,
 CONSTRAINT [PK_visit_status_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[visitor]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[visitor]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[visitor](
	[id] [bigint] IDENTITY(2604,1) NOT NULL,
	[first_name] [varchar](50) NOT NULL,
	[middle_name] [varchar](50) NULL,
	[last_name] [varchar](50) NOT NULL,
	[email] [varchar](50) NOT NULL,
	[contact_number] [varchar](20) NOT NULL,
	[date_of_birth] [date] NULL,
	[company] [bigint] NULL,
	[department] [varchar](50) NULL,
	[position] [varchar](50) NULL,
	[staff_id] [varchar](50) NULL,
	[notes] [varchar](max) NULL,
	[password] [varchar](150) NULL,
	[role] [bigint] NOT NULL,
	[visitor_type] [bigint] NULL,
	[visitor_status] [bigint] NULL,
	[vehicle] [bigint] NULL,
	[photo] [bigint] NULL,
	[created_by] [bigint] NULL,
	[is_deleted] [smallint] NOT NULL,
	[tenant] [bigint] NULL,
	[tenant_agent] [bigint] NULL,
	[visitor_card_status] [bigint] NULL,
	[visitor_workstation] [bigint] NULL,
	[profile_type] [varchar](9) NOT NULL,
	[identification_type] [varchar](15) NULL,
	[identification_country_issued] [int] NULL,
	[identification_document_no] [varchar](50) NULL,
	[identification_document_expiry] [date] NULL,
	[identification_alternate_document_name1] [varchar](50) NULL,
	[identification_alternate_document_no1] [varchar](50) NULL,
	[identification_alternate_document_expiry1] [date] NULL,
	[identification_alternate_document_name2] [varchar](50) NULL,
	[identification_alternate_document_no2] [varchar](50) NULL,
	[identification_alternate_document_expiry2] [date] NULL,
	[contact_unit] [varchar](50) NULL,
	[contact_street_no] [varchar](50) NULL,
	[contact_street_name] [varchar](50) NULL,
	[contact_street_type] [varchar](8) NULL,
	[contact_suburb] [varchar](50) NULL,
	[contact_state] [varchar](50) NULL,
	[contact_country] [int] NULL,
	[asic_no] [varchar](50) NULL,
	[asic_expiry] [date] NULL,
	[verifiable_signature] [int] NULL,
	[contact_postcode] [varchar](10) NULL,
	[date_created] [datetime] NOT NULL,
	[escort_flag] [bit] NULL,
	[is_under_18] [tinyint] NULL,
	[under_18_detail] [varchar](255) NULL,
	[key_string] [text] NULL,
 CONSTRAINT [PK_visitor_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[visitor_card_status]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[visitor_card_status]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[visitor_card_status](
	[id] [bigint] IDENTITY(8,1) NOT NULL,
	[name] [nvarchar](50) NOT NULL,
	[profile_type] [nvarchar](9) NOT NULL,
 CONSTRAINT [PK_visitor_card_status_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
/****** Object:  Table [dbo].[visitor_password_change_request]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[visitor_password_change_request]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[visitor_password_change_request](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[visitor_id] [bigint] NOT NULL,
	[hash] [varchar](255) NOT NULL,
	[created_at] [datetime] NOT NULL,
	[is_used] [bit] NULL,
 CONSTRAINT [PK__visitor___3213E83F46999C6B] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[visitor_status]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[visitor_status]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[visitor_status](
	[id] [bigint] IDENTITY(4,1) NOT NULL,
	[name] [varchar](20) NULL,
 CONSTRAINT [PK_visitor_status_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[visitor_type]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[visitor_type]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[visitor_type](
	[id] [bigint] IDENTITY(18,1) NOT NULL,
	[name] [varchar](25) NULL,
	[created_by] [bigint] NULL,
	[tenant] [bigint] NULL,
	[tenant_agent] [bigint] NULL,
	[is_deleted] [int] NULL,
	[is_default_value] [int] NULL,
	[module] [varchar](10) NULL,
 CONSTRAINT [PK_visitor_type_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[visitor_type_card_type]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[visitor_type_card_type]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[visitor_type_card_type](
	[visitor_type] [bigint] NOT NULL,
	[card_type] [bigint] NOT NULL,
	[tenant] [bigint] NOT NULL,
	[tenant_agent] [bigint] NULL,
	[is_deleted] [bit] NULL,
 CONSTRAINT [vtct_pk] PRIMARY KEY CLUSTERED
(
	[visitor_type] ASC,
	[card_type] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
/****** Object:  Table [dbo].[workstation]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[workstation]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[workstation](
	[id] [bigint] IDENTITY(68,1) NOT NULL,
	[name] [varchar](50) NOT NULL,
	[location] [varchar](100) NULL,
	[contact_name] [varchar](50) NULL,
	[contact_number] [int] NULL,
	[contact_email_address] [varchar](50) NULL,
	[number_of_operators] [int] NULL,
	[assign_kiosk] [smallint] NULL,
	[password] [varchar](50) NULL,
	[created_by] [bigint] NULL,
	[tenant] [bigint] NULL,
	[tenant_agent] [bigint] NULL,
	[is_deleted] [smallint] NULL,
	[timezone_id] [bigint] NOT NULL,
 CONSTRAINT [PK_workstation_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[workstation_card_type]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[workstation_card_type]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[workstation_card_type](
	[workstation] [bigint] NOT NULL,
	[card_type] [bigint] NOT NULL,
	[user] [bigint] NOT NULL,
 CONSTRAINT [PK_workstation_card_type_workstation] PRIMARY KEY CLUSTERED
(
	[workstation] ASC,
	[card_type] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO
/****** Object:  Table [dbo].[yiisession]    Script Date: 8/8/2015 5:31:01 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[yiisession]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[yiisession](
	[id] [nvarchar](255) NULL,
	[expire] [int] NULL,
	[data] [varbinary](max) NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Index [card_image_generated_filename]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[card_generated]') AND name = N'card_image_generated_filename')
CREATE NONCLUSTERED INDEX [card_image_generated_filename] ON [dbo].[card_generated]
(
	[card_image_generated_filename] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [card_status]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[card_generated]') AND name = N'card_status')
CREATE NONCLUSTERED INDEX [card_status] ON [dbo].[card_generated]
(
	[card_status] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [created_by]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[card_generated]') AND name = N'created_by')
CREATE NONCLUSTERED INDEX [created_by] ON [dbo].[card_generated]
(
	[created_by] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [tenant]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[card_generated]') AND name = N'tenant')
CREATE NONCLUSTERED INDEX [tenant] ON [dbo].[card_generated]
(
	[tenant] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [tenant_agent]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[card_generated]') AND name = N'tenant_agent')
CREATE NONCLUSTERED INDEX [tenant_agent] ON [dbo].[card_generated]
(
	[tenant_agent] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [visitor_id]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[card_generated]') AND name = N'visitor_id')
CREATE NONCLUSTERED INDEX [visitor_id] ON [dbo].[card_generated]
(
	[visitor_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [created_by]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[card_status]') AND name = N'created_by')
CREATE NONCLUSTERED INDEX [created_by] ON [dbo].[card_status]
(
	[created_by] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [card_type_module]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[card_type]') AND name = N'card_type_module')
CREATE NONCLUSTERED INDEX [card_type_module] ON [dbo].[card_type]
(
	[module] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [created_by]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[card_type]') AND name = N'created_by')
CREATE NONCLUSTERED INDEX [created_by] ON [dbo].[card_type]
(
	[created_by] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [company_laf_preferences]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[company]') AND name = N'company_laf_preferences')
CREATE NONCLUSTERED INDEX [company_laf_preferences] ON [dbo].[company]
(
	[company_laf_preferences] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [created_by_user]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[company]') AND name = N'created_by_user')
CREATE NONCLUSTERED INDEX [created_by_user] ON [dbo].[company]
(
	[created_by_user] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [created_by_visitor]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[company]') AND name = N'created_by_visitor')
CREATE NONCLUSTERED INDEX [created_by_visitor] ON [dbo].[company]
(
	[created_by_visitor] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [logo]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[company]') AND name = N'logo')
CREATE NONCLUSTERED INDEX [logo] ON [dbo].[company]
(
	[logo] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [tenant]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[company]') AND name = N'tenant')
CREATE NONCLUSTERED INDEX [tenant] ON [dbo].[company]
(
	[tenant] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [tenant_agent]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[company]') AND name = N'tenant_agent')
CREATE NONCLUSTERED INDEX [tenant_agent] ON [dbo].[company]
(
	[tenant_agent] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [helpdesk_helpdesk_group]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[helpdesk]') AND name = N'helpdesk_helpdesk_group')
CREATE NONCLUSTERED INDEX [helpdesk_helpdesk_group] ON [dbo].[helpdesk]
(
	[helpdesk_group_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [user_id]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[password_change_request]') AND name = N'user_id')
CREATE NONCLUSTERED INDEX [user_id] ON [dbo].[password_change_request]
(
	[user_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [created_by]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[roles]') AND name = N'created_by')
CREATE NONCLUSTERED INDEX [created_by] ON [dbo].[roles]
(
	[created_by] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [fk_tenant_contact_tenant1_idx]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[tenant_contact]') AND name = N'fk_tenant_contact_tenant1_idx')
CREATE NONCLUSTERED INDEX [fk_tenant_contact_tenant1_idx] ON [dbo].[tenant_contact]
(
	[tenant] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [company]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[user]') AND name = N'company')
CREATE NONCLUSTERED INDEX [company] ON [dbo].[user]
(
	[company] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [created_by]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[user]') AND name = N'created_by')
CREATE NONCLUSTERED INDEX [created_by] ON [dbo].[user]
(
	[created_by] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [role]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[user]') AND name = N'role')
CREATE NONCLUSTERED INDEX [role] ON [dbo].[user]
(
	[role] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [tenant]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[user]') AND name = N'tenant')
CREATE NONCLUSTERED INDEX [tenant] ON [dbo].[user]
(
	[tenant] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [tenant_agent]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[user]') AND name = N'tenant_agent')
CREATE NONCLUSTERED INDEX [tenant_agent] ON [dbo].[user]
(
	[tenant_agent] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [user_status]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[user]') AND name = N'user_status')
CREATE NONCLUSTERED INDEX [user_status] ON [dbo].[user]
(
	[user_status] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [user_type]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[user]') AND name = N'user_type')
CREATE NONCLUSTERED INDEX [user_type] ON [dbo].[user]
(
	[user_type] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [created_by]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[user_status]') AND name = N'created_by')
CREATE NONCLUSTERED INDEX [created_by] ON [dbo].[user_status]
(
	[created_by] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [created_by]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[user_type]') AND name = N'created_by')
CREATE NONCLUSTERED INDEX [created_by] ON [dbo].[user_type]
(
	[created_by] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [created_by]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[user_workstation]') AND name = N'created_by')
CREATE NONCLUSTERED INDEX [created_by] ON [dbo].[user_workstation]
(
	[created_by] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [user]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[user_workstation]') AND name = N'user')
CREATE NONCLUSTERED INDEX [user] ON [dbo].[user_workstation]
(
	[user] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [workstation]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[user_workstation]') AND name = N'workstation')
CREATE NONCLUSTERED INDEX [workstation] ON [dbo].[user_workstation]
(
	[workstation] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [card]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visit]') AND name = N'card')
CREATE NONCLUSTERED INDEX [card] ON [dbo].[visit]
(
	[card] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [card_type]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visit]') AND name = N'card_type')
CREATE NONCLUSTERED INDEX [card_type] ON [dbo].[visit]
(
	[card_type] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [created_by]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visit]') AND name = N'created_by')
CREATE NONCLUSTERED INDEX [created_by] ON [dbo].[visit]
(
	[created_by] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [host]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visit]') AND name = N'host')
CREATE NONCLUSTERED INDEX [host] ON [dbo].[visit]
(
	[host] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [patient]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visit]') AND name = N'patient')
CREATE NONCLUSTERED INDEX [patient] ON [dbo].[visit]
(
	[patient] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [reason]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visit]') AND name = N'reason')
CREATE NONCLUSTERED INDEX [reason] ON [dbo].[visit]
(
	[reason] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [tenant]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visit]') AND name = N'tenant')
CREATE NONCLUSTERED INDEX [tenant] ON [dbo].[visit]
(
	[tenant] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [tenant_agent]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visit]') AND name = N'tenant_agent')
CREATE NONCLUSTERED INDEX [tenant_agent] ON [dbo].[visit]
(
	[tenant_agent] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [visit_status]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visit]') AND name = N'visit_status')
CREATE NONCLUSTERED INDEX [visit_status] ON [dbo].[visit]
(
	[visit_status] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [visitor_status]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visit]') AND name = N'visitor_status')
CREATE NONCLUSTERED INDEX [visitor_status] ON [dbo].[visit]
(
	[visitor_status] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [visitor_type]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visit]') AND name = N'visitor_type')
CREATE NONCLUSTERED INDEX [visitor_type] ON [dbo].[visit]
(
	[visitor_type] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [workstation]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visit]') AND name = N'workstation')
CREATE NONCLUSTERED INDEX [workstation] ON [dbo].[visit]
(
	[workstation] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [created_by]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visit_reason]') AND name = N'created_by')
CREATE NONCLUSTERED INDEX [created_by] ON [dbo].[visit_reason]
(
	[created_by] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [tenant]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visit_reason]') AND name = N'tenant')
CREATE NONCLUSTERED INDEX [tenant] ON [dbo].[visit_reason]
(
	[tenant] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [tenant_agent]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visit_reason]') AND name = N'tenant_agent')
CREATE NONCLUSTERED INDEX [tenant_agent] ON [dbo].[visit_reason]
(
	[tenant_agent] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [created_by]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visit_status]') AND name = N'created_by')
CREATE NONCLUSTERED INDEX [created_by] ON [dbo].[visit_status]
(
	[created_by] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [company]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visitor]') AND name = N'company')
CREATE NONCLUSTERED INDEX [company] ON [dbo].[visitor]
(
	[company] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [contact_country_fk]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visitor]') AND name = N'contact_country_fk')
CREATE NONCLUSTERED INDEX [contact_country_fk] ON [dbo].[visitor]
(
	[contact_country] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [created_by]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visitor]') AND name = N'created_by')
CREATE NONCLUSTERED INDEX [created_by] ON [dbo].[visitor]
(
	[created_by] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [identification_country_fk]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visitor]') AND name = N'identification_country_fk')
CREATE NONCLUSTERED INDEX [identification_country_fk] ON [dbo].[visitor]
(
	[identification_country_issued] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [photo]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visitor]') AND name = N'photo')
CREATE NONCLUSTERED INDEX [photo] ON [dbo].[visitor]
(
	[photo] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [role]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visitor]') AND name = N'role')
CREATE NONCLUSTERED INDEX [role] ON [dbo].[visitor]
(
	[role] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [tenant]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visitor]') AND name = N'tenant')
CREATE NONCLUSTERED INDEX [tenant] ON [dbo].[visitor]
(
	[tenant] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [tenant_agent]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visitor]') AND name = N'tenant_agent')
CREATE NONCLUSTERED INDEX [tenant_agent] ON [dbo].[visitor]
(
	[tenant_agent] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [vehicle]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visitor]') AND name = N'vehicle')
CREATE NONCLUSTERED INDEX [vehicle] ON [dbo].[visitor]
(
	[vehicle] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [visitor_card_status]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visitor]') AND name = N'visitor_card_status')
CREATE NONCLUSTERED INDEX [visitor_card_status] ON [dbo].[visitor]
(
	[visitor_card_status] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [visitor_status]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visitor]') AND name = N'visitor_status')
CREATE NONCLUSTERED INDEX [visitor_status] ON [dbo].[visitor]
(
	[visitor_status] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [visitor_type]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visitor]') AND name = N'visitor_type')
CREATE NONCLUSTERED INDEX [visitor_type] ON [dbo].[visitor]
(
	[visitor_type] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [visitor_workstation]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visitor]') AND name = N'visitor_workstation')
CREATE NONCLUSTERED INDEX [visitor_workstation] ON [dbo].[visitor]
(
	[visitor_workstation] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [created_by]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[visitor_type]') AND name = N'created_by')
CREATE NONCLUSTERED INDEX [created_by] ON [dbo].[visitor_type]
(
	[created_by] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [created_by]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[workstation]') AND name = N'created_by')
CREATE NONCLUSTERED INDEX [created_by] ON [dbo].[workstation]
(
	[created_by] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [workstation_card_type_card_type]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[workstation_card_type]') AND name = N'workstation_card_type_card_type')
CREATE NONCLUSTERED INDEX [workstation_card_type_card_type] ON [dbo].[workstation_card_type]
(
	[card_type] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [workstation_card_user]    Script Date: 8/8/2015 5:31:01 AM ******/
IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[workstation_card_type]') AND name = N'workstation_card_user')
CREATE NONCLUSTERED INDEX [workstation_card_user] ON [dbo].[workstation_card_type]
(
	[user] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__access_to__EXPIR__0F975522]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[access_tokens] ADD  CONSTRAINT [DF__access_to__EXPIR__0F975522]  DEFAULT (NULL) FOR [EXPIRY]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__access_to__USER___108B795B]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[access_tokens] ADD  CONSTRAINT [DF__access_to__USER___108B795B]  DEFAULT (NULL) FOR [USER_TYPE]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__audit_tra__descr__1273C1CD]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[audit_trail] ADD  CONSTRAINT [DF__audit_tra__descr__1273C1CD]  DEFAULT (NULL) FOR [description]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__audit_tra__old_v__1367E606]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[audit_trail] ADD  CONSTRAINT [DF__audit_tra__old_v__1367E606]  DEFAULT (NULL) FOR [old_value]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__audit_tra__new_v__145C0A3F]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[audit_trail] ADD  CONSTRAINT [DF__audit_tra__new_v__145C0A3F]  DEFAULT (NULL) FOR [new_value]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__audit_tra__actio__15502E78]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[audit_trail] ADD  CONSTRAINT [DF__audit_tra__actio__15502E78]  DEFAULT (NULL) FOR [action]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__audit_tra__model__164452B1]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[audit_trail] ADD  CONSTRAINT [DF__audit_tra__model__164452B1]  DEFAULT (NULL) FOR [model]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__audit_tra__model__173876EA]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[audit_trail] ADD  CONSTRAINT [DF__audit_tra__model__173876EA]  DEFAULT (NULL) FOR [model_id]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__audit_tra__field__182C9B23]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[audit_trail] ADD  CONSTRAINT [DF__audit_tra__field__182C9B23]  DEFAULT (NULL) FOR [field]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__audit_tra__user___1920BF5C]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[audit_trail] ADD  CONSTRAINT [DF__audit_tra__user___1920BF5C]  DEFAULT (NULL) FOR [user_id]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_gene__card___1B0907CE]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_generated] ADD  CONSTRAINT [DF__card_gene__card___1B0907CE]  DEFAULT (NULL) FOR [card_number]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_gene__date___1BFD2C07]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_generated] ADD  CONSTRAINT [DF__card_gene__date___1BFD2C07]  DEFAULT (NULL) FOR [date_printed]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_gene__date___1CF15040]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_generated] ADD  CONSTRAINT [DF__card_gene__date___1CF15040]  DEFAULT (NULL) FOR [date_expiration]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_gene__date___1DE57479]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_generated] ADD  CONSTRAINT [DF__card_gene__date___1DE57479]  DEFAULT (NULL) FOR [date_cancelled]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_gene__date___1ED998B2]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_generated] ADD  CONSTRAINT [DF__card_gene__date___1ED998B2]  DEFAULT (NULL) FOR [date_returned]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_gene__card___1FCDBCEB]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_generated] ADD  CONSTRAINT [DF__card_gene__card___1FCDBCEB]  DEFAULT (NULL) FOR [card_image_generated_filename]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_gene__visit__20C1E124]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_generated] ADD  CONSTRAINT [DF__card_gene__visit__20C1E124]  DEFAULT (NULL) FOR [visitor_id]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_gene__card___21B6055D]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_generated] ADD  CONSTRAINT [DF__card_gene__card___21B6055D]  DEFAULT (NULL) FOR [card_status]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_gene__creat__22AA2996]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_generated] ADD  CONSTRAINT [DF__card_gene__creat__22AA2996]  DEFAULT (NULL) FOR [created_by]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_gene__tenan__239E4DCF]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_generated] ADD  CONSTRAINT [DF__card_gene__tenan__239E4DCF]  DEFAULT (NULL) FOR [tenant]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_gene__tenan__24927208]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_generated] ADD  CONSTRAINT [DF__card_gene__tenan__24927208]  DEFAULT (NULL) FOR [tenant_agent]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_gene__print__25869641]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_generated] ADD  CONSTRAINT [DF__card_gene__print__25869641]  DEFAULT ((0)) FOR [print_count]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_stat__creat__276EDEB3]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_status] ADD  CONSTRAINT [DF__card_stat__creat__276EDEB3]  DEFAULT (NULL) FOR [created_by]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_type__name__29572725]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_type] ADD  CONSTRAINT [DF__card_type__name__29572725]  DEFAULT (NULL) FOR [name]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_type__max_d__2A4B4B5E]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_type] ADD  CONSTRAINT [DF__card_type__max_d__2A4B4B5E]  DEFAULT (NULL) FOR [max_day_validity]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_type__max_t__2B3F6F97]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_type] ADD  CONSTRAINT [DF__card_type__max_t__2B3F6F97]  DEFAULT (NULL) FOR [max_time_validity]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_type__max_e__2C3393D0]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_type] ADD  CONSTRAINT [DF__card_type__max_e__2C3393D0]  DEFAULT (NULL) FOR [max_entry_count_validity]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_type__creat__2D27B809]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_type] ADD  CONSTRAINT [DF__card_type__creat__2D27B809]  DEFAULT (NULL) FOR [created_by]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__card_type__modul__2E1BDC42]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[card_type] ADD  CONSTRAINT [DF__card_type__modul__2E1BDC42]  DEFAULT (NULL) FOR [module]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company__trading__30F848ED]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company] ADD  CONSTRAINT [DF__company__trading__30F848ED]  DEFAULT (NULL) FOR [trading_name]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company__logo__31EC6D26]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company] ADD  CONSTRAINT [DF__company__logo__31EC6D26]  DEFAULT (NULL) FOR [logo]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company__contact__32E0915F]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company] ADD  CONSTRAINT [DF__company__contact__32E0915F]  DEFAULT (NULL) FOR [contact]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company__billing__33D4B598]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company] ADD  CONSTRAINT [DF__company__billing__33D4B598]  DEFAULT (NULL) FOR [billing_address]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company__email_a__34C8D9D1]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company] ADD  CONSTRAINT [DF__company__email_a__34C8D9D1]  DEFAULT (NULL) FOR [email_address]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company__office___35BCFE0A]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company] ADD  CONSTRAINT [DF__company__office___35BCFE0A]  DEFAULT (NULL) FOR [office_number]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company__website__37A5467C]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company] ADD  CONSTRAINT [DF__company__website__37A5467C]  DEFAULT (NULL) FOR [website]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company__company__38996AB5]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company] ADD  CONSTRAINT [DF__company__company__38996AB5]  DEFAULT (NULL) FOR [company_laf_preferences]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company__created__398D8EEE]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company] ADD  CONSTRAINT [DF__company__created__398D8EEE]  DEFAULT (NULL) FOR [created_by_user]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company__created__3A81B327]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company] ADD  CONSTRAINT [DF__company__created__3A81B327]  DEFAULT (NULL) FOR [created_by_visitor]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company__tenant__3B75D760]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company] ADD  CONSTRAINT [DF__company__tenant__3B75D760]  DEFAULT (NULL) FOR [tenant]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company__tenant___3C69FB99]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company] ADD  CONSTRAINT [DF__company__tenant___3C69FB99]  DEFAULT (NULL) FOR [tenant_agent]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company__is_dele__3D5E1FD2]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company] ADD  CONSTRAINT [DF__company__is_dele__3D5E1FD2]  DEFAULT ((0)) FOR [is_deleted]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company__card_co__3E52440B]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company] ADD  CONSTRAINT [DF__company__card_co__3E52440B]  DEFAULT (NULL) FOR [card_count]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company__company__3F466844]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company] ADD  CONSTRAINT [DF__company__company__3F466844]  DEFAULT (NULL) FOR [company_type]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__actio__412EB0B6]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] ADD  CONSTRAINT [DF__company_l__actio__412EB0B6]  DEFAULT (NULL) FOR [action_forward_bg_color]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__actio__4222D4EF]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] ADD  CONSTRAINT [DF__company_l__actio__4222D4EF]  DEFAULT (NULL) FOR [action_forward_bg_color2]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__actio__4316F928]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] ADD  CONSTRAINT [DF__company_l__actio__4316F928]  DEFAULT (NULL) FOR [action_forward_font_color]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__actio__440B1D61]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] ADD  CONSTRAINT [DF__company_l__actio__440B1D61]  DEFAULT (NULL) FOR [action_forward_hover_color]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__actio__44FF419A]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] ADD  CONSTRAINT [DF__company_l__actio__44FF419A]  DEFAULT (NULL) FOR [action_forward_hover_color2]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__actio__45F365D3]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] ADD  CONSTRAINT [DF__company_l__actio__45F365D3]  DEFAULT (NULL) FOR [action_forward_hover_font_color]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__compl__46E78A0C]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] ADD  CONSTRAINT [DF__company_l__compl__46E78A0C]  DEFAULT (NULL) FOR [complete_bg_color]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__compl__47DBAE45]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] ADD  CONSTRAINT [DF__company_l__compl__47DBAE45]  DEFAULT (NULL) FOR [complete_bg_color2]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__compl__48CFD27E]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] ADD  CONSTRAINT [DF__company_l__compl__48CFD27E]  DEFAULT (NULL) FOR [complete_hover_color]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__compl__49C3F6B7]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] ADD  CONSTRAINT [DF__company_l__compl__49C3F6B7]  DEFAULT (NULL) FOR [complete_hover_color2]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__compl__4AB81AF0]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] ADD  CONSTRAINT [DF__company_l__compl__4AB81AF0]  DEFAULT (NULL) FOR [complete_font_color]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__compl__4BAC3F29]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] ADD  CONSTRAINT [DF__company_l__compl__4BAC3F29]  DEFAULT (NULL) FOR [complete_hover_font_color]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__neutr__4CA06362]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] ADD  CONSTRAINT [DF__company_l__neutr__4CA06362]  DEFAULT (NULL) FOR [neutral_bg_color]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__neutr__4D94879B]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] ADD  CONSTRAINT [DF__company_l__neutr__4D94879B]  DEFAULT (NULL) FOR [neutral_bg_color2]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__neutr__4E88ABD4]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] ADD  CONSTRAINT [DF__company_l__neutr__4E88ABD4]  DEFAULT (NULL) FOR [neutral_hover_color]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__neutr__4F7CD00D]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] ADD  CONSTRAINT [DF__company_l__neutr__4F7CD00D]  DEFAULT (NULL) FOR [neutral_hover_color2]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__neutr__5070F446]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] ADD  CONSTRAINT [DF__company_l__neutr__5070F446]  DEFAULT (NULL) FOR [neutral_font_color]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__neutr__5165187F]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] ADD  CONSTRAINT [DF__company_l__neutr__5165187F]  DEFAULT (NULL) FOR [neutral_hover_font_color]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__nav_b__52593CB8]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] ADD  CONSTRAINT [DF__company_l__nav_b__52593CB8]  DEFAULT (NULL) FOR [nav_bg_color]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__nav_h__534D60F1]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] ADD  CONSTRAINT [DF__company_l__nav_h__534D60F1]  DEFAULT (NULL) FOR [nav_hover_color]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__nav_f__5441852A]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] ADD  CONSTRAINT [DF__company_l__nav_f__5441852A]  DEFAULT (NULL) FOR [nav_font_color]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__nav_h__5535A963]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] ADD  CONSTRAINT [DF__company_l__nav_h__5535A963]  DEFAULT (NULL) FOR [nav_hover_font_color]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__sidem__5629CD9C]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] ADD  CONSTRAINT [DF__company_l__sidem__5629CD9C]  DEFAULT (NULL) FOR [sidemenu_bg_color]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__sidem__571DF1D5]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] ADD  CONSTRAINT [DF__company_l__sidem__571DF1D5]  DEFAULT (NULL) FOR [sidemenu_hover_color]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__sidem__5812160E]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] ADD  CONSTRAINT [DF__company_l__sidem__5812160E]  DEFAULT (NULL) FOR [sidemenu_font_color]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__sidem__59063A47]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] ADD  CONSTRAINT [DF__company_l__sidem__59063A47]  DEFAULT (NULL) FOR [sidemenu_hover_font_color]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_l__css_f__59FA5E80]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_laf_preferences] ADD  CONSTRAINT [DF__company_l__css_f__59FA5E80]  DEFAULT (NULL) FOR [css_file_path]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__company_t__creat__5BE2A6F2]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[company_type] ADD  CONSTRAINT [DF__company_t__creat__5BE2A6F2]  DEFAULT (NULL) FOR [created_by]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__contact_p__date___5A4F643B]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[contact_person] ADD  CONSTRAINT [DF__contact_p__date___5A4F643B]  DEFAULT (getdate()) FOR [date_created]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__country__code__5DCAEF64]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[country] ADD  CONSTRAINT [DF__country__code__5DCAEF64]  DEFAULT (N'') FOR [code]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__country__name__5EBF139D]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[country] ADD  CONSTRAINT [DF__country__name__5EBF139D]  DEFAULT (N'') FOR [name]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__helpdesk__order___619B8048]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[helpdesk] ADD  CONSTRAINT [DF__helpdesk__order___619B8048]  DEFAULT (NULL) FOR [order_by]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__helpdesk__create__628FA481]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[helpdesk] ADD  CONSTRAINT [DF__helpdesk__create__628FA481]  DEFAULT (NULL) FOR [created_by]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__helpdesk__is_del__6383C8BA]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[helpdesk] ADD  CONSTRAINT [DF__helpdesk__is_del__6383C8BA]  DEFAULT ((0)) FOR [is_deleted]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__helpdesk___order__656C112C]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[helpdesk_group] ADD  CONSTRAINT [DF__helpdesk___order__656C112C]  DEFAULT (NULL) FOR [order_by]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__helpdesk___creat__66603565]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[helpdesk_group] ADD  CONSTRAINT [DF__helpdesk___creat__66603565]  DEFAULT (NULL) FOR [created_by]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__helpdesk___is_de__6754599E]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[helpdesk_group] ADD  CONSTRAINT [DF__helpdesk___is_de__6754599E]  DEFAULT ((0)) FOR [is_deleted]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_ho__impor__693CA210]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_hosts] ADD  CONSTRAINT [DF__import_ho__impor__693CA210]  DEFAULT (NULL) FOR [imported_by]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_ho__date___6A30C649]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_hosts] ADD  CONSTRAINT [DF__import_ho__date___6A30C649]  DEFAULT (NULL) FOR [date_imported]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_hos__role__6B24EA82]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_hosts] ADD  CONSTRAINT [DF__import_hos__role__6B24EA82]  DEFAULT (NULL) FOR [role]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_ho__posit__6C190EBB]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_hosts] ADD  CONSTRAINT [DF__import_ho__posit__6C190EBB]  DEFAULT (NULL) FOR [position]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_ho__date___6D0D32F4]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_hosts] ADD  CONSTRAINT [DF__import_ho__date___6D0D32F4]  DEFAULT (NULL) FOR [date_of_birth]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_vi__card___6EF57B66]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_visitor] ADD  CONSTRAINT [DF__import_vi__card___6EF57B66]  DEFAULT (NULL) FOR [card_code]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_vi__check__6FE99F9F]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_visitor] ADD  CONSTRAINT [DF__import_vi__check__6FE99F9F]  DEFAULT (NULL) FOR [check_in_date]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_vi__check__70DDC3D8]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_visitor] ADD  CONSTRAINT [DF__import_vi__check__70DDC3D8]  DEFAULT (NULL) FOR [check_out_date]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_vi__impor__71D1E811]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_visitor] ADD  CONSTRAINT [DF__import_vi__impor__71D1E811]  DEFAULT (NULL) FOR [imported_by]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_vi__impor__72C60C4A]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_visitor] ADD  CONSTRAINT [DF__import_vi__impor__72C60C4A]  DEFAULT (NULL) FOR [import_date]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_vi__check__73BA3083]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_visitor] ADD  CONSTRAINT [DF__import_vi__check__73BA3083]  DEFAULT (NULL) FOR [check_in_time]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_vi__check__74AE54BC]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_visitor] ADD  CONSTRAINT [DF__import_vi__check__74AE54BC]  DEFAULT (NULL) FOR [check_out_time]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_vi__posit__75A278F5]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_visitor] ADD  CONSTRAINT [DF__import_vi__posit__75A278F5]  DEFAULT (NULL) FOR [position]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_vi__date___76969D2E]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_visitor] ADD  CONSTRAINT [DF__import_vi__date___76969D2E]  DEFAULT (NULL) FOR [date_printed]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_vi__date___778AC167]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_visitor] ADD  CONSTRAINT [DF__import_vi__date___778AC167]  DEFAULT (NULL) FOR [date_expiration]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_vi__vehic__787EE5A0]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_visitor] ADD  CONSTRAINT [DF__import_vi__vehic__787EE5A0]  DEFAULT (NULL) FOR [vehicle]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__import_vi__conta__797309D9]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[import_visitor] ADD  CONSTRAINT [DF__import_vi__conta__797309D9]  DEFAULT (NULL) FOR [contact_number]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__module__about__7C4F7684]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[module] ADD  CONSTRAINT [DF__module__about__7C4F7684]  DEFAULT (NULL) FOR [about]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__module__created___7D439ABD]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[module] ADD  CONSTRAINT [DF__module__created___7D439ABD]  DEFAULT (NULL) FOR [created_by]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__notificat__creat__7F2BE32F]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[notification] ADD  CONSTRAINT [DF__notificat__creat__7F2BE32F]  DEFAULT (NULL) FOR [created_by]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__notificat__date___00200768]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[notification] ADD  CONSTRAINT [DF__notificat__date___00200768]  DEFAULT (NULL) FOR [date_created]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__notificat__role___01142BA1]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[notification] ADD  CONSTRAINT [DF__notificat__role___01142BA1]  DEFAULT (NULL) FOR [role_id]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__notificat__notif__02084FDA]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[notification] ADD  CONSTRAINT [DF__notificat__notif__02084FDA]  DEFAULT (NULL) FOR [notification_type]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__password___user___03F0984C]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[password_change_request] ADD  CONSTRAINT [DF__password___user___03F0984C]  DEFAULT ((0)) FOR [user_id]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__password_c__hash__04E4BC85]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[password_change_request] ADD  CONSTRAINT [DF__password_c__hash__04E4BC85]  DEFAULT (N'') FOR [hash]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__password___creat__05D8E0BE]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[password_change_request] ADD  CONSTRAINT [DF__password___creat__05D8E0BE]  DEFAULT (getdate()) FOR [created_at]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__password___is_us__06CD04F7]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[password_change_request] ADD  CONSTRAINT [DF__password___is_us__06CD04F7]  DEFAULT (N'NO') FOR [is_used]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__patient__name__08B54D69]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[patient] ADD  CONSTRAINT [DF__patient__name__08B54D69]  DEFAULT (NULL) FOR [name]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__reasons__date_cr__0B91BA14]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[reasons] ADD  CONSTRAINT [DF__reasons__date_cr__0B91BA14]  DEFAULT (getdate()) FOR [date_created]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__reset_his__lodge__0D7A0286]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[reset_history] ADD  CONSTRAINT [DF__reset_his__lodge__0D7A0286]  DEFAULT (NULL) FOR [lodgement_date]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__roles__created_b__0F624AF8]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[roles] ADD  CONSTRAINT [DF__roles__created_b__0F624AF8]  DEFAULT (NULL) FOR [created_by]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__tbl_migra__apply__114A936A]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[tbl_migration] ADD  CONSTRAINT [DF__tbl_migra__apply__114A936A]  DEFAULT (NULL) FOR [apply_time]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__tenant__is_delet__1332DBDC]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[tenant] ADD  CONSTRAINT [DF__tenant__is_delet__1332DBDC]  DEFAULT ((0)) FOR [is_deleted]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user__date_of_bi__17036CC0]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user] ADD  CONSTRAINT [DF__user__date_of_bi__17036CC0]  DEFAULT (NULL) FOR [date_of_birth]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user__company__17F790F9]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user] ADD  CONSTRAINT [DF__user__company__17F790F9]  DEFAULT (NULL) FOR [company]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user__department__18EBB532]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user] ADD  CONSTRAINT [DF__user__department__18EBB532]  DEFAULT (NULL) FOR [department]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user__position__19DFD96B]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user] ADD  CONSTRAINT [DF__user__position__19DFD96B]  DEFAULT (NULL) FOR [position]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user__staff_id__1AD3FDA4]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user] ADD  CONSTRAINT [DF__user__staff_id__1AD3FDA4]  DEFAULT (NULL) FOR [staff_id]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user__password__1BC821DD]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user] ADD  CONSTRAINT [DF__user__password__1BC821DD]  DEFAULT (NULL) FOR [password]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user__user_statu__1CBC4616]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user] ADD  CONSTRAINT [DF__user__user_statu__1CBC4616]  DEFAULT ((1)) FOR [user_status]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user__created_by__1DB06A4F]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user] ADD  CONSTRAINT [DF__user__created_by__1DB06A4F]  DEFAULT (NULL) FOR [created_by]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user__is_deleted__1EA48E88]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user] ADD  CONSTRAINT [DF__user__is_deleted__1EA48E88]  DEFAULT ((0)) FOR [is_deleted]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user__tenant__1F98B2C1]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user] ADD  CONSTRAINT [DF__user__tenant__1F98B2C1]  DEFAULT (NULL) FOR [tenant]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user__tenant_age__208CD6FA]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user] ADD  CONSTRAINT [DF__user__tenant_age__208CD6FA]  DEFAULT (NULL) FOR [tenant_agent]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user__asic_no__2180FB33]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user] ADD  CONSTRAINT [DF__user__asic_no__2180FB33]  DEFAULT (NULL) FOR [asic_no]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user__asic_expir__22751F6C]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user] ADD  CONSTRAINT [DF__user__asic_expir__22751F6C]  DEFAULT (NULL) FOR [asic_expiry]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user__is_require__236943A5]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user] ADD  CONSTRAINT [DF__user__is_require__236943A5]  DEFAULT (NULL) FOR [is_required_induction]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user__is_complet__245D67DE]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user] ADD  CONSTRAINT [DF__user__is_complet__245D67DE]  DEFAULT (NULL) FOR [is_completed_induction]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user__induction___25518C17]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user] ADD  CONSTRAINT [DF__user__induction___25518C17]  DEFAULT (NULL) FOR [induction_expiry]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user_noti__user___2739D489]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user_notification] ADD  CONSTRAINT [DF__user_noti__user___2739D489]  DEFAULT (NULL) FOR [user_id]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user_noti__notif__282DF8C2]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user_notification] ADD  CONSTRAINT [DF__user_noti__notif__282DF8C2]  DEFAULT (NULL) FOR [notification_id]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user_noti__has_r__29221CFB]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user_notification] ADD  CONSTRAINT [DF__user_noti__has_r__29221CFB]  DEFAULT (NULL) FOR [has_read]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user_noti__date___2A164134]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user_notification] ADD  CONSTRAINT [DF__user_noti__date___2A164134]  DEFAULT (NULL) FOR [date_read]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user_stat__creat__2BFE89A6]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user_status] ADD  CONSTRAINT [DF__user_stat__creat__2BFE89A6]  DEFAULT (NULL) FOR [created_by]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user_type__creat__2DE6D218]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user_type] ADD  CONSTRAINT [DF__user_type__creat__2DE6D218]  DEFAULT (NULL) FOR [created_by]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user_work__creat__2FCF1A8A]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user_workstation] ADD  CONSTRAINT [DF__user_work__creat__2FCF1A8A]  DEFAULT (NULL) FOR [created_by]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__user_work__is_pr__30C33EC3]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[user_workstation] ADD  CONSTRAINT [DF__user_work__is_pr__30C33EC3]  DEFAULT ((0)) FOR [is_primary]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__visitor__339FAB6E]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] ADD  CONSTRAINT [DF__visit__visitor__339FAB6E]  DEFAULT (NULL) FOR [visitor]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__card_type__3493CFA7]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] ADD  CONSTRAINT [DF__visit__card_type__3493CFA7]  DEFAULT (NULL) FOR [card_type]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__card__3587F3E0]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] ADD  CONSTRAINT [DF__visit__card__3587F3E0]  DEFAULT (NULL) FOR [card]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__visitor_t__367C1819]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] ADD  CONSTRAINT [DF__visit__visitor_t__367C1819]  DEFAULT (NULL) FOR [visitor_type]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__reason__37703C52]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] ADD  CONSTRAINT [DF__visit__reason__37703C52]  DEFAULT (NULL) FOR [reason]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__visitor_s__3864608B]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] ADD  CONSTRAINT [DF__visit__visitor_s__3864608B]  DEFAULT ((1)) FOR [visitor_status]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__host__395884C4]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] ADD  CONSTRAINT [DF__visit__host__395884C4]  DEFAULT (NULL) FOR [host]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__patient__3A4CA8FD]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] ADD  CONSTRAINT [DF__visit__patient__3A4CA8FD]  DEFAULT (NULL) FOR [patient]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__created_b__3B40CD36]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] ADD  CONSTRAINT [DF__visit__created_b__3B40CD36]  DEFAULT (NULL) FOR [created_by]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__date_in__3C34F16F]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] ADD  CONSTRAINT [DF__visit__date_in__3C34F16F]  DEFAULT (NULL) FOR [date_in]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__time_in__3D2915A8]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] ADD  CONSTRAINT [DF__visit__time_in__3D2915A8]  DEFAULT (NULL) FOR [time_in]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__date_out__3E1D39E1]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] ADD  CONSTRAINT [DF__visit__date_out__3E1D39E1]  DEFAULT (NULL) FOR [date_out]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__time_out__3F115E1A]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] ADD  CONSTRAINT [DF__visit__time_out__3F115E1A]  DEFAULT (NULL) FOR [time_out]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__date_chec__40058253]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] ADD  CONSTRAINT [DF__visit__date_chec__40058253]  DEFAULT (NULL) FOR [date_check_in]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__time_chec__40F9A68C]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] ADD  CONSTRAINT [DF__visit__time_chec__40F9A68C]  DEFAULT (NULL) FOR [time_check_in]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__date_chec__41EDCAC5]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] ADD  CONSTRAINT [DF__visit__date_chec__41EDCAC5]  DEFAULT (NULL) FOR [date_check_out]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__time_chec__42E1EEFE]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] ADD  CONSTRAINT [DF__visit__time_chec__42E1EEFE]  DEFAULT (NULL) FOR [time_check_out]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__visit_sta__43D61337]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] ADD  CONSTRAINT [DF__visit__visit_sta__43D61337]  DEFAULT (NULL) FOR [visit_status]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__workstati__44CA3770]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] ADD  CONSTRAINT [DF__visit__workstati__44CA3770]  DEFAULT (NULL) FOR [workstation]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__tenant__45BE5BA9]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] ADD  CONSTRAINT [DF__visit__tenant__45BE5BA9]  DEFAULT (NULL) FOR [tenant]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__tenant_ag__46B27FE2]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] ADD  CONSTRAINT [DF__visit__tenant_ag__46B27FE2]  DEFAULT (NULL) FOR [tenant_agent]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__is_delete__47A6A41B]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] ADD  CONSTRAINT [DF__visit__is_delete__47A6A41B]  DEFAULT ((0)) FOR [is_deleted]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__finish_da__489AC854]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] ADD  CONSTRAINT [DF__visit__finish_da__489AC854]  DEFAULT (NULL) FOR [finish_date]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__finish_ti__498EEC8D]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] ADD  CONSTRAINT [DF__visit__finish_ti__498EEC8D]  DEFAULT (NULL) FOR [finish_time]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__card_retu__4A8310C6]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] ADD  CONSTRAINT [DF__visit__card_retu__4A8310C6]  DEFAULT (NULL) FOR [card_returned_date]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__reset_id__4B7734FF]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] ADD  CONSTRAINT [DF__visit__reset_id__4B7734FF]  DEFAULT (NULL) FOR [reset_id]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__negate_re__4C6B5938]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] ADD  CONSTRAINT [DF__visit__negate_re__4C6B5938]  DEFAULT (NULL) FOR [negate_reason]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__card_opti__4D5F7D71]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] ADD  CONSTRAINT [DF__visit__card_opti__4D5F7D71]  DEFAULT (N'Returned') FOR [card_option]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit__police_re__4E53A1AA]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit] ADD  CONSTRAINT [DF__visit__police_re__4E53A1AA]  DEFAULT (N'') FOR [police_report_number]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit_rea__creat__503BEA1C]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit_reason] ADD  CONSTRAINT [DF__visit_rea__creat__503BEA1C]  DEFAULT (NULL) FOR [created_by]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit_rea__tenan__51300E55]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit_reason] ADD  CONSTRAINT [DF__visit_rea__tenan__51300E55]  DEFAULT (NULL) FOR [tenant]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit_rea__tenan__5224328E]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit_reason] ADD  CONSTRAINT [DF__visit_rea__tenan__5224328E]  DEFAULT (NULL) FOR [tenant_agent]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit_rea__is_de__531856C7]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit_reason] ADD  CONSTRAINT [DF__visit_rea__is_de__531856C7]  DEFAULT ((0)) FOR [is_deleted]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit_stat__name__55009F39]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit_status] ADD  CONSTRAINT [DF__visit_stat__name__55009F39]  DEFAULT (NULL) FOR [name]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visit_sta__creat__55F4C372]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visit_status] ADD  CONSTRAINT [DF__visit_sta__creat__55F4C372]  DEFAULT (NULL) FOR [created_by]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__middle___57DD0BE4]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__middle___57DD0BE4]  DEFAULT (NULL) FOR [middle_name]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__date_of__58D1301D]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__date_of__58D1301D]  DEFAULT (NULL) FOR [date_of_birth]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__company__59C55456]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__company__59C55456]  DEFAULT (NULL) FOR [company]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__departm__5AB9788F]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__departm__5AB9788F]  DEFAULT (NULL) FOR [department]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__positio__5BAD9CC8]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__positio__5BAD9CC8]  DEFAULT (NULL) FOR [position]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__staff_i__5CA1C101]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__staff_i__5CA1C101]  DEFAULT (NULL) FOR [staff_id]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__passwor__5D95E53A]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__passwor__5D95E53A]  DEFAULT (NULL) FOR [password]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__role__5E8A0973]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__role__5E8A0973]  DEFAULT ((10)) FOR [role]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__visitor__5F7E2DAC]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__visitor__5F7E2DAC]  DEFAULT (NULL) FOR [visitor_type]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__visitor__607251E5]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__visitor__607251E5]  DEFAULT ((1)) FOR [visitor_status]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__vehicle__6166761E]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__vehicle__6166761E]  DEFAULT (NULL) FOR [vehicle]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__photo__625A9A57]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__photo__625A9A57]  DEFAULT (NULL) FOR [photo]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__created__634EBE90]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__created__634EBE90]  DEFAULT (NULL) FOR [created_by]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__is_dele__6442E2C9]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__is_dele__6442E2C9]  DEFAULT ((0)) FOR [is_deleted]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__tenant__65370702]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__tenant__65370702]  DEFAULT (NULL) FOR [tenant]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__tenant___662B2B3B]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__tenant___662B2B3B]  DEFAULT (NULL) FOR [tenant_agent]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__visitor__671F4F74]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__visitor__671F4F74]  DEFAULT (NULL) FOR [visitor_card_status]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__visitor__681373AD]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__visitor__681373AD]  DEFAULT (NULL) FOR [visitor_workstation]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__profile__690797E6]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__profile__690797E6]  DEFAULT (N'CORPORATE') FOR [profile_type]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__identif__69FBBC1F]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__identif__69FBBC1F]  DEFAULT (NULL) FOR [identification_type]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__identif__6AEFE058]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__identif__6AEFE058]  DEFAULT (NULL) FOR [identification_country_issued]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__identif__6BE40491]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__identif__6BE40491]  DEFAULT (NULL) FOR [identification_document_no]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__identif__6CD828CA]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__identif__6CD828CA]  DEFAULT (NULL) FOR [identification_document_expiry]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__identif__6DCC4D03]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__identif__6DCC4D03]  DEFAULT (NULL) FOR [identification_alternate_document_name1]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__identif__6EC0713C]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__identif__6EC0713C]  DEFAULT (NULL) FOR [identification_alternate_document_no1]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__identif__6FB49575]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__identif__6FB49575]  DEFAULT (NULL) FOR [identification_alternate_document_expiry1]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__identif__70A8B9AE]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__identif__70A8B9AE]  DEFAULT (NULL) FOR [identification_alternate_document_name2]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__identif__719CDDE7]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__identif__719CDDE7]  DEFAULT (NULL) FOR [identification_alternate_document_no2]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__identif__72910220]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__identif__72910220]  DEFAULT (NULL) FOR [identification_alternate_document_expiry2]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__contact__73852659]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__contact__73852659]  DEFAULT (NULL) FOR [contact_unit]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__contact__74794A92]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__contact__74794A92]  DEFAULT (NULL) FOR [contact_street_no]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__contact__756D6ECB]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__contact__756D6ECB]  DEFAULT (NULL) FOR [contact_street_name]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__contact__76619304]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__contact__76619304]  DEFAULT (NULL) FOR [contact_street_type]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__contact__7755B73D]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__contact__7755B73D]  DEFAULT (NULL) FOR [contact_suburb]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__contact__7849DB76]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__contact__7849DB76]  DEFAULT (NULL) FOR [contact_state]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__contact__793DFFAF]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__contact__793DFFAF]  DEFAULT (NULL) FOR [contact_country]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__asic_no__7A3223E8]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__asic_no__7A3223E8]  DEFAULT (NULL) FOR [asic_no]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__asic_ex__7B264821]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__asic_ex__7B264821]  DEFAULT (NULL) FOR [asic_expiry]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__verifia__7C1A6C5A]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__verifia__7C1A6C5A]  DEFAULT ((0)) FOR [verifiable_signature]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__contact__7D0E9093]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__contact__7D0E9093]  DEFAULT (NULL) FOR [contact_postcode]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__date_cr__7E02B4CC]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__date_cr__7E02B4CC]  DEFAULT (getdate()) FOR [date_created]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor__is_unde__5B438874]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor] ADD  CONSTRAINT [DF__visitor__is_unde__5B438874]  DEFAULT ((0)) FOR [is_under_18]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor_c__profi__7FEAFD3E]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor_card_status] ADD  CONSTRAINT [DF__visitor_c__profi__7FEAFD3E]  DEFAULT (N'CORPORATE') FOR [profile_type]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor_st__name__01D345B0]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor_status] ADD  CONSTRAINT [DF__visitor_st__name__01D345B0]  DEFAULT (NULL) FOR [name]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor_ty__name__03BB8E22]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor_type] ADD  CONSTRAINT [DF__visitor_ty__name__03BB8E22]  DEFAULT (NULL) FOR [name]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor_t__creat__04AFB25B]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor_type] ADD  CONSTRAINT [DF__visitor_t__creat__04AFB25B]  DEFAULT (NULL) FOR [created_by]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor_t__tenan__05A3D694]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor_type] ADD  CONSTRAINT [DF__visitor_t__tenan__05A3D694]  DEFAULT (NULL) FOR [tenant]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor_t__tenan__0697FACD]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor_type] ADD  CONSTRAINT [DF__visitor_t__tenan__0697FACD]  DEFAULT (NULL) FOR [tenant_agent]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor_t__is_de__078C1F06]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor_type] ADD  CONSTRAINT [DF__visitor_t__is_de__078C1F06]  DEFAULT ((0)) FOR [is_deleted]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor_t__is_de__0880433F]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor_type] ADD  CONSTRAINT [DF__visitor_t__is_de__0880433F]  DEFAULT ((0)) FOR [is_default_value]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__visitor_t__is_de__04459E07]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[visitor_type_card_type] ADD  CONSTRAINT [DF__visitor_t__is_de__04459E07]  DEFAULT ((0)) FOR [is_deleted]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__workstati__locat__0A688BB1]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[workstation] ADD  CONSTRAINT [DF__workstati__locat__0A688BB1]  DEFAULT (NULL) FOR [location]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__workstati__conta__0B5CAFEA]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[workstation] ADD  CONSTRAINT [DF__workstati__conta__0B5CAFEA]  DEFAULT (NULL) FOR [contact_name]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__workstati__conta__0C50D423]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[workstation] ADD  CONSTRAINT [DF__workstati__conta__0C50D423]  DEFAULT (NULL) FOR [contact_number]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__workstati__conta__0D44F85C]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[workstation] ADD  CONSTRAINT [DF__workstati__conta__0D44F85C]  DEFAULT (NULL) FOR [contact_email_address]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__workstati__numbe__0E391C95]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[workstation] ADD  CONSTRAINT [DF__workstati__numbe__0E391C95]  DEFAULT (NULL) FOR [number_of_operators]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__workstati__assig__0F2D40CE]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[workstation] ADD  CONSTRAINT [DF__workstati__assig__0F2D40CE]  DEFAULT ((0)) FOR [assign_kiosk]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__workstati__passw__10216507]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[workstation] ADD  CONSTRAINT [DF__workstati__passw__10216507]  DEFAULT (NULL) FOR [password]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__workstati__creat__11158940]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[workstation] ADD  CONSTRAINT [DF__workstati__creat__11158940]  DEFAULT (NULL) FOR [created_by]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__workstati__tenan__1209AD79]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[workstation] ADD  CONSTRAINT [DF__workstati__tenan__1209AD79]  DEFAULT (NULL) FOR [tenant]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__workstati__tenan__12FDD1B2]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[workstation] ADD  CONSTRAINT [DF__workstati__tenan__12FDD1B2]  DEFAULT (NULL) FOR [tenant_agent]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__workstati__is_de__13F1F5EB]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[workstation] ADD  CONSTRAINT [DF__workstati__is_de__13F1F5EB]  DEFAULT ((0)) FOR [is_deleted]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__yiisession__id__16CE6296]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[yiisession] ADD  CONSTRAINT [DF__yiisession__id__16CE6296]  DEFAULT (NULL) FOR [id]
END

GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[DF__yiisessio__expir__17C286CF]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[yiisession] ADD  CONSTRAINT [DF__yiisessio__expir__17C286CF]  DEFAULT (NULL) FOR [expire]
END

GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[card_generated$card_generated_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[card_generated]'))
ALTER TABLE [dbo].[card_generated]  WITH NOCHECK ADD  CONSTRAINT [card_generated$card_generated_ibfk_1] FOREIGN KEY([card_image_generated_filename])
REFERENCES [dbo].[photo] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[card_generated$card_generated_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[card_generated]'))
ALTER TABLE [dbo].[card_generated] CHECK CONSTRAINT [card_generated$card_generated_ibfk_1]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[card_generated$card_generated_ibfk_2]') AND parent_object_id = OBJECT_ID(N'[dbo].[card_generated]'))
ALTER TABLE [dbo].[card_generated]  WITH NOCHECK ADD  CONSTRAINT [card_generated$card_generated_ibfk_2] FOREIGN KEY([created_by])
REFERENCES [dbo].[user] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[card_generated$card_generated_ibfk_2]') AND parent_object_id = OBJECT_ID(N'[dbo].[card_generated]'))
ALTER TABLE [dbo].[card_generated] CHECK CONSTRAINT [card_generated$card_generated_ibfk_2]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[card_generated$card_generated_ibfk_3]') AND parent_object_id = OBJECT_ID(N'[dbo].[card_generated]'))
ALTER TABLE [dbo].[card_generated]  WITH NOCHECK ADD  CONSTRAINT [card_generated$card_generated_ibfk_3] FOREIGN KEY([tenant])
REFERENCES [dbo].[user] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[card_generated$card_generated_ibfk_3]') AND parent_object_id = OBJECT_ID(N'[dbo].[card_generated]'))
ALTER TABLE [dbo].[card_generated] CHECK CONSTRAINT [card_generated$card_generated_ibfk_3]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[card_generated$card_generated_ibfk_5]') AND parent_object_id = OBJECT_ID(N'[dbo].[card_generated]'))
ALTER TABLE [dbo].[card_generated]  WITH NOCHECK ADD  CONSTRAINT [card_generated$card_generated_ibfk_5] FOREIGN KEY([visitor_id])
REFERENCES [dbo].[visitor] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[card_generated$card_generated_ibfk_5]') AND parent_object_id = OBJECT_ID(N'[dbo].[card_generated]'))
ALTER TABLE [dbo].[card_generated] CHECK CONSTRAINT [card_generated$card_generated_ibfk_5]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[card_generated$card_generated_ibfk_6]') AND parent_object_id = OBJECT_ID(N'[dbo].[card_generated]'))
ALTER TABLE [dbo].[card_generated]  WITH NOCHECK ADD  CONSTRAINT [card_generated$card_generated_ibfk_6] FOREIGN KEY([card_status])
REFERENCES [dbo].[card_status] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[card_generated$card_generated_ibfk_6]') AND parent_object_id = OBJECT_ID(N'[dbo].[card_generated]'))
ALTER TABLE [dbo].[card_generated] CHECK CONSTRAINT [card_generated$card_generated_ibfk_6]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[card_status$card_status_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[card_status]'))
ALTER TABLE [dbo].[card_status]  WITH NOCHECK ADD  CONSTRAINT [card_status$card_status_ibfk_1] FOREIGN KEY([created_by])
REFERENCES [dbo].[user] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[card_status$card_status_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[card_status]'))
ALTER TABLE [dbo].[card_status] CHECK CONSTRAINT [card_status$card_status_ibfk_1]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[card_type$card_type_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[card_type]'))
ALTER TABLE [dbo].[card_type]  WITH NOCHECK ADD  CONSTRAINT [card_type$card_type_ibfk_1] FOREIGN KEY([created_by])
REFERENCES [dbo].[user] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[card_type$card_type_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[card_type]'))
ALTER TABLE [dbo].[card_type] CHECK CONSTRAINT [card_type$card_type_ibfk_1]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[card_type$card_type_module]') AND parent_object_id = OBJECT_ID(N'[dbo].[card_type]'))
ALTER TABLE [dbo].[card_type]  WITH NOCHECK ADD  CONSTRAINT [card_type$card_type_module] FOREIGN KEY([module])
REFERENCES [dbo].[module] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[card_type$card_type_module]') AND parent_object_id = OBJECT_ID(N'[dbo].[card_type]'))
ALTER TABLE [dbo].[card_type] CHECK CONSTRAINT [card_type$card_type_module]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[company$company_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[company]'))
ALTER TABLE [dbo].[company]  WITH NOCHECK ADD  CONSTRAINT [company$company_ibfk_1] FOREIGN KEY([created_by_user])
REFERENCES [dbo].[user] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[company$company_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[company]'))
ALTER TABLE [dbo].[company] CHECK CONSTRAINT [company$company_ibfk_1]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[company$company_ibfk_2]') AND parent_object_id = OBJECT_ID(N'[dbo].[company]'))
ALTER TABLE [dbo].[company]  WITH NOCHECK ADD  CONSTRAINT [company$company_ibfk_2] FOREIGN KEY([tenant_agent])
REFERENCES [dbo].[user] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[company$company_ibfk_2]') AND parent_object_id = OBJECT_ID(N'[dbo].[company]'))
ALTER TABLE [dbo].[company] CHECK CONSTRAINT [company$company_ibfk_2]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[company$company_ibfk_4]') AND parent_object_id = OBJECT_ID(N'[dbo].[company]'))
ALTER TABLE [dbo].[company]  WITH NOCHECK ADD  CONSTRAINT [company$company_ibfk_4] FOREIGN KEY([company_laf_preferences])
REFERENCES [dbo].[company_laf_preferences] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[company$company_ibfk_4]') AND parent_object_id = OBJECT_ID(N'[dbo].[company]'))
ALTER TABLE [dbo].[company] CHECK CONSTRAINT [company$company_ibfk_4]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[company$company_ibfk_5]') AND parent_object_id = OBJECT_ID(N'[dbo].[company]'))
ALTER TABLE [dbo].[company]  WITH NOCHECK ADD  CONSTRAINT [company$company_ibfk_5] FOREIGN KEY([logo])
REFERENCES [dbo].[photo] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[company$company_ibfk_5]') AND parent_object_id = OBJECT_ID(N'[dbo].[company]'))
ALTER TABLE [dbo].[company] CHECK CONSTRAINT [company$company_ibfk_5]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[files_folders_fk]') AND parent_object_id = OBJECT_ID(N'[dbo].[files]'))
ALTER TABLE [dbo].[files]  WITH CHECK ADD  CONSTRAINT [files_folders_fk] FOREIGN KEY([folder_id])
REFERENCES [dbo].[folders] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[files_folders_fk]') AND parent_object_id = OBJECT_ID(N'[dbo].[files]'))
ALTER TABLE [dbo].[files] CHECK CONSTRAINT [files_folders_fk]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[files_user_fk]') AND parent_object_id = OBJECT_ID(N'[dbo].[files]'))
ALTER TABLE [dbo].[files]  WITH CHECK ADD  CONSTRAINT [files_user_fk] FOREIGN KEY([user_id])
REFERENCES [dbo].[user] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[files_user_fk]') AND parent_object_id = OBJECT_ID(N'[dbo].[files]'))
ALTER TABLE [dbo].[files] CHECK CONSTRAINT [files_user_fk]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[folders_user_fk]') AND parent_object_id = OBJECT_ID(N'[dbo].[folders]'))
ALTER TABLE [dbo].[folders]  WITH CHECK ADD  CONSTRAINT [folders_user_fk] FOREIGN KEY([user_id])
REFERENCES [dbo].[user] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[folders_user_fk]') AND parent_object_id = OBJECT_ID(N'[dbo].[folders]'))
ALTER TABLE [dbo].[folders] CHECK CONSTRAINT [folders_user_fk]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[helpdesk$helpdesk_helpdesk_group]') AND parent_object_id = OBJECT_ID(N'[dbo].[helpdesk]'))
ALTER TABLE [dbo].[helpdesk]  WITH NOCHECK ADD  CONSTRAINT [helpdesk$helpdesk_helpdesk_group] FOREIGN KEY([helpdesk_group_id])
REFERENCES [dbo].[helpdesk_group] ([id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[helpdesk$helpdesk_helpdesk_group]') AND parent_object_id = OBJECT_ID(N'[dbo].[helpdesk]'))
ALTER TABLE [dbo].[helpdesk] CHECK CONSTRAINT [helpdesk$helpdesk_helpdesk_group]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[password_change_request$user_password_change_request_user_id]') AND parent_object_id = OBJECT_ID(N'[dbo].[password_change_request]'))
ALTER TABLE [dbo].[password_change_request]  WITH NOCHECK ADD  CONSTRAINT [password_change_request$user_password_change_request_user_id] FOREIGN KEY([user_id])
REFERENCES [dbo].[user] ([id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[password_change_request$user_password_change_request_user_id]') AND parent_object_id = OBJECT_ID(N'[dbo].[password_change_request]'))
ALTER TABLE [dbo].[password_change_request] CHECK CONSTRAINT [password_change_request$user_password_change_request_user_id]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[roles$roles_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[roles]'))
ALTER TABLE [dbo].[roles]  WITH NOCHECK ADD  CONSTRAINT [roles$roles_ibfk_1] FOREIGN KEY([created_by])
REFERENCES [dbo].[user] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[roles$roles_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[roles]'))
ALTER TABLE [dbo].[roles] CHECK CONSTRAINT [roles$roles_ibfk_1]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[tenant$fk_tenant_company1]') AND parent_object_id = OBJECT_ID(N'[dbo].[tenant]'))
ALTER TABLE [dbo].[tenant]  WITH NOCHECK ADD  CONSTRAINT [tenant$fk_tenant_company1] FOREIGN KEY([id])
REFERENCES [dbo].[company] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[tenant$fk_tenant_company1]') AND parent_object_id = OBJECT_ID(N'[dbo].[tenant]'))
ALTER TABLE [dbo].[tenant] CHECK CONSTRAINT [tenant$fk_tenant_company1]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[tenant_contact$fk_tenant_contact_tenant1]') AND parent_object_id = OBJECT_ID(N'[dbo].[tenant_contact]'))
ALTER TABLE [dbo].[tenant_contact]  WITH NOCHECK ADD  CONSTRAINT [tenant_contact$fk_tenant_contact_tenant1] FOREIGN KEY([tenant])
REFERENCES [dbo].[tenant] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[tenant_contact$fk_tenant_contact_tenant1]') AND parent_object_id = OBJECT_ID(N'[dbo].[tenant_contact]'))
ALTER TABLE [dbo].[tenant_contact] CHECK CONSTRAINT [tenant_contact$fk_tenant_contact_tenant1]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[user$user_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[user]'))
ALTER TABLE [dbo].[user]  WITH NOCHECK ADD  CONSTRAINT [user$user_ibfk_1] FOREIGN KEY([role])
REFERENCES [dbo].[roles] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[user$user_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[user]'))
ALTER TABLE [dbo].[user] CHECK CONSTRAINT [user$user_ibfk_1]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[user$user_ibfk_2]') AND parent_object_id = OBJECT_ID(N'[dbo].[user]'))
ALTER TABLE [dbo].[user]  WITH NOCHECK ADD  CONSTRAINT [user$user_ibfk_2] FOREIGN KEY([user_type])
REFERENCES [dbo].[user_type] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[user$user_ibfk_2]') AND parent_object_id = OBJECT_ID(N'[dbo].[user]'))
ALTER TABLE [dbo].[user] CHECK CONSTRAINT [user$user_ibfk_2]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[user$user_ibfk_3]') AND parent_object_id = OBJECT_ID(N'[dbo].[user]'))
ALTER TABLE [dbo].[user]  WITH NOCHECK ADD  CONSTRAINT [user$user_ibfk_3] FOREIGN KEY([user_status])
REFERENCES [dbo].[user_status] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[user$user_ibfk_3]') AND parent_object_id = OBJECT_ID(N'[dbo].[user]'))
ALTER TABLE [dbo].[user] CHECK CONSTRAINT [user$user_ibfk_3]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[user$user_ibfk_4]') AND parent_object_id = OBJECT_ID(N'[dbo].[user]'))
ALTER TABLE [dbo].[user]  WITH NOCHECK ADD  CONSTRAINT [user$user_ibfk_4] FOREIGN KEY([company])
REFERENCES [dbo].[company] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[user$user_ibfk_4]') AND parent_object_id = OBJECT_ID(N'[dbo].[user]'))
ALTER TABLE [dbo].[user] CHECK CONSTRAINT [user$user_ibfk_4]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[user$user_ibfk_5]') AND parent_object_id = OBJECT_ID(N'[dbo].[user]'))
ALTER TABLE [dbo].[user]  WITH NOCHECK ADD  CONSTRAINT [user$user_ibfk_5] FOREIGN KEY([created_by])
REFERENCES [dbo].[user] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[user$user_ibfk_5]') AND parent_object_id = OBJECT_ID(N'[dbo].[user]'))
ALTER TABLE [dbo].[user] CHECK CONSTRAINT [user$user_ibfk_5]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[user$user_ibfk_7]') AND parent_object_id = OBJECT_ID(N'[dbo].[user]'))
ALTER TABLE [dbo].[user]  WITH NOCHECK ADD  CONSTRAINT [user$user_ibfk_7] FOREIGN KEY([tenant_agent])
REFERENCES [dbo].[user] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[user$user_ibfk_7]') AND parent_object_id = OBJECT_ID(N'[dbo].[user]'))
ALTER TABLE [dbo].[user] CHECK CONSTRAINT [user$user_ibfk_7]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[user_status$user_status_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[user_status]'))
ALTER TABLE [dbo].[user_status]  WITH NOCHECK ADD  CONSTRAINT [user_status$user_status_ibfk_1] FOREIGN KEY([created_by])
REFERENCES [dbo].[user] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[user_status$user_status_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[user_status]'))
ALTER TABLE [dbo].[user_status] CHECK CONSTRAINT [user_status$user_status_ibfk_1]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[user_type$user_type_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[user_type]'))
ALTER TABLE [dbo].[user_type]  WITH NOCHECK ADD  CONSTRAINT [user_type$user_type_ibfk_1] FOREIGN KEY([created_by])
REFERENCES [dbo].[user] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[user_type$user_type_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[user_type]'))
ALTER TABLE [dbo].[user_type] CHECK CONSTRAINT [user_type$user_type_ibfk_1]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[user_workstation$user_workstation_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[user_workstation]'))
ALTER TABLE [dbo].[user_workstation]  WITH NOCHECK ADD  CONSTRAINT [user_workstation$user_workstation_ibfk_1] FOREIGN KEY([workstation])
REFERENCES [dbo].[workstation] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[user_workstation$user_workstation_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[user_workstation]'))
ALTER TABLE [dbo].[user_workstation] CHECK CONSTRAINT [user_workstation$user_workstation_ibfk_1]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[user_workstation$user_workstation_ibfk_2]') AND parent_object_id = OBJECT_ID(N'[dbo].[user_workstation]'))
ALTER TABLE [dbo].[user_workstation]  WITH NOCHECK ADD  CONSTRAINT [user_workstation$user_workstation_ibfk_2] FOREIGN KEY([created_by])
REFERENCES [dbo].[user] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[user_workstation$user_workstation_ibfk_2]') AND parent_object_id = OBJECT_ID(N'[dbo].[user_workstation]'))
ALTER TABLE [dbo].[user_workstation] CHECK CONSTRAINT [user_workstation$user_workstation_ibfk_2]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit$visit_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit]'))
ALTER TABLE [dbo].[visit]  WITH NOCHECK ADD  CONSTRAINT [visit$visit_ibfk_1] FOREIGN KEY([card])
REFERENCES [dbo].[card_generated] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit$visit_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit]'))
ALTER TABLE [dbo].[visit] CHECK CONSTRAINT [visit$visit_ibfk_1]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit$visit_ibfk_10]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit]'))
ALTER TABLE [dbo].[visit]  WITH NOCHECK ADD  CONSTRAINT [visit$visit_ibfk_10] FOREIGN KEY([tenant_agent])
REFERENCES [dbo].[user] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit$visit_ibfk_10]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit]'))
ALTER TABLE [dbo].[visit] CHECK CONSTRAINT [visit$visit_ibfk_10]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit$visit_ibfk_11]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit]'))
ALTER TABLE [dbo].[visit]  WITH NOCHECK ADD  CONSTRAINT [visit$visit_ibfk_11] FOREIGN KEY([card_type])
REFERENCES [dbo].[card_type] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit$visit_ibfk_11]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit]'))
ALTER TABLE [dbo].[visit] CHECK CONSTRAINT [visit$visit_ibfk_11]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit$visit_ibfk_12]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit]'))
ALTER TABLE [dbo].[visit]  WITH NOCHECK ADD  CONSTRAINT [visit$visit_ibfk_12] FOREIGN KEY([visit_status])
REFERENCES [dbo].[visit_status] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit$visit_ibfk_12]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit]'))
ALTER TABLE [dbo].[visit] CHECK CONSTRAINT [visit$visit_ibfk_12]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit$visit_ibfk_13]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit]'))
ALTER TABLE [dbo].[visit]  WITH NOCHECK ADD  CONSTRAINT [visit$visit_ibfk_13] FOREIGN KEY([workstation])
REFERENCES [dbo].[workstation] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit$visit_ibfk_13]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit]'))
ALTER TABLE [dbo].[visit] CHECK CONSTRAINT [visit$visit_ibfk_13]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit$visit_ibfk_3]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit]'))
ALTER TABLE [dbo].[visit]  WITH NOCHECK ADD  CONSTRAINT [visit$visit_ibfk_3] FOREIGN KEY([reason])
REFERENCES [dbo].[visit_reason] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit$visit_ibfk_3]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit]'))
ALTER TABLE [dbo].[visit] CHECK CONSTRAINT [visit$visit_ibfk_3]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit$visit_ibfk_4]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit]'))
ALTER TABLE [dbo].[visit]  WITH NOCHECK ADD  CONSTRAINT [visit$visit_ibfk_4] FOREIGN KEY([visitor_type])
REFERENCES [dbo].[visitor_type] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit$visit_ibfk_4]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit]'))
ALTER TABLE [dbo].[visit] CHECK CONSTRAINT [visit$visit_ibfk_4]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit$visit_ibfk_5]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit]'))
ALTER TABLE [dbo].[visit]  WITH NOCHECK ADD  CONSTRAINT [visit$visit_ibfk_5] FOREIGN KEY([visitor_status])
REFERENCES [dbo].[visitor_status] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit$visit_ibfk_5]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit]'))
ALTER TABLE [dbo].[visit] CHECK CONSTRAINT [visit$visit_ibfk_5]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit$visit_ibfk_7]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit]'))
ALTER TABLE [dbo].[visit]  WITH NOCHECK ADD  CONSTRAINT [visit$visit_ibfk_7] FOREIGN KEY([patient])
REFERENCES [dbo].[patient] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit$visit_ibfk_7]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit]'))
ALTER TABLE [dbo].[visit] CHECK CONSTRAINT [visit$visit_ibfk_7]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit$visit_ibfk_8]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit]'))
ALTER TABLE [dbo].[visit]  WITH NOCHECK ADD  CONSTRAINT [visit$visit_ibfk_8] FOREIGN KEY([created_by])
REFERENCES [dbo].[user] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit$visit_ibfk_8]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit]'))
ALTER TABLE [dbo].[visit] CHECK CONSTRAINT [visit$visit_ibfk_8]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit_reason$visit_reason_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit_reason]'))
ALTER TABLE [dbo].[visit_reason]  WITH NOCHECK ADD  CONSTRAINT [visit_reason$visit_reason_ibfk_1] FOREIGN KEY([created_by])
REFERENCES [dbo].[user] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit_reason$visit_reason_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit_reason]'))
ALTER TABLE [dbo].[visit_reason] CHECK CONSTRAINT [visit_reason$visit_reason_ibfk_1]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit_reason$visit_reason_ibfk_3]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit_reason]'))
ALTER TABLE [dbo].[visit_reason]  WITH NOCHECK ADD  CONSTRAINT [visit_reason$visit_reason_ibfk_3] FOREIGN KEY([tenant_agent])
REFERENCES [dbo].[user] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit_reason$visit_reason_ibfk_3]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit_reason]'))
ALTER TABLE [dbo].[visit_reason] CHECK CONSTRAINT [visit_reason$visit_reason_ibfk_3]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit_status$visit_status_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit_status]'))
ALTER TABLE [dbo].[visit_status]  WITH NOCHECK ADD  CONSTRAINT [visit_status$visit_status_ibfk_1] FOREIGN KEY([created_by])
REFERENCES [dbo].[user] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visit_status$visit_status_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[visit_status]'))
ALTER TABLE [dbo].[visit_status] CHECK CONSTRAINT [visit_status$visit_status_ibfk_1]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$contact_country_fk]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor]  WITH NOCHECK ADD  CONSTRAINT [visitor$contact_country_fk] FOREIGN KEY([contact_country])
REFERENCES [dbo].[country] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$contact_country_fk]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor] CHECK CONSTRAINT [visitor$contact_country_fk]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$identification_country_fk]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor]  WITH NOCHECK ADD  CONSTRAINT [visitor$identification_country_fk] FOREIGN KEY([identification_country_issued])
REFERENCES [dbo].[country] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$identification_country_fk]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor] CHECK CONSTRAINT [visitor$identification_country_fk]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$visitor_card_status_fk]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor]  WITH NOCHECK ADD  CONSTRAINT [visitor$visitor_card_status_fk] FOREIGN KEY([visitor_card_status])
REFERENCES [dbo].[visitor_card_status] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$visitor_card_status_fk]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor] CHECK CONSTRAINT [visitor$visitor_card_status_fk]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$visitor_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor]  WITH NOCHECK ADD  CONSTRAINT [visitor$visitor_ibfk_1] FOREIGN KEY([visitor_type])
REFERENCES [dbo].[visitor_type] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$visitor_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor] CHECK CONSTRAINT [visitor$visitor_ibfk_1]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$visitor_ibfk_2]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor]  WITH NOCHECK ADD  CONSTRAINT [visitor$visitor_ibfk_2] FOREIGN KEY([visitor_status])
REFERENCES [dbo].[visitor_status] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$visitor_ibfk_2]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor] CHECK CONSTRAINT [visitor$visitor_ibfk_2]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$visitor_ibfk_3]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor]  WITH NOCHECK ADD  CONSTRAINT [visitor$visitor_ibfk_3] FOREIGN KEY([created_by])
REFERENCES [dbo].[user] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$visitor_ibfk_3]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor] CHECK CONSTRAINT [visitor$visitor_ibfk_3]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$visitor_ibfk_5]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor]  WITH NOCHECK ADD  CONSTRAINT [visitor$visitor_ibfk_5] FOREIGN KEY([tenant_agent])
REFERENCES [dbo].[user] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$visitor_ibfk_5]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor] CHECK CONSTRAINT [visitor$visitor_ibfk_5]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$visitor_ibfk_6]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor]  WITH NOCHECK ADD  CONSTRAINT [visitor$visitor_ibfk_6] FOREIGN KEY([role])
REFERENCES [dbo].[roles] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$visitor_ibfk_6]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor] CHECK CONSTRAINT [visitor$visitor_ibfk_6]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$visitor_ibfk_7]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor]  WITH NOCHECK ADD  CONSTRAINT [visitor$visitor_ibfk_7] FOREIGN KEY([company])
REFERENCES [dbo].[company] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$visitor_ibfk_7]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor] CHECK CONSTRAINT [visitor$visitor_ibfk_7]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$visitor_ibfk_8]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor]  WITH NOCHECK ADD  CONSTRAINT [visitor$visitor_ibfk_8] FOREIGN KEY([vehicle])
REFERENCES [dbo].[vehicle] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$visitor_ibfk_8]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor] CHECK CONSTRAINT [visitor$visitor_ibfk_8]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$visitor_ibfk_9]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor]  WITH NOCHECK ADD  CONSTRAINT [visitor$visitor_ibfk_9] FOREIGN KEY([photo])
REFERENCES [dbo].[photo] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$visitor_ibfk_9]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor] CHECK CONSTRAINT [visitor$visitor_ibfk_9]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$visitor_workstation_fk]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor]  WITH NOCHECK ADD  CONSTRAINT [visitor$visitor_workstation_fk] FOREIGN KEY([visitor_workstation])
REFERENCES [dbo].[workstation] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor$visitor_workstation_fk]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor]'))
ALTER TABLE [dbo].[visitor] CHECK CONSTRAINT [visitor$visitor_workstation_fk]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor_password_change_request_visitor_id]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor_password_change_request]'))
ALTER TABLE [dbo].[visitor_password_change_request]  WITH CHECK ADD  CONSTRAINT [visitor_password_change_request_visitor_id] FOREIGN KEY([visitor_id])
REFERENCES [dbo].[visitor] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor_password_change_request_visitor_id]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor_password_change_request]'))
ALTER TABLE [dbo].[visitor_password_change_request] CHECK CONSTRAINT [visitor_password_change_request_visitor_id]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor_type$visitor_type_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor_type]'))
ALTER TABLE [dbo].[visitor_type]  WITH NOCHECK ADD  CONSTRAINT [visitor_type$visitor_type_ibfk_1] FOREIGN KEY([created_by])
REFERENCES [dbo].[user] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor_type$visitor_type_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor_type]'))
ALTER TABLE [dbo].[visitor_type] CHECK CONSTRAINT [visitor_type$visitor_type_ibfk_1]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor_type_card_type_card_type_fk]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor_type_card_type]'))
ALTER TABLE [dbo].[visitor_type_card_type]  WITH CHECK ADD  CONSTRAINT [visitor_type_card_type_card_type_fk] FOREIGN KEY([card_type])
REFERENCES [dbo].[card_type] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor_type_card_type_card_type_fk]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor_type_card_type]'))
ALTER TABLE [dbo].[visitor_type_card_type] CHECK CONSTRAINT [visitor_type_card_type_card_type_fk]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor_type_card_type_tenant_fk]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor_type_card_type]'))
ALTER TABLE [dbo].[visitor_type_card_type]  WITH CHECK ADD  CONSTRAINT [visitor_type_card_type_tenant_fk] FOREIGN KEY([tenant])
REFERENCES [dbo].[tenant] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor_type_card_type_tenant_fk]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor_type_card_type]'))
ALTER TABLE [dbo].[visitor_type_card_type] CHECK CONSTRAINT [visitor_type_card_type_tenant_fk]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor_type_card_type_visitor_type_fk]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor_type_card_type]'))
ALTER TABLE [dbo].[visitor_type_card_type]  WITH CHECK ADD  CONSTRAINT [visitor_type_card_type_visitor_type_fk] FOREIGN KEY([visitor_type])
REFERENCES [dbo].[visitor_type] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[visitor_type_card_type_visitor_type_fk]') AND parent_object_id = OBJECT_ID(N'[dbo].[visitor_type_card_type]'))
ALTER TABLE [dbo].[visitor_type_card_type] CHECK CONSTRAINT [visitor_type_card_type_visitor_type_fk]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[workstation$workstation_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[workstation]'))
ALTER TABLE [dbo].[workstation]  WITH NOCHECK ADD  CONSTRAINT [workstation$workstation_ibfk_1] FOREIGN KEY([created_by])
REFERENCES [dbo].[user] ([id])
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[workstation$workstation_ibfk_1]') AND parent_object_id = OBJECT_ID(N'[dbo].[workstation]'))
ALTER TABLE [dbo].[workstation] CHECK CONSTRAINT [workstation$workstation_ibfk_1]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[workstation_card_type$workstation_card_type_card_type]') AND parent_object_id = OBJECT_ID(N'[dbo].[workstation_card_type]'))
ALTER TABLE [dbo].[workstation_card_type]  WITH NOCHECK ADD  CONSTRAINT [workstation_card_type$workstation_card_type_card_type] FOREIGN KEY([card_type])
REFERENCES [dbo].[card_type] ([id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[workstation_card_type$workstation_card_type_card_type]') AND parent_object_id = OBJECT_ID(N'[dbo].[workstation_card_type]'))
ALTER TABLE [dbo].[workstation_card_type] CHECK CONSTRAINT [workstation_card_type$workstation_card_type_card_type]
GO
IF NOT EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[workstation_card_type$workstation_card_type_workstation]') AND parent_object_id = OBJECT_ID(N'[dbo].[workstation_card_type]'))
ALTER TABLE [dbo].[workstation_card_type]  WITH NOCHECK ADD  CONSTRAINT [workstation_card_type$workstation_card_type_workstation] FOREIGN KEY([workstation])
REFERENCES [dbo].[workstation] ([id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
IF  EXISTS (SELECT * FROM sys.foreign_keys WHERE object_id = OBJECT_ID(N'[dbo].[workstation_card_type$workstation_card_type_workstation]') AND parent_object_id = OBJECT_ID(N'[dbo].[workstation_card_type]'))
ALTER TABLE [dbo].[workstation_card_type] CHECK CONSTRAINT [workstation_card_type$workstation_card_type_workstation]
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'access_tokens', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.access_tokens' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'access_tokens'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'audit_trail', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.audit_trail' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'audit_trail'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'card_generated', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.card_generated' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'card_generated'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'card_status', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.card_status' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'card_status'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'card_type', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.card_type' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'card_type'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'cardstatus_convert', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.cardstatus_convert' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'cardstatus_convert'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'company', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.company' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'company'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'company_laf_preferences', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.company_laf_preferences' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'company_laf_preferences'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'company_type', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.company_type' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'company_type'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'country', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.country' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'country'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'cvms_kiosk', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.cvms_kiosk' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'cvms_kiosk'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'helpdesk', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.helpdesk' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'helpdesk'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'helpdesk_group', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.helpdesk_group' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'helpdesk_group'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'import_hosts', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.import_hosts' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'import_hosts'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'import_visitor', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.import_visitor' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'import_visitor'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'license_details', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.license_details' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'license_details'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'module', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.module' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'module'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'notification', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.notification' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'notification'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'password_change_request', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.password_change_request' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'password_change_request'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'patient', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.patient' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'patient'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'photo', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.photo' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'photo'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'reasons', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.reasons' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'reasons'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'reset_history', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.reset_history' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'reset_history'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'roles', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.roles' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'roles'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'tbl_migration', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.tbl_migration' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'tbl_migration'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'tenant', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.tenant' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'tenant'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'tenant_contact', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.tenant_contact' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'tenant_contact'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'timezone', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.timezone' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'timezone'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'user', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.`user`' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'user'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'user_notification', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.user_notification' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'user_notification'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'user_status', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.user_status' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'user_status'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'user_type', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.user_type' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'user_type'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'user_workstation', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.user_workstation' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'user_workstation'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'vehicle', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.vehicle' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'vehicle'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'visit', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.visit' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'visit'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'visit_reason', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.visit_reason' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'visit_reason'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'visit_status', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.visit_status' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'visit_status'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'visitor', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.visitor' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'visitor'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'visitor_card_status', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.visitor_card_status' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'visitor_card_status'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'visitor_status', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.visitor_status' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'visitor_status'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'visitor_type', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.visitor_type' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'visitor_type'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'workstation', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.workstation' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'workstation'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'workstation_card_type', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.workstation_card_type' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'workstation_card_type'
GO
IF NOT EXISTS (SELECT * FROM ::fn_listextendedproperty(N'MS_SSMA_SOURCE' , N'SCHEMA',N'dbo', N'TABLE',N'yiisession', NULL,NULL))
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.yiisession' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'yiisession'
GO

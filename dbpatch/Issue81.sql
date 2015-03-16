ALTER TABLE `card_generated` DROP COLUMN `card_code`; 
ALTER TABLE `card_generated` ADD COLUMN `company_code` VARCHAR(3) DEFAULT 0 NULL AFTER `tenant_agent`;
ALTER TABLE `card_generated` ADD COLUMN `card_count` BIGINT DEFAULT 0 NULL AFTER `company_code`;
ALTER TABLE `card_generated` ADD COLUMN `print_count` BIGINT DEFAULT 0 NULL AFTER `card_count`;


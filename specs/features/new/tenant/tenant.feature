#features/tenant.feature
Feature: Tenant
    Super administrator can manage Tenant

    Scenario: Create Tenant with valid data
        #1. Login
        Given I login with username as "superadmin@test.com" and password as "12345"
        Then I should see "Dashboard"

        #2. Create new Tenant
        Given I am on "index.php?r=tenant/create/&role=1"
            When I fill in "TenantForm_tenant_name" with "tenantname_1"
            And I fill in "TenantForm_tenant_code" with "zsx"
            And I fill in "TenantForm_first_name" with "TenantForm_first_name"
            And I fill in "TenantForm_last_name" with "TenantForm_last_name"
            And I fill in "TenantForm_email" with "TenantForm_email_test@test.com"
            And I fill in "TenantForm_contact_number" with "12345678"
            And I select "Internal" from "TenantForm_user_type"
            And I fill in "TenantForm_password" with "123456"
            And I fill in "TenantForm_cnf_password" with "123456"
            And I select "1" from "radiobtn"
            And I press "yt0"

        #3. Checking
        Given I am on "/index.php?r=tenant/admin"
        Then I should see "Tenant"
        And I should see "zsx"
        # Tenant also added as a company. Checking on company list
        Given I am on "/index.php?r=company/index"
        Then I should see "Companies"
        And I should see "tenantname_1"

    Scenario: Edit a Tenant
        #1. Login
        Given I login with username as "superadmin@test.com" and password as "12345"
        Then I should see "Dashboard"

        #2. Use existing Tenant to edit
        Given I am on "index.php?r=tenant/admin"
            Then I edit "tenantname_1"
            And I fill in "Company_name" with "new_tenantname_1"
            And I fill in "Company_code" with "ncd"
            And I fill in "Company_email_address" with "new_tenantname_email@test.com"
            And I fill in "Company_mobile_number" with "0000000"
            And I press "yt0"

        #3. Checking
        Given I am on "/index.php?r=tenant/admin"
        Then I should see "Tenant"
        And I should see "ncd"
        # Tenant also added as a company. Checking on company list
        Given I am on "/index.php?r=company/index"
        Then I should see "Companies"
        And I should see "new_tenantname_1"
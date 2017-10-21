#features/workstation.feature
Feature: Workstation
    Super admin user can a add/edit/delete workstation

    Scenario: Add workstation with valid data
        Given I login with username as "superadmin@test.com" and password as "12345"
        Given I am on "/index.php?r=workstation/create"
            When I select "Sydney Airport" from "Workstation_tenant"
            And I fill in "Name" with "tngoclinh20"
            And I press "Add"
        Then I should be on "/index.php?r=workstation/admin"
        Then I should see "tngoclinh20"

    Scenario: Add workstation with invalid data
        Given I login with username as "superadmin@test.com" and password as "12345"
        Given I am on "/index.php?r=workstation/create"
            And I press "Add"
        Then I should see "Please select a tenant"
        Then I should see "Please enter a name"

        Given I am on "/index.php?r=workstation/create"
            When I select "Sydney Airport" from "Workstation_tenant"
            And I press "Add"
        Then I should see "Please enter a name"

        Given I am on "/index.php?r=workstation/create"
            And I fill in "Name" with "tngoclinh20"
            And I press "Add"
        Then I should see "Please select a tenant"

    Scenario: Edit workstation with valid data
        Given I login with username as "superadmin@test.com" and password as "12345"
        Given I am on "index.php?r=workstation/admin"
        Then I go to workstation "tngoclinh20" edit page
            And I select "Kerry" from "Workstation_tenant"
            And I fill in "Name" with "tngoclinh20_edited"
            And I press "Save"
        Then I should be on "/index.php?r=workstation/admin"
        Then I should see "tngoclinh20_edited"

    Scenario: Edit workstation with invalid data
        Given I login with username as "superadmin@test.com" and password as "12345"
        Given I am on "index.php?r=workstation/admin"
        Then I go to workstation "tngoclinh20_edited" edit page
            And I fill in "Name" with " "
            And I press "Save"
        Then I should see "Please enter a name"

    @javascript
    Scenario: Delete workstation
        Given I login with username as "superadmin@test.com" and password as "12345"
        Then I wait for "Dashboard" to appear
        Given I am on "/index.php?r=workstation/admin"
            Then I wait for "tngoclinh20_edited" to appear
            Then I delete workstation "tngoclinh20_edited"
            Then I confirm the popup
        Given I am on "index.php?r=workstation/admin"
        Then I wait for "Workstation" to appear
        Then I should not see "tngoclinh20_edited"
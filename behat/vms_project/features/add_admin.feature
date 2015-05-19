#features/add_admin.feature
Feature: AddAdministrator
    Logged in user can Add Administrator

    Scenario: Add workstation with validated data
        Given I am logged in as "superadmin@test.com" with password "12345"
        Given I am on "index.php?r=user/create/&role=1"
            When I fill in "First Name" with "1First Name BehatAdminUser1"
            And I fill in "Last Name" with "First Name BehatAdminUser1"
            And I fill in "Email" with "Behat_test1@test.com"
            And I fill in "Mobile Number" with "21321321"
            And I select "Sydney Airport" from "User_company"
            And I select "Internal" from "User_user_type"
            And I fill in "Password" with "12345"
            And I fill in "Repeat Password" with "12345"
            And I press "Save"
        Then I should see "CVMS Users"
        Then I should see "1First Name BehatAdminUser1"
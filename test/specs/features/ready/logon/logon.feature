#features/logon.feature
Feature: Logon
	Inorder to access the application
	As a website user
	I need to authenticate with my credentials

	@javascript
	Scenario: Opening the logon page
		Given I am on the login page

    @javascript
    Scenario: Logging in as a Super Administrator
		Given I am on "/index.php"
        And I create a tenant
		When I log in as a Super Administrator
        Then I should see "Administration" appear

	@javascript
	Scenario: Logging as Issuing Body Administrator
        Given I am on "/index.php"
		And I create a tenant
		When I log in as an Issuing Body Administrator
		Then I should see "Administration" appear

	@javascript
	Scenario: Logging as Airport Operator
		Given I am on "/index.php"
		And I create a tenant
		When I log in as an Airport Operator
		Then I should see "Dashboard" appear
		And I should not see "Administration"

	@javascript
	Scenario: Logging as Agent Airport Administrator
		Given I am on "/index.php"
		And I create a tenant
		When I log in as an Agent Airport Administrator
		Then I should see "Administration" appear

	@javascript
	Scenario: Logging as Agent Airport Operator
		Given I am on "/index.php"
		And I create a tenant
		When I log in as an Agent Airport Operator
		Then I should see "Dashboard" appear
        And I should not see "Administration"


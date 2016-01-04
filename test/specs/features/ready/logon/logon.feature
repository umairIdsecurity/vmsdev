#features/logon.feature
Feature: Logon
	Inorder to access the application
	As a website user
	I need to authenticate with my credentials

    @javascript
    Scenario: Logging on with the correct credentials using feature function
      Given I login with username as "superadmin@test.com" and password as "12345"

    Scenario: Logging on with the correct credentials
        Given I am on "/index.php"
		When I fill in "Username or Email" with "superadmin@test.com"
		And I fill in "Password" with "12345"
	  	And I select "Kalgoorlie-Boulder Airport" from "LoginForm[tenant]"
		And I press "Login"
		Then I should see "Administration"
        Then  I logout
#
#	Scenario: Logging on with the incorrect credentials
#		Given I am on "/index.php"
#		When I fill in "Username or Email" with "superadmin@test.com"
#		And I fill in "Password" with "22222"
#		And I press "Login"
#		Then I should see "Incorrect username or password"
#

		

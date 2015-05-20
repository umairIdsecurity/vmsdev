#features/logon.feature
Feature: Logon
	Inorder to access the application
	As a website user
	I need to authenticate with my credentials
	
	Scenario: Logging on with the correct credentials
		Given I am on "/index.php"
		When I fill in "Username or Email" with "superadmin@test.com"
		And I fill in "Password" with "12345"
		And I press "Login"
		Then I should see "Dashboard"

	Scenario: Logging on with the incorrect credentials
		Given I am on "/index.php"
		When I fill in "Username or Email" with "superadmin@test.com"
		And I fill in "Password" with "22222"
		And I press "Login"
		Then I should see "Incorrect username or password"
		
	Scenario: Clicked Forgot Password Link
		Given I am on "/index.php"
		When I follow "Forgot password?"
		And I fill in "Email" with "superadmin@test.com"
		And I press "Reset"
		Then I should be on "/index.php?r=site/login"
		And I should see "Please check your email for reset password instructions"
		
		
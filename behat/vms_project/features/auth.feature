#features/auth.feature
Feature: Auth
    To acccess the website, user must provide correct username/password
    Only logged user can Logout

    Scenario: Login/Logout with correct username/password
        Given I am on "/index.php"
            When I fill in "Username or Email" with "superadmin@test.com"
            And I fill in "Password" with "12345"
            And I press "Login"
        Then I should see "Logged in as Super Administrator"
        When I follow "Log Out"
            Then I should see "Login"

    Scenario: Login with incorrect username/password
        Given I am on "/index.php"
            When I fill in "Username or Email" with "superadmin@test.com"
            And I fill in "Password" with "''''12345"
            And I press "Login"
        Then I should see "Incorrect username or password."
        Then I should not see "Log Out"

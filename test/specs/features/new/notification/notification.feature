#features/notification.feature
Feature: Notification
    Super administrator create and send to other users a Notification
    A user recieve notification message from Super administrator.

    Scenario: Super administrator create/edit notification
        #1. Login
        Given I login with username as "superadmin@test.com" and password as "12345"
        Then I should see "Dashboard"

        #2. Create new Notification
        Then I create new notification with subject as "Notification test subject1" and message as "Notification test message1"

        #3. Checking
        Then I should see "Manage Notifications"
        And I should see "Notification test subject1"

        #4. Edit
        Then I edit notification "Notification test subject1" with subject as "Notification test subject1 edited" and message as "Notification test message1 edited"
        Then I am on "/index.php?r=notifications/admin"
        Then I should see "Manage Notifications"
        And I should see "Notification test subject1 edited"

    Scenario: A user recieve notification message from Super administrator.
        # 1. Login
        Given I login with username as "superadmin@test.com" and password as "12345"
        Then I should see "Dashboard"
        
        # 2. Create new Administrator
        Given I am on "/index.php?r=user/create/&role=1"
            When I fill in "User_first_name" with "1First Name BehatAdminUser1"
            And I fill in "User_last_name" with "First Name BehatAdminUser1"
            And I fill in "User_email" with "behat_administrator_test@test.com"
            And I fill in "User_contact_number" with "21321321"
            And I select "Sydney Airport" from "User_company"
            And I select "Internal" from "User_user_type"
            And I fill in "User_password" with "123456"
            And I fill in "User_repeat_password" with "123456"
            When I select "1" from "User[password_option]"
            And I press "yt0"
        Then I should see "CVMS Users"
        Then I should see "1First Name BehatAdminUser1"

        # 3. Create new notification
        Then I create new notification with subject as "Notification test subject2" and message as "Notification test message2"
        Then I should see "Manage Notifications"
        And I should see "Notification test subject2"

        # 4. Logout from Superadmin
        Then I logout

        # 5. Login with created Administrator account at (3.)
        Given I login with username as "behat_administrator_test@test.com" and password as "123456"
        Given I am on "/index.php?r=dashboard/adminDashboard"
        Then I should see "Dashboard"

        # 6. Checking new Notifications
        Then I should see the new notifications alert
        Given I am on "/index.php?r=notifications/index"
        And I should see "Notification test subject2"
        # Checking message content
        And I view "Notification test subject2" in details
        Then I should see "Notification test message2"
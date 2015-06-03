#features/visitortype.feature
Feature: VisitorTypes
    Super admin can manage (add/edit/delete) Visitor Types


    Scenario: Add vistor type with valid data
        Given I login with username as "superadmin@test.com" and password as "12345"
        Given I am on "/index.php?r=visitorType/admin"
            Then I should not see "visitor_type1"
        Then I am on "/index.php?r=visitorType/create"
            And I fill in "VisitorType_name" with "visitor_type1"
            And I check "VisitorType_is_default_value"
            And I press "yt0"
        Then I should be on "/index.php?r=visitorType/admin"
        Then I should see "visitor_type1"


    Scenario: Add visitor type with invalid data
        Given I login with username as "superadmin@test.com" and password as "12345"
        Then I am on "/index.php?r=visitorType/create"
            And I fill in "VisitorType_name" with " "
            And I check "VisitorType_is_default_value"
            And I press "yt0"
        Then I should see "Please enter a name"


    Scenario: Edit visitor type with valid data
        Given I login with username as "superadmin@test.com" and password as "12345"
        Given I am on "/index.php?r=visitorType/admin"
            Then I should see "visitor_type1"
        Then I edit "visitor_type1"
            And I fill in "VisitorType_name" with "visitor_type1_edited"
            And I uncheck "VisitorType_is_default_value"
            And I press "yt0"
        Then I am on "/index.php?r=visitorType/admin"
        Then I should see "visitor_type1_edited"


    Scenario: Edit visitor type with valid data
        Given I login with username as "superadmin@test.com" and password as "12345"
        Given I am on "/index.php?r=visitorType/admin"
            Then I should see "visitor_type1_edited"
        Then I edit "visitor_type1_edited"
            And I fill in "VisitorType_name" with ""
            And I check "VisitorType_is_default_value"
            And I press "yt0"
        Then I should see "Please enter a name"
#features/vicprofile.feature
Feature: Edit AVMS User Bug Fixes
  This is for comfirm the bugs are fixed in Edit AVMS User

  @javascript
  Scenario: User password should persist after update
    Given I create a tenant
    And I log in as an Issuing Body Administrator
    And I am on "index.php?r=user/admin&vms=avms"
    And I should see "AVMS Users" appear
    And I fill in "Email Address" with "airportoperator@test.com"
    And I press the enter key
    And I should see "Edit" appear
    And I press "Edit"


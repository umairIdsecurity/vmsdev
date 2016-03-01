Feature: Visitor
  In order to manage visitors
  As an AVMS user
  I need to be able to create visitor profiles

  Scenario: Create an AVMS VIC Profile
    Given I create a tenant
    And I log in as an Issuing Body Administrator
    And I am on "/index.php?r=visitor/addvisitor&profile_type=VIC"
    And I fill in "Visitor_first_name" with "First"
    And I fill in "Visitor_middle_name" with "Middle"
    And I fill in "Visitor_last_name" with "Last"
    And I fill in date "date_of_birth" with "1-1-1970"
    And I fill in "Visitor_email" with "issuingbody@test.com"
    And I fill in "Visitor_contact_number" with "0418936555"
    And I fill in "Visitor_contact_street_no" with "1"
    And I fill in "Visitor_contact_street_name" with "Test"
    And I select "STREET" from "Visitor_contact_street_type"
    And I fill in "Visitor_contact_suburb" with "Testerville"
    And I select "Australia" from "Visitor_contact_country"
    And I select "Western Australia" from "Visitor[contact_state]"
    And I fill in "Visitor_contact_postcode" with "6000"
    And I select "Australia" from "Visitor_contact_country"






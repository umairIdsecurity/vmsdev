#features/vicprofile.feature
Feature: VIC Profile
    This is for comfirm the bugs are fixed in VIC Profile featute

    Scenario: CAVMS-145 Make Country of Issue 'Australia' as default
        #1. Login
        Given I login with username as "superadmin@test.com" and password as "12345"
        Then I should see "Dashboard"

        #2. Goto VIC profile create page
        Then I am on "/index.php?r=visitor/addvisitor&profile_type=VIC"

        #3. Checking
        Then I should see "Australia" in "Visitor_contact_country"
        And I should see "Australia" in "Visitor_identification_country_issued"


    Scenario: CAVMS-189 VIC Profile - Address Country
        #1. Login
        Given I login with username as "superadmin@test.com" and password as "12345"
        Then I should see "Dashboard"

        #2. Goto VIC profile create page
        Then I am on "/index.php?r=visitor/addvisitor&profile_type=VIC"

        #3. Checking
        Then I select "Vietnam" from "Visitor_contact_country"
        Then I select "Vietnam" from "Visitor_identification_country_issued"
        Then I should see "Vietnam" in "Visitor_contact_country"
        And I should see "Vietnam" in "Visitor_identification_country_issued"

    Scenario: CAVMS-220 VIC Issuing - Add VIC Profile and Log Visit - Add Postcode field
        #1. Login
        Given I login with username as "superadmin@test.com" and password as "12345"
        Then I should see "Dashboard"

        #2. Goto VIC profile create page
        Then I am on "/index.php?r=visitor/addvisitor&profile_type=VIC"

        #3. Checking
        Then I should see "Postcode"

    Scenario: CAVMS-180 Text change of Add Visitor Profile: VIC
        #1. Login
        Given I login with username as "superadmin@test.com" and password as "12345"
        Then I should see "Dashboard"

        #2. Goto VIC profile create page
        Then I am on "/index.php?r=visitor/addvisitor&profile_type=VIC"

        #3. Checking
        Then I should see "Applicant does not have one of the above identifications"
        Then I should not see "Alternative identifications One mus have a signature"
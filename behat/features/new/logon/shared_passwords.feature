#features/shared_passwords.feature
Feature: Shared Passwords
  In order to allow an individual to be both a user and a visitor and login with the same credentials
  As a User/Visitor
  I need to have my password synchronised between the users table and the visitors table


  Scenario: Logging on as a Visitor
    Given I create a tenant
    And I log in as an Issuing Body Administrator
    And I create a AVMS visitor
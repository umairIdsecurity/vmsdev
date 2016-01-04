#features/yii.feature
Feature: Test
  In order to user the framework
  As a behat test writer
  I need to run manage data

  @javascript
  Scenario: Create a test tenant
    Given I create a tenant

#features/yii.feature
Feature: Yii
  In order to manage application resources
  As a behat test writer
  I need to run yii console commands

  @javascript
  Scenario: Running a data integrity check
    Given I run a data integrity check

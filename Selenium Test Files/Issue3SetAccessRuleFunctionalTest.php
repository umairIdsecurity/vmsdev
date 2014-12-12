<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'BaseFunctionalTest.php';

include 'Issue3SuperAdminFunctionalTest.php';
$Issue3SuperAdminFunctionalTest = new Issue3SuperAdminFunctionalTest();

/**
 * Description of Issue3FunctionalTest
 *
 * @author Jeremiah
 */
class Issue3SetAccessRuleFunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://cvms.identitysecurity.info");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
        $this->Scenario2();
        $this->Scenario3();
    }

    /* Scenario 1 – Login as admin and remove access rule for operator@tes.com
      Expected Behavior
      -	Asser text  'workstation updated'

      Steps:
      1.	Go to http://cvms.identitysecurity.info
      2.	Type admin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click ‘Administration’
      6.	Click 'manage users' then click set access rule
      7.	type test Test operator in name field and operator@test.com in email field
      8.	click edit
      9.	check set primary button in first workstation
      10.	Click save
      11.	assert text workstation updated
     */

    function Scenario1() {
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Users");
        $this->waitForElementPresent("link=Set Access Rules");
        $this->click("link=Set Access Rules");
        $this->waitForElementPresent("id=19");
        $this->click("id=19");
        $this->waitForElementPresent("id=setPrimary10");
        $this->click("id=setPrimary10");
        $this->click("//label[@id='setPrimary10']");
        $this->click("id=btnSubmit");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Workstation updated.", $this->getText("css=div.flash-success"));
        $this->click("link=×");
    }

    /* Scenario 2 – Login as agent admin and remove access rule for agentoperator@test.com
      Expected Behavior
      -	Asser text  'workstation updated'

      Steps:
      1.	Go to http://cvms.identitysecurity.info
      2.	Type agentadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click ‘Administration’
      6.	Click 'manage users' then click set access rule
      7.	type test agentoperator in name field and agentoperator@test.com in email field
      8.	click edit
      9.	check 1st checkbox to uncheck all
      10.	Click save
      11.	assert text workstation updated
     */

    function Scenario2() {
        $username = 'agentadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Users");
        $this->waitForElementPresent("link=Set Access Rules");
        $this->click("link=Set Access Rules");
        $this->waitForElementPresent("id=20");
        $this->click("id=20");
        $this->waitForElementPresent("id=cbColumnAll");
        $this->click("id=cbColumnAll");
        $this->click("id=btnSubmit");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Workstation updated.", $this->getText("css=div.flash-success"));
        $this->click("link=×");
    }

    /* Scenario 3 – Login as superadmin and add access rule for operator@test.com and agentoperator@test.com
      Expected Behavior
      -	Asser text  'workstation updated'

      Steps:
      1.	Go to http://cvms.identitysecurity.info
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click ‘Administration’
      6.	Click 'manage users' then click set access rule
      7.	type test operator in name field and operator@test.com in email field
      8.	click edit
      9.	check 1st checkbox to check all
      10.	Click save
      11.	assert text workstation updated
      12.       Close modal
      13.       type test agentoperator in name field and agentoperator@test.com in email field
      14.       Click Edit
      15.       Check 1st checkbox to check all
      16.       Click save
      17.       Assert text workstation updated
     */

    function Scenario3() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Workstations");
        $this->waitForElementPresent("link=Add Workstation");
        $this->clickAndWait("link=Add Workstation");
        $this->type("id=Workstation_name", "Operator Workstation");
        $this->type("id=Workstation_location", "PAL");
        $this->type("id=Workstation_contact_name", "Person Name");
        $this->type("id=Workstation_contact_number", "09367941012");
        $this->type("id=Workstation_contact_email_address", "test@test.com");
        $this->select("id=Workstation_tenant", "label=Test admin");
        $this->clickAndWait("name=yt0");
        $this->click("link=Manage Users");
        $this->waitForElementPresent("link=Set Access Rules");
        $this->clickAndWait("link=Set Access Rules");
        $this->waitForElementPresent("id=19");
        $this->click("id=19");
        $this->waitForElementPresent("id=setPrimary11");
        $this->click("id=setPrimary11");
        $this->click("//label[@id='setPrimary11']");
        $this->click("id=cbColumn_0");
        $this->click("id=btnSubmit");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Workstation updated.", $this->getText("css=div.flash-success"));
        $this->click("link=×");
        
        $this->click("link=Manage Workstations");
        $this->waitForElementPresent("link=Add Workstation");
        $this->clickAndWait("link=Add Workstation");
        $this->type("id=Workstation_name", "Workstation Agent Operator");
        $this->type("id=Workstation_location", "MNL");
        $this->type("id=Workstation_contact_name", "Test Person");
        $this->type("id=Workstation_contact_number", "3585795");
        $this->type("id=Workstation_contact_email_address", "test@test.com");
        $this->select("id=Workstation_tenant", "label=Test admin");
        $this->waitForElementPresent("id=Workstation_tenant_agent");
        sleep(1);
        $this->select("id=Workstation_tenant_agent", "label=Test agentadmin");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Users");
        $this->waitForElementPresent("link=Set Access Rules");
        $this->clickAndWait("link=Set Access Rules");
        $this->waitForElementPresent("id=20");
        $this->click("id=20");
        $this->waitForElementPresent("id=setPrimary12");
        $this->click("id=setPrimary12");
        $this->click("//label[@id='setPrimary12']");
        $this->click("id=cbColumn_0");
        $this->click("id=btnSubmit");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Workstation updated.", $this->getText("css=div.flash-success"));
    }

}

?>
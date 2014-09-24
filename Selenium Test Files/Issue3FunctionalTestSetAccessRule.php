<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'BaseFunctionalTest.php';

include 'Issue3FunctionalTestSuperAdmin.php';
$Issue3FunctionalTestSuperAdmin = new Issue3FunctionalTestSuperAdmin();

/**
 * Description of Issue3FunctionalTest
 *
 * @author Jeremiah
 */
class Issue3FunctionalTestSetAccessRule extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://cvms.identitysecurity.info");
        
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
        $this->Scenario2();
        $this->addWorkstationForAdmin();
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
      7.	type test operator in name field and operator@test.com in email field
      8.	click edit
      9.	check 1st checkbox to check all
      10.	Click save
      11.	assert text workstation updated
     */

    function Scenario1() {
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Users");
        $this->click("link=Set Access Rules");
        $this->waitForPageToLoad("30000");
        $this->type("css=td > input[name=\"User[first_name]\"]", "Test Operator");
        $this->click("xpath=(//input[@name='User[email]'])[2]");
        $this->type("xpath=(//input[@name='User[email]'])[2]", "operator@test.com");
        $this->click("id=19");
        sleep(5);
        $this->click("id=cbColumn_all");
        $this->click("id=btnSubmit");
        $this->waitForPageToLoad("30000");
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
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Users");
        $this->click("link=Set Access Rules");
        $this->waitForPageToLoad("30000");
        $this->type("css=td > input[name=\"User[first_name]\"]", "Test agentOperator");
        $this->click("xpath=(//input[@name='User[email]'])[2]");
        sleep(5);
        $this->type("xpath=(//input[@name='User[email]'])[2]", "agentoperator@test.com");
        $this->click("id=20");
        sleep(5);
        $this->click("id=cbColumn_all");
        $this->click("id=btnSubmit");
        $this->waitForPageToLoad("30000");
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
        $this->click("link=Manage Users");
        $this->click("link=Set Access Rules");
        $this->waitForPageToLoad("30000");
        $this->type("css=td > input[name=\"User[first_name]\"]", "Test Operator");
        $this->click("xpath=(//input[@name='User[email]'])[2]");
        $this->type("xpath=(//input[@name='User[email]'])[2]", "operator@test.com");
        $this->click("id=19");
        sleep(5);
        $this->click("id=cbColumnAll");
        $this->click("id=btnSubmit");
        $this->waitForPageToLoad("30000");
        $this->click("link=×");
        sleep(5);
        $this->type("css=td > input[name=\"User[first_name]\"]", "Test AgentOperator");
        $this->click("xpath=(//input[@name='User[email]'])[2]");
        $this->type("xpath=(//input[@name='User[email]'])[2]", "agentoperator@test.com");
        sleep(5);
        $this->click("id=20");
        sleep(5);
        $this->click("id=cbColumnAll");
        $this->click("id=btnSubmit");
        $this->waitForPageToLoad("30000");
        $this->click("link=×");
    }

    function addWorkstationForAdmin() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Workstations");
        $this->click("link=Add Workstation");
        $this->waitForPageToLoad("30000");
        $this->type("id=Workstation_name", "Workstation 2");
        $this->type("id=Workstation_location", "Office");
        $this->type("id=Workstation_contact_name", "Test Person");
        $this->type("id=Workstation_contact_number", "1234-567");
        $this->type("id=Workstation_contact_email_address", "workstation2@test.com");
        $this->select("id=Workstation_tenant", "label=Test admin2");
        $this->type("id=Workstation_password", "12345");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
         }
}

?>
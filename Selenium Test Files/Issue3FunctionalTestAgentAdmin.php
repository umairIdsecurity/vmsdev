<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue3FunctionalTest
 *
 * @author Jeremiah
 */
class Issue3FunctionalTestAgentAdmin extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://localhost/");
    }

    function testAll() {
        $this->Scenario1();
        $this->Scenario2();
    }

    /* Scenario 1 – Login as agent admin and add agent operator
      Expected Behavior
      -	Asser text  agent operator and agentoperator2@test.com  in search role field

      Steps:
      1.	Go to localhost/vms
      2.	Type agentadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click ‘Administration’
      6.	Click ‘Add Agent Operator’
      7.	Verify field role is disabled
      8.	Verify company field is disabled
      9.	Fill up fields, use agentoperator2@test.com for email and 12345 for password
      10.	Click save
      11.	Wait for page to redirect in manage users
      12.	Type agentoperator2@test.com in email filter
      13.	Assert text agentoperator2@test.com
      14.	Assert text agent operator

     */

    function Scenario1() {
        $username = 'agentadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Users");
        $this->click("link=Add Agent Operator");
        $this->waitForPageToLoad("30000");
        $this->addUser("agentoperator2@test.com", "agentoperator2");
        $this->getDisabledRoleValue("7");

        $this->getDisabledCompanyValue("Test Company 1");
        $this->assertEquals("Workstation", $this->getText("id=User_workstation"));
        
        $this->click("id=submitBtn");
        $this->click("id=submitForm");
        $this->waitForPageToLoad("30000");
        $this->type("css=td > input[name=\"User[first_name]\"]", "test");
        $this->click("//td[2]/input");
        $this->type("//td[2]/input", "agentoperator2");
        $this->select("css=select[name=\"User[role]\"]", "label=Agent Operator");
        sleep(1);
        $this->assertEquals("Test", $this->getText("css=tr.odd > td"));
        $this->assertEquals("agentoperator2", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[2]"));
        
        $this->assertEquals("Displaying 1-1 of 1 result.", $this->getText("css=div.summary"));
    }

    /* Scenario 2 – Login as agent admin and add staff member
      Expected Behavior
      -	Asser text  staff member and staffmember3@test.com  in search role field

      Steps:
      1.	Go to localhost/vms
      2.	Type agentadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click ‘Administration’
      6.	Click ‘Add User’
      7.	Fill up fields, use staffmember3@test.com for email and 12345 for password
      8.	Select staff member in role field
      9.	Verify company field is disabled
      10.	Click save
      11.	Wait for page to redirect in manage users
      12.	Type staffmember3@test.com in email filter
      13.	Assert text staffmember3@test.com
      14.	Assert text staff member

     */

    function Scenario2() {
        $username = 'agentadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Users");
        $this->click("link=Add User");
        $this->waitForPageToLoad("30000");
        $this->addUser("staffmember3@test.com", "staffmember3");
        $this->select("id=User_role", "label=Staff Member");
        $this->getDisabledCompanyValue("Test Company 1");
        $this->click("id=submitBtn");
        $this->click("id=submitForm");
        $this->waitForPageToLoad("30000");
        $this->type("css=td > input[name=\"User[first_name]\"]", "Test");
        $this->click("//td[2]/input");
        $this->type("//td[2]/input", "staffmember3");
        $this->select("css=select[name=\"User[role]\"]", "label=Staff Member");
        sleep(1);
        $this->assertEquals("Test", $this->getText("css=tr.odd > td"));
        $this->assertEquals("staffmember3", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[2]"));
        $this->assertEquals("Staff Member", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[3]"));
        
        $this->assertEquals("Displaying 1-1 of 1 result.", $this->getText("css=div.summary"));
    }

}

?>
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
class Issue3AdminFunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*iexplore");
        $this->setBrowserUrl("http://dev.identitysecurity.info");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
        $this->Scenario2();
        $this->Scenario3();
        $this->Scenario4();
        $this->Scenario5();
    }

    /* Scenario 1 – Login as admin and add administrator
      Expected Behavior
      -	Asser text  ’administrator’ and admin2@test.com  in search role field

      Steps:
      1.	Go to localhost/vms
      2.	Type admin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click ‘Administration’
      6.	Click ‘Add Administrator’
      7.	Verify role field is disabled
      8.	Verify company field is disabled
      9.	Fill up fields, use admin2@test.com for email and 12345 for password
      10.	Click save
      11.	Wait for page to redirect in manage users
      12.	Type admin2@test.com in email filter
      13.	Assert text admin2@test.com
      14.	Assert text administrator
     */

    function Scenario1() {
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Users");
        $this->click("link=Add Administrator");
        $this->waitForPageToLoad("30000");
        $this->addUser("admin3@test.com", "admin3");
        $this->click("id=submitBtn");
        $this->click("id=submitForm");
        $this->waitForPageToLoad("30000");
        $this->type("css=td > input[name=\"User[first_name]\"]", "Test");
        $this->click("//td[2]/input");
        $this->type("//td[2]/input", "Admin3");
        $this->select("css=select[name=\"User[role]\"]", "label=Administrator");
        $this->select("css=select[name=\"User[user_type]\"]", "label=Internal");
        sleep(1);
        $this->assertEquals("Test", $this->getText("css=tr.odd > td"));
        $this->assertEquals("admin3", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[2]"));
        $this->assertEquals("Administrator", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[3]"));
        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Displaying 1-1 of 1 result." == $this->getText("css=div.summary"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Displaying 1-1 of 1 result.", $this->getText("css=div.summary"));
    }

    /* Scenario 2 – Login as admin and add agent administrator
      Expected Behavior
      -	Asser text  ’agent administrator’ and agentadmin2@test.com  in search role field

      Steps:
      1.	Go to localhost/vms
      2.	Type admin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click ‘Administration’
      6.	Click ‘Add Agent Administrator’
      7.	Verify role field is disabled
      8.	Fill up fields, use agentagentadmin2@test.com for email and 12345 for password
      9.	Choose test company1 in select company
      10.	Click save
      11.	Wait for page to redirect in manage users
      12.	Type agentadmin2@test.com in email filter
      13.	Assert text agentadmin2@test.com
      14.	Assert text agent administrator


     */

    function Scenario2() {
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Users");
        $this->click("link=Add Agent Administrator");
        $this->waitForPageToLoad("30000");
        $this->addUser("agentadmin2@test.com", "agentadmin2");
        $this->addCompany("Test Company 3", "testcompany3","TCC");
        $this->click("id=submitBtn");
        $this->click("id=submitForm");
        $this->waitForPageToLoad("30000");
        $this->type("css=td > input[name=\"User[first_name]\"]", "Test");
        $this->click("//td[2]/input");
        $this->type("name=User[last_name]", "agentadmin2");
        $this->select("css=select[name=\"User[role]\"]", "label=Agent Administrator");
        $this->select("css=select[name=\"User[user_type]\"]", "label=Internal");
        sleep(5);
        $this->assertEquals("Test", $this->getText("css=tr.odd > td"));
        $this->assertEquals("agentadmin2", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[2]"));
        $this->assertEquals("Agent Administrator", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[3]"));

        $this->assertEquals("Displaying 1-1 of 1 result.", $this->getText("css=div.summary"));
    }

    /*
      Scenario 3 – Login as admin and add operator
      Expected Behavior
      -	Asser text  operator and operator2@test.com  in search role field

      Steps:
      1.	Go to localhost/vms
      2.	Type admin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click ‘Administration’
      6.	Click ‘Add Operator’
      7.	Verify field role is disabled
      8.	Verify company field is disabled
      9.	Fill up fields, use operator2@test.com for email and 12345 for password
      10.	Click save
      11.	Wait for page to redirect in manage users
      12.	Type operator2@test.com in email filter
      13.	Assert text operator2@test.com
      14.	Assert text operator
     */

    function Scenario3() {
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Users");
        $this->click("link=Add Operator");
        $this->waitForPageToLoad("30000");
        $this->addUser("operator2@test.com", "operator2");
        $this->getDisabledRoleValue("8");
        $this->getDisabledCompanyValue("Test Company 1");
        $this->assertEquals("Workstation1", $this->getEval("window.document.getElementById(\"User_workstation\").options[window.document.getElementById(\"User_workstation\").selectedIndex].text"));

        $this->waitForElementPresent("id=submitBtn");
        $this->click("id=submitBtn");
        $this->click("id=submitForm");

        $this->waitForPageToLoad("30000");
        $this->type("css=td > input[name=\"User[first_name]\"]", "Test");
        $this->click("//td[2]/input");
        $this->type("//td[2]/input", "Operator2");
        $this->select("css=select[name=\"User[role]\"]", "label=Operator");
        sleep(1);
        $this->assertEquals("Test", $this->getText("css=tr.odd > td"));
        $this->assertEquals("operator2", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[2]"));
        $this->assertEquals("Operator", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[3]"));
        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Displaying 1-1 of 1 result." == $this->getText("css=div.summary"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Displaying 1-1 of 1 result.", $this->getText("css=div.summary"));
    }

    /* Scenario 4 – Login as admin and add staff member
      Expected Behavior
      -	Asser text  staff member and staffmember2@test.com  in search role field

      Steps:
      1.	Go to localhost/vms
      2.	Type admin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click ‘Administration’
      6.	Click ‘Add User’
      7.	Fill up fields, use staffmember2@test.com for email and 12345 for password
      8.	Select staff member in role field
      9.	Verify company field is disabled
      10.	Click save
      11.	Wait for page to redirect in manage users
      12.	Type staffmember2@test.com in email filter
      13.	Assert text staffmember2@test.com
      14.	Assert text staff member

     */

    function Scenario4() {
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Users");
        $this->click("link=Add User");
        $this->waitForPageToLoad("30000");
        $this->addUser("staffmember2@test.com", "staffmember2");
        $this->getDisabledCompanyValue("Test Company 1");
        $this->select("id=User_role", "label=Staff Member");

        $this->click("id=submitBtn");
        $this->click("id=submitForm");
        $this->waitForPageToLoad("30000");
        $this->type("css=td > input[name=\"User[first_name]\"]", "Test");
        $this->click("//td[2]/input");
        $this->type("//td[2]/input", "staffmember2");
        $this->select("css=select[name=\"User[role]\"]", "label=Staff Member");
        sleep(1);
        $this->assertEquals("Test", $this->getText("css=tr.odd > td"));
        $this->assertEquals("staffmember2", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[2]"));
        $this->assertEquals("Staff Member", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[3]"));
        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Displaying 1-1 of 1 result." == $this->getText("css=div.summary"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Displaying 1-1 of 1 result.", $this->getText("css=div.summary"));
    }

    /* Scenario 5 – Login as admin and add agent administrator with new company
      Expected Behavior
      -	Asser text  ’agent administrator’ and agentadmin3@test.com  in search role field

      Steps:
      1.	Go to localhost/vms
      2.	Type admin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click ‘Administration’ then click manage users
      6.	Click ‘Add Agent Administrator’
      7.	Fill up fields, use agentadmin3@test.com for email and 12345 for password
      8.	Click add company button
      9.	Fill up fields, set company name = test company 4
      10.	Click save in modal
      11.	Assert text Company Successfully added
      12.	Click close in modal
      13.	Assert company field text is test company 4
      14.	Click save
      15.	Wait for page to redirect in manage users
      16.	Type agentadmin3@test.com in email filter
      17.	Assert text agentadmin3@test.com
      18.	Assert text agent administrator
     */

    function Scenario5() {
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Users");
        $this->click("link=Add Agent Administrator");
        $this->waitForPageToLoad("30000");
        $this->addUser("agentadmin3@test.com", "agentadmin3");
        $this->waitForElementPresent("id=submitBtn");
        $this->addCompany("Test Company 4", "testcompany4","TCD");
        $this->waitForElementPresent("id=submitBtn");
        $this->click("id=submitBtn");
        $this->click("id=submitForm");
        $this->waitForPageToLoad("30000");
        $this->type("css=td > input[name=\"User[first_name]\"]", "Test");
        $this->click("//td[2]/input");
        $this->type("//td[2]/input", "agentadmin3");
        $this->select("css=select[name=\"User[role]\"]", "label=Agent Administrator");
        $this->select("css=select[name=\"User[user_type]\"]", "label=Internal");
        $this->waitForElementPresent("css=td > input[name=\"User[first_name]\"]");
        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Test" == $this->getText("css=tr.odd > td"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Test", $this->getText("css=tr.odd > td"));
        $this->assertEquals("agentadmin3", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[2]"));
        $this->assertEquals("Agent Administrator", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[3]"));
        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Displaying 1-1 of 1 result." == $this->getText("css=div.summary"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Displaying 1-1 of 1 result.", $this->getText("css=div.summary"));
    }

}

?>

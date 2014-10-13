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
class Issue3FunctionalTestSuperAdmin extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://cvms.identitysecurity.info");
        
    }

    function testAll() {
        $this->resetDb();
        $this->Scenario1();
        $this->Scenario2();
        $this->Scenario3();
        $this->Scenario4();
        $this->Scenario5();
        $this->Scenario6();
    }

    /* Scenario 1 – Login as super admin and add administrator
      Expected Behavior
      -	Asser text  ’administrator’ and admin@test.com  in search role field

      Steps:
      1.	Go to localhost/vms
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click ‘Administration’
      6.	Click ‘Add Administrator’
      7.	Fill up fields, use admin@test.com for email and 12345 for password
      8.	Choose test company1 in select company
      9.	Click save
      10.	Wait for page to redirect in manage users
      11.	Type admin@test.com in email filter
      12.	Assert text admin@test.com
      13.	Assert text administrator
     */

    public function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Users");
        $this->click("link=Add Administrator");
        $this->waitForPageToLoad("30000");
        $this->addUser("admin@test.com", "admin");
        $this->addCompany("Test Company 1", "testcompany");
        sleep(1);
        $this->waitForElementPresent("id=submitBtn");
        $this->click("id=submitBtn");
        $this->click("id=submitForm");
        $this->waitForPageToLoad("30000");
        sleep(1);
        $this->type("name=User[first_name]", "Test");
        $this->click("//td[2]/input");
        $this->type("name=User[last_name]", "Admin");
        $this->select("css=select[name=\"User[role]\"]", "label=Administrator");

        $this->select("css=select[name=\"User[user_type]\"]", "label=Internal");
        sleep(1);
        $this->assertEquals("Test", $this->getText("css=tr.odd > td"));
        $this->assertEquals("admin", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[2]"));
        $this->assertEquals("Administrator", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[3]"));
        $this->assertEquals("Displaying 1-1 of 1 result.", $this->getText("css=div.summary"));
    }

    /* Scenario 2 – Login as super admin and add agent administrator
      Expected Behavior
      -	Asser text  ’agent administrator’ and agentadmin@test.com  in search role field

      Steps:
      1.	Go to localhost/vms
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click ‘Administration’
      6.	Click ‘Add Agent Administrator’
      7.	Assert if tenant field is present
      8.	Fill up fields, use agentadmin@test.com for email and 12345 for password
      9.	Choose test company1 in select company
      10.	Click save
      11.	Wait for page to redirect in manage users
      12.	Type agentadmin@test.com in email filter
      13.	Assert text agentadmin@test.com
      14.	Assert text agent administrator

     */

    public function Scenario2() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Users");
        $this->click("link=Add Agent Administrator");
        $this->waitForPageToLoad("30000");
        $this->addUser("agentadmin@test.com", "agentadmin");
        $this->select("id=User_tenant", "label=Test admin");
        $this->waitForElementPresent("id=User_company");
        sleep(1);
        $this->click("id=submitBtn");
        $this->click("id=submitForm");
        $this->waitForPageToLoad("30000");
        $this->type("css=td > input[name=\"User[first_name]\"]", "Test");
        $this->click("//td[2]/input");
        $this->type("//td[2]/input", "agentadmin");
        $this->select("css=select[name=\"User[role]\"]", "label=Agent Administrator");
        sleep(1);
        $this->assertEquals("Test", $this->getText("css=tr.odd > td"));
        $this->assertEquals("agentadmin", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[2]"));
        $this->assertEquals("Agent Administrator", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[3]"));
        $this->assertEquals("Displaying 1-1 of 1 result.", $this->getText("css=div.summary"));
    }

    /*
      Scenario 3 – Login as super admin and add operator
      Expected Behavior
      -	Asser text  operator and operator@test.com  in search role field

      Steps:
      1.	Go to localhost/vms
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click ‘Administration’
      6.	Click ‘Add Operator’
      7.	Verify field role is disabled
      8.	Assert tenant field present
      9.	Verify company field is disabled
      10.	Fill up fields, use operator@test.com for email and 12345 for password
      11.	Click save
      12.	Wait for page to redirect in manage users
      13.	Type operator@test.com in email filter
      14.	Assert text operator@test.com
      15.	Assert text operator

     */

    public function Scenario3() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->clickAndWait("link=Manage Users");
        $this->clickAndWait("link=Add Operator");
        $this->addUser("operator@test.com", "operator");
        $this->getDisabledRoleValue("8");
        $this->select("id=User_tenant", "label=Test admin");
        sleep(1);
        $this->getDisabledCompanyValue("Test Company 1");
        $this->assertEquals("Workstation", $this->getEval("window.document.getElementById(\"User_workstation\").options[window.document.getElementById(\"User_workstation\").selectedIndex].text"));
    

        $this->click("id=submitBtn");
        $this->click("id=submitForm");
        $this->waitForPageToLoad("30000");
        $this->type("css=td > input[name=\"User[first_name]\"]", "Test");
        sleep(1);
        $this->type("name=User[last_name]", "Operator");
        $this->select("css=select[name=\"User[role]\"]", "label=Operator");
        $this->waitForElementPresent("css=td > input[name=\"User[first_name]\"]");
        sleep(1);
        $this->assertEquals("Test", $this->getText("css=tr.odd > td"));
        $this->assertEquals("operator", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[2]"));
        $this->assertEquals("Operator", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[3]"));
        $this->assertEquals("Displaying 1-1 of 1 result.", $this->getText("css=div.summary"));
    }

    /* Scenario 4 – Login as super admin and add agent operator
      Expected Behavior
      -	Asser text  agent operator and agentoperator@test.com  in search role field

      Steps:
      1.	Go to localhost/vms
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click ‘Administration’
      6.	Click ‘Add Agent Operator’
      7.	Verify role field is disabled
      8.	Assert tenant and tenant agent field present
      9.	Verify company field is enabled
      10.	Fill up fields, use agentoperator@test.com for email and 12345 for password
      11.	Select admin 1 in tenant, and agent admin 1 in tenant agent field
      12.	Choose company 1 in company field
      13.	Click save
      14.	Wait for page to redirect in manage users
      15.	Type agentoperator@test.com in email filter
      16.	Assert text agentoperator@test.com
      17.	Assert text agent operator
     */

    public function Scenario4() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Users");
        $this->click("link=Add Agent Operator");
        $this->waitForPageToLoad("30000");
        $this->addUser("agentoperator@test.com", "agentoperator");
        $this->getDisabledRoleValue("7");
        $this->select("id=User_tenant", "label=Test admin");
        $this->waitForElementPresent("id=User_tenant_agent");
        sleep(1);
        $this->select("id=User_tenant_agent", "label=Test agentadmin");
        $this->waitForElementPresent("id=User_company");
        sleep(1);
        $this->getDisabledCompanyValue("Test Company 1");
        $this->waitForElementPresent("id=User_workstation");
        $this->assertEquals("Workstation", $this->getText("id=User_workstation"));

        $this->waitForElementPresent("id=submitBtn");
        $this->click("id=submitBtn");
        $this->click("id=submitForm");
        $this->waitForPageToLoad("30000");
        $this->type("css=td > input[name=\"User[first_name]\"]", "Test");
        $this->click("//td[2]/input");
        $this->type("//td[2]/input", "agentoperator");
        $this->select("css=select[name=\"User[role]\"]", "label=Agent Operator");
        $this->waitForElementPresent("css=td > input[name=\"User[first_name]\"]");
        sleep(1);
        $this->assertEquals("Test", $this->getText("css=tr.odd > td"));
        $this->assertEquals("agentoperator", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[2]"));
        $this->assertEquals("Displaying 1-1 of 1 result.", $this->getText("css=div.summary"));
    }

    /* Scenario 5 – Login as super admin and add staff member
      Expected Behavior
      -	Asser text  staff member and staffmember@test.com  in search role field

      Steps:
      1.	Go to localhost/vms
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click ‘Administration’
      6.	Click ‘Add User’
      7.	Fill up fields, use staffmember@test.com for email and 12345 for password
      8.	Select staff member in role field
      9.	Select admin 1 in tenant
      10.	Select agent admin 1 in tenant agent
      11.	Verify company field is disabled
      12.	Click save
      13.	Wait for page to redirect in manage users
      14.	Type staffmember@test.com in email filter
      15.	Assert text staffmember@test.com
      16.	Assert text staff member
     */

    public function Scenario5() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Users");
        $this->click("link=Add User");
        $this->waitForPageToLoad("30000");
        $this->addUser("staffmember@test.com", "staffmember");
        $this->select("id=User_role", "label=Staff Member");
        $this->select("id=User_tenant", "label=Test admin");
        $this->waitForElementPresent("id=User_tenant_agent");
        sleep(1);
        $this->select("id=User_tenant_agent", "label=Test agentadmin");
        $this->waitForElementPresent("id=User_tenant_agent");
        $this->getDisabledCompanyValue("Test Company 1");
        $this->waitForElementPresent("id=submitBtn");
        $this->click("id=submitBtn");
        $this->clickAndWait("id=submitForm");
        $this->waitForElementPresent("css=td > input[name=\"User[first_name]\"]");
        $this->type("css=td > input[name=\"User[first_name]\"]", "Test");
        $this->click("//td[2]/input");
        $this->type("//td[2]/input", "staffmember");
        $this->select("css=select[name=\"User[role]\"]", "label=Staff Member");
        $this->waitForElementPresent("css=td > input[name=\"User[first_name]\"]");
        sleep(1);
        $this->assertEquals("Test", $this->getText("css=tr.odd > td"));
        $this->assertEquals("staffmember", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[2]"));
        $this->assertEquals("Staff Member", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[3]"));
        $this->assertEquals("Displaying 1-1 of 1 result.", $this->getText("css=div.summary"));
    }

    /* Scenario 6 – Login as super admin and add administrator with new company
      Expected Behavior
      -	Asser text  ’administrator’ and admin4@test.com  in search role field

      Steps:
      1.	Go to localhost/vms
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click ‘Administration’
      6.	Click ‘Add Administrator’
      7.	Fill up fields, use admin@test.com for email and 12345 for password
      8.	Click add company button
      9.	Fill up fields, set company name = test company 2
      10.	Click save in modal
      11.	Assert text Company Successfully added
      12.	Click close in modal
      13.	Assert company field text is test company 2
      14.	Click save
      15.	Wait for page to redirect in manage users
      16.	Type admin2@test.com in email filter
      17.	Assert text admin2@test.com
      18.	Assert text administrator
     */

    public function Scenario6() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Users");
        $this->click("link=Add Administrator");
        $this->waitForPageToLoad("30000");
        $this->addUser("admin2@test.com", "admin2");
        $this->waitForElementPresent("id=submitBtn");
        $this->addCompany("Test Company 2", "testcompany2");
        $this->waitForElementPresent("id=submitBtn");
        sleep(1);
        $this->click("id=submitBtn");
        $this->click("id=submitForm");
        $this->waitForPageToLoad("30000");
        $this->type("css=td > input[name=\"User[first_name]\"]", "Test");
        $this->click("//td[2]/input");
        $this->type("//td[2]/input", "Admin2");
        $this->select("css=select[name=\"User[role]\"]", "label=Administrator");
        $this->select("css=select[name=\"User[user_type]\"]", "label=Internal");
        $this->waitForElementPresent("css=td > input[name=\"User[first_name]\"]");
        sleep(1);
        $this->assertEquals("Test", $this->getText("css=tr.odd > td"));
        $this->assertEquals("admin2", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[2]"));
        $this->assertEquals("Administrator", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[3]"));
    }

}

?>
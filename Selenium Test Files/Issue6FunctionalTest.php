<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue6FunctionalTest
 *
 * @author Jeremiah
 */
class Issue6FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://cvms.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
        $this->Scenario2();
        $this->Scenario3();
        $this->Scenario4();
    }

    /* Scenario 1 – Login as super admin and add new workstation

      Expected Behavior
      -	Assert text ‘Workstation 2’ in name field in Search Company filters.
      Steps:
      1.	Go to localhost/vms
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click ‘Administration’
      6.	Click ‘Manage workstations’
      7.        Click ‘add workstation’
      8.	Fill up fields; use workstation 2 for Name
      9.	Select Test admin2 in tenant
      9.	Click save
      10.	Wait for page to redirect in manage workstations
      11.	Type workstation 2 in name filter and workstation2@test.com in email
      12.	Assert text workstation 2 in name row
      13.	Assert text workstation2@test.com in email row.

     */

    function Scenario1() {
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
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        $this->type("css=td > input[name=\"Workstation[name]\"]", "Workstation 2");
        $this->type("xpath=(//input[@name='Workstation[contact_email_address]'])[2]", "workstation2@test.com");
        sleep(5);
        $this->assertEquals("Workstation 2", $this->getText("css=tr.odd > td"));
        $this->waitForElementPresent("//div[@id='workstation-grid']/table/tbody/tr/td[5]");
        $this->assertEquals("workstation2@test.com", $this->getText("//div[@id='workstation-grid']/table/tbody/tr/td[5]"));
    }

    /* Scenario 2 – Login as super admin and add update workstation 2

      Expected Behavior
      -	Assert text ’office updated’ in location field

      Steps:
      1.	Go to localhost/vms
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click ‘Administration’
      6.	Click ‘Manage workstations’
      7.        Click ‘View companies’
      8.	Type Workstation 2 in name field and workstation2@test.com
      9.	Click edit
      9.	Type office updated in location field
      10.	Click save
      11.	Type workstation 2 in name filter and workstation2@test.com in email
      12.	Assert text Office - updated

     */

    function Scenario2() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Workstations");
        $this->click("link=View Workstations");
        $this->waitForPageToLoad("30000");
        $this->type("css=td > input[name=\"Workstation[name]\"]", "Workstation 2");
        $this->type("xpath=(//input[@name='Workstation[contact_email_address]'])[2]", "workstation2@test.com");
        sleep(5);
        $this->click("link=Edit");
        $this->waitForPageToLoad("30000");
        $this->type("id=Workstation_location", "Office - updated");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        $this->type("css=td > input[name=\"Workstation[name]\"]", "Workstation 2");
        $this->type("xpath=(//input[@name='Workstation[contact_email_address]'])[2]", "workstation2@test.com");
        sleep(5);
        $this->assertEquals("Office - updated", $this->getText("//div[@id='workstation-grid']/table/tbody/tr/td[2]"));
    }

    /*
      Scenario 3 – Login as super admin and check for validation errors
      Expected Behavior
      - Assert name cannot be blank
      - Assert Contact email address is not a valid email address.

      Steps:
      1.	Go to localhost/vms
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click ‘Administration’
      6.	Click ‘Manage workstations’
      7.        Click ‘Add company’
      8.	Click save
      9.	Assert text name cannot be blank
      9.	Type 123 in email field
      10.	Assert text contact email address is not a valid email address
*/

    function Scenario3() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Workstations");
        $this->click("link=Add Workstation");
        $this->waitForPageToLoad("30000");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Name cannot be blank.", $this->getText("css=div.errorSummary > ul > li"));
        $this->assertEquals("Tenant cannot be blank.", $this->getText("//form[@id='workstations-form']/div/ul/li[2]"));
        $this->type("id=Workstation_contact_email_address", "123");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Contact Email Address is not a valid email address.", $this->getText("//form[@id='workstations-form']/div/ul/li[3]"));
    }
    
    /*Scenario 4 – Login as admin and add workstation
      Expected Behavior
      - Assert ‘workstation 3’ in name field

      Steps:
      1.	Go to localhost/vms
      2.	Type admin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click ‘Administration’
      6.	Click ‘Manage workstations’
      7.     Click ‘add workstation’
      8.	Fill up fields; use workstation 3 for Name
      9.	Click save
      10.	Wait for page to redirect in manage workstations
      11.	Type workstation 3 in name filter and workstation3@test.com in email
      12.	Assert text workstation 3 in name row
      13.	Assert text workstation3@test.com in email row.
*/
    function Scenario4(){
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Workstations");
        $this->click("link=Add Workstation");
        $this->waitForPageToLoad("30000");
        $this->type("id=Workstation_name", "Workstation 3");
        $this->type("id=Workstation_location", "Office");
        $this->type("id=Workstation_contact_name", "Test Person");
        $this->type("id=Workstation_contact_number", "1234-567");
        $this->type("id=Workstation_contact_email_address", "workstation3@test.com");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        $this->type("css=td > input[name=\"Workstation[name]\"]", "Workstation 3");
        $this->type("xpath=(//input[@name='Workstation[contact_email_address]'])[2]", "workstation3@test.com");
        sleep(5);
        $this->assertEquals("Workstation 3", $this->getText("css=tr.odd > td"));
        $this->assertEquals("workstation3@test.com", $this->getText("//div[@id='workstation-grid']/table/tbody/tr/td[5]"));
    
    }
    /*
      Scenario 5 – Login as admin and assert not authorized to access
      Expected Behavior
      -	Assert text you are not authorized to perform this action

      Steps:
      1.	Go to localhost/vms
      2.	Type admin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	open url http://localhost/vms/index.php?r=company/admin
      6.        assert text you are not authorized to perform this action

     */

    function Scenario5() {
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->open("http://cvms.identitysecurity.info/index.php?r=company/admin");
        $this->assertEquals("You are not authorized to perform this action.", $this->getText("css=div.error"));
    }

}

?>
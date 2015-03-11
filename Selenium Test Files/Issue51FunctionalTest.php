<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue51FunctionalTest
 *
 * @author Jeremiah
 */
class Issue51FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
        $this->Scenario2();
    }

    /* Scenario 1 : Check data control for companies with different tenant 
      Expected Behavior :
     * Assert no results found upon in tables of new tenant
     * Assert no results found in visitor records page of admin@test.com for secondtenantvisitor@test.com       
     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Users");
        $this->clickAndWait("link=Add Administrator");
        $this->type("id=User_first_name", "new");
        $this->type("id=User_last_name", "secondtenant");
        $this->type("id=User_email", "secondtenant@test.com");
        $this->type("id=User_contact_number", "12345");
        $this->addCompany("New company", "newcompany", "NCC");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeat_password", "12345");

        $this->clickAndWait("id=submitForm");
        $this->assertEquals("secondtenant", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[2]"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");

        $username = 'secondtenant@test.com';
        $this->login($username, '12345');
        $this->assertEquals("Error 503\n No workstations available", $this->getText("css=div.adminErrorSummary > p"));
        $this->clickAndWait("link=Visit History");
        $this->assertEquals("No results found.", $this->getText("css=span.empty"));
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Workstations");
        $this->waitForElementPresent("css=span.empty");
        $this->assertEquals("No results found.", $this->getText("css=span.empty"));
        $this->click("link=Manage Visitors");
        $this->waitForElementPresent("css=span.empty");
        $this->assertEquals("No results found.", $this->getText("css=span.empty"));
        $this->click("link=Manage Workstations");
        $this->clickAndWait("link=Add Workstation");
        $this->type("id=Workstation_name", "Second Tenant Workstation");
        $this->type("id=Workstation_location", "Office");
        $this->type("id=Workstation_contact_name", "Test person");
        $this->type("id=Workstation_contact_number", "123456");
        $this->type("id=Workstation_contact_email_address", "testperson@test.com");
        $this->clickAndWait("name=yt0");
        $this->click("link=Manage Visitors");
        $this->clickAndWait("link=Log Visit");
        $this->click("id=clicktabA");
        sleep(1);
        $this->select("id=workstation", "label=Second Tenant Workstation");
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", "secondtenantvisitor");
        $this->type("id=Visitor_position", "position");
        $this->type("id=Visitor_contact_number", "123456");
        $this->select("id=Visitor_visitor_type", "label=Corporate Visitor");
        $this->type("id=Visitor_email", "secondtenantvisitor@test.com");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->select("id=Visit_reason", "label=Reason 2");
        $this->click("id=submitFormVisitor");
        $this->type("id=User_first_name", "test");
        $this->type("id=User_last_name", "test");
        $this->type("id=User_email", "test@test.com");
        $this->type("id=User_contact_number", "123456");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        $this->clickAndWait("id=submitFormUser");
        $this->click("css=#activate-a-visit-form > input.complete");
        sleep(3);
        $this->assertEquals("Visit is now activated. You can now print the visitor badge.", $this->getAlert());
        $this->clickAndWait("link=Dashboard");
        $this->clickAndWait("link=Active");
        $this->assertEquals("secondtenantvisitor", $this->getText("//table[@id='personalDetailsTable']/tbody/tr[2]/td[2]"));
        $this->clickAndWait("link=Visit History");
        $this->assertEquals("secondtenantvisitor@test.com", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[8]"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Visit History");
        $this->type("name=Visit[contactemail]", "secondtenant");
        sleep(1);
        $this->assertEquals("No results found.", $this->getText("css=span.empty"));
    }

    /* Scenario2 - Check data control for users under tenant 2
      Expected Behavior
     *      Assert no results found for operator2@test.com, agentoperator2@test.com, staffmember2@test.com, agentadmin2@test.com
     *      */

    function Scenario2() {
        $username = 'secondtenant@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Users");
        $this->clickAndWait("link=Add Agent Administrator");
        $this->type("id=User_first_name", "new");
        $this->type("id=User_last_name", "agentadmin2");
        $this->type("id=User_last_name", "agentadmin");
        $this->type("id=User_email", "agentadmin2@test.com");
        $this->type("id=User_contact_number", "12345");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeat_password", "12345");
        $this->addCompany("New Company 2", "newcompany2", "NCB");
        $this->clickAndWait("id=submitForm");
        $this->clickAndWait("link=Add Operator");
        $this->type("id=User_first_name", "new");
        $this->type("id=User_last_name", "operator");
        $this->type("id=User_email", "operator2@test.com");
        $this->type("id=User_contact_number", "123456");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeat_password", "12345");
        $this->clickAndWait("id=submitForm");
        $this->clickAndWait("css=div.customIcon-adminmenu");
        $this->select("id=User_role", "label=Staff Member");
        $this->type("id=User_first_name", "new");
        $this->type("id=User_last_name", "staffmember");
        $this->type("id=User_email", "staffmember2@test.com");
        $this->type("id=User_contact_number", "12345");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeat_password", "12345");
        $this->clickAndWait("id=submitForm");
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");

        $username = 'operator2@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("id=submitBtn");
        $this->assertEquals("secondtenantvisitor@test.com", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[7]"));
        $this->clickAndWait("link=Visit History");
        $this->assertEquals("secondtenantvisitor@test.com", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[8]"));
        $this->assertEquals("Displaying 1-1 of 1 result", $this->getText("css=div.summary"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");

        $username = 'staffmember2@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Log Visit");
        $this->click("id=clicktabA");
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", "staffmembervisitor");
        $this->type("id=Visitor_contact_number", "123456");
        $this->type("id=Visitor_email", "staffmembervisitor@test.com");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->select("id=workstation", "label=Second Tenant Workstation");
        $this->click("id=submitFormVisitor");
        $this->click("id=saveCurrentUserAsHost");
        $this->clickAndWait("id=submitAllForms");
        $this->clickAndWait("link=Visit History");
        $this->assertEquals("staffmembervisitor@test.com", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[8]"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
    }

}

?>

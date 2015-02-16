<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue53FunctionalTest
 *
 * @author Jeremiah
 */
class Issue53FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*iexplore");
        $this->setBrowserUrl("http://cvms.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
        $this->Scenario2();
        $this->Scenario3();
    }

    /* Scenario 1 -Login as super admin, Add new visitor type, register a visitor using new visitor type
      Expected Behavior
      Assert Test Visitor Type in table
      Assert Test Visitor Type in visitor type dropdown field
      Assert test newhost registered successfully

     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Visitor Types");
        $this->clickAndWait("link=Add Visitor Type");
        $this->type("id=VisitorType_name", "Test Visitor");
        $this->clickAndWait("name=yt0");
        $this->assertEquals("Test Visitor", $this->getText("css=tr.even > td"));
        $this->clickAndWait("css=tr.even > td.button-column > a.update");
        $this->type("id=VisitorType_name", "Test Visitor Type");
        $this->clickAndWait("name=yt0");
        $this->assertEquals("Test Visitor Type", $this->getText("css=tr.even > td"));
        $this->clickAndWait("link=Dashboard");
        $this->clickAndWait("css=span");
        $this->click("id=clicktabA");
        $this->assertEquals("Corporate Visitor Test Visitor Type", $this->getText("id=Visitor_visitor_type"));
        $this->select("id=Visitor_visitor_type", "label=Test Visitor Type");
        $this->select("id=workstation", "label=Workstation1");
        $this->type("id=Visitor_first_name", "Test");
        $this->type("id=Visitor_last_name", "VisitorType");
        $this->type("id=Visitor_position", "test position");
        $this->type("id=Visitor_contact_number", "123456");
        $this->type("id=Visitor_vehicle", "ABC123");
        $this->type("id=Visitor_email", "testvisitortype@test.com");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->select("id=Visitor_tenant", "label=Test admin");
        sleep(1);
        $this->click("id=Visitor_tenant_agent");
        $this->select("id=Visitor_tenant_agent", "label=Test agentadmin");
        $this->click("id=submitFormVisitor");
        $this->type("id=User_first_name", "test");
        $this->type("id=User_last_name", "newhost");
        $this->type("id=User_department", "test department");
        $this->type("id=User_staff_id", "123456");
        $this->type("id=User_email", "testnewhost@test.com");
        $this->type("id=User_contact_number", "123456");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        $this->select("id=User_tenant", "label=Test admin");
        sleep(1);
        $this->select("id=User_tenant_agent", "label=Test agentadmin");
        $this->click("id=submitFormUser");
        $this->click("id=submitFormUser");
        $this->clickAndWait("id=submitAllForms");
        $this->assertEquals("Corporate Visitor Test Visitor Type", $this->getText("id=Visit_visitor_type"));
        $this->clickAndWait("link=Visitor Records");
        $this->assertEquals("Corporate Visitor Test Visitor Type", $this->getText("name=Visit[visitor_type]"));
        $this->select("name=Visit[visitor_type]", "label=Test Visitor Type");
        $this->assertEquals("Test Visitor Type", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[2]"));
    }

    /* Scenario 2 : Check for validation errors

     * Expected Behavior - Assert Name cannot be blank

     */

    function Scenario2() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Visitor Types");
        $this->clickAndWait("link=Add Visitor Type");
        $this->type("id=VisitorType_name", "");
        $this->clickAndWait("name=yt0");
        $this->assertEquals("Please fix the following input errors:", $this->getText("css=div.errorSummary > p"));
        $this->assertEquals("Name cannot be blank.", $this->getText("css=div.errorMessage"));
    }

    /* Scenario 3 : Login as admin, agent admin, operator, agent operator, staff member and assert test visitor type in visitor type dropdown 
       Expected Behavior : Assert test visitor type under visitor type dropdown
     *      */

    function Scenario3() {
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->checkVisitorType();
        $username = 'agentadmin@test.com';
        $this->login($username, '12345');
        $this->checkVisitorType();
        $username = 'operator@test.com';
        $this->login($username, '12345');
        $this->click("id=submitBtn");
        $this->clickAndWait("id=submit");
        $this->checkVisitorType();
        $username = 'agentoperator@test.com';
        $this->login($username, '12345');
        $this->click("id=submitBtn");
        $this->clickAndWait("id=submit");
        $this->checkVisitorType();
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->checkVisitorType('staffmember@test.com');
    }

    function checkVisitorType($username = NULL) {
        $this->clickAndWait("css=span");
        $this->click("id=clicktabA");
        $this->assertEquals("Corporate Visitor Test Visitor Type", $this->getText("id=Visitor_visitor_type"));
        $this->clickAndWait("link=Visitor Records");
        $this->assertEquals("Corporate Visitor Test Visitor Type", $this->getText("name=Visit[visitor_type]"));
        if ($username != 'staffmember@test.com') {
            $this->assertEquals("Test Visitor Type", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[2]"));
        }
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
    }

}

?>
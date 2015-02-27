<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';
date_default_timezone_set('Asia/Manila');

/**
 * Description of Issue29FunctionalTest
 * @author Jeremiah
 */
class Issue29AdminFunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->ScenarioAdmin();
        $this->resetDbWithData();
        $this->ScenarioAgentAdmin();
        $this->resetDbWithData();
        $this->ScenarioAgentOperator();
        $this->resetDbWithData();
        $this->ScenarioOperator();
        $this->resetDbWithData();
        $this->ScenarioStaffMember();
    }

    function ScenarioAdmin() {
       // //$this->Scenario1"admin");
       // //$this->Scenario2"admin");
        $this->Scenario3("admin");
        $this->Scenario4("admin");
        $this->Scenario5("admin");
        $this->Scenario6("admin");
        $this->resetDbWithData();
       // //$this->Scenario7"admin");
       // //$this->Scenario8("admin");
        $this->Scenario9("admin");
        $this->Scenario10("admin");
        $this->Scenario11("admin");
        $this->Scenario12("admin");
        $this->Scenario13("admin");
        $this->Scenario14("admin");
        $this->ScenarioEvacuationReport("admin");
    }

    function ScenarioAgentAdmin() {
       // //$this->Scenario1"agentadmin");
       // //$this->Scenario2"agentadmin");
        $this->Scenario3("agentadmin");
        $this->Scenario4("agentadmin");
        $this->Scenario5("agentadmin");
        $this->Scenario6("agentadmin");
        $this->resetDbWithData();
        ////$this->Scenario7"agentadmin");
        ////$this->Scenario8("agentadmin");
        $this->Scenario9("agentadmin");
        $this->Scenario10("agentadmin");
        $this->Scenario11("agentadmin");
        $this->Scenario12("agentadmin");
        $this->Scenario13("agentadmin");
        $this->Scenario14("agentadmin");
        $this->ScenarioEvacuationReport("agentadmin");
    }

    function ScenarioAgentOperator() {
        $username = "agentoperator";
        //$this->Scenario1$username);
        //$this->Scenario2$username);
        $this->Scenario3($username);
        $this->Scenario4($username);
        $this->Scenario5($username);
        $this->Scenario6($username);
        $this->resetDbWithData();
        //$this->Scenario7$username);
        //$this->Scenario8($username);
        $this->Scenario9($username);
        $this->Scenario10($username);
        $this->Scenario11($username);
        $this->Scenario12($username);
        $this->Scenario13($username);
        $this->Scenario14($username);
        $this->ScenarioEvacuationReport($username);
    }

    function ScenarioOperator() {
        $username = "operator";
        //$this->Scenario1$username);
        //$this->Scenario2$username);
        $this->Scenario3($username);
        $this->Scenario4($username);
        $this->Scenario5($username);
        $this->Scenario6($username);
        $this->resetDbWithData();
        //$this->Scenario7$username);
        //$this->Scenario8($username);
        $this->Scenario9($username);
        $this->Scenario10($username);
        $this->Scenario11($username);
        $this->Scenario12($username);
        $this->Scenario13($username);
        $this->Scenario14($username);
        $this->ScenarioEvacuationReport($username);
    }

    function ScenarioStaffMember() {
        $username = "staffmember";
        $this->Scenario14($username);
        $this->ScenarioEvacuationReport($username);
    }

    /* Scenario 1 – Login as admin add patient visitor add patient with exisitng reason
     */

    function Scenario1($username) {
        $this->login($username . '@test.com', '12345');
        if ($username == 'agentoperator' || $username == 'operator') {
            $this->click("id=submitBtn");
            $this->clickAndWait("id=submit");
        }
        $this->clickAndWait("link=Log Visit");

        $this->click("id=clicktabA");
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", $username . "visitor1");
        $this->type("id=Visitor_position", "position");
        $this->type("id=Visitor_contact_number", "1234567");
        $this->type("id=Visitor_email", $username . "visitor1@test.com");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        if ($username == 'superadmin' || $username == 'admin' || $username == 'agentadmin') {
            $this->select("id=workstation", "label=Workstation1");
        }
        $this->click("id=submitFormVisitor");
        $this->type("id=Patient_name", $username . "patient1");
        $this->click("id=submitFormPatientName");
        $this->waitForElementPresent("id=submitAllForms");
        $this->clickAndWait("id=submitAllForms");
        $this->assertEquals("test", $this->getText("//table[@id='personalDetailsTable']/tbody/tr/td[2]"));
        $this->assertEquals($username . "visitor1", $this->getText("//table[@id='personalDetailsTable']/tbody/tr[2]/td[2]"));
        $this->assertEquals($username . "visitor1@test.com", $this->getValue("id=Visitor_email"));
        $this->assertEquals("1234567", $this->getValue("id=Visitor_contact_number"));
        $this->assertEquals("1", $this->getValue("id=Visit_visitor_type"));
        $this->assertEquals("1", $this->getValue("id=Visit_reason"));
        $this->assertEquals($username . "patient1", $this->getValue("document.forms['update-patient-form'].elements['Patient[name]']"));
        $this->clickAndWait("link=Dashboard");
        if ($username == 'admin' || $username == 'agentadmin') {
            $this->assertEquals($username . "visitor1", $this->getText("//div[@id='visit-gridDashboard1']/table/tbody/tr/td[4]"));
            $this->assertEquals($username . "visitor1@test.com", $this->getText("//div[@id='visit-gridDashboard1']/table/tbody/tr/td[7]"));
        } else {
            $this->assertEquals($username . "visitor1", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[4]"));
            $this->assertEquals($username . "visitor1@test.com", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[7]"));
        }
    }

    /* Scenario 2 – Login as admin, find patient visitor, add patient with exisitng reason

     */

    function Scenario2($username) {
        $this->login($username . "@test.com", '12345');
        if ($username == 'agentoperator' || $username == 'operator') {
            $this->click("id=submitBtn");
            $this->clickAndWait("id=submit");
        }
        $this->clickAndWait("link=Log Visit");
        $this->click("id=clicktabA");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->waitForElementPresent("id=2");
        $this->click("id=2");
        $this->select("id=Visit_reason_search", "label=Reason 1");
        $this->select("id=workstation_search", "label=Workstation1");
        $this->click("id=clicktabB1");
        $this->type("id=Patient_name", $username . "patient2");
        $this->click("id=submitFormPatientName");
        $this->clickAndWait("id=submitAllForms");
        $this->assertEquals("Visitor1", $this->getText("//table[@id='personalDetailsTable']/tbody/tr[2]/td[2]"));
        $this->assertEquals("testVisitor1@test.com", $this->getValue("id=Visitor_email"));
        $this->assertEquals("1", $this->getValue("id=Visit_visitor_type"));
        $this->assertEquals("1", $this->getValue("id=Visit_reason"));
        $this->assertEquals($username . "patient2", $this->getValue("document.forms['update-patient-form'].elements['Patient[name]']"));
        $this->clickAndWait("link=Dashboard");
        if ($username == 'admin' || $username == 'agentadmin') {
            $this->assertEquals("Visitor1", $this->getText("//div[@id='visit-gridDashboard1']/table/tbody/tr/td[4]"));
            $this->assertEquals("testVisitor1@test.com", $this->getText("//div[@id='visit-gridDashboard1']/table/tbody/tr/td[7]"));
        } else {
            $this->assertEquals("Visitor1", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[4]"));
            $this->assertEquals("testVisitor1@test.com", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[7]"));
        }
    }

    /* Scenario 3 –Login as admin add corporate visitor add host with exisitng reason
     */

    function Scenario3($username) {
        $this->login($username . "@test.com", '12345');
        if ($username == 'agentoperator' || $username == 'operator') {
            $this->click("id=submitBtn");
            $this->clickAndWait("id=submit");
        }
        $this->clickAndWait("link=Log Visit");
        $this->click("id=clicktabA");
        $this->select("id=Visitor_visitor_type", "label=Corporate Visitor");
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", $username . "visitor2");
        $this->type("id=Visitor_position", "position");
        $this->type("id=Visitor_contact_number", "123456");
        $this->type("id=Visitor_email", $username . "visitor2@test.com");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        if ($username == 'superadmin' || $username == 'admin' || $username == 'agentadmin') {
            $this->select("id=workstation", "label=Workstation1");
        }
        $this->click("id=submitFormVisitor");
        $this->type("id=User_first_name", "test");
        $this->type("id=User_last_name", $username . "host1");
        $this->type("id=User_department", "department");
        $this->type("id=User_staff_id", "123456");
        $this->type("id=User_email", $username . "host1@test.com");
        $this->type("id=User_contact_number", "123456");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        $this->click("id=submitFormUser");
        
        $this->clickAndWait("id=submitAllForms");
        $this->assertEquals($username . "visitor2", $this->getText("//table[@id='personalDetailsTable']/tbody/tr[2]/td[2]"));
        $this->assertEquals($username . "visitor2@test.com", $this->getValue("id=Visitor_email"));
        $this->assertEquals("2", $this->getValue("id=Visit_visitor_type"));
        $this->assertEquals("1", $this->getValue("id=Visit_reason"));
        $this->click("css=#activate-a-visit-form > input.complete");
        sleep(5);
        $this->assertEquals("Visit is now activated. You can now print the visitor badge.", $this->getAlert());
        $this->clickAndWait("link=Dashboard");
        $this->clickAndWait("link=Dashboard");
        if ($username == 'admin' || $username == 'agentadmin') {
            $this->assertEquals($username . "visitor2", $this->getText("//div[@id='visit-gridDashboard1']/table/tbody/tr/td[4]"));
            $this->assertEquals($username . "visitor2@test.com", $this->getText("//div[@id='visit-gridDashboard1']/table/tbody/tr/td[7]"));
        } else {
            $this->assertEquals($username . "visitor2", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[4]"));
            $this->assertEquals($username . "visitor2@test.com", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[7]"));
        }
    }

    /* Scenario 4 –Login as admin add corporate visitor find host with exisitng reason
     */

    function Scenario4($username) {
        $this->login($username . "@test.com", '12345');
        if ($username == 'agentoperator' || $username == 'operator') {
            $this->click("id=submitBtn");
            $this->clickAndWait("id=submit");
        }
        $this->clickAndWait("link=Log Visit");
        $this->click("id=clicktabA");
        $this->type("id=Visitor_first_name", "test");
        $this->select("id=Visitor_visitor_type", "label=Corporate Visitor");
        $this->type("id=Visitor_last_name", $username . "visitor3");
        $this->type("id=Visitor_position", "position");
        $this->type("id=Visitor_contact_number", "123456");
        $this->type("id=Visitor_email", $username . "visitor3@test.com");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        if ($username == 'superadmin' || $username == 'admin' || $username == 'agentadmin') {
            $this->select("id=workstation", "label=Workstation1");
        }
        $this->click("id=submitFormVisitor");
        $this->type("id=search-host", "test");
        $this->click("id=dummy-host-findBtn");
        $this->waitForElementPresent("id=21");
        $this->click("id=21");
        $this->click("id=clicktabB2");
        $this->clickAndWait("id=submitAllForms");
        $this->assertEquals($username . "visitor3", $this->getText("//table[@id='personalDetailsTable']/tbody/tr[2]/td[2]"));
        $this->assertEquals($username . "visitor3@test.com", $this->getValue("id=Visitor_email"));
        $this->assertEquals("2", $this->getValue("id=Visit_visitor_type"));
        $this->click("css=#activate-a-visit-form > input.complete");
        sleep(5);
        $this->assertEquals("Visit is now activated. You can now print the visitor badge.", $this->getAlert());
        $this->clickAndWait("link=Dashboard");
        $this->clickAndWait("link=Dashboard");
        
        if ($username == 'admin' || $username == 'agentadmin') {
            $this->assertEquals($username . "visitor3", $this->getText("//div[@id='visit-gridDashboard1']/table/tbody/tr/td[4]"));
            $this->assertEquals($username . "visitor3@test.com", $this->getText("//div[@id='visit-gridDashboard1']/table/tbody/tr/td[7]"));
        } else {
            $this->assertEquals($username . "visitor3", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[4]"));
            $this->assertEquals($username . "visitor3@test.com", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[7]"));
        }
    }

    /* Scenario 5 – Login as admin find visitor add host with exisitng reason

     */

    function Scenario5($username) {
        $this->login($username . "@test.com", '12345');
        if ($username == 'agentoperator' || $username == 'operator') {
            $this->click("id=submitBtn");
            $this->clickAndWait("id=submit");
        }
        $this->clickAndWait("link=Log Visit");
        $this->click("id=clicktabA");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->waitForElementPresent("id=3");
        $this->click("id=3");
        $this->select("id=Visitor_visitor_type_search", "label=Corporate Visitor");
        $this->select("id=Visit_reason_search", "label=Reason 1");
        $this->select("id=workstation_search", "label=Workstation1");
        $this->click("id=clicktabB1");
        $this->type("id=User_first_name", "test");
        $this->type("id=User_last_name", $username . "host2");
        $this->type("id=User_department", "department");
        $this->type("id=User_staff_id", "123456");
        $this->type("id=User_email", $username . "host2@test.com");
        $this->type("id=User_contact_number", "123456");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        $this->click("id=submitFormUser");
        $this->clickAndWait("id=submitAllForms");
        $this->assertEquals("Visitor3", $this->getText("//table[@id='personalDetailsTable']/tbody/tr[2]/td[2]"));
        $this->assertEquals("testVisitor3@test.com", $this->getValue("id=Visitor_email"));
        $this->assertEquals("2", $this->getValue("id=Visit_visitor_type"));
        $this->assertEquals("1", $this->getValue("id=Visit_reason"));
        $this->click("css=#activate-a-visit-form > input.complete");
        sleep(5);
        $this->assertEquals("Visit is now activated. You can now print the visitor badge.", $this->getAlert());
       
        $this->clickAndWait("link=Dashboard");
        if ($username == 'admin' || $username == 'agentadmin') {
            $this->assertEquals("Visitor3", $this->getText("//div[@id='visit-gridDashboard1']/table/tbody/tr/td[4]"));
            $this->assertEquals("testVisitor3@test.com", $this->getText("//div[@id='visit-gridDashboard1']/table/tbody/tr/td[7]"));
        } else {
            $this->assertEquals("Visitor3", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[4]"));
            $this->assertEquals("testVisitor3@test.com", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[7]"));
        }
    }

    /*
      Scenario 6- Login as admin find corporate visitor find host with existin reason
     */

    function Scenario6($username) {
        $this->login($username . "@test.com", '12345');
        if ($username == 'agentoperator' || $username == 'operator') {
            $this->click("id=submitBtn");
            $this->clickAndWait("id=submit");
        }
        $this->clickAndWait("link=Log Visit");
        $this->click("id=clicktabA");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->waitForElementPresent("id=4");
        $this->click("id=4");
        $this->select("id=Visit_reason_search", "label=Reason 1");
        $this->select("id=Visitor_visitor_type_search", "label=Corporate Visitor");
        $this->select("id=workstation_search", "label=Workstation1");
        $this->click("id=clicktabB1");
        $this->type("id=search-host", "test");
        $this->click("id=dummy-host-findBtn");
        $this->waitForElementPresent("id=21");
        $this->click("id=21");
        $this->click("id=clicktabB2");
        $this->clickAndWait("id=submitAllForms");
        $this->assertEquals("Visitor4", $this->getText("//table[@id='personalDetailsTable']/tbody/tr[2]/td[2]"));
        $this->assertEquals("testVisitor4@test.com", $this->getValue("id=Visitor_email"));
        $this->assertEquals("1", $this->getValue("id=Visit_reason"));
        $this->click("css=#activate-a-visit-form > input.complete");
        sleep(5);
        $this->assertEquals("Visit is now activated. You can now print the visitor badge.", $this->getAlert());
       
        $this->clickAndWait("link=Dashboard");
        if ($username == 'admin' || $username == 'agentadmin') {
            $this->assertEquals("Visitor4", $this->getText("//div[@id='visit-gridDashboard1']/table/tbody/tr/td[4]"));
            $this->assertEquals("testVisitor4@test.com", $this->getText("//div[@id='visit-gridDashboard1']/table/tbody/tr/td[7]"));
        } else {
            $this->assertEquals("Visitor4", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[4]"));
            $this->assertEquals("testVisitor4@test.com", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[7]"));
        }
    }

    /*
      Scenario 7- Login as admin add patient visitor add patient with new reason
     */

    function Scenario7($username) {
        $this->login($username . "@test.com", '12345');
        if ($username == 'agentoperator' || $username == 'operator') {
            $this->click("id=submitBtn");
            $this->clickAndWait("id=submit");
        }
        $this->clickAndWait("link=Log Visit");
        $this->click("id=clicktabA");
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", $username . "visitor1");
        $this->type("id=Visitor_position", "position");
        $this->type("id=Visitor_contact_number", "1234567");
        $this->type("id=Visitor_email", $username . "visitor1@test.com");
        $this->select("id=Visit_reason", "label=Other");
        $this->type("id=VisitReason_reason", "reason 3");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        if ($username == 'superadmin' || $username == 'admin' || $username == 'agentadmin') {
            $this->select("id=workstation", "label=Workstation1");
        }
        $this->click("id=submitFormVisitor");
        $this->type("id=Patient_name", $username . "patient1");
        $this->click("id=submitFormPatientName");
        $this->clickAndWait("id=submitAllForms");
        $this->assertEquals("test", $this->getText("//table[@id='personalDetailsTable']/tbody/tr/td[2]"));
        $this->assertEquals($username . "visitor1", $this->getText("//table[@id='personalDetailsTable']/tbody/tr[2]/td[2]"));
        $this->assertEquals($username . "visitor1@test.com", $this->getValue("id=Visitor_email"));
        $this->assertEquals("1234567", $this->getValue("id=Visitor_contact_number"));
        $this->assertEquals("1", $this->getValue("id=Visit_visitor_type"));
        $this->assertEquals("3", $this->getValue("id=Visit_reason"));
        $this->assertEquals($username . "patient1", $this->getValue("document.forms['update-patient-form'].elements['Patient[name]']"));
        $this->click("css=#activate-a-visit-form > input.complete");
        sleep(5);
        $this->assertEquals("Visit is now activated. You can now print the visitor badge.", $this->getAlert());
       
        $this->clickAndWait("link=Dashboard");
        if ($username == 'admin' || $username == 'agentadmin') {
            $this->assertEquals($username . "visitor1", $this->getText("//div[@id='visit-gridDashboard1']/table/tbody/tr/td[4]"));
            $this->assertEquals($username . "visitor1@test.com", $this->getText("//div[@id='visit-gridDashboard1']/table/tbody/tr/td[7]"));
        } else {
            $this->assertEquals($username . "visitor1", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[4]"));
            $this->assertEquals($username . "visitor1@test.com", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[7]"));
        }
    }

    /*
      Scenario 8- Login as admin find visitor add patient with new reason
     */

    function Scenario8($username) {
        $this->login($username . "@test.com", '12345');
        if ($username == 'agentoperator' || $username == 'operator') {
            $this->click("id=submitBtn");
            $this->clickAndWait("id=submit");
        }
        $this->clickAndWait("link=Log Visit");
        $this->click("id=clicktabA");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->waitForElementPresent("id=2");
        $this->click("id=2");
        $this->select("id=Visit_reason_search", "label=Other");
        $this->type("id=VisitReason_reason_search", "Reason 4");
        $this->select("id=workstation_search", "label=Workstation1");
        $this->click("id=clicktabB1");
        $this->type("id=Patient_name", $username . "patient2");
        $this->click("id=submitFormPatientName");
        $this->clickAndWait("id=submitAllForms");
        $this->assertEquals("Visitor1", $this->getText("//table[@id='personalDetailsTable']/tbody/tr[2]/td[2]"));
        $this->assertEquals("testVisitor1@test.com", $this->getValue("id=Visitor_email"));
        $this->assertEquals("1", $this->getValue("id=Visit_visitor_type"));
        $this->assertEquals("4", $this->getValue("id=Visit_reason"));
        $this->assertEquals($username . "patient2", $this->getValue("document.forms['update-patient-form'].elements['Patient[name]']"));
        $this->clickAndWait("link=Dashboard");
        if ($username == 'admin' || $username == 'agentadmin') {
            $this->assertEquals("Visitor1", $this->getText("//div[@id='visit-gridDashboard1']/table/tbody/tr/td[4]"));
            $this->assertEquals("testVisitor1@test.com", $this->getText("//div[@id='visit-gridDashboard1']/table/tbody/tr/td[7]"));
        } else {
            $this->assertEquals("Visitor1", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[4]"));
            $this->assertEquals("testVisitor1@test.com", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[7]"));
        }
    }

    /*
      Scenario 9- Login as admin add visitor add host add reason
     */

    function Scenario9($username) {
        $this->login($username . "@test.com", '12345');
        if ($username == 'agentoperator' || $username == 'operator') {
            $this->click("id=submitBtn");
            $this->clickAndWait("id=submit");
        }
        $this->clickAndWait("link=Log Visit");
        $this->click("id=clicktabA");
        $this->select("id=Visitor_visitor_type", "label=Corporate Visitor");
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", $username . "visitor2");
        $this->type("id=Visitor_position", "position");
        $this->type("id=Visitor_contact_number", "123456");
        $this->type("id=Visitor_email", $username . "visitor2@test.com");
        $this->select("id=Visit_reason", "label=Other");
        $this->type("id=VisitReason_reason", "reason 5");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        if ($username == 'superadmin' || $username == 'admin' || $username == 'agentadmin') {
            $this->select("id=workstation", "label=Workstation1");
        }
        $this->click("id=submitFormVisitor");
        $this->type("id=User_first_name", "test");
        $this->type("id=User_last_name", $username . "host1");
        $this->type("id=User_department", "department");
        $this->type("id=User_staff_id", "123456");
        $this->type("id=User_email", $username . "host1@test.com");
        $this->type("id=User_contact_number", "123456");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        $this->click("id=submitFormUser");
        $this->clickAndWait("id=submitAllForms");
        $this->assertEquals($username . "visitor2", $this->getText("//table[@id='personalDetailsTable']/tbody/tr[2]/td[2]"));
        $this->assertEquals($username . "visitor2@test.com", $this->getValue("id=Visitor_email"));
        $this->assertEquals("2", $this->getValue("id=Visit_visitor_type"));
        $this->assertEquals("3", $this->getValue("id=Visit_reason"));
        $this->click("css=#activate-a-visit-form > input.complete");
        sleep(5);
        $this->assertEquals("Visit is now activated. You can now print the visitor badge.", $this->getAlert());
       
        $this->clickAndWait("link=Dashboard");
        if ($username == 'admin' || $username == 'agentadmin') {
            $this->assertEquals($username . "visitor2", $this->getText("//div[@id='visit-gridDashboard1']/table/tbody/tr/td[4]"));
            $this->assertEquals($username . "visitor2@test.com", $this->getText("//div[@id='visit-gridDashboard1']/table/tbody/tr/td[7]"));
        } else {
            $this->assertEquals($username . "visitor2", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[4]"));
            $this->assertEquals($username . "visitor2@test.com", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[7]"));
        }
    }

    /*
      Scenario 10- Login as admin add visitor find host add reason
     */

    function Scenario10($username) {
        $this->login($username . "@test.com", '12345');
        if ($username == 'agentoperator' || $username == 'operator') {
            $this->click("id=submitBtn");
            $this->clickAndWait("id=submit");
        }
        $this->clickAndWait("link=Log Visit");
        $this->click("id=clicktabA");
        $this->type("id=Visitor_first_name", "test");
        $this->select("id=Visitor_visitor_type", "label=Corporate Visitor");
        $this->type("id=Visitor_last_name", $username . "visitor3");
        $this->type("id=Visitor_position", "position");
        $this->type("id=Visitor_contact_number", "123456");
        $this->type("id=Visitor_email", $username . "visitor3@test.com");
        $this->select("id=Visit_reason", "label=Other");
        $this->type("id=VisitReason_reason", "reason 6");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        if ($username == 'superadmin' || $username == 'admin' || $username == 'agentadmin') {
            $this->select("id=workstation", "label=Workstation1");
        }
        $this->click("id=submitFormVisitor");
        $this->type("id=search-host", "test");
        $this->click("id=dummy-host-findBtn");
        $this->waitForElementPresent("id=21");
        $this->click("id=21");
        $this->click("id=clicktabB2");
        $this->clickAndWait("id=submitAllForms");
        $this->assertEquals($username . "visitor3", $this->getText("//table[@id='personalDetailsTable']/tbody/tr[2]/td[2]"));
        $this->assertEquals($username . "visitor3@test.com", $this->getValue("id=Visitor_email"));
        $this->assertEquals("2", $this->getValue("id=Visit_visitor_type"));
        $this->assertEquals("4", $this->getValue("id=Visit_reason"));
        $this->click("css=#activate-a-visit-form > input.complete");
        sleep(5);
        $this->assertEquals("Visit is now activated. You can now print the visitor badge.", $this->getAlert());
       
        $this->clickAndWait("link=Dashboard");
        if ($username == 'admin' || $username == 'agentadmin') {
            $this->assertEquals($username . "visitor3", $this->getText("//div[@id='visit-gridDashboard1']/table/tbody/tr/td[4]"));
            $this->assertEquals($username . "visitor3@test.com", $this->getText("//div[@id='visit-gridDashboard1']/table/tbody/tr/td[7]"));
        } else {
            $this->assertEquals($username . "visitor3", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[4]"));
            $this->assertEquals($username . "visitor3@test.com", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[7]"));
        }
    }

    /*
      Scenario 11- Login as staff member find visitor select current logged in user as host and add new reason
     */

    function Scenario11($username) {
        $this->login($username . "@test.com", '12345');
        if ($username == 'agentoperator' || $username == 'operator') {
            $this->click("id=submitBtn");
            $this->clickAndWait("id=submit");
        }
        $this->clickAndWait("link=Log Visit");
        $this->click("id=clicktabA");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->waitForElementPresent("id=3");
        $this->click("id=3");
        $this->select("id=Visitor_visitor_type_search", "label=Corporate Visitor");
        $this->select("id=Visit_reason_search", "label=Other");
        $this->type("id=VisitReason_reason_search", "Reason 7");
        $this->select("id=workstation_search", "label=Workstation1");
        $this->click("id=clicktabB1");
        $this->type("id=User_first_name", "test");
        $this->type("id=User_last_name", $username . "host2");
        $this->type("id=User_department", "department");
        $this->type("id=User_staff_id", "123456");
        $this->type("id=User_email", $username . "host2@test.com");
        $this->type("id=User_contact_number", "123456");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        $this->click("id=submitFormUser");
        $this->clickAndWait("id=submitAllForms");
        $this->assertEquals("Visitor3", $this->getText("//table[@id='personalDetailsTable']/tbody/tr[2]/td[2]"));
        $this->assertEquals("testVisitor3@test.com", $this->getValue("id=Visitor_email"));
        $this->assertEquals("2", $this->getValue("id=Visit_visitor_type"));
        $this->assertEquals("5", $this->getValue("id=Visit_reason"));
        $this->click("css=#activate-a-visit-form > input.complete");
        sleep(5);
        $this->assertEquals("Visit is now activated. You can now print the visitor badge.", $this->getAlert());
       
        $this->clickAndWait("link=Dashboard");
        if ($username == 'admin' || $username == 'agentadmin') {
            $this->assertEquals("Visitor3", $this->getText("//div[@id='visit-gridDashboard1']/table/tbody/tr/td[4]"));
            $this->assertEquals("testVisitor3@test.com", $this->getText("//div[@id='visit-gridDashboard1']/table/tbody/tr/td[7]"));
        } else {
            $this->assertEquals("Visitor3", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[4]"));
            $this->assertEquals("testVisitor3@test.com", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[7]"));
        }
    }

    /*
      Scenario 12- Login as staff member find visitor find host and add new reason
     */

    function Scenario12($username) {
        $this->login($username . "@test.com", '12345');
        if ($username == 'agentoperator' || $username == 'operator') {
            $this->click("id=submitBtn");
            $this->clickAndWait("id=submit");
        }
        $this->clickAndWait("link=Log Visit");
        $this->click("id=clicktabA");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->waitForElementPresent("id=4");
        $this->click("id=4");
        $this->select("id=Visit_reason_search", "label=Other");
        $this->type("id=VisitReason_reason_search", "Reason 8");
        $this->select("id=workstation_search", "label=Workstation1");
        $this->select("id=Visitor_visitor_type_search", "label=Corporate Visitor");
        $this->click("id=clicktabB1");
        $this->type("id=search-host", "test");
        $this->click("id=dummy-host-findBtn");
        $this->waitForElementPresent("id=21");
        $this->click("id=21");
        $this->click("id=clicktabB2");
        $this->clickAndWait("id=submitAllForms");
        $this->assertEquals("Visitor4", $this->getText("//table[@id='personalDetailsTable']/tbody/tr[2]/td[2]"));
        $this->assertEquals("testVisitor4@test.com", $this->getValue("id=Visitor_email"));
        $this->assertEquals("6", $this->getValue("id=Visit_reason"));
        $this->click("css=#activate-a-visit-form > input.complete");        
        sleep(5);        
        $this->assertEquals("Visit is now activated. You can now print the visitor badge.", $this->getAlert());       
        $this->clickAndWait("link=Dashboard");
        if ($username == 'admin' || $username == 'agentadmin') {
            $this->assertEquals("Visitor4", $this->getText("//div[@id='visit-gridDashboard1']/table/tbody/tr/td[4]"));
            $this->assertEquals("testVisitor4@test.com", $this->getText("//div[@id='visit-gridDashboard1']/table/tbody/tr/td[7]"));
        } else {
            $this->assertEquals("Visitor4", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[4]"));
            $this->assertEquals("testVisitor4@test.com", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[7]"));
        }
    }

    /*
      Scenario 13- Login as admin check for validations
     */

    function Scenario13($username) {
        $this->login($username . "@test.com", '12345');
        if ($username == 'agentoperator' || $username == 'operator') {
            $this->click("id=submitBtn");
            $this->clickAndWait("id=submit");
        }
        $this->clickAndWait("link=Log Visit");
        $this->click("id=clicktabA");
        $this->waitForElementPresent("id=submitFormVisitor");
        $this->click("id=submitFormVisitor");
        $this->click("id=dummy-visitor-findBtn");
        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Search Name cannot be blank." == $this->getText("id=searchTextErrorMessage"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Search Name cannot be blank.", $this->getText("id=searchTextErrorMessage"));
        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Please enter a First Name" == $this->getText("id=Visitor_first_name_em_"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Please enter a First Name", $this->getText("id=Visitor_first_name_em_"));
        $this->assertEquals("Please enter a Last Name", $this->getText("id=Visitor_last_name_em_"));
        $this->assertEquals("Please enter an Email Address", $this->getText("id=Visitor_email_em_"));
        $this->assertEquals("Please enter a Mobile Number", $this->getText("id=Visitor_contact_number_em_"));
        $this->assertEquals("Please enter a Password", $this->getText("id=Visitor_password_em_"));
        $this->assertEquals("Please enter a Repeat Password", $this->getText("id=Visitor_repeatpassword_em_"));
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", "test");
        $this->type("id=Visitor_contact_number", "12345");
        $this->type("id=Visitor_email", "admin@test.com");
        $this->select("id=Visit_reason", "label=Other");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->type("id=Visitor_password", "12345");
        if ($username == 'superadmin' || $username == 'admin' || $username == 'agentadmin') {
            $this->select("id=workstation", "label=Workstation1");
        }
        $this->click("id=submitFormVisitor");
        $this->assertEquals("Please select a reason", $this->getText("css=td > div.errorMessage.visitorReason"));
        $this->type("id=VisitReason_reason", "reason 1");
        $this->click("id=submitFormVisitor");
        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Reason is already registered." == $this->getText("id=visitReasonErrorMessage"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Reason is already registered.", $this->getText("id=visitReasonErrorMessage"));
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->type("id=Visitor_email", "testvisitor1@test.com");
        if ($username == 'superadmin' || $username == 'admin' || $username == 'agentadmin') {
            $this->select("id=workstation", "label=Workstation1");
        }
        $this->click("id=submitFormVisitor");
        $this->assertEquals("A profile already exists for this email address.", $this->getText("xpath=(//div[@id='Visitor_email_em_'])[2]"));
        $this->type("id=Visitor_email", "test@test.com");
        if ($username == 'superadmin' || $username == 'admin' || $username == 'agentadmin') {
            $this->select("id=workstation", "label=Workstation1");
        }
        $this->click("id=submitFormVisitor");
        $this->click("id=submitFormPatientName");
        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Please enter a Patient Name" == $this->getText("id=Patient_name_em_"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Please enter a Patient Name", $this->getText("id=Patient_name_em_"));
        $this->click("css=#register-host-patient-form > div.register-a-visitor-buttons-div > #btnBackTab3");
        $this->select("id=Visitor_visitor_type", "label=Corporate Visitor");
        if ($username == 'superadmin' || $username == 'admin' || $username == 'agentadmin') {
            $this->select("id=workstation", "label=Workstation1");
        }
        $this->click("id=submitFormVisitor");
        $this->click("id=submitFormUser");
        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Please enter a First Name" == $this->getText("id=User_first_name_em_"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Please enter a First Name", $this->getText("id=User_first_name_em_"));
        $this->assertEquals("Please enter a Last Name", $this->getText("id=User_last_name_em_"));
        $this->assertEquals("Please enter a Contact No.", $this->getText("id=User_contact_number_em_"));
        $this->assertEquals("Please enter an Email Address", $this->getText("id=User_email_em_"));
        $this->assertEquals("Please enter a Repeat Password", $this->getText("id=User_repeatpassword_em_"));
        $this->assertEquals("Please enter a Password", $this->getText("id=User_password_em_"));
        $this->click("id=dummy-host-findBtn");
        $this->assertEquals("Search Name cannot be blank.", $this->getText("id=searchTextHostErrorMessage"));
        $this->type("id=User_first_name", "test");
        $this->type("id=User_last_name", "test");
        $this->type("id=User_email", "staffmember@test.com");
        $this->type("id=User_contact_number", "123456");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12");
        $this->assertEquals("New Password does not match with \nRepeat New Password.", $this->getText("id=passwordErrorMessage"));
        $this->type("id=User_repeatpassword", "12345");
        $this->click("id=submitFormUser");
        $this->assertEquals("A profile already exists for this email address.", $this->getText("xpath=(//div[@id='User_email_em_'])[2]"));
    }

    /*
      Scenario 14- Login as admin and add host
     */

    function Scenario14($username) {
        $this->login($username . "@test.com", '12345');
        if ($username == 'agentoperator' || $username == 'operator') {
            $this->click("id=submitBtn");
            $this->clickAndWait("id=submit");
        }
        $this->click("id=yt0");
        $this->waitForElementPresent("id=User_first_name");
        $this->type("id=User_first_name", "Test");
        $this->type("id=User_last_name", "new" . $username . "host");
        $this->type("id=User_department", "department");
        $this->type("id=User_staff_id", "12345");
        $this->type("id=User_email", "new" . $username . "host@test.com");
        $this->type("id=User_contact_number", "123456");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        $this->clickAndWait("id=submitFormUser");
        $this->clickAndWait("link=Log Visit");
        $this->click("id=clicktabA");

        $this->select("id=Visitor_visitor_type", "label=Corporate Visitor");
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", "test");
        $this->type("id=Visitor_position", "position");
        $this->type("id=Visitor_contact_number", "123456");
        $this->type("id=Visitor_email", "testtest@test.com");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        if ($username == 'superadmin' || $username == 'admin' || $username == 'agentadmin') {
            $this->select("id=workstation", "label=Workstation1");
        }
        $this->click("id=submitFormVisitor");
        $this->waitForElementPresent("id=search-host");
        $this->type("id=search-host", "new" . $username . "host");
        $this->click("id=dummy-host-findBtn");
        if ($username == 'staffmember' ) {
            $this->waitForElementPresent("id=24");
        } 
        else {
            $this->waitForElementPresent("id=28");
        }
        $this->assertEquals("new" . $username . "host", $this->getText("//div[@id='findHost-grid']/table/tbody/tr/td[2]"));
        $this->assertEquals("new" . $username . "host@test.com", $this->getText("//div[@id='findHost-grid']/table/tbody/tr/td[3]"));
        $this->clickAndWait("link=Dashboard");
        $this->click("id=yt0");
        sleep(2);
        $this->waitForElementPresent("id=submitFormUser");
        $this->click("id=submitFormUser");
        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Please enter a First Name" == $this->getText("id=User_first_name_em_"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Please enter a First Name", $this->getText("id=User_first_name_em_"));
        $this->assertEquals("Please enter a Last Name", $this->getText("id=User_last_name_em_"));
        $this->assertEquals("Please enter an Email Address", $this->getText("id=User_email_em_"));
        $this->assertEquals("Please enter a Contact No.", $this->getText("id=User_contact_number_em_"));
        $this->assertEquals("Please enter a Password", $this->getText("id=User_password_em_"));
        $this->assertEquals("Please enter a Repeat Password", $this->getText("id=User_repeatpassword_em_"));
        $this->type("id=User_password", "12345");
        $this->waitForElementPresent("id=passwordErrorMessage");
        $this->assertEquals("New Password does not match with \nRepeat New Password.", $this->getText("id=passwordErrorMessage"));
        $this->type("id=User_first_name", "test");
        $this->type("id=User_last_name", "test");
        $this->type("id=User_department", "department");
        $this->type("id=User_staff_id", "123456");
        $this->type("id=User_email", "staffmember@test.com");
        $this->type("id=User_contact_number", "123456");
        $this->type("id=User_repeatpassword", "12345");
        $this->click("id=submitFormUser");
        $this->waitForElementPresent("xpath=(//div[@id='User_email_em_'])[2]");
        $this->assertEquals("A profile already exists for this email address.", $this->getText("xpath=(//div[@id='User_email_em_'])[2]"));
    }

    function ScenarioEvacuationReport($username) {
        $this->login($username . "@test.com", '12345');
        if ($username == 'agentoperator' || $username == 'operator') {
            $this->click("id=submitBtn");
            $this->clickAndWait("id=submit");
        }
        $this->clickAndWait("link=Visit History");
        if ($username == 'staffmember') {
            $this->assertEquals("Displaying 1-6 of 6 results", $this->getText("css=div.summary"));
        }  else {
            $this->assertEquals("Displaying 1-10 of 11 results", $this->getText("css=div.summary"));
        }

        if ($username != 'staffmember') {
            $this->select("name=Visit[visit_status]", "label=Active");
            if ($username != 'agentoperator') {
                for ($second = 0;; $second++) {
                    if ($second >= 10)
                        $this->fail("timeout");
                    try {
                        if ("Displaying 1-4 of 4 results" == $this->getText("css=div.summary"))
                            break;
                    } catch (Exception $e) {
                        
                    }
                    sleep(1);
                }

                $this->assertEquals("Displaying 1-4 of 4 results", $this->getText("css=div.summary"));
            }
            $this->select("name=Visit[visit_status]", "label=Preregistered");
            for ($second = 0;; $second++) {
                if ($second >= 10)
                    $this->fail("timeout");
                try {
                    if ("Displaying 1-7 of 7 results" == $this->getText("css=div.summary"))
                        break;
                } catch (Exception $e) {
                    
                }
                sleep(1);
            }
            $this->assertEquals("Displaying 1-7 of 7 results", $this->getText("css=div.summary"));
        }
    }

}

?>
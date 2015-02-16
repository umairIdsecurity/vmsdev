<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue54FunctionalTest
 * Preload Data
 * @author Jeremiah
 */
class Issue54FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*iexplore");
        $this->setBrowserUrl("http://cvms.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
        $this->Scenario2();
        $this->Scenario3();
        $this->Scenario4();
        $this->Scenario5();
        $this->Scenario6();
        $this->Scenario7();
        $this->Scenario8();
        $this->resetDbWithData();
        $this->Scenario9();
    }

    /* Scenario 1 - Create a saved visit then preload data in register a visitor
      Expected Behavior -
     *      Assert Workstation1 in workstation form
     *      Assert Reason1 in reason form
      Assert staffmember@test.com in host email field
     *      */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[2]/a/span");
        $this->click("id=clicktabA");
        $this->select("id=workstation", "label=Workstation1");
        $this->type("id=Visitor_vehicle", "BAC123");
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", "personpreload");
        $this->type("id=Visitor_contact_number", "123456");
        $this->type("id=Visitor_email", "personpreload@test.com");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->select("id=Visitor_tenant", "label=Test admin");
        $this->click("id=Visitor_tenant_agent");
        $this->click("id=submitFormVisitor");
        $this->type("id=User_first_name", "New");
        $this->type("id=User_last_name", "PreloadHost");
        $this->type("id=User_email", "preloadhost@test.com");
        $this->type("id=User_contact_number", "123456");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        $this->select("id=User_tenant", "label=Test admin");
        sleep(1);
        $this->clickAndWait("id=submitFormUser");
        try {
            $this->assertEquals("personpreload@test.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->assertEquals("Visit Status: Saved", $this->getText("link=Visit Status: Saved"));
        $this->clickAndWait("link=Dashboard");
        $this->clickAndWait("css=span");
        $this->click("id=clicktabA");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->waitForElementPresent("id=5");
        $this->click("id=5");
        sleep(1);
        $this->assertEquals("Select Workstation Workstation1 Workstation2 Workstation3", $this->getText("id=workstation_search"));
        $this->assertEquals("Select Reason Reason 1 Reason 2 Other", $this->getText("id=Visit_reason_search"));
        $this->click("id=clicktabB1");
        $this->click("id=saveCurrentUserAsHost");
        $this->clickAndWait("id=submitAllForms");
        $this->clickAndWait("css=#activate-a-visit-form > input.complete");
        $this->clickAndWait("link=Active");
        try {
            $this->assertEquals("personpreload@test.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->assertEquals("Visit Status: Active", $this->getText("link=Visit Status: Active"));
    }

    /* Scenario 2 Create a saved visit
     * Expected Behavior
      Assert preloadvisitor2@test.com in visitor records page
      Assert visit status: saved
      Assert saved in visit status table
      Assert displaying 1-1 of 1 result

     */

    function Scenario2() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[2]/a/span");
        $this->click("id=clicktabA");
        $this->select("id=workstation", "label=Workstation1");
        $this->type("id=Visitor_vehicle", "ABC123");
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", "preload2");
        $this->type("id=Visitor_contact_number", "123456");
        $this->type("id=Visitor_email", "preloadvisitor2@test.com");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->select("id=Visitor_tenant", "label=Test admin");
        $this->click("id=submitFormVisitor");
        $this->type("id=User_first_name", "test");
        $this->type("id=User_last_name", "host1");
        $this->type("id=User_department", "host2@test.com");
        $this->type("id=User_contact_number", "12345");
        $this->type("id=User_email", "host2@test.com");
        $this->type("id=User_department", "department");
        $this->type("id=User_staff_id", "12345");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        $this->select("id=User_tenant", "label=Test admin");
        sleep(1);
        $this->clickAndWait("id=submitFormUser");
        try {
            $this->assertEquals("preloadvisitor2@test.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->assertEquals("Visit Status: Saved", $this->getText("link=Visit Status: Saved"));
        $this->clickAndWait("link=Visitor Records");
        $this->assertEquals("preloadvisitor2@test.com", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[8]"));
        $this->assertEquals("Saved", $this->getText("link=Saved"));
    }

    /* Scenario 3 Preregister a visit using saved visit in visitor detail page
      Expected Behavior
      Assert Visit Status: Preregistered
      Assert preloadvisitor2@test.com in visitor email
     */

    function Scenario3() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Visitor Records");
        $this->clickAndWait("link=Saved");
        $this->assertEquals("Visit Status: Saved", $this->getText("link=Visit Status: Saved"));
        $this->click("//li[@id='preregisterLi']/a/span");
        $this->clickAndWait("css=#update-log-visit-form > input.complete");
        $this->assertEquals("Preregistered", $this->getText("link=Preregistered"));
        $this->clickAndWait("link=Preregistered");
        try {
            $this->assertEquals("Visit Status: Preregistered", $this->getText("css=#actionsCssMenu > ul > li"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        try {
            $this->assertEquals("preloadvisitor2@test.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->clickAndWait("link=Visitor Records");
        $this->select("name=Visit[visit_status]", "label=Saved");
        sleep(1);
        $this->assertEquals("No results found.", $this->getText("css=span.empty"));
    }

    /* Scenario 4 Activate a visit using saved visit in visitor detail page
      Expected Behavior
      Assert Visit Status: Active
      Assert preloadvisitor2@test.com in visitor email

     */

    function Scenario4() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Visitor Records");
        $this->clickAndWait("link=Preregistered");
        $this->assertEquals("Visit Status: Preregistered", $this->getText("link=Visit Status: Preregistered"));
        try {
            $this->assertEquals("preloadvisitor2@test.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->clickAndWait("id=cancelPreregisteredVisitButton");
        $this->assertEquals("Visit Status: Saved", $this->getText("link=Visit Status: Saved"));
        $this->click("//li[@id='activateLi']/a/span");
        $this->clickAndWait("css=#activate-a-visit-form > input.complete");
        $this->clickAndWait("link=Active");
        try {
            $this->assertEquals("preloadvisitor2@test.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->assertEquals("Visit Status: Active", $this->getText("link=Visit Status: Active"));
        $this->clickAndWait("link=Visitor Records");
        $this->select("name=Visit[visit_status]", "label=Saved");
        sleep(1);
        $this->assertEquals("No results found.", $this->getText("css=span.empty"));
    }

    /* Scenario 5 Preregister a visit using saved visit and check for validation errors
      Expected Behavior
      Assert alert “A visit has already been preregistered in the same day. “

     */

    function Scenario5() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Visitor Records");
        $this->clickAndWait("link=Active");
        try {
            $this->assertEquals("preloadvisitor2@test.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->clickAndWait("id=cancelActiveVisitButton");
        $this->assertEquals("Visit Status: Saved", $this->getText("link=Visit Status: Saved"));
        $this->click("//li[@id='preregisterLi']/a/span");
        $this->clickAndWait("css=#update-log-visit-form > input.complete");
        $this->clickAndWait("link=Preregistered");
        $this->assertEquals("Visit Status: Preregistered", $this->getText("link=Visit Status: Preregistered"));
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[2]/a/span");
        $this->click("id=clicktabA");
        $this->type("id=search-visitor", "preload2");
        $this->click("id=dummy-visitor-findBtn");
        $this->waitForElementPresent("id=6");
        $this->click("id=6");
        $this->select("id=workstation_search", "label=Workstation1");
        $this->select("id=Visit_reason_search", "label=Reason 1");
        $this->click("id=clicktabB1");
        $this->type("id=search-host", "staffmember");
        $this->click("id=dummy-host-findBtn");
        $this->waitForElementPresent("id=21");
        $this->click("id=21");
        $this->clickAndWait("id=clicktabB2");
        $this->click("//li[@id='preregisterLi']/a/span");
        $this->click("css=#update-log-visit-form > input.complete");
        sleep(1);
        $this->assertEquals("A visit has already been preregistered in the same day.", $this->getAlert());
    }

    /* Scenario 6 Activate a visit using saved visit and check for validation errors
      Expected Behavior
      Assert alert “A visit has already been preregistered in the same day. “
     */

    function Scenario6() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Visitor Records");
        $this->clickAndWait("link=Active");
        try {
            $this->assertEquals("personpreload@test.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->assertEquals("Visit Status: Active", $this->getText("link=Visit Status: Active"));
        $this->clickAndWait("id=cancelActiveVisitButton");
        $this->assertEquals("Visit Status: Saved", $this->getText("link=Visit Status: Saved"));
        $this->click("//li[@id='activateLi']/a/span");
        $this->clickAndWait("css=#activate-a-visit-form > input.complete");
        $this->clickAndWait("link=Preregister a Visit");
        $this->click("id=clicktabA");
        $this->type("id=search-visitor", "preload2");
        $this->click("id=dummy-visitor-findBtn");
        $this->waitForElementPresent("id=6");
        $this->click("id=6");
        $this->click("id=clicktabB1");
        sleep(1);
        $this->clickAndWait("id=saveCurrentUserAsHost");
        $this->assertEquals("Visit Status: Saved", $this->getText("link=Visit Status: Saved"));
        $this->click("//li[@id='preregisterLi']/a/span");
        $this->click("css=#update-log-visit-form > input.complete");
        sleep(1);
        $this->assertEquals("A visit has already been preregistered in the same day.", $this->getAlert());
    }

    /* Scenario 7 Cancel Preregistered Visit
      Expected Behavior
      Assert Visit Status: Saved

     */

    function Scenario7() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Visitor Records");
        $this->clickAndWait("link=Preregistered");
        $this->assertEquals("Visit Status: Preregistered", $this->getText("link=Visit Status: Preregistered"));
        try {
            $this->assertEquals("preloadvisitor2@test.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->clickAndWait("id=cancelPreregisteredVisitButton");
        $this->assertEquals("Visit Status: Saved", $this->getText("link=Visit Status: Saved"));
    }

    /* Scenario 8 Cancel Active Visit
      Expected Behavior
      Assert Visit Status: Saved

     */

    function Scenario8() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Visitor Records");
        $this->clickAndWait("link=Active");
        $this->assertEquals("Visit Status: Active", $this->getText("link=Visit Status: Active"));
        try {
            $this->assertEquals("personpreload@test.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->clickAndWait("id=cancelActiveVisitButton");
        $this->assertEquals("Visit Status: Saved", $this->getText("link=Visit Status: Saved"));
    }

    /* Scenario 9 Created a saved visit with new reason
      Expected Behavior
      Assert reason for save visit in reason field


     */

    function Scenario9() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Dashboard");
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[2]/a/span");
        $this->click("id=clicktabA");
        $this->type("id=Visitor_first_name", "person");
        $this->type("id=Visitor_last_name", "person");
        $this->type("id=Visitor_email", "person@test.com");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->select("id=workstation", "label=Workstation2");
        $this->select("id=workstation", "label=Workstation1");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->type("id=Visitor_contact_number", "1234567");
        $this->select("id=Visitor_tenant", "label=Test admin");
        $this->click("id=submitFormVisitor");
        $this->type("id=User_first_name", "hostperson");
        $this->type("id=User_last_name", "hostperson");
        $this->type("id=User_email", "hostperson@test.com");
        $this->type("id=User_contact_number", "123456");
        $this->select("id=User_tenant", "label=Test admin");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        $this->type("id=User_department", "department");
        $this->type("id=User_staff_id", "1234567");
        $this->clickAndWait("id=submitFormUser");
        $this->assertEquals("Visit Status: Saved", $this->getText("link=Visit Status: Saved"));
        $this->clickAndWait("css=span");
        $this->click("id=clicktabA");
        $this->type("id=search-visitor", "person person");
        $this->click("id=dummy-visitor-findBtn");
        $this->waitForElementPresent("id=5");
        $this->assertEquals("person@test.com", $this->getText("//div[@id='findvisitor-grid']/table/tbody/tr/td[3]"));
        $this->select("id=workstation_search", "label=Workstation1");
        $this->click("id=5");
        $this->select("id=Visit_reason_search", "label=Other");
        $this->type("id=VisitReason_reason_search", "reason for save visit");
        sleep(1);
        $this->click("id=clicktabB1");
        $this->click("id=saveCurrentUserAsHost");
        $this->clickAndWait("id=submitAllForms");
        $this->clickAndWait("css=#activate-a-visit-form > input.complete");
        $this->clickAndWait("link=Active");
        $this->assertEquals("Visit Status: Active", $this->getText("link=Visit Status: Active"));
        // $this->assertEquals("Select Reason Other Reason 1 Reason 2 Reason For Save Visit", $this->getText("id=Visit_reason"));
        try {
            $this->assertEquals("person@test.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
    }

}

?>
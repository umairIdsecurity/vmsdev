<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';
date_default_timezone_set('Asia/Manila');

/**
 * Description of Issue26FunctionalTest
 * Functional Test for issue 28 view my visitors dashboard - for staffmembers only
 * @author Jeremiah
 */
class Issue28RegisterFunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
        $this->Scenario2();
        $this->Scenario3();
        $this->Scenario4();
        $this->Scenario5();
        $this->Scenario6();
        $this->resetDbWithData();
        $this->Scenario7();
        $this->Scenario8();
        $this->Scenario9();
        $this->Scenario10();
        $this->Scenario11();
        $this->Scenario12();
        $this->Scenario13();
        $this->Scenario14();
    }

    /* Scenario 1 – Login as staff member and add visitor record with new host

     */

    function Scenario1() {
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->assertEquals("Visitor Management System - Viewmyvisitors Dashboard", $this->getTitle());
        $this->assertEquals("Add Host", $this->getText("id=yt0"));
        $this->assertEquals("Log Visit", $this->getText("css=a > span"));
        $this->assertEquals("Search Visits", $this->getText("link=Search Visits"));
        $this->assertEquals("Evacuation Report", $this->getText("link=Evacuation Report"));
        $this->clickAndWait("css=a > span");
        $this->click("id=clicktabA");
        $this->assertEquals("Corporate Visitor", $this->getText("id=Visitor_visitor_type"));
        
        $this->type("id=Visitor_first_name", "Test");
        $this->type("id=Visitor_last_name", "staffmembervisitor");
        $this->type("id=Visitor_contact_number", "123456");
        $this->type("id=Visitor_email", "staffmembervisitor@test.com");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->type("id=Visitor_password", "123");
        $this->type("id=Visitor_repeatpassword", "123");
        $this->select("id=workstation", "label=Workstation1");
        $this->click("id=submitFormVisitor");
        $this->click("css=button.host-AddBtn");
        $this->type("id=User_first_name", "test");
        $this->type("id=User_last_name", "staffmemberhost");
        $this->type("id=User_email", "staffmemberhost@test.com");
        $this->type("id=User_contact_number", "123456");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        $this->clickAndWait("id=submitFormUser");
        $this->type("id=Visitor_photo","1");
        $this->click("css=#activate-a-visit-form > input.complete");
        sleep(10);
        $this->assertEquals("Visit is now activated. You can now print the visitor badge.", $this->getAlert());
        //$this->assertEquals("Same Day Visitor", $this->getText("css=#cardDetailsTable > tbody > tr > td"));
        $this->assertEquals("Test staffmembervisitor", $this->getText("//table[@id='cardDetailsTable']/tbody/tr[3]/td"));
        //$this->assertEquals("Test Company 1", $this->getText("//table[@id='cardDetailsTable']/tbody/tr[3]/td"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $this->type("id=LoginForm_username", "staffmemberhost@test.com");
        $this->type("id=LoginForm_password", "12345");
        $this->click("name=yt0");
        $this->clickAndWait("name=yt0");
        $this->clickAndWait("link=Visit History");
        $this->assertEquals("staffmembervisitor", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[5]"));
        $this->assertEquals("staffmembervisitor@test.com", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[8]"));
        $currentDate = date("d-m-Y");
        $this->assertEquals($currentDate, $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[9]"));
        $this->clickAndWait("link=Active");
        $this->assertEquals("Select Reason Other Reason 1 Reason 2", $this->getText("id=Visit_reason"));
    }

    /* Scenario 2 – Login as staffmember, add new visitor, current staffmember as host

     */

    function Scenario2() {
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("css=a > span");
        $this->click("id=clicktabA");
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", "staffmembervisitor2");
        $this->type("id=Visitor_contact_number", "123456");
        $this->type("id=Visitor_email", "staffmembervisitor2@test.com");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->select("id=workstation", "label=Workstation1");
        $this->click("id=submitFormVisitor");
        $this->waitForElementPresent("id=saveCurrentUserAsHost");
        $this->click("id=saveCurrentUserAsHost");
        $this->clickAndWait("id=submitAllForms");
        $this->clickAndWait("link=Visit History");
        $this->assertEquals("staffmembervisitor2", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[5]"));
        $this->assertEquals("staffmembervisitor2@test.com", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[8]"));
        $currentDate = date("d-m-Y");
//        $this->assertEquals($currentDate, $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[9]"));
        $this->clickAndWait("link=Saved");
        $this->assertEquals("Select Reason Other Reason 1 Reason 2", $this->getText("id=Visit_reason"));
    }

    /* Scenario 3 –Login as staff member add visitor and find host 
     */

    function Scenario3() {
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("css=a > span");
        $this->click("id=clicktabA");
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", "staffmembervisitor3");
        $this->type("id=Visitor_contact_number", "123456");
        $this->type("id=Visitor_email", "staffmembervisitor3@test.com");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->select("id=workstation", "label=Workstation1");
        $this->click("id=submitFormVisitor");
        $this->type("id=search-host", "test");
        $this->click("id=dummy-host-findBtn");
        $this->waitForElementPresent("id=21");
        $this->click("id=21");
        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Selected Host Record : Test staffmember" == $this->getText("css=#searchHostTableDiv > h4"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Selected Host Record : Test staffmember", $this->getText("css=#searchHostTableDiv > h4"));
        $this->click("id=clicktabB2");
        $this->clickAndWait("id=submitAllForms");
        $this->clickAndWait("link=Visit History");
        $this->assertEquals("staffmembervisitor3", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[5]"));
        $this->assertEquals("staffmembervisitor3@test.com", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[8]"));
        $currentDate = date("d-m-Y");
        //$this->assertEquals($currentDate, $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[9]"));
        $this->clickAndWait("link=Saved");
        $this->assertEquals("Select Reason Other Reason 1 Reason 2", $this->getText("id=Visit_reason"));
    }

    /* Scenario 4 –Login as super admin and Check for validations in updating a corporate visitor
     */

    function Scenario4() {
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("css=a > span");
        $this->click("id=clicktabA");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->waitForElementPresent("id=2");
        $this->click("id=2");
        $this->select("id=Visit_reason_search", "label=Reason 1");
        $this->select("id=workstation_search", "label=Workstation1");
        $this->click("id=clicktabB1");
        $this->waitForElementPresent("css=button.host-AddBtn");
        $this->click("css=button.host-AddBtn");
        $this->waitForElementPresent("id=User_first_name");
        $this->type("id=User_first_name", "test");
        $this->type("id=User_last_name", "staffmemberhost");
        $this->type("id=User_last_name", "staffmemberhost2@test.com");
        $this->type("id=User_department", "department");
        $this->type("id=User_staff_id", "123456");
        $this->type("id=User_email", "staffmemberhost2@test.com");
        $this->type("id=User_contact_number", "123456");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        
        $this->click("id=submitFormUser");
        $this->clickAndWait("id=submitAllForms");
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $this->type("id=LoginForm_username", "staffmemberhost2@test.com");
        $this->type("id=LoginForm_password", "12345");
        $this->click("name=yt0");
        $this->clickAndWait("name=yt0");
        $this->clickAndWait("link=Visit History");
        $this->assertEquals("Visitor1", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[5]"));
        $this->assertEquals("testVisitor1@test.com", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[8]"));
        $currentDate = date("d-m-Y");
      //  $this->assertEquals($currentDate, $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[9]"));
        $this->clickAndWait("link=Saved");
        $this->assertEquals("Select Reason Other Reason 1 Reason 2", $this->getText("id=Visit_reason"));
    }

    /* Scenario 5 – Login as saffmember register a visitor : find visitor use current logged in as host

     */

    function Scenario5() {
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("css=a > span");
        $this->click("id=clicktabA");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->waitForElementPresent("id=3");
        $this->click("id=3");
        $this->select("id=Visit_reason_search", "label=Reason 1");
        $this->select("id=workstation_search", "label=Workstation1");
        $this->click("id=clicktabB1");
        
        $this->waitForElementPresent("id=saveCurrentUserAsHost");
        $this->click("id=saveCurrentUserAsHost");
        $this->clickAndWait("id=submitAllForms");
        $this->clickAndWait("link=Visit History");
        $this->assertEquals("Visitor3", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[5]"));
        $this->assertEquals("testVisitor3@test.com", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[8]"));
        $currentDate = date("d-m-Y");
        //$this->assertEquals($currentDate, $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[9]"));
        $this->clickAndWait("link=Saved");
        $this->assertEquals("Select Reason Other Reason 1 Reason 2", $this->getText("id=Visit_reason"));
    }

    /*
      Scenario 6- Login as staffmember preregister a visit : find visitor find host
     */

    function Scenario6() {
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("css=a > span");
        $this->click("id=clicktabA");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->waitForElementPresent("id=4");
        $this->click("id=4");
        $this->select("id=Visit_reason_search", "label=Reason 1");
        $this->select("id=workstation_search", "label=Workstation1");
        $this->click("id=clicktabB1");
        $this->waitForElementPresent("id=search-host");
        $this->type("id=search-host", "test");
        $this->click("id=dummy-host-findBtn");
        $this->waitForElementPresent("id=24");
        $this->click("id=24");
        $this->click("id=clicktabB2");
        $this->clickAndWait("id=submitAllForms");
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $this->type("id=LoginForm_username", "staffmemberhost@test.com");
        $this->type("id=LoginForm_password", "12345");
        $this->click("name=yt0");
        $this->clickAndWait("name=yt0");
        $this->clickAndWait("link=Visit History");
        $this->assertEquals("Visitor4", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[5]"));
        $this->assertEquals("testVisitor4@test.com", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[8]"));
       $currentDate = date("d-m-Y");
       //$this->assertEquals($currentDate, $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[9]"));
        $this->clickAndWait("link=Saved");
        $this->assertEquals("Select Reason Other Reason 1 Reason 2", $this->getText("id=Visit_reason"));
    }

    /*
      Scenario 7- Login as staff member add new visitor add new host with new reason
     */

    function Scenario7() {
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("css=a > span");
        $this->click("id=clicktabA");
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", "staffmembervisitor4");
        $this->type("id=Visitor_position", "position");
        $this->type("id=Visitor_contact_number", "123456");
        $this->type("id=Visitor_email", "staffmembervisitor4@test.com");
        $this->select("id=Visit_reason", "label=Other");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->type("id=VisitReason_reason", "reason 3");
        $this->select("id=workstation", "label=Workstation1");
        $this->click("id=submitFormVisitor");
        $this->waitForElementPresent("css=button.host-AddBtn");
        $this->click("css=button.host-AddBtn");
        $this->type("id=User_first_name", "test");
        $this->type("id=User_last_name", "staffmemberhost");
        $this->type("id=User_last_name", "staffmemberhost3");
        $this->type("id=User_department", "department");
        $this->type("id=User_staff_id", "123456");
        $this->type("id=User_email", "staffmemberhost3@test.com");
        $this->type("id=User_contact_number", "123456");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        $this->click("id=submitFormUser");
        $this->clickAndWait("id=submitAllForms");
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $this->type("id=LoginForm_username", "staffmemberhost3@test.com");
        $this->type("id=LoginForm_password", "12345");
        $this->click("name=yt0");
        $this->clickAndWait("name=yt0");
        $this->clickAndWait("link=Visit History");
        $this->assertEquals("staffmembervisitor4", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[5]"));
        $this->assertEquals("staffmembervisitor4@test.com", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[8]"));
        $currentDate = date("d-m-Y");
     //   $this->assertEquals($currentDate, $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[9]"));
        $this->clickAndWait("link=Saved");
        $this->assertEquals("Select Reason Other Reason 1 Reason 2 Reason 3", $this->getText("id=Visit_reason"));
    }

    /*
      Scenario 8- Login as staff member add new visitor select current logged in user as host add new reason
     */

    function Scenario8() {
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("css=a > span");
        $this->click("id=clicktabA");
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", "staffmembervisitor5");
        $this->type("id=Visitor_position", "position");
        $this->type("id=Visitor_contact_number", "123456");
        $this->type("id=Visitor_email", "staffmembervisitor5@test.com");
        $this->select("id=Visit_reason", "label=Other");
        $this->type("id=Visitor_password", "1234");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->type("id=VisitReason_reason", "Reason 4");
        $this->select("id=workstation", "label=Workstation1");
        $this->click("id=submitFormVisitor");
        $this->waitForElementPresent("id=saveCurrentUserAsHost");
        $this->click("id=saveCurrentUserAsHost");
        $this->clickAndWait("id=submitAllForms");
        $this->assertEquals("test staffmembervisitor5", $this->getText("//table[@id='cardDetailsTable']/tbody/tr[3]/td"));
        $this->clickAndWait("link=Visit History");
        $this->assertEquals("staffmembervisitor5", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[5]"));
        $this->assertEquals("staffmembervisitor5@test.com", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[8]"));
        $currentDate = date("d-m-Y");
      //  $this->assertEquals($currentDate, $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[9]"));
        $this->clickAndWait("link=Saved");
        $this->assertEquals("Select Reason Other Reason 1 Reason 2 Reason 3 Reason 4", $this->getText("id=Visit_reason"));
    }

    /*
      Scenario 9- Login as staff member add new visitor find host add new reason
     */

    function Scenario9() {
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("css=a > span");
        $this->click("id=clicktabA");
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", "staffmembervisitor6");
        $this->type("id=Visitor_position", "position");
        $this->type("id=Visitor_contact_number", "123456");
        $this->type("id=Visitor_email", "staffmembervisitor6@test.com");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->select("id=Visit_reason", "label=Other");
        $this->type("id=VisitReason_reason", "Reason 5");
        $this->select("id=workstation", "label=Workstation1");
        $this->click("id=submitFormVisitor");
        $this->waitForElementPresent("id=search-host");
        $this->type("id=search-host", "test");
        $this->click("id=dummy-host-findBtn");
        $this->waitForElementPresent("id=24");
        $this->click("id=24");
        $this->click("id=clicktabB2");
        $this->clickAndWait("id=submitAllForms");
        $this->assertEquals("test staffmembervisitor6", $this->getText("//table[@id='cardDetailsTable']/tbody/tr[3]/td"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $this->type("id=LoginForm_username", "staffmemberhost3@test.com");
        $this->type("id=LoginForm_password", "12345");
        $this->click("name=yt0");
        $this->clickAndWait("name=yt0");
        $this->clickAndWait("link=Visit History");
        $this->assertEquals("staffmembervisitor6", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[5]"));
        $this->assertEquals("staffmembervisitor6@test.com", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[8]"));
        $currentDate = date("d-m-Y");
        //$this->assertEquals($currentDate, $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[9]"));
        $this->clickAndWait("link=Saved");
        $this->assertEquals("Select Reason Other Reason 1 Reason 2 Reason 3 Reason 4 Reason 5", $this->getText("id=Visit_reason"));
    }

    /*
      Scenario 10- Login as staff member find visitor add host add new reason
     */

    function Scenario10() {
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("css=a > span");
        $this->click("id=clicktabA");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->waitForElementPresent("id=2");
        $this->click("id=2");
        $this->select("id=Visit_reason_search", "label=Other");
        $this->type("id=VisitReason_reason_search", "Reason 6");
        $this->select("id=workstation_search", "label=Workstation1");
        $this->click("id=clicktabB1");
        $this->waitForElementPresent("css=button.host-AddBtn");
        $this->click("css=button.host-AddBtn");
        $this->type("id=User_first_name", "test");
        $this->type("id=User_last_name", "staffmember3");
        $this->type("id=User_last_name", "staffmemberhost4");
        $this->type("id=User_department", "department");
        $this->type("id=User_staff_id", "123456");
        $this->type("id=User_email", "staffmemberhost4@test.com");
        $this->type("id=User_contact_number", "123456");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        $this->click("id=submitFormUser");
        $this->clickAndWait("id=submitAllForms");
        $this->assertEquals("Test Visitor1", $this->getText("//table[@id='cardDetailsTable']/tbody/tr[3]/td"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $this->type("id=LoginForm_username", "staffmemberhost4@test.com");
        $this->type("id=LoginForm_password", "12345");
        $this->click("name=yt0");
        $this->clickAndWait("name=yt0");
        $this->clickAndWait("link=Visit History");
        $this->assertEquals("Visitor1", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[5]"));
        $this->assertEquals("testVisitor1@test.com", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[8]"));
        $currentDate = date("d-m-Y");
        //$this->assertEquals($currentDate, $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[9]"));
        $this->clickAndWait("link=Saved");
        $this->assertEquals("Select Reason Other Reason 1 Reason 2 Reason 3 Reason 4 Reason 5 Reason 6", $this->getText("id=Visit_reason"));
    }

    /*
      Scenario 11- Login as staff member find visitor select current logged in user as host and add new reason
     */

    function Scenario11() {
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("css=a > span");
        $this->waitForPageToLoad("30000");
        $this->click("id=clicktabA");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->waitForElementPresent("id=3");
        $this->click("id=3");
        $this->select("id=Visit_reason_search", "label=Other");
        $this->type("id=VisitReason_reason_search", "Reason 7");
        $this->select("id=workstation_search", "label=Workstation1");
        $this->click("id=clicktabB1");
        $this->waitForElementPresent("id=saveCurrentUserAsHost");
        $this->click("id=saveCurrentUserAsHost");
        $this->clickAndWait("id=submitAllForms");
        $this->assertEquals("Test Visitor3", $this->getText("//table[@id='cardDetailsTable']/tbody/tr[3]/td"));
        $this->clickAndWait("link=Visit History");
        $this->assertEquals("Visitor3", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[5]"));
        $this->assertEquals("testVisitor3@test.com", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[8]"));
        $currentDate = date("d-m-Y");
        //$this->assertEquals($currentDate, $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[9]"));
        $this->clickAndWait("link=Saved");
        $this->assertEquals("Select Reason Other Reason 1 Reason 2 Reason 3 Reason 4 Reason 5 Reason 6 Reason 7", $this->getText("id=Visit_reason"));
    }

    /*
      Scenario 12- Login as staff member find visitor find host and add new reason
     */

    function Scenario12() {
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("css=a > span");
        $this->click("id=clicktabA");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->waitForElementPresent("id=4");
        $this->click("id=4");
        $this->select("id=Visit_reason_search", "label=Other");
        $this->type("id=VisitReason_reason_search", "reason 8");
        $this->select("id=workstation_search", "label=Workstation1");
        $this->click("id=clicktabB1");

        $this->type("id=search-host", "test");
        $this->click("id=dummy-host-findBtn");
        $this->waitForElementPresent("id=24");
        $this->click("id=24");
        $this->click("id=clicktabB2");
        $this->clickAndWait("id=submitAllForms");
        $this->assertEquals("Test Visitor4", $this->getText("//table[@id='cardDetailsTable']/tbody/tr[3]/td"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $this->type("id=LoginForm_username", "staffmemberhost3@test.com");
        $this->type("id=LoginForm_password", "12345");
        $this->click("name=yt0");
        $this->clickAndWait("name=yt0");
        $this->clickAndWait("link=Visit History");
        $this->assertEquals("Visitor4", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[5]"));
        $this->assertEquals("testVisitor4@test.com", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[8]"));
        $this->clickAndWait("link=Saved");
        $this->assertEquals("Select Reason Other Reason 1 Reason 2 Reason 3 Reason 4 Reason 5 Reason 6 Reason 7 Reason 8", $this->getText("id=Visit_reason"));
    }

    /*
      Scenario 13- Login as staff member check validations for preregistering a visitor
     */

    function Scenario13() {
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("css=a > span");
        $this->click("id=clicktabA");
        $this->click("id=submitFormVisitor");
        for ($second = 0;; $second++) {
            if ($second >= 60)
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
        $this->type("id=Visitor_contact_number", "123456");
        $this->type("id=Visitor_email", "testvisitor1@test.com");
        $this->select("id=Visit_reason", "label=Other");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "1234");
        $this->select("id=workstation", "label=Workstation1");
        $this->waitForElementPresent("//table[@id='addvisitor-table']/tbody/tr[4]/td[3]/div");
        $this->assertEquals("New Password does not match with Repeat \n New Password.", $this->getText("//table[@id='addvisitor-table']/tbody/tr[4]/td[2]/div"));
        $this->click("id=submitFormVisitor");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->click("id=submitFormVisitor");
        $this->waitForElementPresent("css=td > div.errorMessage.visitorReason");
        $this->assertEquals("Please select a reason", $this->getText("css=td > div.errorMessage.visitorReason"));
        $this->type("id=VisitReason_reason", "test");
        $this->click("id=submitFormVisitor");
        $this->waitForElementPresent("xpath=(//div[@id='Visitor_email_em_'])[2]");
        $this->assertEquals("A profile already exists for this email address.", $this->getText("xpath=(//div[@id='Visitor_email_em_'])[2]"));
        $this->type("id=Visitor_email", "test@test.com");
        $this->click("id=submitFormVisitor");
        $this->click("css=button.host-AddBtn");
        $this->click("id=submitFormUser");
        for ($second = 0;; $second++) {
            if ($second >= 60)
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
        $this->assertEquals("Please enter a Repeat Password", $this->getText("id=User_repeatpassword_em_"));
        $this->assertEquals("Please enter a Password", $this->getText("id=User_password_em_"));
        $this->type("id=User_first_name", "test");
        $this->type("id=User_last_name", "test");
        $this->type("id=User_email", "staffmember@test.com");
        $this->type("id=User_contact_number", "123456");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "123");
        $this->type("id=User_staff_id", "123456");
        $this->assertEquals("New Password does not match with \nRepeat New Password.", $this->getText("id=passwordErrorMessage"));
        $this->type("id=User_repeatpassword", "12345");
        $this->click("id=submitFormUser");
        $this->assertEquals("A profile already exists for this email address.", $this->getText("xpath=(//div[@id='User_email_em_'])[2]"));
        $this->click("id=dummy-host-findBtn");
        $this->assertEquals("Search Name cannot be blank.", $this->getText("id=searchTextHostErrorMessage"));
        $this->type("id=search-host", "test");
        $this->click("id=dummy-host-findBtn");
        $this->click("id=clicktabB2");
        $this->waitForElementPresent("id=searchTextHostErrorMessage");
        $this->assertEquals("Please select a host", $this->getText("id=searchTextHostErrorMessage"));
    }

    /*
      Scenario 14- Login as staff member and add host
     */

    function Scenario14() {
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->click("id=yt0");
        $this->waitForElementPresent("id=User_first_name");
        $this->type("id=User_first_name", "Test");
        $this->type("id=User_last_name", "newhost");
        $this->type("id=User_department", "department");
        $this->type("id=User_staff_id", "12345");
        $this->type("id=User_email", "testnewhost@test.com");
        $this->type("id=User_contact_number", "123456");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        $this->clickAndWait("id=submitFormUser");
        $this->clickAndWait("css=a > span");
        $this->click("id=clicktabA");
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", "test");
        $this->type("id=Visitor_position", "position");
        $this->type("id=Visitor_contact_number", "123456");
        $this->type("id=Visitor_email", "testtest@test.com");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->select("id=workstation", "label=Workstation1");
        $this->click("id=submitFormVisitor");
        $this->waitForElementPresent("id=search-host");
        $this->type("id=search-host", "test");
        $this->click("id=dummy-host-findBtn");
        $this->waitForElementPresent("//div[@id='findHost-grid']/table/tbody/tr[5]/td[2]");
        $this->assertEquals("newhost", $this->getText("//div[@id='findHost-grid']/table/tbody/tr[7]/td[2]"));
        $this->assertEquals("testnewhost@test.com", $this->getText("//div[@id='findHost-grid']/table/tbody/tr[7]/td[3]"));
        
        $this->click("id=yt0");
        sleep(2);
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

    /*Scenario15*/
    function Scenario16(){
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        
    }
}

?>

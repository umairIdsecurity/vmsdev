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
class Issue28PreregisterFunctionalTest extends BaseFunctionalTest {

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
        $this->Scenario7();
        $this->Scenario8();
        $this->Scenario9();
        $this->Scenario10();
        $this->Scenario11();
        $this->Scenario12();
        $this->Scenario13();
    }

    /* Scenario 1 – Login as staff member and add visitor record with new host
     */

    function Scenario1() {
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->assertEquals("Visitor Management System - Viewmyvisitors Dashboard", $this->getTitle());
        $this->assertEquals("Log Visit", $this->getText("css=a > span"));
        $this->assertEquals("Preregister Visit", $this->getText("//div[@id='cssmenu']/ul/li[2]/a/span"));
        $this->assertEquals("Add Host", $this->getText("id=yt0"));
        $this->assertEquals("Search Visits", $this->getText("//div[@id='cssmenu']/ul/li[5]/a/span"));
        $this->assertEquals("Evacuation Report", $this->getText("link=Evacuation Report"));
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[2]/a/span");
        $this->click("id=clicktabA");
        $this->assertEquals("Corporate Visitor", $this->getText("id=Visitor_visitor_type"));
        
        $this->type("id=Visitor_first_name", "Test");
        $this->type("id=Visitor_last_name", "staffmembervisitor");
        $this->type("id=Visitor_contact_number", "123456");
        $this->type("id=Visitor_email", "staffmembervisitor@test.com");
        $this->select("id=Visit_reason", "label=Reason 1");
        sleep(1);
        $this->select("id=workstation", "label=Workstation1");
        $this->select("id=Visitor_company", "label=NAIA Airport");
        sleep(1);
        $this->click("id=submitFormVisitor");

        $this->click("css=button.host-AddBtn");
        $this->type("id=User_first_name", "test");
        $this->type("id=User_last_name", "staffmemberhost");
        $this->type("id=User_email", "staffmemberhost@test.com");
        $this->type("id=User_contact_number", "123456");
        $this->clickAndWait("id=submitFormUser");
        $this->assertEquals("Test staffmembervisitor", $this->getText("//table[@id='cardDetailsTable']/tbody/tr[3]/td")); 
    }

    /* Scenario 2 – Login as staffmember, add new visitor, current staffmember as host

     */

    function Scenario2() {
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[2]/a/span");
        $this->click("id=clicktabA");
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", "staffmembervisitor");
        $this->type("id=Visitor_last_name", "staffmembervisitor2");
        $this->type("id=Visitor_contact_number", "123456");
        $this->type("id=Visitor_email", "staffmembervisitor2@test.com");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->select("id=workstation", "label=Workstation1");
        $this->select("id=workstation", "label=Workstation1");
        sleep(1);
        $this->select("id=Visitor_company", "label=NAIA Airport");
        $this->click("id=submitFormVisitor");
        $this->waitForElementPresent("id=saveCurrentUserAsHost");
        $this->clickAndWait("id=saveCurrentUserAsHost");
        $this->clickAndWait("link=Visit History");
        $this->clickAndWait("link=Saved");
        $this->click("//li[@id='preregisterLi']/a/span");
        $this->clickAndWait("css=#update-log-visit-form > input.complete");
        $this->clickAndWait("link=Dashboard");
        $this->assertEquals("staffmembervisitor2", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[4]"));
    }

    /* Scenario 3 –Login as staff member add visitor and find host 
     */

    function Scenario3() {
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[2]/a/span");
        $this->click("id=clicktabA");
        sleep(1);
        $this->select("id=workstation", "label=Workstation1");
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", "staffmembervisitor3");
        $this->type("id=Visitor_contact_number", "123456");
        $this->type("id=Visitor_email", "staffmembervisitor3@test.com");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->select("id=workstation", "label=Workstation1");
        sleep(1);
        $this->select("id=Visitor_company", "label=NAIA Airport");
        $this->click("id=submitFormVisitor");
        $this->click("link=Find Host");
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
        $this->clickAndWait("id=clicktabB2");
        $this->clickAndWait("link=Dashboard");
        $this->clickAndWait("link=Visit History");
        $this->clickAndWait("link=Saved");
        $this->click("//li[@id='preregisterLi']/a/span");
        $this->clickAndWait("css=#update-log-visit-form > input.complete");
        $this->clickAndWait("link=Dashboard");
        $this->assertEquals("staffmembervisitor3", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[4]"));
    }

    /* Scenario 4 –Login as super admin and Check for validations in updating a corporate visitor
     */

    function Scenario4() {
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->click("//div[@id='cssmenu']/ul/li[2]/a/span");
        $this->waitForPageToLoad("30000");
        $this->click("id=clicktabA");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->waitForElementPresent("id=5");
        $this->click("id=5");
        $this->select("id=Visit_reason_search", "label=Reason 1");
        $this->select("id=workstation_search", "label=Workstation1");
        $this->click("id=clicktabB1");
        $this->waitForElementPresent("css=button.host-AddBtn");
        $this->click("css=button.host-AddBtn");
        $this->waitForElementPresent("id=User_first_name");
        $this->type("id=User_first_name", "test");
        $this->type("id=User_last_name", "staffmemberhost2@test.com");
        $this->type("id=User_department", "department");
        $this->type("id=User_staff_id", "123456");
        $this->type("id=User_email", "staffmemberhost2@test.com");
        $this->type("id=User_contact_number", "123456");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        $this->clickAndWait("id=submitFormUser");
        $this->waitForElementPresent("//ul[@id='tabs']/li[3]/a/p");
        $username = 'staffmemberhost2@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Visit History");
        $this->clickAndWait("link=Saved");
        $this->click("//li[@id='preregisterLi']/a/span");
        $this->type("id=Visit_date_in", "10-02-2015");
        $this->type("id=Visit_date_out", "10-02-2015");
        $this->clickAndWait("css=#update-log-visit-form > input.complete");
        $this->clickAndWait("link=Dashboard");
        $this->assertEquals("staffmembervisitor", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[4]"));
    }

    /* Scenario 5 – Login as saffmember preregister a visitor : find visitor use current logged in as host

     */

    function Scenario5() {
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[2]/a/span");
        $this->click("id=clicktabA");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->waitForElementPresent("id=2");
        $this->click("id=2");
        $this->select("id=Visit_reason_search", "label=Reason 1");
        $this->select("id=workstation_search", "label=Workstation1");
        $this->click("id=clicktabB1");
        $this->waitForElementPresent("id=saveCurrentUserAsHost");
        $this->clickAndWait("id=saveCurrentUserAsHost");
        $this->clickAndWait("link=Visit History");
        $this->clickAndWait("link=Saved");
        $this->click("//li[@id='preregisterLi']/a/span");
        $this->clickAndWait("css=#update-log-visit-form > input.complete");
        $this->assertEquals("Visitor1", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[4]"));
        $this->assertEquals("testVisitor1@test.com", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[7]"));
    }

    /*
      Scenario 6- Login as staffmember preregister a visit : find visitor find host
     */

    function Scenario6() {
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[2]/a/span");
        $this->click("id=clicktabA");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->waitForElementPresent("id=2");
        $this->click("id=2");
        $this->select("id=Visit_reason_search", "label=Reason 1");
        $this->select("id=workstation_search", "label=Workstation1");
        $this->click("id=clicktabB1");
        $this->waitForElementPresent("id=search-host");
        $this->type("id=search-host", "test");
        $this->click("id=dummy-host-findBtn");
        $this->waitForElementPresent("id=24");
        $this->click("id=24");
        $this->clickAndWait("id=clicktabB2");
        
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
           }

    /*
      Scenario 7- Login as staff member add new visitor add new host with new reason
     */

    function Scenario7() {
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[2]/a/span");
        $this->click("id=clicktabA");
        sleep(1);
        $this->select("id=workstation", "label=Workstation1");
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", "staffmembervisitor4");
        $this->type("id=Visitor_position", "position");
        $this->type("id=Visitor_contact_number", "123456");
        $this->type("id=Visitor_email", "staffmembervisitor4@test.com");

        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");

        $this->select("id=Visit_reason", "label=Reason 1");
        $this->select("id=workstation", "label=Workstation1");
        $this->select("id=Visitor_company", "label=NAIA Airport");
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

        $this->clickAndWait("id=submitFormUser");
        $this->click("//li[@id='preregisterLi']/a/span");
        $this->type("id=Visit_date_in", "12-02-2015");
        $this->type("id=Visit_date_out", "12-02-2015");
        $this->clickAndWait("css=#update-log-visit-form > input.complete");
        
        $this->waitForElementPresent("//ul[@id='tabs']/li[3]/a/p");
          }

    /*
      Scenario 8- Login as staff member add new visitor select current logged in user as host add new reason
     */

    function Scenario8() {
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[2]/a/span");
        $this->click("id=clicktabA");
        sleep(1);
        $this->select("id=workstation", "label=Workstation1");
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", "staffmembervisitor5");
        $this->type("id=Visitor_position", "position");
        $this->type("id=Visitor_contact_number", "123456");
        $this->type("id=Visitor_email", "staffmembervisitor5@test.com");
        $this->select("id=Visit_reason", "label=Other");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->type("id=VisitReason_reason", "Reason 4");
        $this->select("id=workstation", "label=Workstation1");
        $this->select("id=Visitor_company", "label=NAIA Airport");
        $this->click("id=submitFormVisitor");
        $this->waitForElementPresent("id=saveCurrentUserAsHost");
        $this->clickAndWait("id=saveCurrentUserAsHost");
        
        $this->assertEquals("test staffmembervisitor5", $this->getText("//table[@id='cardDetailsTable']/tbody/tr[3]/td"));
        $this->click("//li[@id='preregisterLi']/a/span");
        $this->type("id=Visit_date_in", "13-02-2015");
        $this->type("id=Visit_date_out", "13-02-2015");
        $this->clickAndWait("css=#update-log-visit-form > input.complete");
        
        $this->clickAndWait("link=Dashboard");
        $this->assertEquals("staffmembervisitor5", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[4]"));
        $this->clickAndWait("link=Preregistered");
        $this->assertEquals("Please select a reason Other Reason 1 Reason 2 Reason 4", $this->getText("id=Visit_reason"));
    }

    /*
      Scenario 9- Login as staff member add new visitor find host add new reason
     */

    function Scenario9() {
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[2]/a/span");
        $this->click("id=clicktabA");
        sleep(1);
        $this->select("id=workstation", "label=Workstation1");
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
        $this->select("id=Visitor_company", "label=NAIA Airport");
        $this->click("id=submitFormVisitor");
        $this->click("link=Find Host");
        $this->waitForElementPresent("id=search-host");
        $this->type("id=search-host", "test");
        $this->click("id=dummy-host-findBtn");
        $this->waitForElementPresent("id=24");
        $this->click("id=24");
        $this->clickAndWait("id=clicktabB2");
        $this->assertEquals("test staffmembervisitor6", $this->getText("//table[@id='cardDetailsTable']/tbody/tr[3]/td"));
        $this->click("//li[@id='preregisterLi']/a/span");
        $this->type("id=Visit_date_in", "14-02-2015");
        $this->type("id=Visit_date_out", "14-02-2015");
        $this->clickAndWait("css=#update-log-visit-form > input.complete");
          }

    /*
      Scenario 10- Login as staff member find visitor add host add new reason
     */

    function Scenario10() {
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[2]/a/span");
        $this->click("id=clicktabA");
        $this->click("link=Find Visitor Profile");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->waitForElementPresent("id=5");
        $this->click("id=5");
        $this->select("id=Visit_reason_search", "label=Other");
        $this->type("id=VisitReason_reason_search", "Reason 6");
        $this->select("id=workstation_search", "label=Workstation1");
        $this->click("id=clicktabB1");
        $this->click("link=Find Host");
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
        $this->clickAndWait("id=submitFormUser");
        $this->assertEquals("Test staffmembervisitor", $this->getText("//table[@id='cardDetailsTable']/tbody/tr[3]/td"));
        $this->click("//li[@id='preregisterLi']/a/span");
        $this->type("id=Visit_date_in", "15-02-2015");
        $this->type("id=Visit_date_out", "15-02-2015");
        $this->clickAndWait("css=#update-log-visit-form > input.complete");
         }

    /*
      Scenario 11- Login as staff member find visitor select current logged in user as host and add new reason
     */

    function Scenario11() {
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->click("//div[@id='cssmenu']/ul/li[2]/a/span");
        $this->waitForPageToLoad("30000");
        $this->click("id=clicktabA");
        $this->click("link=Find Visitor Profile");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->waitForElementPresent("id=2");
        $this->click("id=2");
        $this->select("id=Visit_reason_search", "label=Other");
        $this->type("id=VisitReason_reason_search", "Reason 7");
        sleep(1);
        $this->select("id=workstation_search", "label=Workstation1");
        $this->click("id=clicktabB1");
        $this->waitForElementPresent("id=saveCurrentUserAsHost");
        $this->clickAndWait("id=saveCurrentUserAsHost");
        $this->assertEquals("Test Visitor1", $this->getText("//table[@id='cardDetailsTable']/tbody/tr[3]/td"));
        $this->click("//li[@id='preregisterLi']/a/span");
        $this->type("id=Visit_date_in", "16-02-2015");
        $this->type("id=Visit_date_out", "16-02-2015");
        $this->clickAndWait("css=#update-log-visit-form > input.complete");
        
        $this->clickAndWait("link=Dashboard");
        $this->assertEquals("Visitor1", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[4]"));
        $this->assertEquals("testVisitor1@test.com", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[7]"));
        $this->clickAndWait("link=Preregistered");
        $this->assertEquals("Please select a reason Other Reason 1 Reason 2 Reason 4 Reason 5 Reason 6 Reason 7", $this->getText("id=Visit_reason"));
    }

    /*
      Scenario 12- Login as staff member find visitor find host and add new reason
     */

    function Scenario12() {
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Preregister Visit");
        $this->click("id=clicktabA");
        $this->click("link=Find Visitor Profile");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->waitForElementPresent("id=5");
        $this->click("id=5");
        $this->select("id=Visit_reason_search", "label=Other");
        $this->type("id=VisitReason_reason_search", "reason 8");
        $this->select("id=workstation_search", "label=Workstation1");
        $this->click("id=clicktabB1");
        $this->click("link=Find Host");
        $this->type("id=search-host", "test");
        $this->click("id=dummy-host-findBtn");
        $this->click("id=dummy-host-findBtn");
        $this->waitForElementPresent("id=24");
        $this->click("id=24");
        $this->clickAndWait("id=clicktabB2");
        $this->assertEquals("Test staffmembervisitor", $this->getText("//table[@id='cardDetailsTable']/tbody/tr[3]/td"));
        $this->click("//li[@id='preregisterLi']/a/span");
        $this->type("id=Visit_date_in", "17-02-2015");
        $this->type("id=Visit_date_out", "17-02-2015");
        $this->clickAndWait("css=#update-log-visit-form > input.complete");
        
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $this->type("id=LoginForm_username", "staffmemberhost@test.com");
        $this->type("id=LoginForm_password", "12345");
        $this->click("name=yt0");
        $this->clickAndWait("name=yt0");
        $this->assertEquals("staffmembervisitor", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[4]"));
        $this->assertEquals("staffmembervisitor@test.com", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[7]"));
        $this->clickAndWait("link=Preregistered");
        $this->assertEquals("Please select a reason Other Reason 1 Reason 2 Reason 4 Reason 5 Reason 6 Reason 7 Reason 8", $this->getText("id=Visit_reason"));
    }

    /*
      Scenario 13- Login as staff member check validations for preregistering a visitor
     */

    function Scenario13() {
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[2]/a/span");
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
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", "test");
        $this->type("id=Visitor_contact_number", "123456");
        $this->type("id=Visitor_email", "testvisitor1@test.com");
        $this->select("id=Visit_reason", "label=Other");
        $this->select("id=workstation", "label=Workstation1");
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
        $this->type("id=User_first_name", "test");
        $this->type("id=User_last_name", "test");
        $this->type("id=User_email", "staffmember@test.com");
        $this->type("id=User_contact_number", "123456");
        $this->type("id=User_staff_id", "123456");
        $this->click("id=submitFormUser");
        $this->assertEquals("A profile already exists for this email address.", $this->getText("xpath=(//div[@id='User_email_em_'])[2]"));
        $this->click("link=Find Host");
        $this->click("id=dummy-host-findBtn");
        $this->assertEquals("Search Name cannot be blank.", $this->getText("id=searchTextHostErrorMessage"));
        
        $this->type("id=search-host", "test");
        $this->click("id=dummy-host-findBtn");
        $this->click("id=clicktabB2");
        $this->assertEquals("Please enter a name", $this->getText("id=searchTextHostErrorMessage"));
    }

}

?>

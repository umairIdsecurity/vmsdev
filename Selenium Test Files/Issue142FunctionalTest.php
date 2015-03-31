<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue142FunctionalTest
 * @author Jeremiah
 */
class Issue142FunctionalTest extends BaseFunctionalTest {

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
        $this->open("http://dev.identitysecurity.info/index.php?r=site/reset&filename=Issue142");
        $this->assertEquals("Tables imported successfully", $this->getText("css=body"));
        $this->Scenario5();
    }

    /* Scenario 1 – Create a saved visit with new visitor then delete the visitor
      Expected Behavior – Visitor should not be displayed, Saved visit of visitor will be deleted.

     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("css=span");
        $this->click("id=clicktabA");
        $this->select("id=Visitor_tenant", "label=NAIA Airport");
        sleep(1);
        $this->select("id=workstation", "label=Workstation3");
        $this->type("id=Visitor_first_name", "Visitor");
        $this->type("id=Visitor_last_name", "Saved");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->select("id=Visitor_company", "label=Philippine Airline");
        $this->type("id=Visitor_email", "visitorsaved@test.com");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->type("id=Visitor_contact_number", "12345");
        $this->click("id=submitFormVisitor");
        $this->type("id=User_first_name", "host");
        $this->type("id=User_last_name", "saved");
        $this->type("id=User_email", "hostsaved@test.com");
        $this->type("id=User_contact_number", "12345");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        sleep(1);
        $this->clickAndWait("id=submitFormUser");
        try {
            $this->assertEquals("visitorsaved@test.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->assertEquals("Saved", $this->getText("css=ul.visitStatusLi > li > a > span"));
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("css=a.managevisitorrecords > span");
        $this->click("id=yt0");
        $this->assertTrue((bool) preg_match('/^Are you sure you want to delete this item[\s\S]$/', $this->getConfirmation()));
        $this->clickAndWait("css=a.managevisitorrecords > span");
        $this->type("name=Visitor[last_name]", "saved");
        $this->waitForElementPresent("css=span.empty");
        $this->assertEquals("No results found.", $this->getText("css=span.empty"));
        $this->click("link=Visit History");
        $this->waitForPageToLoad("30000");
        $this->type("name=Visit[lastname]", "saved");
        $this->waitForElementPresent("css=span.empty");
        $this->assertEquals("No results found.", $this->getText("css=span.empty"));
    }

    /* Scenario 2 – Create a saved visit and active visit with same visitor
      Expected Behavior – Visitor should not be deleted

     */

    function Scenario2() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("css=span");
        $this->click("id=clicktabA");
        $this->select("id=Visitor_tenant", "label=NAIA Airport");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Please select a workstation Workstation3" == $this->getText("id=workstation"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->select("id=workstation", "label=Workstation3");
        $this->type("id=Visitor_first_name", "Visitor");
        $this->type("id=Visitor_last_name", "Active");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->select("id=Visitor_company", "label=Philippine Airline");
        $this->type("id=Visitor_email", "visitoractive@test.com");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->type("id=Visitor_contact_number", "12345");
        $this->click("id=submitFormVisitor");
        $this->type("id=User_first_name", "Host");
        $this->type("id=User_last_name", "active");
        $this->type("id=User_email", "hostactive@test.com");
        $this->type("id=User_contact_number", "12345");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        sleep(1);
        $this->clickAndWait("id=submitFormUser");
        try {
            $this->assertEquals("visitoractive@test.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->assertEquals("Saved", $this->getText("css=ul.visitStatusLi > li > a > span"));
        $this->click("css=#activate-a-visit-form > input.complete");
        sleep(3);
        $this->assertEquals("Visit is now activated. You can now print the visitor badge.", $this->getAlert());
        $this->click("link=Visit History");
        $this->waitForPageToLoad("30000");
        $this->click("link=Active");
        $this->waitForPageToLoad("30000");
        $this->click("id=closeVisitBtnDummy");
        $this->clickAndWait("id=closeVisitBtn");
        $this->assertEquals("Closed", $this->getText("css=ul.visitStatusLi > li > a > span"));
        $this->click("link=Dashboard");
        $this->waitForPageToLoad("30000");
        $this->click("css=span");
        $this->waitForPageToLoad("30000");
        $this->click("id=clicktabA");
        $this->click("link=Find Visitor Profile");
        $this->select("id=search_visitor_tenant", "label=NAIA Airport");
        $this->type("id=search-visitor", "active");
        $this->click("id=dummy-visitor-findBtn");
        $this->waitForElementPresent("id=6");
        $this->click("id=6");
        $this->select("id=workstation_search", "label=Workstation3");
        $this->select("id=Visit_reason_search", "label=Reason 1");
        $this->click("id=clicktabB1");
        $this->click("link=Find Host");
        $this->type("id=search-host", "test");
        $this->click("id=dummy-host-findBtn");
        $this->waitForElementPresent("id=17");

        $this->click("id=17");
        $this->clickAndWait("id=clicktabB2");
        $this->assertEquals("Saved", $this->getText("css=ul.visitStatusLi > li > a > span"));
        $this->click("link=Visit History");
        $this->waitForPageToLoad("30000");
        $this->click("link=Closed");
        $this->waitForPageToLoad("30000");
        $this->click("css=span.log-current");
        $this->clickAndWait("id=registerNewVisit");
        $this->click("link=Visit History");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Active", $this->getText("link=Active"));
        $this->assertEquals("Active", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[5]"));
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("css=a.managevisitorrecords > span");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("visitoractive@test.com", $this->getText("//div[@id='visitor-grid']/table/tbody/tr/td[3]"));
        $this->click("id=yt0");
        $this->assertTrue((bool) preg_match('/^Are you sure you want to delete this item[\s\S]$/', $this->getConfirmation()));
        sleep(3);
        $this->assertEquals("This record has an open visit and must be cancelled before deleting.", $this->getAlert());
        $this->click("css=a.managevisitorrecords > span");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("visitoractive@test.com", $this->getText("//div[@id='visitor-grid']/table/tbody/tr/td[3]"));
    }

    /* Scenario 3 – Create a saved visit and preregister visit with same visitor
      Expected Behavior – Visitor should not be deleted

     */

    function Scenario3() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Visit History");
        $this->waitForPageToLoad("30000");
        $this->click("link=Closed");
        $this->waitForPageToLoad("30000");
        $this->click("css=span.pre-visits");
        $this->click("id=preregisterNewVisit");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Preregistered", $this->getText("css=ul.visitStatusLi > li > a > span"));
        try {
            $this->assertEquals("visitoractive@test.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("css=a.managevisitorrecords > span");
        $this->waitForPageToLoad("30000");
        $this->click("id=yt0");
        $this->assertTrue((bool) preg_match('/^Are you sure you want to delete this item[\s\S]$/', $this->getConfirmation()));
        sleep(1);
        $this->assertEquals("This record has an open visit and must be cancelled before deleting.", $this->getAlert());
    }

    /* Scenario 4 – Create a saved visit and closed visit with same visitor
      Expected Behavior – Visitor should not be deleted
     */

    function Scenario4() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("css=span");
        $this->waitForPageToLoad("30000");
        $this->click("id=clicktabA");
        $this->select("id=Visitor_tenant", "label=NAIA Airport");
        sleep(1);
        $this->select("id=workstation", "label=Workstation3");
        $this->type("id=Visitor_first_name", "Visitor");
        $this->type("id=Visitor_last_name", "Close");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->select("id=Visitor_company", "label=Philippine Airline");
        $this->type("id=Visitor_email", "visitorclose@test.com");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->type("id=Visitor_contact_number", "12345");
        $this->click("id=submitFormVisitor");
        $this->type("id=User_first_name", "Host");
        $this->type("id=User_last_name", "close");
        $this->type("id=User_email", "hostclose@test.com");
        $this->type("id=User_contact_number", "12345");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        sleep(1);
        $this->clickAndWait("id=submitFormUser");
        try {
            $this->assertEquals("visitorclose@test.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->assertEquals("Saved", $this->getText("css=ul.visitStatusLi > li > a > span"));
        $this->click("css=#activate-a-visit-form > input.complete");
        sleep(3);
        $this->assertEquals("Visit is now activated. You can now print the visitor badge.", $this->getAlert());
        $this->click("link=Visit History");
        $this->waitForPageToLoad("30000");
        $this->click("link=Active");
        $this->waitForPageToLoad("30000");
        $this->click("id=closeVisitBtnDummy");
        $this->clickAndWait("id=closeVisitBtn");
        $this->assertEquals("Closed", $this->getText("css=ul.visitStatusLi > li > a > span"));
        $this->click("link=Dashboard");
        $this->waitForPageToLoad("30000");
        $this->click("css=span");
        $this->waitForPageToLoad("30000");
        $this->click("id=clicktabA");
        $this->click("link=Find Visitor Profile");
        $this->type("id=search-visitor", "close");
        $this->select("id=search_visitor_tenant", "label=NAIA Airport");
        $this->click("id=dummy-visitor-findBtn");
        $this->waitForElementPresent("id=7");
        $this->click("id=7");
        $this->select("id=workstation_search", "label=Workstation3");
        $this->select("id=Visit_reason_search", "label=Reason 1");
        $this->click("id=clicktabB1");
        $this->click("link=Find Host");
        $this->type("id=search-host", "test");
        $this->click("id=dummy-host-findBtn");
        $this->waitForElementPresent("id=17");
        $this->click("id=17");
        $this->clickAndWait("id=clicktabB2");
        $this->assertEquals("Saved", $this->getText("css=ul.visitStatusLi > li > a > span"));
        try {
            $this->assertEquals("visitorclose@test.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("css=a.managevisitorrecords > span");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("visitorclose@test.com", $this->getText("//div[@id='visitor-grid']/table/tbody/tr/td[3]"));
        $this->click("id=yt0");
        sleep(1);
        $this->assertTrue((bool) preg_match('/^Are you sure you want to delete this item[\s\S]$/', $this->getConfirmation()));
        $this->assertTrue((bool)preg_match('/^This Visitor Record has visit data recorded\. Do you wish to delete this visitor record and its visit history[\s\S]$/',$this->getConfirmation()));
    }

    /* Scenario 5 – Create a saved visit and expired visit with same visitor
      Expected Behavior – Visitor should not be deleted
     */

    function Scenario5() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Visit History");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Expired", $this->getText("link=Expired"));
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("css=a.managevisitorrecords > span");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("visitorclose@test.com", $this->getText("//div[@id='visitor-grid']/table/tbody/tr/td[3]"));
        $this->click("id=yt0");
        $this->assertTrue((bool) preg_match('/^Are you sure you want to delete this item[\s\S]$/', $this->getConfirmation()));
        $this->chooseCancelOnNextConfirmation();
        sleep(3);
        $this->assertTrue((bool) preg_match('/^This Visitor Record has visit data recorded\. Do you wish to delete this visitor record and its visit history[\s\S]$/', $this->getConfirmation()));
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Visitors");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("visitorclose@test.com", $this->getText("//div[@id='visitor-grid']/table/tbody/tr/td[3]"));
    }

}

?>
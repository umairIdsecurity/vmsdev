<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue144FunctionalTest
 * @author Jeremiah
 */
class Issue144FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
        $this->Scenario2();
    }

    /* Scenario 1 – Log in as operator and assert workstation 1 and workstation 2 are displayed in dashboard page
      Expected Behavior:
      Workstation 1 and workstation2 are displayed in dashboard page
      Assert visits assigned to workstation 1 and 2 are displayed in visit history page and evacuation report

     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("css=a.manageworkstations > span");
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[2]/ul/li/a/span");
        $this->select("id=Workstation_tenant", "label=NAIA Airport");
        $this->type("id=Workstation_name", "Workstation 4");
        $this->clickAndWait("name=yt0");
        $this->assertEquals("Workstation 4", $this->getText("css=tr.odd > td"));
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[3]/ul/li[6]/a/span");
        $this->click("id=19");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("xpath=(//input[@id='cbColumn_0'])[2]"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->click("xpath=(//input[@id='cbColumn_0'])[2]");
        $this->click("id=btnSubmit");
        $this->waitForPageToLoad("30000");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("css=div.flash-success"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("Workstation updated.", $this->getText("css=div.flash-success"));
        $this->click("link=×");
        $this->waitForElementPresent("link=Administration");
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[3]/ul/li[6]/a/span");
        $this->click("id=20");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("xpath=(//input[@id='cbColumn_0'])[2]"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->click("xpath=(//input[@id='cbColumn_0'])[2]");
        $this->clickAndWait("id=btnSubmit");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("css=div.flash-success"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("Workstation updated.", $this->getText("css=div.flash-success"));
        $this->click("link=×");
        $this->click("//ul[@id='tabs']/li[3]/a/p");
        $this->waitForPageToLoad("30000");
        $this->login('operator@test.com', '12345');
        $this->assertEquals("Workstation3 Workstation 4", $this->getText("id=userWorkstation"));
        $this->clickAndWait("id=submitBtn");
        $this->assertEquals("Workstation3", $this->getText("css=h1"));
        $this->assertEquals("Workstation 4", $this->getText("//div[@id='content']/h1[2]"));
        $this->clickAndWait("css=span");
        $this->click("id=clicktabA");
        $this->type("id=Visitor_first_name", "operator1");
        $this->type("id=Visitor_last_name", "operator1");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        sleep(1);
        $this->select("id=Visitor_company", "label=Philippine Airline");
        $this->type("id=Visitor_email", "operator1@test.com");
        $this->type("id=Visitor_vehicle", "123456");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->type("id=Visitor_contact_number", "123456");
        $this->click("id=submitFormVisitor");
        $this->type("id=User_first_name", "operator1");
        $this->type("id=User_last_name", "operator1");
        $this->type("id=User_email", "operator1@test.com");
        $this->type("id=User_contact_number", "1234");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        $this->clickAndWait("id=submitFormUser");
        $this->assertEquals("operator1", $this->getText("//table[@id='personalDetailsTable']/tbody/tr/td[2]"));
        $this->assertEquals("Saved", $this->getText("css=ul.visitStatusLi > li > a > span"));
        $this->clickAndWait("link=Visit History");
        $this->assertEquals("Saved", $this->getText("link=Saved"));
        $this->clickAndWait("link=Saved");
        $this->click("css=#activate-a-visit-form > input.complete");
        sleep(4);
        $this->assertEquals("Visit is now activated. You can now print the visitor badge.", $this->getAlert());
        $this->clickAndWait("link=Dashboard");
        $this->assertEquals("Active", $this->getText("link=Active"));
        $this->assertEquals("No results found.", $this->getText("css=span.empty"));
        $this->click("//ul[@id='tabs']/li[3]/a/p");
        $this->waitForPageToLoad("30000");
        $this->type("id=LoginForm_username", "operator@test.com");
        $this->type("id=LoginForm_password", "12345");
        $this->click("name=yt0");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        $this->select("id=userWorkstation", "label=Workstation 4");
        $this->click("id=submitBtn");
        $this->click("id=submit");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Workstation3", $this->getText("css=h1"));
        $this->assertEquals("Workstation 4", $this->getText("//div[@id='content']/h1[2]"));
        $this->click("link=Visit History");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Active", $this->getText("link=Active"));
        $this->click("link=Dashboard");
        $this->waitForPageToLoad("30000");
        $this->click("css=span");
        $this->waitForPageToLoad("30000");
        $this->click("id=clicktabA");
        $this->type("id=Visitor_first_name", "operator2");
        $this->type("id=Visitor_last_name", "operator2");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->select("id=Visitor_company", "label=Philippine Airline");
        $this->type("id=Visitor_email", "operator2@test.com");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->type("id=Visitor_contact_number", "123456");
        $this->click("id=submitFormVisitor");
        $this->type("id=User_first_name", "operator2");
        $this->type("id=User_last_name", "operator2");
        $this->type("id=User_email", "operator2@test.com");
        $this->type("id=User_contact_number", "123456");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        $this->clickAndWait("id=submitFormUser");
        try {
            $this->assertEquals("operator2@test.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->assertEquals("Saved", $this->getText("css=ul.visitStatusLi > li > a > span"));
        $this->click("link=Visit History");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Saved", $this->getText("link=Saved"));
        $this->click("link=Saved");
        $this->waitForPageToLoad("30000");
        $this->click("css=#activate-a-visit-form > input.complete");
        sleep(4);
        $this->assertEquals("Visit is now activated. You can now print the visitor badge.", $this->getAlert());
        $this->click("link=Visit History");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Active", $this->getText("link=Active"));
        $this->click("link=Dashboard");
        $this->waitForPageToLoad("30000");
        $this->click("css=#evacuationreportSidebar > span");
        $this->waitForPageToLoad("30000");
    }

    /* Scenario 2 Log in as agent operator and assert workstation 3 and workstation 4 are displayed in dashboard page
      Expected Behavior:
      Workstation 3 and workstation 4 are displayed in dashboard page
      Assert visits assigned to workstation 3 and 4 are displayed in visit history page and evacuation report
     */

    function Scenario2() {
        $username = 'agentoperator@test.com';
        $this->login($username, '12345');
        $this->assertEquals("Workstation1 Workstation2", $this->getText("id=userWorkstation"));
        $this->select("id=userWorkstation", "label=Workstation2");
        $this->clickAndWait("id=submitBtn");
        $this->assertEquals("Preregistered", $this->getText("link=Preregistered"));
        $this->clickAndWait("link=Visit History");
        $this->assertEquals("Preregistered", $this->getText("link=Preregistered"));
        $this->clickAndWait("link=Dashboard");
        $this->clickAndWait("css=span");
        $this->click("id=clicktabA");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        sleep(1);
        $this->select("id=Visitor_company", "label=NAIA Airport");
        $this->type("id=Visitor_first_name", "agentoperator1");
        $this->type("id=Visitor_last_name", "agentoperator1");
        $this->type("id=Visitor_email", "agentoperator1@test.com");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->type("id=Visitor_contact_number", "12345");
        $this->click("id=submitFormVisitor");
        $this->type("id=User_first_name", "agentoperator1");
        $this->type("id=User_last_name", "agentoperator1");
        $this->type("id=User_email", "agentoperator1@test.com");
        $this->type("id=User_contact_number", "1234");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        $this->clickAndWait("id=submitFormUser");
        $this->assertEquals("agentoperator1", $this->getText("//table[@id='personalDetailsTable']/tbody/tr/td[2]"));
        $this->assertEquals("Saved", $this->getText("css=ul.visitStatusLi > li > a > span"));
        $this->click("link=Visit History");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Saved", $this->getText("link=Saved"));
        $this->click("link=Saved");
        $this->waitForPageToLoad("30000");
        $this->click("css=#activate-a-visit-form > input.complete");
        sleep(4);
        $this->assertEquals("Visit is now activated. You can now print the visitor badge.", $this->getAlert());
        $this->click("link=Dashboard");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Active", $this->getText("link=Active"));
        $this->assertEquals("Preregistered", $this->getText("link=Preregistered"));
        $this->click("css=#evacuationreportSidebar > span");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Active", $this->getText("link=Active"));
    }

}

?>
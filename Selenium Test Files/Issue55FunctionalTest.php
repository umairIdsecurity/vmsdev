<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue55FunctionalTest
 * Preload Data
 * @author Jeremiah
 */
class Issue55FunctionalTest extends BaseFunctionalTest {

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
    }

    /* Scenario 1 Preregister a visit, status should be saved first 
      Expected Behavior
      Assert Saved

     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[2]/a/span");
        $this->click("id=clicktabA");
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", "preload");
        $this->type("id=Visitor_contact_number", "123456");
        
        $this->type("id=Visitor_email", "preloadvisitor2@test.com");
        $this->type("id=Visitor_email", "preloadvisitor@test.com");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->select("id=Visitor_tenant", "label=NAIA Airport");
        $this->select("id=Visit_reason", "label=Reason 1");
        sleep(1);
        $this->select("id=workstation", "label=Workstation3");
        $this->click("id=submitFormVisitor");
        $this->type("id=User_first_name", "test");
        $this->type("id=User_last_name", "host1");
        $this->type("id=User_email", "host1@test.com");
        $this->type("id=User_contact_number", "12345");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        $this->select("id=User_tenant", "label=NAIA Airport");
        $this->type("id=User_department", "department");
        $this->type("id=User_staff_id", "123123");
        sleep(1);
        $this->clickAndWait("id=submitFormUser");
        try {
            $this->assertEquals("preloadvisitor@test.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->assertEquals("Saved", $this->getText("css=ul.visitStatusLi > li > a > span"));
    }

    /* Scenario 2 Preregister a visit
      Expected Behavior
      Assert visit status: preregistered

     */

    function Scenario2() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Visit History");
        $this->clickAndWait("link=Saved");
        try {
            $this->assertEquals("preloadvisitor@test.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->assertEquals("Saved", $this->getText("css=ul.visitStatusLi > li > a > span"));
        $this->click("//li[@id='preregisterLi']/a/span");
        $this->clickAndWait("css=#update-log-visit-form > input.complete");
        $this->clickAndWait("link=Preregistered");
        $this->assertEquals("Preregistered", $this->getText("css=ul.visitStatusLi > li > a > span"));
        try {
            $this->assertEquals("preloadvisitor@test.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
    }

    /* Scenario 3 Register a visitor for multi day card type then upload a photo
      Expected Behavior
      Assert Multi day selected in card type
      Assert Please upload a photo.

     */

    function Scenario3() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("css=span");
        $this->click("id=multiday");
        $this->click("id=clicktabA");
        $this->type("id=Visitor_first_name", "multida");
        $this->type("id=Visitor_first_name", "multiday");
        $this->type("id=Visitor_last_name", "multiday");
        $this->type("id=Visitor_email", "multiday@test.com");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->type("id=Visitor_contact_number", "1234567");
        $this->type("id=Visitor_vehicle", "ABC123");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->select("id=Visitor_tenant", "label=NAIA Airport");
        sleep(1);
        $this->select("id=workstation", "label=Workstation3");
        $this->click("id=submitFormVisitor");
        $this->waitForElementPresent("id=photoErrorMessage");
        sleep(1);
        $this->assertEquals("Please upload a photo.", $this->getText("id=photoErrorMessage"));
        $this->type("id=Visitor_photo", "1");
        $this->click("id=submitFormVisitor");
        $this->type("id=User_first_name", "host3");
        $this->type("id=User_last_name", "host3");
        $this->type("id=User_department", "department");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        $this->select("id=User_tenant", "label=NAIA Airport");
        sleep(1);
        $this->type("id=User_staff_id", "123456789");
        $this->type("id=User_email", "host3@test.com");
        $this->type("id=User_contact_number", "1234567");
        $this->type("id=User_repeatpassword", "12345");
        $this->clickAndWait("id=submitFormUser");
        $this->click("css=#activate-a-visit-form > input.complete");
        sleep(3);
        $this->assertEquals("Visit is now activated. You can now print the visitor badge.", $this->getAlert());
        $this->clickAndWait("link=Dashboard");
        $this->clickAndWait("link=Active");
        try {
            $this->assertEquals("Same Day Visitor Multiday Visitor", $this->getText("id=Visit_card_type"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        try {
            $this->assertEquals("multiday@test.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->assertEquals("Active", $this->getText("css=ul.visitStatusLi > li > a > span"));
    }

    /* Scenario 4 Update visitor to multiday card type in visitor detail page
      Expected Behavior
      Assert Multi day selected in card type
      Assert Please upload a photo.

     */

    function Scenario4() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Visit History");
        $this->clickAndWait("link=Preregistered");
        $this->assertEquals("Preregistered", $this->getText("css=ul.visitStatusLi > li > a > span"));
        $this->select("id=Visit_card_type", "label=Multiday Visitor");
        $this->click("css=input.submitBtn.complete");
        sleep(1);
        $this->assertEquals("Please upload a photo.", $this->getAlert());
        $this->type("id=Visitor_photo","1");
        $this->clickAndWait("css=input.submitBtn.complete");
        try {
            $this->assertEquals("preloadvisitor@test.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->assertEquals("Same Day Visitor Multiday Visitor", $this->getText("id=Visit_card_type"));
    }

}

?>

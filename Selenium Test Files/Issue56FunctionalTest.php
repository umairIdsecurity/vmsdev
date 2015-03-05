<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue56FunctionalTest
 * Preload Data
 * @author Jeremiah
 */
class Issue56FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
        $this->Scenario2();
    }

    /* Scenario 1 Preregister a visit, status should be saved first 
      Expected Behavior
      Assert Saved
      Assert Preregistered

     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[2]/a/span");
        $this->click("id=clicktabA");
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", "preload");
        $this->type("id=Visitor_contact_number", "123456");
        $this->select("id=workstation", "label=Workstation1");
        $this->type("id=Visitor_email", "preloadvisitor@test.com");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->select("id=Visitor_tenant", "label=Test admin");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->click("id=submitFormVisitor");
        $this->type("id=User_first_name", "test");
        $this->type("id=User_last_name", "host1");
        $this->type("id=User_email", "host1@test.com");
        $this->type("id=User_contact_number", "12345");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        $this->select("id=User_tenant", "label=Test admin");
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

    /* Scenario 2 Activate a visit in visitor detail page
      Expected Behavior
      Assert visit status: active


     */

    function Scenario2() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Visit History");
        $this->clickAndWait("link=Preregistered");
        try {
            $this->assertEquals("preloadvisitor@test.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->assertEquals("Preregistered", $this->getText("css=ul.visitStatusLi > li > a > span"));
        $this->click("//li[@id='activateLi']/a/span");
        $this->click("css=#activate-a-visit-form > input.complete");
        sleep(3);
        $this->assertEquals("Visit is now activated. You can now print the visitor badge.", $this->getAlert());
        $this->clickAndWait("link=Dashboard");
        $this->clickAndWait("link=Active");
        
        $this->assertEquals("Active", $this->getText("css=ul.visitStatusLi > li > a > span"));
        try {
            $this->assertEquals("preloadvisitor@test.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
    }

}

?>

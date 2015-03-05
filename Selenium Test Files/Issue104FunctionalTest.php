<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue104FunctionalTest
 * @author Jeremiah
 */
class Issue104FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
        $this->Scenario2();
        $this->Scenario3();
    }

    /* Scenario 1 Activate a visit for testvisitor1@test.com
      Expected Behavior
      Assert status: Active
     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("xpath=(//a[contains(text(),'Preregistered')])[5]");
        $this->click("css=span.log-current");
        $this->click("css=#activate-a-visit-form > input.complete");
        sleep(3);
        $this->assertEquals("Visit is now activated. You can now print the visitor badge.", $this->getAlert());
        $this->clickAndWait("link=Dashboard");
        $this->assertEquals("Active", $this->getText("link=Active"));
    }

    /* Scenario 2 Activate another visit for testvisitor1@test.com. Should not be activated
      Expected Behavior
      Assert Visit cannot be activated. Please close previous active visit.
      Assert status: Preregistered
     */

    function Scenario2() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("xpath=(//a[contains(text(),'Preregistered')])[5]");
        $this->click("css=span.log-current");
        $this->click("css=#activate-a-visit-form > input.complete");
        sleep(3);
        $this->assertEquals("Visit cannot be activated. Please close previous active visit.", $this->getAlert());
        $this->assertEquals("Preregistered", $this->getText("css=ul.visitStatusLi > li > a > span"));
        $this->clickAndWait("link=Dashboard");
        $this->assertEquals("Preregistered", $this->getText("xpath=(//a[contains(text(),'Preregistered')])[5]"));
        $this->clickAndWait("xpath=(//a[contains(text(),'Preregistered')])[5]");
        try {
            $this->assertEquals("testVisitor1@test.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
    }
    
    /* Scenario 3 Activate another visit with another date. Cannot be updated.
      Expected Behavior
      Assert Visit cannot be activated. Please close previous active visit.
      Assert status: Preregistered
     */

    function Scenario3() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("xpath=(//a[contains(text(),'Preregistered')])[5]");
        $this->click("css=span.log-current");
        $this->type("id=Visit_date_check_in",date('d-m-Y', time() + 86400));
        $this->click("css=#activate-a-visit-form > input.complete");
        sleep(3);
        $this->assertEquals("Visit cannot be activated. Please close previous active visit.", $this->getAlert());
        $this->assertEquals("Preregistered", $this->getText("css=ul.visitStatusLi > li > a > span"));
        $this->clickAndWait("link=Dashboard");
        $this->assertEquals("Preregistered", $this->getText("xpath=(//a[contains(text(),'Preregistered')])[5]"));
        $this->clickAndWait("xpath=(//a[contains(text(),'Preregistered')])[5]");
        try {
            $this->assertEquals("testVisitor1@test.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
    }

}

?>
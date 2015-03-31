<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue113FunctionalTest
 * Scheduled Jobs
 * @author Jeremiah
 */
class Issue113FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        /*super admin*/
        $this->Scenario1();
        $this->Scenario2();
        $this->Scenario3();
        $this->Scenario4();
        $this->Scenario5();
        $this->Scenario6();
        $this->Scenario7();
        /* admin*/
        $this->resetDbWithData();
        $this->Scenario8();
        $this->Scenario9();
        $this->Scenario10();
        //*agent admin*/
        $this->resetDbWithData();
        $this->Scenario11();
        $this->Scenario12();
    }

    /* Scenario 1 – Update administrator’s password to ‘test’
      Expected Behavior: Administrator should be logged in using the new password

     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("xpath=(//a[contains(text(),'Edit')])[7]");
        try {
            $this->assertEquals("admin@test.com", $this->getValue("id=User_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->type("id=User_password", "test");
        $this->type("id=User_repeat_password", "test");
        $this->clickAndWait("id=submitForm");
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $this->login('admin@test.com', 'test');
        $this->assertEquals("Logged in as Administrator", $this->getText("link=Logged in as Administrator"));
        $this->clickAndWait("css=p");
        try {
            $this->assertEquals("admin@test.com", $this->getValue("id=User_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
    }

    /* Scenario 2 – Update agent administrator’s password to ‘test’
      Expected Behavior: Agent administrator should be logged in using the new password
     */

    function Scenario2() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("xpath=(//a[contains(text(),'Edit')])[6]");
        try {
            $this->assertEquals("agentadmin@test.com", $this->getValue("id=User_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->type("id=User_password", "test");
        $this->type("id=User_repeat_password", "test");
        $this->clickAndWait("id=submitForm");
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $this->login('agentadmin@test.com', 'test');
        $this->assertEquals("Logged in as Agent Administrator", $this->getText("link=Logged in as Agent Administrator"));
        $this->clickAndWait("css=p");
        try {
            $this->assertEquals("agentadmin@test.com", $this->getValue("id=User_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
    }

    /* Scenario 3 – Update operator’s password to ‘test’ 
      Expected Behavior: Operator should be logged in using the new password

     */

    function Scenario3() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("xpath=(//a[contains(text(),'Edit')])[5]");
        try {
            $this->assertEquals("operator@test.com", $this->getValue("id=User_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->type("id=User_password", "test");
        $this->type("id=User_repeat_password", "test");
        $this->clickAndWait("id=submitForm");
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $this->login('operator@test.com', 'test');
        $this->clickAndWait("id=submitBtn");
        $this->assertEquals("Logged in as Operator", $this->getText("link=Logged in as Operator"));
        $this->clickAndWait("css=p");
        try {
            $this->assertEquals("operator@test.com", $this->getValue("id=User_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
    }

    /* Scenario 4 – Update agent operator’s password to ‘test’ 
      Expected Behavior: Agent operator should be logged in using the new password

     */

    function Scenario4() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("xpath=(//a[contains(text(),'Edit')])[4]");
        try {
            $this->assertEquals("agentoperator@test.com", $this->getValue("id=User_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->type("id=User_password", "test");
        $this->type("id=User_repeat_password", "test");
        $this->clickAndWait("id=submitForm");
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $this->login('agentoperator@test.com', 'test');
        $this->clickAndWait("id=submitBtn");
        $this->assertEquals("Logged in as Agent Operator", $this->getText("link=Logged in as Agent Operator"));
        $this->clickAndWait("css=p");
        try {
            $this->assertEquals("agentoperator@test.com", $this->getValue("id=User_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
    }

    /* Scenario 5 – Update staff member’s password to ‘test’ 
      Expected Behavior: Staff member should be logged in using the new password

     */

    function Scenario5() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("xpath=(//a[contains(text(),'Edit')])[3]");
        try {
            $this->assertEquals("staffmember@test.com", $this->getValue("id=User_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->type("id=User_password", "test");
        $this->type("id=User_repeat_password", "test");
        $this->clickAndWait("id=submitForm");
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $this->login('staffmember@test.com', 'test');

        $this->assertEquals("Logged in as Staff Member", $this->getText("link=Logged in as Staff Member"));
    }

    /* Scenario 6 – Update administrator’s profile, leave password to blank then click save
      Expected Behavior: Administrator should be logged in using password test

     */

    function Scenario6() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("xpath=(//a[contains(text(),'Edit')])[7]");
        $this->clickAndWait("id=submitForm");
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $this->login('admin@test.com', 'test');
        $this->assertEquals("Logged in as Administrator", $this->getText("link=Logged in as Administrator"));
        $this->clickAndWait("css=p");
        try {
            $this->assertEquals("admin@test.com", $this->getValue("id=User_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
    }

    /* Scenario 7 – Update administrator’s profile, type 123 in password and 1234 in repeat password
      Expected Behavior: New password does not match with repeat password

     */

    function Scenario7() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("xpath=(//a[contains(text(),'Edit')])[7]");
        $this->type("id=User_password", "123");
        $this->type("id=User_repeat_password", "12345");
        $this->click("id=submitForm");
        $this->waitForElementPresent("id=User_password_em_");
        sleep(1);
        $this->assertEquals("Password does not match with repeat password", $this->getText("id=User_password_em_"));
    }

    /* Scenario 8 – Update administrator’s password to ‘test’
      Expected Behavior: Administrator should be logged in using the new password
     */

    function Scenario8() {
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("css=tr.even > td.button-column > a.update");
        try {
            $this->assertEquals("admin2@test.com", $this->getValue("id=User_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->type("id=User_password", "test");
        $this->type("id=User_repeat_password", "test");
        $this->clickAndWait("id=submitForm");
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $this->login('admin2@test.com', 'test');
        $this->assertEquals("Logged in as Administrator", $this->getText("link=Logged in as Administrator"));
        $this->clickAndWait("css=p");
        try {
            $this->assertEquals("admin2@test.com", $this->getValue("id=User_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
    }

    /* Scenario 9 – Update agent administrator’s password to ‘test’
      Expected Behavior: Agent administrator should be logged in using the new password

     */

    function Scenario9() {
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("xpath=(//a[contains(text(),'Edit')])[6]");
        try {
            $this->assertEquals("agentadmin@test.com", $this->getValue("id=User_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->type("id=User_password", "test");
        $this->type("id=User_repeat_password", "test");
        $this->clickAndWait("id=submitForm");
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $this->login('agentadmin@test.com', 'test');
        $this->assertEquals("Logged in as Agent Administrator", $this->getText("link=Logged in as Agent Administrator"));
        $this->clickAndWait("css=p");
        try {
            $this->assertEquals("agentadmin@test.com", $this->getValue("id=User_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
    }

    /* Scenario 10 – Update operator’s password to ‘test’ 
      Expected Behavior: Operator should be logged in using the new password
     */

    function Scenario10() {
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("xpath=(//a[contains(text(),'Edit')])[5]");
        try {
            $this->assertEquals("operator@test.com", $this->getValue("id=User_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->type("id=User_password", "test");
        $this->type("id=User_repeat_password", "test");
        $this->clickAndWait("id=submitForm");
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $this->login('operator@test.com', 'test');
        $this->clickAndWait("id=submitBtn");
        $this->assertEquals("Logged in as Operator", $this->getText("link=Logged in as Operator"));
        $this->clickAndWait("css=p");
        try {
            $this->assertEquals("operator@test.com", $this->getValue("id=User_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
    }

    /* Scenario 11 – Update agent administrator’s password to ‘test’
      Expected Behavior: Agent administrator should be logged in using the new password

     */

    function Scenario11() {
        $username = 'agentadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("xpath=(//a[contains(text(),'Edit')])[3]");
        try {
            $this->assertEquals("agentoperator@test.com", $this->getValue("id=User_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->type("id=User_password", "test");
        $this->type("id=User_repeat_password", "test");
        $this->clickAndWait("id=submitForm");
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $this->login('agentoperator@test.com', 'test');
        $this->clickAndWait("id=submitBtn");
        $this->assertEquals("Logged in as Agent Operator", $this->getText("link=Logged in as Agent Operator"));
        $this->clickAndWait("css=p");
        try {
            $this->assertEquals("agentoperator@test.com", $this->getValue("id=User_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
    }

    /* Scenario 12 – Update staff member’s password to ‘test’ 
      Expected Behavior: Staff member should be logged in using the new password

     */

    function Scenario12() {
        $username = 'agentadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("css=tr.even > td.button-column > a.update");
        try {
            $this->assertEquals("staffmember@test.com", $this->getValue("id=User_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->type("id=User_password", "test");
        $this->type("id=User_repeat_password", "test");
        $this->clickAndWait("id=submitForm");
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $this->login('staffmember@test.com', 'test');
        $this->assertEquals("Logged in as Staff Member", $this->getText("link=Logged in as Staff Member"));
    }

}

?>

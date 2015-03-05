<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue82FunctionalTest
 * @author Jeremiah
 */
class Issue82FunctionalTest extends BaseFunctionalTest {

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

    /* Scenario 1 Update contact number of user. Form should allow to update own email.
      Expected Behavior
      Assert 99999 in contact number
      Assert email is admin@test.com

     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("xpath=(//a[contains(text(),'Edit')])[7]");
        $this->type("id=User_contact_number", "99999");
        $this->clickAndWait("id=submitBtn");
        $this->assertEquals("99999", $this->getText("//div[@id='user-grid']/table/tbody/tr[7]/td[6]"));
        $this->assertEquals("admin", $this->getText("//div[@id='user-grid']/table/tbody/tr[7]/td[2]"));
        $this->clickAndWait("xpath=(//a[contains(text(),'Edit')])[7]");
        try {
            $this->assertEquals("admin@test.com", $this->getValue("id=User_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        try {
            $this->assertEquals("99999", $this->getValue("id=User_contact_number"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
    }

    /* Scenario 2 Update email of admin@test.com to admintest@test.com. Should update
      Expected Behavior
      Assert admintest@test.com in email

     */

    function Scenario2() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("xpath=(//a[contains(text(),'Edit')])[7]");
        $this->type("id=User_email", "admintest@test.com");
        $this->clickAndWait("id=submitBtn");
        $this->clickAndWait("xpath=(//a[contains(text(),'Edit')])[7]");
        try {
            $this->assertEquals("admintest@test.com", $this->getValue("id=User_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $username = 'admintest@test.com';
        $this->login($username, '12345');
        $this->assertEquals("Logged in as admintest@test.com - Administrator", $this->getText("link=Logged in as admintest@test.com - Administrator"));
    }

    /* Scenario 3 Update email of admintest@test.com to staffmember@test.com. Should not update
      Expected Behavior
      Assert A profile already exists for this email address

     */

    function Scenario3() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("xpath=(//a[contains(text(),'Edit')])[7]");
        $this->type("id=User_email", "staffmember@test.com");
        $this->click("id=submitBtn");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("A profile already exists for this email address" == $this->getText("css=span.errorMessageEmail1"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("A profile already exists for this email address", $this->getText("css=span.errorMessageEmail1"));
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("xpath=(//a[contains(text(),'Edit')])[7]");
        try {
            $this->assertEquals("admintest@test.com", $this->getValue("id=User_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
    }

}

?>
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue145FunctionalTest
 * @author Jeremiah
 */
class Issue145FunctionalTest extends BaseFunctionalTest {

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

    /* Scenario 1 – Log in as super admin  then log visit, add new visitor, add new host
      Expected Behavior:
      Log in as new host then assert Incorrect user name password

     */

    function Scenario1() {
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
        $this->type("id=Visitor_first_name", "first");
        $this->type("id=Visitor_last_name", "first");

        $this->select("id=Visitor_company", "label=Philippine Airline");
        $this->type("id=Visitor_email", "first@first.com");
        $this->select("id=Visit_reason", "label=Reason 2");
        $this->type("id=Visitor_contact_number", "123456");
        $this->click("id=submitFormVisitor");
        $this->type("id=User_first_name", "first");
        $this->type("id=User_last_name", "first");
        $this->type("id=User_email", "first@test.com");
        $this->type("id=User_contact_number", "12345");
        sleep(1);
        $this->clickAndWait("id=submitFormUser");
        try {
            $this->assertEquals("first@first.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->assertEquals("Saved", $this->getText("css=ul.visitStatusLi > li > a > span"));
        $this->click("//ul[@id='tabs']/li[3]/a/p");
        $this->waitForPageToLoad("30000");
        $this->type("id=LoginForm_username", "first@test.com");
        $this->type("id=LoginForm_password", "12345");
        $this->click("name=yt0");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Incorrect username or password." == $this->getText("id=LoginForm_password_em_"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("Incorrect username or password.", $this->getText("id=LoginForm_password_em_"));
    }

    /* Scenario 2 - – Log in as super admin then add new host using add host in dashboard page
      Expected Behavior:
      Log in as new host then assert that host is successfully logged in
     */

    function Scenario2() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("id=yt0");
        $this->waitForElementPresent("id=User_tenant");
        $this->select("id=User_tenant", "label=NAIA Airport");
        $this->type("id=User_first_name", "second");
        $this->type("id=User_last_name", "second");
        $this->type("id=User_email", "second@test.com");
        $this->type("id=User_contact_number", "12345");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        $this->clickAndWait("id=submitFormUser");
        $this->click("//ul[@id='tabs']/li[3]/a/p");
        $this->waitForPageToLoad("30000");
        $this->type("id=LoginForm_username", "second@test.com");
        $this->type("id=LoginForm_password", "12345");
        $this->click("name=yt0");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Logged in as Staff Member", $this->getText("link=Logged in as Staff Member"));
    }

    /* Scenario 3 - Check password and repeat password present in add visitor profile, add host, add user */

    function Scenario3() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("id=yt0");
        $this->waitForElementPresent("id=User_password");
        $this->assertTrue($this->isElementPresent("id=User_password"));
        $this->click("css=a.submenu-icon.addvisitorprofile > span");
        $this->waitForPageToLoad("30000");
        $this->assertTrue($this->isElementPresent("id=Visitor_password"));
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("css=a.has-sub-sub > span");
        $this->waitForPageToLoad("30000");
        $this->assertTrue($this->isElementPresent("id=User_password"));
    }

}

?>
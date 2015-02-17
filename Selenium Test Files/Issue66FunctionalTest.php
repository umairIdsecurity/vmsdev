<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue57FunctionalTest
 * Preload Data
 * @author Jeremiah
 */
class Issue66FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://cvms.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
        $this->Scenario2();
    }

    /* Scenario 1 Assert organisation settings present in admin@test.com administration menu
      Expected Behavior
      Assert Organisation Settings in menu

     */

    function Scenario1() {
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->assertEquals("Organisation Settings", $this->getText("css=span"));
        $this->clickAndWait("css=span");
        $this->assertEquals("", $this->getText("id=Company_code"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $username = 'agentadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->assertEquals("Customise Display", $this->getText("css=span"));
    }

    /* Scenario 2 Assert organisation settings not present in adminofadmin@test.com
      Expected Behavior
      Only top admin can change company code
     */

    function Scenario2() {
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("css=li.submenu.addSubMenu > a > span");
        $this->waitForPageToLoad("30000");
        $this->type("id=User_first_name", "admin2");
        $this->type("id=User_last_name", "admin2");
        $this->type("id=User_email", "admin2@test.com");
        $this->type("id=User_contact_number", "12345");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeat_password", "12345");
        $this->click("id=submitBtn");
        $this->type("id=User_email", "adminofadmin@test.com");
        $this->click("id=submitBtn");
        $this->click("id=submitForm");
        $this->waitForPageToLoad("30000");
        $this->click("//ul[@id='tabs']/li[3]/a/p");
        $this->waitForPageToLoad("30000");
        $this->type("id=LoginForm_username", "adminofadmin@test.com");
        $this->type("id=LoginForm_password", "12345");
        $this->click("name=yt0");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Customise Display", $this->getText("link=Customise Display"));
    }

}

?>
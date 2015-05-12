<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*Comment to verify Git is working for me*/

require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue102FunctionalTest
 * @author Jeremiah
 */
class Issue102FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
    }

    /* Scenario 1 Enable update of password without current password
      Expected Behavior
      Assert password updated successfully
      Assert superadmin@test.com can log in with new password
     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("css=p");
        $this->clickAndWait("id=resetPasswordBtn");
        $this->type("name=Password[password]", "test");
        $this->type("name=Password[repeatpassword]", "test");
        $this->click("id=updateBtn");
        $this->clickAndWait("id=save");
        $this->assertEquals("Password successfully updated", $this->getText("css=div.flash-success"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->assertEquals("Incorrect username or password.", $this->getText("id=LoginForm_password_em_"));
        $username = 'superadmin@test.com';
        $this->login($username, 'test');
        $this->assertEquals("Dashboard", $this->getText("link=Dashboard"));
    }

}

?>
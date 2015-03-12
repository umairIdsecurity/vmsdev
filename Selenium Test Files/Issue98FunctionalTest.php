<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue98FunctionalTest
 * @author Jeremiah
 */
class Issue98FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
    }

    /* Scenario 1 Update password for testvisitor1@test.com as superadmin,admin, and agentadmin
      Expected Behavior
      Assert testvisitor1@test.com in table
     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("link=Manage Visitors");
        $this->assertEquals("testVisitor1@test.com", $this->getText("//div[@id='visitor-grid']/table/tbody/tr[3]/td[3]"));
        $this->clickAndWait("xpath=(//a[contains(text(),'Edit')])[3]");
        $this->assertEquals("", $this->getText("id=Visitor_password"));
        $this->assertEquals("", $this->getText("id=Visitor_repeatpassword"));
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->clickAndWait("id=submitFormVisitor");
        
        $this->assertEquals("testVisitor1@test.com", $this->getText("//div[@id='visitor-grid']/table/tbody/tr[3]/td[3]"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("css=a.managevisitorrecords > span");
        $this->clickAndWait("xpath=(//a[contains(text(),'Edit')])[3]");
        $this->type("id=Visitor_password", "123");
        $this->type("id=Visitor_repeatpassword", "123");
        $this->clickAndWait("id=submitFormVisitor");
        $this->assertEquals("testVisitor1@test.com", $this->getText("//div[@id='visitor-grid']/table/tbody/tr[3]/td[3]"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $username = 'agentadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("css=a.managevisitorrecords > span");
        $this->clickAndWait("xpath=(//a[contains(text(),'Edit')])[3]");
        $this->assertFalse($this->isElementPresent("id=Visitor_password"));
        $this->assertFalse($this->isElementPresent("id=Visitor_repeatpassword"));
    }

    /* Scenario 2 Check validation errors for updating password
      Expected Behavior
      Assert Please enter a password
      Assert please enter a repeat password
     */

    function Scenario2() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("css=a.managevisitorrecords > span");
        $this->clickAndWait("xpath=(//a[contains(text(),'Edit')])[3]");
        $this->click("id=submitFormVisitor");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Please enter a Password" == $this->getText("id=Visitor_password_em_"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("Please enter a Password", $this->getText("id=Visitor_password_em_"));
        $this->assertEquals("Please enter a Repeat Password", $this->getText("id=Visitor_repeatpassword_em_"));
        $this->type("id=Visitor_password", "123");
        $this->type("id=Visitor_repeatpassword", "1234");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Password does not match with Repeat \n Password." == $this->getText("//table[@id='addvisitor-table']/tbody/tr/td[2]/table/tbody/tr[7]/td[2]/div"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("Password does not match with Repeat \n Password.", $this->getText("//table[@id='addvisitor-table']/tbody/tr/td[2]/table/tbody/tr[7]/td[2]/div"));
    }

}

?>
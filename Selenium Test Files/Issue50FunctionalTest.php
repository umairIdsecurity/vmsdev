<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue50FunctionalTest
 *
 * @author Jeremiah
 */
class Issue50FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://cvms.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
        $this->Scenario2();
        $this->Scenario3();
        $this->Scenario4();
    }

    /* Scenario 1 - Change look and feel for Test Company 1
      Expected Behavior
      Assert Customisation Successfully updated !
      Assert #71d7f0 in nav background color
     */

    function Scenario1() {
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("link=Organisation Settings");
        $this->clickAndWait("link=Customise Look and Feel");
        $this->click("id=cp13");
        $this->type("id=CompanyLafPreferences_nav_bg_color", "#71d7f0");
        $this->type("//input[@type='file']", "C:\\xampp\\htdocs\\vms\\Selenium Test Files\\images\\Company-Icon.png");
        $this->clickAndWait("name=yt0");
        $this->assertEquals("Customisation Successfully updated!", $this->getText("css=div.flash-success"));
        try {
            $this->assertEquals("#71d7f0", $this->getValue("id=CompanyLafPreferences_nav_bg_color"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
    }

    /* Scenario 2 - Change look and feel for IDS
      Expected Behavior
      Assert Customisation Successfully updated !
      Assert #9ED92F in nav background color
     */

    function Scenario2() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Companies");
        $this->clickAndWait("link=Customise Look and Feel");
        $this->click("id=cp13");
        $this->type("id=CompanyLafPreferences_nav_bg_color", "#9ED92F");
        $this->type("//input[@type='file']", "C:\\xampp\\htdocs\\vms\\Selenium Test Files\\images\\Company-Icon.png");
        $this->clickAndWait("name=yt0");
        $this->assertEquals("Customisation Successfully updated!", $this->getText("css=div.flash-success"));
        try {
            $this->assertEquals("#9ED92F", $this->getValue("id=CompanyLafPreferences_nav_bg_color"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
    }

    /* Scenario 3 - Check if two companies have different values
      Expected Behavior
      Assert #71d7f0 in nav background color of test company1
      Assert #9ED92F in nav background color of IDS
     */

    function Scenario3() {
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Organisation Settings");
        $this->clickAndWait("link=Customise Look and Feel");
        try {
            $this->assertEquals("#71d7f0", $this->getValue("id=CompanyLafPreferences_nav_bg_color"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Companies");
        $this->clickAndWait("link=Customise Look and Feel");
        try {
            $this->assertEquals("#9ED92F", $this->getValue("id=CompanyLafPreferences_nav_bg_color"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
    }

    /* Scenario 4 - Check access controls
      Expected Behavior
      Assert Customisation Look and Feel Menu only for admin, agent admin, superadmin
     */

    function Scenario4() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Companies");
        $this->assertEquals("Customise Look and Feel", $this->getText("//div[@id='cssmenu']/ul/li/ul/li[2]/a/span"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");

        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("link=Organisation Settings");
        $this->assertEquals("Customise Look and Feel", $this->getText("css=a.ajaxLinkLi > span"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");

        $username = 'agentadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("link=Organisation Settings");
        $this->assertEquals("Customise Look and Feel", $this->getText("css=a.ajaxLinkLi > span"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");

        $username = 'operator@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("id=submit");
        $this->assertEquals("Dashboard Visitor Records Logged in as operator@test.com - Operator", $this->getText("css=nav.navigation > #tabs"));
        $this->open("http://cvms.identitysecurity.info/index.php?r=CompanyLafPreferences/customisation");
        $this->assertEquals("You are not authorized to perform this action.", $this->getText("css=div.error"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        
        $username = 'agentoperator@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("id=submit");
        $this->assertEquals("Dashboard Visitor Records Logged in as agentoperator@test.com - Agent Operator", $this->getText("css=nav.navigation > #tabs"));
        $this->open("http://cvms.identitysecurity.info/index.php?r=CompanyLafPreferences/customisation");
        $this->assertEquals("You are not authorized to perform this action.", $this->getText("css=div.error"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->assertEquals("Dashboard Visitor Records Logged in as staffmember@test.com - Staff Member", $this->getText("css=nav.navigation > #tabs"));
        $this->open("http://cvms.identitysecurity.info/index.php?r=CompanyLafPreferences/customisation");
        $this->assertEquals("You are not authorized to perform this action.", $this->getText("css=div.error"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
    }

}

?>
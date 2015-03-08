<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue44FunctionalTest
 *
 * @author Jeremiah
 */
class Issue44FunctionalTest extends BaseFunctionalTest {

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

    /* Scenario 1 - Add Visitor Profile Record 
      Expected Behavior
      Assert testaddvisitor1@test.com in emailaddress search field
     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Visitors");
        $this->clickAndWait("link=Add Visitor Profile");
        $this->addVisitor("addvisitor1");
        $this->clickAndWait("id=submitFormVisitor");
        $this->assertEquals("testaddvisitor1@test.com", $this->getText("//div[@id='visitor-grid']/table/tbody/tr/td[3]"));
        $this->clickAndWait("link=Edit");
        try {
            $this->assertEquals("Test", $this->getValue("id=Visitor_first_name"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        try {
            $this->assertEquals("addvisitor1", $this->getValue("id=Visitor_last_name"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        try {
            $this->assertEquals("testaddvisitor1@test.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        try {
            $this->assertEquals("1234567", $this->getValue("id=Visitor_contact_number"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        try {
            $this->assertEquals("Position", $this->getValue("id=Visitor_position"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->assertEquals("Select Tenant Test Company 1", $this->getText("id=Visitor_tenant"));
        try {
            $this->assertEquals("ABC123", $this->getValue("id=Visitor_vehicle"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
    }

    /* Scenario 2 - Add Visitor Profile Record with new company
      Expected Behavior
      Assert testaddvisitor2@test.com in emailaddress search field
     * Assert visitor company in company dropdown
     */

    function Scenario2() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Visitors");
        $this->clickAndWait("link=Add Visitor Profile");
        $this->addVisitor("addvisitor2");
        $this->addCompany("Visitor Company", "visitorcompany","VCA");
        $this->clickAndWait("id=submitFormVisitor");
        $this->assertEquals("testaddvisitor2@test.com", $this->getText("//div[@id='visitor-grid']/table/tbody/tr/td[3]"));
        $this->clickAndWait("link=Edit");
        try {
            $this->assertEquals("Test", $this->getValue("id=Visitor_first_name"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        try {
            $this->assertEquals("addvisitor2", $this->getValue("id=Visitor_last_name"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        try {
            $this->assertEquals("testaddvisitor2@test.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        try {
            $this->assertEquals("1234567", $this->getValue("id=Visitor_contact_number"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        try {
            $this->assertEquals("Position", $this->getValue("id=Visitor_position"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->assertEquals("Select Tenant Test Company 1", $this->getText("id=Visitor_tenant"));
        sleep(1);
        $this->assertEquals("Visitor Company", $this->getEval("window.document.getElementById(\"Visitor_company\").options[window.document.getElementById(\"Visitor_company\").selectedIndex].text"));

        try {
            $this->assertEquals("ABC123", $this->getValue("id=Visitor_vehicle"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
    }

    /* Scenario 3 - Check for verification erros
      Expected Behavior
      Assert "First Name cannot be blank"
      Assert "Last Name cannot be blank"
      Assert "Email Address cannot be blank"
     */

    function Scenario3() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Visitors");
        $this->clickAndWait("link=Add Visitor Profile");
        $this->click("id=submitFormVisitor");
        $this->waitForElementPresent("id=Visitor_first_name_em_");
        sleep(1);
        $this->assertEquals("Please enter a First Name", $this->getText("id=Visitor_first_name_em_"));
        $this->assertEquals("Please enter a Last Name", $this->getText("id=Visitor_last_name_em_"));
        $this->assertEquals("Please enter an Email Address", $this->getText("id=Visitor_email_em_"));
        $this->assertEquals("Please enter a Mobile Number", $this->getText("id=Visitor_contact_number_em_"));
        $this->assertEquals("Please select a Tenant", $this->getText("id=Visitor_tenant_em_"));
        $this->assertEquals("Please enter a Password", $this->getText("id=Visitor_password_em_"));
        $this->assertEquals("Please enter a Repeat Password", $this->getText("id=Visitor_repeatpassword_em_"));
        $this->type("id=Visitor_email", "123");
        $this->type("id=Visitor_position", "123");
        sleep(1);
        $this->assertEquals("Email Address is not a valid email address.", $this->getText("id=Visitor_email_em_"));
        $this->type("id=Visitor_password", "123");
        $this->type("id=Visitor_repeatpassword", "1234");
        $this->click("id=addCompanyLink");
        $this->assertEquals("Please select a tenant", $this->getText("id=Visitor_company_em_"));
        $this->type("id=Visitor_email", "123");
        $this->type("id=Visitor_position", "123");
        $this->assertEquals("Email Address is not a valid email address.", $this->getText("id=Visitor_email_em_"));
        $this->type("id=Visitor_password", "123");
        $this->type("id=Visitor_repeatpassword", "1234");
        $this->click("id=addCompanyLink");
        $this->assertEquals("Please select a tenant", $this->getText("id=Visitor_company_em_"));
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", "test");
        $this->type("id=Visitor_email", "testvisitor1@test.com");
        $this->type("id=Visitor_contact_number", "123456");
        $this->type("id=Visitor_position", "position");
        $this->select("id=Visitor_tenant", "label=Test Company 1");
        $this->type("id=Visitor_password", "1234");
        $this->click("id=submitFormVisitor");
        $this->waitForElementPresent("css=div.errorMessageEmail");
        sleep(1);
        $this->assertEquals("A profile already exists for this email address.", $this->getText("css=div.errorMessageEmail"));
    }

}

?>

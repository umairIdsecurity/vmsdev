<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue47FunctionalTest
 *
 * @author Jeremiah
 */
class Issue47FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*iexplore");
        $this->setBrowserUrl("http://cvms.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
        $this->Scenario2();
    }

    /* Scenario 1 - Preregister a corporate visitor with new company. Provide company code
      Expected Behavior
      Assert TC3 in card company code
     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Visitors");
        $this->clickAndWait("link=Preregister a Visit");
        $this->click("id=clicktabA");
        $this->select("id=Visitor_visitor_type", "label=Corporate Visitor");
        $this->addVisitor('Visitor5');
        $this->select("id=workstation", "label=Workstation1");
        $this->select("id=Visit_reason", "label=Reason 1");
        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Test Company 1" == $this->getText("id=Visitor_company"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Test Company 1", $this->getText("id=Visitor_company"));
        $this->addCompany("Visitor Company 1", "visitorcompany", "TCA");
        $this->click("id=submitFormVisitor");
        $this->waitForElementPresent("id=User_first_name");
        $this->addHost("staffmemberHostA");
        $this->waitForElementPresent("id=submitFormUser");
        $this->clickAndWait("id=submitFormUser");
        $this->verifyVisitorInTable('Visitor5');

        $this->clickAndWait("link=Dashboard");
        $this->clickAndWait("link=Preregistered");
        $this->assertEquals("TCA", $this->getText("css=#cardDetailsTable > tbody > tr > td"));
        //$this->assertEquals("TCA000008", $this->getText("//table[@id='cardDetailsTable']/tbody/tr[4]/td"));
        $this->clickAndWait("link=Administration");
        $this->click("id=yt0");
        $this->waitForElementPresent("name=Company[name]");
        $this->clickAndWait("link=Edit");
        try {
            $this->assertEquals("TCB", $this->getValue("id=Company_code"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
    }

    /* Scenario 2 - Check for validations
      Expected Behavior
      Assert Company code cannot be blank
      Assert Code is too short (Should be in 3 characters)
     */

    function Scenario2() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("id=yt0");
        $this->waitForElementPresent("link=Add Company");
        $this->clickAndWait("link=Add Company");
        $this->clickAndWait("id=createBtn");
        $this->assertEquals("Company Name cannot be blank.", $this->getText("css=div.errorMessage"));
        $this->assertEquals("Company Code cannot be blank.", $this->getText("//form[@id='company-form']/table/tbody/tr[3]/td[3]/div"));
        $this->type("id=Company_code", "AB");
        $this->clickAndWait("id=createBtn");
        $this->assertEquals("Code is too short (Should be in 3 characters)", $this->getText("//form[@id='company-form']/table/tbody/tr[3]/td[3]/div"));
    }

}

?>
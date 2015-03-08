<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue42FunctionalTest
 *
 * @author Jeremiah
 */
class Issue42FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
        $this->Scenario2();
    }

    /* Scenario 1 - Register a visitor with vehicle registration number
      Expected Behavior
      Assert "ABC123" in vehicle registration number
     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Visitors");
        $this->clickAndWait("link=Preregister Visit");
        $this->click("id=clicktabA");
        $this->select("id=Visitor_visitor_type","label=Corporate Visitor");
        $this->addVisitor('Visitor0');
        $this->select("id=workstation", "label=Workstation1");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->select("id=Visitor_tenant", "label=Test Company 1");
        $this->waitForElementPresent("id=submitFormVisitor");
        $this->click("id=submitFormVisitor");
        $this->addHost("host");
        $this->clickAndWait("id=submitFormUser");
        $this->verifyVisitorInTable('Visitor0');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("css=a.managevisitorrecords > span");
        sleep(2);
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Log Visit" == $this->getText("//div[@id='cssmenu']/ul/li[4]/ul/li[2]/a/span"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->clickAndWait("link=Edit");
        try {
            $this->assertEquals("ABC123", $this->getValue("id=Visitor_vehicle"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
    }
    
    /* Scenario 2 - Preregister a visitor with vehicle registration number
      Expected Behavior
      Assert "ABC123" in vehicle registration number
     */

    function Scenario2() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Visitors");
        $this->clickAndWait("link=Preregister Visit");
        $this->click("id=clicktabA");
        $this->select("id=Visitor_visitor_type","label=Corporate Visitor");
        $this->addVisitor('Visitor5');
        $this->select("id=workstation", "label=Workstation1");
        $this->select("id=Visitor_visitor_type_search", "label=Corporate Visitor");
        $this->addReason('Reason 3');
        $this->waitForElementPresent("id=submitFormVisitor");
        $this->click("id=submitFormVisitor");
//        $this->addPatient("Patient Name 1");
//        $this->clickAndWait("id=submitFormPatientName");
        $this->addHost("Host6");
        $this->clickAndWait("id=submitFormUser");
        $this->verifyVisitorInTable('Visitor5');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("css=a.managevisitorrecords > span");
        sleep(2);
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Log Visit" == $this->getText("//div[@id='cssmenu']/ul/li[4]/ul/li[2]/a/span"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->clickAndWait("link=Edit");
        try {
            $this->assertEquals("ABC123", $this->getValue("id=Visitor_vehicle"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
    }

}

?>

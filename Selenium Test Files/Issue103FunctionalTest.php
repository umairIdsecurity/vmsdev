<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue103FunctionalTest
 * @author Jeremiah
 */
class Issue103FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
    }

    /* Scenario 1 Change selected visitor to visitor selected
      Expected Behavior
      Assert Visitor selected after clicking a visitor in fnd visitor
     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("css=span");
        $this->click("id=clicktabA");
        $this->click("link=Search Visitor Profile");
        $this->select("id=search_visitor_tenant","label=NAIA Airport");
        sleep(1);
        $this->select("id=search_visitor_tenant_agent","label=Philippine Airline");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->waitForElementPresent("id=2");
        $this->click("id=2");
        sleep(1);
        $this->assertEquals("Visitor Selected", $this->getText("id=2"));
        $this->select("id=workstation_search", "label=Workstation2");
        $this->select("id=Visit_reason_search", "label=Reason 1");
        $this->click("id=clicktabB1");
        $this->click("link=Search Host");
        $this->type("id=search-host", "test");
        $this->click("id=dummy-host-findBtn");
        $this->waitForElementPresent("id=21");
        $this->click("id=21");
        $this->clickAndWait("id=clicktabB2");
        $this->assertEquals("Visitor1", $this->getText("//table[@id='personalDetailsTable']/tbody/tr[2]/td[2]"));
    }

}

?>
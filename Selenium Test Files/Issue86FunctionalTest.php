<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue86FunctionalTest
 * @author Jeremiah
 */
class Issue86FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
    }

    /* Scenario 1 Change selected host to host selected in find host register a visit page
      Expected Behavior
      Assert Host selected

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
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("id=2"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        sleep(1);
        $this->select("id=workstation_search", "label=Workstation1");
        $this->select("id=Visit_reason_search", "label=Reason 1");
        $this->click("id=2");
        $this->click("id=clicktabB1");
        $this->click("link=Search Host");
        $this->type("id=search-host", "test");
        $this->click("id=dummy-host-findBtn");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("id=21"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->click("id=21");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Host Selected" == $this->getText("id=21"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("Host Selected", $this->getText("id=21"));
    }

}

?>
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue40FunctionalTest
 * @author Jeremiah
 */
class Issue41FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*iexplore");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
    }

    /* Scenario 1 - All visit status will be displayed in visitor records page
      Expected Behavior
      Assert "Active","Preregistered","Closed","Expired" in visit status dropdown
     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Visitor Records");
        $this->assertEquals("Active Preregistered Closed Expired Saved", $this->getText("name=Visit[visit_status]"));
        $this->clickAndWait("link=Preregistered");
        $this->click("//li[@id='activateLi']/a/span");
        $this->type("id=Visitor_photo","1");
        $this->waitForElementPresent("css=#activate-a-visit-form > input.complete");
        $this->clickAndWait("css=#activate-a-visit-form > input.complete");
        $this->clickAndWait("link=Visitor Records");
        $this->select("name=Visit[visit_status]", "label=Active");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Displaying 1-1 of 1 result." == $this->getText("css=div.summary"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Displaying 1-1 of 1 result.", $this->getText("css=div.summary"));
        $this->select("name=Visit[visit_status]", "label=Preregistered");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Displaying 1-6 of 6 results." == $this->getText("css=div.summary"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Displaying 1-6 of 6 results.", $this->getText("css=div.summary"));
        
        $this->select("name=Visit[visit_status]", "label=Active");
        $this->waitForElementPresent("link=Active");
        $this->clickAndWait("link=Active");
        $this->click("css=#close-visit-form > input[type=\"submit\"]");
        $this->clickAndWait("link=Visitor Records");
        $this->select("name=Visit[visit_status]", "label=Closed");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Displaying 1-1 of 1 result." == $this->getText("css=div.summary"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Displaying 1-1 of 1 result.", $this->getText("css=div.summary"));
        $this->assertEquals("Closed", $this->getText("link=Closed"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Visitor Records");
        $this->assertEquals("Active Preregistered Closed Expired Saved", $this->getText("name=Visit[visit_status]"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $username = 'operator@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("id=submitBtn");
        $this->clickAndWait("link=Visitor Records");
        $this->assertEquals("Active Preregistered Closed Expired Saved", $this->getText("name=Visit[visit_status]"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Visitor Records");
        $this->assertEquals("Active Preregistered Closed Expired Saved", $this->getText("name=Visit[visit_status]"));
    }

}

?>

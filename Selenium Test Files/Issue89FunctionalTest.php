<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue89FunctionalTest
 * @author Jeremiah
 */
class Issue89FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://cvms.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
    }

    /* Scenario 1 Filter for dashboard
      Expected Behavior
      Assert TAC00007 in filter
      Assert Displaying 1-1 of 1 result
     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("css=tr.even > td > a.statusLink");
        $this->click("//li[@id='activateLi']/a/span");
        $this->clickAndWait("css=#activate-a-visit-form > input.complete");
        $this->clickAndWait("link=Active");
        $this->click("id=printCardBtn");
        $this->waitForPopUp("_blank", "30000");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("TCA000006", $this->getText("//table[@id='cardDetailsTable']/tbody/tr[4]/td/span"));
        $this->clickAndWait("link=Dashboard");
        $this->assertEquals("TCA000006", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr[2]/td[2]"));
        $this->type("name=Visit[cardcode]", "TCA");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("TCA000006" == $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[2]"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("TCA000006", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[2]"));
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
        $this->type("name=Visit[cardcode]", "");
        $this->type("name=Visit[lastname]", "1");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Displaying 1-4 of 4 results." == $this->getText("css=div.summary"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("Displaying 1-4 of 4 results.", $this->getText("css=div.summary"));
        $this->assertEquals("Visitor1", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[4]"));
        $this->assertEquals("Visitor1", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr[2]/td[4]"));
        $this->assertEquals("Visitor1", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr[3]/td[4]"));
        $this->assertEquals("Visitor1", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr[4]/td[4]"));
    }

}

?>
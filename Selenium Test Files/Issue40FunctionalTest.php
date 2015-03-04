<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue40FunctionalTest
 * Scheduled Jobs
 * @author Jeremiah
 */
class Issue40FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
    }

    /* Scenario 1 - Check tables and status filter in dashboard for all users
      Expected Behavior
      Assert "Active" and "Preregistered" in visit status dropdown
     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->assertEquals("Active Preregistered", $this->getText("name=Visit[visit_status]"));
        $this->clickAndWait("link=Preregistered");
        $this->click("//li[@id='activateLi']/a/span");
        $this->type("id=Visitor_photo", "1");
        $this->click("css=#activate-a-visit-form > input.complete");
        sleep(1);
        $this->assertEquals("Visit is now activated. You can now print the visitor badge.", $this->getAlert());
        $this->clickAndWait("link=Dashboard");
        $this->select("name=Visit[visit_status]", "label=Active");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Displaying 1-1 of 1 result" == $this->getText("css=div.summary"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Displaying 1-1 of 1 result", $this->getText("css=div.summary"));
        $this->select("name=Visit[visit_status]", "label=Preregistered");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Displaying 1-6 of 6 results" == $this->getText("css=div.summary"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Displaying 1-6 of 6 results", $this->getText("css=div.summary"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->assertEquals("Active Preregistered", $this->getText("name=Visit[visit_status]"));
        $this->select("name=Visit[visit_status]", "label=Active");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Displaying 1-1 of 1 result" == $this->getText("css=div.summary"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Displaying 1-1 of 1 result", $this->getText("css=div.summary"));
        $this->select("name=Visit[visit_status]", "label=Preregistered");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Displaying 1-5 of 6 results" == $this->getText("css=div.summary"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Displaying 1-5 of 6 results", $this->getText("css=div.summary"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $username = 'operator@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("id=submitBtn");
        $this->assertEquals("Active Preregistered", $this->getText("name=Visit[visit_status]"));
        $this->select("name=Visit[visit_status]", "label=Active");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Displaying 1-1 of 1 result" == $this->getText("css=div.summary"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Displaying 1-1 of 1 result", $this->getText("css=div.summary"));
        $this->select("name=Visit[visit_status]", "label=Preregistered");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Displaying 1-6 of 6 results" == $this->getText("css=div.summary"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Displaying 1-6 of 6 results", $this->getText("css=div.summary"));
    }

}

?>

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue88FunctionalTest
 * @author Jeremiah
 */
class Issue88FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://cvms.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
    }

    /* Scenario 1 Change text
      Expected Behavior
      'Manage Visitor Records change to 'Manage Visitors'
      'Add Visitor Record' change to 'Add Visitor Profile'
      'Export Visitor Records' change to 'Export Visit History'
      'Find or Add New Visitor Record' change to 'Find or Add New Visitor Profile'
      Change text in Main Menu 'Find Record' to 'Search Visits'
     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->assertEquals("Manage Visitors", $this->getText("css=a.managevisitorrecords > span"));
        $this->clickAndWait("link=Manage Visitors");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Manage Visitors" == $this->getText("css=h1"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("Manage Visitors", $this->getText("css=h1"));
        $this->assertEquals("Add Visitor Profile", $this->getText("//div[@id='cssmenu']/ul/li[4]/ul/li/a/span"));
        $this->clickAndWait("link=Dashboard");
        $this->assertEquals("Add Visitor Profile", $this->getText("//div[@id='cssmenu']/ul/li[3]/a/span"));
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[3]/a/span");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Add Visitor Profile" == $this->getText("css=h1"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("Add Visitor Profile", $this->getText("css=h1"));
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("link=Manage Visitors");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("//div[@id='cssmenu']/ul/li[4]/ul/li[4]/a/span"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("Export Visit History", $this->getText("//div[@id='cssmenu']/ul/li[4]/ul/li[4]/a/span"));
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[4]/ul/li[4]/a/span");
        $this->assertEquals("Visit History", $this->getText("css=h1"));
        $this->clickAndWait("link=Register a Visit");
        $this->assertEquals("Find or Add New Visitor Profile", $this->getText("id=findVisitorA"));
        $this->clickAndWait("link=Dashboard");
        $this->assertEquals("Search Visits", $this->getText("css=#findrecordSidebar > span"));
    }

}

?>
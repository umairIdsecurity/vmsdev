<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue81FunctionalTest
 *
 * @author Jeremiah
 */
class Issue81FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->open("http://dev.identitysecurity.info/index.php?r=site/reset&filename=test-data");
        $this->assertEquals("Tables imported successfully", $this->getText("css=body"));

        $this->open("http://dev.identitysecurity.info/index.php?r=site/reset&filename=Issue81");
        $this->assertEquals("Tables imported successfully", $this->getText("css=body"));

        $this->open("http://dev.identitysecurity.info/index.php?r=site/DBpatch");
        $this->assertEquals("--== Starting Patcher ==-- \nDone patch for issue81", $this->getText("css=body"));
        $this->Scenario1();
    }

    /* Scenario 1 – reprint card assert card code increments
     */

    function Scenario1() {
        $this->login("superadmin@test.com", "12345");
        $this->assertEquals("KLO000004", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[2]"));
        $this->assertEquals("KLO000002", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr[2]/td[2]"));
        $this->assertEquals("NAI000004", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr[3]/td[2]"));
        $this->assertEquals("NAI000003", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr[5]/td[2]"));
        $this->click("link=Active");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("KLO000004", $this->getText("//table[@id='cardDetailsTable']/tbody/tr[4]/td/span"));
        $this->click("link=Dashboard");
        $this->waitForPageToLoad("30000");
        $this->click("css=tr.even > td.green > a.statusLink");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("KLO000002", $this->getText("//table[@id='cardDetailsTable']/tbody/tr[4]/td/span"));
        $this->click("link=Dashboard");
        $this->waitForPageToLoad("30000");
        $this->click("xpath=(//a[contains(text(),'Active')])[3]");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("NAI000004", $this->getText("//table[@id='cardDetailsTable']/tbody/tr[4]/td/span"));
    }

}

?>
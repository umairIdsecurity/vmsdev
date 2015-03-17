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
        $this->open("http://dev.identitysecurity.info/index.php?r=site/reset&filename=test-data");
        $this->assertEquals("Tables imported successfully", $this->getText("css=body"));

        $this->open("http://dev.identitysecurity.info/index.php?r=site/DBpatch");
        $this->assertEquals("--== Starting Patcher ==-- \nDone patch for issue81", $this->getText("css=body"));
        $this->Scenario1();
    }

    /* Scenario 1 – check if dbpatch successfull
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

    /* Scenario 2 – check if card code in history
     * Activate a visit then assert card code
     * Reprint card code assert card code the same
     */

    function Scenario2() {
        $this->login("superadmin@test.com", "12345");
        $this->click("link=Visit History");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("KLO000004", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[3]"));
        $this->assertEquals("KLO000002", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr[2]/td[3]"));
        $this->assertEquals("NAI000004", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr[3]/td[3]"));
        $this->assertEquals("NAI000003", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr[6]/td[3]"));
        $this->assertEquals("NAI000002", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr[7]/td[3]"));
        $this->click("link=Saved");
        $this->waitForPageToLoad("30000");
        $this->click("css=#activate-a-visit-form > input.complete");
        $this->assertEquals("Visit is now activated. You can now print the visitor badge.", $this->getAlert());
        $this->assertEquals("CRK000001", $this->getText("//table[@id='cardDetailsTable']/tbody/tr[4]/td/span"));
        $this->click("link=Dashboard");
        $this->waitForPageToLoad("30000");
        $this->click("link=Dashboard");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("CRK000001", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr[4]/td[2]"));
        $this->click("link=Visit History");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("CRK000001", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr[4]/td[3]"));
        $this->click("xpath=(//a[contains(text(),'Active')])[4]");
        $this->waitForPageToLoad("30000");
        $this->click("id=printCardBtn");
        $this->waitForPopUp("_blank", "30000");
        $this->click("link=Dashboard");
        $this->waitForPageToLoad("30000");
        $this->click("xpath=(//a[contains(text(),'Active')])[4]");
        $this->waitForPageToLoad("30000");
        $this->click("id=reprintCardBtn");
        $this->waitForPopUp("_blank", "30000");
        $this->click("link=Dashboard");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("CRK000001", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr[4]/td[2]"));
        $this->click("xpath=(//a[contains(text(),'Active')])[4]");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("CRK000001", $this->getText("//table[@id='cardDetailsTable']/tbody/tr[4]/td/span"));
    }

}

?>
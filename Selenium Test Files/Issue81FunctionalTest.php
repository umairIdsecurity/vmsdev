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
        $this->open("http://dev.identitysecurity.info/index.php?r=site/reset&filename=live-demo");
        $this->assertEquals("Tables imported successfully", $this->getText("css=body"));

        $this->open("http://dev.identitysecurity.info/index.php?r=site/DBpatch");
        $this->assertEquals("--== Starting Patcher ==-- \nDone patch for issue81\nDone patch for issue137", $this->getText("css=body"));
        $this->Scenario1();
        $this->Scenario3();
    }

    /* Scenario 1 – check if dbpatch successfull
     */

    function Scenario1() {
        $this->login("superadmin@test.com", "12345");
        $this->assertEquals("PER000002", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[2]"));
        $this->assertEquals("KER000007", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr[3]/td[2]"));
        $this->assertEquals("SYD000124", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr[5]/td[2]"));
        $this->assertEquals("SYD000125", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr[6]/td[2]"));
        $this->assertEquals("SYD000102", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr[7]/td[2]"));
        $this->click("link=Visit History");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("PER000002", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[3]"));
        $this->click("link=Active");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("PER000002", $this->getText("//table[@id='cardDetailsTable']/tbody/tr[4]/td/span"));
        $this->click("link=Visit History");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("PER000005", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr[6]/td[3]"));
        $this->click("link=Closed");
        $this->waitForPageToLoad("30000");
        $this->clickAndWait("link=Visit History");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("PER000004", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr[7]/td[3]"));
        $this->assertEquals("PER000003", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr[8]/td[3]"));
        $this->assertEquals("PER000001", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr[9]/td[3]"));
        $this->click("link=2");
        $this->waitForElementPresent("//div[@id='view-visitor-records']/table/tbody/tr/td[3]");
        sleep(1);
        $this->assertEquals("KER000007", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[3]"));
        $this->assertEquals("KER000001", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr[3]/td[3]"));
        $this->assertEquals("ENS000005", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr[4]/td[3]"));
        $this->assertEquals("SYD000124", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr[5]/td[3]"));
        $this->assertEquals("SYD000125", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr[6]/td[3]"));
        $this->assertEquals("SYD000102", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr[7]/td[3]"));
    }

    /* Scenario 2 – check if card code in history
     * Activate a visit then assert card code
     * Reprint card code assert card code the same
     */

    function Scenario2() {
        $this->login("superadmin@test.com", "12345");
        $this->click("link=Visit History");
        $this->waitForPageToLoad("30000");
        $this->clickAndWait("link=Saved");
        $this->click("css=#activate-a-visit-form > input.complete");
        sleep(5);
        $this->assertEquals("Visit is now activated. You can now print the visitor badge.", $this->getAlert());
        $this->assertEquals("PER000006", $this->getText("//table[@id='cardDetailsTable']/tbody/tr[4]/td/span"));
        $this->clickAndWait("link=Visit History");
        $this->assertEquals("PER000006", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr[2]/td[3]"));
        $this->clickAndWait("css=tr.even > td.green > a.statusLink");
        $this->click("id=printCardBtn");
        $this->waitForPopUp("_blank", "30000");
        $this->click("link=Visit History");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("PER000006", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr[2]/td[3]"));
        $this->click("css=tr.even > td.green > a.statusLink");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("PER000006", $this->getText("//table[@id='cardDetailsTable']/tbody/tr[4]/td/span"));
    }

    /* Scenario 3 – activate another card and check that card code are not duplicated
     */

    function Scenario3() {
        $this->login("superadmin@test.com", "12345");
        $this->click("link=Visit History");
        $this->waitForPageToLoad("30000");
        $this->clickAndWait("link=Active");
        $this->clickAndWait("id=closeVisitBtnDummy");
        $this->clickAndWait("link=Visit History");
        $this->clickAndWait("link=Closed");
        $this->click("css=span.log-current");
        $this->clickAndWait("id=registerNewVisit");
        $this->assertEquals("PER000006", $this->getText("//table[@id='cardDetailsTable']/tbody/tr[4]/td/span"));
        $this->click("link=Visit History");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("PER000006", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[3]"));
        $this->click("link=Active");
        $this->waitForPageToLoad("30000");
        $this->click("id=cancelActiveVisitButton");
        $this->click("link=Visit History");
        $this->waitForPageToLoad("30000");
        $this->click("link=Saved");
        $this->waitForPageToLoad("30000");
        $this->click("css=#activate-a-visit-form > input.complete");
        sleep(5);
        $this->assertEquals("Visit is now activated. You can now print the visitor badge.", $this->getAlert());
        $this->assertEquals("PER000006", $this->getText("//table[@id='cardDetailsTable']/tbody/tr[4]/td/span"));
        $this->click("link=Visit History");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("PER000006", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[3]"));
    }

}

?>
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
        $this->Scenario1();
    }

    /* Scenario 1 – reprint card assert card code increments
     */

    function Scenario1() {
        $this->login("superadmin@test.com", "12345");
        $this->clickAndWait("css=tr.even > td.blue > a.statusLink");
        $this->click("css=span.log-current");
        $this->click("css=#activate-a-visit-form > input.complete");
        sleep(3);
        $this->assertEquals("Visit is now activated. You can now print the visitor badge.", $this->getAlert());
        $this->clickAndWait("link=Dashboard");
        $this->clickAndWait("link=Active");
        $this->assertEquals("NAI000001", $this->getText("//table[@id='cardDetailsTable']/tbody/tr[4]/td/span"));
        $this->click("id=printCardBtn");
        $this->waitForPopUp("_blank", "30000");
        $this->clickAndWait("link=Dashboard");
        $this->clickAndWait("link=Active");
        $this->click("id=reprintCardBtn");
        $this->waitForPopUp("_blank", "30000");
        $this->clickAndWait("link=Dashboard");
        $this->clickAndWait("link=Active");
        $this->assertEquals("NAI000002", $this->getText("//table[@id='cardDetailsTable']/tbody/tr[4]/td/span"));
    }

}

?>
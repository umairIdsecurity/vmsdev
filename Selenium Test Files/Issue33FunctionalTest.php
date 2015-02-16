<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';
date_default_timezone_set('Asia/Manila');

/**
 * Description of Issue33FunctionalTest ->
 * @author Jeremiah
 */
class Issue33FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*iexplore");
        $this->setBrowserUrl("http://cvms.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
    }

    /* Scenario 1 – Login as super admin check data control by updating status of card
     * For export visitor records all status except deleted
     * For evacuation report all active visits
     * For visitor registration history all closed visits only
     */

    function Scenario1() {
        $this->login("superadmin@test.com", '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Reports");
        $this->waitForElementPresent("link=Export Visitor Records");
        $this->clickAndWait("link=Export Visitor Records");
        $this->assertEquals("Displaying 1-7 of 7 results.", $this->getText("css=div.summary"));
        $this->selectWindow("null");
        $this->click("link=Reports");
        $this->assertEquals("Evacuation Report", $this->getText("link=Evacuation Report"));
        $this->assertEquals("Visitor Registration History", $this->getText("link=Visitor Registration History"));
        $this->clickAndWait("link=Evacuation Report");
        $this->clickAndWait("link=Visitor Registration History");
        $this->clickAndWait("link=Dashboard");
        $this->clickAndWait("link=Preregistered");
        $this->click("//li[@id='activateLi']/a/span");
        $this->type("id=Visitor_photo","1");
        $this->clickAndWait("css=#activate-a-visit-form > input.complete");
        $this->clickAndWait("link=Active");
        $this->clickAndWait("id=printCardBtn");
        $this->open("http://cvms.identitysecurity.info/index.php?r=visit/detail&id=7");
        $this->assertEquals("", $this->getText("id=reprintCardBtn"));
        $this->clickAndWait("link=Administration");
        $this->click("link=Reports");
        $this->waitForElementPresent("link=Evacuation Report");
        $this->clickAndWait("link=Evacuation Report");
        $this->assertEquals("testVisitor1@test.com", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[8]"));
        $this->assertEquals("Displaying 1-1 of 1 result.", $this->getText("css=div.summary"));
        $this->clickAndWait("link=Visitor Registration History");
        $this->assertEquals("No results found.", $this->getText("css=span.empty"));
        $this->clickAndWait("link=Evacuation Report");
        $this->clickAndWait("link=Active");
        
        $this->clickAndWait("css=#close-visit-form > input[type=\"submit\"]");
        $this->assertEquals("Visit Status: Closed", $this->getText("link=Visit Status: Closed"));
       
        $this->click("link=Reports");
        $this->clickAndWait("link=Evacuation Report");
        $this->assertEquals("No results found.", $this->getText("css=span.empty"));
        $this->clickAndWait("link=Visitor Registration History");
        $this->assertEquals("testVisitor1@test.com", $this->getText("//div[@id='view-visitor-records-history']/table/tbody/tr/td[8]"));
    }

}

?>
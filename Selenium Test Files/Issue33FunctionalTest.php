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
        $this->setBrowser("*firefox");
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
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("//div[@id='cssmenu']/ul/li[4]/a/span");
        $this->waitForPageToLoad("30000");
        $this->click("link=Export Visitor Records");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Displaying 1-7 of 7 results.", $this->getText("css=div.summary"));
        $this->selectWindow("null");
        $this->click("link=Reports");
        $this->assertEquals("Evacuation Report", $this->getText("css=li.has-sub.active > ul > li.even > a > span"));
        $this->assertEquals("Visitor Registration History", $this->getText("css=li.has-sub.active > ul > li.odd > a > span"));
        $this->click("link=Evacuation Report");
        $this->waitForPageToLoad("30000");
        $this->click("link=Visitor Registration History");
        $this->waitForPageToLoad("30000");
        $this->click("link=Dashboard");
        $this->waitForPageToLoad("30000");
        $this->click("link=Preregistered");
        $this->waitForPageToLoad("30000");
        $this->click("//li[@id='activateLi']/a/span");
        $this->clickAndWait("css=#activate-a-visit-form > input[type=\"submit\"]");
        $this->clickAndWait("id=printCardBtn");
        $this->waitForPageToLoad("30000");
        $this->open("http://cvms.identitysecurity.info/index.php?r=visit/detail&id=7");
        $this->assertEquals("", $this->getText("id=reprintCardBtn"));
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("//div[@id='cssmenu']/ul/li[7]/a/span");
        $this->click("link=Evacuation Report");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("testVisitor1@test.com", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[8]"));
        $this->assertEquals("Displaying 1-1 of 1 result.", $this->getText("css=div.summary"));
        $this->click("link=Visitor Registration History");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("No results found.", $this->getText("css=span.empty"));
        $this->click("link=Evacuation Report");
        $this->waitForPageToLoad("30000");
        $this->clickAndWait("link=Active");
        
        $this->clickAndWait("css=#close-visit-form > input[type=\"submit\"]");
        $this->assertEquals("Visit Status: Closed", $this->getText("link=Visit Status: Closed"));
       
        $this->click("link=Reports");
        $this->click("link=Evacuation Report");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("No results found.", $this->getText("css=span.empty"));
        $this->click("link=Visitor Registration History");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("testVisitor1@test.com", $this->getText("//div[@id='view-visitor-records-history']/table/tbody/tr/td[8]"));
    }

}

?>
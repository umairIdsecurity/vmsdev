<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue93FunctionalTest
 * @author Jeremiah
 */
class Issue93FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
    }

    /* Scenario 1 Prompt user after activating a visit
      Expected Behavior
      Assert Visit is now activated. You can now print the visitor badge.
     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("css=tr.even > td > a.statusLink");
        $this->assertEquals("Preregistered", $this->getText("css=ul.visitStatusLi > li > a > span"));
        $this->assertEquals("Preregister Visit", $this->getText("css=span.pre-visits"));
        $this->assertEquals("Log Visit", $this->getText("css=span.log-current"));
        $this->assertEquals("Visit Status: Preregistered", $this->getText("link=Visit Status: Preregistered"));
        $this->click("css=#activate-a-visit-form > input.complete");
        $this->waitForText("css=ul.visitStatusLi > li > a > span", "Active");
        $this->assertEquals("", $this->getText("id=printCardBtn"));
        $this->assertEquals("Close Visit", $this->getText("css=span.icons.close-visit"));
        $this->waitForElementPresent("css=ul.visitStatusLi > li > a > span");
        $this->assertEquals("Active", $this->getText("css=ul.visitStatusLi > li > a > span"));
        $this->assertEquals("Visit is now activated. You can now print the visitor badge.", $this->getAlert());
        $this->clickAndWait("link=Dashboard");
        $this->assertEquals("Active", $this->getText("css=tr.even > td > a.statusLink"));
    }

}

?>
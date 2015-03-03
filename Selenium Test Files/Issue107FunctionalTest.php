<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue107FunctionalTest
 * @author Jeremiah
 */
class Issue107FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
        $this->Scenario2();
    }

    /* Scenario 1 Preregister a same day visitor
      Expected Behavior
      Assert proposed date out not present

     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("css=tr.even > td.blue > a.statusLink");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Preregistered", $this->getText("css=ul.visitStatusLi > li > a > span"));
        $this->assertEquals("Same Day Visitor Multiday Visitor", $this->getText("id=Visit_card_type"));
        $this->clickAndWait("id=confirmPreregisterDummy");
        $this->clickAndWait("css=tr.even > td.blue > a.statusLink");
        $this->assertEquals("04 Mar 15", $this->getText("css=span.cardDateText"));
    }

    /* Scenario 2 - Preregister a multiday visitor 
     * Expected Behavior
     * - Assert proposed date out present
     *   
     * 
     */

    function Scenario2() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Preregistered");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("", $this->getText("//img[@alt='Select Proposed Date Out']"));
        $this->clickAndWait("id=confirmPreregisterDummy");
        $this->clickAndWait("link=Preregistered");
        $this->assertEquals("06 Mar 15", $this->getText("css=span.cardDateText"));
        $this->assertEquals("Preregistered", $this->getText("css=ul.visitStatusLi > li > a > span"));
    }

}

?>
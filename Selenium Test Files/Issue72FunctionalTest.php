<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue72FunctionalTest
 * Preload Data
 * @author Jeremiah
 */
class Issue72FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
    }

    /* Scenario 1 Assert Max Size: 2MB ;File Ext. : jpeg/png Dimensions: 180px(Width) x 60px(Height) in drag and drop div
      Expected Behavior
      New text should be displayed in drag and drop field of form

     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("id=yt7");
        $this->waitForElementPresent("css=span");
        $this->clickAndWait("css=span");
        $this->assertEquals("Dimensions: 180px(Width) x 60px(Height)", $this->getText("css=span.imageDimensions"));
    }

}

?>
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue46FunctionalTest
 *
 * @author Jeremiah
 */
class Issue46FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
    }

    /* Scenario 1 - Upload Photo Visitor Detail page
      Expected Behavior
      Assert photo uploaded is correct
     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Dashboard");
        $this->clickAndWait("link=Preregistered");
        $this->type("//input[@type='file']", "C:\\xampp\\htdocs\\vms\\Selenium Test Files\\images\\profile.jpg");
        $this->click("id=submitBtnPhoto");
        $this->assertEquals("", $this->getText("id=cropImageBtn"));
       // $this->assertEquals("", $this->getText("css=img.cardCompanyLogo"));
        $this->type("id=Visitor_photo", "2");
        $this->clickAndWait("link=Dashboard");
        $this->clickAndWait("link=Preregistered");
        $this->assertEquals("2", $this->getValue("id=Visitor_photo"));
    }

}

?>

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue84FunctionalTest
 * @author Jeremiah
 */
class Issue84FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://cvms.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
    }

    /* Scenario 1 Label side menu to side menu and header text
      Expected Behavior
      Assert Side menu and header text

     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("id=yt0");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("//div[@id='cssmenu']/ul/li/ul/li[2]/a/span"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->clickAndWait("//div[@id='cssmenu']/ul/li/ul/li[2]/a/span");
        $this->assertEquals("Side Menu and Header Text", $this->getText("css=#sideMenuDiv > span.customTitle"));
    }

}

?>
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
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
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
        $this->click("id=yt7");
        $this->waitForElementPresent("css=span");
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
        $this->assertEquals("Text Color", $this->getText("//div[@id='actionForwardButtonDiv']/div/label[3]"));
        $this->assertEquals("Hover Text Color", $this->getText("//div[@id='actionForwardButtonDiv']/div/label[6]"));
        $this->assertEquals("Text Color", $this->getText("//div[@id='completeButtonDiv']/div/label[3]"));
        $this->assertEquals("Hover Text Color", $this->getText("//div[@id='completeButtonDiv']/div/label[6]"));
        $this->assertEquals("Text Color", $this->getText("//div[@id='neutralButtonDiv']/div/label[3]"));
        $this->assertEquals("Hover Text Color", $this->getText("//div[@id='neutralButtonDiv']/div/label[6]"));
        $this->assertEquals("Text Color", $this->getText("//div[@id='navMenuDiv']/div/label[2]"));
        $this->assertEquals("Hover Text Color", $this->getText("//div[@id='navMenuDiv']/div/label[4]"));
        $this->assertEquals("Text Color", $this->getText("//div[@id='sideMenuDiv']/div/label[2]"));
        $this->assertEquals("Hover Text Color", $this->getText("//div[@id='sideMenuDiv']/div/label[4]"));
    }

}

?>
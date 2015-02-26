<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue74FunctionalTest
 *
 * @author Jeremiah
 */
class Issue74FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://cvms.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
    }

    /* Scenario 1 Type different formats of website, error should not be shown after submit
      Expected Behavior
      Assert 'Website url is not valid' error is not present

     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("id=yt0");
        $this->clickAndWait("link=Add Company");
        $this->type("id=Company_website", "stableapps.com");
        $this->clickAndWait("id=createBtn");
        $this->assertFalse($this->isElementPresent("//form[@id='company-form']/table/tbody/tr[10]/td[3]/d"));
        try {
            $this->assertEquals("http://stableapps.com", $this->getValue("id=Company_website"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->type("id=Company_website", "www.stableapps.com");
        $this->clickAndWait("id=createBtn");
        $this->assertFalse($this->isElementPresent("//form[@id='company-form']/table/tbody/tr[10]/td[3]/d"));
        try {
            $this->assertEquals("http://www.stableapps.com", $this->getValue("id=Company_website"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->type("id=Company_website", "stableapps.gov.ph");
        $this->clickAndWait("id=createBtn");
        $this->assertFalse($this->isElementPresent("//form[@id='company-form']/table/tbody/tr[10]/td[3]/d"));
        try {
            $this->assertEquals("http://stableapps.gov.ph", $this->getValue("id=Company_website"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->type("id=Company_website", "http://hello.com");
        $this->clickAndWait("id=createBtn");
        $this->assertFalse($this->isElementPresent("//form[@id='company-form']/table/tbody/tr[10]/td[3]/d"));
        try {
            $this->assertEquals("http://hello.com", $this->getValue("id=Company_website"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->type("id=Company_website", "123");
        $this->clickAndWait("id=createBtn");
        $this->assertEquals("Website is not a valid URL.", $this->getText("//form[@id='company-form']/table/tbody/tr[10]/td[3]/div"));
        
        $this->clickAndWait("link=Add Company");
        $this->type("id=Company_website", "www.yahoo");
        $this->click("id=createBtn");
        $this->waitForElementPresent("id=websiteErrorMessage");
        $this->assertEquals("Website is not a valid URL.", $this->getText("id=websiteErrorMessage"));
        $this->type("id=Company_website", "www.yahoo.com");
        $this->clickAndWait("id=createBtn");
        $this->type("id=Company_name", "test");
        $this->type("id=Company_code", "tes");
        $this->clickAndWait("id=createBtn");
        $this->assertEquals("test", $this->getText("css=tr.odd > td"));
        $this->clickAndWait("link=Edit");
        try {
            $this->assertEquals("http://www.yahoo.com", $this->getValue("id=Company_website"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
    }

}

?>
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue69FunctionalTest
 * Preload Data
 * @author Jeremiah
 */
class Issue69FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://cvms.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
    }

    /* Scenario 1 Assert card code is displayed in tables 
      Expected Behavior
      Assert card code in dashboard, view records,evacuation report, view registration history

     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("css=tr.even > td > a.statusLink");
        $this->click("//li[@id='activateLi']/a/span");
        $this->clickAndWait("css=#activate-a-visit-form > input.complete");
        $this->clickAndWait("link=Active");
        $this->click("id=printCardBtn");
        $this->waitForPopUp("_blank", "30000");
        $this->waitForPageToLoad("30000");
        $this->clickAndWait("link=Dashboard");
        $this->assertEquals("TCA000006", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr[2]/td[2]"));
        $this->clickAndWait("css=#findrecordSidebar > span");
        $this->assertEquals("TCA000006", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr[2]/td[3]"));
        $this->clickAndWait("link=Dashboard");
        $this->clickAndWait("css=#evacuationreportSidebar > span");
        $this->assertEquals("TCA000006", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[3]"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->assertEquals("TCA000006", $this->getText("//div[@id='visit-gridDashboard1']/table/tbody/tr[2]/td[2]"));
        $this->clickAndWait("id=findrecordSidebar");
        $this->assertEquals("TCA000006", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr[2]/td[3]"));
        $this->clickAndWait("link=Dashboard");
        $this->clickAndWait("css=#evacuationreportSidebar > span");
        $this->assertEquals("TCA000006", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[3]"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
         $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("css=tr.even > td > a.statusLink");
        $this->click("//li[@id='activateLi']/a/span");
        $this->clickAndWait("css=#activate-a-visit-form > input.complete");
        
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("xpath=(//a[contains(text(),'Active')])[2]");
        $this->click("id=printCardBtn");
        $this->waitForPopUp("_blank", "30000");
        $this->waitForPageToLoad("30000");
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Visitor Records");
        $this->assertEquals("TCA000005", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr[2]/td[3]"));
        $this->clickAndWait("link=Dashboard");
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[6]/a/span");
        $this->assertEquals("TCA000005", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[3]"));
    }

    

}

?>
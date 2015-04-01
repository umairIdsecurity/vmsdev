<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue91FunctionalTest
 * @author Jeremiah
 */
class Issue91FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
    }

    /* Scenario 1 Changed labels in sidebar menu
      Expected Behavior
      Assert register a visit - Log visit
     * Assert preregister a visit- preregister visit
     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->assertEquals("Log Visit", $this->getText("css=span"));
        $this->assertEquals("Preregister Visit", $this->getText("link=Preregister Visit"));
        $this->assertEquals("Add Host", $this->getText("id=yt0"));
        $this->assertEquals("Add Visitor Profile", $this->getText("css=a.submenu-icon.addvisitorprofile > span"));
        $this->assertEquals("Search Visits", $this->getText("css=#findrecordSidebar > span"));
        $this->assertEquals("Evacuation Report", $this->getText("css=#evacuationreportSidebar > span"));
        $this->clickAndWait("css=span");
        $this->assertEquals("Log Visit", $this->getText("css=h1"));
        $this->clickAndWait("css=a.sidemenu-icon.pre-visits > span");
        $this->assertEquals("Preregister Visit", $this->getText("css=h1"));
        $this->clickAndWait("link=Dashboard");
        $this->clickAndWait("link=Preregistered");
        $this->assertEquals("Preregister Visit", $this->getText("css=span.pre-visits"));
        $this->assertEquals("Log Visit", $this->getText("css=span.log-current"));
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("css=a.managevisitorrecords > span");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Log Visit" == $this->getText("//div[@id='cssmenu']/ul/li[4]/ul/li[2]/a/span"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("Log Visit", $this->getText("//div[@id='cssmenu']/ul/li[4]/ul/li[2]/a/span"));
        $this->assertEquals("Preregister Visit", $this->getText("//div[@id='cssmenu']/ul/li[4]/ul/li[3]/a/span"));
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[4]/ul/li[2]/a/span");
        $this->assertEquals("Log Visit", $this->getText("css=h1"));
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[4]/ul/li[3]/a/span");
        $this->assertEquals("Preregister Visit", $this->getText("css=h1"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->assertEquals("Log Visit", $this->getText("css=span"));
        $this->assertEquals("Preregister Visit", $this->getText("css=a.sidemenu-icon.pre-visits > span"));
        $this->assertEquals("Add Host", $this->getText("id=yt0"));
        $this->clickAndWait("id=addvisitorSidebar");
        $this->assertEquals("Log Visit", $this->getText("css=h1"));
        $this->assertEquals("Log Visit", $this->getText("link=Log Visit"));
        $this->assertEquals("Preregister Visit", $this->getText("css=a.sidemenu-icon.pre-visits > span"));
        $this->clickAndWait("css=a.sidemenu-icon.pre-visits > span");
        $this->assertEquals("Preregister Visit", $this->getText("css=h1"));
        $this->clickAndWait("css=a.submenu-icon.addvisitorprofile > span");
        $this->assertEquals("Add Visitor Profile", $this->getText("css=h1"));
        $this->clickAndWait("link=Dashboard");
        $this->clickAndWait("link=Preregistered");
        $this->assertEquals("Preregister Visit", $this->getText("css=span.pre-visits"));
        $this->assertEquals("Log Visit", $this->getText("css=span.log-current"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $username = 'operator@test.com';
        $this->login($username, '12345');
        $this->select("id=userWorkstation", "label=Workstation1");
        $this->click("id=submitBtn");
        $this->click("id=submit");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Log Visit", $this->getText("css=span"));
        $this->assertEquals("Preregister Visit", $this->getText("css=a.sidemenu-icon.pre-visits > span"));
        $this->clickAndWait("css=span");
        $this->assertEquals("Log Visit", $this->getText("css=h1"));
        $this->clickAndWait("css=a.sidemenu-icon.pre-visits > span");
        $this->assertEquals("Preregister Visit", $this->getText("css=h1"));
        $this->clickAndWait("css=span");
        $this->clickAndWait("link=Dashboard");
        $this->clickAndWait("link=Preregistered");
        $this->assertEquals("Preregister Visit", $this->getText("css=span.pre-visits"));
        $this->assertEquals("Log Visit", $this->getText("css=span.log-current"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->assertEquals("Log Visit", $this->getText("link=Log Visit"));
        $this->assertEquals("Preregister Visit", $this->getText("link=Preregister Visit"));
        $this->clickAndWait("css=span");
        $this->assertEquals("Log Visit", $this->getText("css=h1"));
        $this->clickAndWait("css=a.submenu-icon.pre-visits > span");
        $this->assertEquals("Preregister Visit", $this->getText("css=h1"));
        $this->clickAndWait("link=Dashboard");
        $this->clickAndWait("link=Preregistered");
        $this->assertEquals("Preregister Visit", $this->getText("css=span.pre-visits"));
        $this->assertEquals("Log Visit", $this->getText("css=span.log-current"));
    }

}

?>
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue52FunctionalTest
 *
 * @author Jeremiah
 */
class Issue52FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
        $this->Scenario2();
    }

    /* Scenario 1 - Close a visit
      Expected Behavior
      Assert Closed

     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->closeVisit();
        $this->assertEquals("Closed", $this->getText("link=Closed"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");

        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->closeVisit();
        $this->type("name=Visit[contactemail]", "testvisitor4@test.com");
        $this->assertEquals("Closed", $this->getText("link=Closed"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");

        $username = 'agentadmin@test.com';
        $this->login($username, '12345');
        $this->closeVisit();
        $this->type("name=Visit[contactemail]", "testvisitor3@test.com");
        $this->assertEquals("Closed", $this->getText("link=Closed"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");

        $username = 'agentoperator@test.com';
        $this->login($username, '12345');
        $this->click("id=submitBtn");
        $this->clickAndWait("id=submit");
        $this->closeVisit();
        $this->type("name=Visit[contactemail]", "testvisitor3@test.com");
        $this->assertEquals("Closed", $this->getText("link=Closed"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");

        $username = 'operator@test.com';
        $this->login($username, '12345');
        $this->click("id=submitBtn");
        $this->clickAndWait("id=submit");
        $this->closeVisit();
        $this->type("name=Visit[contactemail]", "testvisitor3@test.com");
        $this->assertEquals("Closed", $this->getText("xpath=(//a[contains(text(),'Closed')])[5]"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
    }

    function closeVisit() {
        $this->clickAndWait("link=Preregistered");
        $this->click("//li[@id='activateLi']/a/span");
        $this->type("id=Visitor_photo","1");
        $this->click("css=#activate-a-visit-form > input.complete");
        sleep(5);
        $this->assertEquals("Visit is now activated. You can now print the visitor badge.", $this->getAlert());
        $this->clickAndWait("link=Dashboard");
        $this->clickAndWait("link=Dashboard");
        $this->clickAndWait("link=Active");
        $this->clickAndWait("css=#close-visit-form > input.complete");
        $this->assertEquals("Closed", $this->getText("css=ul.visitStatusLi > li > a > span"));
        $this->clickAndWait("link=Visit History");
    }
    
   function assertCloseVisitSpan(){
       $this->clickAndWait("link=Active");
        $this->assertEquals("Close Visit", $this->getText("//li[@id='closevisitLi']/a/span"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
   }

    /* Scenario 2 - Check access controls for manual closing of cards

     * Expected Behavior
     *   
     *      */

    function Scenario2() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Preregistered");
        $this->click("//li[@id='activateLi']/a/span");
        $this->click("css=#activate-a-visit-form > input.complete");
        sleep(5);
        $this->assertEquals("Visit is now activated. You can now print the visitor badge.", $this->getAlert());
        $this->clickAndWait("link=Dashboard");
        $this->clickAndWait("link=Dashboard");
        $this->clickAndWait("link=Active");
        $this->assertEquals("Close Visit", $this->getText("//li[@id='closevisitLi']/a/span"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->assertCloseVisitSpan();
        
        $username = 'agentadmin@test.com';
        $this->login($username, '12345');
        $this->assertCloseVisitSpan();
        
        $username = 'operator@test.com';
        $this->login($username, '12345');
        $this->click("id=submitBtn");
        $this->clickAndWait("id=submit");
        $this->assertCloseVisitSpan();
        
        $username = 'agentoperator@test.com';
        $this->login($username, '12345');
        $this->click("id=submitBtn");
        $this->clickAndWait("id=submit");
        $this->assertCloseVisitSpan();
        
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[2]/a/span");
        $this->click("id=clicktabA");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->select("id=workstation_search", "label=Workstation1");
        $this->select("id=Visit_reason_search", "label=Reason 1");
        $this->waitForElementPresent("id=3");
        $this->click("id=3");
        $this->click("id=clicktabB1");
        $this->clickAndWait("id=saveCurrentUserAsHost");
        $this->clickAndWait("link=Dashboard");
        $this->clickAndWait("link=Preregistered");
    }

}

?>
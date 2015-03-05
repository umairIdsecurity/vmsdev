<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue92FunctionalTest
 * @author Jeremiah
 */
class Issue92FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
    }

    /* Scenario 1 Changed visitor has an active visit  -> Status:Active
      Expected Behavior
      Assert Visit:Active in table
      Assert visitor detail page. testvisitor4@test.com after redirect
     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("css=tr.even > td.blue > a.statusLink");
        $this->assertEquals("Preregistered", $this->getText("css=ul.visitStatusLi > li > a > span"));
        $this->click("css=#activateLi > a");
        $this->click("css=#activate-a-visit-form > input.complete");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Active" == $this->getText("css=ul.visitStatusLi > li > a > span"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("Status: Active", $this->getText("link=exact:Status: Active"));
        $this->assertEquals("Visit is now activated. You can now print the visitor badge.", $this->getAlert());
        $this->clickAndWait("css=span");
        $this->click("id=clicktabA");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->waitForElementPresent("id=2");
        $this->assertEquals("Status: Active", $this->getText("//div[@id='findvisitor-grid']/table/tbody/tr[3]/td[5]"));
        $this->clickAndWait("link=Active");
        $this->assertEquals("Visitor Detail", $this->getText("css=td"));
        $this->assertEquals("Active", $this->getText("css=ul.visitStatusLi > li > a > span"));
        try {
            $this->assertEquals("testVisitor4@test.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
    }

}

?>
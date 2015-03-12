<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue127FunctionalTest
 * @author Jeremiah
 */
class Issue127FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
    }

    /* Scenario 1 – Input Chris O'Brien in company name
     * assert chris o'brien in manage company tables
     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("id=yt7");
        $this->click("css=span");
        $this->waitForPageToLoad("30000");
        $this->type("id=Company_name", "Chris O'Brien Lifehouse");
        $this->type("id=Company_code", "CA'");
        $this->click("id=createBtn");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Code can only contain letters", $this->getText("css=div.errorMessage"));
        $this->type("id=Company_code", "CAL");
        $this->click("id=createBtn");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Chris O'Brien Lifehouse", $this->getText("css=tr.odd > td"));
        $this->click("css=span");
        $this->waitForPageToLoad("30000");
        $this->type("id=Company_name", "#$%^&*()!@#$%^&*()_<>>?<");
        $this->type("id=Company_code", "DAE");
        $this->clickAndWait("id=createBtn");
        $this->assertTrue((bool) preg_match('/^exact:#\$%^&[\s\S]*\(\)!@#\$%^&[\s\S]*\(\)_<>>[\s\S]<$/', $this->getText("css=tr.odd > td")));
    }

}

?>
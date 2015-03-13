<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue57FunctionalTest
 * Preload Data
 * @author Jeremiah
 */
class Issue57FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->clearMailcatcher();
        $this->Scenario1();
        $this->Scenario2();
        $this->Scenario3();
    }

    /* Scenario 1 Send Contact Support Email to Administration Support 
      Expected Behavior
      Assert Thank you for contacting us. We will respond to you as soon as possible.
      Assert email subject Administration Support
      Assert email from and to correct
      Assert message is correct

     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->sendAdminSupport("support@idsecurity.com.au", "superadmin@test.com");
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->sendAdminSupport("superadmin@test.com", "admin@test.com");
        $username = 'agentadmin@test.com';
        $this->login($username, '12345');
        $this->sendAdminSupport("admin@test.com", "agentadmin@test.com");
        $username = 'operator@test.com';
        $this->login($username, '12345');
        $this->click("id=submitBtn");
        $this->clickAndWait("id=submit");
        $this->sendAdminSupport("admin@test.com", "operator@test.com");
        $username = 'agentoperator@test.com';
        $this->login($username, '12345');
        $this->click("id=submitBtn");
        $this->clickAndWait("id=submit");
        $this->sendAdminSupport("admin@test.com", "agentoperator@test.com");
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->sendAdminSupport("admin@test.com", "staffmember@test.com");
        $this->addNewAdmin();
        $username = 'admin3@test.com';
        $this->login($username, '12345');
        $this->sendAdminSupport("admin@test.com", "admin3@test.com");
    }
    
    
    /* Scenario 2 Send Contact Support Email to Technical Support 
      Expected Behavior
      Assert Thank you for contacting us. We will respond to you as soon as possible.
      Assert email subject Technical Support
      Assert email from and to correct
      Assert message is correct

     */

    function Scenario2() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->sendTechSupport("superadmin@test.com");
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->sendTechSupport("admin@test.com");
        $username = 'agentadmin@test.com';
        $this->login($username, '12345');
        $this->sendTechSupport("agentadmin@test.com");
        $username = 'operator@test.com';
        $this->login($username, '12345');
        $this->click("id=submitBtn");
        $this->clickAndWait("id=submit");
        $this->sendTechSupport("operator@test.com");
        $username = 'agentoperator@test.com';
        $this->login($username, '12345');
        $this->click("id=submitBtn");
        $this->clickAndWait("id=submit");
        $this->sendTechSupport("agentoperator@test.com");
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->sendTechSupport("staffmember@test.com");
        $username = 'admin3@test.com';
        $this->login($username, '12345');
        $this->sendTechSupport("admin3@test.com");
    }
    
    /* Scenario 3 Check for validation errors
      Expected Behavior
      Assert Message cannot be blank

     */

    function Scenario3() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("//ul[@id='tabs']/li[2]/a/p");
        $this->clickAndWait("name=yt0");
        $this->assertEquals("Please enter a Message", $this->getText("css=div.errorSummary > ul > li"));
        
    }

    function sendAdminSupport($adminEmail,$fromEmail){
        $this->clickAndWait("//ul[@id='tabs']/li[2]/a/p");
        $this->select("id=ContactForm_subject", "label=Administration Support");
        $this->type("id=ContactForm_message", "Good Day,\n\n\nThis is a sample email for admin support ".$adminEmail);
        try {
            $this->assertEquals("Send", $this->getValue("name=yt0"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->clickAndWait("name=yt0");
        $this->assertEquals("Thank you for contacting us. We will respond to you as soon as possible.", $this->getText("css=div.flash-success"));
        $this->goToMailcatcher();
        $this->click("//nav[@id='messages']/table/tbody/tr/td[2]");
        $this->waitForElementPresent("css=pre");
        $this->assertEquals("Good Day,\n\n\nThis is a sample email for admin support ".$adminEmail."\n\n~This message was sent via Visitor Management System~", $this->getText("css=pre"));
        $this->assertEquals("<".$adminEmail.">", $this->getText("css=dd.to"));
        $this->assertEquals("<".$fromEmail.">", $this->getText("css=dd.from"));
        $this->assertEquals("Administration Support", $this->getText("css=dd.subject"));
        $this->clearMailcatcher();
    }
    
    function sendTechSupport($fromEmail){
        $this->clickAndWait("//ul[@id='tabs']/li[2]/a/p");
        $this->select("id=ContactForm_subject", "label=Technical Support");
        $this->type("id=ContactForm_message", "Good Day,\n\n\nThis is a sample email for technical support support@idsecurity.com.au");
        try {
            $this->assertEquals("Send", $this->getValue("name=yt0"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->clickAndWait("name=yt0");
        $this->assertEquals("Thank you for contacting us. We will respond to you as soon as possible.", $this->getText("css=div.flash-success"));
        $this->goToMailcatcher();
        $this->click("//nav[@id='messages']/table/tbody/tr/td[2]");
        $this->waitForElementPresent("css=pre");
        $this->assertEquals("Good Day,\n\n\nThis is a sample email for technical support support@idsecurity.com.au\n\n~This message was sent via Visitor Management System~", $this->getText("css=pre"));
        $this->assertEquals("<support@idsecurity.com.au>", $this->getText("css=dd.to"));
        $this->assertEquals("<".$fromEmail.">", $this->getText("css=dd.from"));
        $this->assertEquals("Technical Support", $this->getText("css=dd.subject"));
        $this->clearMailcatcher();
    }
    
    function goToMailcatcher() {
        $this->open("http://localhost:1080/");
        $this->selectWindow("title=MailCatcher");
        $this->windowFocus();
    }
    
    function addNewAdmin(){
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Users");
        $this->clickAndWait("link=Add Administrator");
        $this->addUser("admin3@test.com", "admin3");
        $this->clickAndWait("id=submitForm");
        $this->type("css=td > input[name=\"User[first_name]\"]", "Test");
        $this->click("//td[2]/input");
        $this->type("//td[2]/input", "Admin3");
        $this->select("css=select[name=\"User[role]\"]", "label=Administrator");
        $this->select("css=select[name=\"User[user_type]\"]", "label=Internal");
        sleep(1);
        $this->assertEquals("Test", $this->getText("css=tr.odd > td"));
        $this->assertEquals("admin3", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[2]"));
        $this->assertEquals("Administrator", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[3]"));
        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Displaying 1-1 of 1 result" == $this->getText("css=div.summary"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Displaying 1-1 of 1 result", $this->getText("css=div.summary"));
    }

}

?>

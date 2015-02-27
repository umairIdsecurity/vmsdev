<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue25FunctionalTest
 * Scheduled Jobs
 * @author Jeremiah
 */
class Issue35FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->issue35Sql();
        $this->Scenario1();
        $this->Scenario2();
        
    }

    /* Scenario 1 - Perform Update Status To Close Visit for Scheduled Jobs
      Expected Behavior
      Assert text "Scheduled Jobs - Close Affected rows 2 Update visit to close status successful."

      Steps:
      1. Open http://dev.identitysecurity.info/index.php?r=site/login
      2. Login as superadmin@test.com 12345 for password
      3. Open http://dev.identitysecurity.info/index.php?r=visit/RunScheduledJobsClose
      4. Assert text "Scheduled Jobs - Close Affected Rows: 2 Update visit to close status successful."
      5. Open http://dev.identitysecurity.info/index.php?r=dashboard
      6. Assert first row status is closed. Click closed link. assert visit status: closed
     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->open("http://dev.identitysecurity.info/index.php?r=visit/RunScheduledJobsClose");
        $this->assertEquals("Scheduled Jobs - Close \nAffected Rows : 2\nUpdate visit to close status successful.", $this->getText("css=body"));
        $this->open("http://dev.identitysecurity.info/index.php?r=dashboard");
        $this->clickAndWait("link=Visitor Records");
        $this->clickAndWait("link=Closed");
        $this->assertEquals("Visit Status: Closed", $this->getText("link=Visit Status: Closed"));
    }

    /* Scenario 2 - Perform Update Status To Expired for Visit for Scheduled Jobs
      Expected Behavior
      Assert text "Scheduled Jobs - Close Affected rows 2 Update visit to close status successful."

      Steps:
      1. Open http://dev.identitysecurity.info/index.php?r=site/login
      2. Login as superadmin@test.com 12345 for password
      3. Open http://dev.identitysecurity.info/index.php?r=visit/RunScheduledJobsExpired
      4. Assert text "Scheduled Jobs - Expired Affected Rows: 2 Update visit to Expired status successful."
      5. Open http://dev.identitysecurity.info/index.php?r=dashboard
      6. Assert first row status is Expired.
     */

    function Scenario2() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->open("http://dev.identitysecurity.info/index.php?r=visit/RunScheduledJobsExpired");
        $this->assertEquals("Scheduled Jobs - Expired \nAffected Rows : 2\nUpdate visit to expired status successful.", $this->getText("css=body"));
        $this->open("http://dev.identitysecurity.info/index.php?r=dashboard");
        $this->clickAndWait("link=Visitor Records");
        $this->assertEquals("Expired", $this->getText("link=Expired"));
    }

    

}

?>

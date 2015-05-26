<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException,
    Behat\Behat\Context\Step;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
	
use Behat\MinkExtension\Context\MinkContext;
	

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends MinkContext
{
    private $driver;
    private $session;

    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {

    }
    /** @BeforeScenario */
    public function before($event)
    {
        $this->printDebug("Resetting Database");
        $this->visit("/index.php");
        $this->fillField("Username or Email","superadmin@test.com");
        $this->fillField("Password","12345");
        $this->pressButton("Login");
        $this->visit("/index.php?r=resetDatabase/resetWithTestData");
        $this->visit("/index.php");

    }


    /**
    * @Then /^I login with username as "([^"]*)" and password as "([^"]*)"$/
    */
    public function iLoginWithUsernameAndPassword($username, $password)
    {
        return array(
            new Step\Given('I am on "/index.php"'),
            new Step\When('I fill in "Username or Email" with "'.$username.'"'),
            new Step\When('I fill in "Password" with "'.$password.'"'),
            new Step\When('I press "Login"'),
        );
    }

    /**
    * @Then /^I create new notification with subject as "([^"]*)" and message as "([^"]*)"$/
    */
    public function iCreateNewNotification($subject, $message)
    {
        return array(
            new Step\Given('I am on "/index.php?r=notifications/create"'),
            new Step\When('I fill in "Subject" with "'.$subject.'"'),
            new Step\When('I fill in "Message" with "'.$message.'"'),
            new Step\When('I press "Create"'),
        );
    }
    
    /**
    * @Then /^I logout$/
    */
    public function iLogout(){
        return array(
            new Step\Given('I am on "/index.php?r=user/create"'),
        );
    }

    /**
    * @Then /^I should see the new notifications alert$/
    */
    public function iSeeNewNotificationAlert()
    {
        $page = $this->getSession()->getPage();
        $element = $page->find('css', '.notification-count');
        if (null === $element) {
            throw new Exception("Couldn't found notifications!", 1);
        } else {
            $notifi_count = intval($element->getText());
            if ($notifi_count <= 0) {
                throw new Exception("There are no new notifications!", 1);
            }
        }
    }

    /**
    * @Then /^I view "([^"]*)" in details$/
    */
    public function iViewNotificationDetail($subject)
    {
        $page = $this->getSession()->getPage();
        $element = $page->find('xpath', '//td[text()="'.$subject.'"]');
        if (null === $element) {
            throw new Exception("Couldn't found notifications!", 1);
        } else {
            $tr = $element->getParent();
            $view = $tr->find('css', '.view');
            #$this->printDebug($view->getText());
            $view->click();
        }
    }

    /**
    * @Then /^I edit notification "([^"]*)" with subject "([^"]*)" as and message as "([^"]*)"$/
    */
    public function iEditNotificationWithSubject($subject, $newsubject, $newmessage)
    {
        $page = $this->getSession()->getPage();
        $element = $page->find('xpath', '//td[text()="'.$subject.'"]');
        if (null === $element) {
            throw new Exception("Couldn't found notifications!", 1);
        } else {
            $tr = $element->getParent();
            $update = $tr->find('css', '.update');
            $update->click();

            $this->fillField("Subject", $newsubject);
            $this->fillField("Message", $newmessage);
            $this->pressButton("Save");
        }
    }

    /**
    * @Then /^I delete notification "([^"]*)"$/
    * This is not working, delete function need JS to run
    */
    public function iDeleteNotification($subject)
    {
        $page = $this->getSession()->getPage();
        $element = $page->find('xpath', '//td[text()="'.$subject.'"]');
        if (null === $element) {
            throw new Exception("Couldn't found notifications!", 1);
        } else {
            $tr = $element->getParent();
            $delete = $tr->find('css', '.delete');
            $delete->click();
        }
    }
}

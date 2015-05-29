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
        $this->useContext('notification', new SubContext\NotificationContext($parameters));
        $this->useContext('vicprofile', new SubContext\VicprofileContext($parameters));
        $this->useContext('workstation', new SubContext\WorkstationContext($parameters));
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
    * @Then /^I logout$/
    */
    public function iLogout(){
        return array(
            new Step\Given('I am on "/index.php?r=user/create"'),
        );
    }


     /**
    * @When /^I wait for "([^"]*)" to appear$/
    * @Then /^I should see "([^"]*)" appear$/
    * @param $text
    * @throws \Exception
    */
    public function iWaitForTextToAppear($text)
    {
        $this->spin(function(FeatureContext $context) use ($text) {
            try {
                $context->assertPageContainsText($text);
                return true;
            }
            catch(ResponseTextException $e) {
                // NOOP
            }
            return false;
        });
    }


    public function spin ($lambda, $wait = 60)
    {
        for ($i = 0; $i < $wait; $i++)
        {
            try {
                if ($lambda($this)) {
                    return true;
                }
            } catch (Exception $e) {
                // do nothing
            }

            sleep(1);
        }

        $backtrace = debug_backtrace();

        throw new Exception(
            "Timeout thrown by " . $backtrace[1]['class'] . "::" . $backtrace[1]['function'] . "()\n" .
            $backtrace[1]['file'] . ", line " . $backtrace[1]['line']
        );
    }
}

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
        //$this->printDebug("Resetting Database");
        //$this->iLoginWithUsernameAndPassword("superadmin@test.com","123456");
        //$this->visit("/index.php?r=resetDatabase/resetWithTestData");
        //$this->visit("/index.php");
    }
    /** @AfterScenario */
    public function after($event){
        //$this->iWaitForSeconds(5);
    }

    /**
     * @Then /^I login with username as "([^"]*)" and password as "([^"]*)"$/
     */
    public function iLoginWithUsernameAndPassword($username, $password)
    {
        $this->getSession()->reset();
        return array(
            new Step\Given('I am on "/index.php"'),
            new Step\Then('show me a screenshot'),
            new Step\When('I fill in "Username or Email" with "'.$username.'"'),
            new Step\When('I fill in "Password" with "'.$password.'"'),
            new Step\When('I select "Kalgoorlie-Boulder Airport" from "LoginForm[tenant]"'),
            new Step\When('I press "Login"'),
            new Step\Then('I should see "Dashboard" appear'),
        );
    }

    /**
     * @Then /^I logout$/
     */
    public function iLogout(){
        return array(
            new Step\Given('I am on "/index.php?r=site/logout"'),
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

    /**
     * @When /^I check the "([^"]*)" radio button$/
     */
    public function iCheckTheRadioButton($labelText) {
        $page = $this->getSession()->getPage();
        foreach ($page->findAll('css', 'label') as $label) {
            if ( $labelText === $label->getText() ) {
                $radioButton = $page->find('css', '#'.$label->getAttribute('for'));
                $radioButton->click();
                return;
            }
        }
        throw new \Exception("Radio button with label {$labelText} not found");
    }

    /**
     * @When /^I check the "([^"]*)" radio button in "([^"]*)" button group$/
     */
    public function iCheckButtonInGroup($labelText, $groupSelector){
        $page = $this->getSession()->getPage();
        $group = $page->find('css',$groupSelector);
        foreach ($group->findAll('css', 'label') as $label) {
            if ( $labelText === $label->getText() ) {
                $radioButton = $page->find('css', '#'.$label->getAttribute('for'));
                $radioButton->click();
                return;
            }
        }
        throw new \Exception("Radio button with label {$labelText} not found in group {$groupSelector}");
    }

    /**
     * @When /^I select "([^"]*)" for radio button "([^"]*)"$/
     */
    public function iCheckValueInRadioButton($value, $radioButton){
        $page = $this->getSession()->getPage();
        $radioButtons = $page->find('css', 'input[name="'.$radioButton.'"]');
        $radioButton = $radioButtons->find('css', 'input[value="'.$value.'"]');
        if (null === $radioButton) {
            throw new \Exception("Radio button ".$radioButton." with value ".$value." is not found.");
        } else {
            $radioButton->check();
        }
    }

    /**
     * @Then /^I edit "([^"]*)"$/
     */
    public function iEditItem($subject)
    {
        $page = $this->getMainContext()->getSession()->getPage();
        $element = $page->find('xpath', '//td[text()="'.$subject.'"]');
        if (null === $element) {
            throw new \Exception("Couldn't found ".$subject." edit button!", 1);
        } else {
            $tr = $element->getParent();
            $update = $tr->find('css', '.update');
            $update->click();
        }
    }

    /**
     * @Then /^I delete "([^"]*)"$/
     */
    public function iDeleteItem($subject)
    {
        $page = $this->getMainContext()->getSession()->getPage();
        $element = $page->find('xpath', '//td[text()="'.$subject.'"]');
        if (null === $element) {
            throw new \Exception("Couldn't found ".$subject." delete button!", 1);
        } else {
            $tr = $element->getParent();
            $delete = $tr->find('css', '.delete');
            $delete->click();
            #$url = $delete->getAttribute('href');
            #$postdata = "";
            #$this->getSession()->getDriver()->getClient()->request('POST', $url, $postdata);
        }
    }

    /**
     * This works for Selenium and other real browsers that support screenshots.
     *
     * @Then /^show me a screenshot$/
     */
    public function show_me_a_screenshot() {
        $image_data = $this->getSession()->getDriver()->getScreenshot();
        $file_and_path = '/tmp/behat_screenshot.jpg';
        file_put_contents($file_and_path, $image_data);
        $html = $this->getSession()->getDriver()->getContent();
        file_put_contents('/tmp/behat_page.html', $html);
    }

    /**
     * @Given /^I wait for (\d+) seconds$/
     */
    public function iWaitForSeconds($arg1)
    {
        $this->getSession()->wait($arg1*1000);
    }


}

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

    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        $this->useContext('yii', new SubContext\YiiContext($parameters));
        $this->useContext('tenant', new SubContext\TenantContext($parameters));
        $this->useContext('login', new SubContext\LoginContext($parameters));
        $this->useContext('notification', new SubContext\NotificationContext($parameters));
        $this->useContext('vicprofile', new SubContext\VicprofileContext($parameters));
        $this->useContext('workstation', new SubContext\WorkstationContext($parameters));
        $this->useContext('dataIntegrity', new SubContext\DataIntegrityContext($parameters));

    }

    /** @BeforeScenario */
    public function before($event)
    {
        $this->getSession()->resizeWindow(1440, 900, 'current');
    }

    /** @AfterScenario */
    public function after($event){

        if ($event->getResult() == 4) {
            if ($this->getSession()->getDriver() instanceof \Behat\Mink\Driver\Selenium2Driver) {
                $screenshot = $this->getSession()->getDriver()->getScreenshot();
                file_put_contents('/tmp/screenshot.png', $screenshot);
            }
        }

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


    public function spin ($lambda, $wait = 15)
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
            "Timeout thrown by " . $backtrace[1]['class'] . "::" . $backtrace[1]['function'] . "()\n"
            //.$backtrace[1]['file'] . ", line " . $backtrace[1]['line']
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
     * @Then /^I select option number "([^"]*)" from select "([^"]*)"$/
     */
    public function iSelectOptionNumberFromSelect($number,$select){

        $field = $this->getSession()->getPage()->findField($select);
        $optionElements = $field->findAll('css','option');

        $i = 0;
        foreach ($optionElements as $optionElement) {
            $i++;
            if($i==intval($number)){
                $field->selectOption($optionElement->getValue());
                return;
            }
        }
    }

    /**
     * @Then /^I select  "([^"]*)" from  "([^"]*)"$/
     */
    public function iSelectValueFromSelect($value,$select){

        $field = $this->getSession()->getPage()->findField($select);
        $optionElements = $field->findAll('css','option');

        foreach ($optionElements as $optionElement) {
            if($optionElement->getValue() == $value || $optionElement->getText() == $value){
                $field->selectOption($optionElement->getValue());
                return;
            }
        }
    }


    /**
     * @Then /^I fill in date "([^"]*)" with "([^"]*)"$/
     */
    public function iFillDateCombos($name,$date){
        $parts = explode('-',$date);
        $this->iSelectValueFromSelect($parts[0],$name."_day");
        $this->iSelectValueFromSelect($parts[1],$name."_month");
        $this->iSelectValueFromSelect($parts[2],$name."_year");

    }

    /**
     * @Then /^I press the enter key$/
     */
    public function iPressTheEnterKey(){

        $this->getSession()->executeScript("
            $(':focus').trigger($.Event('keypress', {which: 9, keyCode: 9}));
        ");

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
     * @Then /^I wait for (\d+) seconds$/
     */
    public function iWaitForSeconds($arg1)
    {
        $this->getSession()->wait($arg1*1000);
    }

    /**
     * @Given /^I reset this session$/
     */
    public function iResetThisSession()
    {
        $this->getSession()->reset();
    }




}

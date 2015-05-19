<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException,
    Behat\Behat\Context\Step;

use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Behat\MinkExtension\Context\MinkContext;

/**
 * Features context.
 */
class FeatureContext extends MinkContext
{
    /**
    * @Given /^I am logged in as "([^"]*)" with password "([^"]*)"$/
    */
    public function iAmLoggedInAsWithPassword($username, $password)
    {
        return array(
            new Step\Given('I am on "/index.php"'),
            new Step\When('I fill in "Username or Email" with "'.$username.'"'),
            new Step\When('I fill in "Password" with "'.$password.'"'),
            new Step\When('I press "Login"'),
        );
    }

}
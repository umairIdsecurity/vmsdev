<?php
namespace SubContext;
use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException,
    Behat\Behat\Context\Step;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;


/**
 * Notification context.
 */
class WorkstationContext extends BehatContext
{
    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
    }

    /**
    * @Then /^I go to workstation "([^"]*)" edit page$/
    */
    public function iEditWorkstation($subject)
    {
        $page = $this->getMainContext()->getSession()->getPage();
        $element = $page->find('xpath', '//td[text()="'.$subject.'"]');
        if (null === $element) {
            throw new Exception("Couldn't found workstation ".$subject." edit page!", 1);
        } else {
            $tr = $element->getParent();
            $update = $tr->find('css', '.update');
            $update->click();
        }
    }

    /**
    * @Then /^I delete workstation "([^"]*)"$/
    */
    public function iDeleteWorkstation($subject)
    {
        $page = $this->getMainContext()->getSession()->getPage();
        $element = $page->find('xpath', '//td[text()="'.$subject.'"]');
        if (null === $element) {
            throw new Exception("Couldn't found notifications!", 1);
        } else {
            $tr = $element->getParent();
            $delete = $tr->find('css', '.delete');
            $delete->click();
        }
    }

    /**
     * @when /^(?:|I )confirm the popup$/
     */
    public function confirmPopup()
    {
        $this->getMainContext()->getSession()->getDriver()->getWebDriverSession()->accept_alert();
    }
}

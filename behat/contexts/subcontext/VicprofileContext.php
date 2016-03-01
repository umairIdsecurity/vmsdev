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
class VicprofileContext extends BehatContext
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
    * @Then /^I should see "([^"]*)" in "([^"]*)"$/
    */
    public function iSeeValueIn($value, $id)
    {
        $page = $this->getMainContext()->getSession()->getPage();
        $element = $page->find('css', "#".$id." option[selected='selected']");
        if (null === $element) {
            throw new Exception("Couldn't found notifications!", 1);
        } else {
            return $value == ($element->getText());
        }
    }
}

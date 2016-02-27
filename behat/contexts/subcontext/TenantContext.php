<?php
namespace SubContext;

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException,
    Behat\Behat\Context\Step;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Behat\MinkExtension\Context\MinkContext;
use Yii,
    TenantManager;





//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class TenantContext extends BehatContext
{
    private $createdTenants = [];
    private $currentTenant = null;


    public function getCurrentTenant(){
        return $this->currentTenant;
    }


    /**
     * @Then /^I create a tenant$/
     */
    public function iCreateAnAvmsTenant(){

        $manager = new TenantManager();
        $info = $manager->createTestTenantFromJsonFile("test/specs/data/Test Tenant.tenant");
        $this->createdTenants[] = $info;
        $this->currentTenant = $info;
    }

    /**
     * @Then /^I delete the current tenant$/
     */
    public function iDeleteTheCurrentTenant(){
        if($this->currentTenant!=null){
            $this->iDeleteTenant($this->currentTenant['name']);
            $this->currentTenant = null;
        }
    }

    /**
     * @Then /^I reset tenant "([^"]*)"$/
     */
    public function iResetTenant($tenantName){
        $this->iDeleteTenant($tenantName);
        $this->iImportTenant($tenantName);
    }

    /**
     * @Then /^I import tenant "([^"]*)"$/
     */
    public function iImportTenant($tenantName){
        $tenantFile = "test/specs/data/$tenantName.tenant";
        $manager = new TenantManager();
        $manager->importTenantFromJsonFile($tenantFile);
        $this->currentTenant = $manager->getInfo($tenantName);
        $this->createdTenants = $this->currentTenant;
    }

    /**
     * @Then /^I delete tenant "([^"]*)"$/
     */
    public function iDeleteTenant($tenantName){
        $manager = new TenantManager();
        $manager->deleteWithName($tenantName);
        if($this->currentTenant!=null && $this->currentTenant['name']==$tenantName){
            $currentTenant = null;
        }
    }

    /**
     * @Then /^I delete created tenants$/
     */
    public function iDeleteCreatedTenants(){
        $manager = new TenantManager();
        foreach($this->createdTenants as $tenant) {
            $manager->deleteWithId($tenant['id']);
        }
        $this->createdTenants = [];
        $this->currentTenant = null;
    }

}

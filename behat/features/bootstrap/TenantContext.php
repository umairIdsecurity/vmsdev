<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use Yii,
    TenantManager;

/**
 * Defines application features from the specific context.
 */
class TenantContext implements Context, SnippetAcceptingContext
{


    private $createdTenants = [];
    private $currentTenant = null;



    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /** @BeforeScenario */
    public function before()
    {
        //$this->getSession()->resizeWindow(1440, 900, 'current');
    }


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

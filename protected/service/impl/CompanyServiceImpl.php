<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CompanyServiceImpl
 *
 * @author Jeremiah
 */
class CompanyServiceImpl implements CompanyService {

    public function save($company, $sessionTenant, $sessionRole, $currentAction) {
        if($company->tenant_agent == ''){
            $company->tenant_agent = NULL;
        }
        if (!($company->save())) {
            return false;
        }
        
        /* if logged in is admin
         * set company tenant to tenant of admin
         */
        if ($currentAction == 'create') {
            $this->assignCompanyTenantIfCurrentlyLoggedUserIsAdmin($company, $sessionTenant, $sessionRole);
        }
        return true;
    }

    private function assignCompanyTenantIfCurrentlyLoggedUserIsAdmin($company, $sessionTenant, $sessionRole) {
        if ($company->tenant == '') {
            if ($sessionRole == Roles::ROLE_ADMIN) {
                Company::model()->updateByPk($company->id, array('tenant' => $sessionTenant));
            }
        }
    }

}

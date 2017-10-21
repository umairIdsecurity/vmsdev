
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VisitorServiceImpl
 *
 * @author Jeremiah
 */
class CompanyLafPreferencesServiceImpl implements CompanyLafPreferencesService {

    public function save($companyLafPreferences, $company) {
        if($companyLafPreferences->logo == ''){
            $companyLafPreferences->logo = NULL;
        }
        
        if (!($companyLafPreferences->save())) {
            return false;
        }
        
        Company::model()->updateByPk($company->id, array(
                'company_laf_preferences' => $companyLafPreferences->id, 
                'logo' => $companyLafPreferences->logo,
            ));
        return true;
    }

}


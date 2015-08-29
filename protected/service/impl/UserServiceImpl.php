<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserServiceImpl
 *
 * @author Jeremiah
 */
class UserServiceImpl implements UserService {

    public function save($user, $userLoggedIn, $workstation) {
        $user->date_of_birth = date('Y-m-d', strtotime($user->birthdayYear.'-'.$user->birthdayMonth.'-'.$user->birthdayDay));

        $user->asic_expiry = date('Y-m-d', strtotime($user->asic_expiry_year.'-'.$user->asic_expiry_month.'-'.$user->asic_expiry_day));

        //$user->asic_expiry = strtotime($user->asic_expiry_year.'-'.$user->asic_expiry_month.'-'.$user->asic_expiry_day);

		if($user['password']==''){
			$user->password	=	(NULL);
		}

        if ($user->isNewRecord) {
            $user->created_by = $userLoggedIn->id;
        }

        // just make sure that the record is being updated honestly
        // if not superadmin then use must be in the same tenant as the logged in user
        if($userLoggedIn->role!=Roles::ROLE_SUPERADMIN){

            $user->tenant = $userLoggedIn->tenant;

            // if not a administrator then must be within the same tenant agent
            if(!in_array($userLoggedIn->role, array(Roles::ROLE_ADMIN, Roles::ROLE_ISSUING_BODY_ADMIN))){
                $user->tenant_agent = $userLoggedIn->tenant_agent;
            }
        }

        // set the company for the user
        if($user->tenant_agent) {
            $user->company = $user->tenant_agent;
        } else {
            $user->company = $user->tenant;
        }


        if (!($user->save())) {
            return false;
        }else{
			if ($user->password_option==2)
			User::model()->restorePassword($user['email']);

            if ($workstation){
                    User::model()->saveWorkstation($user->id, $workstation,$userLoggedIn->id);
            }
			
		}


        if ($user->role == Roles::ROLE_OPERATOR || $user->role == Roles::ROLE_AGENT_OPERATOR) {
            User::model()->saveWorkstation($user->id, $workstation, $userLoggedIn->id);
        }
        return true;
    }

    private function assignTenantOfUserAndCompanyForRoleAdmin($user, $company_tenant) {
        if ($user->tenant == '') {
            if ($company_tenant == '') {
                Company::model()->updateByPk($user->company, array('tenant' => $user->id));
                User::model()->updateByPk($user->id, array('tenant' => $user->id));
            } else {
                User::model()->updateByPk($user->id, array('tenant' => $company_tenant));
            }
        }
    }

    private function assignTenantAndTenantAgentOfUserAndCompanyForRoleAgentAdmin($user, $company_tenant, $company_tenant_agent) {
        if ($user->tenant_agent == '') {
            if ($company_tenant_agent == '') {
                Company::model()->updateByPk($user->company, array('tenant_agent' => $user->id));
                User::model()->updateByPk($user->id, array('tenant_agent' => $user->id));
            } else {
                User::model()->updateByPk($user->id, array('tenant_agent' => $company_tenant_agent));
            }

            if ($company_tenant == '') {
                Company::model()->updateByPk($user->company, array('tenant' => $user->tenant));
            }
        }
    }

    private function assignSessionTenantAndTenantAgentOfUserAndCompanyForRoleAgentAdmin($user, $company_tenant, $company_tenant_agent, $userLoggedIn) {
        if ($user->tenant == '') {
            if ($company_tenant_agent == '') {
                Company::model()->updateByPk($user->company, array('tenant_agent' => $user->id));
                User::model()->updateByPk($user->id, array('tenant_agent' => $user->id));
            } else {
                User::model()->updateByPk($user->id, array('tenant_agent' => $company_tenant_agent));
            }

            if ($company_tenant == '') {

                Company::model()->updateByPk($user->company, array('tenant' => $userLoggedIn->tenant));
                User::model()->updateByPk($user->id, array('tenant' => $userLoggedIn->tenant));
            } else {
                User::model()->updateByPk($user->id, array('tenant' => $company_tenant));
            }
        }
    }

    private function removeTenantAgentofUserIfTenantIsSetForRoleStaffMember($user) {
        if ($user->tenant_agent != '') {
            User::model()->updateByPk($user->id, array('tenant' => $user->tenant));
        } 
    }

    private function updateTenantForRoleAdmin($user, $company_tenant) {

        if ($company_tenant == '') {
            Company::model()->updateByPk($user->company, array('tenant' => $user->id));
            User::model()->updateByPk($user->id, array('tenant' => $user->id));
        } else {
            User::model()->updateByPk($user->id, array('tenant' => $company_tenant));
        }
    }

    public function assignSessionTenantAgentForRoleStaffMember($user, $userLoggedIn) {
        if ($user->role == Roles::ROLE_STAFFMEMBER) {
            User::model()->updateByPk($user->id, array(
                'tenant_agent' => $userLoggedIn->tenant_agent,
                'tenant' => $userLoggedIn->tenant
            ));
        }
    }

//put your code here
}

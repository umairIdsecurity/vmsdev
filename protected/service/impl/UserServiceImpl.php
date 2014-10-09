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

    public function save($user, $sessionTenant, $sessionTenantAgent, $sessionRole, $sessionId, $workstation) {
        $user->date_of_birth = date('Y-m-d', strtotime($user->birthdayYear . '-' . $user->birthdayMonth . '-' . $user->birthdayDay));
        
        if ($user->isNewRecord) {
            $user->created_by = $sessionId;
        } else {
            if (Yii::app()->user->role == Roles::ROLE_SUPERADMIN) {

                $userdetails = User::model()->findByPK($user->id);
                $company = Company::model()->findByPK($userdetails->company);
                if ($userdetails->role == Roles::ROLE_ADMIN) {
                    if ($userdetails->id == $company->tenant) {
                        Company::model()->updateByPk($userdetails->company, array('tenant' => NULL));
                    }
                }
            }
        }

        if (!($user->save())) {
            return false;
        }

        /** set tenant id if superadmin and user created is admin.. tenant id = admin_id 
         * set tenant_agent if superadmin and user created is agentadmin.. tenant id = admin_id ,tenant_agent
         * if not superadmin inherit tenant id from currently logged in user
         * if superadmin and user created != admin .. tenant id = choose admin_id
         * if agent admin logged in , all created 
         * * */
        $company = Company::model()->findByPK($user->company);
        if (Yii::app()->controller->action->id == 'create') {
            switch ($sessionRole) {
                case Roles::ROLE_SUPERADMIN:

                    if ($user->role == Roles::ROLE_ADMIN) {
                        $this->assignTenantOfUserAndCompanyForRoleAdmin($user, $company->tenant);
                    } else if ($user->role == Roles::ROLE_AGENT_ADMIN) {
                        $this->assignTenantAndTenantAgentOfUserAndCompanyForRoleAgentAdmin($user, $company->tenant, $company->tenant_agent);
                    } elseif ($user->role == Roles::ROLE_STAFFMEMBER) {
                        $this->removeTenantAgentofUserIfTenantIsSetForRoleStaffMember($user);
                    }

                    break;

                default:
                    if ($user->role == Roles::ROLE_ADMIN) {
                        $this->assignTenantOfUserAndCompanyForRoleAdmin($user, $company->tenant);
                    } else if ($user->role == Roles::ROLE_AGENT_ADMIN) {
                        $this->assignSessionTenantAndTenantAgentOfUserAndCompanyForRoleAgentAdmin($user, $company->tenant, $company->tenant_agent, $sessionTenant);
                    } else if ($user->role == Roles::ROLE_AGENT_OPERATOR) {
                        /* if user role is agent operator, set tenant agent = tenant agent of current logged user */
                        User::model()->updateByPk($user->id, array('tenant_agent' => $sessionTenantAgent, 'tenant' => $sessionTenant));
                    } else if ($sessionRole == Roles::ROLE_AGENT_ADMIN) {
                        $this->assignSessionTenantAgentForRoleStaffMember($user, $sessionTenantAgent);
                    } else {
                        User::model()->updateByPk($user->id, array('tenant' => $sessionTenant));
                    }
            }
        } else { //else if update
            if ($user->role == Roles::ROLE_ADMIN) {
                $this->updateTenantForRoleAdmin($user, $company->tenant);
            }
        }

        if ($user->role == Roles::ROLE_OPERATOR || $user->role == Roles::ROLE_AGENT_OPERATOR) {
            User::model()->saveWorkstation($user->id, $workstation, $sessionId);
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

    private function assignSessionTenantAndTenantAgentOfUserAndCompanyForRoleAgentAdmin($user, $company_tenant, $company_tenant_agent, $sessionTenant) {
        if ($user->tenant == '') {
            if ($company_tenant_agent == '') {
                Company::model()->updateByPk($user->company, array('tenant_agent' => $user->id));
                User::model()->updateByPk($user->id, array('tenant_agent' => $user->id));
            } else {
                User::model()->updateByPk($user->id, array('tenant_agent' => $company_tenant_agent));
            }

            if ($company_tenant == '') {

                Company::model()->updateByPk($user->company, array('tenant' => $sessionTenant));
                User::model()->updateByPk($user->id, array('tenant' => $sessionTenant));
            } else {
                User::model()->updateByPk($user->id, array('tenant' => $company_tenant));
            }
        }
    }

    private function removeTenantAgentofUserIfTenantIsSetForRoleStaffMember($user) {
        if ($user->tenant_agent != '') {
            User::model()->updateByPk($user->id, array('tenant' => ''));
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

    public function assignSessionTenantAgentForRoleStaffMember($user, $sessionTenantAgent) {
        if ($user->role == Roles::ROLE_STAFFMEMBER) {
            User::model()->updateByPk($user->id, array(
                'tenant_agent' => $sessionTenantAgent
            ));
        }
    }

//put your code here
}

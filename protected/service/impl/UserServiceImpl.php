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
        //$user->date_of_birth = date('Y-m-d', strtotime($user->birthdayYear.'-'.$user->birthdayMonth.'-'.$user->birthdayDay));

        //$user->asic_expiry = date('Y-m-d', strtotime($user->asic_expiry_year.'-'.$user->asic_expiry_month.'-'.$user->asic_expiry_day));

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


        if (!($user->save())) 
        {
            return false;
        }
        else
        {
            /*if ($user->password_option==2)
                User::model()->restorePassword($user['email']);*/
            #Send mail
            if ($user->password_option == PasswordRequirement::PASSWORD_IS_REQUIRED) 
            {
                $workstationObj = Workstation::model()->findByPk($workstation);
                $loggedUserEmail = "admin@identitysecurity.com.au";
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= "From: ".$loggedUserEmail."\r\nReply-To: ".$loggedUserEmail;
                $to=$user['email'];
                $subject = "Invitation to Aviation Visitor Management System";
                $body = "<html><body>Hi,<br><br>".
                        $workstationObj->name." has requested a user account to be created for ".$user['email']."<br><br>".
                        "Please click the following link to create your password:<br>".
                        "http://vmsdev.identitysecurity.com.au/index.php?r=site/forgot<br>";
                $body .="<br>"."Thanks,"."<br>Admin</body></html>";
                EmailTransport::mail($to, $subject, $body, $headers);
            }

            //because of https://ids-jira.atlassian.net/browse/CAVMS-1204
            if($user->role == Roles::ROLE_AIRPORT_OPERATOR)
            {
                if(Yii::app()->user->role == Roles::ROLE_SUPERADMIN)
                {
                    $userTenant = $user->tenant;
                    $worksta = Workstation::model()->find('tenant=:tenant', array(':tenant'=>$userTenant));
                    if($worksta)
                        User::model()->saveWorkstation($user->id, $worksta['id'], $userLoggedIn->id);
                }
                else
                {
                    $session = new CHttpSession;
                    User::model()->saveWorkstation($user->id, $session['workstation'], $userLoggedIn->id);
                }
            }
            else if($user->role == Roles::ROLE_AGENT_AIRPORT_OPERATOR || $user->role == Roles::ROLE_AGENT_AIRPORT_ADMIN)
            {
                $userTenantAgent = $user->tenant_agent;
                $worksta = Workstation::model()->find('tenant_agent=:tenant_agent and tenant=:tenant', array(':tenant_agent'=>$userTenantAgent,':tenant'=>Yii::app()->user->tenant));
                if($worksta)
                    User::model()->saveWorkstation($user->id, $worksta->id, $userLoggedIn->id);
            }
            else if(is_object($workstation)) 
            {
                User::model()->saveWorkstation($user->id, $workstation->id, $userLoggedIn->id);
            }
            else{}
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

<?php

class CompaniesController extends RestfulController {

    /**
     * Admin
     * Get Admin & Admin Logout
     * by rohan m.
     * * */
    public function actionIndex() {
        try {
            $token_user = $this->checkAuth();
            if (Yii::app()->request->getParam('id')) {
                $id = Yii::app()->request->getParam('id');
                $company = Company::model()->findByPK($id);
                if ($company) {
                    $result = array();
                    $image = photo::model()->returnCompanyPhotoRelativePath($company->id);
                    if ($image != NULL) {
                        $url = Yii::app()->request->hostInfo . yii::app()->baseUrl . '/' . $image;
                    } else {
                        $url = "N/A";
                    }
                    $result['id'] = $company->id;
                    $result['code'] = $company->code;
                    $result['name'] = $company->name;
                    $result['trading_name'] = $company->trading_name;
                    $result['logo'] = $url;
                    $result['contact'] = $company->contact;
                    $result['billing_address'] = $company->billing_address;
                    $result['email_address'] = $company->email_address;
                    $result['office_number'] = $company->office_number;
                    $result['mobile_number'] = $company->mobile_number;

                    $this->sendResponse(200, CJSON::encode($result));
                } else {
                    $this->sendResponse(404, CJSON::encode(array('responseCode' => 404, 'errorCode' => 'ADMIN_DOES_NOT_EXIST', 'errorDescription' => 'Requsted Admin not found')));
                }
            } else {
                $companies = Company::model()->findAll();
                if ($companies) {
                    $result = array();
                    $i = 0;
                    foreach ($companies as $company) {

                        $result[$i]['id'] = $company->id;
                        $result[$i]['code'] = $company->code;
                        $result[$i]['name'] = $company->name;
                        $result[$i]['trading_name'] = $company->trading_name;
                        $result[$i]['logo'] = ($company->logo) ? Yii::app()->request->hostInfo . yii::app()->baseUrl . '/' . $company->ph->relative_path : "N/A";
                        $result[$i]['contact'] = $company->contact;
                        $result[$i]['billing_address'] = $company->billing_address;
                        $result[$i]['email_address'] = $company->email_address;
                        $result[$i]['office_number'] = $company->office_number;
                        $result[$i]['mobile_number'] = $company->mobile_number;
                        $i++;
                    }
                    $this->sendResponse(200, CJSON::encode($result));
                }
            }
        } catch (Exception $ex) {
            $this->sendResponse(500, CJSON::encode(array('responseCode' => 500, 'errorCode' => 'INTERNAL_SERVER_ERROR', 'errorDescription' => 'something went')));
        }
    }

    public function actionLogout() {
        try {
            $token_user = $this->checkAuth();
            if (Yii::app()->request->getParam('email')) {
                $email = Yii::app()->request->getParam('email');
                $admin = User::model()->with('com')->findByAttributes(array('email' => $email));
                if ($admin) {
                    $access_token = AccessTokens::model()->findByAttributes(array('USER_ID' => $admin->id));
                    if ($access_token->delete()) {
                        $this->sendResponse(204);
                    }
                } else {
                    $this->sendResponse(404, CJSON::encode(array('responseCode' => 404, 'errorCode' => 'ADMIN_NOT_FOUND', 'errorDescription' => 'Requsted Admin not found')));
                }
            } else {
                $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'INVALID_PARAMETER', 'errorDescription' => 'GET parameter required for action')));
            }
        } catch (Exception $ex) {
            $this->sendResponse(500, CJSON::encode(array('responseCode' => 500, 'errorCode' => 'INTERNAL_SERVER_ERROR', 'errorDescription' => 'something went')));
        }
    }

}

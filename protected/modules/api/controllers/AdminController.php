<?php

class AdminController extends RestfulController {

    /**
     * Admin
     * Get Admin & Admin Logout
     * by rohan m.
     * * */
    public function actionIndex() {
        try {
            $token_user = $this->checkAuth();
            if (Yii::app()->request->getParam('email')) {
                $email = Yii::app()->request->getParam('email');
                $admin = User::model()->with('com')->findByAttributes(array('email' => $email));
                if ($admin) {
                    $result = array();
                    $result['firstName'] = $admin->first_name;
                    $result['lastName'] = $admin->last_name;
                    $result['email'] = $admin->email;
                    $result['companyName'] = ($admin->com->name) ? $admin->com->name : "N/A";
                    $result['companyLogoURL'] = ($admin->com->ph) ? Yii::app()->request->hostInfo . yii::app()->baseUrl . '/' . $admin->com->ph->relative_path : "N/A";
                    $result['companyTagLine'] = ($admin->com->trading_name) ? $admin->com->trading_name : "N/A";
                    $result['VICPickupLoctaion'] = "N/A";
                    $result['visitorLogin'] = false;
                    $result['photoRequired'] = true;
                    $this->sendResponse(200, CJSON::encode($result));
                } else {
                    $this->sendResponse(404, CJSON::encode(array('responseCode' => 404, 'errorCode' => 'ADMIN_DOES_NOT_EXIST', 'errorDescription' => 'Requested Admin not found')));
                }
            } else {
                $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'INVALID_PARAMETER', 'errorDescription' => 'GET parameter required for action')));
            }
        } catch (Exception $ex) {
            $this->sendResponse(500, CJSON::encode(array('responseCode' => 500, 'errorCode' => 'INTERNAL_SERVER_ERROR', 'errorDescription' => 'Something went wrong')));
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
                    if ($access_token) {
                        $access_token->delete();
                        $this->sendResponse(204);
                    }
                } else {
                    $this->sendResponse(404, CJSON::encode(array('responseCode' => 404, 'errorCode' => 'ADMIN_NOT_FOUND', 'errorDescription' => 'Requested Admin not found')));
                }
            } else {
                $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'INVALID_PARAMETER', 'errorDescription' => 'GET parameter required for action')));
            }
        } catch (Exception $ex) {
            $this->sendResponse(500, CJSON::encode(array('responseCode' => 500, 'errorCode' => 'INTERNAL_SERVER_ERROR', 'errorDescription' => 'something went wrong')));
        }
    }

}

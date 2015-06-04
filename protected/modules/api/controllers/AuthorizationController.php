<?php

class AuthorizationController extends RestfulController {

    /**
     * Authorisation
     * Create Token & Refresh with expiry 
     * by rohan m.
     * * */
    public function actionAdmin() {
        try {
            $result = array();
            if (Yii::app()->request->isPostRequest) {
                $data = file_get_contents("php://input");
                $data = CJSON::decode($data);
                if ($data['grant_type'] === 'password') {
                    if ($data['password'] !== null && $data['email'] !== null) {
                        $user = User::model()->findByAttributes(array('email' => $data['email']));
                        if ($user) {
                            if (CPasswordHelper::verifyPassword($data['password'], $user->password)) {
                                $access_token = AccessTokens::model()->findByAttributes(array('USER_ID' => $user->id));
                                if ($access_token) {
                                    $newtimestamp = strtotime(date('Y-m-d H:i:s') . ' + 15 minute');
                                    $access_token->ACCESS_TOKEN = $this->generateToken(20);
                                    $access_token->EXPIRY = NULL;
                                    $access_token->MODIFIED = date('Y-m-d H:i:s');
                                    $access_token->save(false);
                                    $result['access_token'] = $access_token->ACCESS_TOKEN;
                                } else {
                                    $newtimestamp = strtotime(date('Y-m-d H:i:s') . ' + 15 minute');
                                    $newAccessToken = new AccessTokens();
                                    $newAccessToken->USER_ID = $user->id;
                                    $newAccessToken->ACCESS_TOKEN = $this->generateToken(20);
                                    $newAccessToken->EXPIRY = NULL;
                                    $newAccessToken->CREATED = date('Y-m-d H:i:s');
                                    $newAccessToken->save(false);
                                    $result['access_token'] = $newAccessToken->ACCESS_TOKEN;
                                }
                                $this->sendResponse(200, CJSON::encode($result));
                            } else {
                                $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'INVALID_LOGIN', 'errorDescription' => 'Password is Invalid.')));
                            }
                        } else {
                            $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'INVALID_LOGIN', 'errorDescription' => 'Requseted user is not exist.')));
                        }
                    }
                } elseif ($data['grant_type'] === 'refresh_token') {
                    $access_token = AccessTokens::model()->findByAttributes(array('ACCESS_TOKEN' => $data['access_token']));
                    if ($access_token) {
                        $newtimestamp = strtotime(date('Y-m-d H:i:s') . ' + 15 minute');
                        $access_token->EXPIRY = NULL;
                        $access_token->save(false);
                        $result['access_token'] = $access_token->ACCESS_TOKEN;
                        $this->sendResponse(200, CJSON::encode($result));
                    } else {
                        $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'INVALID_TOKEN', 'errorDescription' => 'Requseted Token for refresh is invalid.')));
                    }
                }
            } else {
                $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'INVALID_REQUSET', 'errorDescription' => 'Requset must be POST')));
            }
        } catch (Exception $ex) {
             $this->sendResponse(500, CJSON::encode(array('responseCode' => 500, 'errorCode' => 'INTERNAL_SERVER_ERROR', 'errorDescription' => 'something went wrong')));
        }
    }

    public function generateToken($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
    
    public function actionPreflight() {
        $content_type = 'application/json';
        $status = 204;
 
        // set the status
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->getStatusCodeMessage($status);
        header($status_header);
 
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header("Access-Control-Allow-Headers: Authorization");
        header('Content-type: ' . $content_type);
    }
}

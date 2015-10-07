<?php

/**
 * Created by PhpStorm.
 * User: geoffstewart
 * Date: 3/10/15
 * Time: 6:04 PM
 */
class TenantTransferController extends Controller
{
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow user if same company
                'actions' => array('export','import'),
                'expression' => 'Yii::app()->user->role  == Roles::ROLE_SUPERADMIN',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionExport(){

        $tenant = $_REQUEST['tenant'];
        $userTable = Yii::app()->db->quoteTableName('user');
        $default_condition = 'WHERE tenant='.$tenant.' and is_deleted=0';
        $queries = [
            'company'                           =>[$default_condition." OR id=".$tenant],

            'company_laf_preferences'           =>['JOIN company ON company_laf_preferences.id = company_laf_preferences.id '.
                                                    $default_condition],

            'tenant'                            =>['WHERE id='.$tenant.' and is_deleted=0'],

            'tenant_agent'                      =>['WHERE tenant_id='.$tenant.' and is_deleted=0'],

            'user'                              =>[$default_condition],

            'photo'                             =>[ 'JOIN company ON company.logo = photo.id '.$default_condition,
                                                    'JOIN '.$userTable.' ON '.$userTable.'.photo = photo.id '.$default_condition],

            'contact_person'                    =>['WHERE tenant='.$tenant],

            //'cvms_kiosk'                        =>[$default_condition],

            'kiosk'                             =>[$default_condition],

            'reasons'                            =>['WHERE tenant='.$tenant],

            'password_change_request'           =>['JOIN '.$userTable.' ON '.$userTable.'.id = password_change_request.user_id '.
                                                    $default_condition],

            'tenant_agent_contact'              =>['WHERE tenant_id='.$tenant],

            'tenant_contact'                    =>['WHERE tenant='.$tenant],

            'user_notification'                 =>['JOIN '.$userTable.' ON '.$userTable.'.id = user_notification.user_id '.
                                                    $default_condition],

            'notification'                      =>['JOIN user_notification ON user_notification.user_id = user_notification.user_id '.
                                                    'JOIN '.$userTable.' ON '.$userTable.'.id = user_notification.user_id '.
                                                    $default_condition],

            'workstation'                       =>[$default_condition],

            'workstation_card_type'             =>["JOIN workstation ON workstation.id = workstation_card_type.workstation ".
                                                    $default_condition],

            'user_workstation'                  =>['JOIN '.$userTable.' ON '.$userTable.'.id = user_workstation.user_id '.
                                                    $default_condition],


            'visit'                             =>[$default_condition],
            'visitor'                           =>[$default_condition],
            'visit'                             =>[$default_condition],
            'visitor_type'                      =>[$default_condition],
            'visitor_type_card_type'            =>[$default_condition],

            'visitor_password_change_request'   =>['JOIN visitor ON visitor.id = visitor_password_change_request.visitor_id '.
                                                    $default_condition],

            'card_generated'                    =>["WHERE tenant=".$tenant],

            'reset_history'                     =>['JOIN visitor ON visitor.id = reset_history.visitor_id '.
                                                    $default_condition],

            'cardstatus_convert'                =>['JOIN visitor ON visitor.id = cardstatus_convert.visitor_id '.
                                                    $default_condition],

            'audit_trail'                       =>['JOIN '.$userTable.' ON user.id = audit_trail.user_id '.$default_condition],



        ];

        $data=[];
        $dataHelper = new DataHelper(Yii::app()->db);
        foreach($queries as $table=>$conditions){
            $tableName = Yii::app()->db->quoteTableName($table);
            $data[$table] = [];
            foreach($conditions as $condition) {
                $data[$table] = array_merge($data[$table],$dataHelper->getRows("SELECT " . $tableName . ".* FROM " . $tableName . " " . $condition));
            }
        }

        echo "<pre>";
        print_r($data);
        die;
        
        //Yii::app()->getRequest()->sendFile($this->getTenantName($data).'.tenant',json_encode($data));

    }


    public function actionImport()
    {
        $model = new ImportTenantForm();
        $session = new CHttpSession;
/*        if(isset($_POST['ajax']) && $_POST['ajax']==='importtenant-form')
        {
            echo "called";
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }*/
        if (isset($_POST['ImportTenantForm'])) 
        {
            $model->attributes = $_POST['ImportTenantForm']; 
            //****************************************************************
            $name  = $_FILES['ImportTenantForm']['name']['file'];
            if(!empty($name)) 
            {
                $model->file=CUploadedFile::getInstance($model,'file');
                $fullImgSource = Yii::getPathOfAlias('webroot').'/uploads/visitor/'.$name;
                if($model->file->saveAs($fullImgSource))
                {
                    $data=file_get_contents($fullImgSource);
                    $obj = json_decode($data);
                    /*** cast the object to array ***/
                    $contents = (array) $obj;
                    foreach ($contents as $tableName => $content) 
                    {
                        if( !empty($content) ) // if table has data, then create insert statements otherwise neglect it
                        {
                            $rows = (array) $content;
                            $cols = array();
                            $sql = '';
                            foreach ($rows as $rowKey => $row) 
                            {
                                $row = (array) $row;
                                if(!$cols){$cols = array_keys($row);}
                                $values = array_values($row);
                                $vals = array();
                                foreach ($values as $val)
                                {
                                    $vals[] = "'".mysql_real_escape_string($val)."'";
                                }
                                $sql == "" ? $sql .= "(".implode(',', $vals).")" : $sql = $sql . ",". "(".implode(',', $vals).")"; 
                            }
                            echo $sql = "INSERT into ".$tableName."(".implode(',', $cols).") VALUES ". $sql;
                            echo "<br><br>";    
                        }
                    }
                    if (file_exists($fullImgSource)) 
                    {
                        unlink($fullImgSource);
                    }
                    die();
                }
            }
            //****************************************************************
        }

        $this->render("view", array("model" => $model));
    }

    function getTenantName($data){
        return $data['company'][0]['name'];
    }
}
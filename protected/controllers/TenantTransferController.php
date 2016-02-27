<?php


/**
 * Created by PhpStorm.
 * User: geoffstewart
 * Date: 3/10/15
 * Time: 6:04 PM
 */
class TenantTransferController extends Controller
{


    public $layout = '//layouts/column2';




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
                'actions' => array('export','import','deleteSql'),
                'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user,UserGroup::USERGROUP_SUPERADMIN)',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }



    public function actionExport(){

        $tenant = $_REQUEST['tenant'];

        $manager = new TenantManager();
        $data = $manager->exportWithIdToArray($tenant);

        Yii::app()->getRequest()->sendFile($this->getTenantName($data).'.tenant',json_encode($data,JSON_PRETTY_PRINT));

    }

    function actionDeleteSql()
    {
        #get the tenant
        $tenant = $_REQUEST['tenant'];

        $manager = new TenantManager();
        $sql = $manager->getDeleteSqlFromId($tenant);

        Yii::app()->getRequest()->sendFile("Delete Tenant ".$tenant.'.sql',$sql);
    }


    public function actionImport()
    {
        $model = new ImportTenantForm();
        if (isset($_POST['ImportTenantForm'])) {
            $model->attributes = $_POST['ImportTenantForm'];
            $this->importTenant($model);
        }
        return $this->render("importTenant", array("model" => $model));

    }


    private function importTenant($model)
    {

        $name  = $_FILES['ImportTenantForm']['name']['tenantFile'];
        if(!empty($name))
        {
            $model->tenantFile=CUploadedFile::getInstance($model,'tenantFile');
            $fullImgSource = Yii::getPathOfAlias('webroot').'/uploads/visitor/'.$name;



            if($model->tenantFile->saveAs($fullImgSource))
            {

                $manager = new TenantManager();
                $manager->importTenantFromJsonFile($fullImgSource);

                if (file_exists($fullImgSource))
                {
                    unlink($fullImgSource);
                }
                die();
            }
        }
        //****************************************************************

        
    }

    function getTenantName($data)
    {
        return $data['company'][0]['name'];
    }



}
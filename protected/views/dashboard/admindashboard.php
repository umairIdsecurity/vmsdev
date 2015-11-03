<style>
    .grid-view .summary {
        margin-top: -39px !important;
        margin-left: 743px !important;
    }
</style>
<?php

/* @var $this VisitController */
/* @var $model Visit */
$session = new CHttpSession();
switch ($session['role']) {
    case Roles::ROLE_ISSUING_BODY_ADMIN:
    case Roles::ROLE_ADMIN:
        $Criteria = new CDbCriteria();
        $Criteria->condition = "tenant = " . $session['tenant'] . " AND is_deleted = 0";
        $workstationList = Workstation::model()->findAll($Criteria);
        break;
    case Roles::ROLE_AGENT_ADMIN:
    case Roles::ROLE_AGENT_AIRPORT_ADMIN:
    $Criteria = new CDbCriteria();
        $Criteria->condition = "tenant = " . $session['tenant'] . " and tenant_agent = " . $session['tenant_agent'] . " AND is_deleted = 0";
        $workstationList = Workstation::model()->findAll($Criteria);
        break;
    
    case Roles::ROLE_OPERATOR:
    case Roles::ROLE_AGENT_OPERATOR:
    case Roles::ROLE_AIRPORT_OPERATOR:
    case Roles::ROLE_AGENT_AIRPORT_OPERATOR:
        $Criteria = new CDbCriteria();
        $Criteria->condition = "user_id  IN (".Yii::app()->user->id.")";
        $workstationList = UserWorkstations::model()->findAll($Criteria);
        $workstationListTemp = array();
        foreach ($workstationList as $key => $value) {
            if (!in_array($value->workstation, $workstationListTemp)) {
                array_push($workstationListTemp, $value->workstation);
            }
        }
        $workstationList = $workstationListTemp;
        break;
    default:
        $workstationList = array();
}
$x = 0; //initiate variable for foreach
if (empty($workstationList)) { ?>
    <div class="adminErrorSummary" >
        <p><br> No workstation found</p>
    </div>
<?php }

// move selected items to first
if (isset($session['workstation'])) {
    
    $workstation = Workstation::model()->findByPk($session['workstation']);

    if ($workstation) {
        foreach ($workstationList as $key => $value) {
            if(in_array(intval($session['role']),[Roles::ROLE_AIRPORT_OPERATOR, Roles::ROLE_OPERATOR, Roles::ROLE_AGENT_OPERATOR, Roles::ROLE_AGENT_AIRPORT_OPERATOR])){
                if ($value == $workstation->id) {
                    $moveWorkstation = $workstationList[$key];
                    $workstationList[$key] = $workstationList[0];
                    $workstationList[0] = $moveWorkstation;
                }
            }
            else {
                if ($value->id == $workstation->id) {
                    $moveWorkstation = $workstationList[$key];
                    $workstationList[$key] = $workstationList[0];
                    $workstationList[0] = $moveWorkstation;
                }
            }
        }

    }
}


foreach ($workstationList as $workstation) {
    $x++;
    if(in_array(intval($session['role']),[Roles::ROLE_AIRPORT_OPERATOR, Roles::ROLE_OPERATOR, Roles::ROLE_AGENT_OPERATOR, Roles::ROLE_AGENT_AIRPORT_OPERATOR] )){
        $workstationName = Workstation::model()->findByPk($workstation)->name;
    } else {
        $workstationName = $workstation->name;
    }
    echo "<h1>" . $workstationName . "</h1>";
    $merge = new CDbCriteria;
    if(in_array(intval($session['role']),[Roles::ROLE_AIRPORT_OPERATOR, Roles::ROLE_OPERATOR, Roles::ROLE_AGENT_OPERATOR, Roles::ROLE_AGENT_AIRPORT_OPERATOR])){
        $workstationId = $workstation;
    } else {
        $workstationId = $workstation->id;
    }
    $merge->addCondition("workstation =" . $workstationId . " and (visit_status =" . VisitStatus::ACTIVE . " or visit_status =" . VisitStatus::PREREGISTERED . " or visit_status =" . VisitStatus::EXPIRED . ")");

?>
    <div  class="admindashboardDiv">
        <?php
        $login_url = $this->createUrl('site/login');
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'visit-gridDashboard' . $x,
            'dataProvider' => $model->search($merge),
            'enableSorting' => false,
            'hideHeader'=>true,
            'filter' => $model,
            'afterAjaxUpdate' => "
            function(id, data) {
                $('th > .asc').append('<div></div>');
                $('th > .desc').append('<div></div>');
            }",
            'columns' =>
            array(
                array(
                    'name' => 'visit_status',
                    'filter' => VisitStatus::$VISIT_STATUS_DASHBOARD_FILTER,
                    'value' => 'CHtml::link(VisitStatus::$VISIT_STATUS_LIST[$data->visit_status],Yii::app()->createUrl("visit/detail",array("id"=>$data->id)),array("class" =>"statusLink"))',
                    'type' => 'raw',
                    'header' => 'Status',
                    //'cssClassExpression' => '"statusRow"',
                    'cssClassExpression' => 'changeStatusClass($data->visit_status)',
                    'htmlOptions'=>array('width'=>'40px'),
                ),
                array(
                    'name' => 'cardnumber',
                    'header' => 'Card No.',
                    'filter'=>CHtml::activeTextField($model, 'cardnumber', array('placeholder'=>'Card No.')),
                    'value' => 'CardGenerated::model()->getCardCode($data->card)',
                    'htmlOptions'=>array('width'=>'150px'),
                ),
                array(
                    'name' => 'firstname',
                    'filter'=>CHtml::activeTextField($model, 'firstname', array('placeholder'=>'First Name')),
                    'value' => '!empty($data->visitor0->first_name) ? $data->visitor0->first_name : ""',
                    'header' => 'First Name',
                    'htmlOptions'=>array('width'=>'120px'),
                ),
                array(
                    'name' => 'lastname',
                    'filter'=>CHtml::activeTextField($model, 'lastname', array('placeholder'=>'Last Name')),
                    'value' => '!empty($data->visitor0->last_name) ? $data->visitor0->last_name : ""',
                    'header' => 'Last Name',
                    'htmlOptions'=>array('width'=>'120px'),
                ),
                array(
                    'name' => 'company',
                    'filter'=>CHtml::activeTextField($model, 'company', array('placeholder'=>'Company')),
                    'value' => 'getCompany($data->visitor)',
                    'header' => 'Company',
                    'cssClassExpression' => '(getCompany($data->visitor) == "Not Available" ? "errorNotAvailable" : "")',
                    'type' => 'raw',
                    'htmlOptions'=>array('width'=>'120px'),
                ),
                array(
                    'name' => 'contactnumber',
                    'filter'=>CHtml::activeTextField($model, 'contactnumber', array('placeholder'=>'Contact Number')),
                    'value' => '!empty($data->visitor0->contact_number) ? $data->visitor0->contact_number : ""',
                    'header' => 'Contact Number',
                    'htmlOptions'=>array('width'=>'120px'),
                ),
                array(
                    'name' => 'contactemail',
                    'filter'=>CHtml::activeTextField($model, 'contactemail', array('placeholder'=>'Contact Email')),
                    'value' => '!empty($data->visitor0->email) ? $data->visitor0->email : ""',
                    'header' => 'Contact Email',
                    'htmlOptions'=>array('width'=>'100px'),
                ),
                array(
                    'name' => 'date_check_in',
                    'filter'=>CHtml::activeTextField($model, 'date_check_in', array('placeholder'=>'Check In Date')),
                    'type' => 'html',
                    'htmlOptions'=>array('width'=>'100px'),
                    'value' => 'CHelper::formatDate($data->date_check_in)',
                ),
                array(
                    'name' => 'time_check_in',
                    'filter'=>CHtml::activeTextField($model, 'time_check_in', array('placeholder'=>'Check In Time')),
                    'type' => 'html',
                    'value' => 'formatTime($data->time_check_in)',
                    'htmlOptions'=>array('width'=>'100px'),
                ),
                array(
                    'name' => 'date_check_out',
                    'filter'=>CHtml::activeTextField($model, 'date_check_out', array('placeholder'=>'Check Out Date')),
                    'type' => 'html',
                    'htmlOptions'=>array('width'=>'110px'),
                    'value' => 'CHelper::formatDate($data->date_check_out)',
                ),
            ),
        ));
        ?>
    </div>
    <br>
<?php
}

function getVisitorFullName($id) {
    $visitor = Visitor::model()->findByPk($id);

    return $visitor->first_name . ' ' . $visitor->last_name;
}

function getCompany($id) {

    $visitor = Visitor::model()->findByPk($id);

    if ($visitor) {
        $companyID = $visitor->company;
        $companyModel = Company::model();

        $company = $companyModel->findByPk($companyID, "is_deleted >= 0");

        if(isset($company))
        {
            return $company->name;
        }
    }
    return "Not Available";

}

function formatTime($time) {
    if ($time == '' || $time == '00:00:00') {
        return "-";
    } else {
        return date('h:i A', strtotime($time));
    }
}

function changeStatusClass($visitStatus) {
    // return "red";
    switch ($visitStatus) {
        case VisitStatus::ACTIVE:
            return "green";
            break;

        case VisitStatus::PREREGISTERED:
            return "blue";
            break;

        case VisitStatus::CLOSED:
            return "black";
            break;

        case VisitStatus::SAVED:
            return "grey";
            break;

        case VisitStatus::EXPIRED:
            return "red";
            break;

        default:
            break;
    }
}
?>

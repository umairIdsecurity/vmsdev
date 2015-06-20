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
    case Roles::ROLE_ADMIN:
        $Criteria = new CDbCriteria();
        $Criteria->condition = "tenant ='" . $session['tenant'] . "' AND is_deleted = 0";
        $workstationList = Workstation::model()->findAll($Criteria);
        break;
    case Roles::ROLE_ISSUING_BODY_ADMIN:
        $Criteria = new CDbCriteria();
        $Criteria->condition = "tenant ='" . $session['tenant'] . "' AND is_deleted = 0";
        $workstationList = Workstation::model()->findAll($Criteria);
        break;
    case Roles::ROLE_AGENT_ADMIN:
        $Criteria = new CDbCriteria();
        $Criteria->condition = "tenant ='" . $session['tenant'] . "' and tenant_agent ='" . $session['tenant_agent'] . "' AND is_deleted = 0";
        $workstationList = Workstation::model()->findAll($Criteria);
        break;
    
    case Roles::ROLE_OPERATOR:
    case Roles::ROLE_AGENT_OPERATOR:
        $Criteria = new CDbCriteria();
        $Criteria->condition = "`user`  IN ('".Yii::app()->user->id."')";
        $workstationList = UserWorkstations::model()->findAll($Criteria);
        break;
}
$x = 0; //initiate variable for foreach
if (empty($workstationList)) {
	if (Roles::ROLE_AGENT_ADMIN == $session['role'] || Roles::ROLE_ADMIN == $session['role']) {
		echo '<div style="margin-top: 20px;" class="btn"><a class="addSubMenu" href="' . Yii::app()->createUrl('workstation/create') . '" ><span>Add Workstation</span></a></div>';
	}else if(Roles::ROLE_ISSUING_BODY_ADMIN == $session['role']){
    ?>
        <div class="adminErrorSummary" >
        <p><br> No workstation found</p>
    </div>
    <?php } else {
    ?>

    <div class="adminErrorSummary" >
        <p><b>Error 503</b><br> No workstations available</p>
    </div>

    <?php
	}
}

// move selected items to first
if (isset($session['workstation'])) {
    
    $workstation = Workstation::model()->findByPk($session['workstation']);

    if ($workstation) {
        foreach ($workstationList as $key => $value) {
            if ($value->id == $workstation->id) {
                $moveWorkstation = $workstationList[$key];
                $workstationList[$key] = $workstationList[0];
                $workstationList[0] = $moveWorkstation;
            }
        }

    }
}


foreach ($workstationList as $workstation) {
    $x++;
    if($session['role'] == Roles::ROLE_OPERATOR || $session['role'] == Roles::ROLE_AGENT_OPERATOR){
        $workstationName = Workstation::model()->findByPk($workstation->workstation)->name;
    } else {
        $workstationName = $workstation->name;
    }
    echo "<h1>" . $workstationName . "</h1>";
    $merge = new CDbCriteria;
    if($session['role'] == Roles::ROLE_OPERATOR || $session['role'] == Roles::ROLE_AGENT_OPERATOR){
        $workstationId = $workstation->workstation;
    } else {
        $workstationId = $workstation->id;
    }
    $merge->addCondition("workstation ='" . $workstationId . "' and (visit_status ='" . VisitStatus::ACTIVE . "' or visit_status ='" . VisitStatus::PREREGISTERED . "')");
    ?><div  class="admindashboardDiv"><?php
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
                    'value' => 'Visitor::model()->findByPk($data->visitor)->first_name',
                    'header' => 'First Name',
                    'htmlOptions'=>array('width'=>'120px'),
                ),
                array(
                    'name' => 'lastname',
                    'filter'=>CHtml::activeTextField($model, 'lastname', array('placeholder'=>'Last Name')),
                    'value' => 'Visitor::model()->findByPk($data->visitor)->last_name',
                    'header' => 'Last Name',
                    'htmlOptions'=>array('width'=>'120px'),
                ),
                array(
                    'name' => 'company',
                    'filter'=>CHtml::activeTextField($model, 'company', array('placeholder'=>'Company')),
                    'value' => 'getCompany($data->visitor)',
                    'header' => 'Company',
                    'cssClassExpression' => '( getCompany($data->visitor)== "Not Available" ? "errorNotAvailable" : "" ) ',
                    'type' => 'raw',
                    'htmlOptions'=>array('width'=>'120px'),
                ),
                array(
                    'name' => 'contactnumber',
                    'filter'=>CHtml::activeTextField($model, 'contactnumber', array('placeholder'=>'Contact Number')),
                    'value' => 'Visitor::model()->findByPk($data->visitor)->contact_number',
                    'header' => 'Contact Number',
                    'htmlOptions'=>array('width'=>'120px'),
                ),
                array(
                    'name' => 'contactemail',
                    'filter'=>CHtml::activeTextField($model, 'contactemail', array('placeholder'=>'Contact Email')),
                    'value' => 'Visitor::model()->findByPk($data->visitor)->email',
                    'header' => 'Contact Email',
                    'htmlOptions'=>array('width'=>'100px'),
                ),
                array(
                    'name' => 'date_check_in',
                    'filter'=>CHtml::activeTextField($model, 'date_check_in', array('placeholder'=>'Check In Date')),
                    'type' => 'html',
                    'htmlOptions'=>array('width'=>'100px'),
                //  'value' => 'formatDate($data->date_in)',
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
                //    'value' => 'formatDate($data->date_out)',
                ),
            ),
        ));
        ?></div><br><?php
}

function getVisitorFullName($id) {
    $visitor = Visitor::model()->findByPk($id);

    return $visitor->first_name . ' ' . $visitor->last_name;
}

function getCompany($id) {

    $company_id = Visitor::model()->findByPk($id)->company;

    if (isset($company_id)) {

        $companyModel = Company::model();

        $company = $companyModel->findByPk($company_id, "is_deleted >= 0 " );

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
            return "red";
            break;

        case VisitStatus::SAVED:
            return "grey";
            break;

        default:
            break;
    }
}
?>

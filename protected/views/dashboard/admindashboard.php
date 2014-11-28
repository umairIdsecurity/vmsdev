<div id="admindashboardDiv">
<?php

/* @var $this VisitController */
/* @var $model Visit */
$session = new CHttpSession();

switch ($session['role']) {
    case Roles::ROLE_ADMIN:
        $Criteria = new CDbCriteria();
        $Criteria->condition = "tenant ='" . $session['tenant'] . "'";
        $workstationList = Workstation::model()->findAll($Criteria);
        break;

    case Roles::ROLE_AGENT_ADMIN:
        $Criteria = new CDbCriteria();
        $Criteria->condition = "tenant ='" . $session['tenant'] . "' and tenant_agent ='" . $session['tenant_agent'] . "'";
        $workstationList = Workstation::model()->findAll($Criteria);
        break;
}
 $x = 0;
foreach ($workstationList as $workstation) {
   
    $x++;
    echo "<h1>" . $workstation->name . "</h1>";
        $merge = new CDbCriteria;
        $merge->addCondition('workstation ="' . $workstation->id . '"');
   
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'visit-gridDashboard'.$x,
        'dataProvider' => $model->search($merge),
        'filter' => $model,
        'columns' =>
        array(
            array(
                'name' => 'visit_status',
                'filter' => false,
                'value' => 'CHtml::link(VisitStatus::$VISIT_STATUS_LIST[$data->visit_status],Yii::app()->createUrl("visit/detail",array("id"=>$data->id)),array("class" =>"statusLink"))',
                'type' => 'raw',
                'header' => 'Status',
                 'cssClassExpression' => '"statusRow"',
            ),
            array(
                'name' => 'date_in',
                'type' => 'html',
                'value' => 'formatDate($data->date_in)',
            ),
            array(
                'name' => 'card',
                'header' => 'Card No.'
            ),
            array(
                'name' => 'firstname',
                'value' => 'Visitor::model()->findByPk($data->visitor)->first_name',
                'header' => 'First Name'
            ),
            array(
                'name' => 'lastname',
                'value' => 'Visitor::model()->findByPk($data->visitor)->last_name',
                'header' => 'Last Name'
            ),
            array(
                'name' => 'company',
                'value' => 'getCompany($data->visitor)',
                'header' => 'Company',
                'cssClassExpression' => '( getCompany($data->visitor)== "Not Available" ? "errorNotAvailable" : "" ) ',
                'type' => 'raw'
            ),
            array(
                'name' => 'contactnumber',
                'value' => 'Visitor::model()->findByPk($data->visitor)->contact_number',
                'header' => 'Contact Number'
            ),
            array(
                'name' => 'contactemail',
                'value' => 'Visitor::model()->findByPk($data->visitor)->email',
                'header' => 'Contact Email'
            ),
            array(
                'name' => 'time_in',
                'type' => 'html',
                'value' => 'formatTime($data->time_in)',
            ),
            array(
                'name' => 'date_out',
                'type' => 'html',
                'value' => 'formatDate($data->date_out)',
            ),
        ),
    ));
}

function getVisitorFullName($id) {
    $visitor = Visitor::model()->findByPk($id);

    return $visitor->first_name . ' ' . $visitor->last_name;
}

function getCompany($id) {
    if (Visitor::model()->findByPk($id)->company == NULL) {
        return "Not Available";
    } else {
        return Company::model()->findByPk(Visitor::model()->findByPk($id)->company)->name;
    }
}

function formatTime($time) {
    if ($time == '') {
        return "-";
    } else {
        return date('h:i A', strtotime($time));
    }
}

function formatDate($date) {
    if ($date == '') {
        return "-";
    } else {
        return Yii::app()->dateFormatter->format("d/MM/y", strtotime($date));
    }
}
?>
</div>
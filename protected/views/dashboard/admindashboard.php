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
        $Criteria->condition = "tenant ='" . $session['tenant'] . "'";
        $workstationList = Workstation::model()->findAll($Criteria);
        break;

    case Roles::ROLE_AGENT_ADMIN:
        $Criteria = new CDbCriteria();
        $Criteria->condition = "tenant ='" . $session['tenant'] . "' and tenant_agent ='" . $session['tenant_agent'] . "'";
        $workstationList = Workstation::model()->findAll($Criteria);
        break;
}
$x = 0; //initiate variable for foreach
if (empty($workstationList)) {
    ?>

    <div class="adminErrorSummary" >
        <p><b>Error 503</b><br> No workstations available</p>
    </div>

    <?php
}
foreach ($workstationList as $workstation) {

    $x++;
    echo "<h1>" . $workstation->name . "</h1>";
    $merge = new CDbCriteria;
    $merge->addCondition('workstation ="' . $workstation->id . '" and (visit_status ="' . VisitStatus::ACTIVE . '" or visit_status ="' . VisitStatus::PREREGISTERED . '")');
    ?><div  class="admindashboardDiv"><?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'visit-gridDashboard' . $x,
            'dataProvider' => $model->search($merge),
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
                ),
                array(
                    'name' => 'card',
                    'header' => 'Card No.',
                    'value' => 'CardGenerated::model()->getCardCode($data->card, $data->id)',
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
                    'name' => 'date_check_in',
                    'type' => 'html',
                //  'value' => 'formatDate($data->date_in)',
                ),
                array(
                    'name' => 'time_check_in',
                    'type' => 'html',
                    'value' => 'formatTime($data->time_check_in)',
                ),
                array(
                    'name' => 'date_check_out',
                    'type' => 'html',
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

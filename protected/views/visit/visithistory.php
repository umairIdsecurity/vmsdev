<?php
date_default_timezone_set("Asia/Manila");
$session = new CHttpSession;
?>
<div id="visitHistoryVisitDetailDiv">
    <span class="visitTitle">Visit History</span>
    <div id="visitHistoryTableDiv">
        <span>Closed Visit</span>

        <?php
        if ($model->host != '') {
            $host = $model->host;
            $GLOBALS['userHost'] = 'host';
        } else {
            $host = $model->patient;
            $GLOBALS['userHost'] = 'patient';
        }


        $visitor = $model->visitor;
        $model = new Visit;
        $criteria = new CDbCriteria;
        $criteria->order = 'date_check_out,time_check_out DESC';
        $criteria->addCondition('visit_status="' . VisitStatus::CLOSED . '" and visitor="' . $visitor . '"');


        $model->unsetAttributes();
        $visitData = new CActiveDataProvider($model, array(
            'criteria' => $criteria,
        ));
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'visit-grid',
            'dataProvider' => $visitData,
            'afterAjaxUpdate' => "
    function(id, data) {
        $('th > .asc').append('<div></div>');
        $('th > .desc').append('<div></div>');
    }",
            'columns' => array(
                array(
                    'name' => 'cardnumber',
                    'header' => 'Card No.',
                    'value' => 'CardGenerated::model()->getCardCode($data->card)',
                ),
                array(
                    'header' => 'Open by',
                    'name' => 'created_by',
                    'type' => 'html',
                    'value' => 'User::model()->findByPk($data->created_by)->first_name." ".User::model()->findByPk($data->created_by)->last_name',
                ),
                array(
                    'name' => 'date_check_in',
                    'type' => 'html',
                //   'value' => 'Yii::app()->dateFormatter->format("d/MM/y",strtotime($data->date_in))',
                ),
                array(
                    'name' => 'Host',
                    'type' => 'html',
                    'value' => 'returnPatientOrHostName($data->id,$GLOBALS["userHost"])',
                ),
                array(
                    'name' => 'date_check_out',
                    'type' => 'html',
                //  'value' => 'Yii::app()->dateFormatter->format("d/MM/y",strtotime($data->date_out))',
                ),
                array(
                    'name' => 'time_check_out',
                    'type' => 'html',
                    'value' => 'formatTime($data->time_check_out)',
                ),
                array(
                    'header' => 'Closed by',
                    'name' => 'created_by',
                    'type' => 'html',
                    'value' => 'User::model()->findByPk($data->created_by)->first_name." ".User::model()->findByPk($data->created_by)->last_name',
                ),
                array(
                    'header' => 'Actions',
                    'class' => 'CButtonColumn',
                    'template' => '{delete}',
                    'buttons' => array(
                        'delete' => array(//the name {reply} must be same
                            'label' => 'Delete', // text label of the button
                            'imageUrl' => false, // image URL of the button. If not set or false, a text link is used, The image must be 16X16 pixels
                            'visible' => 'isRoleAllowedToDelete()',
                        ),
                    ),
                ),
            ),
        ));
        ?>

    </div>
</div>

<?php

function returnPatientOrHostName($visit_id, $userHost) {
    $visitDetails = Visit::model()->findByPk($visit_id);
    if ($visitDetails['visitor_type'] == VisitorType::PATIENT_VISITOR) {
        $hostFullName = Patient::model()->findByPk($visitDetails['patient'])->name;
    } else {
        $fname = User::model()->findByPk($visitDetails['host'])->first_name;
        $lname = User::model()->findByPk($visitDetails['host'])->last_name;
        $hostFullName = $fname . " " . $lname;
    }

    return $hostFullName;
}

function formatTime($time) {
    if ($time == '' || $time == '00:00:00') {
        return "-";
    } else {
        return date('h:i A', strtotime($time));
    }
}

function isRoleAllowedToDelete() {
    $session = new CHttpSession;
    if ($session['role'] != Roles::ROLE_STAFFMEMBER) {
        return true;
    } else {
        return false;
    }
}
?>
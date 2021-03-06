<?php
date_default_timezone_set("Asia/Manila");
$session = new CHttpSession;
?>
<style>
    #visit-grid table th {
        padding-right: 0 !important;
    }
    #visitorDetailDiv tr {
        border:none !important;
    }
</style>
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
        $card_type = $model->card_type;

        $visitor = $model->visitor;
        $model = new Visit;
        $criteria = new CDbCriteria;
        $criteria->order = 'id DESC';
        $criteria->addCondition("(visit_status = " . VisitStatus::AUTOCLOSED . " OR visit_status = " . VisitStatus::CLOSED . ") AND visitor = " . $visitor);

        //because of the comment in https://ids-jira.atlassian.net/browse/CAVMS-1242
        //$criteria->addCondition("reset_id IS NULL AND negate_reason IS NULL");


        $model->unsetAttributes();
        $visitData = new CActiveDataProvider($model, array(
            'criteria' => $criteria,
        ));
		
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'visit-grid',
            'dataProvider' => $visitData,
            'ajaxUpdateError' => "function(id, data) {window.location.replace('?r=site/login');}",
            /*'afterAjaxUpdate' => "
                function(id, data) {
                    $('th > .asc').append('<div></div>');
                    $('th > .desc').append('<div></div>');
                }",*/
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
                    'value' => 'User::model()->fullName($data->created_by)',
					//'value'=>'$v->first_name',
					),
					
                array(
                    'name' => 'date_check_in',
                    'type' => 'html',
                   'value' => 'Yii::app()->dateFormatter->format("dd-MM-y",strtotime($data->date_check_in))',
                ),
                array(
                    'header' => ($card_type > CardType::CONTRACTOR_VISITOR) ? "ASIC Sponsor" : "Host",
                    'type' => 'html',
                    'value' => 'returnPatientOrHostName($data->id,$GLOBALS["userHost"])',
                ),
                array(
                    'name' => 'date_check_out',
                    'type' => 'html',
                   'value' => 'Yii::app()->dateFormatter->format("dd-MM-y",strtotime($data->date_check_out))',
                ),
                array(
                    'name' => 'time_check_out',
                    'type' => 'html',
                    'value' => 'formatTime($data->time_check_out)',
                ),
               /* array(
                    'header' => 'Closed by',
                    'name' => 'closed_by',
                    'type' => 'html',
                    'value' => '!is_null($data->closed_by) ?  User::model()->findByPk($data->closed_by)->first_name." ".User::model()->findByPk($data->closed_by)->last_name:""',
                ),*/
                 array(
                    'header' => 'Date Closed',
                    'name' => 'visit_closed_date',
                    'type' => 'html',
                     'value' => '!is_null($data->visit_closed_date)?date("d-m-Y", strtotime($data->visit_closed_date)):""',
                ),
                
//                array(
//                    'header' => 'Actions',
//                    'class' => 'CButtonColumn',
//                    'template' => '{delete}',
//                    'buttons' => array(
//                        'delete' => array(//the name {reply} must be same
//                            'label' => 'Delete', // text label of the button
//                            'imageUrl' => false, // image URL of the button. If not set or false, a text link is used, The image must be 16X16 pixels
//                            'visible' => 'isRoleAllowedToDelete()',
//                        ),
//                    ),
//                ),
            ),
        ));
		
		 //$criteria = new CDbCriteria();
		 
		//$check = $data->created_by;
				//$result=$check->text;
				//echo $check;
				//$c = array(User::model()->findByPk($model['created_by'])->first_name);
				//echo $c->first_name;
				//die();
        
        ?>

    </div>
</div>

<?php

function returnPatientOrHostName($visit_id, $userHost) {
    $visitDetails = Visit::model()->findByPk($visit_id);
    /*if ($visitDetails['visitor_type'] == VisitorType::PATIENT_VISITOR) {
        $hostFullName = Patient::model()->findByPk($visitDetails['patient'])->name;
    } else {*/
        $user = Visitor::model()->findByPk($visitDetails['host']);
        if ($user) {
            $fname = $user->first_name;
            $lname = $user->last_name;
            $hostFullName = $fname . " " . $lname;
        } else {
            $hostFullName = '';
        }
    //}

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
    if ($session['role'] == Roles::ROLE_ADMIN || $session['role'] == Roles::ROLE_SUPERADMIN) {
        return true;
    } else {
        return false;
    }
}
?>
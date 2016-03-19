<style>
    .grid-view .summary {
        margin-left: 760px !important;
        margin-top: -25px !important;
    }
</style>
<h1>Visitor Registration History</h1>
<?php echo CHtml::button('Export to CSV', array('id' => 'export-button', 'class' => 'greenBtn complete')); ?>

<div class="searchDateRange" >
    <?php
    /* @var $this VisitController */
    /* @var $model Visit */
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));

    $attribute = 'date_check_in';
    for ($i = 0; $i <= 1; $i++) {
        echo ($i == 0 ? Yii::t('main', '<span class="searchRangeTitle">Date From:</span>') : Yii::t('main', '<span class="searchRangeTitle">Date To:</span>'));
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'id' => CHtml::activeId($model, $attribute . '_' . $i),
            'model' => $model,
            'attribute' => $attribute . "[$i]",
            'options' => array(
                'dateFormat' => 'dd-mm-yy',
            ),
            'htmlOptions' => array(
                'placeholder' => 'dd-mm-yyyy',
                'readonly' => 'readonly',
            ),
        ));
    }
    ?>
    <input type="submit" name="yt1" value="Filter" style="margin-top:-10px;height:30px;" class="neutral">  

    <?php $this->endWidget(); ?>
</div>
<?php
$session = new CHttpSession;
$merge = new CDbCriteria;
$merge->addCondition("visit_status =" . VisitStatus::CLOSED . "");


?>
<input type="text" id="totalRecordsCount" value="<?php echo $model->search($merge)->getTotalItemCount(); ?>"/>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'view-visitor-records-history',
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
            'filter'=>CHtml::activeTextField($model, 'visit_status', array('placeholder'=>'Status','disabled'=>'disabled')),
            'value' => 'CHtml::link(VisitStatus::$VISIT_STATUS_LIST[$data->visit_status],Yii::app()->createUrl("visit/detail",array("id"=>$data->id)),array("class" =>"statusLink"))',
            'type' => 'raw',
            'header' => 'Status',
            'cssClassExpression' => 'changeStatusClass($data->visit_status)',
        ),
        array(
            'name' => 'visitor_type',
            'value' => 'is_array(VisitorType::model()->returnVisitorTypes($data->visitor_type))? "" : VisitorType::model()->returnVisitorTypes($data->visitor_type)',
            'filter'=>CHtml::activeTextField(Visitor::model(), 'profile_type', array('placeholder'=>'Corporate Profile Type','disabled'=>'disabled')),
        ),
        array(
            'name' => 'cardnumber',
            'header' => 'Card No.',
            'value'=>  'CardGenerated::model()->getCardCode($data->card)',
            'filter'=>CHtml::activeTextField($model, 'cardnumber', array('placeholder'=>'Card No.')),
        ),
        array(
            'name' => 'firstname',
            'value' => 'Visitor::model()->findByPk($data->visitor)? Visitor::model()->findByPk($data->visitor)->first_name : ""',
            'header' => 'First Name',
            'filter'=>CHtml::activeTextField($model, 'firstname', array('placeholder'=>'First Name')),
        ),
        array(
            'name' => 'lastname',
            'value' => 'Visitor::model()->findByPk($data->visitor)? Visitor::model()->findByPk($data->visitor)->last_name : ""',
            'header' => 'Last Name',
            'filter'=>CHtml::activeTextField($model, 'lastname', array('placeholder'=>'Last Name')),
        ),
        array(
            'name' => 'company',
            'value' => 'getCompany($data->visitor)',
            'header' => 'Company Name',
            'cssClassExpression' => '( getCompany($data->visitor)== "Not Available" ? "errorNotAvailable" : "" ) ',
            'type' => 'raw',
            'filter'=>CHtml::activeTextField($model, 'company', array('placeholder'=>'Company Name')),
        ),
        array(
            'name' => 'contactnumber',
            'value' => 'Visitor::model()->findByPk($data->visitor)? Visitor::model()->findByPk($data->visitor)->contact_number : ""',
            'header' => 'Contact Number',
            'filter'=>CHtml::activeTextField($model, 'contactnumber', array('placeholder'=>'Contact Number')),
        ),
        array(
            'name' => 'contactemail',
            'value' => 'Visitor::model()->findByPk($data->visitor)? Visitor::model()->findByPk($data->visitor)->email : ""',
            'header' => 'Contact Email',
            'filter'=>CHtml::activeTextField($model, 'contactemail', array('placeholder'=>'Contact Email')),
        ),
        array(
            'name' => 'datecheckin1',
            'value' => '$data->date_check_in',
            'header' => 'Date Check In',
            'filter'=>CHtml::activeTextField($model, 'datecheckin1', array('placeholder'=>'Date Check In')),
        ),

      
        array(
            'name' => 'time_check_in',
            'type' => 'html',
            'value' => 'formatTime($data->time_check_in)',
            'filter'=>CHtml::activeTextField($model, 'time_check_in', array('placeholder'=>'Check In Time')),
        ),
        //'date_check_out',
        array(
            'name' => 'date_check_out',
            'type' => 'html',
            'filter'=>CHtml::activeTextField($model, 'date_check_out', array('placeholder'=>'Check Out Date'))
            //   'value' => 'formatDate($data->date_out)',
        ),
        array(
            'name' => 'time_check_out',
            'type' => 'html',
            'value' => 'formatTime($data->time_check_in)',
            'filter'=>CHtml::activeTextField($model, 'time_check_out', array('placeholder'=>'Check Out Time'))
        ),
        array(
            'name' => 'date_out',
            'type' => 'html',
            'header' => 'Date Expiration',
            'filter'=>CHtml::activeTextField($model, 'date_out', array('placeholder'=>'Date Expiration'))
        ),
       // 'card0.date_expiration',
    ),
));

function getCompany($id) {
    if (Visitor::model()->findByPk($id))
    {
         $company_id = Visitor::model()->findByPk($id)->company;

        if (isset($company_id)) {

            $companyModel = Company::model();

            $company = $companyModel->findByPk($company_id, "is_deleted >= 0 " );

            if(isset($company))
            {
                return $company->name;
            }
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
?>
<script>
    $(document).ready(function() {
        if ($("#totalRecordsCount").val() == 0) {
            $('#export-button').removeClass('greenBtn');
            $('#export-button').addClass('btn DeleteBtn');
            $("#export-button").attr('disabled', true);
        }

        $('#export-button').on('click', function() {
            $.fn.yiiGridView.export();
        });
        $.fn.yiiGridView.export = function() {
            $.fn.yiiGridView.update('view-visitor-records-history', {
                success: function() {
                    $('#view-visitor-records-history').removeClass('grid-view-loading');
                    window.location = '<?php echo $this->createUrl('exportFileHistory'); ?>';
                },
                data: $('#view-visitor-records-history').serialize() + '&export=true'
            });
        }

        $("#Visit_date_check_in_0").datepicker({
            changeMonth: true,
            changeYear: true,
            showOn: "button",
            buttonImage: "<?php echo Yii::app()->controller->assetsBase; ?>/images/calendar.png",
            buttonImageOnly: true,
            buttonText: "Select Date From",
            dateFormat: "dd-mm-yy",
            onClose: function (selectedDate) { $("#Visit_date_check_in_1").datepicker("option", "minDate", selectedDate); },
        });

        $("#Visit_date_check_in_1").datepicker({
            changeMonth: true,
            changeYear: true,
            showOn: "button",
            buttonImage: "<?php echo Yii::app()->controller->assetsBase; ?>/images/calendar.png",
            buttonImageOnly: true,
            buttonText: "Select Date To",
            dateFormat: "dd-mm-yy"
        });
    });
</script>
<?php 
function changeStatusClass($visitStatus){
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
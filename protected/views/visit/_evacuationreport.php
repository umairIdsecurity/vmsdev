<style>
    .grid-view .summary {
        margin-left: 760px !important;
        margin-top: -25px !important;
    }
</style>
<?php
/* @var $this VisitController */
/* @var $model Visit */
?>

<h1>Evacuation Report</h1>
<?php echo CHtml::button('Export to CSV', array('id' => 'export-button', 'class' => 'greenBtn complete')); ?>
<br>

<div class="search-form" style="display:none;">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->
<?php
$session = new CHttpSession;
$merge = new CDbCriteria;
$merge->addCondition('visit_status ="' . VisitStatus::ACTIVE . '"');
?>
<input type="text" id="totalRecordsCount" value="<?php echo $model->search($merge)->getTotalItemCount(); ?>"/>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'view-visitor-records',
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
            'value' => 'VisitorType::model()->returnVisitorTypes($data->visitor_type)',
            'filter' => VisitorType::model()->returnVisitorTypes(),
        ),
        array(
            'name' => 'cardnumber',
            'header' => 'Card No.',
            'value'=>  'CardGenerated::model()->getCardCode($data->card)',
            'filter'=>CHtml::activeTextField($model, 'cardnumber', array('placeholder'=>'Card No.')),
        ),
        
        array(
            'name' => 'firstname',
            'value' => 'Visitor::model()->findByPk($data->visitor)->first_name',
            'header' => 'First Name',
            'filter' => CHtml::textField('Visit[firstname]', '', array('class' => 'filterFirstName','placeholder'=>'First Name')),
        ),
        array(
            'name' => 'lastname',
            'value' => 'Visitor::model()->findByPk($data->visitor)->last_name',
            'header' => 'Last Name',
            'filter' => CHtml::textField('Visit[lastname]', '', array('class' => 'filterLastName' , 'placeholder'=>'Last Name')),
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
            'value' => 'Visitor::model()->findByPk($data->visitor)->contact_number',
            'header' => 'Contact Number',
            'filter'=>CHtml::activeTextField($model, 'contactnumber', array('placeholder'=>'Contact Number')),
        ),
        array(
            'name' => 'contactemail',
            'value' => 'Visitor::model()->findByPk($data->visitor)->email',
            'header' => 'Contact Email',
            'filter'=>CHtml::activeTextField($model, 'contactemail', array('placeholder'=>'Contact Email'))
        ),
        array(
            'name' => 'date_check_in',
            'type' => 'html',
            'filter'=>CHtml::activeTextField($model, 'date_check_in', array('placeholder'=>'Check In Date'))
        //    'value' => 'formatDate($data->date_in)',
        ),
        array(
            'name' => 'time_check_in',
            'type' => 'html',
            'value' => 'formatTime($data->time_check_in)',
            'filter'=>CHtml::activeTextField($model, 'time_check_in', array('placeholder'=>'Check In Time'))
        ),
        array(
            'name' => 'date_check_out',
            'type' => 'html',
            'filter'=>CHtml::activeTextField($model, 'date_check_out', array('placeholder'=>'Check Out Date'))
        //   'value' => 'formatDate($data->date_out)',
        ),
        array(
            'name' => 'time_check_out',
            'type' => 'html',
            'value' => 'formatTime($data->time_check_out)',
            'filter'=>CHtml::activeTextField($model, 'time_check_out', array('placeholder'=>'Check Out Time'))
        ),
        //'card0.date_expiration',
        array(
            'name' => 'date_out',
            'type' => 'html',
            'header' => 'Date Expiration',
            'filter'=>CHtml::activeTextField($model, 'date_out', array('placeholder'=>'Date Expiration'))
        ),
    ),
));

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
?>
<script>
    $(document).ready(function() {
        if ($("#totalRecordsCount").val() == 0) {
            $('#export-button').removeClass('greenBtn');
            $('#export-button').addClass('btn DeleteBtn actionForward');
            $("#export-button").attr('disabled', true);
        }
        
        $('#export-button').on('click', function() {
            $.fn.yiiGridView.export();
        });
        $.fn.yiiGridView.export = function() {
            $.fn.yiiGridView.update('view-visitor-records', {
                success: function() {
                    $('#view-visitor-records').removeClass('grid-view-loading');
                    window.location = '<?php echo $this->createUrl('exportFile'); ?>';
                },
                data: $('#view-visitor-records').serialize() + '&export=true'
            });
        }

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
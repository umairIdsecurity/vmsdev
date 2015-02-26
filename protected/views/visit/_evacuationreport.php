<style>
    .grid-view .summary {
        margin-left: 758px !important;
        margin-top: -63px !important;
    }
</style>
<?php
/* @var $this VisitController */
/* @var $model Visit */
?>

<h1>Evacuation Report</h1>
<?php echo CHtml::button('Export to CSV', array('id' => 'export-button', 'class' => 'greenBtn complete')); ?>
<br>
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
    'filter' => $model,
    'columns' =>
    array(
        
        array(
            'name' => 'visit_status',
            'filter' => false,
            'value' => 'CHtml::link(VisitStatus::$VISIT_STATUS_LIST[$data->visit_status],Yii::app()->createUrl("visit/detail",array("id"=>$data->id)),array("class" =>"statusLink"))',
            'type' => 'raw',
            'header' => 'Status',
        ),
        array(
            'name' => 'visitor_type',
            'value' => 'VisitorType::model()->returnVisitorTypes($data->visitor_type)',
            'filter' => VisitorType::model()->returnVisitorTypes(),
        ),
        array(
            'name' => 'cardcode',
            'header' => 'Card No.',
            'value' => 'CardGenerated::model()->getCardCode($data->card)',
        ),
        
        array(
            'name' => 'firstname',
            'value' => 'Visitor::model()->findByPk($data->visitor)->first_name',
            'header' => 'First Name',
            'filter' => CHtml::textField('Visit[firstname]', '', array('class' => 'filterFirstName')),
        ),
        array(
            'name' => 'lastname',
            'value' => 'Visitor::model()->findByPk($data->visitor)->last_name',
            'header' => 'Last Name',
            'filter' => CHtml::textField('Visit[lastname]', '', array('class' => 'filterLastName')),
        ),
        array(
            'name' => 'company',
            'value' => 'getCompany($data->visitor)',
            'header' => 'Company Name',
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
        //    'value' => 'formatDate($data->date_in)',
        ),
        array(
            'name' => 'time_check_in',
            'type' => 'html',
            'value' => 'formatTime($data->time_check_in)',
        ),
        array(
            'name' => 'date_check_out',
            'type' => 'html',
        //   'value' => 'formatDate($data->date_out)',
        ),
        array(
            'name' => 'time_check_out',
            'type' => 'html',
            'value' => 'formatTime($data->time_check_out)',
        ),
        //'card0.date_expiration',
        array(
            'name' => 'date_out',
            'type' => 'html',
            'header' => 'Date Expiration',
        ),
    ),
));

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
function getCardCode($cardId) {
    if($cardId !=''){
        return CardGenerated::model()->findByPk($cardId)->card_code;
    } else {
        return "";
    }
}

?>
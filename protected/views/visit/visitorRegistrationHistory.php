
<h1>Visitor Registration History</h1>
<?php echo CHtml::button('Export to CSV', array('id' => 'export-button', 'class' => 'greenBtn')); ?>
<br>
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
        <input type="submit" name="yt1" value="Filter" style="margin-top:-10px;height:30px;">  

    <?php $this->endWidget(); ?>
</div>
<?php
$session = new CHttpSession;
$merge = new CDbCriteria;
$merge->addCondition('visit_status ="' . VisitStatus::CLOSED . '"');

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'view-visitor-records-history',
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
            'value' => 'VisitorType::$VISITOR_TYPE_LIST[$data->visitor_type]',
            'filter' => VisitorType::$VISITOR_TYPE_LIST,
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
            'name' => 'date_in',
            'type' => 'html',
          //  'value' => 'formatDate($data->date_in)',
        ),
        array(
            'name' => 'time_in',
            'type' => 'html',
            'value' => 'formatTime($data->time_in)',
        ),
        array(
            'name' => 'date_out',
            'type' => 'html',
         //   'value' => 'formatDate($data->date_out)',
        ),
        array(
            'name' => 'time_out',
            'type' => 'html',
            'value' => 'formatTime($data->time_out)',
        ),
        'card0.date_expiration',
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
            buttonImage: "<?php echo Yii::app()->request->baseUrl;?>/images/calendar.png",
            buttonImageOnly: true,
            buttonText: "Select Date From",
            dateFormat: "dd-mm-yy",
           
        });
        
        $("#Visit_date_check_in_1").datepicker({
            changeMonth: true,
            changeYear: true,
            showOn: "button",
            buttonImage: "<?php echo Yii::app()->request->baseUrl;?>/images/calendar.png",
            buttonImageOnly: true,
            buttonText: "Select Date To",
            dateFormat: "dd-mm-yy",
            
        });
    });
</script>
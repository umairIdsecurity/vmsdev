<?php
/* @var $this VisitController */
/* @var $model Visit */
?>

<h1>Visitor Records</h1>
<?php echo CHtml::button('Export to CSV', array('id' => 'export-button', 'class' => 'greenBtn')); ?>
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
?>
<input type="text" id="totalRecordsCount" value="<?php echo $model->search()->getTotalItemCount(); ?>"/>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'view-export-visitor-records',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' =>
    array(
        array(
            'name' => 'card',
            'header' => 'Card No.',
            'filter' => CHtml::textField('Visit[card]', '', array('class' => 'filterCard')),
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
            'name' => 'visit_status',
            'filter' => VisitStatus::$VISIT_STATUS_LIST,
            'value' => 'CHtml::link(VisitStatus::$VISIT_STATUS_LIST[$data->visit_status],Yii::app()->createUrl("visit/detail",array("id"=>$data->id)),array("class" =>"statusLink"))',
            'type' => 'raw',
            'header' => 'Status',
        ),
       
         array(
            'name' => 'contactemail',
            'value' => 'Visitor::model()->findByPk($data->visitor)->email',
            'header' => 'Contact Email'
        ),
        array(
            'name' => 'contactnumber',
            'value' => 'Visitor::model()->findByPk($data->visitor)->contact_number',
            'header' => 'Contact Number'
        ),
        array(
            'name' => 'visitor_type',
            'value' => 'VisitorType::$VISITOR_TYPE_LIST[$data->visitor_type]',
            'filter' => VisitorType::$VISITOR_TYPE_LIST,
        ),
        
        
        array(
            'name' => 'company',
            'value' => 'getCompany($data->visitor)',
            'header' => 'Company Name',
            'cssClassExpression' => '( getCompany($data->visitor)== "Not Available" ? "errorNotAvailable" : "" ) ',
            'type' => 'raw'
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

function formatDate($date) {
    if ($date == '') {
        return "-";
    } else {
        return Yii::app()->dateFormatter->format("d/MM/y", strtotime($date));
    }
}
?>
<script>
    $(document).ready(function() {
        $('#export-button').on('click', function() {
            $.fn.yiiGridView.export();
        });
        $.fn.yiiGridView.export = function() {
            $.fn.yiiGridView.update('view-export-visitor-records', {
                success: function() {
                    $('#view-export-visitor-records').removeClass('grid-view-loading');
                    window.location = '<?php echo $this->createUrl('exportFileVisitorRecords'); ?>';
                },
                data: $('#view-export-visitor-records').serialize() + '&export=true'
            });
        }

    });
</script>
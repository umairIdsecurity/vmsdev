<style>
    .grid-view .summary {
        margin-left: 760px !important;
        margin-top: -25px !important;
    }
</style>

<h1>Visit History</h1>

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
?>
<input type="text" id="totalRecordsCount" value="<?php echo $model->search()->getTotalItemCount(); ?>"/>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'view-export-visitor-records',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'afterAjaxUpdate' => "
    function(id, data) {
        $('th > .asc').append('<div></div>');
        $('th > .desc').append('<div></div>');
    }",
    'columns' =>
    array(
        array(
            'name' => 'cardnumber',
            'header' => 'Card No.',
            'value'=>  'CardGenerated::model()->getCardCode($data->card)',
        ),
        array(
            'name' => 'firstname',
            'value' => 'getFirstname($data->visitor)',
            'header' => 'First Name',
            'filter' => CHtml::textField('Visit[firstname]', '', array('class' => 'filterFirstName')),
        ),
        array(
            'name' => 'lastname',
            'value' => 'getLastname($data->visitor)',
            'header' => 'Last Name',
            'filter' => CHtml::textField('Visit[lastname]', '', array('class' => 'filterLastName')),
        ),
        array(
            'name' => 'visit_status',
            'filter' => VisitStatus::$VISIT_STATUS_LIST,
            'value' => 'CHtml::link(VisitStatus::$VISIT_STATUS_LIST[$data->visit_status],Yii::app()->createUrl("visit/detail",array("id"=>$data->id)),array("class" =>"statusLink"))',
            'type' => 'raw',
            'header' => 'Status',
            'cssClassExpression' => 'changeStatusClass($data->visit_status)',
        ),
        array(
            'name' => 'contactemail',
            'value' => 'getEmail($data->visitor)',
            'header' => 'Contact Email'
        ),
        array(
            'name' => 'contactnumber',
            'value' => 'getContactNumber($data->visitor)',
            'header' => 'Contact Number'
        ),
        array(
            'name' => 'visitor_type',
            'value' => 'VisitorType::model()->returnVisitorType($data->visitor_type)',
            'filter' => VisitorType::model()->returnVisitorTypes(),
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

    $visitor = Visitor::model()->findByPk($id);
    if (isset($visitor)) {
        $company_id = $visitor->company;
    }

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

function getFirstname($id) {
    $visitor = Visitor::model()->findByPk($id);
    if (isset($visitor)) {
        return $visitor->first_name;
    }
    return "";
}

function getLastname($id) {
    $visitor = Visitor::model()->findByPk($id);
    if (isset($visitor)) {
        return $visitor->last_name;
    }
    return "";
}

function getEmail($id) {
    $visitor = Visitor::model()->findByPk($id);
    if (isset($visitor)) {
        return $visitor->email;
    }
    return "";
}

function getContactNumber($id) {
    $visitor = Visitor::model()->findByPk($id);
    if (isset($visitor)) {
        return $visitor->contact_number;
    }
    return "";
}

function formatTime($time) {
    if ($time == '' || $time == '00:00:00') {
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

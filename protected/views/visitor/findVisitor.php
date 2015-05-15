<style>
    .summary{
        display:none !important;
    }

    #findvisitor-grid_c0 {
        min-width: 12px !important;
    }
</style>
<?php
$session = new CHttpSession;
/* @var $this VisitorController */
/* @var $model Visitor */
$visitorName = $_GET['id'];

if (isset($_GET['tenant_agent']) && $_GET['tenant_agent'] != '') {
    $tenant_agent = 'tenant_agent="' . $_GET['tenant_agent'] . '" and';
} else {
    $tenant_agent = '(tenant_agent IS NULL or tenant_agent =0 or tenant_agent="") and';
}
$model = new Visitor;
$criteria = new CDbCriteria;
$tenant = '';
if($_GET['tenant'] && $_GET['tenant']!=''){
  $tenant = 'tenant='.$_GET['tenant'].' AND ';
}else{
    $tenant = '';
}

$criteria->addCondition($tenant. $tenant_agent . ' (CONCAT(first_name," ",last_name) like "%' . $visitorName . '%" or first_name like "%' . $visitorName . '%" or last_name like "%' . $visitorName . '%" or email like "%' . $visitorName . '%")');

$model->unsetAttributes();

$customDataProvider = new CActiveDataProvider($model, array(
    'criteria' => $criteria,
        ));

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'findvisitor-grid',
    'dataProvider' => $customDataProvider,
    'afterAjaxUpdate' => "
    function(id, data) {
        $('th > .asc').append('<div></div>');
        $('th > .desc').append('<div></div>');
    }",
    'columns' => array(
        array(
            'header' => '',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:center;width:12px;'),
            'value' => '($data->profile_type == Visitor::PROFILE_TYPE_VIC) ? "<img style=\"width: 25px\" src=\"" . Yii::app()->controller->assetsBase . "/images/corporate-visitor-icon.png\"/>" : "<img style=\"width: 25px\" src=\"" . Yii::app()->controller->assetsBase . "/images/asic-visitor-icon.png\"/>" ',
        ),
        array(
            'name' => 'first_name',
            'filter' => false
        ),
        'last_name',
        array(
            'header' => 'Company',
            'filter' => false,
            'value' => '$data->getCompanyName()'
        ),
        array(
            'header' => 'Action',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:center', 'class' => 'findVisitorButtonColumn'),
            'value' => '(checkIfanActiveVisitExists($data->id)=="0")? displaySelectVisitorButton($data):returnVisitorDetailLink($data->id)',
        ),
    ),
));

function checkIfanActiveVisitExists($visitorId) {
    $results = Visit::model()->countByAttributes(array("visitor" => $visitorId, "visit_status" => "1"));
    return $results;
}

function displaySelectVisitorButton($visitorData) {
    return CHtml::link("Select Visitor", "#", array(
                "id" => $visitorData["id"],
                "onclick" => "parent.closeAndPopulateField({$visitorData['id']})",
                    )
    );
}

function returnVisitorDetailLink($visitorId) {
    $visit_id = Visit::model()->find("visitor='" . $visitorId . "' and visit_status=1")->id;
    $url = '/index.php?r=visit/detail&id=' . $visit_id;
    return '<span style="font-size:12px;">Status: <a class="linkToVisitorDetailPage" href="' . $url . '" style="display:inline;text-decoration:underline !important;">Active</a></span>';
}
?>
<script>
    $(function() {
        $(".linkToVisitorDetailPage").click(function(e) {
            e.preventDefault();
            var addressValue = $(this).attr("href");
            window.top.location = addressValue;
        });
    });
</script>

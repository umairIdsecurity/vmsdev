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


$conditionString = $tenant. $tenant_agent . ' (CONCAT(first_name," ",last_name) like "%' . $visitorName
                    . '%" or first_name like "%' . $visitorName
                    . '%" or last_name like "%' . $visitorName
                    . '%" or email like "%' . $visitorName
                    . '%" or identification_document_no LIKE "%' . $visitorName
                    . '%" or identification_alternate_document_no1 LIKE "%' . $visitorName
                    . '%" or identification_alternate_document_no2 LIKE "%' . $visitorName
                    . '%")';

if (isset($_GET['cardType']) && $_GET['cardType'] > CardType::CONTRACTOR_VISITOR) {
    $conditionString .= ' AND profile_type = "' . Visitor::PROFILE_TYPE_VIC . '" ';
} else {
    $conditionString .= ' AND profile_type = "' . Visitor::PROFILE_TYPE_CORPORATE . '" ';
}


$criteria->addCondition($conditionString);

$model->unsetAttributes();

$customDataProvider = new CActiveDataProvider($model, array(
    'criteria' => $criteria,
        ));

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'findvisitor-grid-1',
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
            'value' => '$data->getVisitorProfileIcon()',
        ),
        array(
            'name' => 'first_name',
            'filter' => false
        ),
        'last_name',
        array(
            'header' => 'Company',
            'filter' => false,
            'value' => 'isset($data->getCompany()->name) ? $data->getCompany()->name : "NO COMPANY"'
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
    $visit =  Visit::model()->findByAttributes(array('visitor'=>$visitorId,'visit_status'=>1));
    if($visit){
        $url = Yii::app()->baseUrl.'/index.php?r=visit/detail&id=' . $visit->id;
    }
   
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

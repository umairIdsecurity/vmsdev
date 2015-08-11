<style>
    .summary{
        display:none !important;
    }

    #findvisitor-grid_c0 {
        min-width: 12px !important;
    }
</style>
<?php
Yii::app()->clientScript->scriptMap['jquery.js']=false;
$session = new CHttpSession;
/* @var $this VisitorController */
/* @var $model Visitor */
$visitorName = $_GET['id'];

if (isset($_GET['tenant_agent']) && $_GET['tenant_agent'] != '') {
    $tenant_agent = "tenant_agent=" . $_GET["tenant_agent"] . " and";
} 

else {
    //$tenant_agent = "(tenant_agent IS NULL or tenant_agent =0 or tenant_agent='') and";
    $tenant_agent = "";
}
$model = new Visitor;
$criteria = new CDbCriteria;
$tenant = '';
//if($_GET['tenant'] && $_GET['tenant']!=''){
//  $tenant = 'tenant='.$_GET['tenant'].' AND ';
//}else{
//    $tenant = '';
//}

$tenant = 'tenant='.Yii::app()->user->tenant.' AND ';
$conditionString = $tenant. $tenant_agent . " (CONCAT(first_name,' ',last_name) like '%" . $visitorName
                 . "%' or first_name like '%" . $visitorName
                 . "%' or last_name like '%" . $visitorName
                 . "%' or email like '%" . $visitorName
                 . "%' or identification_document_no LIKE '%" . $visitorName
                 . "%' or identification_alternate_document_no1 LIKE '%" . $visitorName
                 . "%' or identification_alternate_document_no2 LIKE '%" . $visitorName
                 . "%')";

if (isset($_GET['cardType']) && $_GET['cardType'] > CardType::CONTRACTOR_VISITOR) {
    $conditionString .= " AND (profile_type = '" . Visitor::PROFILE_TYPE_VIC . "' OR profile_type = '". Visitor::PROFILE_TYPE_ASIC ."')";
    // $conditionString .= " AND profile_type = '" . Visitor::PROFILE_TYPE_VIC . "' ";

} else {
    $conditionString .= " AND profile_type = '" . Visitor::PROFILE_TYPE_CORPORATE . "'";
}
$conditionString .= " AND is_deleted = '0'";


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
            'header'      => '',
            'type'        => 'raw',
            'htmlOptions' => array('style' => 'text-align:center;width:12px;'),
            'value'       => '$data->getVisitorProfileIcon()',
        ),
        array(
            'name'   => 'first_name',
            'filter' => false
        ),
        'last_name',
        array(
            'header' => 'Company',
            'filter' => false,
            'value'  => 'Company::model()->getCompanyName($data->company)'
        ),
        array(
            'header'      => 'Action',
            'type'        => 'raw',
            'htmlOptions' => array('style' => 'text-align:center', 'class' => 'findVisitorButtonColumn'),
            'value'       => '(checkIfanActiveVisitExists($data->id)=="0")? displaySelectVisitorButton($data):returnVisitorDetailLink($data->id)',
        ),
    ),
));


function checkIfanActiveVisitExists($visitorId) {
    $results = Visit::model()->countByAttributes(array("visitor" => $visitorId, "visit_status" => VisitStatus::ACTIVE));
    if ($results == 0) {
        $results = Visit::model()->countByAttributes(array("visitor" => $visitorId, "visit_status" => VisitStatus::AUTOCLOSED));
    }
    return $results;
}

function displaySelectVisitorButton($visitorData) {
    return CHtml::link("Select Visitor", "javascript:void(0)", array(
                "id" => $visitorData["id"],
                "onclick" => "parent.closeAndPopulateField({$visitorData['id']})",
                    )
    );
}

function returnVisitorDetailLink($visitorId) {
    $criteria = new CDbCriteria;
    $criteria->order = 'id DESC';
    $visit = Visit::model()->findByAttributes(array('visitor' => $visitorId), $criteria);
    //$visit = Yii::app()->db->createCommand("SELECT * FROM visit WHERE visitor = ".$visitorId." ORDER BY ' DESC")->queryRow();
    if (!empty($visit)) {
        $url = Yii::app()->baseUrl.'/index.php?r=visit/detail&id=' . $visit['id'];
    }

    if (isset($url)) {
        $status = VisitStatus::$VISIT_STATUS_LIST[$visit['visit_status']];
        return '<span style="font-size:12px;">Status: <a class="linkToVisitorDetailPage" href="' . $url . '" style="display:inline;text-decoration:underline !important;">' . $status . '</a></span>';
    }
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

<style>
    .summary{
        display:none !important;
    }
</style>
<?php
$session = new CHttpSession;
/* @var $this VisitorController */
/* @var $model Visitor */
$visitorName = $_GET['id'];

$model = new Visitor;
$criteria = new CDbCriteria;
$criteria->addCondition('CONCAT(first_name," ",last_name) like "%' . $visitorName . '%" or first_name like "%' . $visitorName . '%" or last_name like "%' . $visitorName . '%"');

$model->unsetAttributes();

$customDataProvider = new CActiveDataProvider($model, array(
    'criteria' => $criteria,
        ));

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'findvisitor-grid',
    'dataProvider' => $customDataProvider,
    'columns' => array(
        array(
            'name' => 'first_name',
            'filter' => false
        ),
        'last_name',
        'email',
        'contact_number',
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

<?php
/* @var $this VisitorController */
/* @var $model Visitor */
$search = $_GET['id'];
?>

<?php
$model = new Visitor;
$criteria = new CDbCriteria;
$criteria->addCondition('CONCAT(first_name," ",last_name) like "%' . $search . '%" or first_name like "%' . $search . '%" or last_name like "%' . $search . '%"');

$model->unsetAttributes();

$d = new CActiveDataProvider($model, array(
    'criteria' => $criteria,
        ));

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'findvisitor-grid',
    'dataProvider' => $d,
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

function checkIfanActiveVisitExists($visitor_id) {
    $results = Visit::model()->countByAttributes(array("visitor" => $visitor_id, "visit_status" => "1"));
    return $results;
}

function displaySelectVisitorButton($data) {
    return CHtml::link("Select Visitor", "#", array(
                "id" => $data["id"],
                "onclick" => "parent.closeAndPopulateField({$data['id']})",
                    )
    );
}

function returnVisitorDetailLink($visitor_id) {
    $visit_id = Visit::model()->find("visitor='" . $visitor_id . "' and visit_status=1")->id;
    $url = '/index.php?r=visit/detail&id=' . $visit_id;
    return '<a class="linkToVisitorDetailPage" href="'.$url.'" >Visitor has an active visit</a>';
}
?>
<script>
    $(function() {
        $(".linkToVisitorDetailPage").click(function(e) {
            e.preventDefault();
            var addressValue = $(this).attr("href");
            window.top.location =addressValue;
        });
    });
</script>

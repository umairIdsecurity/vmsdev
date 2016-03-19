
<?php
/* @var $this VisitController */
/* @var $model Visit */
?>

<h1>Manage Visits</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'visit-grid',
    'dataProvider' => $model->search(),
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
            'name'=>'visitor',
            'value'=>'getVisitorFullName($data->visitor)',
            'filter'=>CHtml::activeTextField($model, 'visitor', array('placeholder'=>'Visitor')),
        ),
        array(
            'name' => 'card_type',
            'value' => 'getCartTypeByType($data->card_type)',
            'filter' => CardType::$CARD_TYPE_LIST,
        ),
        array(
            'name' => 'visitor_type',
            'value' => 'getVisitorTypeById($data->visitor_type)',
            'filter' => VisitorType::model()->returnVisitorTypes(),
        ),
        array(
            'name' => 'reason',
            'value' => 'getVisitReasonById($data->reason)',
            'filter' => getVisitReason(),
        ),
        array(
            'name' => 'visitor_status',
            'value' => 'VisitorStatus::$VISITOR_STATUS_LIST[$data->visitor_status]',
            'filter' => VisitorStatus::$VISITOR_STATUS_LIST,
        ),
        array(
            'name' => 'visit_status',
            'value' => 'VisitStatus::$VISIT_STATUS_LIST[$data->visit_status]',
            'filter' => VisitStatus::$VISIT_STATUS_LIST,
            'cssClassExpression' => 'changeStatusClass($data->visit_status)',
        ),
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}',
            'buttons' => array(
                'update' => array(//the name {reply} must be same
                    'label' => 'Edit', // text label of the button
                    'imageUrl' => false, // image URL of the button. If not set or false, a text link is used, The image must be 16X16 pixels
                    'url' => 'Yii::app()->createUrl("visit/detail", array("id"=>$data->id))',
                    ),
                'delete' => array(//the name {reply} must be same
                    'label' => 'Delete', // text label of the button
                    'imageUrl' => false, // image URL of the button. If not set or false, a text link is used, The image must be 16X16 pixels
                
                ),
            ),
        ),
        
    ),
));

function getCartTypeByType($type = 0){
    if(isset($type) && $type && array_key_exists($type,CardType::$CARD_TYPE_LIST)){
        return CardType::$CARD_TYPE_LIST[$type];

    }
    return 'Card Type';
}

function getVisitorFullName($id){
    $visitor =Visitor::model()->findByPk($id);
    if($visitor)
    return $visitor->first_name.' '.$visitor->last_name;
    return '';
}
function getVisitReasonById($id)
{
    $reason1 = VisitReason::model()->findByPk($id);
    if ($reason1) {
        return $reason1->reason;
    }
    return '';
}
function getVisitorTypeById($id)
{
    $vstype = VisitorType::model()->findByPk($id);
    if ($vstype) {
        return 'Visitor Type: '.$vstype->name;
    }
    return '';
}
function getVisitReason(){
    $data = CHtml::listData(VisitReason::model()->findAll(array('order' => 'reason ASC')), 'id', 'reason');
    if($data)
        return array(""=>'Reason')+$data;
    return array(""=>'Reason');
}


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

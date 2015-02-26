
<?php
/* @var $this VisitController */
/* @var $model Visit */
?>

<h1>Manage Visits</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'visit-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' =>
    array(
        array(
            'name'=>'visitor',
            'value'=>'getVisitorFullName($data->visitor)',
            
        ),
        array(
            'name' => 'card_type',
            'value' => 'CardType::$CARD_TYPE_LIST[$data->card_type]',
            'filter' => CardType::$CARD_TYPE_LIST,
        ),  
        array(
            'name' => 'visitor_type',
            'value' => 'VisitorType::model()->returnVisitorTypes($data->visitor_type)',
            'filter' => VisitorType::model()->returnVisitorTypes(),
        ),
        array(
            'name' => 'reason',
            'value' => 'VisitReason::model()->findByPk($data->reason)->reason',
            'filter' => CHtml::listData(VisitReason::model()->findAll(array('order' => 'reason ASC')), 'id', 'reason'),
            
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

function getVisitorFullName($id){
    $visitor =Visitor::model()->findByPk($id);
    return $visitor->first_name.' '.$visitor->last_name;
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


<?php
/* @var $this VisitorController */
/* @var $model Visitor */
?>

<h1>Manage Visitors</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'visitor-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'first_name',
        'last_name',
        'email',
        'contact_number',
        array(
            'name' => 'id',
            'type' => 'raw',
            'value' => 'CHtml::hiddenField("visitorExists1".$data->id,isVisitorExists($data->id))',
            'visible' => true,
            'cssClassExpression' => '"hidden"',
            'filter' =>false,
        ),
        array(
            'name' => 'id',
            'type' => 'raw',
            'value' => 'CHtml::hiddenField("visitorExists2".$data->id,isVisitorExistsInClosedVisits($data->id))',
            'visible' => true,
            'cssClassExpression' => '"hidden"',
            'filter' =>false,
        ),
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}',
            'buttons' => array(
                'update' => array(//the name {reply} must be same
                    'label' => 'Edit', // text label of the button
                    'imageUrl' => false, // image URL of the button. If not set or false, a text link is used, The image must be 16X16 pixels
                    'url' => 'Yii::app()->createUrl("visitor/update", array("id"=>$data->id))',
                ),
                'delete' => array(//the name {reply} must be same
                    'label' => 'Delete', // text label of the button
                    'imageUrl' => false, // image URL of the button. If not set or false, a text link is used, The image must be 16X16 pixels
                    'url' => 'Yii::app()->controller->createUrl("visitor/delete",array("id"=>$data->id))',
                    'options' => array(// this is the 'html' array but we specify the 'ajax' element
                       'confirm' => "Are you sure you want to delete this item?",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => "js:$(this).attr('href')", // ajax post will use 'url' specified above
                            'success' => 'function(data){
                                
                                                if(data == "true"){
                                                    $.fn.yiiGridView.update("visitor-grid");   
                                                    return false;
                                                }else{
                                                    var urlAddress = this.url;
                                                    var urlAddressId = urlAddress.split("=");
                                                    var x;
                                                    if($("#visitorExists1"+  urlAddressId["2"]).val() == 1){
                                                        alert("This record has an open visit and must be cancelled before deleting.");
                                                        return false;
                                                    } else if($("#visitorExists2"+  urlAddressId["2"]).val() == 1){
                                                        if (confirm("This Visitor Record has visit data recorded. Do you wish to delete this visitor record and its visit history?") == true) {
                                                            $.ajax({
                                                                type: "POST",
                                                                url: "'. Yii::app()->createUrl('visit/deleteAllVisitWithSameVisitorId&id=') .'" +urlAddressId["2"] ,
                                                                success: function(r) {
                                                                    $.fn.yiiGridView.update("visitor-grid");
                                                                    return false;
                                                                }
                                                            });
                                                        } 
                                                        return false;
                                                    }
                                                    
                                                                
                                                }
                                            }',
                        ),
                    ),
                    
                ),
            ),
        ),
    ),
));

function isVisitorExists($visitorId) {
    return Visit::model()->exists('is_deleted = 0 and visitor =' . $visitorId . ' and (visit_status=' . VisitStatus::PREREGISTERED . ' or visit_status=' . VisitStatus::ACTIVE . ')');
}

function isVisitorExistsInClosedVisits($visitorId) {
    return Visit::model()->exists('is_deleted = 0 and visitor =' . $visitorId . ' and (visit_status=' . VisitStatus::CLOSED . ' or visit_status=' . VisitStatus::EXPIRED . ')');
}
?>

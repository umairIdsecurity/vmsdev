<?php

/* @var $this VisitorController */
/* @var $model Visitor */
?>

<h1><?php echo strtoupper(Yii::app()->request->getParam('vms')) ?> Visitors</h1>
<?php    
foreach (Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div><br>";
 }
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'visitor-grid',
    'dataProvider' => $model->search(),
    'enableSorting' => false,
    'hideHeader'=>true,
    'filter' => $model,
    'afterAjaxUpdate' => "
    function(id, data) {
        $('th > .asc').append('<div></div>');
        $('th > .desc').append('<div></div>');
    }",
    'columns' => array(
        array(
            'name' => 'first_name',
            'filter'=>CHtml::activeTextField($model, 'first_name', array('placeholder'=>'First Name')),
        ),
        array(
            'name' => 'last_name',
            'filter'=>CHtml::activeTextField($model, 'last_name', array('placeholder'=>'Last Name')),
        ),
        array(
            'name' => 'email',
            'filter'=>CHtml::activeTextField($model, 'email', array('placeholder'=>'Email Address')),
        ),
        array(
            'name' => 'contact_number',
            'filter'=>CHtml::activeTextField($model, 'contact_number', array('placeholder'=>'Mobile Number')),
        ),
        array(
            'name'   => 'company',
            'filter' => CHtml::activeTextField($model, 'company', array('placeholder' => 'Company')),
            'value'  => '!empty($data->company0->name) ? $data->company0->name : ""'
        ),
        array(
            'name' => 'profile_type',
            'filter' => CHtml::activeTextField($model, 'profile_type', array('placeholder' => 'Visitor Profile Type')),
        ),
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
                    'url' => 'Yii::app()->createUrl("visitor/update", array("id"=>$data->id, "vms"=>Yii::app()->request->getParam("vms")))',
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

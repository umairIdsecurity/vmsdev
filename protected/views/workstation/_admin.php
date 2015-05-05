
<?php
/* @var $this WorkstationController */
/* @var $model Workstation */
?>

<h1>Workstations</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'workstation-grid',
    'dataProvider' => $model->search(),
    'enableSorting' => false,
    //'hideHeader'=>true,
    //'filter' => $model,
    'afterAjaxUpdate' => "
    function(id, data) {
        $('th > .asc').append('<div></div>');
        $('th > .desc').append('<div></div>');
    }",
    'columns' => array(
        array(
            'name' => 'name',
            'header' => 'Workstation',
            'htmlOptions'=>array('width'=>'180px'),
        ),

        array(
            'name' => 'moduleCorporate',
            'header' => '',
            'type'=>'raw',
            'value' => '$data->getCorporateCardType($data->id)',
            /*'htmlOptions'=>array('width'=>'300px' , 'height'=>'119px'),*/
            'headerHtmlOptions' => array('class'=>'header-corporate')
        ),

        array(
            'name' => 'moduleVic',
            'type'=>'raw',
            'header' => '',
            'value' => '$data->getCorporateVic($data->id)',
            /*'htmlOptions'=>array('width'=>'400px' , 'height'=>'119px'),*/
            'headerHtmlOptions' => array('class'=>'header-vic')
        ),

        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}',
            'buttons' => array(
                'update' => array(//the name {reply} must be same
                    'label' => 'Edit', // text label of the button
                    'imageUrl' => false, // image URL of the button. If not set or false, a text link is used, The image must be 16X16 pixels
                ),
                'delete' => array(//the name {reply} must be same
                    'label' => 'Delete', // text label of the button
                    'imageUrl' => false, // image URL of the button. If not set or false, a text link is used, The image must be 16X16 pixels
                    'url' => 'Yii::app()->controller->createUrl("workstation/delete",array("id"=>$data->id))',
                    'options' => array(// this is the 'html' array but we specify the 'ajax' element
                        'confirm' => "Are you sure you want to delete this item?",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => "js:$(this).attr('href')", // ajax post will use 'url' specified above
                            'success' => 'function(data){
                                
                                                if(data == "true"){
                                                    $.fn.yiiGridView.update("workstation-grid");   
                                                    return false;
                                                }else{
                                                    var urlAddress = this.url;
                                                    var urlAddressId = urlAddress.split("=");
                                                    var x;
                                                    if($("#workstationExists1"+  urlAddressId["2"]).val() == 1){
                                                        alert("An exisitng user is linked to this workstation. Please remove workstation assignment first.");
                                                        return false;
                                                    }  
                                                    else if($("#visitExists2"+  urlAddressId["2"]).val() == 1){
                                                        alert("An exisitng visit is linked to this workstation. Please delete visit first.");
                                                        return false;
                                                    }  
                                                    return false;
                                                }
                                            }',
                        ),
                    ),
                ),
            ),
        ),
    ),
));
function getCorporateModule(){

    $cards = CardType::model()->findAllByAttributes(
        array('module'=>1)
    );

    foreach($cards as $card){
        $card->name;
    }
    return "hello";
}
function isWorkstationExists($workstationId) {
    return UserWorkstations::model()->exists('workstation="' . $workstationId . '"');
}

function isVisitExistsInClosedVisits($workstationId) {
    return Visit::model()->exists('workstation="' . $workstationId . '"');
}


?>

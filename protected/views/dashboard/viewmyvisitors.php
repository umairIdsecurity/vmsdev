<?php
/* @var $this VisitController */
/* @var $model Visit */

?>
<h1>Preregistered Visitors</h1>
<br>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'visit-gridDashboard',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' =>
    array(
        array(
            'name' => 'visit_status',
            'filter' => VisitStatus::$VISIT_STATUS_LIST,
            'value' => 'CHtml::link(VisitStatus::$VISIT_STATUS_LIST[$data->visit_status],Yii::app()->createUrl("visit/detail",array("id"=>$data->id)),array("class" =>"statusLink"))',
            'type'=>'raw',
            'header'=>'Status',
            ),
        
        'date_in',
        array(
            'name' => 'card',
            'header' =>'Card No.'
        ),
        array(
            'name' => 'firstname',
            'value' => 'Visitor::model()->findByPk($data->visitor)->first_name',
            'header' => 'First Name'
        ),
        array(
            'name' => 'lastname',
            'value' => 'Visitor::model()->findByPk($data->visitor)->last_name',
            'header' => 'Last Name'
        ),
        array(
            'name' => 'company',
            'value' => 'Company::model()->findByPk(Visitor::model()->findByPk($data->visitor)->company)->name',
            'header' => 'Company'
        ),
        array(
            'name' => 'contactnumber',
            'value' => 'Visitor::model()->findByPk($data->visitor)->contact_number',
            'header' => 'Contact Number'
        ),
        array(
            'name' => 'contactemail',
            'value' => 'Visitor::model()->findByPk($data->visitor)->email',
            'header' => 'Contact Email'
        ),
        'time_in',
        'date_out',
       
        
    ),
));

function getVisitorFullName($id){
    $visitor =Visitor::model()->findByPk($id);
    return $visitor->first_name.' '.$visitor->last_name;
}
?>

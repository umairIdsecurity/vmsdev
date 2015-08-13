<style>
    .summary{
        display:none !important;
    }
</style>
<?php
    Yii::app()->clientScript->scriptMap['jquery.js']=false;
    $dataProvider = new CActiveDataProvider($model, array(
        'criteria' => $criteria,
    ));
if ($visitorType != VisitorType::PATIENT_VISITOR) {
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'findHost-grid-1',
        'dataProvider' => $dataProvider,
        'afterAjaxUpdate' => "
    function(id, data) {
        $('th > .asc').append('<div></div>');
        $('th > .desc').append('<div></div>');
    }",
        'columns' => array(
            array(
                'name' => 'first_name',
                'filter' => false
            ),
            'last_name',
            [
                'name' => 'company',
                'filter' => false,
                'value' => '$data->getCompanyForLogVisit()? $data->getCompanyForLogVisit()->name : "NO COMPANY"'
            ],
            array(
                'header' => 'Action',
                'type' => 'raw',
                'htmlOptions' => array('style' => 'text-align:center', 'class' => 'findHostButtonColumn'),
                'value' => function($data) use ($hostTitle) {

                    return CHtml::link('Select '.$hostTitle, 'javascript:void(0)', array(
                                'id' => $data['id'],
                                'onclick' => "parent.populateFieldHost({$data['id']})",
                                'class' => "actionForward"
                                    )
                    );
                },
            ),
        ),
    ));
}
?>

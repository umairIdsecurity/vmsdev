<?php

/* @var $this VisitorController */
/* @var $model Visitor */
$visitorName = $_GET['id'];
$visitorType = $_GET['visitortype'];

$model = new User;
$criteria = new CDbCriteria;
$criteria->addCondition('role="9" and (CONCAT(first_name," ",last_name) like "%' . $visitorName . '%" or first_name like "%' . $visitorName . '%" or last_name like "%' . $visitorName . '%")');

$model->unsetAttributes();

$customDataProvider = new CActiveDataProvider($model, array(
    'criteria' => $criteria,
        ));
if ($visitorType != VisitorType::PATIENT_VISITOR) {
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'findHost-grid',
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
                'htmlOptions' => array('style' => 'text-align:center', 'class' => 'findHostButtonColumn'),
                'value' => function($data) {
            return CHtml::link('Select Host', '#', array(
                        'id' => $data['id'],
                        'onclick' => "parent.populateFieldHost({$data['id']})",
                            )
            );
        },
            ),
        ),
    ));
}
?>

<?php

/* @var $this VisitorController */
/* @var $model Visitor */
$search = $_GET['id'];
$visitor_type = $_GET['visitortype'];
?>

<?php

if ($visitor_type != VisitorType::PATIENT_VISITOR) {
    $model = new User;
    $criteria = new CDbCriteria;
    $criteria->addCondition('role="9" and (CONCAT(first_name," ",last_name) like "%' . $search . '%" or first_name like "%' . $search . '%" or last_name like "%' . $search . '%")');
} else {
    $model = new Patient;
    $criteria = new CDbCriteria;
    $criteria->addCondition('name like "%' . $search . '%"');
}


$model->unsetAttributes();

$d = new CActiveDataProvider($model, array(
    'criteria' => $criteria,
        ));
if ($visitor_type != VisitorType::PATIENT_VISITOR) {
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'findHost-grid',
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
                'htmlOptions' => array('style' => 'text-align:center'),
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
} else {

    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'findpatient-grid',
        'dataProvider' => $d,
        'columns' => array(
            'name',
            
            array(
                'header' => 'Action',
                'type' => 'raw',
                'htmlOptions' => array('style' => 'text-align:center'),
                'value' => function($data) {
            return CHtml::link('Select Patient', '#', array(
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

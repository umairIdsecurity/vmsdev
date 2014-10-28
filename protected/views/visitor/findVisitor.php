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
            'htmlOptions' => array('style' => 'text-align:center', 'class'=>'findVisitorButtonColumn'),
            'value' => function($data) {
        return CHtml::link('Select Visitor', '#', array(
                    'id' => $data['id'],
                    'onclick' => "parent.closeAndPopulateField({$data['id']})",
                        )
        );
    },
        ),
    ),
));
?>

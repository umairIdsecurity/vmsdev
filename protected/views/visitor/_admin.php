
<?php
/* @var $this VisitorController */
/* @var $model Visitor */
?>

<h1>Manage Visitors</h1>
<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>
 
<?php if(Yii::app()->user->hasFlash('error')):?>
    <div class="flash-error">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>
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
                ),
            ),
        ),
    ),
));
?>

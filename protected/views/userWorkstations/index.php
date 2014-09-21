
<?php echo CHtml::beginForm(); ?>
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>
<input type='hidden' value='<?php echo $_GET['id']; ?>' name='userId'>
<?php
foreach (Yii::app()->user->getFlashes() as $key => $message) {
    echo '<div class="flash-' . $key . '" style="width:450px !important;">' . $message . "</div>\n";
}
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'user_workstationsGrid',
    'dataProvider' => Workstation::model()->search(),
    'template' => "{items}",
    'columns' => array(
        array('name' => 'name', 'header' => 'Name'),
        array('name' => 'location', 'header' => 'Location'),
        array('class' => 'CCheckBoxColumn',
            'id' => 'cbColumn',
            'selectableRows' => 2,
            'checked' => '(Workstation::model()->getWorkstations(' . $_GET['id'] . ',$data->id)==true)?(1):(0)',
            'htmlOptions' => array("onclick" => 'getId()'),
        ),
        
    // ), 
    ),
));
?>

<div>
    <?php echo CHtml::submitButton('Save Changes', array('name' => 'ApproveButton', 'id' => 'btnSubmit')); ?>

</div>
<?php
$connection = Yii::app()->db;
$sql = "select id from workstation";
$command = $connection->createCommand($sql);
$row = $command->query();
foreach ($row as $user) {
    foreach ($user as $v) {
        $sql = "select id from user_workstation where user=105 and workstation=$v";
        $command = $connection->createCommand($sql);
        $row = $command->query();
        foreach ($row as $user) {
            foreach ($user as $v) {
                //   echo $v;
            }
        }
    }
}
?>
<?php echo CHtml::endForm(); ?>
            
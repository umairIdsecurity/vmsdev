
<?php
$session = new CHttpSession;
echo CHtml::beginForm();
?>
<?php
foreach (Yii::app()->user->getFlashes() as $key => $message) {
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
if ($session['role'] != Roles::ROLE_SUPERADMIN) {
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
        ),
    ));
} else {
    ?>
    <form method="post" action="/index.php?r=userWorkstations/index&amp;id=<?php echo $_GET['id'] ?>"><input type="hidden" name="userId" value="<?php echo $_GET['id'] ?>">

        <div class="grid-view" id="user_workstationsGrid">
            <table class="items table-striped" >
                <thead>
                    <tr>
                        <th id="user_workstationsGrid_c0" style="text-align:center;">
                            <a href="/index.php?r=userWorkstations/index&amp;id=<?php echo $_GET['id']; ?>&amp;Workstation_sort=name" class="sort-link">Name</a>
                        </th>
                        <th id="user_workstationsGrid_c1" style="text-align:center;">
                            <a href="/index.php?r=userWorkstations/index&amp;id=<?php echo $_GET['id']; ?>&amp;Workstation_sort=location" class="sort-link">Location</a>
                        </th>
                        <th id="cbColumn" class="checkbox-column" style="text-align:center;"><input type="checkbox" id="cbColumnAll" name="cbColumn_all">
                        </th>
                    </tr>
                </thead>
                <tbody> <?php
                    $connection = Yii::app()->db;

                    $sqlA = "select role from `user` where id='" . $_GET['id'] . "'";
                    $command = $connection->createCommand($sqlA);
                    $rowA = $command->queryRow();
                    if ($rowA['role'] == Roles::ROLE_OPERATOR) {
                        $queryCondition = "WHERE workstation.tenant=user.tenant and workstation"
                                . ".tenant_agent IS NULL";
                    } else {
                        $queryCondition = "WHERE workstation.tenant=user.tenant and workstation"
                                . ".tenant_agent = user.tenant_agent";
                    }
                    $sql = "SELECT workstation.id as id,workstation.location as location,workstation.name as name FROM workstation
                            LEFT JOIN `user` ON user.`id` = " . $_GET['id'] . " " . $queryCondition;
                    $command = $connection->createCommand($sql);
                    $row = $command->query();
                    foreach ($row as $user) {
                        ?> 
                        <tr class="odd">
                            <td style="text-align:center;"><?php echo $user['name'] ?></td>
                            <td style="text-align:center;"><?php echo $user['location'] ?></td>
                            <td style="text-align:center;" onclick="getId()">
                                <input type="checkbox" name="cbColumn[]"  <?php
                                (Workstation::model()->getWorkstations($_GET['id'], $user['id']) == true) ? ( $cbVal = 'checked') : ( $cbVal = '');
                                echo $cbVal;
                                ?> id="cbColumn_0" value="<?php echo $user['id'] ?>">
                            </td>
                        </tr>

                        <?php
                    }
                    ?>
                </tbody>
            </table>

        </div>

        <?php } ?>
    <div>
<?php echo CHtml::submitButton('Save Changes', array('name' => 'ApproveButton', 'id' => 'btnSubmit')); ?>

    </div>

<?php echo CHtml::endForm(); ?>
    <script>
        $(document).ready(function() {

            $("#cbColumnAll").on("click", function() {
                var all = $(this);
                $('input:checkbox').each(function() {
                    $(this).prop("checked", all.prop("checked"));
                });
            });
        });
    </script>
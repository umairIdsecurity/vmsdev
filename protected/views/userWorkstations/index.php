
<?php
$session = new CHttpSession;
echo CHtml::beginForm();
?>

<input type='hidden' value='<?php echo $_GET['id']; ?>' name='userId'>
<?php
foreach (Yii::app()->user->getFlashes() as $key => $message) {
    echo '<div class="flash-' . $key . '" style="width:450px !important;">' . $message . "</div>\n";
}
?>

    <form method="post" action="/index.php?r=userWorkstations/index&amp;id=<?php echo $_GET['id'] ?>"><input type="hidden" name="userId" value="<?php echo $_GET['id'] ?>">

        <div class="grid-view superadminSetAccessTable" id="user_workstationsGrid">
            <table class="items table-striped ">
                <thead >
                    <tr>
                        <th id="user_workstationsGrid_c0" style="text-align:center;">
                            <a href="/index.php?r=userWorkstations/index&amp;id=<?php echo $_GET['id']; ?>&amp;Workstation_sort=name" class="sort-link">Name</a>
                        </th>
                        <th id="user_workstationsGrid_c1" style="text-align:center;">
                            <a href="/index.php?r=userWorkstations/index&amp;id=<?php echo $_GET['id']; ?>&amp;Workstation_sort=location" class="sort-link">Location</a>
                        </th>
                        <th id="cbColumn" class="checkbox-column" style="text-align:center;"><input type="checkbox" id="cbColumnAll" name="cbColumn_all"></th>
                        <th style="text-align:center;">Set Primary</th>
                    </tr>
                </thead>
                <tbody> <?php
                    $row = UserWorkstations::model()->getAllUserWorkstationsCanBeEditedBySuperAdmin($_GET['id'],$session['role']);
                    foreach ($row as $user) {
                        ?> 
                        <tr>
                            <td ><?php echo $user['name'] ?></td>
                            <td ><?php echo $user['location'] ?></td>
                            <td style="text-align:center;" onclick="getId()" class="checkboxColumnTd">
                                <input type="checkbox" name="cbColumn[]"  <?php
                                (Workstation::model()->getWorkstations($_GET['id'], $user['id']) == true) ? ( $cbVal = 'checked') : ( $cbVal = '');
                                echo $cbVal." ";

                                if (UserWorkstations::model()->checkIfWorkstationIsPrimaryOfUser($_GET['id'], $user['id']) == true) {
                                    $checked = "checked";
                                    $disabled = "disabled";
                                    $isPrimary = "1";
                                    $label = "Primary";
                                } else {
                                    $checked = "";
                                    $disabled = "";
                                    $isPrimary = "0";
                                    $label="Set Primary";
                                }
                                echo $disabled;
                                ?> id="cbColumn_0" value="<?php echo $user['id'] ?>">
                            </td>
                            <td style="text-align: center;" class="radioButtonTd">

                                <input type="radio" id="setPrimary<?php echo $user['id']; ?>" name="rButtons" class="rButtons"
                                       <?php echo $checked; ?>
                                       />
                                <label for="setPrimary<?php echo $user['id']; ?>" id="setPrimary<?php echo $user['id']; ?>"><?php echo $label; ?></label>
                                <input type="text" style="display:none;" name="radioSetPrimaryInput[<?php echo $user['id']; ?>]" value="<?php echo $isPrimary; ?>"/>

                            </td>
                        </tr>

                        <?php
                    }
                    ?>
                </tbody>
            </table>

        </div>

    <div style="margin-left:374px;">
        <?php echo CHtml::submitButton('Save Changes', array('name' => 'ApproveButton', 'id' => 'btnSubmit')); ?>

    </div>

    <?php echo CHtml::endForm(); ?>
    <script>
        $(".rButtons").click(function() {
            $("input[type='text']").val("0");
            $("label").html("Set Primary");
            $("input[type='checkbox']").prop("disabled", false);

            $(this).closest('td.radioButtonTd').find('input[type=text]').val("1");
            $(this).closest('td.radioButtonTd').find('label').html("Primary");
            $(this).parents('td:eq(0)').prev().find('input[type="checkbox"]').prop("checked", true);
            $(this).parents('td:eq(0)').prev().find('input[type="checkbox"]').prop("disabled", true);
        });

        $("#btnSubmit").click(function() {
            $("input[type='checkbox']").prop("disabled", false);
        });
        
        $(document).ready(function() {
            $("#cbColumnAll").on("click", function() {
                var all = $(this);
                $('input:checkbox').not("[disabled]").each(function() {
                    $(this).prop("checked", all.prop("checked"));
                });
            });
        }
        );
    </script>
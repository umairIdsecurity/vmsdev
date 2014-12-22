<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::app()->name . ' - Select Workstation';

$workstationsList = array();
$arrayCount = count($workstations);
for ($i = 0; $i < $arrayCount; $i++) {
    $workstationsList [$workstations[$i]['id']] = $workstations[$i]['name'];
}
?>
<div style="text-align:center;" id="usercontent">

    <div class="form" >
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'selectworkstation-form',
        ));
        ?>

        <table class="selectworkstation-area" style="padding:12px;">
            <tr>
                <td style="font-size:12px;font-weight: bold;text-align: center">Please select which Workstation you want to access : </td>
            </tr>
            <tr>
                <td style="text-align: center">
                    <select style='font-size:12px;' name='userWorkstation' id='userWorkstation'>
                        <?php
                        foreach ($workstationsList as $key => $value) {
                            echo "<option  value='" . $key . "'>" . $value . "</option>";
                        }
                        ?>
                    </select>
                </td>

            </tr>

            <tr >
                <td style="text-align: center">
                    <button id='submitBtn'>Continue</button>
                    <input type="submit" value="Continue" name="submit" id='submit' style='display: none;'>
                </td>
            </tr>

        </table>


        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>

<script>
    $(document).ready(function() {
        $("#submitBtn").click(function(e) {

            e.preventDefault();
            var workstation = $("#userWorkstation").val();
            if (workstation !='') {
                $("#submit").click();
            }else{
                alert("Please select workstation");
            }
        });
    });
</script>
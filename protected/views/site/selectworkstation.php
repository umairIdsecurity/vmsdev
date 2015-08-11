<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
$session = new CHttpSession;

$this->pageTitle = Yii::app()->name . ' - Please select a workstation';

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
                <td style="font-size:12px;font-weight: bold;text-align: center">Please select your workstation</td>
            </tr>
            <tr>
                <td style="text-align: center">
                    <select style='font-size:12px;' name='userWorkstation' id='userWorkstation'>
                        <?php
                        foreach ($workstationsList as $key => $value) {
                            ?>
                        <option  value='<?php echo $key; ?>' <?php if(checkIfWorkstationIsPrimary($key)){
                                echo "selected";
                            }?>><?php echo $value; ?></option>
                            <?php
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
            
            <!--<tr>
            	<td style="text-align: center">
            		<?php /*if ($addWorkstation) { */?>
            			<a class="addSubMenu" href="<?php /*echo Yii::app()->createUrl('workstation/create'); */?>" ><span>Add Workstation</span></a>
            		<?php /*} */?>
            	</td>
            </tr>-->

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


<?php 
function checkIfWorkstationIsPrimary($workstationId){
    $userWorkstation = UserWorkstations::model()->find("workstation=".$workstationId." and user=".Yii::app()->user->id."");
    if(isset($userWorkstation->is_primary) && $userWorkstation->is_primary ==1){
        return true;
    } else {
        return false;
    }
}
?>
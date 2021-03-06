<?php
/* @var $this CompanyLafPreferencesController */
/* @var $model CompanyLafPreferences */
/* @var $form CActiveForm */
$session = new CHttpSession;
$company = Company::model()->findByPk($session['company']);
?>
<style>
    <?php
    if($company->logo != ''){
    ?>
    #logoDiv #cropImageBtn{
        display: block;
    }
    <?php
    }
    ?>

    #photoPreview2 {
        height: 100% !important;
        width: 100% !important;
        
    }
    
    .photoDiv{
        width:184px !important;
        height:114px !important;;
        margin-bottom:10px;
    }
</style>
<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'company-laf-preferences-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>
    <?php
    foreach (Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
    ?>
    
    <?php echo $form->errorSummary($model); ?>

    <div id="logoDiv">
        <div class="cssButtonDetails">
            <span class="customTitle userpreferencesLogoLabel">Logo</span><br>
            <input id="CompanyLafPreferences_logo" type="text" name="CompanyLafPreferences[logo]" style="display:none;" value="<?php echo $company->logo; ?>">
            <div class="photoDiv companyPhotoDiv" <?php
            if ($company->logo == NULL) {
                echo "style='display:none !important;'";
            }
            ?>>
                     <?php
                     if ($company->logo != NULL) {
                         ?>
                    <img id='photoPreview2' class="companylogopreview" src="data:image;base64,<?php echo Photo::model()->returnLogoPhotoRelative($company->logo); ?>"/>
                <?php } else { ?>
                    <img id="photoPreview2" >
                <?php } ?>
            </div>
            <?php require_once(Yii::app()->basePath . '/draganddrop/index.php'); ?>
        </div>
    </div>
    <div id="actionForwardButtonDiv">
        <span class="customTitle">Action Forward Button</span> 
        <div class="cssButtonDetails">
            <label>Background Color</label>

            <input type="text" id="CompanyLafPreferences_action_forward_bg_color" name="CompanyLafPreferences[action_forward_bg_color]" readonly value="<?php if($model->action_forward_bg_color == ''){ echo '#c6f76b'; } else { echo $model->action_forward_bg_color; }?>"/>
            <?php
            $this->widget('application.extensions.colorpicker.EColorPicker', array(
                'name' => 'CompanyLafPreferences_action_forward_bg_color',
                'mode' => 'selector',
                'selector' => 'cp1',
                'fade' => false,
                'slide' => false,
                'curtain' => false,
                    )
            );
            ?>
            <div class="colorSelector2"><div style="background-color:<?php if($model->action_forward_bg_color == ''){ echo '#c6f76b'; } else { echo $model->action_forward_bg_color; }?>" id="cp1"></div></div>
            <div class="colorpickerHolder2">
            </div>
            <label>Background Gradient 2</label>

            <input type="text" id="CompanyLafPreferences_action_forward_bg_color2" name="CompanyLafPreferences[action_forward_bg_color2]" readonly value="<?php if($model->action_forward_bg_color2 == ''){ echo '#9ED92F'; } else { echo $model->action_forward_bg_color2; }?>"/>
            <?php
            $this->widget('application.extensions.colorpicker.EColorPicker', array(
                'name' => 'CompanyLafPreferences_action_forward_bg_color2',
                'mode' => 'selector',
                'selector' => 'cp24',
                'fade' => false,
                'slide' => false,
                'curtain' => false,
                    )
            );
            ?>
            <div class="colorSelector2"><div style="background-color:<?php if($model->action_forward_bg_color2 == ''){ echo '#9ED92F'; } else { echo $model->action_forward_bg_color2; }?>" id="cp24"></div></div>
            <div class="colorpickerHolder2">
            </div>
            
            <?php echo $form->error($model, 'action_forward_bg_color'); ?>
            <label>Text Color</label>
            <input type="text" id="CompanyLafPreferences_action_forward_font_color" name="CompanyLafPreferences[action_forward_font_color]" readonly value="<?php if($model->action_forward_font_color == ''){ echo '#ffffff'; } else { echo $model->action_forward_font_color; }?>">
            <?php
            $this->widget('application.extensions.colorpicker.EColorPicker', array(
                'name' => 'CompanyLafPreferences_action_forward_font_color',
                'mode' => 'selector',
                'selector' => 'cp2',
                'fade' => false,
                'slide' => false,
                'curtain' => false,
                    )
            );
            ?>
            <div class="colorSelector2"><div style="background-color: <?php if($model->action_forward_font_color == ''){ echo '#ffffff'; } else { echo $model->action_forward_font_color; }?>" id="cp2"></div></div>
            <div class="colorpickerHolder2">
            </div>
            <?php echo $form->error($model, 'action_forward_font_color'); ?>
            
            <label>Hover Background Color</label>
            <input type="text" id="CompanyLafPreferences_action_forward_hover_color" name="CompanyLafPreferences[action_forward_hover_color]" readonly value="<?php if($model->action_forward_hover_color == ''){ echo '#c6f76b'; } else { echo $model->action_forward_hover_color; }?>">
            <?php
            $this->widget('application.extensions.colorpicker.EColorPicker', array(
                'name' => 'CompanyLafPreferences_action_forward_hover_color',
                'mode' => 'selector',
                'selector' => 'cp3',
                'fade' => false,
                'slide' => false,
                'curtain' => false,
                    )
            );
            ?>
            <div class="colorSelector2"><div style="background-color: <?php if($model->action_forward_hover_color == ''){ echo '#c6f76b'; } else { echo $model->action_forward_hover_color; }?>" id="cp3"></div></div>
            <div class="colorpickerHolder2">
            </div>
            <label>Hover Background Color 2</label>
            <input type="text" id="CompanyLafPreferences_action_forward_hover_color2" name="CompanyLafPreferences[action_forward_hover_color2]" readonly value="<?php if($model->action_forward_hover_color2 == ''){ echo '#9ED92F'; } else { echo $model->action_forward_hover_color2; }?>">
            <?php
            $this->widget('application.extensions.colorpicker.EColorPicker', array(
                'name' => 'CompanyLafPreferences_action_forward_hover_color2',
                'mode' => 'selector',
                'selector' => 'cp25',
                'fade' => false,
                'slide' => false,
                'curtain' => false,
                    )
            );
            ?>
            <div class="colorSelector2"><div style="background-color: <?php if($model->action_forward_hover_color2 == ''){ echo '#9ED92F'; } else { echo $model->action_forward_hover_color2; }?>" id="cp25"></div></div>
            <div class="colorpickerHolder2">
            </div>
            <?php echo $form->error($model, 'action_forward_hover_color'); ?>
            
            <label>Hover Text Color</label>
            <input type="text" id="CompanyLafPreferences_action_forward_hover_font_color" name="CompanyLafPreferences[action_forward_hover_font_color]" readonly value="<?php if($model->action_forward_hover_color == ''){ echo '#ffffff'; } else { echo $model->action_forward_hover_font_color; }?>">
            <?php
            $this->widget('application.extensions.colorpicker.EColorPicker', array(
                'name' => 'CompanyLafPreferences_action_forward_hover_font_color',
                'mode' => 'selector',
                'selector' => 'cp4',
                'fade' => false,
                'slide' => false,
                'curtain' => false,
                    )
            );
            ?>
            <div class="colorSelector2"><div style="background-color: <?php if($model->action_forward_hover_font_color == ''){ echo '#ffffff'; } else { echo $model->action_forward_hover_font_color; }?>" id="cp4"></div></div>
            <div class="colorpickerHolder2">
            </div>
            
            
        </div>
    </div>
    <br>
    <div id="completeButtonDiv">
        <span class="customTitle">Complete Button (i.e Save)</span> 
        <div class="cssButtonDetails">
            <label>Background Color</label>
            <input type="text" id="CompanyLafPreferences_complete_bg_color" name="CompanyLafPreferences[complete_bg_color]" readonly value="<?php if($model->complete_bg_color == ''){ echo '#e67171'; } else { echo $model->complete_bg_color; }?>">
            <?php
            $this->widget('application.extensions.colorpicker.EColorPicker', array(
                'name' => 'CompanyLafPreferences_complete_bg_color',
                'mode' => 'selector',
                'selector' => 'cp5',
                'fade' => false,
                'slide' => false,
                'curtain' => false,
                    )
            );
            ?>
            <div class="colorSelector2"><div style="background-color: <?php if($model->complete_bg_color == ''){ echo '#e67171'; } else { echo $model->complete_bg_color; }?>" id="cp5"></div></div>
            <div class="colorpickerHolder2">
            </div>
            <?php echo $form->error($model, 'complete_bg_color'); ?>
            <label>Background Gradient 2</label>
            <input type="text" id="CompanyLafPreferences_complete_bg_color2" name="CompanyLafPreferences[complete_bg_color2]" readonly value="<?php if($model->complete_bg_color2 == ''){ echo '#d42222'; } else { echo $model->complete_bg_color2; }?>"/>
            
            <?php
            $this->widget('application.extensions.colorpicker.EColorPicker', array(
                'name' => 'CompanyLafPreferences_complete_bg_color2',
                'mode' => 'selector',
                'selector' => 'cp21',
                'fade' => false,
                'slide' => false,
                'curtain' => false,
                    )
            );
            ?>
            <div class="colorSelector2"><div style="background-color:<?php if($model->complete_bg_color2 == ''){ echo '#d42222'; } else { echo $model->complete_bg_color2; }?>" id="cp21"></div></div>
            <div class="colorpickerHolder2">
            </div>
            <label>Text Color</label>
            <input type="text" id="CompanyLafPreferences_complete_font_color" name="CompanyLafPreferences[complete_font_color]" readonly value="<?php if($model->complete_font_color == ''){ echo '#ffffff'; } else { echo $model->complete_font_color; }?>">
            <?php
            $this->widget('application.extensions.colorpicker.EColorPicker', array(
                'name' => 'CompanyLafPreferences_complete_font_color',
                'mode' => 'selector',
                'selector' => 'cp6',
                'fade' => false,
                'slide' => false,
                'curtain' => false,
                    )
            );
            ?>
            <div class="colorSelector2"><div style="background-color: <?php if($model->complete_font_color == ''){ echo '#ffffff'; } else { echo $model->complete_font_color; }?>" id="cp6"></div></div>
            <div class="colorpickerHolder2">
            </div>   
            <?php echo $form->error($model, 'complete_font_color'); ?>
            
            <label>Hover Background Color</label>
            <input type="text" id="CompanyLafPreferences_complete_hover_color" name="CompanyLafPreferences[complete_hover_color]" readonly value="<?php if($model->complete_hover_color == ''){ echo '#e67171'; } else { echo $model->complete_hover_color; }?>">
            <?php
            $this->widget('application.extensions.colorpicker.EColorPicker', array(
                'name' => 'CompanyLafPreferences_complete_hover_color',
                'mode' => 'selector',
                'selector' => 'cp7',
                'fade' => false,
                'slide' => false,
                'curtain' => false,
                    )
            );
            ?>
            <div class="colorSelector2"><div style="background-color:<?php if($model->complete_hover_color == ''){ echo '#e67171'; } else { echo $model->complete_hover_color; }?>" id="cp7"></div></div>
            <div class="colorpickerHolder2">
            </div>
            <?php echo $form->error($model, 'complete_hover_color'); ?>
            <label>Hover Background Color 2</label>
            <input type="text" id="CompanyLafPreferences_complete_hover_color2" name="CompanyLafPreferences[complete_hover_color2]" readonly value="<?php if($model->complete_hover_color2 == ''){ echo '#d42222'; } else { echo $model->complete_hover_color2; }?>">
            <?php
            $this->widget('application.extensions.colorpicker.EColorPicker', array(
                'name' => 'CompanyLafPreferences_complete_hover_color2',
                'mode' => 'selector',
                'selector' => 'cp23',
                'fade' => false,
                'slide' => false,
                'curtain' => false,
                    )
            );
            ?>
            <div class="colorSelector2"><div style="background-color:<?php if($model->complete_hover_color2 == ''){ echo '#d42222'; } else { echo $model->complete_hover_color2; }?>" id="cp23"></div></div>
            <div class="colorpickerHolder2">
            </div>
            
            <label>Hover Text Color</label>
            <input type="text" id="CompanyLafPreferences_complete_hover_font_color" name="CompanyLafPreferences[complete_hover_font_color]" readonly value="<?php if($model->complete_hover_font_color == ''){ echo '#ffffff'; } else { echo $model->complete_hover_font_color; }?>">
            <?php
            $this->widget('application.extensions.colorpicker.EColorPicker', array(
                'name' => 'CompanyLafPreferences_complete_hover_font_color',
                'mode' => 'selector',
                'selector' => 'cp8',
                'fade' => false,
                'slide' => false,
                'curtain' => false,
                    )
            );
            ?>
            <div class="colorSelector2"><div style="background-color:<?php if($model->complete_hover_font_color == ''){ echo '#ffffff'; } else { echo $model->complete_hover_font_color; }?>" id="cp8"></div></div>
            <div class="colorpickerHolder2">
            </div>
        </div>
    </div>
    <br>
    <div id="neutralButtonDiv">
        <span class="customTitle">Neutral Button (i.e Find Record)</span> 
        <div class="cssButtonDetails">
            <label>Background Color</label>
            <input type="text" id="CompanyLafPreferences_neutral_bg_color" name="CompanyLafPreferences[neutral_bg_color]" readonly value="<?php if($model->neutral_bg_color == ''){ echo '#5fdaf5'; } else { echo $model->neutral_bg_color; }?>">
            <?php
            $this->widget('application.extensions.colorpicker.EColorPicker', array(
                'name' => 'CompanyLafPreferences_neutral_bg_color',
                'mode' => 'selector',
                'selector' => 'cp9',
                'fade' => false,
                'slide' => false,
                'curtain' => false,
                    )
            );
            ?>
            <div class="colorSelector2"><div style="background-color: <?php if($model->neutral_bg_color == ''){ echo '#5fdaf5'; } else { echo $model->neutral_bg_color; }?>" id="cp9"></div></div>
            <div class="colorpickerHolder2">
            </div> 
            <?php echo $form->error($model, 'neutral_bg_color'); ?>
            
            <label>Background Gradient 2</label>
            <input type="text" id="CompanyLafPreferences_neutral_bg_color2" name="CompanyLafPreferences[neutral_bg_color2]" readonly value="<?php if($model->neutral_bg_color2 == ''){ echo '#33bcdb'; } else { echo $model->neutral_bg_color2; }?>">
            <?php
            $this->widget('application.extensions.colorpicker.EColorPicker', array(
                'name' => 'CompanyLafPreferences_neutral_bg_color2',
                'mode' => 'selector',
                'selector' => 'cp22',
                'fade' => false,
                'slide' => false,
                'curtain' => false,
                    )
            );
            ?>
            <div class="colorSelector2"><div style="background-color: <?php if($model->neutral_bg_color2 == ''){ echo '#33bcdb'; } else { echo $model->neutral_bg_color2; }?>" id="cp22"></div></div>
            <div class="colorpickerHolder2">
            </div> 
            
            <label>Text Color</label>
            <input type="text" id="CompanyLafPreferences_neutral_font_color" name="CompanyLafPreferences[neutral_font_color]" readonly value="<?php if($model->neutral_font_color== ''){ echo '#ffffff'; } else { echo $model->neutral_font_color; }?>"/>
            <?php
            $this->widget('application.extensions.colorpicker.EColorPicker', array(
                'name' => 'CompanyLafPreferences_neutral_font_color',
                'mode' => 'selector',
                'selector' => 'cp10',
                'fade' => false,
                'slide' => false,
                'curtain' => false,
                    )
            );
            ?>
            <div class="colorSelector2"><div style="background-color: <?php if($model->neutral_font_color== ''){ echo '#ffffff'; } else { echo $model->neutral_font_color; }?>" id="cp10"></div></div>
            <div class="colorpickerHolder2">
            </div> 
            <?php echo $form->error($model, 'neutral_font_color'); ?>
            <label>Hover Background Color</label>
            <input type="text" id="CompanyLafPreferences_neutral_hover_color" name="CompanyLafPreferences[neutral_hover_color]" readonly value="<?php if($model->neutral_hover_color == ''){ echo '#33bcdb'; } else { echo $model->neutral_hover_color; }?>">
            <?php
            $this->widget('application.extensions.colorpicker.EColorPicker', array(
                'name' => 'CompanyLafPreferences_neutral_hover_color',
                'mode' => 'selector',
                'selector' => 'cp11',
                'fade' => false,
                'slide' => false,
                'curtain' => false,
                    )
            );
            ?>
            <div class="colorSelector2"><div style="background-color: <?php if($model->neutral_hover_color == ''){ echo '#33bcdb'; } else { echo $model->neutral_hover_color; }?>" id="cp11"></div></div>
            <div class="colorpickerHolder2">
            </div> 
            
            <label>Hover Background Color 2</label>
            <input type="text" id="CompanyLafPreferences_neutral_hover_color2" name="CompanyLafPreferences[neutral_hover_color2]" readonly value="<?php if($model->neutral_hover_color2 == ''){ echo '#33bcdb'; } else { echo $model->neutral_hover_color2; }?>">
            <?php
            $this->widget('application.extensions.colorpicker.EColorPicker', array(
                'name' => 'CompanyLafPreferences_neutral_hover_color2',
                'mode' => 'selector',
                'selector' => 'cp26',
                'fade' => false,
                'slide' => false,
                'curtain' => false,
                    )
            );
            ?>
            <div class="colorSelector2"><div style="background-color: <?php if($model->neutral_hover_color2 == ''){ echo '#33bcdb'; } else { echo $model->neutral_hover_color2; }?>" id="cp26"></div></div>
            <div class="colorpickerHolder2">
            </div> 
            <?php echo $form->error($model, 'neutral_hover_color'); ?>
           
            
            <label>Hover Text Color</label>
            <input type="text" id="CompanyLafPreferences_neutral_hover_font_color" name="CompanyLafPreferences[neutral_hover_font_color]" readonly value="<?php if($model->neutral_hover_font_color == ''){ echo '#ffffff'; } else { echo $model->neutral_hover_font_color; }?>">
            <?php
            $this->widget('application.extensions.colorpicker.EColorPicker', array(
                'name' => 'CompanyLafPreferences_neutral_hover_font_color',
                'mode' => 'selector',
                'selector' => 'cp12',
                'fade' => false,
                'slide' => false,
                'curtain' => false,
                    )
            );
            ?>
            <div class="colorSelector2"><div style="background-color: <?php if($model->neutral_hover_font_color == ''){ echo '#ffffff'; } else { echo $model->neutral_hover_font_color; }?>" id="cp12"></div></div>
            <div class="colorpickerHolder2">
            </div> 
            
        </div>
    </div>
    <br>
    <div id="navMenuDiv">
        <span class="customTitle">Navigation Menu</span> 
        <div class="cssButtonDetails">
            <label>Background Color</label>
            <input type="text" id="CompanyLafPreferences_nav_bg_color" name="CompanyLafPreferences[nav_bg_color]" readonly value="<?php if($model->nav_bg_color == ''){ echo '#E7E7E7'; } else { echo $model->nav_bg_color; }?>">
            <?php
            $this->widget('application.extensions.colorpicker.EColorPicker', array(
                'name' => 'CompanyLafPreferences_nav_bg_color',
                'mode' => 'selector',
                'selector' => 'cp13',
                'fade' => false,
                'slide' => false,
                'curtain' => false,
                    )
            );
            ?>
            <div class="colorSelector2"><div style="background-color: <?php if($model->nav_bg_color == ''){ echo '#E7E7E7'; } else { echo $model->nav_bg_color; }?>" id="cp13"></div></div>
            <div class="colorpickerHolder2">
            </div> 
            <?php echo $form->error($model, 'nav_bg_color'); ?>
            <label>Text Color</label>
            <input type="text" id="CompanyLafPreferences_nav_font_color" name="CompanyLafPreferences[nav_font_color]" readonly value="<?php if($model->nav_font_color== ''){ echo '#637280'; } else { echo $model->nav_font_color; }?>"/>
            <?php
            $this->widget('application.extensions.colorpicker.EColorPicker', array(
                'name' => 'CompanyLafPreferences_nav_font_color',
                'mode' => 'selector',
                'selector' => 'cp14',
                'fade' => false,
                'slide' => false,
                'curtain' => false,
                    )
            );
            ?>
            <div class="colorSelector2"><div style="background-color: <?php if($model->nav_font_color== ''){ echo '#637280'; } else { echo $model->nav_font_color; }?>" id="cp14"></div></div>
            <div class="colorpickerHolder2">
            </div> 
            <?php echo $form->error($model, 'nav_font_color'); ?>
            <label>Hover Background Color</label>
            <input type="text" id="CompanyLafPreferences_nav_hover_color" name="CompanyLafPreferences[nav_hover_color]" readonly value="<?php if($model->nav_hover_color == ''){ echo '#9ED92F'; } else { echo $model->nav_hover_color; }?>">
            <?php
            $this->widget('application.extensions.colorpicker.EColorPicker', array(
                'name' => 'CompanyLafPreferences_nav_hover_color',
                'mode' => 'selector',
                'selector' => 'cp15',
                'fade' => false,
                'slide' => false,
                'curtain' => false,
                    )
            );
            ?>
            <div class="colorSelector2"><div style="background-color: <?php if($model->nav_hover_color == ''){ echo '#9ED92F'; } else { echo $model->nav_hover_color; }?>" id="cp15"></div></div>
            <div class="colorpickerHolder2">
            </div> 
            <?php echo $form->error($model, 'nav_hover_color'); ?>

            <label>Hover Text Color</label>
            <input type="text" id="CompanyLafPreferences_nav_hover_font_color" name="CompanyLafPreferences[nav_hover_font_color]" readonly value="<?php if($model->nav_hover_font_color == ''){ echo '#ffffff'; } else { echo $model->nav_hover_font_color; }?>">
            <?php
            $this->widget('application.extensions.colorpicker.EColorPicker', array(
                'name' => 'CompanyLafPreferences_nav_hover_font_color',
                'mode' => 'selector',
                'selector' => 'cp16',
                'fade' => false,
                'slide' => false,
                'curtain' => false,
                    )
            );
            ?>
            <div class="colorSelector2"><div style="background-color: <?php if($model->nav_hover_font_color == ''){ echo '#ffffff'; } else { echo $model->nav_hover_font_color; }?>" id="cp16"></div></div>
            <div class="colorpickerHolder2">
            </div> 
            
        </div>
    </div>
    
    <br>
    <div id="sideMenuDiv">
        <span class="customTitle">Side Menu and Header Text</span> 
        <div class="cssButtonDetails">
            <label>Background Color</label>
            <input type="text" id="CompanyLafPreferences_sidemenu_bg_color" name="CompanyLafPreferences[sidemenu_bg_color]" readonly value="<?php if($model->sidemenu_bg_color == ''){ echo '#E7E7E7'; } else { echo $model->sidemenu_bg_color; }?>">
            <?php
            $this->widget('application.extensions.colorpicker.EColorPicker', array(
                'name' => 'CompanyLafPreferences_sidemenu_bg_color',
                'mode' => 'selector',
                'selector' => 'cp17',
                'fade' => false,
                'slide' => false,
                'curtain' => false,
                    )
            );
            ?>
            <div class="colorSelector2"><div style="background-color: <?php if($model->sidemenu_bg_color == ''){ echo '#E7E7E7'; } else { echo $model->sidemenu_bg_color; }?>" id="cp17"></div></div>
            <div class="colorpickerHolder2">
            </div> 
            <?php echo $form->error($model, 'sidemenu_bg_color'); ?>
            <label>Text Color</label>
            <input type="text" id="CompanyLafPreferences_sidemenu_font_color" name="CompanyLafPreferences[sidemenu_font_color]" readonly value="<?php if($model->sidemenu_font_color== ''){ echo '#637280'; } else { echo $model->sidemenu_font_color; }?>"/>
            <?php
            $this->widget('application.extensions.colorpicker.EColorPicker', array(
                'name' => 'CompanyLafPreferences_sidemenu_font_color',
                'mode' => 'selector',
                'selector' => 'cp18',
                'fade' => false,
                'slide' => false,
                'curtain' => false,
                    )
            );
            ?>
            <div class="colorSelector2"><div style="background-color: <?php if($model->sidemenu_font_color== ''){ echo '#637280'; } else { echo $model->sidemenu_font_color; }?>" id="cp18"></div></div>
            <div class="colorpickerHolder2">
            </div> 
            <?php echo $form->error($model, 'sidemenu_font_color'); ?>
            <label>Hover Background Color</label>
            <input type="text" id="CompanyLafPreferences_sidemenu_hover_color" name="CompanyLafPreferences[sidemenu_hover_color]" readonly value="<?php if($model->sidemenu_hover_color == ''){ echo '#E7E7E7'; } else { echo $model->sidemenu_hover_color; }?>">
            <?php
            $this->widget('application.extensions.colorpicker.EColorPicker', array(
                'name' => 'CompanyLafPreferences_sidemenu_hover_color',
                'mode' => 'selector',
                'selector' => 'cp19',
                'fade' => false,
                'slide' => false,
                'curtain' => false,
                    )
            );
            ?>
            <div class="colorSelector2"><div style="background-color: <?php if($model->sidemenu_hover_color == ''){ echo '#E7E7E7'; } else { echo $model->sidemenu_hover_color; }?>" id="cp19"></div></div>
            <div class="colorpickerHolder2">
            </div> 
            <?php echo $form->error($model, 'sidemenu_hover_color'); ?>

            <label>Hover Text Color</label>
            <input type="text" id="CompanyLafPreferences_sidemenu_hover_font_color" name="CompanyLafPreferences[sidemenu_hover_font_color]" readonly value="<?php if($model->sidemenu_hover_font_color == ''){ echo '#637280'; } else { echo $model->sidemenu_hover_font_color; }?>">
            <?php
            $this->widget('application.extensions.colorpicker.EColorPicker', array(
                'name' => 'CompanyLafPreferences_sidemenu_hover_font_color',
                'mode' => 'selector',
                'selector' => 'cp20',
                'fade' => false,
                'slide' => false,
                'curtain' => false,
                    )
            );
            ?>
            <div class="colorSelector2"><div style="background-color: <?php if($model->sidemenu_hover_font_color == ''){ echo '#637280'; } else { echo $model->sidemenu_hover_font_color; }?>" id="cp20"></div></div>
            <div class="colorpickerHolder2">
            </div> 
            
        </div>
    </div>
<div class="row buttons buttonsAlignToRight" style="margin-left:3px;">
    <input type="submit" value="Save" name="yt0" class="complete">
</div>
<?php $this->endWidget(); ?>

</div><!-- form -->

<input type="hidden" id="Host_photo" name="CompanyLafPreferences[logo]" value="<?php echo $company->logo; ?>">
<!-- <input type="hidden" id="Host_photo"> -->

<script>
    $(document).ready(function () {

        /*Added by farhat aziz for upload host photo*/

        if($('#photoCropPreview').imgAreaSelect) {
            $('#photoCropPreview').imgAreaSelect({
                handles: true,
                onSelectEnd: function (img, selection) {
                    $("#cropPhotoBtn").show();
                    $("#x12").val(selection.x1);
                    $("#x22").val(selection.x2);
                    $("#y12").val(selection.y1);
                    $("#y22").val(selection.y2);
                    $("#width").val(selection.width);
                    $("#height").val(selection.height);
                }
            });
        }
        $("#cropPhotoBtn").click(function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: "<?php echo Yii::app()->createUrl('CompanyLafPreferences/AjaxCrop'); ?>",
                data: {
                    x1: $("#x12").val(),
                    x2: $("#x22").val(),
                    y1: $("#y12").val(),
                    y2: $("#y22").val(),
                    width: $("#width").val(),
                    height: $("#height").val(),
                    //imageUrl: $('#photoCropPreview').attr('src').substring(1, $('#photoCropPreview').attr('src').length),
                    photoId: $('#Host_photo').val(),
                    logo_id: $('#CompanyLafPreferences_logo').val()
                },
                dataType: 'json',
                success: function (r) {
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo Yii::app()->createUrl('photo/GetPathOfCompanyLogo&id='); ?>" + $('#Host_photo').val(),
                        dataType: 'json',
                        success: function (r) {
                            $.each(r.data, function (index, value) {
                                
                                /*document.getElementById('photoPreview2').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;*/
                                /*document.getElementById('photoPreview').src = "data:image;base64,"+ value.db_image;*/
                                document.getElementById('photoPreview2').src = "data:image;base64,"+ value.db_image;
                    
                            });
                        }
                    });
                    $("#closeCropPhoto").click();
                    var ias = $('#photoCropPreview').imgAreaSelect({instance: true});
                    ias.cancelSelection();
                }
            });
        });
        $('#closeCropPhoto').on('click', function(){
            document.getElementById('light').style.display = 'none';
            document.getElementById('fade').style.display = 'none';
            var ias = $('#photoCropPreview').imgAreaSelect({instance: true});
            ias.cancelSelection();
        });
    });
</script>

<!-- PHOTO CROP-->
<div id="light" class="white_content" style="height: 380px;">
    <img id="photoCropPreview" src="data:image;base64,<?php echo Photo::model()->returnLogoPhotoRelative($company->logo); ?>" style="max-width: 500px !important;">

</div>
<div id="fade" class="black_overlay">
    <div style="text-align:right;">
        <input type="button" class="btn btn-success" id="cropPhotoBtn" value="Crop" style="">
        <input type="button" id="closeCropPhoto" value="x" class="btn btn-danger">
    </div>
</div>

<input type="hidden" id="x12"/>
<input type="hidden" id="x22"/>
<input type="hidden" id="y12"/>
<input type="hidden" id="y22"/>
<input type="hidden" id="width"/>
<input type="hidden" id="height"/>

<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 6/17/15
 * Time: 10:43 AM
 */

$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/script-birthday.js');

$countryList = CHtml::listData(Country::model()->findAll(array(
    "order" => "name asc",
    "group" => "name"
)), 'id', 'name');
?>

<div class="page-content">
    <h1 class="text-primary title">CONFIRM DETAILS</h1>
    <div class="bg-gray-lighter form-info">Please confirm if the details below are correct and edit where necessary.</div>
    <?php
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'confirm-details-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'htmlOptions'=>array(
            'class'=> 'form-comfirm-detail'
        )
    ));
    ?>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <?php echo $form->textField($model, 'first_name', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'First Name' , 'class'=>'form-control input-lg')); ?>
                    <?php echo $form->error($model, 'first_name'); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->textField($model, 'last_name', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Last Name' , 'class'=>'form-control input-lg')); ?>
                    <?php echo $form->error($model, 'last_name'); ?>
                </div>
                <div class="row form-group">
                    <span class="text-primary col-xs-12">DATE OF BIRTH</span>

                    <input type="hidden" id="dateofBirthBreakdownValueYear"
                           value="<?php echo date("Y", strtotime($model->date_of_birth)); ?>">
                    <input type="hidden" id="dateofBirthBreakdownValueMonth"
                           value="<?php echo date("n", strtotime($model->date_of_birth)); ?>">
                    <input type="hidden" id="dateofBirthBreakdownValueDay"
                           value="<?php echo date("j", strtotime($model->date_of_birth)); ?>">

                    <div class="col-xs-3">
                        <select id="fromDay" name="Visitor[birthdayDay]" class='daySelect form-control input-lg'></select>
                    </div>
                    <div class="col-xs-3">
                        <select id="fromMonth" name="Visitor[birthdayMonth]" class='monthSelect form-control input-lg'></select>
                    </div>
                    <div class="col-xs-3">
                        <select id="fromYear" name="Visitor[birthdayYear]" class='yearSelect form-control input-lg'></select>
                    </div>

                    <?php echo $form->error($model, 'date_of_birth'); ?>

                </div>
                <div class="form-group">
                    <?php echo $form->dropDownList($model, 'identification_type', Visitor::$IDENTIFICATION_TYPE_LIST, array('prompt' => 'Identification Type' , 'class'=>'form-control input-lg')); ?>
                    <?php echo $form->error($model, 'identification_type'); ?>

                </div>
                <div class="form-group">
                    <input name="id-number"
                           class="form-control input-lg"
                           data-validate-input
                           placeholder="ID number" >
                </div>
                <div class="form-group">
                    <?php
                    echo $form->dropDownList($model, 'identification_country_issued', $countryList, array('empty' => 'Country of Issue', 'class'=>'form-control input-lg' , 'options' => array(Visitor::AUSTRALIA_ID => array('selected' => 'selected'))));
                    ?>
                    <?php echo $form->error($model, 'identification_country_issued'); ?>

                </div>
                <div class="row form-group">
                    <span class="text-primary col-xs-12">EXPIRY</span>
                    <div class="col-md-6">
                        <?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model'       => $model,
                            'attribute'   => 'identification_document_expiry',
                            'options'     => array(
                                'dateFormat' => 'dd-mm-yy',
                            ),
                            'htmlOptions' => array(
                                'size'        => '0',
                                'maxlength'   => '10',
                                'placeholder' => 'Expiry',
                                /*'style'       => 'width: 80px;',*/
                                'class' => 'form-control input-lg'
                            ),
                        ));
                        ?>
                        <?php echo $form->error($model, 'identification_document_expiry'); ?>
                    </div>
                    <!--<div class="col-xs-3">
                        <select name="year" class="form-control input-lg">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            <option>6</option>
                            <option>7</option>
                            <option>8</option>
                            <option>9</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                            <option>24</option>
                            <option>25</option>
                            <option>26</option>
                            <option>27</option>
                            <option>28</option>
                            <option>29</option>
                            <option>30</option>
                            <option>31</option>
                        </select>
                    </div>
                    <div class="col-xs-5">
                        <select name="month" class="form-control input-lg">
                            <option>January</option>
                            <option>February</option>
                            <option>March</option>
                            <option>April</option>
                            <option>May</option>
                            <option>June</option>
                            <option>July</option>
                            <option>August</option>
                            <option>September</option>
                            <option>October</option>
                            <option>November</option>
                            <option>December</option>
                        </select>
                    </div>
                    <div class="col-xs-4">
                        <select name="year" class="form-control input-lg">
                            <option>2015</option>
                            <option>2016</option>
                            <option>2017</option>
                            <option>2018</option>
                            <option>2019</option>
                            <option>2020</option>
                            <option>2021</option>
                            <option>2022</option>
                        </select>
                    </div>-->
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row form-group">
                    <div class="col-xs-5">
                        <?php echo $form->textField($model, 'contact_unit', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'Unit / flat no.', 'class'=>'form-control input-lg')); ?>
                        <?php echo $form->error($model, 'contact_unit'); ?>

                    </div>
                    <div class="col-xs-7">
                        <?php echo $form->textField($model, 'contact_street_no', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'Street No.', 'class'=>'form-control input-lg')); ?>
                        <?php echo $form->error($model, 'contact_street_no'); ?>
                    </div>

                </div>
                <div class="row form-group form-group-custom">
                    <div class="col-xs-7">
                        <?php echo $form->textField($model, 'contact_street_name', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'Street Name', 'class'=>'form-control input-lg')); ?>
                        <?php echo "<br>" . $form->error($model, 'contact_street_name'); ?>
                    </div>
                    <div class="col-xs-5">
                        <?php echo $form->dropDownList($model, 'contact_street_type', Visitor::$STREET_TYPES, array('empty' => 'Type', 'class'=>'form-control input-lg')); ?>
                        <?php echo $form->error($model, 'contact_street_type'); ?>
                    </div>
                </div>
                <div class="form-group form-group-custom">
                    <?php echo $form->textField($model, 'contact_suburb', array('size' => 15, 'maxlength' => 50, 'placeholder' => 'Suburb' , 'class'=>'form-control input-lg')); ?>
                    <?php echo $form->error($model, 'contact_suburb'); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->textField($model, 'contact_postcode', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'Postcode', 'class'=>'form-control input-lg')); ?>
                    <?php echo $form->error($model, 'contact_postcode'); ?>
                </div>
                <div class="form-group form-group-custom">
                    <?php echo $form->dropDownList($model, 'contact_state', Visitor::$AUSTRALIAN_STATES, array('empty' => 'State', 'class'=>'form-control input-lg')); ?>
                    <?php echo $form->error($model, 'contact_state'); ?>

                </div>
                <div class="form-group form-group-custom">
                    <?php
                    echo $form->dropDownList($model, 'contact_country', $countryList,
                        array('prompt' => 'Country', 'class'=>'form-control input-lg',
                            'options' => array(Visitor::AUSTRALIA_ID => array('selected' => 'selected'))));
                    ?>
                    <?php echo $form->error($model, 'contact_country'); ?>

                </div>
                <div class="form-group">
                    <?php echo $form->textField($model, 'contact_number', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Mobile Number', 'class'=>'form-control input-lg')); ?>
                    <?php echo $form->error($model, 'contact_number'); ?>

                </div>
            </div>
        </div>

    <div class="row next-prev-btns">
        <div class="col-md-1 col-sm-1 col-xs-1">
            <a href="<?=Yii::app()->createUrl("preregistration/registration")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
        </div>

        <div class="col-md-offset-10 col-sm-offset-10 col-xs-offset-7 col-md-1 col-sm-1 col-xs-1">
            <?php
            echo CHtml::tag('button', array(
                'type'=>'submit',
                'class' => 'btn btn-primary btn-next'
            ), 'NEXT <span class="glyphicon glyphicon-chevron-right"></span> ');
            ?>

        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>




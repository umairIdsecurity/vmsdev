<?php
/* @var $this InductionController */
/* @var $model InductionRecords */
/* @var $induction InductionName */
/* @var $visitor Visitor */
/* @var $company Company */

$session = new CHttpSession;
?>
<h1 style="font-size: 20px;">AIRPORT INDUCTION CARD</h1>
 
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
    
?>

<?php $this->renderPartial('_form', array('min'       => $min,
                                          'model'     => $model, 
										  'induction' => $induction,
										  'visitor'   => $visitor,
										  'company'   => $company)); ?>




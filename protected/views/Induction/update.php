<?php
/* @var $this InductionController */
/* @var $model InductionRecords */
/* @var $induction InductionName */
/* @var $visitor Visitor */
/* @var $company Company */
?>

<h1 style="font-size: 20px;">Edit Airport Induction Card</h1>
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
    
?>

<?php $this->renderPartial('_updateform', array('min'         => $min,
												'airSide'     => $airSide,
												'Orientation' => $Orientation,
												'Security'    => $Security,
												'Safe'        => $Safe,
												'Driving'     => $Driving,
												'Drug'        => $Drug,
												'induction'   => $induction,
												'visitor'     => $visitor,
												'company'     => $company,  
												)); ?>
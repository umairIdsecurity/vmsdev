<<<<<<< HEAD
<?php
/* @var $this CompanyController */
/* @var $model Company */


?>

<h1>Edit Organisation Fields</h1>
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
    
?>
=======
<?php
/* @var $this CompanyController */
/* @var $model Company */


?>

<h1>Edit Organisation Fields</h1>
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
    
?>
>>>>>>> origin/Issue35
<?php $this->renderPartial('_form', array('model'=>$model)); ?>
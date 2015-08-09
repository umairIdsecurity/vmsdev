<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 7/23/15
 * Time: 6:39 PM
 */
?>

<div class="page-content">
    <h1 class="text-primary title">Confirmation</h1>

    <p>Please go to the gate to collect your VIC with your Identification for verification.</p>

</div>

<script type="text/javascript">

    $(document).ready(function () {
        window.setTimeout(function () {
            location.href = '<?=Yii::app()->getBaseUrl(true)?>/index.php/preregistration/dashboard';
        }, 5000);
    });

</script>
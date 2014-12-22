
<?php
/* @var $this DashboardController */
/* @var $dataProvider CActiveDataProvider */
?>

<div id="data">
</div>

<?php
$url;
switch ($_GET['page']) {
    case "addhostSidebar":
        $url = 'dashboard/addHost';
        break;
    case "addvisitorSidebar":
        $url = 'visitor/create';
        break;
    case "findrecordSidebar":
        $url = 'visit/view';
        break;
    case "evacuationreportSidebar":
        $url = 'visit/evacuationReport';
        break;
}
echo CHtml::ajaxLink("Update data", CController::createUrl($url), array(
    'update' => '#data',
        ), array(
    'id' => 'ajaxTriggerButton',
));
?>

<script>

    $(document).ready(function() {
        alert("da");
         $("#ajaxTriggerButton").click();
    });

</script>
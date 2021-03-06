<?php
$pageId = isset($_REQUEST["p"])?$_REQUEST["p"]:1;
$getFile = "page/mobile/page{$pageId}.html";
if(!is_file($getFile)){
    $pageId=1;
    $getFile = "page/mobile/page1.html";
}
?>
<!DOCTYPE html>
    <html lang="en" class="mobile">
    <head>
        <meta charset="utf-8">
        <meta name="HandheldFriendly" content="True">
        <meta name="MobileOptimized" content="320">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-title" content="" />
        <meta name="description" content="description" />
        <meta name="keywords" content="keywords"/>
        <title>Preregistration</title>
        <link rel="stylesheet" href="./css/style.css" />
        <script src="./js/modernizr.js"></script>
    </head>
    <body class="<?=$pageId==1?"first-page":""?> <?=$pageId>4?"logout-page":"login-page"?>">
        <div id="header" class="relative">
            <div class="container">
                <div class="logo">
                    <a href="./mobile.php">
                        <img src="./images/logo.png" alt="Pre registration"/>
                    </a>
                </div>
                <ul class="icons">
                    <li class="group-1"><a href="./user.php"><span class="glyphicon glyphicon-log-in"></span></a></li>
                    <li class="group-2"><a href="./user.php?p=function"><span class="glyphicon glyphicon-user"></span></a></li>
                    <li class="group-2"><a href="#"><span class="glyphicon glyphicon-envelope"></span></a></li>
                    <li class="group-2"><a href="#"><span class="glyphicon glyphicon-question-sign"></span></a></li>
                    <li class="group-2"><a href="#"><span class="glyphicon glyphicon-log-out"></span></a></li>
                </ul>
            </div>
        </div>
        <div id="container">
            <div class="container">
                <div id="main">
                    <?php
                    require($getFile);
                    ?>
                </div>
            </div>
        </div>
        <div id="footer">
            <div class="container">
                <a href="?p=<?=$pageId-1?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
                <a href="?p=<?=$pageId+1?>" class="btn btn-primary btn-next">NEXT <span class="glyphicon glyphicon-chevron-right"></span></a>
            </div>
        </div>
        <!-- for developer -->
        <script src="./js/libs.js"></script>
        <script src="./js/plugins.download.js"></script>
        <script src="./js/plugins.js"></script>
        <script src="./js/script.js"></script>
    </body>
</html>


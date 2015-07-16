<html>
<head>
    <script>
        function readfile() {
            document.getElementById('iframe').contentDocument.body.firstChild.innerHTML;
        }
    </script>
</head>
<body style="margin:0px;padding:0px;overflow:hidden">
<iframe  id='iframe' src='<?php echo $source; ?>'  frameborder="0" style="overflow:hidden;overflow-x:hidden;overflow-y:hidden;width:100%;position:absolute;top:0px;left:0px;right:0px;bottom:0px" height="100%" width="100%"> </iframe>
</body>
</html>
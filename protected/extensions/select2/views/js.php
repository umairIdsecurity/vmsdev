<script>
    $( document ).ready(function() {
        $(".<?php echo $className ?>").select2({
            placeholder: "<?php echo $placeHolder ?>",
            width: '220px'
        });
    });
</script>
jQuery(function() {
    'use strict';
    var $datepickerEls = $('[data-date-picker]');

    if($datepickerEls.length){

        $datepickerEls.each(function(){
            var formatDay =$(this).data('dateFormat') || 'dd/mm/yyyy';
            var $linkedPickersElm = $(this).data('linkedPickers')?$($(this).data('linkedPickers')):null;

            $(this).datepicker({
                format: formatDay,
                autoclose: true
            });
            /*if($linkedPickersElm && $linkedPickersElm.length){
                $(this).click(function () {
                    if($linkedPickersElm.val()){
                        $(this).datepicker({
                            format: formatDay,
                            startDate:$linkedPickersElm.val(),
                            autoclose: true
                        });
                    }
                });
            }*/
        });
    }
});

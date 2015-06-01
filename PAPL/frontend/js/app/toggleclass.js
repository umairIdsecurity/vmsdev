jQuery(function() {
    'use strict';
    var $btnToggleClass = $('[data-toggle-class]'),
        $btnClosetToggleClass = $('[data-closet-toggle-class]');

    if ($btnToggleClass.length) {
        $btnToggleClass.on('click', function(e) {
            e.preventDefault();
            var objTarget = $(this).data('toggleClassObject')? $(this).data('toggleClassObject').split(','):null;
            var objClass = $(this).data('toggleClass')?$(this).data('toggleClass').split(','):null;

            var showHide = $(this).data('showHide')?$(this).data('showHide').split(','):null;

            if (objTarget && objClass) {
                for (var i = 0, l = objTarget.length; i < l; i++) {
                    $($(objTarget[i].trim())).toggleClass(objClass[i].trim());
                }
            }

            if(showHide){
                // show
                if( showHide[0] && $(showHide[0]).length ){
                    $(showHide[0].trim()).removeClass("hidden");
                }
                // hide
                if( showHide[1] && $(showHide[1]).length ){
                     $(showHide[1].trim()).addClass("hidden");
                }
            }
        });
    }

    if ($btnClosetToggleClass.length) {
        $btnClosetToggleClass.on('click', function(e) {
            e.preventDefault();
            $(this).closest($(this).data('object')).toggleClass($(this).data('closetToggleClass'));
        });
    }
});

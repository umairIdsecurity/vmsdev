jQuery(function() {
    'use strict';
    var $validateInput = $('[data-validate]');
    if ($validateInput.length) {
        $validateInput.on('change', function(e) {
            Site.isValidate($(this));
        });
    }
});
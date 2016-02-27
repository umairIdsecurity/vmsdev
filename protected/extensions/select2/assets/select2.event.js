function select2changed (evt) {
    evt.type = (typeof evt.added === "undefined") ? 'select2:unselect' : 'select2:select';
    if (evt) {
        if (evt.type == 'select2:select') {
            $.ajax({
                url: '/dataNew/renderShippingAttribute',
                type: 'post',
                data: {language: evt.added.id},
                dataType: 'json',
                beforeSend: function() {
                    $('#language_loading').show();
                },
                success: function(data) {
                    if (data.status == 'success') {
                        $('#shipping_wrapper').append(data.html);
                    }
                },
                complete: function(data) {
                    $('#language_loading').hide();
                }
            });
        } else if (evt.type == 'select2:unselect') {
            $('#panel-shipping-' + evt.removed.id).remove();
        }
    }
}
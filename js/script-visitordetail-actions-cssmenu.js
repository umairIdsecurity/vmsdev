<<<<<<< HEAD
(function($) {
    $(document).ready(function() {
        $('#actionsCssMenu ul ul li:odd').addClass('odd');
        $('#actionsCssMenu ul ul li:even').addClass('even');
        $('#actionsCssMenu li').removeClass('active');

        $('#actionsCssMenu > ul > li > a').click(function() {
            $('#actionsCssMenu li').removeClass('active');
            $(this).closest('li').addClass('active');
            var checkElement = $(this).next();
            if ((checkElement.is('ul')) && (checkElement.is(':visible'))) {
                $(this).closest('li').removeClass('active');
                checkElement.slideUp('normal');
            }
            if ((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
                $('#actionsCssMenu ul ul:visible').slideUp('normal');
                checkElement.slideDown('normal');
            }
            if ($(this).closest('li').find('ul').children().length == 0) {
                return true;
            } else {
                return false;
            }
        });
        
        

        

    });


})(jQuery);
=======
(function($) {
    $(document).ready(function() {
        $('#actionsCssMenu ul ul li:odd').addClass('odd');
        $('#actionsCssMenu ul ul li:even').addClass('even');
        $('#actionsCssMenu li').removeClass('active');

        $('#actionsCssMenu > ul > li > a').click(function() {
            $('#actionsCssMenu li').removeClass('active');
            $(this).closest('li').addClass('active');
            var checkElement = $(this).next();
            if ((checkElement.is('ul')) && (checkElement.is(':visible'))) {
                $(this).closest('li').removeClass('active');
                checkElement.slideUp('normal');
            }
            if ((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
                $('#actionsCssMenu ul ul:visible').slideUp('normal');
                checkElement.slideDown('normal');
            }
            if ($(this).closest('li').find('ul').children().length == 0) {
                return true;
            } else {
                return false;
            }
        });
        
        

        

    });


})(jQuery);
>>>>>>> origin/Issue35

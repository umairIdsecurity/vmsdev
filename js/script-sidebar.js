(function($) {
    $(document).ready(function() {
//        $('#cssmenu ul ul li:odd').addClass('odd');
//        $('#cssmenu ul ul li:even').addClass('even');
//
//        $('#cssmenu > ul > li > a').click(function() {
//            $('#cssmenu li').removeClass('active');
//            $(this).closest('li').addClass('active');
//            var checkElement = $(this).next();
//            if ((checkElement.is('ul')) && (checkElement.is(':visible'))) {
//                $(this).closest('li').removeClass('active');
//                checkElement.slideUp('normal');
//            }
//            if ((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
//                $('#cssmenu ul ul:visible').slideUp('normal');
//                checkElement.slideDown('normal');
//            }
//            if ($(this).closest('li').find('ul').children().length == 0) {
//                return true;
//            } else {
//                return false;
//            }
//        });

        /*click sidebar menu if same with current page*/
        var pathArray = window.location.href.split('/');
        var secondLevelLocation = pathArray[3]; // + "/" + pathArray[4];
        var currentRole = $("#sessionRoleForSideBar").val();
        var admin = 1;
        var agentadmin = 6;
        var superadmin = 5;
        var li = $('#cssmenu > ul li a');
        switch (secondLevelLocation) {
            case "index.php?r=company":
                if (currentRole == superadmin)
                {
                    //   li[0].click();
                 //   $('.managecompanies').next().show();
                }
                break;
            case "index.php?r=workstation":
//                if (currentRole == admin || currentRole == agentadmin) {
//                    li[1].click();
//                } else
//                {
//                    li[2].click();
//                }
               // $('.manageworkstations').next().show();
                break;
            case "index.php?r=user":
//                if (currentRole == admin || currentRole == agentadmin) {
//                    li[3].click();
//                }
//                else
//                {
//                    li[4].click();
//                }
               // $('.manageusers').next().show();
                break;
//
            case "index.php?r=visitReason":
//                if (currentRole == superadmin) {
//                    li[15].click();
//                }
             //   $('.managevisitreasons').next().show();
                break;
            case "index.php?r=visitor":

//                if (currentRole == superadmin) {
//                    li[11].click();
//                } else if(currentRole == admin) {
//                    li[9].click();
//                }  else if(currentRole == agentadmin) {
//                    li[7].click();
//                }
               // $('.managevisitorrecords').next().show();
                break;
            case "index.php?r=licenseDetails":
                if (currentRole == superadmin)
                {
                    //   li[0].click();
          //          $('.managecompanies').next().show();
                }
                break;
        }
//        
        if ((pathArray[4] == 'evacuationReport' || pathArray[4] == 'visitorRegistrationHistory') && (currentRole == admin || currentRole == agentadmin || currentRole == superadmin)) {

//            if (currentRole == admin) {
//                li[9].click();
//            }
//            else if (currentRole == agentadmin) {
//                li[7].click();
//            }
//            else {
//                li[18].click();
//            }
          //  $('.managereports').next().slideDown('normal');
            //$('.managereports').next().show();
        }
//        
//        
        if (pathArray[4] == 'exportvisitorrecords') {
//            if (currentRole == superadmin) {
//                    li[11].click();
//                } else if (currentRole == admin) {
//                    li[9].click();
//                } else if (currentRole == agentadmin) {
//                    li[7].click();
//                }
       //     $('.managevisitorrecords').next().show();

        }
        $('.has-sub a').click(function() {
            //window.location = this.href;
            //  e.preventDefault();
        });

    });


})(jQuery);

jQuery.expr[":"].Contains = jQuery.expr.createPseudo(function(arg) {
    return function( elem ) {
        return jQuery(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
    };
});

jQuery(document).ready(function($){
	//update these values if you change these breakpoints in the style.css file (or _layout.scss if you use SASS)
	var MqM= 768,
		MqL = 1024;

	var faqsSections = $('.help-desk-group'),
		faqTrigger = $('.help-desk-trigger'),
		faqsContainer = $('.help-desk-items'),
		faqsCategoriesContainer = $('.help-desk-categories'),
		faqsCategories = faqsCategoriesContainer.find('a'),
		closeFaqsContainer = $('.cd-close-panel');
	
	//select a faq section 
	faqsCategories.on('click', function(event){
		event.preventDefault();
		var selectedHref = $(this).attr('href'),
			target= $(selectedHref);
		if( $(window).width() < MqM) {
			faqsContainer.scrollTop(0).addClass('slide-in').children('ul').removeClass('selected').end().children(selectedHref).addClass('selected');
			closeFaqsContainer.addClass('move-left');
			$('body').addClass('cd-overlay');
		} else {
	        $('body,html').animate({ 'scrollTop': target.offset().top - 19}, 200); 
		}
	});

	//close faq lateral panel - mobile only
	$('body').bind('click touchstart', function(event){
		if( $(event.target).is('body.cd-overlay') || $(event.target).is('.cd-close-panel')) { 
			closePanel(event);
		}
	});
	faqsContainer.on('swiperight', function(event){
		closePanel(event);
	});

	//show faq content clicking on faqTrigger
	faqTrigger.on('click', function(event){
		event.preventDefault();
		$(this).next('.help-desk-content').slideToggle(200).end().parent('li').toggleClass('content-visible');
	});

	//update category sidebar while scrolling
	$(window).on('scroll', function(){
		if ( $(window).width() > MqL ) {
			(!window.requestAnimationFrame) ? updateCategory() : window.requestAnimationFrame(updateCategory); 
		}
	});

	$(window).on('resize', function(){
		if($(window).width() <= MqL) {
			faqsCategoriesContainer.removeClass('is-fixed').css({
				'-moz-transform': 'translateY(0)',
			    '-webkit-transform': 'translateY(0)',
				'-ms-transform': 'translateY(0)',
				'-o-transform': 'translateY(0)',
				'transform': 'translateY(0)',
			});
		}	
		if( faqsCategoriesContainer.hasClass('is-fixed') ) {
			faqsCategoriesContainer.css({
				'left': faqsContainer.offset().left,
			});
		}
	});

	function closePanel(e) {
		e.preventDefault();
		faqsContainer.removeClass('slide-in').find('li').show();
		closeFaqsContainer.removeClass('move-left');
		$('body').removeClass('cd-overlay');
	}

	function updateCategory(){
		updateCategoryPosition();
		updateSelectedCategory();
	}

	function updateCategoryPosition() {
		var top = $('.help-desk').offset().top,
			height = jQuery('.help-desk').height() - jQuery('.help-desk-categories').height(),
			margin = 20;
		if( top - margin <= $(window).scrollTop() && top - margin + height > $(window).scrollTop() ) {
			var leftValue = faqsCategoriesContainer.offset().left,
				widthValue = faqsCategoriesContainer.width();
			faqsCategoriesContainer.addClass('is-fixed').css({
				'left': leftValue,
				'top': margin,
				'-moz-transform': 'translateZ(0)',
			    '-webkit-transform': 'translateZ(0)',
				'-ms-transform': 'translateZ(0)',
				'-o-transform': 'translateZ(0)',
				'transform': 'translateZ(0)',
			});
		} else if( top - margin + height <= $(window).scrollTop()) {
			var delta = top - margin + height - $(window).scrollTop();
			faqsCategoriesContainer.css({
				'-moz-transform': 'translateZ(0) translateY('+delta+'px)',
			    '-webkit-transform': 'translateZ(0) translateY('+delta+'px)',
				'-ms-transform': 'translateZ(0) translateY('+delta+'px)',
				'-o-transform': 'translateZ(0) translateY('+delta+'px)',
				'transform': 'translateZ(0) translateY('+delta+'px)',
			});
		} else { 
			faqsCategoriesContainer.removeClass('is-fixed').css({
				'left': 0,
				'top': 0,
			});
		}
	}

	function updateSelectedCategory() {
		faqsSections.each(function(){
			var actual = $(this),
				margin = parseInt($('.help-desk-title').eq(1).css('marginTop').replace('px', '')),
				activeCategory = $('.help-desk-categories a[href="#'+actual.attr('id')+'"]'),
				topSection = (activeCategory.parent('li').is(':first-child')) ? 0 : Math.round(actual.offset().top);
			
			if ( ( topSection - 20 <= $(window).scrollTop() ) && ( Math.round(actual.offset().top) + actual.height() + margin - 20 > $(window).scrollTop() ) ) {
				activeCategory.addClass('selected');
			}else {
				activeCategory.removeClass('selected');
			}
		});
	}
	
	 $("#txt_search").keyup(function(event){
		  if(event.keyCode == 13){
			  $("#searchFaq").click();
		  }
     });
	
     $( "#searchFaq" ).click(function(event) {
			 event.preventDefault();
			 var txt_search = $('#txt_search').val();
			 
			 if(txt_search == '' && txt_search.length <=2)
			 {
			   $( ".help-desk-items ul > li" ).show();
			   return 0;
			 }
			  var tokens = [].concat.apply([], txt_search.split('"').map(function(v,i){
				return i%2 ? v : v.split(' ')
			 })).filter(Boolean);
			 
			 $( ".help-desk-items ul" ).each(function( i ) {
				  
				  $helpDeskUl = $(this);
				  $helpDeskUl.find('li').hide(); 
				  var ivar = 1;
				  var isFound =0;
				  $helpDeskUl.find('li').each(function(){
                                   	isAllFound = 1;			
					for(kvar=0;kvar<tokens.length;kvar++)
					{
					   if(!($(this).is(':Contains("'+tokens[kvar]+'")')) && tokens[kvar].length >2 )
					   {
							isAllFound = 0;		 	 
					   } else {
                                                $(this).show();
                                           }
					   
					}
					   if(ivar !=1 && isAllFound==1)
					   {
						 $(this).show();
						 isFound = 1;
					   }
					   ivar = ivar+1;
				  
				  });
				  if(isFound == 1)
					$helpDeskUl.find('li').first().show();
			  
    });

   
   $( "#showAllFaq" ).click(function(event) {
	   event.preventDefault();
       $( ".help-desk-items ul" ).find('li').show();
	   
   });
  
});
	
	
});
<?php header('X-Frame-Options:  ALLOW-FROM https://www.youtube.com/'); ?>
<?php header('X-Frame-Options:  SAMEORIGIN'); ?>
<?php header('X-Frame-Options: ALLOW'); ?>
<?php
$this->pageTitle=Yii::app()->name . ' - Help Desk';
$cs = Yii::app()->clientScript;
//$cs->registerScriptFile(Yii::app()->controller->assetsBase. '/js/helpdesk.js');
/* @var $this UserController */
/* @var $model User */
$session = new ChttpSession;
?>
<div >
<h1>Help Desk</h1>




<div class="row buttons" style="margin-top: 30px;">
         <input type="text" name="txt_search"  id="txt_search" value="" placeholder="Example: How do I add a new visit?" style="margin-bottom: 0;
  margin-left: 50px; width: 500px;"  />
		<input type="submit" name="searchFaq" id="searchFaq" value="Search" class="neutral"  />
        <input type="submit" name="showAllFaq" id="showAllFaq"  value="Show All" class="complete"  />
        <input type="submit" name="askAQuestion" class="complete" value="Ask a Question" onclick="window.location.href='<?php echo Yii::app()->createUrl("/dashboard/contactsupport"); ?>'"  />
	</div>




<section class="help-desk">
	
  
	<div class="help-desk-items">
	  <?php   foreach ($helpDeskGroupRecords as $key => $value) {	
	            $helpDeskRecords = HelpDesk::model()->getHelpDeskByGroup($value['id']);
				if(sizeof($helpDeskRecords)>0)
				{
	    ?>
    
    	<ul id="group_<?php echo $value['id']; ?>" class="help-desk-group">
<!--			<li class="help-desk-title"><h2><?php //echo $value['name']; ?></h2></li>-->
               <?php   
			   
			   foreach ($helpDeskRecords as $keyhelpdesk => $valuehelpdesk) {	  ?>
                    <li>
                           <a class="help-desk-trigger" href="#0" id="help_questions"><?php echo $valuehelpdesk['question']; ?></a>
                           <div class="help-desk-content">
                               <p><?php echo $valuehelpdesk['answer']; ?></p>
							   <?php if ($valuehelpdesk['videolink']!='' || $valuehelpdesk['videolink']!=null)
							   {
								   ?>
								   </br>
								   <iframe width="560" height="315" src="<?php echo $valuehelpdesk['videolink'];?>" frameborder="0" allowfullscreen></iframe>
							   <?php } ?>
                           </div> 
                    </li>
             <?php  } ?> 
            
		</ul>
    
      <?php  } 
	  }
	  ?> 
    </div> 
</section> 

<style>

.help-desk *::after,.help-desk *::before {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}

.help-desk *::after,.help-desk *::before {
  content: '';
}
.help-desk a:hover, .help-desk a:focus
{
	text-decoration:none;
	}
.help-desk:after {
  content: "";
  display: table;
  clear: both;
}
.help-desk-categories a::before, .help-desk-categories a::after {
  /* plus icon on the right */
  position: absolute;
  top: 50%;
  right: 16px;
  display: inline-block;
  height: 1px;
  width: 10px;
  background-color: #7f868e;
}
.help-desk-categories a::after {
  -webkit-transform: rotate(90deg);
  -moz-transform: rotate(90deg);
  -ms-transform: rotate(90deg);
  -o-transform: rotate(90deg);
  transform: rotate(90deg);
}
.help-desk-categories li:last-child a {
  border-bottom: none;
}
.no-js .help-desk-items {
  position: static;
  height: auto;
  width: 100%;
  -webkit-transform: translateX(0);
  -moz-transform: translateX(0);
  -ms-transform: translateX(0);
  -o-transform: translateX(0);
  transform: translateX(0);
      padding-left: 0;

}

  .help-desk-items {
    position: static;
    height: auto;
    width: 100%;
    float: none;
    overflow: visible;
    -webkit-transform: translateZ(0) translateX(0);
    -moz-transform: translateZ(0) translateX(0);
    -ms-transform: translateZ(0) translateX(0);
    -o-transform: translateZ(0) translateX(0);
    transform: translateZ(0) translateX(0);
    padding: 0;
    background: transparent;
  }

 

.cd-close-panel {
  position: fixed;
  top: 5px;
  right: -100%;
  display: block;
  height: 40px;
  width: 40px;
  overflow: hidden;
  text-indent: 100%;
  white-space: nowrap;
  z-index: 2;
  /* Force Hardware Acceleration in WebKit */
  -webkit-transform: translateZ(0);
  -moz-transform: translateZ(0);
  -ms-transform: translateZ(0);
  -o-transform: translateZ(0);
  transform: translateZ(0);
  -webkit-backface-visibility: hidden;
  backface-visibility: hidden;
  -webkit-transition: right 0.4s;
  -moz-transition: right 0.4s;
  transition: right 0.4s;
}
.cd-close-panel::before, .cd-close-panel::after {
  /* close icon in CSS */
  position: absolute;
  top: 16px;
  left: 12px;
  display: inline-block;
  height: 3px;
  width: 18px;
  background: #0088cc;
}
.cd-close-panel::before {
  -webkit-transform: rotate(45deg);
  -moz-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  -o-transform: rotate(45deg);
  transform: rotate(45deg);
}
.cd-close-panel::after {
  -webkit-transform: rotate(-45deg);
  -moz-transform: rotate(-45deg);
  -ms-transform: rotate(-45deg);
  -o-transform: rotate(-45deg);
  transform: rotate(-45deg);
}
.cd-close-panel.move-left {
  right: 2%;
}
@media only screen and (min-width: 768px) {
  .cd-close-panel {
    display: none;
  }
}

.help-desk-group {
  /* hide group not selected */
    display: block;
  list-style-type:none;
  margin:0;
}
.help-desk-group.selected {
  display: block;
}
.help-desk-group .help-desk-title {
  background: transparent;
  box-shadow: none;
  margin: 1em 0;
}
.no-touch .help-desk-group .help-desk-title:hover {
  box-shadow: none;
}
.help-desk-group .help-desk-title h2 {
  text-transform: uppercase;
  font-size: 12px;
    font-size: 1.0rem;
  padding-top: 16px;
  font-weight: 700;
  color: #bbbbc7;
}
.no-js .help-desk-group {
  display: block;
  
}

  .help-desk-group > li {
    background: #F5F5F5;
    margin-bottom: 6px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
    -webkit-transition: box-shadow 0.2s;
    -moz-transition: box-shadow 0.2s;
    transition: box-shadow 0.2s;
	padding-left: 20px;
	line-height:1;
  }
  .no-touch .help-desk-group > li:hover {
    box-shadow: 0 1px 10px rgba(108, 125, 142, 0.3);
  }
  .help-desk-group .help-desk-title {
    margin: 2em 0 1em;
  }
  .help-desk-group:first-child .help-desk-title {
    margin-top: 0;
  }


.help-desk-trigger {
  position: relative;
  display: block;
  margin: 1.6em 0 .4em;
  line-height: 1.2;
  font-size: 24px;
  font-size: 1.1rem;
  font-weight: 300;
  margin: 0;
  padding: 10px 32px 10px 0px;
}
@media only screen and (min-width: 768px) {
  .help-desk-trigger::before, .help-desk-trigger::after {
    /* arrow icon on the right */
    position: absolute;
    right: 28px;
    top: 50%;
    height: 2px;
    width: 8px;
    background: #0088cc;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    -webkit-transition-property: -webkit-transform;
    -moz-transition-property: -moz-transform;
    transition-property: transform;
    -webkit-transition-duration: 0.2s;
    -moz-transition-duration: 0.2s;
    transition-duration: 0.2s;
  }
  .help-desk-trigger::before {
    -webkit-transform: rotate(45deg);
    -moz-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    -o-transform: rotate(45deg);
    transform: rotate(45deg);
    right: 32px;
  }
  .help-desk-trigger::after {
    -webkit-transform: rotate(-45deg);
    -moz-transform: rotate(-45deg);
    -ms-transform: rotate(-45deg);
    -o-transform: rotate(-45deg);
    transform: rotate(-45deg);
  }
  .content-visible .help-desk-trigger::before {
    -webkit-transform: rotate(-45deg);
    -moz-transform: rotate(-45deg);
    -ms-transform: rotate(-45deg);
    -o-transform: rotate(-45deg);
    transform: rotate(-45deg);
  }
  .content-visible .help-desk-trigger::after {
    -webkit-transform: rotate(45deg);
    -moz-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    -o-transform: rotate(45deg);
    transform: rotate(45deg);
  }


.help-desk-content p {
  font-size: 14px;
  font-size: 0.875rem;
  line-height: 1.6;
  color: #6c7d8e;
  padding-bottom:15px;
  margin-bottom:0;
}
  .help-desk-content {
    display: none;
	
	
  }



</style>
<script>
jQuery.expr[":"].Contains = jQuery.expr.createPseudo(function(arg) {
    return function( elem ) {
        return jQuery(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
    };
});

jQuery(document).ready(function($){
	
	var sources = [];
	$('.help-desk-trigger').each(function(i,ele){
		sources.push({'label': $(ele).text(), 'value' : $(ele).text()});
		});
$( "#txt_search" ).autocomplete({
	minLength:3,
	max:2,
    source: sources
});
	
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
			 alert(txt_search);
			 if(txt_search!='')
			 {
				
			 $('.help-desk-group li:not(.help-desk-group li:Contains("'+txt_search+'"))').hide();
			 
			 
			 }
			else
				$('.help-desk-trigger').show();
				
    });

   
   $( "#showAllFaq" ).click(function(event) {
	   event.preventDefault();
       $( ".help-desk-group li" ).show();
	   
   });
  
});
	
	

</script>
</div>
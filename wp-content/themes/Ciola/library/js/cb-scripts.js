// IE8 ployfill for GetComputed Style (for Responsive Script below)
if (!window.getComputedStyle) {
    window.getComputedStyle = function(el) {"use strict";
        this.el = el;
        this.getPropertyValue = function(prop) {
            var re = /(\-([a-z]){1})/g;
            if (prop === 'float') { prop = 'styleFloat'; }
            if (re.test(prop)) {
                prop = prop.replace(re, function () {
                    return arguments[2].toUpperCase();
                });
            }
            return el.currentStyle[prop] ? el.currentStyle[prop] : null;
        };
        return this;
   };
}

/*! A fix for the iOS orientationchange zoom bug.
 Script by @scottjehl, rebound by @wilto.
 MIT / GPLv2 License.
*/
(function(w){"use strict"; 

	// This fix addresses an iOS bug, so return early if the UA claims it's something else.
	var ua = navigator.userAgent;
	if( !( /iPhone|iPad|iPod/.test( navigator.platform ) && /OS [1-5]_[0-9_]* like Mac OS X/i.test(ua) && ua.indexOf( "AppleWebKit" ) > -1 ) ){
		return;
	}

    var doc = w.document;

    if( !doc.querySelector ){ return; }

    var meta = doc.querySelector( "meta[name=viewport]" ),
        initialContent = meta && meta.getAttribute( "content" ),
        disabledZoom = initialContent + ",maximum-scale=1",
        enabledZoom = initialContent + ",maximum-scale=10",
        enabled = true,
		x, y, z, aig;

    if( !meta ){ return; }

    function restoreZoom(){
        meta.setAttribute( "content", enabledZoom );
        enabled = true;
    }

    function disableZoom(){
        meta.setAttribute( "content", disabledZoom );
        enabled = false;
    }

    function checkTilt( e ){
		aig = e.accelerationIncludingGravity;
		x = Math.abs( aig.x );
		y = Math.abs( aig.y );
		z = Math.abs( aig.z );

		// If portrait orientation and in one of the danger zones
        if( (!w.orientation || w.orientation === 180) && ( x > 7 || ( ( z > 6 && y < 8 || z < 8 && y > 6 ) && x > 5 ) ) ){
			if(enabled){disableZoom();}
        }
		else if( !enabled ){
			restoreZoom();
        }
    }

	w.addEventListener( "orientationchange", restoreZoom, false );
	w.addEventListener( "devicemotion", checkTilt, false );

})( this );

// as the page loads, call these scripts
jQuery(document).ready(function($) { "use strict";

    /* getting viewport width */
    var responsive_viewport = $(window).width();
    
    /* if is below 481px */
    if (responsive_viewport < 768) {

	//IE transitions
	if(!Modernizr.csstransitions) { 
		
					if ($('.cover-image').length){
						$(" #cb-content ").css("margin", "350px auto 0 auto");
					}
	}
    
    } /* end smallest screen */
    
    /* if is larger than 481px */
    if (responsive_viewport > 481) {
    /*global Modernizr */
    //IE transitions
	if(!Modernizr.csstransitions) {
		
		$(".gallery-icon img").hover(function(){
				$(this).stop().animate({'opacity':'0.5'}, 400);
				}, function(){
				$(this).stop().animate({'opacity':'1'}, 400);
			});
			if ($('.full-bg').length){
				$(" #cb-content ").css("margin", "600px auto 0 auto");
				$(" .backstretch span ").css("display", "none");
			}
		}
	
	/* Change div class if two module b's */
	$(".cb-half-mod:odd").addClass('spacer-left').after('<div class="clearfix"></div>');
	
	} /* end larger than 481px */
    
    /* if is above or equal to 768px */
    if (responsive_viewport >= 768) {
   
   /* load gravatars */
  $('.comment img[data-gravatar]').each(function(){$(this).attr('src',$(this).attr('data-gravatar'));});
    }
   
    $("#cb-mob-dropdown-top").click(function(){
		$("#cb-top-menu-mob ul").toggle();
	});

    $("#cb-mob-dropdown-main").click(function(){
		$("#cb-main-menu-mob ul").toggle();
	});

/*
	Totem Ticker Plugin
	Copyright (c) 2011 Zach Dunn / www.buildinternet.com
	Released under MIT License
	--------------------------
	Structure based on Doug Neiner's jQuery plugin blueprint: http://starter.pixelgraphics.us/
*/
(function( $ ){
	
	if(!$.omr){
      $.omr = {};
	}

	$.omr.totemticker = function(el, options ) {
      
      var base = this;
      
      //Define the DOM elements
      base.el = el;
      base.$el = $(el);
      
      // Add a reverse reference to the DOM object
      base.$el.data("omr.totemticker", base);
      
      base.init = function(){
        base.options = $.extend({},$.omr.totemticker.defaultOptions, options);
        
        //Adjust the height of ticker if specified
			base.format_ticker();
			
			//Setup navigation links (if specified)
			base.setup_nav();
			
			//Start the ticker
			base.start_interval();
			
			//Debugging info in console
			//base.debug_info();
        };
		
		base.start_interval = function(){
			
			//Clear out any existing interval
			clearInterval(base.ticker);
			
			if (base.options.direction === 'up') {
				//If the direction has been set to up
				base.ticker = setInterval(function() {
					base.$el.find('li:last').detach().prependTo(base.$el).css('marginTop', '-' + base.options.row_height);
					base.$el.find('li:first').animate({
                      marginTop: '0px'
                    }, base.options.speed, function () {
                      //Callback functions go here
                    });
                }, base.options.interval);
			}else{
				//Otherwise, run the default of down
              base.ticker = setInterval(function() {
                
                base.$el.find('li:first').animate({
                  marginTop: '-' + base.options.row_height
                }, base.options.speed, function() {
                  $(this).detach().css('marginTop', '0').appendTo(base.$el);
                });
              
              }, base.options.interval);
            }
        };
          base.reset_interval = function(){
            clearInterval(base.ticker);
            base.start_interval();
          };
        base.stop_interval = function(){
          clearInterval(base.ticker);
        };
        base.format_ticker = function(){
          if(typeof(base.options.max_items) !== "undefined" && base.options.max_items !== null) {
            //Remove units of measurement (Should expand to cover EM and % later)
            var stripped_height = base.options.row_height.replace(/px/i, '');
            var ticker_height = stripped_height * base.options.max_items;
			
				base.$el.css({
					height		: ticker_height + 'px', 
					overflow	: 'hidden'
				});
				
			}else{
				//No heights were specified, so just doublecheck overflow = hidden
				base.$el.css({
					overflow	: 'hidden'
				});
			}
			
		};
	
		base.setup_nav = function(){
			
			//Stop Button
			if (typeof(base.options.stop) !== "undefined"  && base.options.stop !== null){
				$(base.options.stop).click(function(){
					base.stop_interval();
					return false;
				});
			}
			
			//Start Button
			if (typeof(base.options.start) !== "undefined"  && base.options.start !== null){
				$(base.options.start).click(function(){
					base.start_interval();
					return false;
				});
			}
			
			//Previous Button
			if (typeof(base.options.previous) !== "undefined"  && base.options.previous !== null){
				$(base.options.previous).click(function(){
					base.$el.find('li:last').detach().prependTo(base.$el).css('marginTop', '-' + base.options.row_height);
					base.$el.find('li:first').animate({
                      marginTop: '0px'
                    }, base.options.speed, function () {
                      base.reset_interval();
                    });
                  return false;
                });
            }
			
			//Next Button
			if (typeof(base.options.next) !== "undefined" && base.options.next !== null){
				$(base.options.next).click(function(){
					base.$el.find('li:first').animate({
						marginTop: '-' + base.options.row_height
                    }, base.options.speed, function() {
                      $(this).detach().css('marginTop', '0px').appendTo(base.$el);
                      base.reset_interval();
                    });
                  return false;
                });
			}
			
			//Stop on mouse hover
			if (typeof(base.options.mousestop) !== "undefined" && base.options.mousestop === true) {
				base.$el.mouseenter(function(){
					base.stop_interval();
				}).mouseleave(function(){
					base.start_interval();
				});
			}
			
			/*
				TO DO List
				----------------
				Add a continuous scrolling mode
			*/
			
		};
		
		//base.debug_info = function()
		//{
			//Dump options into console
			//console.log(base.options);
		//};
		
		//Make it go!
		base.init();
  };
  
  $.omr.totemticker.defaultOptions = {
    message		:	'Ticker Loaded',	/* Disregard */
    next		:	null,		/* ID of next button or link */
    previous	:	null,		/* ID of previous button or link */
    stop		:	null,		/* ID of stop button or link */
    start		:	null,		/* ID of start button or link */
    row_height	:	'100px',	/* Height of each ticker row in PX. Should be uniform. */
    speed		:	800,		/* Speed of transition animation in milliseconds */
    interval	:	4000,		/* Time between change in milliseconds */
    max_items   :   null,       /* Integer for how many items to display at once. Resizes height accordingly (OPTIONAL) */
    mousestop	:	false,		/* If set to true, the ticker will stop on mouseover */
    direction	:	'down'		/* Direction that list will scroll */		
  };
  
  $.fn.totemticker = function( options ){
    return this.each(function(){
      (new $.omr.totemticker(this, options));
    });
  };
  
})( jQuery );


	/* Breaking News */			
	$('.cb-breaking-news ul').totemticker({
			row_height  :   '20px',
			mousestop   :   true
			
	});

	/* FitVid */
	$("#cb-container").fitVids();
	
	/* Toggle function */
	$('.toggle-content').hide();
	$('.toggle').click(function() {
		$(this).toggleClass('open').parent().next('.toggle-content').stop().slideToggle('easing');
		return false;
    });
	
	/* Tabs shuffling  */
	$("ul.tabs").tabs("div.panes > span",  {effect: 'fade', fadeOutSpeed: 0, fadeInSpeed: 500});
	 
	/* Add lightbox class */	
	$(".entry-content").find('a').has("img").each(function () {
        
        var cbImgTitle = $('img', this).attr( "title" );
        if (typeof cbImgTitle !== 'undefined') {
            $(this).attr('title', cbImgTitle);
        }
        if (typeof ( $(this).attr('href') ) !== 'undefined') {
	        var cbHref = $(this).attr('href').split('.');
	        var cbHrefExt = $(cbHref)[$(cbHref).length - 1];
	        
	        if ((cbHrefExt === 'jpg') || (cbHrefExt === 'jpeg') || (cbHrefExt === 'png') || (cbHrefExt === 'gif') || (cbHrefExt === 'tif')) {
	            $(this).addClass("cb-lightbox");
	        }
    	}
       
    });   
    
	
	/* Initialize LightBox */
	if (!!$.prototype.boxer) {
    	jQuery(".cb-lightbox").boxer({
    	duration: 500
    	});
	}
	/* Add rel to galleries */
	
	jQuery(".gallery").each(function (increment) {
	    var relVar = 'gallery' + increment;
	    jQuery(this).find('a').attr('rel', relVar);
	});
	    
	/* Dropdown menu */
	jQuery('.sf-menu').superfish({
		autoArrows:  true,
		disableHI: true,
		animation: {opacity:'show'}                
	});
});
	
jQuery(document).ready(function() {"use strict";
	
	jQuery('.flexslider').flexslider({
			animation: "fade",
			pauseOnAction: true
		});
	
	jQuery('.flexslider-e').flexslider({
		animation: "slide",
		itemWidth: 250,
		itemMargin: 20,
		animationSpeed: 450,
		slideshow: false,
		slideshowSpeed: 5000,
		animationLoop: false,
		minItems: 2,
		controlNav: false,
		maxItems: 2
	});
	jQuery('.flexslider-g').flexslider({
		animation: "slide",
		animationLoop: false,
		itemWidth: 160,
		animationSpeed: 450,
		itemMargin: 20,
		slideshow: false,
		minItems: 2,
		controlNav: false,
		maxItems: 3
	});
	jQuery('.flexslider-full').flexslider({
		animation: "slide",
		pauseOnAction: true
	});
});
	
	jQuery(window).load(function() {"use strict";
		var cb_amount = (jQuery("ul.tabbernav")).children().length;	
		if (cb_amount === 4) { jQuery("ul.tabbernav").addClass("cb-fourtabs");}
		if (cb_amount === 3) { jQuery("ul.tabbernav").addClass("cb-threetabs");}
		if (cb_amount === 2) { jQuery("ul.tabbernav").addClass("cb-twotabs");}
		if (cb_amount === 1) { jQuery("ul.tabbernav").addClass("cb-onetab");}
	});
	
	jQuery(document).ready(function($) {"use strict";

		/* Add first to image gallery */
		$(".gallery-item:nth-child(5n+1)").addClass('first');

	/* To Top Button */
	jQuery(window).scroll(function() {
		if(jQuery(this).scrollTop () > 1500) {
			 jQuery(".cb-to-top").fadeIn(300);
		} else { 
			jQuery(".cb-to-top").fadeOut(300);
			} 
		});
		
		jQuery('.cb-to-top').click(function(event) {
			$("html, body").animate( {scrollTop:0}, 600);
			event.preventDefault();
		});
});
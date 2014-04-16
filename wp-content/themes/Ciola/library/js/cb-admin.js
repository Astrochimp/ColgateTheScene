jQuery(document).ready(function(){"use strict";
	
	jQuery('.cb-about-options-title').after(jQuery('.cb-about-options'));
	 
	if (jQuery("input#cb_review_checkbox").is(":checked")) {
        jQuery(".review-main").show();
     }
     
     jQuery("input#cb_review_checkbox").click(function(){
			jQuery(".review-main").toggle();
	 });
		
    function updateScore() {	
    	
    	    // Get scores
    		var i = 0;
    		var score1 = parseFloat(jQuery("#cb_rating_1_score").val());		
    		var score2 = parseFloat(jQuery("#cb_rating_2_score").val());	
    		var score3 = parseFloat(jQuery("#cb_rating_3_score").val());		
    		var score4 = parseFloat(jQuery("#cb_rating_4_score").val());	
    		var score5 = parseFloat(jQuery("#cb_rating_5_score").val());		
    		var score6 = parseFloat(jQuery("#cb_rating_6_score").val());	
    		
    		// Count number of scores
    		if (score1){i+=1;} else {score1 = 0;}
    		if (score2){i+=1;} else {score2 = 0;}
    		if (score3){i+=1;} else {score3 = 0;}
    		if (score4){i+=1;} else {score4 = 0;}
    		if (score5){i+=1;} else {score5 = 0;}
    		if (score6){i+=1;} else {score6 = 0;}
    		
    		// Calculate final score
    		var tempTotal = (score1 + score2 + score3 + score4 + score5 + score6);
    		var total = tempTotal / i;
            jQuery("#cb_final_score").val(total);
    }

/* Copyright (c) 2013 Brandon Aaron (http://brandonaaron.net) Licensed under the MIT License  */
(function(c){var a=["DOMMouseScroll","mousewheel"];c.event.special.mousewheel={setup:function(){if(this.addEventListener){for(var d=a.length;d;){this.addEventListener(a[--d],b,false);}}else{this.onmousewheel=b;}},teardown:function(){if(this.removeEventListener){for(var d=a.length;d;){this.removeEventListener(a[--d],b,false);}}else{this.onmousewheel=null;}}};c.fn.extend({mousewheel:function(d){return d?this.bind("mousewheel",d):this.trigger("mousewheel");},unmousewheel:function(d){return this.unbind("mousewheel",d);}});function b(i){var g=i||window.event,f=[].slice.call(arguments,1),j=0,e=0,d=0;i=c.event.fix(g);i.type="mousewheel";if(i.wheelDelta){j=i.wheelDelta/120;}if(i.detail){j=-i.detail/3;}d=j;if(g.axis!==undefined&&g.axis===g.HORIZONTAL_AXIS){d=0;e=-1*j;}if(g.wheelDeltaY!==undefined){d=g.wheelDeltaY/120;}if(g.wheelDeltaX!==undefined){e=-1*g.wheelDeltaX/120;}f.unshift(i,j,e,d);/*jshint validthis: true */return c.event.handle.apply(this,f);}})(jQuery);

    jQuery(document).on("change", "#cb_rating_1_score, #cb_rating_2_score, #cb_rating_3_score, #cb_rating_4_score, #cb_rating_5_score, #cb_rating_6_score", updateScore);
    jQuery(document).on("mousewheel", "#cb_rating_1_score, #cb_rating_2_score, #cb_rating_3_score, #cb_rating_4_score, #cb_rating_5_score, #cb_rating_6_score", updateScore);
    jQuery(document).on("click", "#cb_rating_1_score, #cb_rating_2_score, #cb_rating_3_score, #cb_rating_4_score, #cb_rating_5_score, #cb_rating_6_score", updateScore);
    jQuery(document).on("keyup", "#cb_rating_1_score, #cb_rating_2_score, #cb_rating_3_score, #cb_rating_4_score, #cb_rating_5_score, #cb_rating_6_score", updateScore);

});
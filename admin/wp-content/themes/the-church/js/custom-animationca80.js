jQuery(window).scroll(function() {						   
	   
	jQuery('#pagearea .container .fourpagebox').each(function(){
		var imagePos = jQuery(this).offset().top;
		var topOfWindow = jQuery(window).scrollTop();
			if (imagePos < topOfWindow+400) {
				jQuery(this).addClass("fadeInUp");
			}
		});	
	
	jQuery('#welcomearea .container .one_half').each(function(){
		var imagePos = jQuery(this).offset().top;
		var topOfWindow = jQuery(window).scrollTop();
			if (imagePos < topOfWindow+400) {
				jQuery(this).addClass("fadeInDown");
			}
		});	
	
	jQuery('#section1 .container').each(function(){
		var imagePos = jQuery(this).offset().top;
		var topOfWindow = jQuery(window).scrollTop();
			if (imagePos < topOfWindow+400) {
				jQuery(this).addClass("pulse");
			}
		});
	
	jQuery('#section2 .container .column-event').each(function(){
		var imagePos = jQuery(this).offset().top;
		var topOfWindow = jQuery(window).scrollTop();
			if (imagePos < topOfWindow+400) {
				jQuery(this).addClass("fadeIn");
			}
		});
	
	jQuery('#section3 .container .about-me').each(function(){
		var imagePos = jQuery(this).offset().top;
		var topOfWindow = jQuery(window).scrollTop();
			if (imagePos < topOfWindow+400) {
				jQuery(this).addClass("fadeInDown");
			}
		});
	
	jQuery('#section4 .container').each(function(){
		var imagePos = jQuery(this).offset().top;
		var topOfWindow = jQuery(window).scrollTop();
			if (imagePos < topOfWindow+400) {
				jQuery(this).addClass("bounceIn");
			}
		});
	
	jQuery('#section5 .container .news-box').each(function(){
		var imagePos = jQuery(this).offset().top;
		var topOfWindow = jQuery(window).scrollTop();
			if (imagePos < topOfWindow+400) {
				jQuery(this).addClass("fadeIn");
			}
		});
	
	jQuery('#section6 .container .teammember-list').each(function(){
		var imagePos = jQuery(this).offset().top;
		var topOfWindow = jQuery(window).scrollTop();
			if (imagePos < topOfWindow+400) {
				jQuery(this).addClass("flipInX");
			}
		});

	jQuery('#section8 .container').each(function(){
		var imagePos = jQuery(this).offset().top;
		var topOfWindow = jQuery(window).scrollTop();
			if (imagePos < topOfWindow+400) {
				jQuery(this).addClass("fadeInUp");
			}
		});	
		
	jQuery('#section9 .container').each(function(){
		var imagePos = jQuery(this).offset().top;
		var topOfWindow = jQuery(window).scrollTop();
			if (imagePos < topOfWindow+400) {
				jQuery(this).addClass("fadeInDown");
			}
		});	
		
	});
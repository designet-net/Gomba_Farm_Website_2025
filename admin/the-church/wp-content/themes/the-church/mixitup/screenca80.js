
jQuery(window).load(function(){

	/* Isotope Portfolio */
	var $container = jQuery('.portfolio');
	$container.isotope({
		filter: '*',
		animationOptions: {
			duration: 500,
			easing: 'linear',
			queue: false
		}
	});

	jQuery(window).resize(function() {
		setTimeout(function() {jQuery('.portfolio').isotope('reLayout');},550);
	});

	jQuery('.portfolio').isotope('reLayout');

	jQuery('ul.portfoliofilter a').click(function(){
		var selector = jQuery(this).attr('data-filter');
		$container.isotope({
			filter: selector,
			animationOptions: {
				duration: 500,
				easing: 'linear',
				queue: false
			}
		});
	  return false;
	});

	var $optionSets = jQuery('ul.portfoliofilter'),
	       $optionLinks = $optionSets.find('a');
	       $optionLinks.click(function(){
	          var $this = jQuery(this);
		  // don't proceed if already selected
		  if ( $this.hasClass('selected') ) {
		      return false;
		  }
	   var $optionSet = $this.parents('ul.portfoliofilter');
	   $optionSet.find('.selected').removeClass('selected');
	   $this.addClass('selected');
	});

	jQuery('.isotope-item').hover(function() {
		var item = jQuery(this);
		var textholder = item.find('.foliotextholder')

		item.find('.folio_underlay').css({paddingBottom:35 + textholder.height()+"px"});
	});

});


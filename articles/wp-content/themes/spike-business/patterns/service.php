<?php
/**
 * Title: Service
 * Slug: spike-business/service
 * Categories: service
 */
$spike_business_img = array(
	SPIKE_BUSINESS_URL . 'assets/images/service-img1.png',
	SPIKE_BUSINESS_URL . 'assets/images/service-img2.png',
	SPIKE_BUSINESS_URL . 'assets/images/service-img3.png',
	SPIKE_BUSINESS_URL . 'assets/images/service-img4.png',
);
?>

<!-- wp:group {"style":{"spacing":{"blockGap":"0","padding":{"top":"var:preset|spacing|xx-large","bottom":"var:preset|spacing|xx-large","left":"var:preset|spacing|x-small","right":"var:preset|spacing|x-small"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--xx-large);padding-right:var(--wp--preset--spacing--x-small);padding-bottom:var(--wp--preset--spacing--xx-large);padding-left:var(--wp--preset--spacing--x-small)"><!-- wp:columns {"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|large"},"blockGap":{"top":"var:preset|spacing|x-small"}}}} -->
<div class="wp-block-columns" style="margin-bottom:var(--wp--preset--spacing--large)"><!-- wp:column {"width":"55%","style":{"spacing":{"blockGap":"0"}}} -->
<div class="wp-block-column" style="flex-basis:55%"><!-- wp:heading {"level":6,"style":{"spacing":{"margin":{"top":"0","bottom":"var:preset|spacing|xx-small","right":"0","left":"0px"}},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}},"typography":{"fontStyle":"normal","fontWeight":"600"}},"textColor":"secondary","fontSize":"small"} -->
<h6 class="wp-block-heading has-secondary-color has-text-color has-link-color has-small-font-size" style="margin-top:0;margin-right:0;margin-bottom:var(--wp--preset--spacing--xx-small);margin-left:0px;font-style:normal;font-weight:600"><?php echo esc_html__( 'OUR SERVICES', 'spike-business' ); ?></h6>
<!-- /wp:heading -->

<!-- wp:heading {"style":{"typography":{"fontStyle":"normal","fontWeight":"700","lineHeight":"1.1"}}} -->
<h2 class="wp-block-heading" style="font-style:normal;font-weight:700;line-height:1.1"><strong><?php echo esc_html__( 'Our Flowless Services', 'spike-business' ); ?></strong></h2>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"25%"} -->
<div class="wp-block-column" style="flex-basis:25%"></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"20%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:20%"><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"left"}} -->
<div class="wp-block-buttons"><!-- wp:button {"textAlign":"right","style":{"spacing":{"padding":{"left":"var:preset|spacing|small","right":"var:preset|spacing|small","top":"var:preset|spacing|x-small","bottom":"var:preset|spacing|x-small"}},"border":{"radius":"30px"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-align-right wp-element-button" style="border-radius:30px;padding-top:var(--wp--preset--spacing--x-small);padding-right:var(--wp--preset--spacing--small);padding-bottom:var(--wp--preset--spacing--x-small);padding-left:var(--wp--preset--spacing--small)"><?php echo esc_html__( 'View All Services', 'spike-business' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|small","left":"var:preset|spacing|medium"}}}} -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-bk-box-shadow is-style-sb-box-shadow-medium","style":{"spacing":{"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"}},"border":{"radius":"18px"}},"backgroundColor":"background","layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-bk-box-shadow is-style-sb-box-shadow-medium has-background-background-color has-background" style="border-radius:18px;padding-top:var(--wp--preset--spacing--medium);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--medium);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:image {"id":34,"sizeSlug":"full","linkDestination":"none","className":"is-style-default"} -->
<figure class="wp-block-image size-full is-style-default"><img src="<?php echo esc_url($spike_business_img[0]); ?>" alt="" class="wp-image-34"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":4,"style":{"spacing":{"margin":{"top":"var:preset|spacing|small"}}},"fontSize":"large"} -->
<h4 class="wp-block-heading has-large-font-size" style="margin-top:var(--wp--preset--spacing--small)"><?php echo esc_html__( 'Media Marketing Management', 'spike-business' ); ?></h4>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|small"}}},"fontSize":"small"} -->
<p class="has-small-font-size" style="margin-bottom:var(--wp--preset--spacing--small)"><?php echo esc_html__( 'We provide digital strategies, products and services that appreciated by clients.', 'spike-business' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"style":{"typography":{"fontStyle":"normal","fontWeight":"300"},"spacing":{"padding":{"left":"var:preset|spacing|x-small","right":"var:preset|spacing|x-small","top":"var:preset|spacing|xx-small","bottom":"var:preset|spacing|xx-small"}},"border":{"radius":"30px"}},"fontSize":"x-small"} -->
<div class="wp-block-button has-custom-font-size has-x-small-font-size" style="font-style:normal;font-weight:300"><a class="wp-block-button__link wp-element-button" style="border-radius:30px;padding-top:var(--wp--preset--spacing--xx-small);padding-right:var(--wp--preset--spacing--x-small);padding-bottom:var(--wp--preset--spacing--xx-small);padding-left:var(--wp--preset--spacing--x-small)"><?php echo esc_html__( 'Read More', 'spike-business' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-bk-box-shadow is-style-sb-box-shadow-medium","style":{"spacing":{"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"}},"border":{"radius":"18px"}},"backgroundColor":"background","layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-bk-box-shadow is-style-sb-box-shadow-medium has-background-background-color has-background" style="border-radius:18px;padding-top:var(--wp--preset--spacing--medium);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--medium);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:image {"id":35,"sizeSlug":"full","linkDestination":"none","className":"is-style-default"} -->
<figure class="wp-block-image size-full is-style-default"><img src="<?php echo esc_url($spike_business_img[1]); ?>" alt="" class="wp-image-35"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":4,"style":{"spacing":{"margin":{"top":"var:preset|spacing|small"}}},"fontSize":"large"} -->
<h4 class="wp-block-heading has-large-font-size" style="margin-top:var(--wp--preset--spacing--small)"><?php echo esc_html__( 'Media Market Management', 'spike-business' ); ?></h4>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|small"}}},"fontSize":"small"} -->
<p class="has-small-font-size" style="margin-bottom:var(--wp--preset--spacing--small)"><?php echo esc_html__( 'We provide digital strategies, products and services that appreciated by clients.', 'spike-business' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"style":{"typography":{"fontStyle":"normal","fontWeight":"300"},"spacing":{"padding":{"left":"var:preset|spacing|x-small","right":"var:preset|spacing|x-small","top":"var:preset|spacing|xx-small","bottom":"var:preset|spacing|xx-small"}},"border":{"radius":"30px"}},"fontSize":"x-small"} -->
<div class="wp-block-button has-custom-font-size has-x-small-font-size" style="font-style:normal;font-weight:300"><a class="wp-block-button__link wp-element-button" style="border-radius:30px;padding-top:var(--wp--preset--spacing--xx-small);padding-right:var(--wp--preset--spacing--x-small);padding-bottom:var(--wp--preset--spacing--xx-small);padding-left:var(--wp--preset--spacing--x-small)"><?php echo esc_html__( 'Read More', 'spike-business' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-bk-box-shadow is-style-sb-box-shadow-medium","style":{"spacing":{"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"}},"border":{"radius":"18px"}},"backgroundColor":"background","layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-bk-box-shadow is-style-sb-box-shadow-medium has-background-background-color has-background" style="border-radius:18px;padding-top:var(--wp--preset--spacing--medium);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--medium);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:image {"id":36,"sizeSlug":"full","linkDestination":"none","className":"is-style-default"} -->
<figure class="wp-block-image size-full is-style-default"><img src="<?php echo esc_url($spike_business_img[2]); ?>" alt="" class="wp-image-36"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":4,"style":{"spacing":{"margin":{"top":"var:preset|spacing|small"}}},"fontSize":"large"} -->
<h4 class="wp-block-heading has-large-font-size" style="margin-top:var(--wp--preset--spacing--small)"><?php echo esc_html__( 'Project Mission Visualization', 'spike-business' ); ?></h4>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|small"}}},"fontSize":"small"} -->
<p class="has-small-font-size" style="margin-bottom:var(--wp--preset--spacing--small)"><?php echo esc_html__( 'We provide digital strategies, products and services that appreciated by clients.', 'spike-business' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"style":{"typography":{"fontStyle":"normal","fontWeight":"300"},"spacing":{"padding":{"left":"var:preset|spacing|x-small","right":"var:preset|spacing|x-small","top":"var:preset|spacing|xx-small","bottom":"var:preset|spacing|xx-small"}},"border":{"radius":"30px"}},"fontSize":"x-small"} -->
<div class="wp-block-button has-custom-font-size has-x-small-font-size" style="font-style:normal;font-weight:300"><a class="wp-block-button__link wp-element-button" style="border-radius:30px;padding-top:var(--wp--preset--spacing--xx-small);padding-right:var(--wp--preset--spacing--x-small);padding-bottom:var(--wp--preset--spacing--xx-small);padding-left:var(--wp--preset--spacing--x-small)"><?php echo esc_html__( 'Read More', 'spike-business' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-bk-box-shadow is-style-sb-box-shadow-medium","style":{"spacing":{"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"}},"border":{"radius":"18px"}},"backgroundColor":"background","layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-bk-box-shadow is-style-sb-box-shadow-medium has-background-background-color has-background" style="border-radius:18px;padding-top:var(--wp--preset--spacing--medium);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--medium);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:image {"id":37,"sizeSlug":"full","linkDestination":"none","className":"is-style-default"} -->
<figure class="wp-block-image size-full is-style-default"><img src="<?php echo esc_url($spike_business_img[3]); ?>" alt="" class="wp-image-37"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":4,"style":{"spacing":{"margin":{"top":"var:preset|spacing|small"}}},"fontSize":"large"} -->
<h4 class="wp-block-heading has-large-font-size" style="margin-top:var(--wp--preset--spacing--small)"><?php echo wp_kses_post( html_entity_decode( esc_html__( 'Policy Creation &amp; Plan Process' , 'spike-business' ) ) ); ?></h4>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|small"}}},"fontSize":"small"} -->
<p class="has-small-font-size" style="margin-bottom:var(--wp--preset--spacing--small)"><?php echo esc_html__( 'We provide digital strategies, products and services that appreciated by clients.', 'spike-business' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"style":{"typography":{"fontStyle":"normal","fontWeight":"300"},"spacing":{"padding":{"left":"var:preset|spacing|x-small","right":"var:preset|spacing|x-small","top":"var:preset|spacing|xx-small","bottom":"var:preset|spacing|xx-small"}},"border":{"radius":"30px"}},"fontSize":"x-small"} -->
<div class="wp-block-button has-custom-font-size has-x-small-font-size" style="font-style:normal;font-weight:300"><a class="wp-block-button__link wp-element-button" style="border-radius:30px;padding-top:var(--wp--preset--spacing--xx-small);padding-right:var(--wp--preset--spacing--x-small);padding-bottom:var(--wp--preset--spacing--xx-small);padding-left:var(--wp--preset--spacing--x-small)"><?php echo esc_html__( 'Read More', 'spike-business' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
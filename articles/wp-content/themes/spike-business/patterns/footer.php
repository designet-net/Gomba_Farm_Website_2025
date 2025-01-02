<?php
/**
 * Title: Footer
 * Slug: spike-business/footer
 * Categories: footer
 */
$spike_business_img = array(
	SPIKE_BUSINESS_URL . 'assets/images/footer-img1.jpg',
);
?>

<!-- wp:cover {"url":"<?php echo esc_url($spike_business_img[0]); ?>","id":73,"dimRatio":90,"overlayColor":"primary","isUserOverlayColor":true,"minHeight":50,"style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover" style="padding-top:0;padding-bottom:0;min-height:50px"><span aria-hidden="true" class="wp-block-cover__background has-primary-background-color has-background-dim-90 has-background-dim"></span><img class="wp-block-cover__image-background wp-image-73" alt="" src="<?php echo esc_url($spike_business_img[0]); ?>" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|medium","left":"var:preset|spacing|medium"},"padding":{"top":"var:preset|spacing|xx-large","bottom":"var:preset|spacing|medium"}}}} -->
<div class="wp-block-columns" style="padding-top:var(--wp--preset--spacing--xx-large);padding-bottom:var(--wp--preset--spacing--medium)"><!-- wp:column {"width":"30%","style":{"spacing":{"padding":{"bottom":"var:preset|spacing|xx-small"}}}} -->
<div class="wp-block-column" style="padding-bottom:var(--wp--preset--spacing--xx-small);flex-basis:30%"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|xx-small"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:site-logo {"width":36} /-->

<!-- wp:site-title {"style":{"typography":{"fontStyle":"normal","fontWeight":"600"}},"fontSize":"medium"} /--></div>
<!-- /wp:group -->

<!-- wp:paragraph {"style":{"spacing":{"padding":{"right":"var:preset|spacing|medium"}}},"fontSize":"small"} -->
<p class="has-small-font-size" style="padding-right:var(--wp--preset--spacing--medium)"><?php echo esc_html__( 'Nisl libero ullamcorper id ipsum viverra mauris non pellentesque placerat lorem lacinia sagittis non pretium aliquet, fames quo repudiandae.', 'spike-business' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"20%","style":{"spacing":{"padding":{"bottom":"var:preset|spacing|xx-small"}}}} -->
<div class="wp-block-column" style="padding-bottom:var(--wp--preset--spacing--xx-small);flex-basis:20%"><!-- wp:heading {"level":5,"style":{"typography":{"textTransform":"uppercase","letterSpacing":"1px"}},"fontSize":"small"} -->
<h5 class="wp-block-heading has-small-font-size" style="letter-spacing:1px;text-transform:uppercase"><?php echo esc_html__( 'Products', 'spike-business' ); ?></h5>
<!-- /wp:heading -->

<!-- wp:navigation {"ref":114,"style":{"spacing":{"blockGap":"var:preset|spacing|xx-small"}},"fontSize":"small","layout":{"type":"flex","orientation":"vertical","justifyContent":"left"}} /--></div>
<!-- /wp:column -->

<!-- wp:column {"width":"20%","style":{"spacing":{"padding":{"bottom":"var:preset|spacing|xx-small"}}}} -->
<div class="wp-block-column" style="padding-bottom:var(--wp--preset--spacing--xx-small);flex-basis:20%"><!-- wp:heading {"level":5,"style":{"typography":{"textTransform":"uppercase","letterSpacing":"1px"}},"fontSize":"small"} -->
<h5 class="wp-block-heading has-small-font-size" style="letter-spacing:1px;text-transform:uppercase"><?php echo esc_html__( 'Company', 'spike-business' ); ?></h5>
<!-- /wp:heading -->

<!-- wp:navigation {"ref":23,"style":{"spacing":{"blockGap":"var:preset|spacing|xx-small"}},"fontSize":"small","layout":{"type":"flex","orientation":"vertical"}} /--></div>
<!-- /wp:column -->

<!-- wp:column {"width":"30%","style":{"spacing":{"padding":{"bottom":"var:preset|spacing|xx-small"}}}} -->
<div class="wp-block-column" style="padding-bottom:var(--wp--preset--spacing--xx-small);flex-basis:30%"><!-- wp:heading {"level":5,"style":{"typography":{"textTransform":"uppercase","letterSpacing":"1px"}},"fontSize":"small"} -->
<h5 class="wp-block-heading has-small-font-size" style="letter-spacing:1px;text-transform:uppercase"><?php echo esc_html__( 'OUR Newsletter', 'spike-business' ); ?></h5>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size"><?php echo esc_html__( 'Please subscribe to our newsletter to get all the great Offers', 'spike-business' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"style":{"border":{"radius":"30px"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" style="border-radius:30px"><?php echo esc_html__( 'JOIN US NOW', 'spike-business' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|xx-small","padding":{"top":"0","bottom":"var:preset|spacing|small"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
<div class="wp-block-group" style="padding-top:0;padding-bottom:var(--wp--preset--spacing--small)"><!-- wp:paragraph {"align":"center","fontSize":"x-small"} -->
<p class="has-text-align-center has-x-small-font-size"><?php echo esc_html__( '© 2024.', 'spike-business' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:site-title {"style":{"typography":{"fontStyle":"normal","fontWeight":"400"}},"fontSize":"x-small"} /-->

<!-- wp:paragraph {"align":"center","fontSize":"x-small"} -->
<p class="has-text-align-center has-x-small-font-size"><?php echo esc_html__( 'All rights reserved', 'spike-business' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->

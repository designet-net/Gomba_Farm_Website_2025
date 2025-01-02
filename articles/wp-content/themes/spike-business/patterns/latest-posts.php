<?php
/**
 * Title: Latest Posts
 * Slug: spike-business/latest-posts
 * Categories: latest-posts
 */
?>

<!-- wp:group {"align":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|xx-large","bottom":"var:preset|spacing|xx-large","left":"var:preset|spacing|x-small","right":"var:preset|spacing|x-small"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--xx-large);padding-right:var(--wp--preset--spacing--x-small);padding-bottom:var(--wp--preset--spacing--xx-large);padding-left:var(--wp--preset--spacing--x-small)"><!-- wp:columns {"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|large"},"blockGap":{"top":"var:preset|spacing|x-small"}}}} -->
<div class="wp-block-columns" style="margin-bottom:var(--wp--preset--spacing--large)"><!-- wp:column {"width":"55%","style":{"spacing":{"blockGap":"0"}}} -->
<div class="wp-block-column" style="flex-basis:55%"><!-- wp:heading {"level":6,"style":{"spacing":{"margin":{"top":"0","bottom":"var:preset|spacing|xx-small","right":"0","left":"0px"}},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}},"typography":{"fontStyle":"normal","fontWeight":"600"}},"textColor":"secondary","fontSize":"small"} -->
<h6 class="wp-block-heading has-secondary-color has-text-color has-link-color has-small-font-size" style="margin-top:0;margin-right:0;margin-bottom:var(--wp--preset--spacing--xx-small);margin-left:0px;font-style:normal;font-weight:600"><?php echo esc_html__( 'OUR BLOG', 'spike-business' ); ?></h6>
<!-- /wp:heading -->

<!-- wp:heading {"style":{"typography":{"fontStyle":"normal","fontWeight":"700","lineHeight":"1.1"}}} -->
<h2 class="wp-block-heading" style="font-style:normal;font-weight:700;line-height:1.1"><?php echo wp_kses_post( html_entity_decode( esc_html__( 'Our Latest Articles &amp; Blog' , 'spike-business' ) ) ); ?></h2>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"25%"} -->
<div class="wp-block-column" style="flex-basis:25%"></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"20%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:20%"><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"left"}} -->
<div class="wp-block-buttons"><!-- wp:button {"textAlign":"right","style":{"spacing":{"padding":{"left":"var:preset|spacing|small","right":"var:preset|spacing|small","top":"var:preset|spacing|x-small","bottom":"var:preset|spacing|x-small"}},"border":{"radius":"30px"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-align-right wp-element-button" style="border-radius:30px;padding-top:var(--wp--preset--spacing--x-small);padding-right:var(--wp--preset--spacing--small);padding-bottom:var(--wp--preset--spacing--x-small);padding-left:var(--wp--preset--spacing--small)"><?php echo esc_html__( 'View All Blog', 'spike-business' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:query {"queryId":42,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"layout":{"type":"default"}} -->
<div class="wp-block-query"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|medium"}},"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:group {"className":"is-style-bk-box-shadow is-style-sb-box-shadow-medium","style":{"spacing":{"blockGap":"var:preset|spacing|xx-small","padding":{"top":"0","bottom":"var:preset|spacing|medium","right":"0","left":"0"}},"border":{"radius":"12px"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group is-style-bk-box-shadow is-style-sb-box-shadow-medium" style="border-radius:12px;padding-top:0;padding-right:0;padding-bottom:var(--wp--preset--spacing--medium);padding-left:0"><!-- wp:post-featured-image {"isLink":true,"width":"","height":"","style":{"border":{"radius":{"topLeft":"12px","topRight":"12px","bottomLeft":"0px","bottomRight":"0px"}},"layout":{"selfStretch":"fit","flexSize":null}}} /-->

<!-- wp:group {"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"right":"var:preset|spacing|medium","left":"var:preset|spacing|medium","top":"var:preset|spacing|x-small"}}},"layout":{"type":"constrained","justifyContent":"left"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--x-small);padding-right:var(--wp--preset--spacing--medium);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:post-title {"level":5,"style":{"typography":{"fontStyle":"normal","fontWeight":"700","lineHeight":"1.2"}}} /-->

<!-- wp:post-excerpt {"moreText":"","excerptLength":10,"className":"link-no-underline","fontSize":"small"} /-->

<!-- wp:read-more {"style":{"typography":{"fontStyle":"normal","fontWeight":"500"},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"textColor":"primary","fontSize":"small","fontFamily":"body"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->
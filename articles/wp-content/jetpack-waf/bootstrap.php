<?php
define( 'DISABLE_JETPACK_WAF', false );
if ( defined( 'DISABLE_JETPACK_WAF' ) && DISABLE_JETPACK_WAF ) return;
define( 'JETPACK_WAF_MODE', 'silent' );
define( 'JETPACK_WAF_SHARE_DATA', false );
define( 'JETPACK_WAF_SHARE_DEBUG_DATA', false );
define( 'JETPACK_WAF_DIR', '/home3/novus6sk/terissalittleflower.org/articles/wp-content/jetpack-waf' );
define( 'JETPACK_WAF_WPCONFIG', '/home3/novus6sk/terissalittleflower.org/articles/wp-content/../wp-config.php' );
define( 'JETPACK_WAF_ENTRYPOINT', 'rules/rules.php' );
require_once '/home3/novus6sk/terissalittleflower.org/articles/wp-content/plugins/jetpack/vendor/autoload.php';
Automattic\Jetpack\Waf\Waf_Runner::initialize();

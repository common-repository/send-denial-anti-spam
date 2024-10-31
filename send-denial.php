<?php
/**
 * Plugin Name: Send Denial (Anti Spam Sentinel)
 * Description: Adds javascript based honeypot validation to all major forms and blocks spam in GDPR Compliance.
 * Version: 1.0.10
 * Text Domain: send-denial
 * Author: Julian Lang
 * Author URI: https://senddenial.com
 * Domain Path: /languages
 */

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if( ! function_exists( 'get_plugin_data' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

$plugin_data = get_plugin_data( __FILE__ );
$plugin_version = $plugin_data['Version'];

define( 'SEDE_PLUGIN_VERSION', $plugin_version );
define( 'SEDE_PLUGIN_SLUG', 'send-denial' );
define( 'SEDE_PREFIX', 'SEDE' );
define( 'SEDE_CORE_PATH', plugin_dir_path(__FILE__) );
define( 'SEDE_CORE_URL', plugin_dir_url(__FILE__) );

/**
 * Core Autoloader
 */
spl_autoload_register(function ( $class_name ) {
    $prefix = SEDE_PREFIX;

    $len = strlen( $prefix );

    if ( 0 !== strncmp( $prefix, $class_name, $len ) ) {
        return;
    }

    $relative_class = substr( $class_name, $len );

    $path = explode( '\\', strtolower( str_replace( '_', '-', $relative_class ) ) );
    $file = array_pop( $path );
    $file = SEDE_CORE_PATH . implode( '/', $path ) . '/class-' . $file . '.php';

    if ( file_exists( $file ) ) {
        require $file;
    }
});

new \SEDE\Core\Init();

/**
 * Initialize Languages
 */
function sede_load_textdomain( $mofile, $domain ) {

	if ( 'send-denial' === $domain && false !== strpos( $mofile, WP_LANG_DIR . '/plugins/' ) ) {

		$locale = apply_filters( 'plugin_locale', determine_locale(), $domain );
		$mofile = WP_PLUGIN_DIR . '/' . dirname( plugin_basename( __FILE__ ) ) . '/languages/' . $domain . '-' . $locale . '.mo';

	}

	return $mofile;

}
add_filter( 'load_textdomain_mofile', 'sede_load_textdomain', 10, 2 );


/**
 * Activation initial setting of honeypot values
 */
function sede_activate() {

    $sede_plugin_options = get_option( 'sede_plugin_options' );
    if ( empty( $sede_plugin_options ) ) {

        $fieldname  = \SEDE\Core\Helper::create_token();
        $token      = \SEDE\Core\Helper::create_token();

        $sede_plugin_options = array(
            'fieldname'         =>  $fieldname,
            'token'             =>  $token,
            'show_credits'      =>  0,
            'anonymize_logs'    =>  1
        );

        add_option( 'sede_plugin_options', $sede_plugin_options );

    }

}
register_activation_hook( __FILE__, 'sede_activate' );
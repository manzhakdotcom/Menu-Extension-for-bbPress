<?php
/*
Plugin Name: Menu Extension for bbPress
Plugin URI: http://www.manzhak.com/menu-extension-for-bbpress
Description: You can now add bbPress links in your WP menus.
Version: 0.0.6
Text Domain: menu-extension-for-bbpress
Author: Sergius Manzhak
Author URI: http://www.manzhak.com/

Text Domain: menu-extension-for-bbpress
Domain Path: /languages/
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;


define( 'BBP_M_EXT_BASENAME', plugin_basename( __FILE__ ) );
define( 'BBP_M_EXT_PATH', plugin_dir_path( __FILE__ ) );
define( 'BBP_M_EXT_INC', BBP_M_EXT_PATH . 'include/' );
define( 'BBP_M_EXT_VERSION', '0.0.6' );

function bbp_m_ext_is_request($type) {
	switch ( $type ) {
		case 'admin' :
			return is_admin();
		case 'frontend' :
			return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
	}
}

function bbp_m_ext_textdomain() {

    // Set filter for plugin's languages directory
    $lang_dir = dirname( BBP_M_EXT_BASENAME ) . '/languages/';
    $lang_dir = apply_filters( 'bbp_notices_languages', $lang_dir );

    // Traditional WordPress plugin locale filter
    $locale        = apply_filters( 'plugin_locale',  get_locale(), 'menu-extension-for-bbpress' );
    $mofile        = sprintf( '%1$s-%2$s.mo', 'menu-extension-for-bbpress', $locale );

    // Setup paths to current locale file
    $mofile_local  = $lang_dir . $mofile;
    $mofile_global = WP_LANG_DIR . '/menu-extension-for-bbpress/' . $mofile;

    if ( file_exists( $mofile_global ) ) {
        // Look in global /wp-content/languages/menu-extension-for-bbpress folder
        load_textdomain( 'menu-extension-for-bbpress', $mofile_global );
    } elseif ( file_exists( $mofile_local ) ) {
        // Look in local /wp-content/plugins/menu-extension-for-bbpress/languages/ folder
        load_textdomain( 'menu-extension-for-bbpress', $mofile_local );
    } else {
        // Load the default language files
        load_plugin_textdomain( 'menu-extension-for-bbpress', false, $lang_dir );
    }
}


function bbp_m_ext_start() {
    add_action( 'init', 'bbp_m_ext_textdomain' );
	if ( bbp_m_ext_is_request( 'admin' ) ) {
		include_once( BBP_M_EXT_INC . 'admin.php' );
	}
	if ( bbp_m_ext_is_request( 'frontend' ) ) {
		include_once( BBP_M_EXT_INC . 'frontend.php' );
	}

}

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'bbpress/bbpress.php' ) ) {

	add_action( 'plugins_loaded', 'bbp_m_ext_start' );
	
} else {
	add_action('admin_notices', 'bbp_m_ext_plugin_admin_notices');
}

function bbp_m_ext_plugin_admin_notices() {

	// Generate our error message
	$output = '<div id="message" class="error">';
	$output .= '<p>';
	$output .= sprintf( __( 'The "Menu Extension for bbPress" %1$sis inactive.%2$s The %3$sbbPress%4$s plugin must be active for the "Menu Extension for bbPress" to work. Please activate bbPress on the %5$splugin page%6$s once it is installed.', 'menu-extension-for-bbpress' ), '<strong>', '</strong>', '<a href="http://wordpress.org/extend/plugins/bbPress/" target="_blank">', '</a>', '<a href="' . esc_url( admin_url( 'plugins.php' ) ) . '">', '</a>' );
	$output .= '</p>';
	$output .= '</div>';
	echo $output; 
	   
	deactivate_plugins( BBP_M_EXT_BASENAME );
}
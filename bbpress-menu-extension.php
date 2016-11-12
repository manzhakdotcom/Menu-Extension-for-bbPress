<?php
/*
Plugin Name: bbPress Menu Extension
Plugin URI: http://www.manzhak.com/bbpress-menu-extension
Description: You can now add bbPress links in your WP menus.
Version: 0.0.2
Text Domain: bbpress-menu-extension
Author: Sergius Manzhak
Author URI: http://www.manzhak.com/

Text Domain: bbpress-menu-extension
Domain Path: /languages/
*/

define( 'BBP_M_EXT_VERSION', '0.0.2' );
define( 'BBP_M_EXT_BASENAME', plugin_basename( __FILE__ ) );
define( 'BBP_M_EXT_PATH', plugin_dir_path( __FILE__ ) );
define( 'BBP_M_EXT_INC', BBP_M_EXT_PATH . 'include/' );


function bbp_m_ext_is_request($type) {
	switch ( $type ) {
		case 'admin' :
			return is_admin();
		case 'frontend' :
			return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
	}
}


function bbp_m_ext_start() {

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
	$output .= sprintf( __( 'The %1$sbbPress Menu Extension is inactive.%2$s The %3$sbbPress%4$s plugin must be active for the bbPress Menu Extension to work. Please activate bbPress on the %5$splugin page%6$s once it is installed.', 'bbpress-menu-extension' ), '<strong>', '</strong>', '<a href="http://wordpress.org/extend/plugins/bbPress/" target="_blank">', '</a>', '<a href="' . esc_url( admin_url( 'plugins.php' ) ) . '">', '</a>' );
	$output .= '</p>';
	$output .= '</div>';
	echo $output; 
	   
	deactivate_plugins('bbpress-menu-extension/bbpress-menu-extension.php');
}
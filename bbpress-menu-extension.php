<?php
/*
Plugin Name: bbPress Menu Extension
Plugin URI: http://www.manzhak.com/bbpress-menu-extension
Description: You can now add bbPress links in your WP menus.
Version: 1.0.0
Text Domain: bbpress-menu-extension
Author: Manzhak
Author URI: http://www.manzhak.com/
*/

define( 'BBP_M_EXT_VERSION', '1.0.0' );
define('BBP_M_EXT_BASENAME', plugin_basename( __FILE__ ));
define('BBP_M_EXT_PATH', plugin_dir_path( __FILE__ ));


/**
 * @return boolean True if bbPress is active, otherwise false
 */
function bbp_m_ext_meets_requirements() {

	return class_exists( 'BBP_Component' ) ? true : false;

} /*bbp_m_ext_meets_requirements()*/

function bbp_m_ext_maybe_disable_plugin () {

	// Generate our error message
	$output = '<div id="message" class="error">';
	$output .= '<p>';
	$output .= sprintf( __( 'The %1$sbbPress Menu Extension is inactive.%2$s The %3$sbbPress%4$s plugin must be active for the bbPress Menu Extension to work. Please activate bbPress on the %5$splugin page%6$s once it is installed.', 'bbpress-menu-extension' ), '<strong>', '</strong>', '<a href="http://wordpress.org/extend/plugins/bbPress/" target="_blank">', '</a>', '<a href="' . esc_url( admin_url( 'plugins.php' ) ) . '">', '</a>' );
	$output .= '</p>';
	$output .= '</div>';
	echo $output;

	// Deactivate our plugin
	deactivate_plugins( BBP_M_EXT_BASENAME );

}/*bbp_m_ext_maybe_disable_plugin()*/


if ( bbp_m_ext_meets_requirements() ) {

	// Load translations
	load_plugin_textdomain( 'bbpress-menu-extension', false, dirname( BBP_M_EXT_BASENAME ) . '/languages' );

	add_action( 'plugins_loaded', create_function( '', '
			$filename  = "include/";
			$filename .= is_admin() ? "backend.inc.php" : "frontend.inc.php";
			if( file_exists( plugin_dir_path( __FILE__ ) . $filename ) )
				include( plugin_dir_path( __FILE__ ) . $filename );
	' 	)
	);
	
} else {
	add_action('admin_notices', 'bbp_m_ext_maybe_disable_plugin');
}

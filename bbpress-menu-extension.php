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

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

define('BBP_M_EXT_PATH', plugin_dir_path( __FILE__ ));

if ( is_plugin_active( 'bbpress/bbpress.php' ) ) {

	add_action( 'plugins_loaded', create_function( '', '
			$filename  = "include/";
			$filename .= is_admin() ? "backend.inc.php" : "frontend.inc.php";
			if( file_exists( plugin_dir_path( __FILE__ ) . $filename ) )
				include( plugin_dir_path( __FILE__ ) . $filename );
	' 	)
	);
	
} else {
	add_action('admin_notices', 'bbp_m_ext_plugin_admin_notices');
}

function bbp_m_ext_plugin_admin_notices() {

	   $msg = sprintf( __( 'Please install or activate : %s.', $_SERVER['SERVER_NAME'] ), '<a href=https://wordpress.org/plugins/bbpress style="color: #ffffff;text-decoration:none;font-style: italic;" target="_blank"/><strong>bbPress - forum by WordPress Team</strong></a>' );
	   
	   echo '<div id="message" class="error" style="background-color: #DD3D36;"><p style="font-size: 16px;color: #ffffff">' . $msg . '</p></div>';   
	   
	   deactivate_plugins('bbpress-menu-extension/bbpress-menu-extension.php');
}
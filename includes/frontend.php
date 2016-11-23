<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/* The main code, this replace the #keyword# by the correct links with nonce ect */
add_filter( 'wp_setup_nav_menu_item', 'bbp_m_ext_setup_nav_menu_item' );
function bbp_m_ext_setup_nav_menu_item( $item ) {
	global $pagenow;
	if( $pagenow!='nav-menus.php' && !defined('DOING_AJAX') && isset( $item->url ) && strstr( $item->url, '#bbp_m_ext_' ) != '' ) {
		$item_url = substr( $item->url, 0, strpos( $item->url, '#', 1 ) ) . '#';

		switch( $item_url ) {
			case '#bbp_m_ext_topics#'		 :	$item->url = is_user_logged_in() ? bbp_get_user_profile_url( get_current_user_id() ) . 'topics' : get_permalink( wc_get_page_id( 'myaccount' ) ); break;
			
			case '#bbp_m_ext_profile#'		 :	$item->url = is_user_logged_in() ? bbp_get_user_profile_url( get_current_user_id() ) : get_permalink( wc_get_page_id( 'myaccount' ) ); break;

		}
		$item->url = esc_url( $item->url );
	}
	return $item;
}




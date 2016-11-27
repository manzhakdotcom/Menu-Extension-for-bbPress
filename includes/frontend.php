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

			case '#bbp_m_ext_topics#'		 :	$item->url = is_user_logged_in() ? bbp_get_user_profile_url( get_current_user_id() ) . 'topics' : bbp_m_ext_get_root_url(); break; //get_permalink( wc_get_page_id( 'myaccount' ) )

			case '#bbp_m_ext_profile#'		 :	$item->url = is_user_logged_in() ? bbp_get_user_profile_url( get_current_user_id() ) : bbp_m_ext_get_root_url(); break;

		}
		$item->url = esc_url( $item->url );
	}
	return $item;
}

function bbp_m_ext_get_root_url() {
    // Page exists at root slug path, so use its permalink
    $page = bbp_get_page_by_path( bbp_get_root_slug() );
    if ( !empty( $page ) ) {
        $root_url = get_permalink( $page->ID );

        // Use the root slug
    } else {
        $root_url = get_post_type_archive_link( bbp_get_forum_post_type() );
    }

    return $root_url;
}




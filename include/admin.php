<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/* Add a metabox in admin menu page */
add_action('admin_head-nav-menus.php', 'bbp_m_ext_add_nav_menu_metabox');
function bbp_m_ext_add_nav_menu_metabox() {
	add_meta_box( 'bbp_m_ext', __( 'bbPress Links', 'menu-extension-for-bbpress' ), 'bbp_m_ext_nav_menu_metabox', 'nav-menus', 'side', 'default' );
}

/* The metabox code */
function bbp_m_ext_nav_menu_metabox()
{
	global $nav_menu_selected_id;

	$elems = array( '#bbp_m_ext_topics#' => __( 'My Topics', 'menu-extension-for-bbpress' ), '#bbp_m_ext_profile#' => __( 'My Profile', 'menu-extension-for-bbpress' )  );
	class bbp_m_ext_logItems {
		public $db_id = 0;
		public $object = 'bbp_m_ext_log';
		public $object_id;
		public $menu_item_parent = 0;
		public $type = 'custom';
		public $title;
		public $url;
		public $target = '';
		public $attr_title = '';
		public $classes = array();
		public $xfn = '';
	}

	$elems_obj = array();
	foreach ( $elems as $value => $title ) {
		$elems_obj[$title] = new bbp_m_ext_logItems();
		$elems_obj[$title]->object_id	= esc_attr( $value );
		$elems_obj[$title]->title		= esc_attr( $title );
		$elems_obj[$title]->url			= esc_attr( $value );
	}

	$walker = new Walker_Nav_Menu_Checklist( array() );
	?>
	<div id="bbpress-links" class="bbpresslinksdiv">

		<div id="tabs-panel-bbpress-links-all" class="tabs-panel tabs-panel-view-all tabs-panel-active">
			<ul id="bbpress-linkschecklist" class="list:bbpress-links categorychecklist form-no-clear">
				<?php echo walk_nav_menu_tree( array_map( 'wp_setup_nav_menu_item', $elems_obj ), 0, (object)array( 'walker' => $walker ) ); ?>
			</ul>
		</div>

		<p class="button-controls wp-clearfix">
			<span class="add-to-menu">
				<input type="submit"<?php disabled( $nav_menu_selected_id, 0 ); ?> class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e('Add to Menu', 'menu-extension-for-bbpress' ); ?>" name="add-bbpress-links-menu-item" id="submit-bbpress-links" />
				<span class="spinner"></span>
			</span>
		</p>

	</div>
	<?php
}

/* Modify the "type_label" */
add_filter( 'wp_setup_nav_menu_item', 'bbp_m_ext_nav_menu_type_label' );
function bbp_m_ext_nav_menu_type_label( $menu_item )
{
	$elems = array( '#bbp_m_ext_topics#', '#bbp_m_ext_profile#' );
	
	$menu_item_array = explode('#', $menu_item->url);
	$menu_item_url = '';
	if(!empty($menu_item_array[1]))
	{	
		$menu_item_url = '#'.$menu_item_array[1].'#';
	}
		
	if ( isset($menu_item->object, $menu_item->url) && $menu_item->object == 'custom' && in_array($menu_item_url, $elems) )
		$menu_item->type_label = ( 'bbPress Menu Ext' );

	return $menu_item;
}
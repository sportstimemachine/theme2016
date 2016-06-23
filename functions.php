<?php

add_theme_support( 'menus' );

register_nav_menus( array(
	'stark' => 'Stark Menu',
	'summit' => 'Summit Menu'
) );
	function custom_excerpt_length( $length ) {
		return 20;
	}
	add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
	
	function new_excerpt_more($more) {
		global $query_string;
		if ( array_key_exists('pagename', wp_parse_args($query_string) ) ){
			global $post;
			return '<div class="bl_read_more"><a href="'.get_permalink($post->ID).'">Read the rest of this article</a></div>';
		}
	}
	add_filter('excerpt_more', 'new_excerpt_more');
	
function mbpc_remove_menu_items() {
		global $menu;
		global $current_user;
	    get_currentuserinfo();
		$restricted = array(__('Posts'),__('Links'));
		
	    if($current_user->user_login == 'sportstimemachine')
	    {
	        $restricted[] = __('Comments');
	        $restricted[] =  __('Appearance');
	        $restricted[] = __('Plugins');
	        $restricted[] = __('Tools');
			$restricted[] = __('Settings');
		}
		
		end ($menu);
		while (prev($menu)){
			$value = explode(' ',$menu[key($menu)][0]);
			if(in_array($value[0] != NULL?$value[0]:"" , $restricted)) {
				unset($menu[key($menu)]);
			}
		}
	}
	
	add_action('admin_menu', 'mbpc_remove_menu_items');

//============================================================
// 	KEEPS NON ADMINS FROM CREATING ADMINS
//============================================================
class JPB_User_Caps {

  // Add our filters
  function JPB_User_Caps(){
    add_filter( 'editable_roles', array(&$this, 'editable_roles'));
    add_filter( 'map_meta_cap', array(&$this, 'map_meta_cap'),10,4);
  }

  // Remove 'Administrator' from the list of roles if the current user is not an admin
  function editable_roles( $roles ){
    if( isset( $roles['administrator'] ) && !current_user_can('administrator') ){
      unset( $roles['administrator']);
    }
    return $roles;
  }

  // If someone is trying to edit or delete and admin and that user isn't an admin, don't allow it
  function map_meta_cap( $caps, $cap, $user_id, $args ){

    switch( $cap ){
        case 'edit_user':
        case 'remove_user':
        case 'promote_user':
            if( isset($args[0]) && $args[0] == $user_id )
                break;
            elseif( !isset($args[0]) )
                $caps[] = 'do_not_allow';
            $other = new WP_User( absint($args[0]) );
            if( $other->has_cap( 'administrator' ) ){
                if(!current_user_can('administrator')){
                    $caps[] = 'do_not_allow';
                }
            }
            break;
        case 'delete_user':
        case 'delete_users':
            if( !isset($args[0]) )
                break;
            $other = new WP_User( absint($args[0]) );
            if( $other->has_cap( 'administrator' ) ){
                if(!current_user_can('administrator')){
                    $caps[] = 'do_not_allow';
                }
            }
            break;
        default:
            break;
    }
    return $caps;
  }

}

$jpb_user_caps = new JPB_User_Caps();


// Filter to fix the Post Author Dropdown
add_filter('wp_dropdown_users', 'theme_post_author_override');
function theme_post_author_override($output)
{
  global $post;
  // return if this isn't the theme author override dropdown
  if (!preg_match('/post_author_override/', $output)) return $output;

  // return if we've already replaced the list (end recursion)
  if (preg_match ('/post_author_override_replaced/', $output)) return $output;

  // replacement call to wp_dropdown_users
	$output = wp_dropdown_users(array(
	  'echo' => 0,
		'name' => 'post_author_override_replaced',
		'selected' => empty($post->ID) ? $user_ID : $post->post_author,
		'include_selected' => true,
		'exclude'=>'casselbear'
	));

	// put the original name back
	$output = preg_replace('/post_author_override_replaced/', 'post_author_override', $output);

  return $output;
}

add_filter('next_posts_link_attributes', 'my_next_posts_link_attributes');
add_filter('previous_posts_link_attributes', 'my_prev_posts_link_attributes');

function my_prev_posts_link_attributes(){
//	return 'class="prev_post"';
}

function my_next_posts_link_attributes(){
//	return 'class="next_post"';
}


//============================================================
// 	CUSTOM POST TYPES - STARK RADIO EPISODES
//============================================================
add_action( 'init', 'stark_radio', 0 );

function stark_radio() {
 
	$labels = array(
		'name' => _x('Stark Radio', 'post type general name'),
		'singular_name' => _x('Stark Radio', 'post type singular name'),
		'add_new' => _x('Add New', 'tips item'),
		'add_new_item' => __('Add New Radio Post'),
		'edit_item' => __('Edit Radio Post'),
		'new_item' => __('New Radio Post'),
		'view_item' => __('View Radio Post'),
		'search_items' => __('Search Radio Posts'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'menu_icon' => get_stylesheet_directory_uri() . '/images/microphone.png',
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 35,
		'supports' => array('title','editor','thumbnail', 'author'),
		'taxonomies' => array('category','post_tag')
	  ); 
 
	register_post_type( 'Stark_Radio' , $args );
        flush_rewrite_rules();
}


add_filter( 'manage_edit-stark_radio_columns', 'stark_radio_columns' ) ;


// 	CUSTOM POST TYPES - STARK RADIO COLUMNS
//============================================================
function stark_radio_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Episode Name' ),
		'author' => __( 'Author' ),
		'tags' => __( 'Tags' ),
		'date' => __( 'Date' )
	);

	return $columns;
}

//============================================================
// 	CUSTOM POST TYPES - STARK SPONSORS
//============================================================
add_action( 'init', 'stark_sponsors', 0 );

function stark_sponsors() {
 
	$labels = array(
		'name' => _x('Stark Sponsors', 'post type general name'),
		'singular_name' => _x('Stark Sponsors', 'post type singular name'),
		'add_new' => _x('Add New', 'tips item'),
		'add_new_item' => __('Add New Sponsors'),
		'edit_item' => __('Edit Sponsors'),
		'new_item' => __('New Sponsors'),
		'view_item' => __('View Sponsors'),
		'search_items' => __('Search Sponsors'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'menu_icon' => get_stylesheet_directory_uri() . '/images/money.png',
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 35,
		'supports' => array('title','editor','thumbnail', 'author'),
		'taxonomies' => array('category','post_tag')
	  ); 
 
	register_post_type( 'Stark_Sponsors' , $args );
        flush_rewrite_rules();
}

//============================================================
// 	CUSTOM POST TYPES - STARK UPCOMING RADIO EPISODES
//============================================================
add_action( 'init', 'stark_upcoming', 0 );

function stark_upcoming() {
 
	$labels = array(
		'name' => _x('Stark Upcoming', 'post type general name'),
		'singular_name' => _x('Stark Upcoming', 'post type singular name'),
		'add_new' => _x('Add New', 'tips item'),
		'add_new_item' => __('Add New Upcoming'),
		'edit_item' => __('Edit Upcoming'),
		'new_item' => __('New Upcoming'),
		'view_item' => __('View Upcoming'),
		'search_items' => __('Search Upcoming'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'menu_icon' => get_stylesheet_directory_uri() . '/images/calendar.png',
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 35,
		'supports' => array('title','editor'),
	  ); 
 
	register_post_type( 'Stark_Upcoming' , $args );
        flush_rewrite_rules();
}

//============================================================
// 	CUSTOM POST TYPES - SUMMIT RADIO EPISODES
//============================================================
add_action( 'init', 'summit_radio', 0 );

function summit_radio() {
 
	$labels = array(
		'name' => _x('Summit Radio', 'post type general name'),
		'singular_name' => _x('Summit Radio', 'post type singular name'),
		'add_new' => _x('Add New', 'tips item'),
		'add_new_item' => __('Add New Radio Post'),
		'edit_item' => __('Edit Radio Post'),
		'new_item' => __('New Radio Post'),
		'view_item' => __('View Radio Post'),
		'search_items' => __('Search Radio Posts'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'menu_icon' => get_stylesheet_directory_uri() . '/images/microphone.png',
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 35,
		'supports' => array('title','editor','thumbnail', 'author'),
		'taxonomies' => array('category','post_tag')
	  ); 
 
	register_post_type( 'Summit_Radio' , $args );
        flush_rewrite_rules();
}


add_filter( 'manage_edit-summit_radio_columns', 'summit_radio_columns' ) ;


// 	CUSTOM POST TYPES - SUMMIT RADIO COLUMNS
//============================================================
function summit_radio_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Episode Name' ),
		'author' => __( 'Author' ),
		'tags' => __( 'Tags' ),
		'date' => __( 'Date' )
	);

	return $columns;
}

//============================================================
// 	CUSTOM POST TYPES - SUMMIT SPONSORS
//============================================================
add_action( 'init', 'summit_sponsors', 0 );

function summit_sponsors() {
 
	$labels = array(
		'name' => _x('Summit Sponsors', 'post type general name'),
		'singular_name' => _x('Summit Sponsors', 'post type singular name'),
		'add_new' => _x('Add New', 'tips item'),
		'add_new_item' => __('Add New Sponsors'),
		'edit_item' => __('Edit Sponsors'),
		'new_item' => __('New Sponsors'),
		'view_item' => __('View Sponsors'),
		'search_items' => __('Search Sponsors'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'menu_icon' => get_stylesheet_directory_uri() . '/images/money.png',
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 35,
		'supports' => array('title','editor','thumbnail', 'author'),
	  ); 
 
	register_post_type( 'Summit_Sponsors' , $args );
        flush_rewrite_rules();
}

//============================================================
// 	CUSTOM POST TYPES - SUMMIT UPCOMING RADIO EPISODES
//============================================================
add_action( 'init', 'summit_upcoming', 0 );

function summit_upcoming() {
 
	$labels = array(
		'name' => _x('Summit Upcoming', 'post type general name'),
		'singular_name' => _x('Summit Upcoming', 'post type singular name'),
		'add_new' => _x('Add New', 'tips item'),
		'add_new_item' => __('Add New Upcoming'),
		'edit_item' => __('Edit Upcoming'),
		'new_item' => __('New Upcoming'),
		'view_item' => __('View Upcoming'),
		'search_items' => __('Search Upcoming'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'menu_icon' => get_stylesheet_directory_uri() . '/images/calendar.png',
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 35,
		'supports' => array('title','editor'),
	  ); 
 
	register_post_type( 'summit_Upcoming' , $args );
        flush_rewrite_rules();
}

	
?>

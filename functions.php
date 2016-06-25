<?php

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

define( 'THEME_ID', 'Sports_Time_Machine' );
define( 'THEME_VERSION', '1.0.1' );

add_action( 'init', 'sportstm_register_styles_scripts' );
function sportstm_register_styles_scripts() {

    // Parent Theme
    wp_register_style(
        THEME_ID . '-parent',
        get_template_directory_uri() . '/style.css',
        null,
        defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : THEME_VERSION
    );

    // Current (Child) Theme
    wp_register_style(
        THEME_ID,
        get_stylesheet_uri(),
        array( THEME_ID . '-parent' ),
        defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : THEME_VERSION
    );

    // jQuery Fancybox CSS
    wp_register_style(
        THEME_ID . '-fancybox-css',
        get_stylesheet_directory_uri() . '/js/jquery.fancybox/jquery.fancybox.css',
        null,
        defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : THEME_VERSION
    );

    // jQuery Fancybox JS
    wp_register_script(
        THEME_ID . '-fancybox-js',
        get_stylesheet_directory_uri() . '/js/jquery.fancybox/jquery.fancybox.js',
        array( 'jquery' ),
        defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : THEME_VERSION,
        true
    );

}

add_action( 'wp_enqueue_scripts', 'sportstm_enqueue_styles_scripts' );
function sportstm_enqueue_styles_scripts() {

    wp_enqueue_style( THEME_ID . '-parent' );
    wp_enqueue_style( THEME_ID );

    wp_enqueue_style( THEME_ID . '-fancybox-css' );
    wp_enqueue_script( THEME_ID . '-fancybox-js' );

}

add_action( 'wp_head', 'sportstm_radio_show_rss_feeds' );
function sportstm_radio_show_rss_feeds() { ?>

<link rel="alternate" type="application/rss+xml" title="Stark Posts" href="/feed/?post_type=stark_radio" />
<link rel="alternate" type="application/rss+xml" title="Summit Posts" href="/feed/?post_type=summit_radio" />

<?php
}

add_action( 'wp_footer', 'sportstm_google_analytics' );
function sportstm_google_analytics() { ?>

<script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-30047922-3']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

</script>

<?php   
}

add_action( 'after_setup_theme', 'sportstm_theme_support' );
function sportstm_theme_support() {

    add_theme_support( 'menus' );

    // Allow shortcodes in text widget
    add_filter( 'widget_text', 'do_shortcode' );

}

add_action( 'after_setup_theme', 'sportstm_nav_menus' );
function sportstm_nav_menus() {

    register_nav_menus( array(
        'stark' => 'Stark Menu',
        'summit' => 'Summit Menu'
    ) );

}

add_filter( 'excerpt_length', 'sportstm_custom_excerpt_length' );
function sportstm_custom_excerpt_length( $length ) {
    return 20;
}

add_filter( 'excerpt_more', 'sportstm_new_excerpt_more' );
function sportstm_new_excerpt_more( $more ) {
    
    global $query_string;
    
    if ( array_key_exists( 'pagename', wp_parse_args( $query_string ) ) ) {
        
        global $post;
        return '<div class="bl_read_more"><a href="' . get_permalink( $post->ID ) . '">Read the rest of this article</a></div>';
        
    }
    
}


//============================================================
// 	CUSTOM POST TYPES - STARK RADIO EPISODES
//============================================================
add_action( 'init', 'stark_radio' );

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
add_action( 'init', 'stark_sponsors' );

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

}

//============================================================
// 	CUSTOM POST TYPES - STARK UPCOMING RADIO EPISODES
//============================================================
add_action( 'init', 'stark_upcoming' );

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

}

//============================================================
// 	CUSTOM POST TYPES - SUMMIT RADIO EPISODES
//============================================================
add_action( 'init', 'summit_radio' );

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
add_action( 'init', 'summit_sponsors' );

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

}

//============================================================
// 	CUSTOM POST TYPES - SUMMIT UPCOMING RADIO EPISODES
//============================================================
add_action( 'init', 'summit_upcoming' );

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

}